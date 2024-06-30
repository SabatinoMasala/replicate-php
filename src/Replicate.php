<?php

namespace SabatinoMasala\Replicate;

use SabatinoMasala\Replicate\Resources\ModelResource;
use SabatinoMasala\Replicate\Resources\PredictionResource;
use SabatinoMasala\Replicate\Resources\TrainingResource;
use Saloon\Http\Connector;

class Replicate extends Connector
{
    public function __construct(protected string $apiKey)
    {
        $this->withTokenAuth($this->apiKey, 'Token');
    }

    public function predictions()
    {
        return new PredictionResource($this);
    }

    public function run($ref, $options, $progress = null)
    {
        $wait = $options['wait'] ?? null;
        $signal = $options['signal'] ?? null;
        $data = $options;
        unset($data['wait'], $data['signal']);

        $prediction = $this->predictions()->create($ref, $data);
        if ($prediction->clientError()) {
            throw new \Exception('Failed to create prediction: ' . json_encode($prediction->json()));
        }

        // Call progress callback with the initial prediction object
        if ($progress) {
            $progress($prediction);
        }

        $prediction = $this->wait($prediction, $wait ?? [], function($updatedPrediction) use ($progress, $signal) {
            // Call progress callback with the updated prediction object
            if ($progress) {
                $progress($updatedPrediction);
            }

            // We handle the cancel later in the function.
            if ($signal && $signal->aborted) {
                return true; // stop polling
            }

            return false; // continue polling
        });

        if ($signal && $signal->aborted) {
            $prediction = $this->predictions()->cancel($prediction->json('id'));
        }

        // Call progress callback with the completed prediction object
        if ($progress) {
            $progress($prediction);
        }

        if ($prediction->json('status') === 'failed') {
            throw new \Exception('Prediction failed: ' . $prediction->json('error'));
        }

        return $prediction->json('output');
    }

    public function models(string $owner, string $name)
    {
        return new ModelResource($this, $owner, $name);
    }

    public function trainings()
    {
        return new TrainingResource($this);
    }

    public function resolveBaseUrl(): string
    {
        return 'https://api.replicate.com/v1/';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    private function wait($prediction, $options, $stop = null) {
        $id = $prediction->json('id') ?? null;
        if (!$id) {
            throw new \Exception('Invalid prediction');
        }

        if (in_array($prediction->json('status'), ['succeeded', 'failed', 'canceled'])) {
            return $prediction;
        }

        $interval = $options['interval'] ?? 500;

        $sleep = function ($ms) {
            usleep($ms * 1000);
        };

        $updatedPrediction = $this->predictions()->get($id);

        while (!in_array($updatedPrediction->json('status'), ['succeeded', 'failed', 'canceled'])) {
            if ($stop && call_user_func($stop, $updatedPrediction) === true) {
                break;
            }

            $sleep($interval);
            $updatedPrediction = $this->predictions()->get($id);
        }

        if ($updatedPrediction->json('status') === 'failed') {
            throw new \Exception('Prediction failed: ' . $updatedPrediction->json('error'));
        }

        return $updatedPrediction;
    }

}

<?php

namespace SabatinoMasala\Replicate\Resources;

use SabatinoMasala\Replicate\ModelVersionIdentifier;
use SabatinoMasala\Replicate\Requests\CancelPredictionRequest;
use SabatinoMasala\Replicate\Requests\CreateModelPredictionRequest;
use SabatinoMasala\Replicate\Requests\CreatePredictionRequest;
use SabatinoMasala\Replicate\Requests\GetAllPredictionsRequest;
use SabatinoMasala\Replicate\Requests\GetPredictionRequest;

class PredictionResource extends Resource
{
    public function create(string $ref, array $data)
    {
        $input = isset($data['input']) ? $data['input'] : $data;
        $identifier = ModelVersionIdentifier::parse($ref);
        if (isset($identifier->version)) {
            $req = new CreatePredictionRequest;
            $req->body()->add('version', $identifier->version);
        } elseif (isset($identifier->owner) && isset($identifier->name)) {
            $req = new CreateModelPredictionRequest("{$identifier->owner}/{$identifier->name}");
        } else {
            throw new \Exception('Invalid model version identifier');
        }
        if (isset($data['webhook'])) {
            $req->body()->add('webhook', $data['webhook']);
            if (isset($data['webhook_events_filter'])) {
                $req->body()->add('webhook_events_filter', $data['webhook_events_filter']);
            }
        }
        $req->body()->add('input', $input);

        return $this->connector->send($req);
    }

    public function get(string $id)
    {
        return $this->connector->send(new GetPredictionRequest($id));
    }

    public function all()
    {
        return $this->connector->send(new GetAllPredictionsRequest);
    }

    public function cancel(string $id)
    {
        return $this->connector->send(new CancelPredictionRequest($id));
    }
}

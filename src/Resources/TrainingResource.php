<?php

namespace SabatinoMasala\Replicate\Resources;

use SabatinoMasala\Replicate\Requests\CancelTrainingRequest;
use SabatinoMasala\Replicate\Requests\CreateDreamboothTrainingRequest;
use SabatinoMasala\Replicate\Requests\GetAllTrainingsRequest;
use SabatinoMasala\Replicate\Requests\GetDreamboothRequest;
use SabatinoMasala\Replicate\Requests\GetTrainingRequest;

class TrainingResource extends Resource
{
    public function get(string $id)
    {
        return $this->connector->send(new GetTrainingRequest($id));
    }

    public function all()
    {
        return $this->connector->send(new GetAllTrainingsRequest);
    }

    public function cancel(string $id)
    {
        return $this->connector->send(new CancelTrainingRequest($id));
    }

    public function createDreambooth(string $model, string $trainerVersion, string $webhookCompleted, array $input)
    {
        $req = new CreateDreamboothTrainingRequest();
        $req->body()->add('model', $model);
        $req->body()->add('trainer_version', $trainerVersion);
        $req->body()->add('webhook_completed', $webhookCompleted);
        $req->body()->add('input', $input);

        return $this->connector->send($req);
    }

    public function getDreambooth(string $id)
    {
        return $this->connector->send(new GetDreamboothRequest($id));
    }
}

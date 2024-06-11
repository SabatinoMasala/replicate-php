<?php

namespace SabatinoMasala\Replicate\Resources;

use Saloon\Contracts\Connector;
use SabatinoMasala\Replicate\Requests\CreateTrainingRequest;
use SabatinoMasala\Replicate\Requests\GetAllModelVersionsRequest;
use SabatinoMasala\Replicate\Requests\GetModelRequest;
use SabatinoMasala\Replicate\Requests\GetModelVersionRequest;

class ModelResource extends Resource
{
    public string $owner;

    public string $name;

    public function __construct(Connector $connector, string $owner, string $name)
    {
        parent::__construct($connector);
        $this->owner = $owner;
        $this->name = $name;
    }

    public function get()
    {
        return $this->connector->send(new GetModelRequest($this->owner, $this->name));
    }

    public function allVersions()
    {
        return $this->connector->send(new GetAllModelVersionsRequest($this->owner, $this->name));
    }

    public function getVersion(string $version)
    {
        return $this->connector->send(new GetModelVersionRequest($this->owner, $this->name, $version));
    }

    public function createTraining(string $version, array $input, string $webhook)
    {
        $req = new CreateTrainingRequest($this->owner, $this->name, $version);
        $req->body()->add('input', $input);
        $req->body()->add('webhook', $webhook);

        return $this->connector->send($req);
    }
}

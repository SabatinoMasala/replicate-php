<?php

namespace SabatinoMasala\Replicate\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateTrainingRequest extends Request implements HasBody
{
    use HasJsonBody;

    public Method $method = Method::POST;

    public function __construct(
        protected string $owner,
        protected string $name,
        protected string $version,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/models/{$this->owner}/{$this->name}/versions/{$this->version}/trainings";
    }

    protected function defaultBody(): array
    {
        return [
            'destination' => "{$this->owner}/{$this->name}",
        ];
    }
}

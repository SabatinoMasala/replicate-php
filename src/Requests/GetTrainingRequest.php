<?php

namespace SabatinoMasala\Replicate\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetTrainingRequest extends Request
{
    public Method $method = Method::GET;

    public function __construct(
        protected string $id,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/trainings/{$this->id}";
    }
}

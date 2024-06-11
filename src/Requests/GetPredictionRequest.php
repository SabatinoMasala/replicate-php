<?php

namespace SabatinoMasala\Replicate\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetPredictionRequest extends Request
{
    public Method $method = Method::GET;

    public function __construct(
        protected string $id,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/predictions/{$this->id}";
    }
}

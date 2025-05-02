<?php

namespace SabatinoMasala\Replicate\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class CancelPredictionRequest extends Request
{
    public Method $method = Method::POST;
    
    public function __construct(
        protected string $id
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/predictions/{$this->id}/cancel";
    }
}

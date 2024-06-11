<?php

namespace SabatinoMasala\Replicate\Requests;

use Saloon\Http\Request;

class CancelPredictionRequest extends Request
{
    public function __construct(
        protected string $id
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/predictions/{$this->id}/cancel";
    }
}

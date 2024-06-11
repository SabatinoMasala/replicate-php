<?php

namespace SabatinoMasala\Replicate\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetAllPredictionsRequest extends Request
{
    public Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/predictions';
    }
}

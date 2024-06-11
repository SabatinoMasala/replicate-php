<?php

namespace SabatinoMasala\Replicate\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetDreamboothRequest extends Request
{
    public Method $method = Method::GET;

    public function __construct(
        protected string $id,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "https://dreambooth-api-experimental.replicate.com/v1/trainings/{$this->id}";
    }
}

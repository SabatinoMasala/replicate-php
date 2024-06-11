<?php

namespace SabatinoMasala\Replicate\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetModelRequest extends Request
{
    public Method $method = Method::GET;

    public function __construct(
        protected string $owner,
        protected string $name,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/models/{$this->owner}/{$this->name}";
    }
}

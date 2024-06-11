<?php

namespace SabatinoMasala\Replicate\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class CreateUploadRequest extends Request
{
    public Method $method = Method::POST;

    public function __construct(
        protected string $name,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "https://dreambooth-api-experimental.replicate.com/v1/upload/{$this->name}";
    }
}

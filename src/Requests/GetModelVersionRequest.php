<?php

namespace SabatinoMasala\Replicate\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetModelVersionRequest extends Request
{
    public Method $method = Method::GET;

    public function __construct(
        protected string $owner,
        protected string $name,
        protected string $version,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/models/{$this->owner}/{$this->name}/versions/{$this->version}";
    }
}

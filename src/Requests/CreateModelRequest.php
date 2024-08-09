<?php

namespace SabatinoMasala\Replicate\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateModelRequest extends Request implements HasBody
{
    use HasJsonBody;

    public function __construct(
        protected string $owner,
        protected string $name,
    ) {
    }

    protected Method $method = Method::POST;

    protected function defaultBody(): array
    {
        return [
            'owner' => $this->owner,
            'name' => $this->name,
        ];
    }

    public function resolveEndpoint(): string
    {
        return '/models';
    }
}

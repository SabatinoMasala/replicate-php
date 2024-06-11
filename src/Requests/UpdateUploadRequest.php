<?php

namespace SabatinoMasala\Replicate\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasMultipartBody;

class UpdateUploadRequest extends Request implements HasBody
{
    use HasMultipartBody;

    public Method $method = Method::PUT;

    public function __construct(protected string $url)
    {
    }

    public function resolveEndpoint(): string
    {
        return $this->url;
    }
}

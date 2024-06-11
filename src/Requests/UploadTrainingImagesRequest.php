<?php

namespace SabatinoMasala\Replicate\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasMultipartBody;

class UploadTrainingImagesRequest extends Request implements HasBody
{
    use HasMultipartBody;

    public Method $method = Method::PUT;

    public function __construct(
        protected string $uploadUrl,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return $this->uploadUrl;
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/zip',
        ];
    }
}

<?php

namespace SabatinoMasala\Replicate\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateModelPredictionRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(protected string $model)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/models/' . $this->model . '/predictions';
    }
}

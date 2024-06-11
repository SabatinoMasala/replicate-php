<?php

namespace SabatinoMasala\Replicate\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateDreamboothTrainingRequest extends Request implements HasBody
{
    use HasJsonBody;

    public Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return 'https://dreambooth-api-experimental.replicate.com/v1/trainings';
    }
}

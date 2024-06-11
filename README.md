# PHP client for the Replicate API

This is a PHP client for Replicate. It lets you run models from your PHP code and do various other things on Replicate.

## Credits

This package is based on the work of https://github.com/SabatinoMasala/replicate-php

## Installation

You can install the package via composer:

```bash
composer require sabatinomasala/replicate-php
```

## Creating a prediction

You can create a prediction as follows:

```php
// Create a prediction
$prediction = $client->predictions()->create('stability-ai/sdxl:7762fd07cf82c948538e41f63f77d685e02b063e37e496e96eefd46c929f9bdc', [
    'prompt' => 'a cat wearing a cowboy hat',
]);

$id = $prediction->json('id');

// Fetch prediction
$prediction = $client->predictions()->get($id);
dd($prediction->json())

```

## Running a model

You can run a model and wait on the output as follows:

```php
$token = env('REPLICATE_TOKEN');
$client = new SabatinoMasala\Replicate\Replicate($token);
$output = $client->run('stability-ai/sdxl:7762fd07cf82c948538e41f63f77d685e02b063e37e496e96eefd46c929f9bdc', [
    'prompt' => 'a cat wearing a cowboy hat',
], function($prediction) {
    // You can log the current state of the prediction
    \Log::info('Progress', $prediction->json());
});

dd($output[0]);
```

### Chaining multiple models

Because 'run' returns the output of the model, you can chain multiple models together like this:

```php
$output = $client->run('stability-ai/sdxl:7762fd07cf82c948538e41f63f77d685e02b063e37e496e96eefd46c929f9bdc', [
    'prompt' => 'a cat wearing a cowboy hat',
]);

$caption = $client->run('salesforce/blip:2e1dddc8621f72155f24cf2e0adbde548458d3cab9f00c0139eea840d0ac4746', [
    'task' => 'image_captioning',
    'image' => $output[0],
]);

dd($caption); // Caption: a drawing of a cat wearing a cowboy hat
```

## Credits
- Original creator of replicate-php: [sawirricardo](https://github.com/sawirricardo)
- [sabatinomasala](https://github.com/sabatinomasala)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

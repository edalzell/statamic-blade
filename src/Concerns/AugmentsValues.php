<?php

namespace Edalzell\Blade\Concerns;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use JsonSerializable;
use Statamic\Fields\Value;

trait AugmentsValues
{
    protected function getAugmentedValue($data)
    {
        if ($data instanceof Carbon) {
            return $data;
        }

        if ($data instanceof JsonSerializable || $data instanceof Collection) {
            return $this->getAugmentedValue($data->jsonSerialize());
        }

        if (is_array($data)) {
            return collect($data)
                    ->map(fn ($value) => $this->getAugmentedValue($value))
                    ->all();
        }

        if ($data instanceof Value) {
            return $data->value();
        }

        if (is_object($data) && method_exists($data, 'toAugmentedArray')) {
            return $this->getAugmentedValue($data->toAugmentedArray());
        }

        return $data;
    }
}

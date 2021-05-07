<?php

namespace Edalzell\Blade\Concerns;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use JsonSerializable;
use Statamic\Fields\Value;

trait AugmentsValues
{
    protected function getAugmentedValue($data, $level = 0)
    {
        if ($level > 2) {
            return $data;
        }

        $level++;

        if ($data instanceof Carbon) {
            return $data;
        }

        if ($data instanceof JsonSerializable || $data instanceof Collection) {
            return $this->getAugmentedValue($data->jsonSerialize(), $level);
        }

        if (is_array($data)) {
            return collect($data)
                    ->map(fn ($value) => $this->getAugmentedValue($value, $level))
                    ->all();
        }

        if ($data instanceof Value) {
            return $data->value();
        }

        if (is_object($data) && method_exists($data, 'toAugmentedArray')) {
            return $this->getAugmentedValue($data->toAugmentedArray(), $level);
        }

        return $data;
    }
}

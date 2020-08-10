<?php

namespace Edalzell\Blade\Directives;

use Statamic\Fields\Value;
use Statamic\Support\Arr;

class Bard
{
    public function handle(Value $data)
    {
        return collect($data->value())
            ->map(fn ($set) => $this->convertFromValueToArray($set))
            ->all();
    }

    private function convertFromValueToArray(array $set)
    {
        return [
            'type' => Arr::get($set, 'type'),
            'content' => $this->getFirstValueAsRaw($set),
        ];
    }

    private function getFirstValueAsRaw($set)
    {
        return Arr::first($set, fn ($value) => $value instanceof Value)->raw();
    }
}

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
            'content' => $this->getValuesAsRaw($set),
        ];
    }

    private function getValuesAsRaw($set)
    {
        $values = collect($set)->filter(fn ($value) => $value instanceof Value);
        if ($values->count() === 1) {
            return $values
                ->first()
                ->raw();
        }

        return $values
            ->mapWithKeys(fn ($value, $key) => [$key => $value->raw()])
            ->toArray();
    }
}

<?php

namespace Edalzell\Blade\Directives;

use Statamic\Fields\Value;

class Bard
{
    public function handle(Value $data)
    {
        $bar = collect($data->value())
            ->map(function ($set) {
                $plainSet = [];
                foreach ($set as $key => $value) {
                    if ($key == 'type') {
                        $plainSet[$key] = $value;
                    } elseif ($value instanceof Value) {
                        $plainSet['content'] = $value->raw();
                    }
                }

                return $plainSet;
            })->all();

        return $bar;
    }
}

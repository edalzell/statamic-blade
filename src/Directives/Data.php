<?php

namespace Edalzell\Blade\Directives;

use Edalzell\Blade\Concerns\IsDirective;
use Statamic\Fields\Value;
use Statamic\Stache\Query\Builder;

class Data
{
    use IsDirective;

    protected string $directive = 'data';
    protected string $key = 'data';
    protected string $type = 'array';
    protected string $method = 'handle';

    public function handle($data)
    {
        if ($data instanceof Builder) {
            return $this->getAugmentedValue($data->get());
        }

        if ($data instanceof Value) {
            return $this->getAugmentedValue($data->value());
        }

        return $this->getAugmentedValue($data);
    }
}

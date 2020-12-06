<?php

namespace Edalzell\Blade\Directives;

use Edalzell\Blade\Concerns\IsDirective;

class Data
{
    use IsDirective;

    public $directive = 'data';
    public $key = 'data';
    public $type = 'array';
    public $method = 'handle';

    public function handle($data)
    {
        return $this->getAugmentedValue($data->value());
    }
}

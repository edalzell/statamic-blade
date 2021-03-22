<?php

namespace Edalzell\Blade\Directives;

use Edalzell\Blade\Concerns\IsDirective;

class Collection
{
    use IsDirective;

    protected string $directive = 'collection';
    protected string $key = 'entry';
    protected string $type = 'loop';
    protected string $method = 'handle';

    public function handle(string $handle, array $params = [])
    {
        return $this->getAugmentedValue(
            tag(
                'collection',
                array_merge(['from' => $handle], $params)
            )
        );
    }
}

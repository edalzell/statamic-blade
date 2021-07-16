<?php

namespace Edalzell\Blade\Directives;

use Edalzell\Blade\Concerns\IsDirective;

class Taxonomy
{
    use IsDirective;

    protected string $directive = 'taxonomy';
    protected string $key = 'term';
    protected string $type = 'loop';
    protected string $method = 'handle';

    public function handle(string $handle, array $params = [])
    {
        $terms = tag(
            'taxonomy',
            array_merge(['from' => $handle], $params)
        );

        return $this->getAugmentedValue($terms);
    }
}

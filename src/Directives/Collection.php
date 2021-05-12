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
        $entries = tag(
            'collection',
            array_merge(['from' => $handle], $params)
        );

        if (collect($entries)->isEmpty()) {
            return [['no_results' => true]];
        }

        if (in_array('paginate', $params)) {
            return [$this->getAugmentedValue($entries)];
        }

        return $this->getAugmentedValue($entries);
    }
}

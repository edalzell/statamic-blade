<?php

namespace Edalzell\Blade\Directives;

use Edalzell\Blade\Concerns\IsDirective;
use Statamic\Facades\Entry as EntryAPI;

class Entry
{
    use IsDirective;

    protected string $directive = 'entry';
    protected string $key = 'entry';
    protected string $type = 'array';
    protected string $method = 'handle';

    public function handle(string $handle, $slug)
    {
        return $this->getAugmentedValue(EntryAPI::findBySlug($slug, $handle));
    }
}

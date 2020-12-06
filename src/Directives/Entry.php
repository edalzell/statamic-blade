<?php

namespace Edalzell\Blade\Directives;

use Edalzell\Blade\Concerns\IsDirective;
use Statamic\Facades\Entry as EntryAPI;

class Entry
{
    use IsDirective;

    public $directive = 'entry';
    public $key = 'entry';
    public $type = 'array';
    public $method = 'handle';

    public function handle(string $handle, $slug)
    {
        return $this->getAugmentedValue(EntryAPI::findBySlug($slug, $handle));
    }
}

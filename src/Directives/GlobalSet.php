<?php

namespace Edalzell\Blade\Directives;

use Edalzell\Blade\Concerns\IsDirective;
use Statamic\Facades\GlobalSet as GlobalSetAPI;

class GlobalSet
{
    use IsDirective;

    public $directive = 'globalset';
    public $key = 'globalset';
    public $type = 'both';
    public $method = 'handle';

    public function handleKey(string $handle, string $key = null)
    {
        return $this->globalSet($handle)->get($key);
    }

    public function handle(string $handle)
    {
        return $this->getAugmentedValue($this->globalSet($handle));
    }

    private function globalSet(string $handle)
    {
        return GlobalSetAPI::findByHandle($handle)->inCurrentSite();
    }
}

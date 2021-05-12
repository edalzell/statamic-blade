<?php

namespace Edalzell\Blade\Directives;

use Edalzell\Blade\Concerns\IsDirective;
use Statamic\Facades\Asset as AssetAPI;

class Asset
{
    use IsDirective;

    protected string $directive = 'asset';
    protected string $key = 'asset';
    protected string $type = 'array';
    protected string $method = 'handle';

    public function handle(string $url)
    {
        return $this->getAugmentedValue(AssetAPI::findByUrl($url));
    }
}

<?php

namespace Edalzell\Blade\Directives;

use Edalzell\Blade\Concerns\IsDirective;
use Statamic\Facades\Antlers;
use Statamic\Tags\Glide as GlideTag;

class Glide
{
    use IsDirective;

    public $directive = 'glide';
    public $key = 'glide';
    public $type = 'array';
    public $method = 'handle';

    public function handle(string $path, array $params = [])
    {
        $data = (new GlideTag)
            ->setParser(Antlers::parser())
            ->setContext([])
            ->setParameters($params)
            ->generate($path);

        return $data[0];
    }
}

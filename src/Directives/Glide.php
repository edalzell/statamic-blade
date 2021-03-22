<?php

namespace Edalzell\Blade\Directives;

use Edalzell\Blade\Concerns\IsDirective;
use Statamic\Facades\Antlers;
use Statamic\Tags\Glide as GlideTag;

class Glide
{
    use IsDirective;

    protected string $directive = 'glide';
    protected string $key = 'glide';
    protected string $type = 'array';
    protected string $method = 'handle';

    public function handle(string $path, array $params = [])
    {
        // this returns a string, not sure how to make it an array
        // return tag('glide', array_merge(['src'=>$path], $params));
        $data = (new GlideTag)
            ->setParser(Antlers::parser())
            ->setContext([])
            ->setParameters($params)
            ->generate($path);

        return $data[0];
    }
}

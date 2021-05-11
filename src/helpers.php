<?php

use Illuminate\Support\Str;
use Statamic\Modifiers\Modify;
use Statamic\Tags\Loader as TagLoader;
use Statamic\View\Antlers\Parser;

if (! function_exists('modify')) {
    /**
     * Specify a value to start the modification chain.
     *
     * @param mixed $value
     * @return \Statamic\Modifiers\Modify
     */
    function modify($value): Modify
    {
        return Modify::value($value);
    }
}

if (! function_exists('tag')) {
    /**
     * Tags are Antlers expressions giving you the ability to fetch, filter, and display content, enhance and simplify your markup, build forms, and build dynamic functionality.
     *
     * @param string $name
     * @param array $params
     * @param array $context
     * @return mixed
     */
    function tag(string $name, array $params = [], array $context = [])
    {
        if ($pos = strpos($name, ':')) {
            $original_method = substr($name, $pos + 1);
            $method = Str::camel($original_method);
            $name = substr($name, 0, $pos);
        } else {
            $method = $original_method = 'index';
        }

        $tag = app(TagLoader::class)->load($name, [
            'parser'     => app(Parser::class),
            'params'     => $params,
            'content'    => '',
            'context'    => $context,
            'tag'        => $name.':'.$original_method,
            'tag_method' => $original_method,
        ]);

        return $tag->$method();
    }
}

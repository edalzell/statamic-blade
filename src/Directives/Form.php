<?php

namespace Edalzell\Blade\Directives;

use Edalzell\Blade\Concerns\IsDirective;
use Statamic\Support\Arr;

class Form
{
    use IsDirective;

    protected string $directive = 'form';
    protected string $key = 'form';
    protected string $type = 'form';
    protected string $method = 'handle';

    public function handle(string $handle, array $params)
    {
        $keys = ['redirect', 'error_redirect', 'allow_request_redirect'];

        $tag = '<form method="POST" action="'.
               route('statamic.forms.submit', $handle).
               '"'.
               $this->makeAttributes(Arr::except($params, $keys)).
               '>';

        return $tag.$this->makeFields(Arr::only($params, $keys));
    }

    private function makeAttributes(array $attributes = []): string
    {
        return trim(collect($attributes)
            ->map(fn ($value, $key) => $key.'="'.$value.'" ')
            ->reduce(fn (?string $html, string $input) => $html.$input));
    }

    private function makeFields(array $params = []): string
    {
        $fieldMap = [
            'redirect' => '_redirect',
            'error_redirect' => '_error_redirect',
            'allow_request_redirect' => 'allow_request_redirect',
        ];

        return trim(collect($params)
            ->filter()
            ->map(fn ($value, $key) => '<input type="hidden" name="'.$fieldMap[$key].'" value="'.$value.'">')
            ->reduce(fn (?string $html, string $input) => $html.$input, csrf_field()));
    }
}

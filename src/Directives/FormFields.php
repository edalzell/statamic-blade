<?php

namespace Edalzell\Blade\Directives;

use Edalzell\Blade\Concerns\IsDirective;
use Statamic\Facades\Form as FormAPI;

class FormFields
{
    use IsDirective;

    protected string $directive = 'formfields';
    protected string $key = 'field';
    protected string $type = 'loop';
    protected string $method = 'handle';

    public function handle(string $handle)
    {
        $form = $this->getAugmentedValue(FormAPI::find($handle));

        return $form['fields'];
    }
}

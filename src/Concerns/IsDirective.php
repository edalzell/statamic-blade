<?php

namespace Edalzell\Blade\Concerns;

use Illuminate\Support\Facades\Blade;
use Statamic\Support\Str;

trait IsDirective
{
    use AugmentsValues;

    public function boot()
    {
        $booter = [
            'array' => 'bootArray',
            'both' => 'bootBoth',
            'form' => 'bootForm',
            'loop' => 'bootLoop',
        ];

        $this->{$booter[$this->type]}();
    }

    public function bootArray()
    {
        Blade::directive(
                $this->directive,
                fn ($expression) => $this->asArray($this->key, get_class($this), $this->method, $expression)
            );

        Blade::directive(
                "end{$this->directive}",
                fn () => $this->endAsArray($this->key)
            );
    }

    public function bootBoth()
    {
        Blade::directive(
                $this->directive,
                function ($expression) {
                    if (Str::contains($expression, ',')) {
                        return $this->asString(get_class($this), "{$this->method}Key", $expression);
                    }

                    return $this->asArray($this->key, get_class($this), $this->method, $expression);
                }
            );

        Blade::directive(
                "end{$this->directive}",
                fn () => $this->endAsArray($this->key)
            );
    }

    public function bootForm()
    {
        Blade::directive(
                $this->directive,
                fn ($expression) => $this->asForm(get_class($this), $this->method, $expression, $this->key)
            );

        Blade::directive("end{$this->directive}", fn () => $this->endAsForm());
    }

    public function bootLoop()
    {
        Blade::directive(
                $this->directive,
                fn ($expression) => $this->asLoop(get_class($this), $this->method, $expression, $this->key)
            );

        Blade::directive("end{$this->directive}", fn () => $this->endAsLoop());
    }

    private function asArray($key, $class, $method, $params = null)
    {
        return $this->php("extract($${key} = Facades\\${class}::${method}(${params}));");
    }

    private function asForm($class, $method, $params, $as)
    {
        return $this->php("echo Facades\\${class}::${method}(${params})");
    }

    private function asLoop($class, $method, $params, $as)
    {
        return $this->php("foreach(Facades\\${class}::${method}(${params}) as $${as}) {");
    }

    private function asString($class, $method, $params)
    {
        return $this->php("echo Facades\\${class}::${method}(${params});");
    }

    private function endAsArray($variable)
    {
        return
                '<?php
                    foreach($'.$variable.' as $key => $value) {
                        unset($key);
                    }
                    unset($'.$variable.');
                    extract($__data ?? []);
                ?>';
    }

    private function endAsForm()
    {
        return '</form>';
    }

    private function endAsLoop()
    {
        return $this->php('}');
    }

    private function php($php)
    {
        return "<?php {$php} ?>";
    }
}

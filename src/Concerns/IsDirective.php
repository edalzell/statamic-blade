<?php

namespace Edalzell\Blade\Concerns;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use JsonSerializable;
use Statamic\Fields\Value;
use Statamic\Support\Str;

trait IsDirective
{
    public function boot()
    {
        $booter = [
                'loop' => 'bootLoop',
                'array' => 'bootArray',
                'both' => 'bootBoth',
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

    public function bootLoop()
    {
        Blade::directive(
                $this->directive,
                fn ($expression) => $this->asLoop(get_class($this), $this->method, $expression, $this->key)
            );

        Blade::directive("end{$this->directive}", fn () => $this->endAsLoop());
    }

    protected function getAugmentedValue($data)
    {
        if (is_null($data)) {
            return;
        }

        if ($data instanceof Carbon) {
            return $data;
        }

        if ($data instanceof JsonSerializable || $data instanceof Collection) {
            return $this->getAugmentedValue($data->jsonSerialize());
        }

        if (is_array($data)) {
            return collect($data)
                    ->map(fn ($value) => $this->getAugmentedValue($value))
                    ->all();
        }

        if ($data instanceof Value) {
            return $data->value();
        }

        if (is_object($data) && method_exists($data, 'toAugmentedArray')) {
            return $this->getAugmentedValue($data->toAugmentedArray());
        }

        return $data;
    }

    private function asArray($key, $class, $method, $params = null)
    {
        return $this->php("extract($${key} = Facades\\${class}::${method}(${params}));");
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
                ?>';
    }

    private function asLoop($class, $method, $params, $as)
    {
        return $this->php("foreach(Facades\\${class}::${method}(${params}) as $${as}) {");
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

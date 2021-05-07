<?php

namespace Edalzell\Blade\Augmentation;

use Illuminate\View\Factory;

class AugmentationViewFactory extends Factory
{
    protected function viewInstance($view, $path, $data)
    {
        return new AugmentedView($this, $this->getEngineFromPath($path), $view, $path, $data);
    }
}

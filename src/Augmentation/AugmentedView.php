<?php

namespace Edalzell\Blade\Augmentation;

use Edalzell\Blade\Concerns\AugmentsValues;
use Illuminate\View\View;

class AugmentedView extends View
{
    use AugmentsValues;

    public function gatherData(): array
    {
        $variables = parent::gatherData();

        return array_map(function ($data) {
            return $this->getAugmentedValue($data);
        }, $variables);
    }
}

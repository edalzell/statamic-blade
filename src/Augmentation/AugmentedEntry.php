<?php

namespace Edalzell\Blade\Augmentation;

use Edalzell\Blade\Concerns\AugmentsValues;

class AugmentedEntry
{
    use AugmentsValues;

    public function gatherEntryData($entry): array
    {
        return array_map(function ($data) {
            return $this->getAugmentedValue($data);
        }, $entry->toAugmentedArray());
    }
}

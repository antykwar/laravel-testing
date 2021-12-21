<?php

namespace App\Directives;

use App\Models\RussianCache;

class BladeDirective
{
    public function __construct(protected RussianCache $cache) {}

    public function setUp($key)
    {
        $this
            ->cache
            ->has($this->normalizeKey($key));
    }

    protected function normalizeKey($item)
    {
        if (is_object($item) && method_exists($item, 'getCacheKey')) {
            return $item->getCacheKey();
        }

        if (is_array($item)) {
            return md5(implode('', $item));
        }

        return $item;
    }
}

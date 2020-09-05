<?php

namespace Hsy\Categorize\Traits;

use Hsy\Categorize\Models\Category;

trait CategorizeCache
{
    private function cacheKey($key, $node, $withSelf)
    {
        $parameters = [
            $key,
            ($node instanceof Category) ? $node->id : $node,
            $withSelf ? "1" : "0"
        ];
        return implode("_", $parameters);
    }

    private function remember($key, $value)
    {
        cache()->tags(["categorize"])->put($key, $value, config("categorize.cache_time", now()->addDays(30)));
    }

    public function flushCache()
    {
        cache()->tags(["categorize"])->flush();
    }
}

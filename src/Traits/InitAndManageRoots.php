<?php

namespace Hsy\Categorize\Traits;

use Hsy\Categorize\Models\Category;

trait InitAndManageRoots
{
    use CategorizeCache;

    public function syncRoots()
    {
        $this->createRoots();
        $this->removeUndefinedRoots();
    }

    public function createRoots()
    {
        $rootsInConfig = config("categories.roots");
        $catModel = config("categories.model");
        foreach ($rootsInConfig as $rootName => $rootTitle) {
            $catModel::firstOrCreate(["name" => $rootName], ["title" => $rootTitle]);
        }
        return true;
    }

    public function removeUndefinedRoots()
    {
        $catModel = config("categories.model");
        $roots = $catModel::all();
        foreach ($roots as $root) {
            if (!config()->has("categories.roots." . $root->name))
                $root->delete();
        }
        return true;
    }

}

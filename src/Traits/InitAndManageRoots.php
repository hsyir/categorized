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
        $rootsInConfig = config("categorize.roots");
        $catModel = config("categorize.model");
        foreach ($rootsInConfig as $rootName => $rootTitle) {
            $catModel::firstOrCreate(["name" => $rootName], ["title" => $rootTitle]);
        }
        return true;
    }

    public function removeUndefinedRoots()
    {
        $catModel = config("categorize.model");
        $roots = $catModel::all();
        foreach ($roots as $root) {
            if (!config()->has("categorize.roots." . $root->name))
                $root->delete();
        }
        return true;
    }

}

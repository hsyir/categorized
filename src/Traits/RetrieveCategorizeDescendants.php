<?php

namespace Hsy\Categorize\Traits;




trait  RetrieveCategorizeDescendants
{
    public function getTreeArray($node, $withSelf = false)
    {
        return $this->abs(
            $node,
            $withSelf,
            $this->cacheKey("Categories_tree_array", $node, $withSelf),
            function ($descendants) {
                return $descendants->toTree()->toArray();
            }
        );
    }
    public function getTree($node, $withSelf = false)
    {
        return $this->abs(
            $node,
            $withSelf,
            $this->cacheKey("Categories_tree", $node, $withSelf),
            function ($descendants) {
                return $descendants->toTree();
            }
        );
    }

    public function getDescendantsIds($node, $withSelf = true)
    {
        return $this->abs(
            $node,
            $withSelf,
            $this->cacheKey("categories_descendants_ids", $node, $withSelf),
            function ($descendants) {
                return $descendants->pluck("id")->toArray();
            }
        );
    }

    private function abs($node, $withSelf, $cacheKey, $call)
    {
        if (cache()->tags(["categories"])->has($cacheKey))
            return cache()->tags(["categories"])->get($cacheKey);

        $descendants = $this->getDescendants($node, $withSelf);
        $nodes = $call($descendants);
        $this->remember($cacheKey, $nodes);
        return $nodes;
    }

    public function getDescendants($node, $withSelf = false)
    {
        $model = config('categories.model');

        if (is_string($node))
            $node = $model::whereName($node)->first();
        else if (is_int($node))
            $node = $model::find($node);


        $nodes =
            $withSelf
                ? $model::descendantsAndSelf($node)
                : $model::descendantsOf($node);

        return $nodes;
    }

    public function getFlatTreeView($node, $withSelf = false, $prefix = '')
    {
        $categoryTree = $this->getTree($node, $withSelf);
        if ($categoryTree == []) return [];
        $traverse = function ($categoryTree, $depth = 0) use (&$traverse) {
            $menu = [];
            foreach ($categoryTree as $mn) {
                $menu[] = ['id' => $mn->id, 'title' => $mn->title, "depth" => $depth];
                if ($mn->children) {
                    $child_cats = $traverse($mn->children, $depth + 1);
                    if (is_array($child_cats))
                        $menu = array_merge($menu, $child_cats);
                }
            }
            return $menu;
        };

        return $traverse($categoryTree);
    }

    public function getRootOfNode($node, $withSelf = true)
    {
        $model = config('categories.model');
        $ancestors = $withSelf ? $model::whereAncestorOrSelf($node) : $model::whereAncestorOf($node);
        return $ancestors->withDepth()->having('depth', '=', 0)->first();
    }
}

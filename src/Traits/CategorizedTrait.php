<?php
/**
 * Created by PhpStorm.
 * User: Hsy
 * Date: 30/Jan/2020
 * Time: 11:55 AM
 */

namespace Hsy\Categorize\Traits;


use Hsy\Categorize\CategoryManager;

trait CategorizedTrait
{
    public function category()
    {
        return $this->belongsTo(config('categorize.model'));
    }

    public function scopeInCategoryTree($query, $category_id)
    {
        $catManager = new CategoryManager();
        $categorises=$catManager->getDescendantsIds($category_id);
//        $categoryModel = config('categories.model');
//        $categorize = $categoryModel::descendantsAndSelf($category_id)->pluck('id');
        return $query->whereIn('category_id', $categorises);
    }
}
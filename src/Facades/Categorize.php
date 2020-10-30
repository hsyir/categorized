<?php
namespace Hsy\Categorize\Facades;

use Hsy\Categorize\CategoryManager;
use Illuminate\Support\Facades\Facade;

class Categorize extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "Categorize";
    }
}

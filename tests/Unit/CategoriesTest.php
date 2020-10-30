<?php

namespace Tests\Feature\Packages;


use Hsy\Categorize\Facades\Categorize;
use Hsy\Categorize\Models\Category;
use Hsy\Categorize\Tests\TestCase;

class CategoriesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreate()
    {
        Categorize::syncRoots();
        $ids = Categorize::getDescendantsIds(0);
        dd($ids);
        $this->assertTrue(true);
    }
}

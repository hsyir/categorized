<?php

use Hsy\Categorize\Models\Category;

$factory->define(Category::class, function (Faker\Generator $faker) {
    return [
        'name'        => $faker->word,
        'title'        => $faker->word,
        'parent_id' => 0,
    ];
});

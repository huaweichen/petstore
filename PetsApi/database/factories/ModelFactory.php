<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/**
 * Define pet.
 */

use Illuminate\Support\Arr;

$factory->define(App\Models\Pet::class, function (Faker\Generator $faker) {
    return [
        'category_id' => $faker->numberBetween(1, 4),
        'name' => $faker->name,
        'photoUrls' => json_encode(Arr::random([$faker->url, $faker->url, $faker->url, $faker->url], rand(1, 4)), JSON_UNESCAPED_SLASHES),
        'status' => $faker->randomElement(['available', 'pending', 'sold']),
    ];
});

/**
 * Define category.
 */
$factory->define(App\Models\Category::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word(),
    ];
});

/**
 * Define tag.
 */
$factory->define(App\Models\Tag::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word(),
    ];
});


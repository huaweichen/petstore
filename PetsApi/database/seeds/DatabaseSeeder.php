<?php

use App\Models\Category;
use App\Models\Pet;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Category::class, 4)->create();
        factory(Pet::class, 20)->create();
        factory(Tag::class, 10)->create();

        $tags = App\Models\Tag::all();
        App\Models\Pet::all()->each(function ($pet) use ($tags) {
            $pet->tags()->attach(
                $tags->random(rand(1, 10))->pluck('id')->toArray()
            );
        });
    }
}

<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productos = Product::factory(50)->create();
        foreach ($productos as $item) {
            $item->tags()->attach(self::devolverTags());
        }
    }

    private static function devolverTags(): array
    {
        $tags = [];
        $ids = Tag::pluck('id')->toArray();
        $indices = array_rand($ids, random_int(2, count($ids)));
        foreach ($indices as $indice) {
            $tags[] = $ids[$indice];
        }
        return $tags;
    }
}

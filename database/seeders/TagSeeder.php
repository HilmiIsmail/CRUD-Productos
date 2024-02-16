<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'infantil' => '#98ABEE',
            'multimedia' => '#FDBF60',
            'digital' => '#836FFF',
            'mecanico' => '#F28585',
            'hardware' => '#EFF396',
            'deporte' => '#99BC85',
        ];

        foreach ($tags as $nombre => $color) {
            Tag::create(compact('nombre', 'color'));
        }
    }
}

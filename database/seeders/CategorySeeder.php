<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Hardstyle',
                'slug' => 'hardstyle',
                'description' => 'De hardste en snelste beats in de elektronische muziek scene',
                'icon' => '🎧',
            ],
            [
                'name' => 'Hardcore',
                'slug' => 'hardcore',
                'description' => 'Extreme beats voor de echte hardcore fans',
                'icon' => '💀',
            ],
            [
                'name' => 'Raw Hardstyle',
                'slug' => 'raw-hardstyle',
                'description' => 'Ruige en agressieve variant van hardstyle',
                'icon' => '⚡',
            ],
            [
                'name' => 'Euphoric Hardstyle',
                'slug' => 'euphoric-hardstyle',
                'description' => 'Melodische en uplifting hardstyle tracks',
                'icon' => '✨',
            ],
            [
                'name' => 'Classics',
                'slug' => 'classics',
                'description' => 'De legendarische tracks van vroeger',
                'icon' => '🎵',
            ],
            [
                'name' => 'Festival',
                'slug' => 'festival',
                'description' => 'Meerdaagse festivals met camping',
                'icon' => '🎪',
            ],
            [
                'name' => 'Indoor',
                'slug' => 'indoor',
                'description' => 'Evenementen in grote hallen en domes',
                'icon' => '🏟️',
            ],
            [
                'name' => 'Outdoor',
                'slug' => 'outdoor',
                'description' => 'Buitenevenementen met grote stages',
                'icon' => '🌳',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

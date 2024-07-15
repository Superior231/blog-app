<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['title' => 'Animation'],
            ['title' => 'Anime'],
            ['title' => 'Arts'],
            ['title' => 'Automotive'],
            ['title' => 'Books'],
            ['title' => 'Business'],
            ['title' => 'Career'],
            ['title' => 'Computers'],
            ['title' => 'Creativity'],
            ['title' => 'Culture'],
            ['title' => 'Desktop'],
            ['title' => 'Developer'],
            ['title' => 'Eduaction'],
            ['title' => 'Entertainment'],
            ['title' => 'Fashion'],
            ['title' => 'Film'],
            ['title' => 'Finance'],
            ['title' => 'Fitness'],
            ['title' => 'Food'],
            ['title' => 'Health'],
            ['title' => 'History'],
            ['title' => 'Hobbies'],
            ['title' => 'IT'],
            ['title' => 'Laptop'],
            ['title' => 'Lifestyle'],
            ['title' => 'Literature'],
            ['title' => 'Mobile'],
            ['title' => 'Mobile Developer'],
            ['title' => 'Motivation'],
            ['title' => 'Movie'],
            ['title' => 'Music'],
            ['title' => 'Pets'],
            ['title' => 'Politics'],
            ['title' => 'Relationships'],
            ['title' => 'Science'],
            ['title' => 'Smartphone'],
            ['title' => 'Sports'],
            ['title' => 'Style'],
            ['title' => 'Technology'],
            ['title' => 'Tips & Tricks'],
            ['title' => 'Travel'],
            ['title' => 'Web'],
            ['title' => 'Web Developer'],
            ['title' => 'Website'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}


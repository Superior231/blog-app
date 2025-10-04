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
            ['title' => 'AI'],
            ['title' => 'Animation'],
            ['title' => 'Anime'],
            ['title' => 'Arts'],
            ['title' => 'Artificial Intelligence'],
            ['title' => 'Automotive'],
            ['title' => 'Books'],
            ['title' => 'Bootstrap'],
            ['title' => 'Business'],
            ['title' => 'Career'],
            ['title' => 'Computers'],
            ['title' => 'Creativity'],
            ['title' => 'CSS'],
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
            ['title' => 'Hobbies'],
            ['title' => 'History'],
            ['title' => 'HTML'],
            ['title' => 'IT'],
            ['title' => 'Javascript'],
            ['title' => 'JS'],
            ['title' => 'Laptop'],
            ['title' => 'Laravel'],
            ['title' => 'Lifestyle'],
            ['title' => 'Literature'],
            ['title' => 'Machine Learning'],
            ['title' => 'Management'],
            ['title' => 'Mobile'],
            ['title' => 'Mobile Developer'],
            ['title' => 'Motivation'],
            ['title' => 'Movie'],
            ['title' => 'Music'],
            ['title' => 'MySQL'],
            ['title' => 'NoSQL'],
            ['title' => 'Pets'],
            ['title' => 'PHP'],
            ['title' => 'Politics'],
            ['title' => 'Python'],
            ['title' => 'Relationships'],
            ['title' => 'Science'],
            ['title' => 'Smartphone'],
            ['title' => 'Sports'],
            ['title' => 'SQL'],
            ['title' => 'Streaming'],
            ['title' => 'Style'],
            ['title' => 'Technology'],
            ['title' => 'Tips & Tricks'],
            ['title' => 'Travel'],
            ['title' => 'Tutorial'],
            ['title' => 'Web'],
            ['title' => 'Web Developer'],
            ['title' => 'Website'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}


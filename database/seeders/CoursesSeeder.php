<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesSeeder extends Seeder
{

    public function run(): void
    {
        $courseDetail = [
            [
                "title"=> "Learn Spanish in 30 Days",
                "description"=> "This course is designed to help you learn Spanish in just 30 days. It covers all the basics and provides you with the tools you need to start speaking Spanish confidently.",
                "short_description"=> "Learn Spanish in 30 days with our comprehensive course. Perfect for beginners!",
                "language_level"=> "beginner",
                "language"=> "spanish",
                "instructor"=> "Vinay Kumar",
                "duration"=> "5",
                "price"=> 0.00,
                "created_at"=> now(),
                "updated_at"=> now(),
            ],
            [
                "title"=> "Learn French in 30 Days",
                "description"=> "This course is designed to help you learn French in just 30 days. It covers all the basics and provides you with the tools you need to start speaking French confidently.",
                "short_description"=> "Learn French in 30 days with our comprehensive course. Perfect for beginners!",
                "language_level"=> "beginner",
                "language"=> "french",
                "instructor"=> "Shiv Kumar",
                "duration"=> "4",
                "price"=> 1200.00,
                "created_at"=> now(),
                "updated_at"=> now(),
            ],
            [
                "title"=> "Learn German in 30 Days",
                "description"=> "This course is designed to help you learn German in just 30 days. It covers all the basics and provides you with the tools you need to start speaking German confidently.",
                "short_description"=> "Learn German in 30 days with our comprehensive course. Perfect for beginners!",
                "language_level"=> "beginner",
                "language"=> "german",
                "instructor"=> "Hari Kumar",
                "duration"=> "5",
                "price"=> 1800.00,
                "created_at"=> now(),
                "updated_at"=> now(),
            ],
            [
                "title"=> "Learn English in 30 Days",
                "description"=> "This course is designed to help you learn English in just 30 days. It covers all the basics and provides you with the tools you need to start speaking English confidently.",
                "short_description"=> "Learn English in 30 days with our comprehensive course. Perfect for beginners!",
                "language_level"=> "beginner",
                "language"=> "english",
                "instructor"=> "Shiv Kumar",
                "duration"=> "4",
                "price"=> 1799.00,
                "created_at"=> now(),
                "updated_at"=> now(),
            ],
            [
                "title"=> "Learn Hindi in 30 Days",
                "description"=> "This course is designed to help you learn Hindi in just 30 days. It covers all the basics and provides you with the tools you need to start speaking Hindi confidently.",
                "short_description"=> "Learn Hindi in 30 days with our comprehensive course. Perfect for beginners!",
                "language_level"=> "beginner",
                "language"=> "hindi",
                "instructor"=> "Krishna Kumar",
                "duration"=> "3",
                "price"=> 1999.00,
                "created_at"=> now(),
                "updated_at"=> now(),
            ],
        ];

        foreach ($courseDetail as $course) {
            DB::table('courses')->insert($course);
        }
    }
}

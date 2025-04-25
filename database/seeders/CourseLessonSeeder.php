<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseLessonSeeder extends Seeder
{
    public function run(): void
    {
        $lessonData = [
            [
                'course_section_id' => 1, 
                'title' => 'Introduction to Spanish',
                'content' => 'Welcome to your first Spanish lesson. In this lesson, we will learn basic greetings and introductions.',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_section_id' => 1,
                'title' => 'Basic Greetings',
                'content' => 'Learn how to say hello, goodbye, and other common greetings in Spanish.',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_section_id' => 2,
                'title' => 'Numbers and Counting',
                'content' => 'Learn how to count from 1 to 100 in Spanish.',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_section_id' => 3,
                'title' => 'Verb Conjugation',
                'content' => 'Introduction to verb conjugation in Spanish.',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            [
                'course_section_id' => 4, 
                'title' => 'Introduction to French',
                'content' => 'Welcome to your first French lesson. In this lesson, we will learn basic greetings and introductions.',
                'media_path' => 'lessons/french/intro.mp4',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_section_id' => 5, 
                'title' => 'Numbers and Counting',
                'content' => 'Learn how to count from 1 to 100 in French.',
                'media_path' => 'lessons/french/numbers.mp4',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_section_id' => 7, 
                'title' => 'Introduction to German',
                'content' => 'Welcome to your first German lesson. In this lesson, we will learn basic greetings and introductions.',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_section_id' => 8, 
                'title' => 'Numbers and Counting',
                'content' => 'Learn how to count from 1 to 100 in German.',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            [
                'course_section_id' => 10, 
                'title' => 'Introduction to English',
                'content' => 'Welcome to your first English lesson. In this lesson, we will learn basic greetings and introductions.',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_section_id' => 11, 
                'title' => 'Numbers and Counting',
                'content' => 'Learn how to count from 1 to 100 in English.',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_section_id' => 13, 
                'title' => 'Introduction to Hindi',
                'content' => 'Welcome to your first Hindi lesson. In this lesson, we will learn basic greetings and introductions.',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_section_id' => 14, 
                'title' => 'Numbers and Counting',
                'content' => 'Learn how to count from 1 to 100 in Hindi.',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($lessonData as $lesson) {
            DB::table('lessons')->insert($lesson);
        }
    }
}

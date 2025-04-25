<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuizzesSeeder extends Seeder
{
    public function run(): void
    {
        $quizzes = [
            [
                'id' => 1,
                'course_id' => 4,
                'lesson_id' => 10,
                'title' => 'English Vocabulary Quiz',
                'description' => 'Test your knowledge of basic English vocabulary.',
                'language_level' => 'beginner',
                'time_limit' => 20,
                'passing_score' => 70,
                'attempts_allowed' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'course_id' => 1,
                'lesson_id' => 2,
                'title' => 'Spanish Grammar Quiz',
                'description' => 'Test your understanding of basic Spanish grammar concepts.',
                'language_level' => 'beginner',
                'time_limit' => 15,
                'passing_score' => 65,
                'attempts_allowed' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'course_id' => 2,
                'lesson_id' => 5,
                'title' => 'French Vocabulary Challenge',
                'description' => 'Challenge your French vocabulary knowledge.',
                'language_level' => 'intermediate',
                'time_limit' => 30,
                'passing_score' => 80,
                'attempts_allowed' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'course_id' => 3,
                'lesson_id' => 7,
                'title' => 'German Pronunciation Quiz',
                'description' => 'Test your German pronunciation knowledge.',
                'language_level' => 'beginner',
                'time_limit' => 25,
                'passing_score' => 75,
                'attempts_allowed' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'course_id' => 4,
                'lesson_id' => 9,
                'title' => 'Advanced English Grammar',
                'description' => 'Test your knowledge of advanced English grammar concepts.',
                'language_level' => 'advanced',
                'time_limit' => 40,
                'passing_score' => 85,
                'attempts_allowed' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('quizzes')->insert($quizzes);
    }
}

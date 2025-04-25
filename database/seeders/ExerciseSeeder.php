<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExerciseSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('exercises')->count() > 0) {
            
            return;
        }
        
        $exercises = [
            [
                'course_id' => 4,
                'lesson_id' => 10,
                'title' => 'Fill in the Blanks Exercise',
                'description' => 'Complete the sentences by filling in the correct words.',
                'language_level' => 'intermediate',
                'skill_focus' => 'listening',
                'estimated_time' => 15,
                'instructions' => 'Read each sentence carefully and fill in the blank with the appropriate word.',
                'exercise_type' => 'fill-in-blank',
                'case_sensitive' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 1,
                'lesson_id' => 1,
                'title' => 'Basic Spanish Vocabulary',
                'description' => 'Test your knowledge of basic Spanish words.',
                'language_level' => 'beginner',
                'skill_focus' => 'vocabulary',
                'estimated_time' => 10,
                'instructions' => 'Complete each sentence with the appropriate Spanish word.',
                'exercise_type' => 'fill-in-blank',
                'case_sensitive' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 4,
                'lesson_id' => 9,
                'title' => 'English Grammar Practice',
                'description' => 'Practice your English grammar skills.',
                'language_level' => 'intermediate',
                'skill_focus' => 'grammar',
                'estimated_time' => 20,
                'instructions' => 'Fill in the blanks with the correct grammatical form.',
                'exercise_type' => 'fill-in-blank',
                'case_sensitive' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 2,
                'lesson_id' => 5,
                'title' => 'French Vocabulary Quiz',
                'description' => 'Test your knowledge of French vocabulary.',
                'language_level' => 'beginner',
                'skill_focus' => 'vocabulary',
                'estimated_time' => 15,
                'instructions' => 'Select the correct translation for each word.',
                'exercise_type' => 'quiz',
                'case_sensitive' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 3,
                'lesson_id' => 7,
                'title' => 'German Pronunciation',
                'description' => 'Practice your German pronunciation.',
                'language_level' => 'beginner',
                'skill_focus' => 'speaking',
                'estimated_time' => 25,
                'instructions' => 'Listen to the audio and fill in the missing words.',
                'exercise_type' => 'fill-in-blank',
                'case_sensitive' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('exercises')->insert($exercises);
    }
}

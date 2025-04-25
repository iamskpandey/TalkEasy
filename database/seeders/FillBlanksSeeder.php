<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FillBlanksSeeder extends Seeder
{
    public function run(): void
    {
        $fillBlankQuestions = [
            [
                'id' => 1,
                'exercise_id' => 1,
                'text_with_blanks' => 'The cat sat on the [blank:mat]',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'exercise_id' => 1,
                'text_with_blanks' => 'The cat [blank:sat] on the mat',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'exercise_id' => 1,
                'text_with_blanks' => 'The [blank:cat] sat on the mat',
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'exercise_id' => 2,
                'text_with_blanks' => 'Buenos [blank:días] means good morning in Spanish',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'exercise_id' => 2,
                'text_with_blanks' => 'Hola, ¿cómo [blank:estás]?',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'exercise_id' => 3,
                'text_with_blanks' => 'She [blank:is] going to the store',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'exercise_id' => 3,
                'text_with_blanks' => 'They [blank:have] been studying for hours',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8, 
                'exercise_id' => 3,
                'text_with_blanks' => 'The books [blank:are] on the table',
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9,
                'exercise_id' => 5,
                'text_with_blanks' => 'Guten [blank:Tag] means good day in German',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10,
                'exercise_id' => 5,
                'text_with_blanks' => 'Wie [blank:geht] es dir?',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('fill_blank_questions')->insert($fillBlankQuestions);
    }
}

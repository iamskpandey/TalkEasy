<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User::factory(10)->create();
        $users = [
            [
                "name"=> "Krishna Kumar",
                "email"=> "krishna@gmail.com",
                "language_preference"=> "spanish",
                "password"=> bcrypt("12345678"),
            ],
            [
                "name"=> "Rajesh Kumar",
                "email"=> "rajesh@gmail.com",
                "language_preference"=> "french",
                "password"=> bcrypt("12345678"),
            ],
            [
                "name"=> "Radha Kumari",
                "email"=> "radha@gmail.com",
                "language_preference"=> "german",
                "password"=> bcrypt("12345678"),
            ],
            [
                "name"=> "Sita Kumari",
                "email"=> "sita@gmail.com",
                "language_preference"=> "french",
                "password"=> bcrypt("12345678"),
            ],
        ];

        for($i=0;$i<count($users);$i++){
            if (!User::where('email', $users[$i]['email'])->exists()) {
                User::factory()->create($users[$i]);
            }
        }

        $this->call([
            CoursesSeeder::class,
            CourseSectionSeeder::class,
            CourseLessonSeeder::class,
            ExerciseSeeder::class,
            FillBlanksSeeder::class,
            QuizzesSeeder::class,
            QuizQuestionSeeder::class,
        ]);
    }
}

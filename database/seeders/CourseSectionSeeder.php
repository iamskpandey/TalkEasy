<?php

namespace Database\Seeders;

use App\Models\CourseSection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSectionSeeder extends Seeder
{
    public function run(): void
    {
        $courseSectionDetail = [
            [
                'course_id' => 1,
                'title' => 'First Steps Toward Spanish',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 1,
                'title' => 'Basic Vocabulary',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 1,
                'title' => 'Basic Grammar',
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 2,
                'title' => 'First Steps Toward French',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 2,
                'title' => 'Basic Vocabulary',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 2,
                'title' => 'Basic Grammar',
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 3,
                'title' => 'First Steps Toward German',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 3,
                'title' => 'Basic Vocabulary',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 3,
                'title' => 'Basic Grammar',
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 4,
                'title' => 'First Steps Toward English',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 4,
                'title' => 'Basic Vocabulary',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 4,
                'title' => 'Basic Grammar',
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 5,
                'title' => 'First Steps Toward Hindi',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 5,
                'title' => 'Basic Vocabulary',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 5,
                'title' => 'Basic Grammar',
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        foreach ($courseSectionDetail as $section) {
            CourseSection::create($section);
        }
    }
}

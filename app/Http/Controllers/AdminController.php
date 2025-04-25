<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $coursesCount = \App\Models\Course::count();
        $exercisesCount = \App\Models\Exercise::count();
        $quizzesCount = \App\Models\Quiz::count();
        $usersCount = \App\Models\User::count();

        $courses = \App\Models\Course::orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        $exercises = \App\Models\Exercise::with('course')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        $quizzes = \App\Models\Quiz::with('course')
            ->withCount('questions')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        $users = \App\Models\User::orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return view('admin.dashboard', compact(
            'coursesCount',
            'exercisesCount',
            'quizzesCount',
            'usersCount',
            'courses',
            'exercises',
            'quizzes',
            'users'
        ));
    }

    public function courses()
    {
        return view('admin.courses');
    }

    public function exercises()
    {
        return view('admin.exercises');
    }

    public function quizzes()
    {
        return view('admin.quizzes');
    }

    public function createCourse()
    {
        return view('admin.create-course');
    }
    public function storeCourse(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'required|string|max:500',
            'language_level' => 'required|string|in:beginner,intermediate,advanced',
            'language' => 'required|string',
            'instructor' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'sections' => 'required|array|min:1',
            'sections.*.title' => 'required|string|max:255',
            'sections.*.lessons' => 'required|array|min:1',
            'sections.*.lessons.*.title' => 'required|string|max:255',
            'sections.*.lessons.*.content' => 'required|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store('course-images', 'public');
        }

        \DB::beginTransaction();

        try {
            $course = \App\Models\Course::create([
                'title' => $request->title,
                'description' => $request->description,
                'short_description' => $request->short_description,
                'language_level' => $request->language_level,
                'language' => $request->language,
                'instructor' => $request->instructor,
                'duration' => $request->duration,
                'price' => $request->price,
                'image_path' => $imagePath,
            ]);

            foreach ($request->sections as $sectionIndex => $sectionData) {
                $section = $course->sections()->create([
                    'title' => $sectionData['title'],
                    'order' => $sectionIndex,
                ]);

                foreach ($sectionData['lessons'] as $lessonIndex => $lessonData) {
                    $mediaPath = null;
                    $mediaKey = "sections.{$sectionIndex}.lessons.{$lessonIndex}.media";

                    if ($request->hasFile($mediaKey) && $request->file($mediaKey)->isValid()) {
                        $mediaPath = $request->file($mediaKey)->store('lesson-media', 'public');
                    }

                    $section->lessons()->create([
                        'title' => $lessonData['title'],
                        'content' => $lessonData['content'],
                        'media_path' => $mediaPath,
                        'order' => $lessonIndex,
                    ]);
                }
            }

            \DB::commit();

            return redirect()->route('courses.create')->with('success', 'Course created successfully');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('error', 'Failed to create course: ' . $e->getMessage())->withInput();
        }
    }
    public function createExercise()
    {
        $courses = \App\Models\Course::orderBy('title')->get();
        return view('admin.create-exercise', compact('courses'));
    }
    public function storeExercise(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'lesson_id' => 'required|exists:lessons,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'language_level' => 'required|string|in:beginner,intermediate,advanced',
            'skill_focus' => 'required|string|in:vocabulary,grammar,reading,listening,speaking,writing',
            'estimated_time' => 'required|integer|min:1|max:120',
            'instructions' => 'required|string',
            'exercise_type' => 'required|string|in:fill-in-blank',
            'questions' => 'required|array|min:1',
            'questions.*.text_with_blanks' => 'required|string',
        ]);

        $blankPattern = '/\[blank:[^\[\]]+\]/';
        foreach ($request->questions as $index => $question) {
            if (!preg_match($blankPattern, $question['text_with_blanks'])) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(["questions.{$index}.text_with_blanks" => "Question {$index} must contain at least one blank in the format [blank:answer]"]);
            }
        }

        \DB::beginTransaction();

        try {
            $exercise = \App\Models\Exercise::create([
                'course_id' => $request->course_id,
                'lesson_id' => $request->lesson_id,
                'title' => $request->title,
                'description' => $request->description,
                'language_level' => $request->language_level,
                'skill_focus' => $request->skill_focus,
                'estimated_time' => $request->estimated_time,
                'instructions' => $request->instructions,
                'exercise_type' => $request->exercise_type,
                'case_sensitive' => $request->has('case_sensitive') ? true : false,
            ]);

            foreach ($request->questions as $index => $questionData) {
                $exercise->fillBlankQuestions()->create([
                    'text_with_blanks' => $questionData['text_with_blanks'],
                    'order' => $index
                ]);
            }

            \DB::commit();

            return redirect()->route('exercises.create')->with('success', 'Exercise created successfully');
        } catch (\Exception $e) {
            \DB::rollback();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create exercise: ' . $e->getMessage());
        }
    }
    public function createQuiz()
    {
        $courses = \App\Models\Course::orderBy('title')->get();
        return view('admin.create-quiz', compact('courses'));
    }
    public function storeQuiz(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'lesson_id' => 'required|exists:lessons,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'language_level' => 'required|string|in:beginner,intermediate,advanced',
            'time_limit' => 'required|integer|min:5|max:180',
            'passing_score' => 'required|integer|min:1|max:100',
            'attempts_allowed' => 'required|integer|min:1|max:10',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.type' => 'required|string|in:multiple_choice,true_false,short_answer',
            'questions.*.points' => 'required|integer|min:1|max:100',
        ]);

        \DB::beginTransaction();

        try {
            $quiz = \App\Models\Quiz::create([
                'course_id' => $request->course_id,
                'lesson_id' => $request->lesson_id,
                'title' => $request->title,
                'description' => $request->description,
                'language_level' => $request->language_level,
                'time_limit' => $request->time_limit,
                'passing_score' => $request->passing_score,
                'attempts_allowed' => $request->attempts_allowed,
            ]);

            foreach ($request->questions as $index => $questionData) {
                $imagePath = null;
                if ($request->hasFile("questions.{$index}.image") && $request->file("questions.{$index}.image")->isValid()) {
                    $imagePath = $request->file("questions.{$index}.image")->store('quiz-images', 'public');
                }

                $correctAnswers = [];
                $options = null;

                switch ($questionData['type']) {
                    case 'multiple_choice':
                        if (empty($questionData['options'])) {
                            throw new \Exception('Multiple choice questions must have options.');
                        }

                        $options = [];
                        $hasCorrectAnswer = false;

                        foreach ($questionData['options'] as $optionIndex => $option) {
                            $options[] = $option['text'];

                            if (!empty($option['is_correct'])) {
                                $correctAnswers[] = $optionIndex;
                                $hasCorrectAnswer = true;
                            }
                        }

                        if (!$hasCorrectAnswer) {
                            throw new \Exception('Multiple choice questions must have at least one correct answer.');
                        }
                        break;

                    case 'true_false':
                        $correctAnswers = [$questionData['true_false']];
                        break;

                    case 'short_answer':
                        $correctAnswers = [$questionData['short_answer']];
                        break;
                }

                $quiz->questions()->create([
                    'type' => $questionData['type'],
                    'text' => $questionData['text'],
                    'image_path' => $imagePath,
                    'points' => $questionData['points'],
                    'explanation' => $questionData['explanation'] ?? null,
                    'options' => $options,
                    'correct_answers' => $correctAnswers,
                    'order' => $index,
                ]);
            }

            \DB::commit();

            return redirect()->route('quizzes.create')->with('success', 'Quiz created successfully');
        } catch (\Exception $e) {
            \DB::rollback();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create quiz: ' . $e->getMessage());
        }
    }

    public function getCourseLessons($courseId)
    {
        $course = \App\Models\Course::findOrFail($courseId);

        $lessons = collect();

        foreach ($course->sections as $section) {
            $sectionLessons = $section->lessons->map(function ($lesson) use ($section) {
                return [
                    'id' => $lesson->id,
                    'title' => "{$section->title} - {$lesson->title}",
                    'section_id' => $section->id
                ];
            });

            $lessons = $lessons->concat($sectionLessons);
        }

        return response()->json([
            'success' => true,
            'lessons' => $lessons
        ]);
    }
}

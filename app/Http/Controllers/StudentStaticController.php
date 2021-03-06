<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Group;
use App\Models\Lesson;
use App\Models\Result;
use App\Models\Section;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class StudentStaticController extends Controller
{
    //

    public function index()
    {

        $class = Group::where('class_id', session('user_class'))->first();
        $assigned_courses = explode(',', $class->assigned_courses);
        $courses = Course::whereIn('course_id', $assigned_courses);
        $sections = Section::whereIn('course_id', $assigned_courses);
        $lessons = Lesson::whereIn('section_id', $sections->pluck('section_id'))->get();

        // Get user lesson history

        $userResult = Result::where('user_id', session('user_id'));

        if ($userResult->count() > 0) {
            $last_lesson_id = $userResult->latest()->first()->lesson_id;
            $last_section_id = Lesson::where('lesson_id', $last_lesson_id)->first()->section_id;
            $last_course_id = Lesson::where('lesson_id', $last_lesson_id)->first()->course_id;
            $all_finished_lesson = Result::where('user_id', session('user_id'))->select('lesson_id')->get();

            $data = [
                'title' => 'Skillful Typing | Student Static',
                'class' => $class,
                'courses' => $courses->get(),
                'sections' => $sections->get(),
                'lessons' => $lessons,
                'last_lesson_id' => $last_lesson_id,
                'last_section_id' => $last_section_id,
                'last_course_id' => $last_course_id,
                'all_finished_lesson' => $all_finished_lesson
            ];

            return view('student.student_static', $data);
        }

        $data = [
            'title' => 'Skillful Typing | Student Static',
            'class' => $class,
            'courses' => $courses->get(),
            'sections' => $sections->get(),
            'lessons' => $lessons,
        ];

        return view('student.student_static', $data);
    }

    public function overallResult()
    {
        $class = Group::where('class_id', session('user_class'))->first();
        $assigned_courses = explode(',', $class->assigned_courses);
        $courses = Course::whereIn('course_id', $assigned_courses);

        $data = [
            'title' => 'Skillful Typing | Student Static - Overall Result',
            'courses' => $courses->get()
        ];

        return view('student.overall_result', $data);
    }

    public function postOverallResult(Request $request)
    {
        $class = Group::where('class_id', session('user_class'))->first();
        $assigned_courses = explode(',', $class->assigned_courses);
        $courses = Course::whereIn('course_id', $assigned_courses);

        $sections = Section::where('course_id', $request->course_id);
        $lessons = Lesson::where('course_id', $request->course_id);

        $selectedCourse = Course::where('course_id', $request->course_id)->first();
        $lessons_name =  $lessons->pluck('lesson_name')->toArray();
        $lessons_id =  $lessons->pluck('lesson_id')->toArray();
        $lessons_completed = Result::where('user_id', session('user_id'))->whereIn('lesson_id', $lessons_id)->pluck('lesson_id')->count();
        $sum_speed = Result::where('user_id', session('user_id'))->whereIn('lesson_id', $lessons_id)->sum('wpm');
        $sum_accuracy = Result::where('user_id', session('user_id'))->whereIn('lesson_id', $lessons_id)->sum('accuracy');
        $sum_slowdown = Result::where('user_id', session('user_id'))->whereIn('lesson_id', $lessons_id)->sum('slowdown');
        $error_words = Result::where('user_id', session('user_id'))->whereIn('lesson_id', $lessons_id)->sum('incorrect_words');
        $correct_words = Result::where('user_id', session('user_id'))->whereIn('lesson_id', $lessons_id)->sum('correct_words');
        $time_spend = Result::where('user_id', session('user_id'))->whereIn('lesson_id', $lessons_id)->sum('minutes');

        if ($lessons_completed > 0) {
            $data = [
                'title' => 'Skillful Typing | Student Static - Overall Result',
                'courses' => $courses->get(),
                'lessons_name' => implode(', ', $lessons_name),
                'lessons_count' => $lessons->count(),
                'sections_name' => $sections->get(),
                'selected_course' => $selectedCourse,
                'lessons_completed' => $lessons_completed,
                'avg_speed' => $sum_speed / $lessons_completed,
                'avg_accuracy' => $sum_accuracy / $lessons_completed,
                'avg_slowdown' => $sum_slowdown / $lessons_completed,
                'error_words' => $error_words,
                'time_spend' => number_format((float)$time_spend, 2, '.', ''),
                'words_typed' => $correct_words + $error_words
            ];

            return view('student.overall_result', $data);
        }

        $data = [
            'title' => 'Skillful Typing | Student Static - Overall Result',
            'courses' => $courses->get(),
            'lessons_name' => implode(', ', $lessons_name),
            'lessons_count' => $lessons->count(),
            'sections_name' => $sections->get(),
            'selected_course' => $selectedCourse,
        ];

        return view('student.overall_result', $data);
        // return $data;
    }

    public function getLessonStaticById(Request $request)
    {
        $result = Result::where(['user_id' => session('user_id'), 'lesson_id' => $request->lesson])->first();

        // 
        $class = Group::where('class_id', session('user_class'))->first();
        $assigned_courses = explode(',', $class->assigned_courses);
        $courses = Course::whereIn('course_id', $assigned_courses);
        $sections = Section::whereIn('course_id', $assigned_courses);
        $lessons = Lesson::whereIn('section_id', $sections->pluck('section_id'))->get();

        $userResult = Result::where('user_id', session('user_id'));

        if ($userResult->count() > 0) {
            $data = [
                'title' => 'Skillful Typing | Student Static',
                'class' => $class,
                'courses' => $courses->get(),
                'sections' => $sections->get(),
                'lessons' => $lessons,
                'result' => $result,
                // 'message' => 'Lesson result not found.'
            ];

            return view('student.student_static', $data);
        }

        $data = [
            'title' => 'Skillful Typing | Student Static',
            'class' => $class,
            'courses' => $courses->get(),
            'sections' => $sections->get(),
            'lessons' => $lessons,
            'message' => 'Lesson result not found.'
        ];

        return view('student.student_static', $data);
    }

    public function printToPdf(Request $request)
    {
        $class = Group::where('class_id', session('user_class'))->first();
        $assigned_courses = explode(',', $class->assigned_courses);
        $courses = Course::whereIn('course_id', $assigned_courses);

        $sections = Section::where('course_id', $request->course_id);
        $lessons = Lesson::where('course_id', $request->course_id);



        $selectedCourse = Course::where('course_id', $request->course_id)->first();
        $lessons_name =  $lessons->pluck('lesson_name')->toArray();
        $lessons_id =  $lessons->pluck('lesson_id')->toArray();
        $lessons_completed = Result::where('user_id', session('user_id'))->whereIn('lesson_id', $lessons_id)->pluck('lesson_id')->count();

        $all_lesson_result = Result::where('user_id', session('user_id'))->whereIn('lesson_id', $lessons_id)->get();

        $sum_speed = Result::where('user_id', session('user_id'))->whereIn('lesson_id', $lessons_id)->sum('wpm');
        $sum_accuracy = Result::where('user_id', session('user_id'))->whereIn('lesson_id', $lessons_id)->sum('accuracy');
        $sum_slowdown = Result::where('user_id', session('user_id'))->whereIn('lesson_id', $lessons_id)->sum('slowdown');
        $error_words = Result::where('user_id', session('user_id'))->whereIn('lesson_id', $lessons_id)->sum('incorrect_words');
        $correct_words = Result::where('user_id', session('user_id'))->whereIn('lesson_id', $lessons_id)->sum('correct_words');
        $time_spend = Result::where('user_id', session('user_id'))->whereIn('lesson_id', $lessons_id)->sum('minutes');

        $data = [
            'title' => 'Skillful Typing | Student Static - Overall Result',
            'courses' => $courses->get(),
            'all_lesson_result' => $all_lesson_result,
            'lessons_name' => implode(', ', $lessons_name),
            'lessons_count' => $lessons->count(),
            'sections_name' => $sections->get(),
            'selected_course' => $selectedCourse,
            'lessons_completed' => $lessons_completed,
            'avg_speed' => $sum_speed / $lessons_completed,
            'avg_accuracy' => $sum_accuracy / $lessons_completed,
            'avg_slowdown' => $sum_slowdown / $lessons_completed,
            'error_words' => $error_words,
            'time_spend' => number_format((float)$time_spend, 2, '.', ''),
            'words_typed' => $correct_words + $error_words,
            'user_class' => Group::where('class_id', session('user_class'))->first()->class_name
        ];

        $pdf = PDF::loadView('student.overall_result_print', $data)->setPaper('A4', 'landscape')->setOptions([
            'dpi' => 150,
            'defaultFont' => 'sans-serif',
            'enable-javascript' => true,
            'javascript-delay' => 13000,
            'images' => true,
            'enable-smart-shrinking' => true,
            'no-stop-slow-scripts' => true
        ]);

        return $pdf->download(session('user_name') . '_' . $selectedCourse->course_name . '.pdf');
    }


    public function getLessonStaticPageById($lesson_id)
    {
        $result = Result::where(['user_id' => session('user_id'), 'lesson_id' => $lesson_id])->first();

        //
        $class = Group::where('class_id', session('user_class'))->first();
        $assigned_courses = explode(',', $class->assigned_courses);
        $courses = Course::whereIn('course_id', $assigned_courses);
        $sections = Section::whereIn('course_id', $assigned_courses);
        $lessons = Lesson::whereIn('section_id', $sections->pluck('section_id'))->get();

        $userResult = Result::where('user_id', session('user_id'));

        if ($userResult->count() > 0) {
            $data = [
                'title' => 'Skillful Typing | Student Static',
                'class' => $class,
                'courses' => $courses->get(),
                'sections' => $sections->get(),
                'lessons' => $lessons,
                'result' => $result,
                // 'message' => 'Lesson result not found.'
            ];

            return view('student.student_static', $data);
        }

        $data = [
            'title' => 'Skillful Typing | Student Static',
            'class' => $class,
            'courses' => $courses->get(),
            'sections' => $sections->get(),
            'lessons' => $lessons,
            'message' => 'Lesson result not found.'
        ];

        return view('student.student_static', $data);
    }
}

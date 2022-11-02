<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courses;
use App\Models\Teachers;
use App\Models\CourseMember;

class CourseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $name = $request->name;
        $code = $request->code;
        if($name || $code){
            $courses = Courses::where('name','LIKE','%'.$name.'%')
                ->where('courseCode','LIKE','%'.$code.'%')
                ->paginate(10);
        }else{
            $courses = Courses::paginate(10);
        }
        return view('course', compact('courses', 'name', 'code'));
    }

    public function detail($id){
        $course = Courses::where('id', $id)->first();
        if($course){
            $tea = Teachers::all();
            $teachers = [];
            foreach($tea as $teacher){
                $exist = CourseMember::where('courseID', $course->id)->where('teacherID', $teacher->id)->first();
                if(!$exist){
                    array_push($teachers, $teacher);
                }
            }
            $teacherData = Teachers::select('teachers.*')
                ->join('course_members', 'teachers.id', '=', 'course_members.teacherID')
                ->where('course_members.courseID', $course->id)
                ->get();
            return view('course-detail')->with(compact('course', 'teachers', 'teacherData'));
        }else{
            return redirect()->back();
        }
    }

    public function store(Request $request){
        $validate = $request->validate([
                'name' => 'required',
                'courseCode' => 'required|min:5',
                'description' => 'required|min:50',
                'startDate' => 'required',
                'endDate' => 'required',
            ], [
                'name.required' => 'Name field is required.',
                'courseCode.required' => 'CourseCode field is required.',
                'description.required' => 'Description field is required.',
                'startDate.required' => 'Start Date field is required.',
                'endDate.required' => 'End Date field is required.'
            ]);

        $course = Courses::create($validate);

        return back()->with('success', 'Course created successfully.');
    }

    public function edit($id){
        $course = Courses::where('id', $id)->first();
        if($course){
            return view('course-edit')->with(compact('course'));   
        }else{
            return redirect()->back();
        }
    }

    public function update(Request $request){
        $validate = $request->validate([
                'name' => 'required',
                'courseCode' => 'required|min:5',
                'description' => 'required|min:50',
                'startDate' => 'required',
                'endDate' => 'required',
            ], [
                'name.required' => 'Name field is required.',
                'courseCode.required' => 'CourseCode field is required.',
                'description.required' => 'Description field is required.',
                'startDate.required' => 'Start Date field is required.',
                'endDate.required' => 'End Date field is required.'
            ]);

        $course = Courses::where('id', $request->id)->update($validate);

        return back()->with('success', 'Course updated successfully.');
    }

    public function delete($id){
        $delete = Courses::where('id', $id)->delete();

        return redirect('/')->with('success', 'Course removed successfully.');   
    }

    public function add_teachers(Request $request){
        $id = $request->id;
        $teachers = $request->teachers;
        $validate = $request->validate([
                'teachers' => 'required',
            ], [
                'teachers.required' => 'Teachers field is required.'
            ]);
        foreach($teachers as $teacher){
            $dataInput['courseID'] = $id;
            $dataInput['teacherID'] = $teacher;
            CourseMember::create($dataInput);
        }
        return back()->with('success', 'Teachers added successfully.');
    }
}

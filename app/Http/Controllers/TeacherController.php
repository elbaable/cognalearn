<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courses;
use App\Models\Teachers;
use App\Models\CourseMember;

class TeacherController extends Controller
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
        $firstName = $request->firstName;
        $lastName = $request->lastName;
        $email = $request->email;
        if($firstName != "" || $lastName != "" || $email != ""){
            $teachers = Teachers::where('firstName','LIKE','%'.$firstName.'%')
                ->where('lastName','LIKE','%'.$lastName.'%')
                ->where('email','LIKE','%'.$email.'%')
                ->paginate(15);
        }else{
            $teachers = Teachers::paginate(15);
        }
        return view('teacher', compact('teachers', 'firstName', 'lastName', 'email'));
    }

    public function detail($id){
        $teacher = Teachers::where('id', $id)->first();
        if($teacher){
            $cor = Courses::all();
            $courses = [];
            foreach($cor as $course){
                $exist = CourseMember::where('courseID', $course->id)->where('teacherID', $teacher->id)->first();
                if(!$exist){
                    array_push($courses, $course);
                }
            }
            $courseData = Courses::select('courses.*')
                ->join('course_members', 'courses.id', '=', 'course_members.courseID')
                ->where('course_members.teacherID', $teacher->id)
                ->get();
            return view('teacher-detail')->with(compact('teacher', 'courses', 'courseData'));   
        }else{
            return redirect()->back();
        }
    }

    public function store(Request $request){
        $validate = $request->validate([
                'firstName' => 'required',
                'lastName' => 'required',
                'email' => 'required|email|unique:teachers',
                'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10'
            ], [
                'firstName.required' => 'First Name field is required.',
                'lastName.required' => 'Last Name field is required.',
                'email.required' => 'Email field is required.',
                'email.email' => 'Email field must be email address.',
                'phone.required' => 'Phone Number field is required.'
            ]);

        $teacher = Teachers::create($validate);

        return back()->with('success', 'Teacher created successfully.');
    }

    public function edit($id){
        $teacher = Teachers::where('id', $id)->first();
        if($teacher){
            return view('teacher-edit')->with(compact('teacher'));   
        }else{
            return redirect()->back();
        }
    }

    public function update(Request $request){
        $validate = $request->validate([
                'firstName' => 'required',
                'lastName' => 'required',
                'email' => 'required|email',
                'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10'
            ], [
                'firstName.required' => 'First Name field is required.',
                'lastName.required' => 'Last Name field is required.',
                'email.required' => 'Email field is required.',
                'email.email' => 'Email field must be email address.',
                'phone.required' => 'Phone Number field is required.'
            ]);

        $teacher = Teachers::where('id', $request->id)->update($validate);

        return back()->with('success', 'Teacher updated successfully.');
    }

    public function delete($id){
        $delete = Teachers::where('id', $id)->delete();

        return redirect('teachers')->with('success', 'Teacher removed successfully.');   
    }

    public function add_courses(Request $request){
        $id = $request->id;
        $courses = $request->courses;
        $validate = $request->validate([
                'courses' => 'required',
            ], [
                'courses.required' => 'Courses field is required.'
            ]);
        foreach($courses as $course){
            $dataInput['teacherID'] = $id;
            $dataInput['courseID'] = $course;
            CourseMember::create($dataInput);
        }
        return back()->with('success', 'Courses added successfully.');
    }
}

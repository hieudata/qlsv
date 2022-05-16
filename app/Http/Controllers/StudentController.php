<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Student;
use App\Models\Subject;
use App\Repositories\Student\StudentRepositoryInterface;
use App\Repositories\Faculty\FacultyRepositoryInterface;
use App\Repositories\Subject\SubjectRepositoryInterface;
use GuzzleHttp\Psr7\Request;

class StudentController extends Controller
{
    protected $studentRepo, $facultyRepo, $subjectRepo;

    public function __construct(StudentRepositoryInterface $studentRepo, FacultyRepositoryInterface $facultyRepo, SubjectRepositoryInterface $subjectRepo)
    {
        $this->studentRepo = $studentRepo;
        $this->facultyRepo = $facultyRepo;
        $this->subjectRepo = $subjectRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = $this->studentRepo->paginate();
        // dd($students);
        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $student = $this->studentRepo->newStudent();
        $faculties = $this->facultyRepo->pluck();
        return view('students.form', compact('faculties', 'student'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request)
    {
        $request->validate(['avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048']);
        $input = $request->all();
        if ($avatar = $request->file('avatar')) {
            $profileImage = 'images/' . rand(1111, 9999) . "." . $avatar->getClientOriginalExtension();
            $avatar->move('images', $profileImage);
            $input['avatar'] = "$profileImage";
        }

        $this->studentRepo->create($input);
        return redirect()->route('students.index')->with('success', 'Create Successful');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = $this->studentRepo->find($id);
        // dd($student);
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $student = $this->studentRepo->find($id);
        return view('students.form', [
            'student' => $this->studentRepo->find($id),
            'faculties' => $this->facultyRepo->pluck()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StudentRequest $request, $id)
    {
        $student = $this->studentRepo->find($id);
        $input = $request->all();
        if ($avatar = $request->file('avatar')) {
            $profileImage = 'images/' . rand(1111, 9999) . "." . $avatar->getClientOriginalExtension();
            $avatar->move('images/', $profileImage);
            $input['avatar'] = "$profileImage";
        } else {
            unset($input['avatar']);
        }
        $student->update($input);
        // dd($student);
        return redirect()->back()->with('success', 'Update Successful');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->studentRepo->delete($id);

        return redirect()->route('students.index')->with('success', 'Detele Successful');
    }

    public function addsub(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $request->validate([
            'subjects' => 'required',
        ]);

        $student->subjects()->attach($request->subjects);
        return redirect()->route('students.add');
        // $student = Student::findOrFail($id);
        // $student->subjects()->attach();
        // // dd($student);
        // return view('students.add', compact('student'));
    }
}

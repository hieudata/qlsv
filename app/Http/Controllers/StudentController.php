<?php

namespace App\Http\Controllers;

use App\Http\Requests\PointRequest;
use App\Http\Requests\StudentRequest;
use App\Repositories\Student\StudentRepositoryInterface;
use App\Repositories\Faculty\FacultyRepositoryInterface;
use App\Repositories\Subject\SubjectRepositoryInterface;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;
use App\Mail\MyTestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
    public function index(Request $request)
    {
        $students = $this->studentRepo->search($request->all(), $this->subjectRepo->getAll()->count());
        $faculties = $this->facultyRepo->getAll()->pluck('name', 'id');

        return view('students.index', compact('students', 'faculties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $student = $this->studentRepo->newStudent();
        $faculties = $this->facultyRepo->getAll()->pluck('name', 'id');
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
        $input = $request->all();
        if ($avatar = $request->file('avatar')) {
            $profileImage = rand(1111, 9999) . "." . $avatar->getClientOriginalExtension();
            $avatar->move('images', $profileImage);
            $input['avatar'] = "$profileImage";
        } else {
            $input['avatar'] = 'default.png';
        }
        // $input['password'] = Str::random(10);
        $this->studentRepo->create($input);
        return redirect()->route('students.index')->with('success', 'Create Successful');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $student = $this->studentRepo->query()->where('slug', $slug)->first();
        return view('students.show', ['student' => $student]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('students.form', [
            'student' => $this->studentRepo->find($id),
            'faculties' => $this->facultyRepo->getAll()->pluck('name', 'id')
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
        $input['slug'] = SlugService::createSlug($student, 'slug', $request->name);
        if ($avatar = $request->file('avatar')) {
            $profileImage = rand(1111, 9999) . "." . $avatar->getClientOriginalExtension();
            $avatar->move('images/', $profileImage);
            $input['avatar'] = "$profileImage";
            unlink('images/' . $student->avatar);
        } else {
            unset($input['avatar']);
        }
        $student->update($input);
        return redirect()->route('students.index')->with('success', 'Update Successful');
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

    // Login Student
    public function login()
    {
        return view('students.login');
    }

    public function check(Request $request)
    {
        //Validate requests
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5|max:12'
        ]);

        $student = $this->studentRepo->query()->where('email', '=', $request->email)->first();

        if (!$student) {
            return back()->with('fail', 'We do not recognize your email address');
        } else {
            //check password
            if ($request->password == $student->password) {
                $request->session()->put('LoggedUser', $student->id);
                return redirect('student/dashboard');
            } else {
                return back()->with('fail', 'Incorrect password');
            }
        }
    }

    public function dashboard()
    {
        $student = $this->studentRepo->query()->where('id', '=', session('LoggedUser'))->first();
        if ($student) {
            return view('students.dashboard', compact('student'));
        } else {
            echo "<h3>You must log in your account. <a href='login'>Login now</a></h3>";
        }
    }

    public function logout()
    {
        if (session()->has('LoggedUser')) {
            session()->pull('LoggedUser');
            return redirect('student/login');
        }
    }
    // Register and Login Page Admin
    public function registerAdmin()
    {
        return view('students.login');
    }

    public function checkAdmin(Request $request)
    {
        //Validate requests
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5|max:12'
        ]);

        $student = $this->studentRepo->query()->where('email', '=', $request->email)->first();

        if (!$student) {
            return back()->with('fail', 'We do not recognize your email address');
        } else {
            //check password
            if ($request->password == $student->password) {
                $request->session()->put('LoggedUser', $student->id);
                return redirect('student/dashboard');
            } else {
                return back()->with('fail', 'Incorrect password');
            }
        }
    }

    // Send Mail

    public function sendmail()
    {
        $students = $this->studentRepo->query()->withAvg('studentSubject', 'point')
            ->having('student_subject_avg_point', '<', 5)->get();
        foreach ($students as $student) {
            Mail::to($student->email)->send(new MyTestMail($student));
        }
        dd("Email is Sent.");
    }

    // Ajax update popup
    public function getStudent($id)
    {
        $student = $this->studentRepo->find($id);
        return response()->json($student);
    }

    public function updateStudent(Request $request)
    {
        $student = $this->studentRepo->find($request->id);
        $input = $request->all();
        $input['slug'] = SlugService::createSlug($student, 'slug', $request->name);
        if ($avatar = $request->file('avatar')) {
            $profileImage = rand(1111, 9999) . "." . $avatar->getClientOriginalExtension();
            $avatar->move('images/', $profileImage);
            $input['avatar'] = "$profileImage";
            unlink('images/' . $student->avatar);
        } else {
            unset($input['avatar']);
        }
        $data = [];
        $student->update($input);
        $data = [
            'data' => $student,
            'message' => "Update success"
        ];

        return response()->json($data);
    }

    //Localization
    public function setLang($locale)
    {
        Session::put('locale', $locale);
        return redirect()->back();
    }

    public function getLanguage()
    {
        $en = DB::table('languages')->pluck('english', '_key');
        $vi = DB::table('languages')->pluck('vietnamese', '_key');
        $jsonEN = json_encode($en, JSON_UNESCAPED_UNICODE);
        $jsonVi = json_encode($vi, JSON_UNESCAPED_UNICODE);
        file_put_contents(base_path('resources/lang/en.json'), stripslashes($jsonEN));
        file_put_contents(base_path('resources/lang/vi.json'), stripslashes($jsonVi));
    }

    // Add&Edit Subject
    public function addSubject($id)
    {
        $student = $this->studentRepo->find($id);
        $subjects = $this->subjectRepo->getAll();
        return view('student_subject.addSubject', compact('student', 'subjects'));
    }

    public function saveSubject(Request $request, $id)
    {
        $student = $this->studentRepo->find($id);
        $this->validate($request, [
            'subjects' => 'required',
        ]);
        $student->subjects()->sync($request->subjects);
        return redirect()->route('students.index', ['student' => $student->id])->with('success', 'Succesful');
    }

    // Update Point

    public function updatePoint($id)
    {
        $points = [];
        $subject_ids = [];
        $student = $this->studentRepo->find($id);
        $allSubject = ['' => 'Select Subject'] + $this->subjectRepo->getAll()->pluck('name', 'id')->toArray();
        $subjects = $this->subjectRepo->getAll();
        $selectedSubjects  = $student->subjects()->get();
        
        foreach ($selectedSubjects as $selectedSubject) {
            $points[] = $selectedSubject->pivot->point;
            $subject_ids[] = $selectedSubject->pivot->subject_id;
        }
        return view('student_subject.updatePoint', compact('student', 'allSubject', 'subject_ids', 'points', 'subjects'));
    }

    public function savePoint(PointRequest $request, $id)
    {
        if (isset($request->subject_ids)) {
            $data = [];
            foreach ($request->subject_ids as $key => $value) {
                array_push($data, [
                    'subject_id' => $request->subject_ids[$key],
                    'point' => $request->points[$key],
                ]);
            }
            $points = [];
            foreach ($data as $key => $value) {
                $points[$value['subject_id']] = ['point' => $value['point']];
            }
            $this->studentRepo->find($id)->subjects()->sync($points);
            return redirect()->back();
        } else {
            $this->studentRepo->find($id)->subjects()->detach();
        }
    }
}

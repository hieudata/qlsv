<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Repositories\Student\StudentRepositoryInterface;
use App\Repositories\Faculty\FacultyRepositoryInterface;
use App\Repositories\Subject\SubjectRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use Cviebrock\EloquentSluggable\Services\SlugService;
use App\Mail\MyTestMail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

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
        // $subjectTotal = 0;

        // if (!empty($request['category'])) {
        //     $subjectTotal = Subject::count('id');
        // }

        $students = $this->studentRepo->search($request->all());
        $faculties = $this->facultyRepo->pluck();

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
        // $request->validate(['avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048']);
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
    public function show(Student $student)
    {
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
        return view('students.form', [
            'student' => $this->studentRepo->find($id),
            'faculties' => $this->facultyRepo->pluck('name', 'id')
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
                // return "Done";

            } else {
                return back()->with('fail', 'Incorrect password');
            }
        }
    }

    public function dashboard()
    {
        // $data = ['LoggedUserInfo'=>$this->studentRepo->query()->where('id','=', session('LoggedUser'))->first()];
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
                // return "Done";

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
        $input['slug'] = SlugService::createSlug(Student::class, 'slug', $request->name);
        if ($avatar = $request->file('avatar')) {
            $profileImage = rand(1111, 9999) . "." . $avatar->getClientOriginalExtension();
            $avatar->move('images/', $profileImage);
            $input['avatar'] = "$profileImage";
            unlink('images/' . $student->avatar);
        } else {
            unset($input['avatar']);
        }
        $student->update($input);
        return response()->json($student);
    }

    //Localization
    public function setLang($locale)
    {
        App::setLocale($locale);
        Session::put('locale', $locale);
        return redirect()->back();
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
        return redirect()->route('students.show', ['student' => $student->id])->with('success', 'Succesful');
    }

    // Update Point
    public function updatePoint($id)
    {
        $student = $this->studentRepo->find($id);
        return view('student_subject.updatePoint', compact('student'));
    }

    public function savePoint(Request $request, $id)
    {
        $data = [];
        foreach ($request->subject_id as $key => $value) {
            array_push($data, [
                'subject_id' => $request->subject_id[$key],
                'point' => $request->point[$key],
            ]);
        }
        $points = [];
        foreach ($data as $key => $value) {
            $points[$value['subject_id']] = ['point' => $value['point']];
        }
        $this->studentRepo->find($id)->subjects()->syncWithoutDetaching($points);

        return redirect()->route('students.index');
    }
}

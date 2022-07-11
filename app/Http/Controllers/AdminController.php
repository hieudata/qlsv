<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Repositories\User\UserRepository;

class AdminController extends Controller
{

    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        return view('admin.login');
    }

    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('students')
                ->withSuccess('Signed in');
        }

        return redirect("admin/login")->withSuccess('Login details are not valid');
    }

    public function registration()
    {
        return view('admin.register');
    }

    public function customRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $check = $this->create($data);

        return "Register Successful";
    }

    public function create(array $data)
    {
        return $this->userRepo->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function dashboard()
    {
        if (Auth::check()) {
            return view('students.index');
        }

        return redirect("admin/login")->withSuccess('You are not allowed to access');
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();
        return Redirect('admin/login');
    }
}

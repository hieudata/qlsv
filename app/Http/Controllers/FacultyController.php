<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Faculty\FacultyRepositoryInterface;

class FacultyController extends Controller
{
    protected $facultyRepo;

    public function __construct(FacultyRepositoryInterface $facultyRepo)
    {
        $this->facultyRepo = $facultyRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faculties = $this->facultyRepo->getFaculty();
        return view('faculties.index', compact('faculties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        return view('faculties.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $this->facultyRepo->create($request->all());
        return redirect()->route('faculties.index')->with('success', 'Create Successful');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $faculty = $this->facultyRepo->find($id);
        return view('faculties.show', compact('faculty'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $faculty = $this->facultyRepo->find($id);
        return view('faculties.edit', compact('faculty'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);      
        $faculty = $this->facultyRepo->find($id);
        $faculty->fill($request->all());
        $faculty->save();
        return redirect()->route('faculties.index')->with('success', 'Update Successful');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->facultyRepo->delete($id);

        return redirect()->route('faculties.index')->with('success', 'Detele Successful');
    }
}

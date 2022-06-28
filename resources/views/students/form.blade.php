@extends('layouts.main')
@include('layouts.flash_message')
@section('content')
    <main id="main" class="main">
        <div class="card shadow m-3 p-3">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="float-left">
                        <h2>{{ isset($student->id) ? 'Edit' : 'Add' }} Student</h2>
                    </div>
                    <div class="float-right">
                        <a class="btn btn-primary" href="{{ route('students.index') }}"> Back</a>
                    </div>
                </div>
            </div>
            @yield('error')
            {!! Form::model($student, ['route' => [$student->url(), $student->id], 'method' => $student->method(), 'enctype' => 'multipart/form-data']) !!}
            <div class="row">
                <div class="col-md-6">
                    {!! Form::label('name', 'Student Name') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Full Name']) !!}
                </div>
                <div class="col-md-6">
                    {!! Form::label('avatar', 'Avatar') !!}
                    <img id="imgPreview" src="{{ isset($student->avatar) ? asset('images/'.$student->avatar) : '' }}" width="100px"  class="rounded-circle">
                    {!! Form::file('avatar', ['id' => 'avatar']) !!}
                </div>
                <div class="col-md-6">
                    {!! Form::label('phone', 'Phone Number') !!}
                    {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Number']) !!}
                </div>
                <div class="col-md-6">
                    {!! Form::label('gender', 'Gender', ['class' => 'd-block mb-2']) !!}
                    <input type=radio name="gender" value="1" {{ $student->gender == '1' ? 'checked' : '' }}>Male
                    <input type=radio name="gender" value="0" {{ $student->gender == '0' ? 'checked' : '' }}>Female
                </div>
                <div class="col-md-6">
                    {!! Form::label('email', 'Email') !!}
                    {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
                </div>
                <div class="col-md-6">
                    {!! Form::label('birhday', 'Birthday') !!}
                    {!! Form::date('birthday', $student->birthday, ['class' => 'form-control']) !!}
                </div>
                <div class="col-md-6">
                    {!! Form::label('faculty', 'Select a faculty') !!}
                    {!! Form::select('faculty_id', $faculties, null, ['class' => 'form-control', 'placeholder' => 'Choose a faculty.']) !!}
                </div>
                <div class="col-md-6 text-center">
                    {!! Form::submit('Save', ['class' => 'btn btn-primary mt-4']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </main>
@endsection

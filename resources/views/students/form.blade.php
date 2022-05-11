@extends('layouts.main')
@include('layouts.flash_message')
@section('content')
    <div class="container-fluid">
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
                    @if (isset($student->avatar))
                        <img src="{{ asset($student->avatar) }}" alt="" width="100px">
                    @endif
                    {!! Form::file('avatar') !!}
                </div>
                <div class="col-md-6">
                    {!! Form::label('phone', 'Phone Number') !!}
                    {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Number']) !!}
                </div>
                <div class="col-md-6">
                    {!! Form::label('gender', 'Gender') !!}
                    {!! Form::select('gender', ['1' => 'Nam', '0' => 'Nữ'], null, ['class' => 'form-control', 'placeholder' => '']) !!}
                </div>
                <div class="col-md-6">
                    {!! Form::label('email', 'Email') !!}
                    {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
                </div>
                <div class="col-md-6">
                    {!! Form::label('birhday', 'Birthday') !!}
                    {!! Form::date('birthday', \Carbon\Carbon::now(), ['class' => 'form-control']) !!}
                </div>
                <div class="col-md-6">
                    {!! Form::label('faculty', 'Select a faculty') !!}
                    {!! Form::select('faculty_id', $faculties, null, ['class' => 'form-control', 'placeholder' => 'Choose a faculty.']) !!}
                </div>
                <div class="col-md-6">
                    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

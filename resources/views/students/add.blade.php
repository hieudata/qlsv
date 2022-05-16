@extends('layouts.main')
@include('layouts.flash_message')
@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-3">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary">Register</h3>
                <div class="float-right">
                    <a class="btn btn-success" href="{{ route('students.create') }}"> Student</a>
                </div>
            </div>
            <form method="GET" action="">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        {!! Form::select('subject_id', $subject, null, ['class' => 'form-control', 'placeholder' => 'Choose a subject.']) !!}
                    </div>
                    <div class="col-md-6">
                        <input type="number" name="point" step="0.01">
                    </div>
                    <div class="col-md-6">
                        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
@endsection

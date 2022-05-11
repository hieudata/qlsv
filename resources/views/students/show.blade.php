@extends('layouts.main')
@section('content')
    <div class="container-fluid">
        <div class="card shadow m-3 p-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="float-left">
                        <h2>Student Details</h2>
                    </div>
                    <div class="float-right">
                        <a class="btn btn-primary" href="{{ route('students.index') }}">Back</a>
                    </div>
                </div>
                <form action="" method="GET">
                    <a class="btn btn-success m-3" href="{{ route('subject', $student->id) }}" role="button">Add
                        subject</a>
                    <a class="btn btn-success m-3" href="#" role="button">Update point</a>
                </form>
            </div>
            <div class="row p-2">
                <div class="col-lg-3 m-4"><strong>Name: </strong>{{ $student->name }}</div>
                <div class="col-lg-3 m-4"><strong>Avatar: </strong><img src="{{ asset($student->avatar) }}" alt=""
                        width="100px"></div>
                <div class="col-lg-3 m-4"><strong>Phone: </strong>{{ $student->phone }}</div>
                <div class="col-lg-3 m-4"><strong>Gender: </strong>{{ $student->gender == 1 ? 'Nam' : 'Nữ' }}</div>
                <div class="col-lg-3 m-4"><strong>Email: </strong>{{ $student->email }}</div>
                <div class="col-lg-3 m-4"><strong>Day of Birthday: </strong>{{ $student->birthday }}</div>
                <div class="col-lg-3 m-4"><strong>Faculty: </strong>{{ $student->faculty->name }}</div>
                <div class="col-lg-3 m-4"><strong>Registered the subject: </strong></div>
            </div>
        </div>
    </div>
@endsection

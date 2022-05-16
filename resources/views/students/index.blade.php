@extends('layouts.main')
@include('layouts.flash_message')
@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-3">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary">Student List</h3>
                <div class="float-right">
                    <a class="btn btn-success" href="{{ route('students.create') }}"> Create Student</a>
                </div>
            </div>
            @yield('success')
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Avatar</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Gender</th>
                                <th>Email</th>
                                <th>Day of Birthday</th>
                                <th>Faculty</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $key => $student)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td><img src="{{ asset($student->avatar) }}" alt="" width="100px"></td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->phone }}</td>
                                    <td>{{ $student->gender == 1 ? 'Nam' : 'Nữ' }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->birthday }}</td>
                                    <td>{{ $student->faculty->name }}</td>
                                    <td>
                                        {!! Form::model($student, ['route' => ['students.destroy', $student->id], 'method' => 'DELETE']) !!}
                                        <a class="btn btn-info"
                                            href="{{ route('students.show', $student->id) }}">Show</a>
                                        <a class="btn btn-primary"
                                            href="{{ route('students.edit', $student->id) }}">Edit</a>
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $students->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

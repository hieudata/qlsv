@extends('layouts.main')
@section('content')
    <main id="main" class="main">
        <div class="card shadow m-3 p-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="float-start">
                        <h2>Student Details</h2>
                    </div>
                    <div class="float-end">
                        <a class="btn btn-primary" href="{{ route('students.index') }}">Back</a>
                    </div>
                </div>
                @yield('success')
            </div>
            <div class="d-flex flex-row bd-highlight mb-3">
                <a class="btn btn-success m-1"
                    href="{{ route('addSubject', $student->id) }}">{{ $student->subjects->isEmpty() ? 'Add' : 'Edit' }}
                    subject</a>
                <a class="btn btn-success m-1" href="{{ route('updatePoint', $student->id) }}">Update Point</a>
            </div>
            <table class="table table-bordered">
                <tr>
                    <td><strong>@lang('name'): </strong>{{ $student->name }}</td>
                    <td><strong>Avatar: </strong><img class="rounded-circle" src="{{ asset('images/' . $student->avatar) }}"
                            width="100px"></td>
                </tr>
                <tr>
                    <td><strong>Phone: </strong>{{ $student->phone }}</td>
                    <td><strong>Gender: </strong>{{ $student->gender == 1 ? 'Nam' : 'Nữ' }}</td>
                </tr>
                <tr>
                    <td><strong>Email: </strong>{{ $student->email }}</td>
                    <td><strong>Day of Birthday: </strong>{{ $student->birthday }}</td>
                </tr>
                <tr>
                    <td><strong>Faculty: </strong>{{ $student->faculty->name }}</td>
                    <td><strong>Registered the subject: </strong>
                        @foreach ($student->subjects as $subject)
                            <li>{{ $subject->name }}<strong class="float-end">{{ $subject->pivot->point }}
                                    point</strong></li>
                        @endforeach
                    </td>
                </tr>
            </table>
        </div>
    </main>
@endsection

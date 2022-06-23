@extends('layouts.main')
@include('layouts.flash_message')
@section('content')
<main id="main" class="main">

        <div class="card shadow mb-3">
            <div class="card-header py-3">
                <h3 class="m-1 font-weight-bold text-primary">Register the subject</h3>
                <h4 class="m-1 text-dark">Student: {{ $student->name }}</h4>
                <div class="float-right m-1">
                    <a class="btn btn-primary" href="{{ route('students.show', $student->id) }}"> Back</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <form action="{{ route('saveSubject', $student->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Subject Name</th>
                                    <th>Checkbox</th>
                                </tr>
                            </thead>
                            <tbody>
                                <div>
                                    @foreach ($subjects as $key => $subject)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $subject->name }}</td>
                                            <td><input type="checkbox" name="subjects[]" value="{{ $subject->id }}"
                                                    {{ $student->subjects->contains($subject->id) ? 'checked' : '' }}>
                                            </td>
                                        </tr>
                                    @endforeach
                                </div>
                            </tbody>
                        </table>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

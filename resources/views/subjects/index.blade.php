@extends('layouts.main')
@include('layouts.flash_message')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-3">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary">Subject List</h3>

                <div class="float-right">
                    <a class="btn btn-success" href="{{ route('subjects.create') }}"> Create subject</a>
                </div>
            </div>
            @yield('success')
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Subject Name</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $key =>$subject)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $subject->name }}</td>
                                    <td>
                                        {!! Form::model($subject, ['route' => ['subjects.destroy', $subject->id], 'method' => 'DELETE']) !!}
                                        <a class="btn btn-info"
                                            href="{{ route('subjects.show', $subject->id) }}">Show</a>

                                        <a class="btn btn-primary"
                                            href="{{ route('subjects.edit', $subject->id) }}">Edit</a>

                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}

                                        {!! Form::close() !!}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $subjects->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

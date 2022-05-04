@extends('layouts.main')
@include('layouts.flash_message')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-3">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary">Faculty CRUD</h3>

                <div class="float-right">
                    <a class="btn btn-success" href="{{ route('faculties.create') }}"> Create New Faculty</a>
                </div>
            </div>
            @yield('success')
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Faculty Name</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($faculties as $key =>$faculty)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $faculty->name }}</td>
                                    <td>
                                        {!! Form::model($faculty, ['route' => ['faculties.destroy', $faculty->id], 'method' => 'DELETE']) !!}
                                        <a class="btn btn-info"
                                            href="{{ route('faculties.show', $faculty->id) }}">Show</a>

                                        <a class="btn btn-primary"
                                            href="{{ route('faculties.edit', $faculty->id) }}">Edit</a>

                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}

                                        {!! Form::close() !!}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $faculties->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.main')
@include('layouts.flash_message')

@section('content')
    <main id="main" class="main">

        <div class="card shadow mb-3">
            <div class="card-header py-3 bg-light">
                <div class="row">
                    <div class="col">
                        <h3 class="fw-bold text-primary">Subject List</h3>
                    </div>
                    <div class="col">
                        <a class="btn btn-success float-end" href="{{ route('subjects.create') }}"><i
                                class="fa-solid fa-circle-plus"></i></a>
                    </div>
                </div>
            </div>
            @yield('success')
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Subject Name</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $key => $subject)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $subject->name }}</td>
                                    <td>
                                        {!! Form::model($subject, ['route' => ['subjects.destroy', $subject->id], 'method' => 'DELETE']) !!}
                                        <a class="btn btn-info" href="{{ route('subjects.show', $subject->id) }}"><i
                                                class="fa-regular fa-eye"></i></a>

                                        <a class="btn btn-warning" href="{{ route('subjects.edit', $subject->id) }}"><i
                                                class="fa-regular fa-pen-to-square"></i></a>
                                        {!! Form::button('<i class="fa-regular fa-trash-can"></i>', ['type' => 'submit', 'class' => 'btn btn-danger']) !!}
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
    </main>
@endsection

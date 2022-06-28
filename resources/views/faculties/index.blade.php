@extends('layouts.main')
@include('layouts.flash_message')
@section('content')
    <main id="main" class="main">
        <div class="card shadow mb-3">
            <div class="card-header py-3 bg-light">
                <div class="row">
                    <div class="col">
                        <h3 class="fw-bold text-primary">Faculty List</h3>
                    </div>
                    <div class="col">
                        <a class="btn btn-success float-end" href="{{ route('faculties.create') }}"><i
                                class="fa-solid fa-circle-plus"></i></a>
                    </div>
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
                            @foreach ($faculties as $key => $faculty)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $faculty->name }}</td>
                                    <td>
                                        {!! Form::model($faculty, ['route' => ['faculties.destroy', $faculty->id], 'method' => 'DELETE']) !!}
                                        <a class="btn btn-info" href="{{ route('faculties.show', $faculty->id) }}"><i
                                                class="fa-regular fa-eye"></i></a>
                                        <a class="btn btn-warning" href="{{ route('faculties.edit', $faculty->id) }}"><i
                                                class="fa-regular fa-pen-to-square"></i></a>
                                        @auth
                                            {!! Form::button('<i class="fa-regular fa-trash-can"></i>', ['type' => 'submit', 'class' => 'btn btn-danger']) !!}
                                        @endauth
                                        {{-- <button type="submit" class="btn btn-danger"><i
                                                class="fa-regular fa-trash-can"></i></button> --}}
                                        {!! Form::close() !!}
                                    </td>
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
    </main>
@endsection

@extends('layouts.main')
@include('layouts.flash_message')
@section('content')
    <div class="container-fluid">
        <div class="card shadow m-3 p-3">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="float-left">
                        <h2>{{ isset($faculty->id)?"Edit":"Add" }} Faculty</h2>
                    </div>
                    <div class="float-right">
                        <a class="btn btn-primary" href="{{ route('faculties.index') }}"> Back</a>
                    </div>
                </div>
            </div>
            @yield('error')
            {!! Form::model($faculty, ['route' => [$faculty->url(), $faculty->id], 'method' => $faculty->method()]) !!}
            <div class="mb-3">
                {!! Form::label('name', 'Name') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
            </div>
            <div class="mb-3">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

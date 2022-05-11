@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="card shadow m-3 p-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="float-left">
                        <h2> Show Faculty</h2>
                    </div>
                    <div class="float-right">
                        <a class="btn btn-primary" href="{{ route('faculties.index') }}"> Back</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        {{ $faculty->name }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

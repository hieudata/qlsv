@extends('layouts.main')

@section('content')
<main id="main" class="main">

        <div class="card shadow m-3 p-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="float-left">
                        <h2> Show Subject</h2>
                    </div>
                    <div class="float-right">
                        <a class="btn btn-primary" href="{{ route('subjects.index') }}"> Back</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        {{ $subject->name }}
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

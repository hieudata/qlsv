@extends('layouts.main')
@include('layouts.flash_message')
@section('content')
    <main id="main" class="main">
        <div class="card shadow mb-3">
            <div class="card-header py-3 bg-light">
                <div class="row">
                    <div class="col">
                        <h3 class="fw-bold text-primary"><a href="{{ route('students.index') }}">@lang('student list')</a></h3>
                    </div>
                    <div class="col">
                        <a class="btn btn-success float-end" href="{{ route('students.create') }}"><i
                                class="fa-solid fa-circle-plus"></i></a>
                    </div>
                </div>
            </div>
            @yield('success')
            {!! Form::open([
                'route' => 'students.index',
                'method' => 'GET',
                'enctype' => 'multipart/form-data',
                'class' => 'm-3',
                'id' => 'newForm',
            ]) !!}
            <div class="row">
                <div class="d-flex flex-row bd-highlight m-1">
                    <label class="m-1">@lang('range age'):</label>
                    {!! Form::number('age_from', request('age_from'), ['class' => 'm-1', 'placeholder' => 'Age From']) !!}
                    {!! Form::number('age_to', request('age_to'), ['class' => 'm-1', 'placeholder' => 'Age To']) !!}
                </div>
                <div class="d-flex flex-row bd-highlight m-1">
                    <label class="m-1">@lang('range point'):</label>
                    {!! Form::number('point_from', request('point_from'), ['class' => 'm-1', 'placeholder' => 'Point From']) !!}
                    {!! Form::number('point_to', request('point_to'), ['class' => 'm-1', 'placeholder' => 'Point To']) !!}
                </div>
                <div class="d-flex flex-row bd-highlight m-1">
                    <label class="mx-1">@lang('select brand'): </label>
                    <div class="form-check form-check-inline">
                        {!! Form::checkbox('viettel', null, request('viettel') == 'on' ? 'checked' : '', [
                            'class' => 'form-check-input',
                        ]) !!}
                        <label class="form-check-label">Viettel</label>
                    </div>
                    <div class="form-check form-check-inline">
                        {!! Form::checkbox('mobi', null, request('mobi') == 'on' ? 'checked' : '', ['class' => 'form-check-input']) !!}
                        <label class="form-check-label">Mobi</label>
                    </div>
                    <div class="form-check form-check-inline">
                        {!! Form::checkbox('vina', null, request('vina') == 'on' ? 'checked' : '', ['class' => 'form-check-input']) !!}
                        <label class="form-check-label">Vina</label>
                    </div>
                </div>
                <div class="d-flex flex-row bd-highlight m-1">
                    <label class="m-1">@lang('select category'): </label>
                    {!! Form::select('category', ['1' => 'Study All', '2' => 'Not All'], null, [
                        'placeholder' => '--Choose--',
                        'class' => 'm-1',
                        'id' => 'category',
                    ]) !!}
                </div>
                <div class="d-flex flex-row bd-highlight m-1">
                    <label class="m-1">Show {!! Form::select('paginate', ['1' => '10', '2' => '100', '3' => '500'], null, ['class' => 'm-1']) !!} rows: </label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary m-1"><i class="fa-solid fa-filter"></i></button>
            <input type="button" class="btn btn-secondary m-1" onclick="newFunction()" value="Clear">
            <a href="{{ route('sendmail') }}" type="submit" class="btn btn-warning m-1"><i
                    class="fa-solid fa-envelope"></i></a>
            {!! Form::close() !!}
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-striped" width="100%" cellspacing="0">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>@lang('avatar')</th>
                                <th>@lang('name')</th>
                                <th>@lang('phone')</th>
                                <th>@lang('gender')</th>
                                <th>@lang('day of birthday')</th>
                                <th>@lang('faculty')</th>
                                <th>@lang('action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $key => $student)
                                <tr id="tr{{ $student->id }}">
                                    <td>{{ $student->id }}</td>
                                    <td><img src="{{ asset('images/' . $student->avatar) }}" alt="" width="80px"
                                            class="rounded-circle"></td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->phone }}</td>
                                    <td>{{ $student->gender == 1 ? 'Male' : 'Female' }}</td>
                                    <td>{{ $student->birthday }}</td>
                                    <td>{{ $student->faculty->name }}</td>
                                    <td>
                                        {!! Form::model($student, ['route' => ['students.destroy', $student->id], 'method' => 'DELETE']) !!}
                                        <a class="btn btn-info" href="{{ route('student.slug', $student->slug) }}"
                                            id="ajax"><i class="fa-regular fa-eye"></i></a>
                                        <a class="btn btn-warning" href="{{ route('students.edit', $student->id) }}"><i
                                                class="fa-regular fa-pen-to-square"></i></a>
                                        <a class="btn btn-success" href="javascript:void(0)"
                                            onclick="editStudent({{ $student->id }})"><i class="fa-solid fa-pen"></i></a>
                                        {!! Form::button('<i class="fa-regular fa-trash-can"></i>', ['type' => 'submit', 'class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $students->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- Update Modal -->
        <div class="modal fade " id="studentEditModal" data-toggle="modal" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white">Edit Student</h5>
                        <button type="button" class="btn-close h3" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    @yield('success')
                    <div class="alert alert-danger" style="display:none"></div>
                    <div class="modal-body">
                        <form id="studentEditForm">
                            @csrf
                            <div class="row">
                                <input type="hidden" id="id" name="id">
                                <div class="col-md-6 p-3">
                                    {!! Form::label('name', 'Student Name') !!}
                                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Full Name']) !!}
                                </div>
                                <div class="col-md-6 p-3">
                                    {!! Form::label('avatar', 'Avatar') !!}
                                    <img id="imgPreview" width="100px" class="rounded-circle">
                                    {!! Form::file('avatar') !!}
                                </div>
                                <div class="col-md-6 p-3">
                                    {!! Form::label('phone', 'Phone Number') !!}
                                    {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Number']) !!}
                                </div>
                                <div class="col-md-6 p-3">
                                    {!! Form::label('gender', 'Gender', ['class' => 'd-block mb-2']) !!}
                                    {!! Form::radio('gender', 1) !!} Male
                                    {!! Form::radio('gender', 0, true, ['class' => 'ms-3']) !!} Female
                                </div>
                                <div class="col-md-6 p-3">
                                    {!! Form::label('email', 'Email') !!}
                                    <input type="text" class="form-control" id="email" name="email">
                                </div>
                                <div class="col-md-6 p-3">
                                    {!! Form::label('birhday', 'Birthday') !!}
                                    {!! Form::date('birthday', $student->birthday, ['class' => 'form-control']) !!}
                                </div>
                                <div class="col-md-6 p-3">
                                    {!! Form::label('faculty_id', 'Faculty') !!}
                                    {!! Form::select('faculty_id', $faculties, null, ['class' => 'form-control', 'id' => 'faculty_id']) !!}
                                </div>
                                <div class="col-md-6 p-3 mt-2">
                                    <button type="button" class="btn btn-secondary m-2"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary m-2">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        function editStudent(id) {
            $.get('students/ajax/' + id, function(student) {
                $.each(student, function(key, value) {
                    if (key !== "avatar") {
                        $("#" + key).val(value);
                    }
                });

                $("input[type=radio][name='gender'][value=" + student.gender + "]").prop('checked', true);
                $('#imgPreview').attr('src', 'images/' + student.avatar);
                $("#studentEditModal").modal("toggle");
            });
        }

        $("#studentEditForm").submit(function(e) {
            e.preventDefault();

            formData = new FormData($("#studentEditForm")[0])

            formData.append('avatar', avatar.files[0])
            formData.append('_token', $("input[name=_token]").val())

            $.ajax({
                url: "{{ route('student.update') }}",
                method: 'post',
                contentType: false,
                processData: false,
                data: formData,
                success: function(data) {
                    $("#tr" + data.id + ' img')[0].src = "{{ asset('images') }}" + '/' + data.avatar;
                    $("#tr" + data.id + ' td:nth-child(3)').text(data.name);
                    $("#tr" + data.id + ' td:nth-child(4)').html(data.phone);
                    $("#tr" + data.id + ' td:nth-child(5)').html(data.gender == 1 ? "Male" : "Female");
                    $("#tr" + data.id + ' td:nth-child(6)').html(data.birthday);
                    let faculty_id = $("#faculty_id option:selected").text();
                    $("#tr" + data.id + ' td:nth-child(7)').text(faculty_id);
                    $("#tr" + data.id + ' #ajax').attr("href", window.location.href + '/' + data.slug);
                    // alert(message)
                    $("#studentEditModal").modal("toggle");
                    $("#studentEditForm")[0].reset();
                }
            });
        });
    </script>
@endsection

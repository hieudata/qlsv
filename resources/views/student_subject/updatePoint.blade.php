@extends('layouts.main')
@section('content')
    <main id="main" class="main">
        <div class="card shadow m-3 p-3">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button class="btn btn-primary add-select" type="button">Add</button>
              </div>
            {{-- <a class="btn btn-primary" href="{{ route('students.show', $student->id) }}"> Back</a> --}}
            <form action="{{ route('savePoint', $student->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <table>
                    <thead>
                        <div class="row m-2">
                            <div class="form-group col-4">Subject</div>
                            <div class="form-group col-4">Point</div>
                            <div class="form-group col-4">Delete</div>
                        </div>
                    </thead>
                    <tbody class="addMore">
                        <div class="row m-2">
                            <div class="form-group col-4">
                                <select name="subject_id[]" id="tag_id" class="tag_id form-control show-tick">
                                    @foreach ($student->subjects as $subject)
                                        <option data-id="{{ $subject->pivot->point }}"
                                            value="{{ $subject->pivot->subject_id }}">
                                            {{ $subject->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <input type="text" name="point[]" id="point" class="form-control point" value="">
                            </div>
                            <div class="form-group col-4">
                                <button type="button" class="btn btn-danger">Remove</button>
                            </div>
                        </div>
                        {{-- <div class="row m-2">
                        <div class="form-group col-4">
                            <select name="" id="tag_id" class="tag_id form-control show-tick">
                                <option selected="true" disabled="disabled">--Select item--</option>
                                @foreach ($student->subjects as $subject)
                                    <option name='subject_id' data-id="{{ $subject->pivot->point }}"
                                        value="{{ $subject->pivot->subject_id }}">
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-4">
                            <input type="text" name="point" id="point" class="form-control point">
                        </div>
                        <div class="form-group col-4">
                            <button type="button" class="btn btn-danger">Remove</button>
                        </div>
                    </div> --}}
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(document).on("click", ".add-select", function() {
                var tag = $('.tag_id').html();
                var addUpdate =
                    '<div class="row"><div class="col"><select class="form-select tag_id" name="tag_id[]">' +
                    tag + '</select></div>' +
                    '<div class="col"><input type="number" name="point[]" id="point" class="form-control point"></div>' +
                    '<div class="col"><button type="button" class="btn btn-danger delete">Remove</button></div></div>';
                $('.addMore').append(addUpdate);
            });
            $('.addMore').delegate('.delete', 'click', function() {
                $(this).parent().parent().remove();
            })
            $('.tag_id').on('change', function() {
                var tr = $(this).parent().parent();
                var option = $(this).find(':selected').attr('data-id');
                tr.find('#point').val(option);

            });
        });
    </script>
@endsection

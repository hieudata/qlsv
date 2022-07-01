@extends('layouts.main')
@section('content')
    <style>
        option:disabled {
            display: none;
        }
    </style>
    <main id="main" class="main">
        <div class="card shadow m-3 p-3">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button class="btn btn-primary add-select" type="button">Add</button>
            </div>
            <h3>Student: {{ $student->name }} - ID: {{ $student->id }}</h3>
            {{-- <a class="btn btn-primary" href="{{ route('students.show', $student->id) }}"> Back</a> --}}
            <em class="d-flex justify-content-center text-danger d-none">Bạn đã chọn hết các môn</em>
            <form action="{{ route('savePoint', $student->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="table table-sm">
                    {{-- <div class="thead">
                        <div class="row m-2">
                            <div class="form-group col-4">Subject</div>
                            <div class="form-group col-4">Point</div>
                            <div class="form-group col-4">Delete</div>
                        </div>
                    </div> --}}
                    <div class="addMore">
                        <div class="row m-2" id="add" style="display: none">
                            <div class="form-group col-4">
                                <select name="subject_id[]" id="subject_id" class="form-select subject_id count">
                                    {{-- <option></option> --}}
                                    @foreach ($student->subjects as $subject)
                                        <option data-id="{{ $subject->pivot->point }}"
                                            value="{{ $subject->pivot->subject_id }}">
                                            {{ $subject->id }} - {{ $subject->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <input type="text" name="point[]" id="point" class="form-control point"
                                    value="">
                            </div>
                            <div class="form-group col-4">
                                <button type="button" class="btn btn-danger">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary ">Save</button>
                </div>
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            form = $('div#add').html();
            $(".add-select").on("click", function() {
                // var len = $('tbody#formadd tr').length;
                // var subject = $('p#count-subject').html();
                $("div#add").css('display', 'block').append("<div class='row'>"+ form +"</div>");
            });

            // disable button
            if ($('select.count option').length == $('div.addMore').children().length) {
                $("button.add-select").attr("disabled", "disabled");
                $("main#main em").removeClass('d-none');
            }

            // select
            $("div.addMore").each(function(index, element) {
                $selects = $("select#subject_id");
                $selects.on("change", function() {
                    if ($selects.length <= 0) return;
                    let selected = [];
                    $selects.each(function(index, select) {
                        if (select.value !== "") {
                            selected.push(select.value);
                        }
                    });

                    $("div.addMore").find("option").prop("disabled", false);
                    for (let index in selected) {
                        $("div.addMore").find('option[value="' + selected[index] +
                            '"]:not(:selected)').prop(
                            "disabled", true);
                    }
                });
                $selects.trigger("change");
            });

            // Xóa remove
            $('.addMore').delegate('.delete', 'click', function() {
                $(this).parent().parent().remove();
                if ($('select.count option').length !== $('div.addMore').children().length) {
                    $("button.add-select").attr("disabled", false);
                    $("main#main em").addClass('d-none');
                }
            });

            $('#subject_id').on('change', function() {
                let tr = $(this).parent().parent();
                let option = $(this).find(':selected').attr('data-id');
                tr.find('#point').val(option);
            });
        });
    </script>
@endsection

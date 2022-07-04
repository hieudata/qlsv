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
            <em class="usercheck" style="color: red;"></em>
            <h3>Student: {{ $student->name }} - ID: {{ $student->id }}</h3>
            {{-- <a class="btn btn-primary" href="{{ route('students.show', $student->id) }}"> Back</a> --}}
            <form action="{{ route('savePoint', $student->id) }}" method="POST" enctype="multipart/form-data"
                id="formSubmit">
                @csrf
                <div class="table table-sm">
                    <div class="thead">
                        <div class="row m-2">
                            <div class="form-group col-4">Subject</div>
                            <div class="form-group col-4">Point</div>
                            <div class="form-group col-4">Delete</div>
                        </div>
                    </div>
                    <div class="addMore">
                        <div class="row m-2">
                            <div class="form-group col-4">
                                <select name="subject_id[]" id="subject_id" class="form-select subject_id count">
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
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary" id="submitbtn">Save</button>
                </div>
                <p class="text-danger d-none m-2 fst-italic"><i class="fa-solid fa-circle-xmark text-danger m-1"></i>Bạn đã
                    add hết môn rồi!</p>
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            function changeSelect() {
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
            }
            // Nút ADD
            $(document).on("click", ".add-select", function() {
                let tag = $('#subject_id').html();
                let addUpdate =
                    `<div class="row m-2">` +
                    `<div class="form-group col-4">` +
                    `<select name="subject_id[]" id="subject_id" class="form-select subject_id"><option>Select-subject</option>` +
                    tag +
                    `</select>` +
                    `</div>` +
                    `<div class="form-group col-4">` +
                    `<input type="text" name="point[]" id="point" class="form-control point" value="">` +
                    `</div>` +
                    `<div class="form-group col-4">` +
                    `<button type="button" class="btn btn-danger delete">Remove</button>` +
                    `</div>` +
                    `</div>`;
                $('.addMore').append(addUpdate);

                // disable button
                if ($('select.count option').length == $('div.addMore').children().length) {
                    $("button.add-select").addClass('d-none');
                    $("main#main p").removeClass('d-none').addClass('d-inline');
                    let timerInterval
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...!!!',
                        text: 'Bạn đã add hết môn rồi!',
                    });
                }
                // select
                changeSelect();
            });

            // Xóa remove
            $('.addMore').delegate('.delete', 'click', function() {
                $(this).parent().parent().remove();
                if ($('select.count option').length !== $('div.addMore').children().length) {
                    $("button.add-select").removeClass('d-none');
                    $("main#main p").addClass('d-none');
                }
                changeSelect();
            });

            // $('#subject_id').on('change', function() {
            //     let tr = $(this).parent().parent();
            //     let option = $(this).find(':selected').attr('data-id');
            //     tr.find('#point').val(option);
            // });

            // Validate Form
            $("em").hide();
            usernameError = true;
            // $('[name="point[]"]').keyup(function() {
            //     validateUsername();
            // });

            function validateUsername() {
                var usernameValue = $('[name="point[]"]');
                var reg = new RegExp('^[0-9]*$');
                for (i = 0; i < usernameValue.length; i++) {
                    if (usernameValue[i].value === "") {
                        $("em").show();
                        $("em").html("*Point is missing");
                        usernameError = false;
                        return false;
                    } else if (usernameValue[i].value < 0 || usernameValue[i].value > 10) {
                        $("em").show();
                        $("em").html("*Diem phai nam trong khoang 0 - 10");
                        usernameError = false;
                        return false;
                    } else if (reg.test(usernameValue[i].value) === false) {
                        $("em").show();
                        $("em").html("*Gia tri khong hop le!!");
                        usernameError = false;
                        return false;
                    } else {
                        $("em").hide();
                        usernameError = true;
                    }
                }
            }
            $("#formSubmit").submit(function() {
                validateUsername();
                if (usernameError == true) {
                    return true;
                } else {
                    return false;
                }
            });
        });
    </script>
@endsection

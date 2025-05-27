<x-guest-layout>
    <div class="row">
        <div class="col-lg-9 mx-auto mt-5 ">
            <div class="r-form">
                <div class="col-md-12">
                    <div id="due_div" class="my_hide" style="display:none; float: right;margin-bottom: 2%;">
                        <blink class="my-element" style="display: flex;align-items:end;">
                            <h6 style="margin-right:12px; ">Due Date:</h6>
                            <h6 id="due_date" style=""></h6>
                        </blink>
                    </div>
                </div>
                <form action="{{ route('existing.course.details') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <div class="col-sm-12 w-100">
                            <input class="input" id="roll_no" type="text" name="roll_no" required placeholder="">
                            <label class="user-label">Roll No<span style="color:red">*</span></label>
                        </div>
                    </div>
                    <div class="input-group my_hide" style="display:none;">
                        <div class="col-sm-12 w-100">
                            <input class="input" id="name" type="text" name="name" readonly>
                            <label class="user-label">Name<span style="color:red">*</span></label>
                        </div>
                    </div>
                    <div class="input-group my_hide" style="display:none;">
                        <div class="col-sm-12 w-100">
                            <input class="input" id="mobile" type="text" name="mobile" readonly placeholder="">
                            <label class="user-label">Mobile No<span style="color:red">*</span></label>
                        </div>
                    </div>

                    <div class="input-group">
                        <div class="col-sm-12 w-100">
                            <input class="input" type="text" id="email" name="email" autocomplete="off"
                                autofocus="off" oninput="this.value=this.value.toLowerCase()">
                            <label class="user-label">Please Enter Your Registered Email ID<span
                                    style="color:red">*</span></label>
                        </div>
                    </div>
                    <div class="input-group" style="display:none;">
                        <div class="col-sm-12 w-100">
                            <label class="user-label">Due Date<span style="color:red">*</span></label>
                            <input class="input" id="due" type="text" name="due" readonly
                                style="background-color: transparent;">
                        </div>
                    </div>
                    <div class="input-group my_hide" style="display:none;">
                        <div class="col-sm-12 w-100">
                            <div class="col-sm-3">
                                <label style="color: #ee4545;">Payment Type *</label>
                            </div>
                            <div class="col-sm-6 d-flex align-items-center">
                                <input type="radio" name="payment_type" id="payment_type" value="0" checked
                                    required style="float: left;">
                                <span
                                    style="padding-bottom: 0px;display: inline-block;float: left;padding-left: 2%;color: #ee4545;padding-right: 6%;">Monthly
                                    Payment</span>
                            </div>
                        </div>
                    </div>
                    <input class="input" id="course_id" type="hidden" name="course_id">
                    <div class="input-group my_hide" style="display:none;">
                        <div class="col-sm-12 w-100">
                            <label class="user-label">Course<span style="color:red">*</span></label>
                            <input class="input" id="course" type="text" name="course" placeholder="" readonly
                                style="background-color: transparent;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <button type="submit" name="submit" id="submit_button" class="act-btn"
                                style="width: 100%; margin-left:0;margin-right:0;">NEXT</button>
                        </div>
                        <div class="col-sm-6">
                            <button type="button" name="button" id="view_button" class="act-btn"
                                style="width: 100%; margin-left:0;margin-right:0;" onclick="get_student_details();">
                                View Details
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        blink {
            animation: blinker 1s linear infinite;
        }

        @keyframes blinker {
            70% {
                opacity: 0.0;
            }
        }

        @keyframes blink {
            to {
                color: #be1e2e;
            }
        }

        .my-element {
            color: black;
            animation: blink 1s steps(2, start) infinite;
        }
    </style>
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
        <script>
            $(document).ready(function() {
                $(".my_hide").css("display", "none");
            });

            function get_student_details() {
                var roll_no = $('#roll_no').val();
                var email = $('#email').val();
                if (roll_no == '' || email == '') {
                    alert('Please enter Roll No and Email ID');
                    return false;
                }
                $.ajax({
                    type: "POST",
                    url: "{{ route('get.student.details') }}",
                    data: {
                        roll_no: roll_no,
                        email: email,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status) {
                            $('#name').val(response.data.name);
                            $('#mobile').val(response.data.phone);
                            $('#course').val(response.data.studentcourse.course_name);
                            $('#course_id').val(response.data.course_id);
                            $('#due').val(response.data.due_date);
                            $('#due_date').text(moment(response.data.due_date).format('DD-MM-YYYY'));
                            $('#due_div').css("display", "block");
                            $(".my_hide").css("display", "block");
                        } else {
                            alert('Student not found');
                        }
                    }
                });
            }
        </script>
    @endpush
    @if (Session::has('notfound'))
        <script>
            $(document).ready(function onDocumentReady() {
                alert("student not found with this roll no & email");
            });
        </script>
    @endif
</x-guest-layout>

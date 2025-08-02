<x-guest-layout>
    <style>
        .gradient-button {
            background: linear-gradient(45deg, red, rgb(255, 234, 0));
            background-size: 400% 400%;
            animation: gradientAnimation 3s ease infinite;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
        }

        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }
    </style>
    <!-- Hero Section -->
    <section class="hero-section" style="height: 35vh;">
        <div class="container">
            <div class="hero-content">
                {{-- <h1 class="hero-title">Select the course of your choice</h1> --}}
            </div>
        </div>
    </section>

    <!-- Enhanced Form Section -->
    <section class="form-section">
        <div class="auth-container">
            <!-- Login Form -->
            <div class="form-container login-form animated">
                <div class="d-flex justify-content-between">
                    <h1 class="auth-title">Welcome Back</h1>
                    <div id="due_div" class="my_hide" style="display:none; float: right;margin-bottom: 2%;">
                        <blink class="my-element gradient-button" style="display: flex;align-items:end;">
                            <h6 class="mb-0" style="margin-right:12px;">Due Date:</h6>
                            <h6 class="mb-0" id="due_date" style=""></h6>
                        </blink>
                    </div>
                </div>
                {{-- <p class="auth-description">
                    Sign in to continue your musical journey with Riyaaz Online
                </p> --}}

                <form action="{{ route('existing.course.details') }}" method="POST">
                    @csrf
                    <div class="form-group animated delay-1 mb-3">
                        <i class="fas fa-id-card input-icon"></i>
                        <input id="roll_no" type="text" name="roll_no" class="form-control"
                            placeholder="Roll number" required />
                    </div>
                    <div class="form-group animated delay-1 mb-3 my_hide" style="display:none;">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" class="form-control" id="name" name="name" readonly />
                    </div>
                    <div class="form-group animated delay-1 mb-3 my_hide" style="display:none;">
                        <i class="fas fa-phone input-icon"></i>
                        <input type="text" class="form-control" name="mobile" id="mobile" readonly />
                    </div>
                    <div class="form-group animated delay-1 mb-3">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" class="form-control" id="email" name="email" autofocus="off"
                            placeholder="Please enter your registered email ID" required />
                    </div>
                    <input class="input" id="course_id" type="hidden" name="course_id">
                    <div class="form-group animated delay-1 mb-3 my_hide" style="display:none;">
                        <i class="fa-solid fa-music input-icon"></i>
                        <input id="course" type="text" name="course" class="form-control" autofocus="off"
                            readonly />
                    </div>
                    <div class="form-group animated delay-1 mb-3 my_hide" style="display:none;">
                        <i class="fa-solid fa-money-bill-1-wave input-icon"></i>
                        <i class="fas fa-chevron-down select-icon"></i>
                        <select class="form-control" required name="payment_type" id="payment_type">
                            <option value="">Payment Type</option>
                            <option value="0">Monthly</option>
                            <option value="1">Quaterly</option>
                            <option value="2">Half Yearly</option>
                        </select>
                    </div>
                    @if ($errors->has('payment_type'))
                        <span style="font-size: 10px; color:red;">{{ $errors->first('payment_type') }}</span>
                    @endif
                    <div class="row">
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-primary animated delay-2 w-100 h-100"
                                onclick="get_student_details();">
                                <i class="fas fa-info-circle me-2"></i> View Details
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-auth animated delay-2">
                                <i class="fas fa-arrow-right me-2"></i> Next
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Welcome Panel -->
            <div class="welcome-panel animated delay-1">
                <img src="" alt="" />
            </div>
        </div>
    </section>
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
                            $('#name').val(response.data.f_name + ' ' + response.data.l_name);
                            $('#mobile').val(response.data.phone);
                            $('#course').val(response.data.studentcourse.course_name);
                            $('#course_id').val(response.data.course_id);
                            $('#due').val(response.data.studentcourse.due_date);
                            $('#payment_type').val(response.data.payment_type);
                            $('#due_date').text(moment(response.data.studentcourse.due_date).format('DD-MM-YYYY'));
                            $('#due_div').css("display", "block");
                            $(".my_hide").css("display", "block");
                            let selected = response.data.payment_type;
                            if (selected == 0) {
                                $('#payment_type').html(`
                                    <option value="">Payment Type</option>
                                    <option value="0">Monthly</option>
                                    <option value="1">Quaterly</option>
                                    <option value="2">Half Yearly</option>
                                `).val(selected); // Set value after appending
                            } else {
                                let text = selected == 1 ? 'Quaterly' : 'Half Yearly';
                                $('#payment_type').html(`
                                    <option value="${selected}">${text}</option>
                                `).val(selected); // Set value after appending
                            }
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

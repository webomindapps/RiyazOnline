<x-guest-layout>
    <div class="container-fluid comp-reg-form">
        <div class="row">
            <div class="col-lg-9 mx-auto mt-5 mb-4 ">
                <div class="r-form">
                    {{-- @if ($student->reg_status == 1)
                        <h2 class="fs-title"
                            style="font-size: 19px;color: #ec1c24;font-weight: 400;margin-top: 15%;margin-bottom: 15%;text-align:center">
                            You have already completed your registration.</h2>
                    @else --}}
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                    data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                    aria-selected="true">Step 1</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" disabled id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                    type="button" role="tab" aria-controls="profile" aria-selected="false">
                                    Step 2
                                </button>
                            </li>
                        </ul>
                        <form action="{{ route('complete.registration', $student->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel"
                                    aria-labelledby="home-tab">
                                    <h5 class="my-3">STUDENT DETAILS</h5>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label>First Name
                                                <span style="color:red">*</span>
                                            </label>
                                            <div class="form-group animated delay-1">
                                                <i class="fas fa-user input-icon"></i>
                                                <input class="form-control" name="f_name" id="f_name"
                                                    value="{{ $student->f_name }}"onkeypress="return isalpha(event)"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Last Name
                                                <span style="color:red">*</span>
                                            </label>
                                            <div class="form-group animated delay-1">
                                                <i class="fas fa-user input-icon"></i>
                                                <input class="form-control" name="l_name" id="l_name"
                                                    value="{{ $student->l_name }}"onkeypress="return isalpha(event)"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Email<span style="color:red">*</span></label>
                                            <div class="form-group animated delay-1">
                                                <i class="fas fa-envelope input-icon"></i>
                                                <input class="form-control" name="email" id="email"
                                                    value="{{ $student->email }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Phone<span style="color:red">*</span></label>
                                            <div class="form-group animated delay-1">
                                                <i class="fas fa-phone input-icon"></i>
                                                <input class="form-control" name="phone" id="phone"
                                                    value="{{ $student->phone }}" readonly
                                                    onchange="check_mobile_available(this.id)"
                                                    placeholder="Contact No 1*" maxlength="10"
                                                    onkeypress="return isNumber(event)">
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="display:none">
                                            <input class="form-control" type="text" name="phone_2" id="phone_2"
                                                value="{{ $student->phone_2 }}" placeholder="Contact No 2"
                                                maxlength="10" onkeypress="return isNumber(event)">
                                        </div>
                                        <div class="col-md-6 ">
                                            <label>Whatsapp No<span style="color:red">*</span></label>
                                            <div class="form-group animated delay-1">
                                                <i class="fas fa-phone input-icon"></i>
                                                <input class="form-control" type="text" name="whatsapp_no"
                                                    id="whatsapp_no" maxlength="10" onkeypress="return isNumber(event)"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>
                                                Photo
                                                <span style="color:red">*</span>
                                                <span
                                                    style="font-size: 10px;font-weight: 500;color: #000;">(jpg,png,jpeg)</span>
                                            </label>
                                            <input class="form-control" type="file" id="file" name="photo"
                                                onchange="validate_image();" accept="image/*" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Date of Birth
                                                <span style="color:red">*</span>
                                            </label>
                                            <div class="form-group animated delay-1">
                                                <i class="fa-solid fa-calendar-days input-icon"></i>
                                                <input class="form-control datepicker hasDatepicker" id="dob"
                                                    type="date" name="dob" onchange="calculate_age();"
                                                    max="2025-05-26" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Age<span style="color:red">*</span></label>
                                            <select name="age" required id="age"
                                                style="border: 1px solid #e4e3e7;width:100%;border-radius: 7px;box-shadow: none;padding: 14px 15px;font-size: 14px;border: 1px solid #ff430442;color: #656565;background: #fff;">
                                                <option value=""> Select Age</option>
                                                @for ($i = 3; $i <= 18; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ $student->age == $i ? 'selected' : '' }}>
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                                <option value="Adult"
                                                    {{ $student->age == 'Adult' ? 'selected' : '' }}>
                                                    Adult
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Gender<span style="color:red">*</span></label>
                                            <select name="gender" id="gender"
                                                style="border: 1px solid #e4e3e7;width:100%;border-radius: 7px;box-shadow: none;padding: 14px 15px;font-size: 14px;border: 1px solid #ff430442;color: #656565;background: #fff;"
                                                fdprocessedid="1njazb">
                                                <option value=""> Gender</option>
                                                <option value="0" selected>Male</option>
                                                <option value="1">Female</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <button type="button" class="act-btn" class="act-btn"
                                                style="background: #ec1c24;color:#fff;"
                                                onclick="validate_form();">Next</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel"
                                    aria-labelledby="profile-tab">
                                    <h5 class="my-3">PERSONAL DETAILS</h5>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label>Country<span style="color:red">*</span></label>
                                            <select name="country_id" required id="country"
                                                style="border: 1px solid #e4e3e7;width:100%;border-radius: 7px;box-shadow: none;padding: 14px 15px;font-size: 14px;border: 1px solid #ff430442;color: #656565;background: #fff;">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ $country->id == $student->country_id ? 'selected' : '' }}>
                                                        {{ $country->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>State<span style="color:red">*</span></label>
                                            <select name="state_id" required id="state"
                                                style="border: 1px solid #e4e3e7;width:100%;border-radius: 7px;box-shadow: none;padding: 14px 15px;font-size: 14px;border: 1px solid #ff430442;color: #656565;background: #fff;">
                                                <option value="">Select State</option>
                                                <option value="{{ $state?->id }}" selected>{{ $state?->name }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>City<span style="color:red">*</span></label>
                                            <div class="form-group">
                                                <input class="form-control" name="text" id="city"
                                                    style="padding: 14px 15px;font-size: 14px;"
                                                    value="{{ $student->city }}" required>
                                            </div>
                                        </div>
                                        @if ($student->age != 'Adult')
                                            <div class="col-md-6">
                                                <label>Father Name</label>
                                                <input class="form-control" type="text" name="father_name"
                                                    id="father_name" onkeypress="return isalpha(event)">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Mother Name</label>
                                                <input class="form-control" type="text" name="mother_name"
                                                    id="mother_name" onkeypress="return isalpha(event)">
                                            </div>
                                        @endif
                                        <div class="col-md-6">
                                            <label for="current_address" class="form-label">
                                                Current Address <span style="color: red">*</span><br>
                                                <small style="font-size: 10px; font-weight: 500; color: #000;">
                                                    (Ensure you fill in your complete address)
                                                </small>
                                            </label>
                                            <textarea id="current_address" name="current_address" class="form-control custom-control" required
                                                style="border-radius: 7px; border: 1px solid #ff430442; padding-left:5px;">{{$student->current_address}}</textarea>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="d-flex justify-content-between">
                                                <label for="permanent_address" class="form-label">
                                                    Permanent Address <span style="color: red">*</span><br>
                                                    <small style="font-size: 10px; font-weight: 500; color: #000;">
                                                        (Ensure you fill in your complete address)
                                                    </small>
                                                </label>
                                                <div class="">
                                                    <input type="checkbox" class="form-check-input me-2 d-none"
                                                        id="sameAsCurrent" onclick="copyAddress()">
                                                    <label class="form-check-label btn btn-info" for="sameAsCurrent">
                                                        Same as Current Address
                                                    </label>
                                                </div>
                                            </div>

                                            <textarea id="permanent_address" name="permanent_address" class="form-control custom-control" required
                                                style="border-radius: 7px; border: 1px solid #ff430442; padding-left:5px;"></textarea>
                                        </div>
                                        <div class="col-md-6 ">
                                            <label>Emergency Contact Person Name
                                                <span style="color:red">*</span><br>
                                                <span style="font-size: 10px;font-weight: 500;color: #000;">
                                                    .
                                                </span>
                                            </label>
                                            <input class="form-control" type="text" name="emg_contact_person"
                                                style="padding-left:5px;" id="emg_contact_name"
                                                onkeypress="return isalpha(event)" required>
                                        </div>
                                        <div class="col-md-6 ">
                                            <label>Emergency Contact Person Relation
                                                <span style="color:red">*</span><br>
                                                <span style="font-size: 10px;font-weight: 500;color: #000;">
                                                    ( Father / Mother / Brother / Spouse etc )
                                                </span>
                                            </label>
                                            <input class="form-control" type="text"
                                                name="emg_relation"style="padding-left:5px;" id="emg_relation"
                                                onkeypress="return isalpha(event)" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label>Emergency Contact No
                                                <span style="color:red">*</span><br>
                                                <span style="font-size: 10px;font-weight: 500;color: #000;">
                                                    ( Incase your number is not reachable, we will reach out to this
                                                    number
                                                    )
                                                </span>
                                            </label>
                                            <div class="form-group animated delay-1">
                                                <i class="fas fa-phone input-icon"></i>
                                                <input class="form-control" type="text" name="emg_contact_no"
                                                    id="emg_phone" maxlength="10" onkeypress="return isNumber(event)"
                                                    onchange="check_emg_contact_no();" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12 ">
                                            <button type="button" class="act-btn"
                                                style="background: #ec1c24;color:#fff;">Cancel</button>
                                            <button type="submit" class="act-btn"
                                                style="background: #ec1c24;color:#fff;">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    {{-- @endif --}}
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function validate_form() {
                let f_name = $("#f_name").val().trim();
                let l_name = $("#l_name").val().trim();
                email = $("#email").val();
                phone = $("#phone").val();
                file = $("#file").val();
                dob = $("#dob").val();
                age = $("#age").val();
                gender = $("#gender").val();
                whatsapp_no = $("#whatsapp_no").val();
                if (f_name === "" || l_name === "" || email == "" || phone == "" || file == "" || dob == "" || age == "" || gender == "" ||
                    whatsapp_no == "") {
                    alert("Please fill in all the mandatory (*) fields");
                    return;
                } else {
                    // const nextTab = document.getElementById("profile-tab");
                    // nextTab.click();
                    var tab = new bootstrap.Tab(document.querySelector('#profile-tab'));
                    tab.show();
                }
            }

            function validate_image() {
                var ext = $('#file').val().split('.').pop().toLowerCase();
                if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
                    alert('Invalid Image !');
                    $('#file').val("");
                } else {
                    var file_size = $('#file')[0].files[0].size;
                    if (file_size > 2097152) {
                        alert("File Size Should Below 2mb");
                        $('#file').val("");
                    }
                }
            }

            function isalpha(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;

                if (charCode == 32) {
                    return true;
                } else if (charCode > 31 && (charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122) || charCode ==
                    13) {
                    return false;
                }
            }

            function isNumber(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
            }
            $(document).ready(function() {
                $('#sameAsCurrent').on('change', function() {
                    if ($(this).is(':checked')) {
                        $('#permanent_address').val($('#current_address').val()).prop('readonly', true);
                    } else {
                        $('#permanent_address').val('').prop('readonly', false);
                    }
                });

                $('#current_address').on('input', function() {
                    if ($('#sameAsCurrent').is(':checked')) {
                        $('#permanent_address').val($(this).val());
                    }
                });
            });
            $('#country').on('change', function() {
                var country_id = $(this).val();
                if (country_id) {
                    $.ajax({
                        url: "{{ url('/') }}/get-states/" + country_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#state').empty().append(
                                '<option selected value="">Select State</option>');
                            $.each(data, function(key, value) {
                                $('#state').append('<option value="' + value.id + '">' + value
                                    .name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#state').empty().append('<option selected value="">Select State</option>');
                }
            });
        </script>
    @endpush
    <style>
        .nav-tabs .nav-item.show .nav-link,
        .nav-tabs .nav-link.active {
            color: #ffffff;
            background-color: #ec1c24;
            border-color: #ec1c24;
        }

        .nav-tabs {
            margin-top: 3px;
            border-bottom: 3px solid #ec1c24;
        }

        .nav-tabs .nav-link {
            color: #ec1c24;
            border-radius: 0;
        }
    </style>
</x-guest-layout>

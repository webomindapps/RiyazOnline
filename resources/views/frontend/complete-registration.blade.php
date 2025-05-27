<x-guest-layout>
    <div class="row">
        <div class="col-lg-9 mx-auto mt-5 ">
            <div class="r-form">
                @if ($student->reg_status == 1)
                    <h2 class="fs-title"
                        style="font-size: 19px;color: #ec1c24;font-weight: 400;margin-top: 15%;margin-bottom: 15%;text-align:center">
                        You have already completed your registration.</h2>
                @else
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                type="button" role="tab" aria-controls="home" aria-selected="true">Step 1</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                type="button" role="tab" aria-controls="profile" aria-selected="false">Step
                                2</button>
                        </li>
                    </ul>
                    <form action="{{ route('complete.registration', $student->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                <h5 class="text-center mt-3">STUDENT DETAILS</h5>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Student Name<span style="color:red">*</span><br>
                                                <span style="font-size: 10px;font-weight: 500;color: #000;">(Please
                                                    fill your complete name as per your ID
                                                    proof)</span>
                                            </label>
                                            <input class="form-control" name="name" id="name"
                                                value="{{ $student->name }}"onkeypress="return isalpha(event)" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email<span style="color:red">*</span></label>
                                            <input class="form-control" name="email" id="email"
                                                value="{{ $student->email }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Phone<span style="color:red">*</span></label>
                                        <input class="form-control" name="phone" id="phone"
                                            value="{{ $student->phone }}" readonly
                                            onchange="check_mobile_available(this.id)" placeholder="Contact No 1*"
                                            maxlength="10" onkeypress="return isNumber(event)">
                                    </div>
                                    <div class="col-md-6" style="display:none">
                                        <input class="form-control" type="text" name="phone_2" id="phone_2"
                                            value="{{ $student->phone_2 }}" placeholder="Contact No 2" maxlength="10"
                                            onkeypress="return isNumber(event)">
                                    </div>
                                    <div class="col-md-6 ">
                                        <label>Whatsapp No<span style="color:red">*</span></label>
                                        <input class="form-control" type="text" name="whatsapp_no" id="whatsapp_no"
                                            maxlength="10" onkeypress="return isNumber(event)" required>
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
                                    <div class="col-md-12">
                                        <label>Date of Birth
                                            <span style="color:red">*</span>
                                        </label>
                                        <input class="form-control datepicker hasDatepicker" id="dob"
                                            type="date" name="dob" onchange="calculate_age();" max="2025-05-26"
                                            required>
                                    </div>
                                    <div class="col-md-6 ">
                                        <label>Age<span style="color:red">*</span></label>
                                        <select name="age" required
                                            style="border: 1px solid #e4e3e7;width:100%;border-radius: 7px;box-shadow: none;padding: 10px 15px;font-size: 13px;border: 1px solid #ff430442;color: #656565;background: #fff;">
                                            <option value=""> Select Age</option>
                                            <option value="Adult" {{ $student->age == 'Adult' ? 'selected' : '' }}>
                                                Adult
                                            </option>
                                            @for ($i = 3; $i <= 18; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $student->age == $i ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Gender<span style="color:red">*</span></label>
                                        <select name="gender"
                                            style="border: 1px solid #e4e3e7;width:100%;border-radius: 7px;box-shadow: none;padding: 10px 15px;font-size: 13px;border: 1px solid #ff430442;color: #656565;background: #fff;"
                                            fdprocessedid="1njazb">
                                            <option value=""> Gender</option>
                                            <option value="0" selected>Male</option>
                                            <option value="1">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="act-btn mx-auto"
                                            onclick="validate_form();">Next</button>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <h5 class="text-center mt-3">PERSONAL DETAILS</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label>Father Name<span style="color:red">*</span></label>
                                        <input class="form-control" type="text" name="father_name"
                                            id="father_name" placeholder="" required
                                            onkeypress="return isalpha(event)">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Mother Name<span style="color:red">*</span></label>
                                        <input class="form-control" type="text" name="mother_name"
                                            id="mother_name" placeholder="" onkeypress="return isalpha(event)"
                                            required>
                                    </div>
                                    <div class="col-md-6 ">
                                        <label>Current Address
                                            <span style="color:red">*</span><br>
                                            <span style="font-size: 10px;font-weight: 500;color: #000;">(Ensure
                                                you will fill your complete
                                                address)</span>
                                        </label>
                                        <textarea class="form-control custom-control" name="current_address" rows="3" placeholder="" required
                                            style="border-radius: 7px;border: 1px solid #ff430442;"></textarea>
                                    </div>
                                    <div class="col-md-6 ">
                                        <label>Permanent Address<span style="color:red">*</span><br><span
                                                style="font-size: 10px;font-weight: 500;color: #000;">(Ensure
                                                you will fill your complete
                                                address)</span></label>
                                        <textarea class="form-control custom-control" name="permanent_address" rows="3" placeholder="" required
                                            style="border-radius: 7px;border: 1px solid #ff430442;"></textarea>
                                    </div>
                                    <div class="col-md-6 ">
                                        <label>Emergency Contact Person<span style="color:red">*</span></label>
                                        <input class="form-control" type="text" name="emg_contact_person"
                                            id="emg_contact_name" onkeypress="return isalpha(event)" required>
                                    </div>
                                    <div class="col-md-6 ">
                                        <label>Emergency Contact No<span style="color:red">*</span></label>
                                        <input class="form-control" type="text" name="emg_contact_no"
                                            id="emg_phone" maxlength="10" onkeypress="return isNumber(event)"
                                            onchange="check_emg_contact_no();" required>
                                    </div>
                                    <div class="col-md-6 ">
                                        <label>Emergency Contact Person Relation<span
                                                style="color:red">*</span></label>
                                        <input class="form-control" type="text" name="emg_relation"
                                            id="emg_relation" onkeypress="return isalpha(event)" required>
                                    </div>
                                    <div class="col-md-6 ">
                                        <label>Occupation<span style="color:red">*</span><br>
                                            <span style="font-size: 10px;font-weight: 500;color: #000;">(Please
                                                enter parent's occupation if student below 18
                                                years)</span>
                                        </label>
                                        <input class="form-control" type="text" name="occupation"
                                            id="occupation">
                                    </div>
                                    <div class="col-md-6 ">
                                        <label style="">Office No<br>
                                            <span style="font-size: 10px;font-weight: 500;color: #000;">(Please
                                                enter parent's office no if student below 18
                                                years)</span>
                                        </label>
                                        <input class="form-control" type="text" maxlength="10"
                                            onkeypress="return isNumber(event)" name="office_no">
                                    </div>
                                    <div class="col-md-6 ">
                                        <label style="">Office Address<br>
                                            <span style="font-size: 10px;font-weight: 500;color: #000;">(Please
                                                enter parent's office address if student below
                                                18
                                                years)</span>
                                        </label>
                                        <textarea class="form-control custom-control" name="office_address" rows="5"
                                            style="border-radius: 7px;border: 1px solid #ff430442;"></textarea>
                                    </div>
                                    <div class="col-md-12 ">
                                        <button type="button" class="act-btn">Cancel</button>
                                        <button type="submit" class="act-btn">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function validate_form() {
                name = $("#name").val();
                email = $("#email").val();
                phone = $("#phone").val();
                file = $("#file").val();
                dob = $("#dob").val();
                age = $("#age").val();
                gender = $("#gender").val();
                whatsapp_no = $("#whatsapp_no").val();
                if (name == "" || email == "" || phone == "" || file == "" || dob == "" || age == "" || gender == "" ||
                    whatsapp_no == "") {
                    alert("Please fill in all the mandatory (*) fields");
                    return;
                } else {
                    const nextTab = document.getElementById("profile-tab");
                    nextTab.click();
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

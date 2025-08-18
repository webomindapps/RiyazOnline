<div class="modal-header bg-primary text-white">
    <div class="d-flex justify-content-between w-100 px-2">
        <div class="">
            <h4>{{ $student->name }}</h4>
            <span style="font-size: 12px;">Student</span>
        </div>
        <div class="">
            @if ($student->profile_picture)
                <a data-fancybox="gallery" data-src="{{ asset('storage/' . $student->profile_picture) }}">
                    <img src="{{ asset('storage/' . $student->profile_picture) }}" alt="" class="" width="50px">
                </a>
            @else
                <img src="{{ asset('frontend/user.png') }}" alt="" class="" width="50px">
            @endif
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="modal-body detail-modal">
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <p><b>Name :</b> <span>{{ $student->f_name . ' ' . $student->l_name }}</span></p>
                <p><b>Contact No :</b> <span>{{ $student->phone }}</span></p>
                <p><b>Date of Register :</b> <span>{{ date('d-m-Y', strtotime($student->date)) }}</span></p>
                <p><b>Gender :</b> <span>{{ $student->gender == 0 ? 'Male' : 'Female' }}</span></p>
                <p class="text-danger"><b>Due Date : </b>
                    <span>{{ date('d-m-Y', strtotime($student->studentcourse->due_date)) }}</span>
                </p>
            </div>
            <div class="col-md-4 col-sm-6">
                <p>
                    <b>DOB :</b>
                    @if ($student->dob)
                        <span>{{ date('d-m-Y', strtotime($student->dob)) }}</span>
                    @endif
                </p>
                <p><b>Alt.Contact No :</b> <span>{{ $student->phone_2 }}</span></p>
            </div>
            <div class="col-md-4 col-sm-6">
                <p><b>Email :</b> <span>{{ $student->email }}</span></p>
                <p><b>Whatsapp No :</b> <span>{{ $student->student_whatsapp_no }}</span></p>
                <p><b>Age :</b> <span>{{ $student->age }}</span></p>
            </div>
        </div>
        <hr>
        <h4 class="text-semibold">Personal Details</h4>
        <div class="row">
            <div class="col-md-4 col-sm-6">
                @if($student->age != 'Adult')
                    <p><b>Father Name :</b> <span>{{ $student->father_name }}</span></p>
                @endif
                <p><b>Current Country :</b> <span>{{ $student->country?->name }}</span></p>
                <p><b>Current State :</b> <span>{{ $student->state?->name }}</span></p>
                <p><b>Current City :</b> <span>{{ $student->city }}</span></p>
                <p><b>Current Address :</b> <span>{{ $student->current_address }}</span></p>
            </div>
            <div class="col-md-4 col-sm-6">
                @if($student->age != 'Adult')
                    <p><b>Mother Name :</b> <span>{{ $student->mother_name }}</span></p>
                @endif
                <p><b>Permanent Country :</b> <span>{{ $student->pcountry?->name }}</span></p>
                <p><b>Permanent State :</b> <span>{{ $student->pstate?->name }}</span></p>
                <p><b>Permanent City :</b> <span>{{ $student->p_city }}</span></p>
                <p><b>Permanent Address :</b> <span>{{ $student->permanent_address }}</span></p>
            </div>
            <div class="col-md-4 col-sm-6">
                <p><b>Emg Contact Person :</b> <span>{{ $student->emg_contact_person }}</span></p>
                <p><b>Emg Relationship :</b> <span>{{ $student->emg_relation }}</span></p>
                <p><b>Emg Contact No :</b> <span>{{ $student->emg_contact_no }}</span></p>
            </div>
        </div>
        <hr>
        <h4 class="text-semibold">Courses Joined</h4>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="bg-primary text-white">Course</th>
                    <th class="bg-primary text-white">Fees Paid</th>
                    <th class="bg-primary text-white">Type</th>
                    <th class="bg-primary text-white">Paid Date</th>
                    <th class="bg-primary text-white">Penalty</th>
                    <th class="bg-primary text-white">Payment Type</th>
                    <th class="bg-primary text-white">Invoice</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($student->studentcourses as $course)
                    <tr>
                        <td>{{ $course->course_name }}</td>
                        <td>{{ $course->grand_total }}</td>
                        <td>Existing Registration</td>
                        <td>{{ date('d-m-Y', strtotime($course->paid_date)) }}</td>
                        <td>{{ $course->penalty_amount }}</td>
                        <td>{{ $course->type ? 'Monthly' : 'Quarterly' }}</td>
                        <td>
                            <a class="text-primary" target="_blank"
                                href="{{ route('admin.invoice.show', $course->id) }}">Download</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

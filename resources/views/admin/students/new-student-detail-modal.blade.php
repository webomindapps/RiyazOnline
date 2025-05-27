<div class="modal-header bg-primary text-white">
    <div class="d-flex justify-content-between w-100 px-2">
        <div class="">
            <h4>{{ $student->name }}</h4>
            <span style="font-size: 12px;">Student</span>
        </div>
        <div class="">
            @if ($student->profile_picture)
                <img src="{{ asset('storage/'.$student->profile_picture) }}" alt="" class="" width="50px">
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
                <p><b>Name :</b> <span>{{ $student->name }}</span></p>
                <p><b>Contact No :</b> <span>{{ $student->phone }}</span></p>
                <p><b>Date of Register :</b> <span>{{ date('d-m-Y', strtotime($student->date)) }}</span></p>
                <p><b>Gender :</b> <span>{{ $student->gender == 0 ? 'Male' : 'Female' }}</span></p>
                <p><b>Country :</b> <span>{{ $student->country?->name }}</span></p>
            </div>
            <div class="col-md-4 col-sm-6">
                <p><b>DOB :</b> <span>{{ date('d-m-Y', strtotime($student->dob)) }}</span></p>
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
                <p><b>Father Name :</b> <span>{{ $student->mother_name }}</span></p>
                <p><b>Current Address :</b> <span>{{ $student->current_address }}</span></p>
                <p><b>Office Contact No :</b> <span>{{ $student->office_no }}</span></p>
                <p><b>Office Address :</b> <span>{{ $student->office_address }}</span></p>
            </div>
            <div class="col-md-4 col-sm-6">
                <p><b>Mother Name :</b> <span>{{ $student->mother_name }}</span></p>
                <p><b>Permanent Address :</b> <span>{{ $student->permanent_address }}</span></p>
                <p><b>Occupation :</b> <span>{{ $student->occupation }}</span></p>
            </div>
            <div class="col-md-4 col-sm-6">
                <p><b>Emg Contact Person :</b> <span>{{ $student->emg_contact_person }}</span></p>
                <p><b>Emg Contact No :</b> <span>{{ $student->emg_contact_no }}</span></p>
                <p><b>Emg Relationship :</b> <span>{{ $student->emg_relation }}</span></p>
            </div>
        </div>
        <hr>
        <h4 class="text-semibold">Courses Joined</h4>
        <table class="table datatable-basic table-bordered table-hover">
            <thead class="bg-primary text-white">
                <tr>
                    <th>Course</th>
                    <th>Fees Paid</th>
                    <th>Type</th>
                    <th>Invoice</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($student->studentcourses as $course)
                    <tr>
                        <td>{{ $course->course_name }}</td>
                        <td>{{ $course->grand_total }}</td>
                        <td>{{ $course->type }}</td>
                        <td>
                            <a class="text-primary" target="_blank" href="">Download</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

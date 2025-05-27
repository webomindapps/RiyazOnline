<x-app-layout>
    <div class="m-3 bg-white">
        <x-admin.breadcrumb title="Edit Student Details" isBack="{{ true }}" />
        <div class="form-card px-3 bg-white">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" class="formSubmit" action="{{ route('admin.student.edit', $student->id) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="row mb-4">
                    <x-forms.input label="Name" type="text" name="name" id="name" :required="true"
                        size="col-lg-4 mt-4" :value="$student->name" />
                    <x-forms.input label="Email" type="email" name="email" id="email" :required="true"
                        size="col-lg-4 mt-4" :value="$student->email" />
                    <x-forms.input label="Contact" type="number" name="phone" id="phone" :required="true"
                        size="col-lg-4 mt-4" :value="$student->phone" />
                    <x-forms.input label="Alternate Contact" type="number" name="phone_2" id="phone_2"
                        :required="true" size="col-lg-4 mt-4" :value="$student->phone_2" />
                    <div class="col-lg-4 mt-4" id="form-group-phone">
                        <label for="course" class="form-lable">
                            Course<span style="color: red">*</span>
                        </label>
                        <select name="course" class="w-100" id="course">
                            <option value="">Select Course</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}"
                                    {{ $course->id == $student->studentcourse?->course_id ? 'selected' : '' }}>
                                    {{ $course->course_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4 mt-4" id="form-group-phone">
                        <label for="country" class="form-lable">
                            Country<span style="color: red">*</span>
                        </label>
                        <select name="country_id" class="w-100" id="country">
                            <option value="">Select Country</option>
                            <option value="1" {{ $student->country_id == 1 ? 'selected' : '' }}>India</option>
                        </select>
                    </div>
                    <x-forms.input label="Date Of Birth" type="date" name="dob" id="dob" :required="false"
                        size="col-lg-4 mt-4" :value="$student->dob" />
                    <x-forms.input label="Student Photo" type="file" name="photo" id="photo" :required="false"
                        size="col-lg-4 mt-4" :value="$student->photo" />
                    <div class="col-lg-4 mt-4" id="form-group-phone">
                        <label for="age" class="form-lable">
                            Age<span style="color: red">*</span>
                        </label>
                        <select name="age" class="w-100" id="age" required>
                            <option value="">Select Age</option>
                            <option value="Adult" {{ $student->age == 'Adult' ? 'selected' : '' }}>Adult</option>
                            @for ($i = 3; $i <= 18; $i++)
                                <option value="{{ $i }}" {{ $student->age == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-lg-4 mt-4" id="form-group-phone">
                        <label for="gender" class="form-lable">
                            Gender
                        </label>
                        <select name="gender" class="w-100" id="gender">
                            <option value="0" {{ $student->gender == 0 ? 'selected' : '' }}>Male</option>
                            <option value="1" {{ $student->gender == 1 ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    <x-forms.input label="Father's name" type="text" name="father_name" id="father_name"
                        :required="false" size="col-lg-6 mt-4" :value="$student->father_name" />
                    <x-forms.input label="Mother's name" type="text" name="mother_name" id="mother_name"
                        :required="false" size="col-lg-6 mt-4" :value="$student->mother_name" />
                    <x-forms.textarea label="Current Address" type="text" name="current_address" id="current_address"
                        :required="false" size="col-lg-6 mt-4" :value="$student->current_address" />
                    <x-forms.textarea label="Permanent Address" type="text" name="permanent_address"
                        id="permanent_address" :required="false" size="col-lg-6 mt-4" :value="$student->permanent_address" />
                    <x-forms.input label="Emg Contact Person" type="text" name="emg_contact_person"
                        id="emg_contact_person" :required="false" size="col-lg-6 mt-4" :value="$student->emg_contact_person" />
                    <x-forms.input label="Emg Contact No" type="number" name="emg_contact_no" id="emg_contact_no"
                        :required="true" size="col-lg-6 mt-4" :value="$student->emg_contact_no" />
                    <x-forms.input label="Emg Contact Person Relation" type="text" name="emg_relation"
                        id="emg_relation" :required="false" size="col-lg-6 mt-4" :value="$student->emg_relation" />
                    <x-forms.input label="Whatsapp No" type="number" name="student_whatsapp_no"
                        id="student_whatsapp_no" :required="false" size="col-lg-6 mt-4" :value="$student->student_whatsapp_no" />
                    <x-forms.input label="Occupation (Enter parents occupation if student below 18 years)"
                        type="text" name="occupation" id="occupation" :required="false" size="col-lg-6 mt-4"
                        :value="$student->occupation" />
                    <x-forms.input label="Office No (Enter parents office no if student below 18 years)"
                        type="number" name="office_no" id="office_no" :required="false" size="col-lg-6 mt-4"
                        :value="$student->office_no" />
                    <x-forms.textarea label="Office Address" type="text" name="office_address"
                        id="office_address" :required="false" size="col-lg-12 mt-4" :value="$student->office_address" />
                    <x-forms.select label="Payment Type" name="payment_type" id="payment_type" :required="true"
                        size="col-lg-4 mt-4" :options="[['label' => 'Monthly', 'value' => 0], ['label' => 'Quaterly', 'value' => 1]]" :value="$student->payment_type" />
                    <x-forms.input label="Date of Register" type="date" name="latest_paid_date"
                        id="latest_paid_date" :required="true" size="col-lg-4 mt-4" :value="$student->latest_paid_date" />
                    <x-forms.input label="Class Start Date" type="date" name="date_joining" id="date_joining"
                        :required="true" size="col-lg-4 mt-4" :value="$student->date_joining" />
                    <x-forms.input label="Due Date" type="date" name="due_date" id="due_date" :required="true"
                        size="col-lg-4 mt-4" :value="$student->studentcourse?->due_date" />
                    <x-forms.input label="GST No. (Please mention your GST number if you are a registered GST user)"
                        type="text" name="gst_no" id="gst_no" :required="false" size="col-lg-6 mt-4"
                        :value="$student->gst_no" />
                    <x-forms.input label="Reminder Date" type="date" name="reminder_date" id="reminder_date"
                        :required="false" size="col-lg-2 mt-4" :value="$student->reminder_date" />
                    <x-forms.textarea label="Reminder" type="text" name="reminder" id="reminder"
                        :required="false" size="col-lg-12 mt-4" :value="$student->reminder" />
                </div>
                <x-forms.button type="submit" class="btn btn-success mt-3" label="Submit" />
            </form>
        </div>
    </div>
</x-app-layout>

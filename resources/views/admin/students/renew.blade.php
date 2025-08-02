<x-app-layout>
    <div class="m-3 bg-white">
        <x-admin.breadcrumb title="Renew Student Course" isBack="{{ true }}" />
        <div class="form-card px-3 bg-white">
            @if ($errors->any())
                <div class="alert alert-danger mt-2">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" class="formSubmit" action="{{ route('admin.student.renew') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="row mb-4">
                    <x-forms.input label="Roll No" type="text" name="roll_no" id="roll_no" :required="true"
                        size="col-lg-4 mt-4" :value="old('roll_no')" placeholder="Student Roll No" />
                    <x-forms.input label="First Name" type="text" name="f_name" id="f_name" :required="false"
                        readonly size="col-lg-4 mt-4" :value="old('f_name')" />
                    <x-forms.input label="Last Name" type="text" name="l_name" id="l_name" :required="false"
                       readonly size="col-lg-4 mt-4" :value="old('f_name')" />
                    <x-forms.input label="Email" type="email" name="email" id="email" :required="false"
                       readonly size="col-lg-4 mt-4" :value="old('email')" />
                    <x-forms.input label="Phone" type="text" name="phone" id="phone" :required="false"
                       readonly size="col-lg-4 mt-4" :value="old('phone')" />
                    <input type="hidden" name="course_id" id="course_id">
                    <x-forms.input label="Course" type="text" name="course" id="course" :required="false"
                       readonly size="col-lg-4 mt-4" :value="old('course')" />
                    <x-forms.input label="Due Date" type="date" name="due_date" id="due_date" :required="false"
                        size="col-lg-4 mt-4" :value="old('due_date')" />
                    <x-forms.input label="Paid Date" type="date" name="paid_date" id="paid_date" :required="true"
                        size="col-lg-4 mt-4" :value="old('paid_date')" />
                    <x-forms.input label="Course Fee" type="number" name="amount" id="amount" :required="true"
                        size="col-lg-4 mt-4" :value="old('amount')" />
                    <x-forms.input label="Convenience Fees" type="number" name="convenience_fees" id="convenience_fees"
                        :required="true" size="col-lg-4 mt-4" :value="old('convenience_fees')" />
                    <x-forms.input label="Sub Total" type="number" name="sub_tot" id="sub_tot" :required="true"
                        size="col-lg-4 mt-4" :value="old('sub_tot')" />
                    <x-forms.input label="Grand Total" type="number" name="grand_total" id="grand_total"
                        :required="true" size="col-lg-4 mt-4" :value="old('grand_total')" />
                </div>
                <x-forms.button type="submit" class="btn btn-success mt-3" label="Submit" />
            </form>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#roll_no').on('change', function() {
                    var rollNo = $(this).val().trim();

                    if (rollNo !== '') {
                        $.ajax({
                            url: "{{ url('/') }}" + '/admin/student/details-by-roll/' + rollNo,
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response);

                                if (response.status === 'success') {
                                    var student = response.data;
                                    $('#f_name').val(student.f_name || '');
                                    $('#l_name').val(student.l_name || '');
                                    $('#email').val(student.email || '');
                                    $('#phone').val(student.phone || '');

                                    // Handle course if available from studentcourse relationship
                                    if (student.studentcourse) {
                                        $('#course_id').val(student.studentcourse.course_id);
                                        $('#course').val(student.studentcourse.course_name || '');
                                        $('#due_date').val(student.studentcourse.due_date || '');
                                        $('#amount').val(student.studentcourse.amount || '');
                                        $('#convenience_fees').val(student.studentcourse
                                            .convenience_fees || '');
                                        $('#sub_tot').val(student.studentcourse.grand_total || '');
                                        $('#grand_total').val(student.studentcourse.grand_total ||
                                            '');
                                    }
                                } else {
                                    alert("Student not found.");
                                }
                            },
                            error: function() {
                                alert("Something went wrong while fetching student data.");
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>

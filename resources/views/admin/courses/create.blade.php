<x-app-layout>
    <div class="m-3 bg-white">
        <x-admin.breadcrumb title="Add Course" isBack="{{ true }}" />
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
            <form method="POST" class="formSubmit" action="{{ route('admin.courses.store') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="row mb-4">
                    <x-forms.input label="Course Name" type="text" name="course_name" id="course_name"
                        :required="true" size="col-lg-4 mt-4" :value="old('course_name')" />
                    <x-forms.input label="New Student Fees" type="number" name="new_student_fees" id="new_student_fees"
                        :required="true" size="col-lg-4 mt-4" :value="old('new_student_fees')" />
                    <x-forms.input label="Old Student Fees" type="number" name="old_student_fees" id="old_student_fees"
                        :required="true" size="col-lg-4 mt-4" :value="old('old_student_fees')" />
                    <x-forms.input label="Priority" type="number" name="priority" id="priority" :required="true"
                        size="col-lg-4 mt-4" :value="old('priority')" />
                    <x-forms.select label="Status" name="status" id="status" :required="true" size="col-lg-4 mt-4"
                        :options="[['label' => 'Active', 'value' => 1], ['label' => 'In-Active', 'value' => 0]]" :value="1" />
                    <x-forms.textarea label="Course Description" type="text" name="description" id="description"
                        :required="true" size="col-lg-12 mt-4" :value="old('description')" />
                </div>
                <x-forms.button type="submit" class="btn btn-success mt-3" label="Submit" />
            </form>
        </div>
    </div>
</x-app-layout>

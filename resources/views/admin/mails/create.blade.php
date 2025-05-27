<x-app-layout>
    <div class="m-3 bg-white">
        <x-admin.breadcrumb title="Add Mail" isBack="{{ true }}" />
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
            <form method="POST" class="formSubmit" action="{{ route('admin.mails.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row mb-4">
                    <x-forms.input label="Name" type="text" name="name" id="name" :required="true"
                        size="col-lg-4 mt-4" :value="old('name')" />
                    <x-forms.input label="Email" type="email" name="email" id="email" :required="true"
                        size="col-lg-4 mt-4" :value="old('email')" />
                    <x-forms.select label="Status" name="status" id="status" :required="true" size="col-lg-4 mt-4"
                        :options="[['label' => 'Active', 'value' => 1], ['label' => 'In-Active', 'value' => 0]]" :value="1" />
                </div>
                <x-forms.button type="submit" class="btn btn-success mt-3" label="Submit" />
            </form>
        </div>
    </div>
</x-app-layout>

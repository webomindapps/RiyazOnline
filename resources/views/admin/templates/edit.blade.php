<x-app-layout>
    <div class="m-3 bg-white">
        <x-admin.breadcrumb title="Edit Template" isBack="{{ true }}" />
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
            <form method="POST" class="formSubmit" action="{{ route('admin.templates.update', $template->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row mb-4">
                    <x-forms.input label="Title" type="text" name="title" id="title" :required="true"
                        size="col-lg-8 mt-4" :value="$template->title" />
                    <x-forms.input label="Priority" type="number" name="priority" id="priority" :required="true"
                        size="col-lg-4 mt-4" :value="$template->priority" />
                    <x-forms.textarea label="Content" type="text" name="content" id="content" :required="true"
                        size="col-lg-12 mt-4" :value="$template->content" />
                </div>
                <x-forms.button type="submit" class="btn btn-success mt-3" label="Submit" />
            </form>
        </div>
    </div>
</x-app-layout>

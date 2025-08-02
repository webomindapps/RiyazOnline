<x-app-layout>
    <div class="m-3 bg-white p-2 rounded">
        <div class="d-flex bg-primary text-white p-2 justify-content-between align-items-center rounded">
            <p>Email Panel</p>
            <a class="btn btn-sm border text-white" data-bs-toggle="collapse" href="#collapseExample" role="button"
                aria-expanded="false" aria-controls="collapseExample">
                <i class="bi bi-caret-down"></i>
            </a>
        </div>
        <div class="collapse mt-2" id="collapseExample">
            <div class="card card-body">
                <div class="form-group">
                    <label class="form-label" style="padding-top:1%">Template</label>
                    <div class="">
                        <select name="email_template" id="email_template" class="form-control"
                            onchange="get_email_content();">
                            <option value="">Select</option>
                            @foreach ($emailtemplates as $template)
                                <option value="{{ $template->id }}">{{ $template->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" style="padding-top:1%">Message</label>
                    <div class="">
                        <textarea class="form-control" name="mail_message" id="mail_message" rows="4" placeholder="Message *"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary float-end mt-3" value="Send Mail" onclick="sendMail()"
                        name="send_mail">
                </div>
            </div>
        </div>
    </div>
    <div class="m-3 bg-white">
        <x-admin.breadcrumb title="Student List" isCreate="{{ true }}"
            createLink="{{ route('admin.student.create') }}">
            <!-- Button trigger modal -->
            <button type="button" class="add-btn" data-bs-toggle="modal" data-bs-target="#studentImport">
                <i class="bi bi-file-earmark-arrow-up"></i> Import
            </button>

            <!-- Modal -->
            <div class="modal fade" id="studentImport" tabindex="-1" aria-labelledby="studentImportLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="studentImportLabel">Import Students</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('admin.student.import') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="file" class="form-label">Upload Excel File</label>
                                    <input type="file" class="form-control" id="file" name="file"
                                        accept=".xls,.xlsx">
                                </div>
                                <button type="submit" class="add-btn float-end">Import</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.student.renew') }}" class="add-btn">
                <i class="bi bi-plus-circle"></i>
                Fees Manual
            </a>
        </x-admin.breadcrumb>
        @php

            $columns = [
                ['label' => 'Sl No', 'column' => 'id', 'sort' => true],
                ['label' => 'Roll No', 'column' => 'id', 'sort' => true],
                ['label' => 'Name', 'column' => 'f_name', 'sort' => true],
                ['label' => 'Mobile', 'column' => 'phone', 'sort' => true],
                ['label' => 'Course', 'column' => 'course_id', 'sort' => false],
                // ['label' => 'Guru', 'column' => 'date', 'sort' => true],
                ['label' => 'Due Date', 'column' => 'status', 'sort' => false],
                ['label' => 'Disable', 'column' => 'date', 'sort' => false],
                ['label' => 'Actions', 'column' => 'action', 'sort' => false],
            ];

            $bulkOptions = [
                [
                    'label' => 'Delete',
                    'value' => '1',
                ],
                [
                    'label' => 'Status',
                    'value' => '2',
                    'options' => [
                        [
                            'label' => 'Active',
                            'value' => '1',
                        ],
                        [
                            'label' => 'Inactive',
                            'value' => '0',
                        ],
                    ],
                ],
            ];
        @endphp

        <x-table :columns="$columns" :data="$students" checkAll="{{ true }}" :bulk="route('admin.all.students', ['customer' => 'bulk'])" :route="route('admin.all.students')">
            @foreach ($students as $key => $item)
                @php
                    $actions = [
                        [
                            'code' => 'view',
                            'id' => $item->id,
                        ],
                        [
                            'code' => 'edit',
                            'route' => route('admin.student.edit', $item->id),
                        ],
                    ];
                @endphp
                <tr>
                    <td>
                        <input type="checkbox" name="selected_items[]" class="student_check"
                            value="{{ $item->id }}">
                    </td>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        <span class="badge px-3 py-2 bg-{{ $item->reg_status >= 1 ? 'success' : 'danger' }}">
                            {{ $item->id }}
                        </span>
                    </td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item?->course[0]?->course_name }}</td>
                    {{-- <td>
                        <select name="" id="">
                            <option value="">Select Guru</option>
                        </select>
                    </td> --}}
                    <td>{{ date('d-m-Y', strtotime($item->studentcourse?->due_date)) }}</td>
                    <td>
                        <label class="switch">
                            <input {{ $item->status != 3 ? 'checked' : '' }} type="checkbox"
                                onchange="change_student_status({{ $item->id }});">
                            <span class="slider round"></span>
                        </label>
                    </td>
                    <td>
                        <x-actions :item="$item" :options="$actions" />
                    </td>
                </tr>
            @endforeach
        </x-table>
    </div>
    @push('scripts')
        <script>
            function change_student_status(id) {
                value = 3;
                if ($('#' + id).is(':checked')) {
                    value = 2;
                }
                r = confirm("Are you sure to remove the records from the student master Tab ?");
                if (r == true) {
                    let remark = prompt('Why moving to attrition?');
                    jQuery.ajax({
                        type: "POST",
                        url: "{{ route('admin.student.status.change') }}",
                        datatype: "text",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}",
                            value: value,
                            remark: remark,
                        },
                        success: function(response) {
                            location.reload();
                        },
                        error: function(xhr, ajaxOptions, thrownError) {}
                    });
                } else {
                    $('#' + id).prop('checked', true);
                }
            }

            function get_email_content() {
                id = $("#email_template").val();
                if (id == "") {
                    $("#mail_message").val("");
                    return;
                }
                jQuery.ajax({
                    type: "GET",
                    url: "{{ route('admin.get.email.content') }}",
                    datatype: "text",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        $("#mail_message").val("" + response.content + "");
                    },
                    error: function(xhr, ajaxOptions, thrownError) {}
                });
            }

            function sendMail() {
                student = [];
                content = $("#mail_message").val();
                mail_id = $("#email_template").val();
                $('.student_check:checkbox:checked').each(function() {
                    student.push($(this).val());
                });
                if (student.length === 0) {
                    alert("Please select at least one student.");
                    return;
                }
                if (mail_id === "") {
                    alert("Please select one template.");
                    return;
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    type: "POST",
                    url: "{{ route('admin.student.bulk.mail') }}",
                    datatype: "text",
                    data: {
                        content: content,
                        student: student,
                        template_id: mail_id,
                    },
                    success: function(response) {
                        window.location.reload();
                    },
                    error: function(xhr, ajaxOptions, thrownError) {}
                });
            }
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
        <script type="text/javascript">
            var route = "{{ url('autocomplete-search') }}";
            $('#searchBox').typeahead({
                name: 'name',
                source: function(query, process) {
                    return $.get(route, {
                        query: query
                    }, function(data) {
                        return process(data);
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>

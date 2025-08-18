<x-app-layout>
    <div class="m-3 bg-white">
        <x-admin.breadcrumb title="Disabled Student List" isCreate="{{ false }}" />
        @php

            $columns = [
                ['label' => 'Sl No', 'column' => 'id', 'sort' => true],
                ['label' => 'Roll No', 'column' => 'id', 'sort' => true],
                ['label' => 'Name', 'column' => 'name', 'sort' => true],
                ['label' => 'Course', 'column' => 'course_id', 'sort' => false],
                ['label' => 'Date Of Joining', 'column' => 'date_joining', 'sort' => true],
                ['label' => 'Date Of Attrition', 'column' => 'attrition_date', 'sort' => true],
                ['label' => 'Reason', 'column' => 'status', 'sort' => false],
                ['label' => 'Enable', 'column' => 'date', 'sort' => false],
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

        <x-table :columns="$columns" :data="$students" checkAll="{{ false }}" :bulk="route('admin.students.disabled', ['customer' => 'bulk'])" :route="route('admin.students.disabled')">
            @foreach ($students as $key => $item)
                @php
                    $actions = [
                        [
                            'code' => 'edit',
                            'route' => route('admin.student.edit', $item->id),
                        ],
                    ];
                @endphp
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item?->course[0]?->course_name }}</td>
                    <td>{{ date('d-m-Y', strtotime($item->date_joining)) }}</td>
                    <td>{{ date('d-m-Y', strtotime($item->attrition_date)) }}</td>
                    <td>
                        <textarea id="comm_{{ $item->id }}" onchange="update_comment({{ $item->id }});" rows="1">{{ $item->comment }}</textarea>
                    </td>
                    <td>
                        <label class="switch">
                            <input {{ $item->status == 3 ? 'checked' : '' }} type="checkbox"
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
                jQuery.ajax({
                    type: "POST",
                    url: "{{ route('admin.student.status.change') }}",
                    datatype: "text",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}",
                        value: 2,
                    },
                    success: function(response) {
                        location.reload();
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
            function update_comment(id) {
                value = $("#comm_" + id).val();
                jQuery.ajax({
                    type: "POST",
                    url: "{{ route('admin.student.comment.update') }}",
                    datatype: "text",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        comment: value
                    },
                    success: function(response) {
                        alert("Updated Successfully");
                    },
                    error: function(xhr, ajaxOptions, thrownError) {}
                });
            }
        </script>
    @endpush
</x-app-layout>

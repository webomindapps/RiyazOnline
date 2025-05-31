<x-app-layout>
    <div class="m-3 bg-white">
        <x-admin.breadcrumb title="Student List" isCreate="{{ true }}"
            createLink="{{ route('admin.student.create') }}" />
        @php

            $columns = [
                ['label' => 'Sl No', 'column' => 'id', 'sort' => true],
                ['label' => 'Roll No', 'column' => 'id', 'sort' => true],
                ['label' => 'Name', 'column' => 'name', 'sort' => true],
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

        <x-table :columns="$columns" :data="$students" checkAll="{{ false }}" :bulk="route('admin.mails.index', ['customer' => 'bulk'])" :route="route('admin.mails.index')">
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
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->id }}</td>
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
        </script>
    @endpush
</x-app-layout>

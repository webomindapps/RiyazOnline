<x-app-layout>
    <div class="m-3 bg-white">
        <x-admin.breadcrumb title="Course List" isCreate="{{ true }}" createLink="{{ route('admin.courses.create') }}" >
            <a href="{{ route('admin.courses.export') }}" class="add-btn"><i class="bi bi-file-earmark-arrow-down"></i> Download</a>
        </x-admin.breadcrumb>
        @php

            $columns = [
                ['label' => 'Sl No', 'column' => 'id', 'sort' => true],
                ['label' => 'Course', 'column' => 'course_name', 'sort' => true],
                ['label' => 'New Student Fee', 'column' => 'new_student_fees', 'sort' => true],
                ['label' => 'Old Student Fee', 'column' => 'old_student_fees', 'sort' => true],
                ['label' => 'Status', 'column' => 'status', 'sort' => true],
                ['label' => 'Position', 'column' => 'priority', 'sort' => true],
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

        <x-table :columns="$columns" :data="$courses" checkAll="{{ false }}" :bulk="route('admin.courses.index', ['customer' => 'bulk'])" :route="route('admin.courses.index')">
            @foreach ($courses as $key => $item)
                @php

                    $actions = [
                        [
                            'code' => 'edit',
                            'route' => route('admin.courses.edit', $item->id),
                        ]
                    ];
                @endphp
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->course_name }}</td>
                    <td>{{ $item->new_student_fees }}</td>
                    <td>{{ $item->old_student_fees }}</td>
                    <td>
                        <label class="switch">
                            <input {{ $item->status == 1 ? 'checked' : '' }} type="checkbox"
                                onchange="change_course_status({{ $item->id }});">
                            <span class="slider round"></span>
                        </label>
                    </td>
                    <td>
                        <input type="number" style="width: 80px;height:30px;" value="{{ $item->priority }}"
                            onchange="update_priority({{ $item->id }}, this);">
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
            function change_course_status(id) {
                $.ajax({
                    url: "{{ route('admin.courses.change_status') }}",
                    type: "POST",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status == "success") {
                            alert('Status changed successfully');
                        } else {
                            alert('Failed to change status');
                        }
                    }
                });
            }

            function update_priority(id, el) {
                var priority = $(el).val();
                console.log(priority);
                
                $.ajax({
                    url: "{{ route('admin.courses.update_priority') }}",
                    type: "POST",
                    data: {
                        id: id,
                        priority: priority,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status == "success") {
                            alert('Priority updated successfully');
                        } else {
                            alert('Failed to update priority');
                        }
                    }
                });
            }
        </script>
    @endpush
</x-app-layout>

<x-app-layout>
    <div class="m-3 bg-white">
        <x-admin.breadcrumb title="New Registered Students" isCreate="{{ true }}"
            createLink="{{ route('admin.student.create') }}" />
        @php

            $columns = [
                ['label' => 'Sl No', 'column' => 'id', 'sort' => true],
                ['label' => 'Roll No', 'column' => 'id', 'sort' => true],
                ['label' => 'Name', 'column' => 'name', 'sort' => true],
                ['label' => 'Mobile', 'column' => 'phone', 'sort' => true],
                ['label' => 'Email', 'column' => 'email', 'sort' => true],
                ['label' => 'Course', 'column' => 'course_id', 'sort' => true],
                ['label' => 'Date of Reg', 'column' => 'date', 'sort' => true],
                ['label' => 'Registration Status', 'column' => 'status', 'sort' => true],
                ['label' => 'Start Date', 'column' => 'date', 'sort' => true],
                ['label' => 'Actions', 'column' => 'action', 'sort' => false],
            ];

            $bulkOptions = [];
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
                    <td>{{ $item->email }}</td>
                    <td>{{ $item?->course[0]?->course_name }}</td>
                    <td>{{ date('d-m-Y', strtotime($item->date)) }}</td>
                    <td>
                        @if ($item->reg_status >= 1)
                            <span class="badge rounded-pill text-bg-success">Completed</span>
                        @else
                            <span class="badge rounded-pill text-bg-danger">Incomplete</span>
                        @endif
                    </td>
                    <td>
                        <input type="date" style="height: 25px;" class="form-control" value="{{ $item->date_joining }}"
                            onchange="change_joining_date({{ $item->id }}, this);">
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
            function change_mail_status(id) {
                $.ajax({
                    url: "{{ route('admin.mails.change_status') }}",
                    type: "POST",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status == "success") {
                            alert('Status changed successfully');
                            location.reload();
                        } else {
                            alert('Failed to change status');
                        }
                    }
                });
            }

            function change_joining_date(id, el) {
                var joinDt = $(el).val();
                console.log(joinDt);

                $.ajax({
                    url: "{{ route('admin.student.joinDt.change') }}",
                    type: "POST",
                    data: {
                        id: id,
                        join_date: joinDt,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status == "success") {
                            location.reload();
                        } else {
                            alert('Failed to Join Date');
                        }
                    }
                });
            }
        </script>
    @endpush
</x-app-layout>

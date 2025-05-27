<x-app-layout>
    <div class="m-3 bg-white">
        <x-admin.breadcrumb title="Reports" isCreate="{{ true }}"
            createLink="{{ route('admin.student.create') }}" />
        <x-table-filter :route="route('admin.mails.index')">
            <p>f ddg</p>
        </x-table-filter>
        @php

            $columns = [
                ['label' => 'Sl No', 'column' => 'id', 'sort' => true],
                ['label' => 'Roll No', 'column' => 'id', 'sort' => true],
                ['label' => 'Name', 'column' => 'name', 'sort' => true],
                ['label' => 'Mobile', 'column' => 'phone', 'sort' => true],
                ['label' => 'Course', 'column' => 'course_id', 'sort' => true],
                ['label' => 'Amount Paid', 'column' => 'date', 'sort' => true],
                ['label' => 'Date', 'column' => 'status', 'sort' => true],
                ['label' => 'Actions', 'column' => 'action', 'sort' => false],
            ];
        @endphp

        <x-table :columns="$columns" :data="$reports" checkAll="{{ false }}" :bulk="route('admin.mails.index', ['customer' => 'bulk'])" :route="route('admin.mails.index')">
            @foreach ($reports as $key => $item)
                @php
                    $actions = [
                        [
                            'code' => 'view',
                            'id' => $item->student?->id,
                        ],
                    ];
                @endphp
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->student?->name }}</td>
                    <td>{{ $item->student?->phone }}</td>
                    <td>{{ $item->course?->course_name }}</td>
                    <td>{{ $item->grand_total }}</td>
                    <td>{{ date('d-m-Y', strtotime($item->paid_date)) }}</td>
                    <td>
                        <x-actions :item="$item" :options="$actions" />
                    </td>
                </tr>
            @endforeach
        </x-table>
    </div>
</x-app-layout>

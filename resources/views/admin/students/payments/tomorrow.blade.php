<x-app-layout>
    <div class="m-3 bg-white">
        <x-admin.breadcrumb title="Today payments" isCreate="{{ false }}" />

        @php
            $columns = [
                ['label' => 'Sl No', 'column' => 'id', 'sort' => false],
                ['label' => 'Roll No', 'column' => 'id', 'sort' => false],
                ['label' => 'Name', 'column' => 'name', 'sort' => false],
                ['label' => 'Mobile', 'column' => 'phone', 'sort' => false],
                ['label' => 'Course', 'column' => 'course_id', 'sort' => false],
                ['label' => 'Course Fee', 'column' => 'grand_total', 'sort' => true],
                ['label' => 'Due Date', 'column' => 'due_date', 'sort' => true],
                ['label' => 'Actions', 'column' => 'action', 'sort' => false],
            ];
        @endphp

        <x-table :columns="$columns" :data="$studentCourses" checkAll="{{ false }}" :bulk="route('admin.payments.tomorrow', ['customer' => 'bulk'])" :route="route('admin.payments.tomorrow')">
            @foreach ($studentCourses as $key => $item)
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
                    <td>{{ $item->student?->f_name . ' ' . $item->student?->l_name }}</td>
                    <td>{{ $item->student?->phone }}</td>
                    <td>{{ $item->course?->course_name }}</td>
                    <td>{{ $item->grand_total }}</td>
                    <td>{{ date('d-m-Y', strtotime($item->due_date)) }}</td>
                    <td>
                        <x-actions :item="$item" :options="$actions" />
                    </td>
                </tr>
            @endforeach
        </x-table>
    </div>
</x-app-layout>

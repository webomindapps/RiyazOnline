<x-app-layout>
    <div class="m-3 bg-white">
        <x-admin.breadcrumb title="Exam Registrations" isCreate="{{ false }}" />
        @php

            $columns = [
                ['label' => 'Sl No', 'column' => 'id', 'sort' => true],
                ['label' => 'Name', 'column' => 'name', 'sort' => false],
                ['label' => 'Email', 'column' => 'emsil', 'sort' => false],
                ['label' => 'Phone', 'column' => 'priority', 'sort' => false],
                ['label' => 'Exam fees', 'column' => 'exam_fee', 'sort' => false],
                ['label' => 'Convinence fee', 'column' => 'convience_fee', 'sort' => false],
                ['label' => 'Total Amount', 'column' => 'total', 'sort' => false],
                ['label' => 'Paid Date', 'column' => 'payment_date', 'sort' => false],
                // ['label' => 'Actions', 'column' => 'action', 'sort' => false],
            ];
        @endphp

        <x-table :columns="$columns" :data="$registrations" checkAll="{{ false }}" :bulk="route('admin.exam.payments', ['customer' => 'bulk'])" :route="route('admin.exam.payments')">
            @foreach ($registrations as $key => $item)
                @php
                    $actions = [
                        // [
                        //     'code' => 'edit',
                        //     'route' => route('admin.registrations.edit', $item->id),
                        // ],
                    ];
                @endphp
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->student?->name }}</td>
                    <td>{{ $item->student?->email }}</td>
                    <td>{{ $item->student?->phone }}</td>
                    <td>{{ $item->exam_fee }}</td>
                    <td>{{ $item->convience_fee }}</td>
                    <td>{{ $item->total }}</td>
                    <td>{{ date('d-m-Y', strtotime($item->payment_date)) }}</td>
                    {{-- <td>
                        <x-actions :item="$item" :options="$actions" />
                    </td> --}}
                </tr>
            @endforeach
        </x-table>
    </div>
</x-app-layout>

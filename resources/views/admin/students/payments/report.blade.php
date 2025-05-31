<x-app-layout>
    <div class="m-3 bg-white">
        <x-admin.breadcrumb title="Reports" isCreate="{{ false }}" />
        @php

            $columns = [
                ['label' => 'Sl No', 'column' => 'id', 'sort' => false],
                ['label' => 'Roll No', 'column' => 'id', 'sort' => false],
                ['label' => 'Name', 'column' => 'name', 'sort' => false],
                ['label' => 'Mobile', 'column' => 'phone', 'sort' => false],
                ['label' => 'Course', 'column' => 'course_id', 'sort' => false],
                ['label' => 'Amount Paid', 'column' => 'grand_total', 'sort' => false],
                ['label' => 'Date', 'column' => 'paid_date', 'sort' => false],
                ['label' => 'Actions', 'column' => 'action', 'sort' => false],
            ];
        @endphp

        <x-table :columns="$columns" :data="$reports" checkAll="{{ false }}" :bulk="route('admin.payments.report', ['customer' => 'bulk'])" :route="route('admin.payments.report')">
            <x-slot name="filters">
                <div class="ms-2 d-flex align-items-center">
                    <label for="from_date" class="me-2">Filter By Date:</label>
                    <input type="date" id="from_date" class="">
                    <label for="to_date" class="ms-2 me-2">To</label>
                    <input type="date" id="to_date" class="">
                </div>
            </x-slot>
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
                    <td>{{ $item->student?->id }}</td>
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
    @push('scripts')
        <script>
            var table = {
                from_date: '',
                to_date: '',
            }
            $(document).ready(function() {
                let from_date = new URLSearchParams(window.location.search).get("from_date");
                let to_date = new URLSearchParams(window.location.search).get("to_date");
                table.from_date = from_date ? from_date : '';
                $('#from_date').val(from_date ? from_date : '');
                table.to_date = to_date ? to_date : '';
                $('#to_date').val(to_date ? to_date : '');

            });
            $('#from_date').on('change', function(e) {
                e.preventDefault();
                table.from_date = $(this).val();
                getRecords();
            });
            $('#to_date').on('change', function(e) {
                e.preventDefault();
                table.to_date = $(this).val();
                getRecords();
            });
        </script>
    @endpush
</x-app-layout>

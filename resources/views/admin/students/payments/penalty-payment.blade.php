<x-app-layout>
    <div class="m-3 bg-white">
        <x-admin.breadcrumb title="Penalty Payments" isCreate="{{ false }}" />

        @php
            $columns = [
                ['label' => 'Sl No', 'column' => 'id', 'sort' => true],
                ['label' => 'Roll No', 'column' => 'id', 'sort' => true],
                ['label' => 'Name', 'column' => 'f_name', 'sort' => true],
                ['label' => 'Mobile', 'column' => 'phone', 'sort' => true],
                ['label' => 'Course & Fees', 'column' => 'course_id', 'sort' => false],
                ['label' => 'Due Date', 'column' => 'due_date', 'sort' => true],
                ['label' => 'Penalty', 'column' => 'penalty', 'sort' => false],
                ['label' => 'Actions', 'column' => 'action', 'sort' => false],
            ];
        @endphp

        <x-table :columns="$columns" :data="$students" checkAll="{{ false }}" :bulk="route('admin.payments.penalty', ['customer' => 'bulk'])" :route="route('admin.payments.penalty')">
            @foreach ($students as $key => $item)
                @php
                    $actions = [
                        [
                            'code' => 'view',
                            'id' => $item->id,
                        ],
                    ];
                    $date1 = date_create($item->studentcourse?->due_date);
                    $date2 = date_create(date('d-m-Y'));
                    $diff = date_diff($date1, $date2);
                    $day_diff = $diff->format('%R%a');
                    if ($day_diff >= 1 && $day_diff <= 7) {
                        $penalty = '350';
                    } elseif ($day_diff >= 8 && $day_diff <= 14) {
                        $penalty = '550';
                    } elseif ($day_diff >= 15 && $day_diff <= 21) {
                        $penalty = '750';
                    } elseif ($day_diff >= 22 && $day_diff <= 28) {
                        $penalty = '950';
                    } elseif ($day_diff >= 29) {
                        $penalty = '1150';
                    }
                @endphp
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->f_name . ' ' . $item->l_name }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>
                        {{ $item->studentcourse?->course_name }}<br>
                        <p>(RS. {{ $item->studentcourse?->course?->old_student_fees }})</p>
                    </td>
                    <td>
                        {{ date('d-m-Y', strtotime($item->studentcourse?->due_date)) }}<br>
                        {{ $diff->format('%a') }} Days
                    </td>
                    <td>
                        Rs. {{ $penalty }}<br>
                        <input type="number" style="width: 100px;height:30px;"
                            value="{{ $item->studentcourse?->penalty }}">
                    </td>
                    <td>
                        <x-actions :item="$item" :options="$actions" />
                    </td>
                </tr>
            @endforeach
        </x-table>
    </div>
</x-app-layout>

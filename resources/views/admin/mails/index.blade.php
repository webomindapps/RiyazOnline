<x-app-layout>
    <div class="m-3 bg-white">
        <x-admin.breadcrumb title="Admin Mails" isCreate="{{ true }}" createLink="{{ route('admin.mails.create') }}" />
        @php

            $columns = [
                ['label' => 'Sl No', 'column' => 'id', 'sort' => true],
                ['label' => 'Name', 'column' => 'name', 'sort' => true],
                ['label' => 'Email', 'column' => 'email', 'sort' => true],
                ['label' => 'Status', 'column' => 'status', 'sort' => true],
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

        <x-table :columns="$columns" :data="$mails" checkAll="{{ false }}" :bulk="route('admin.mails.index', ['customer' => 'bulk'])" :route="route('admin.mails.index')">
            @foreach ($mails as $key => $item)
                @php
                    $actions = [
                        [
                            'code' => 'delete',
                            'route' => route('admin.mails.delete', $item->id),
                        ]
                    ];
                @endphp
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>
                        <label class="switch">
                            <input {{ $item->status == 1 ? 'checked' : '' }} type="checkbox"
                                onchange="change_mail_status({{ $item->id }});">
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
                        } else {
                            alert('Failed to change status');
                        }
                    }
                });
            }
        </script>
    @endpush
</x-app-layout>

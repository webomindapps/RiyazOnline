<x-app-layout>
    <div class="m-3 bg-white">
        <x-admin.breadcrumb title="Email Templates" isCreate="{{ true }}"
            createLink="{{ route('admin.templates.create') }}" />
        @php

            $columns = [
                ['label' => 'Sl No', 'column' => 'id', 'sort' => true],
                ['label' => 'Title', 'column' => 'title', 'sort' => true],
                ['label' => 'Priority', 'column' => 'priority', 'sort' => true],
                ['label' => 'Content', 'column' => 'content', 'sort' => false],
                ['label' => 'Actions', 'column' => 'action', 'sort' => false],
            ];
        @endphp

        <x-table :columns="$columns" :data="$templates" checkAll="{{ false }}" :bulk="route('admin.templates.index', ['customer' => 'bulk'])" :route="route('admin.templates.index')">
            @foreach ($templates as $key => $item)
                @php
                    $actions = [
                        [
                            'code' => 'edit',
                            'route' => route('admin.templates.edit', $item->id),
                        ],
                    ];
                @endphp
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->priority }}</td>
                    <td>{{ $item->content }}</td>
                    <td>
                        <x-actions :item="$item" :options="$actions" />
                    </td>
                </tr>
            @endforeach
        </x-table>
    </div>
</x-app-layout>

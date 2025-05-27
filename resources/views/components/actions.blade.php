@props(['item', 'options'])

<div class="dropdown pop_Up dropdown_bg">
    <div class="dropdown-toggle" id="dropdownMenuButton-{{ $item->id }}" data-bs-toggle="dropdown" aria-expanded="true"
        style="cursor: pointer">
        Action
    </div>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-{{ $item->id }}">
        @foreach ($options as $option)
            @php
                $code = $option['code'] ?? '';
                $route = $option['route'] ?? '#';
                $itmid = $option['id'] ?? '#';
                $additional = $option['additional'] ?? [];
            @endphp

            @switch($code)
                @case('simple')
                    <li>
                        <a href="{{ $route }}" class="dropdown-item">
                            <i class="{{ $additional['icon'] ?? '' }}"></i> {{ $additional['label'] ?? 'Action' }}
                        </a>
                    </li>
                @break

                @case('active')
                    <li>
                        <a class="dropdown-item singleItem" data-type="2" data-id="{{ $item->id }}" data-value="1">
                            <i class="fas fa-check-circle"></i> Active
                        </a>
                    </li>
                @break

                @case('inactive')
                    <li>
                        <a class="dropdown-item singleItem" data-type="2" data-id="{{ $item->id }}" data-value="0">
                            <i class="fas fa-file-exclamation"></i> InActive
                        </a>
                    </li>
                @break

                @case('delete')
                    <li>
                        <a class="dropdown-item" onclick="return confirm('Are you sure?')" href="{{ $route }}">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                    </li>
                @break

                @case('edit')
                    <li>
                        <a class="dropdown-item" href="{{ $route }}">
                            <i class="bi bi-pencil-square"></i> Edit Details
                        </a>
                    </li>
                @break

                @case('view')
                    <li>
                        <a class="dropdown-item view-student-detail" href="javascript:void(0)" data-id="{{ $itmid }}">
                            <i class="bi bi-eye"></i> View Details
                        </a>
                    </li>
                @break

                @default
                    <li>
                        <a class="dropdown-item {{ $code }}" data-item="{{ $item }}" data-type="info"
                            data-id="{{ $item->id }}">
                            <i class="fa fa-info-circle"></i> {{ $code }}
                        </a>
                    </li>
            @endswitch
        @endforeach
    </ul>
</div>

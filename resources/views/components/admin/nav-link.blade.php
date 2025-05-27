@props(['href' => '', 'icon' => '', 'class' => '', 'active' => false])

@php
    $classes = $active ? 'active' : '';
    $classes .= ' ' . $class;
@endphp

<li class="{{ $classes }}">
    <a href="{{ $href }}" class="menu_link">
        <span class="menu_icon"><i class="{{ $icon }}"></i></span>
        <span class="menu_text">{{ $slot }}</span>
    </a>
</li>

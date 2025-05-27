<!-- Sidebar -->
<div id="sidebar" class="sidebar">
    <div class="logo-holder">
        <div class="logo" style="filter: invert(1);">
            <img src="{{ asset('backend/logo.png') }}" alt="">
        </div>
        <button id="toggleSidebar" class="toggle-btn">☰</button>
    </div>
    <div class="menu-holder">
        <ul class="menu">
            @foreach ($menus as $key => $menu)
                <x-admin.nav-link :href="route($menu['route'], $menu['params'] ?? [])" class="menu_item" icon="{{ $menu['icon'] }}" :active="request()->routeIs($menu['route'])">
                    {{ $menu['title'] }}
                </x-admin.nav-link>
            @endforeach
            {{-- <li class="menu_item has_dropdown">
                <a href="" class="dropdwn_toggler menu_link">
                    <span class="menu_icon"><i class="bi bi-gear"></i></span>
                    <span class="menu_text">CMS</span>
                </a>
                <ul class="dropdwn-mnu collapsed">
                    <li class="dropdwn-mnu-item">
                        <a href="">Banners</a>
                    </li>
                    <li class="dropdwn-mnu-item">
                        <a href="">Pages</a>
                    </li>
                    <li class="dropdwn-mnu-item">
                        <a href="">Sliders</a>
                    </li>
                </ul>
            </li> --}}
        </ul>
    </div>
</div>
<!-- End Sidebar -->

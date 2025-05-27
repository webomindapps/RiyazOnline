<div class="top-header">
    <div class="header-holder">
        <div class="header profile-toggle">
            <img src="{{ asset('backend/user.png') }}" alt="User Profile">
        </div>
        <ul class="profile-dropdown">
            <li class="profile-dropdown-item">
                <a href="{{ route('profile.edit') }}" class="profile-dropdown-link">
                    <span class="me-2"><i class="bi bi-person"></i></span>
                    Profile
                </a>
            </li>
            <li class="profile-dropdown-item">
                <a href="{{ route('logout') }}" class="profile-dropdown-link">
                    <span class="me-2"><i class="bi bi-box-arrow-right"></i></span>
                    Logout
                </a>
            </li>
        </ul>
    </div>
</div>

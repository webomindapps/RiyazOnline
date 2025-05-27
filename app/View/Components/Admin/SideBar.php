<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SideBar extends Component
{
    public $menus = [
        [
            'title' => 'Dashboard',
            'icon' => 'bi bi-speedometer2',
            'route' => 'admin.dashboard',
            'isSubMenu' => false,
        ],
        [
            'title' => 'Course',
            'icon' => 'bi bi-journals',
            'route' => 'admin.courses.index',
            'isSubMenu' => false,
        ],
        [
            'title' => 'New Student',
            'icon' => 'bi bi-person-vcard',
            'route' => 'admin.students.new',
            'isSubMenu' => false,
        ],
        [
            'title' => 'Student Master',
            'icon' => 'bi bi-person-video2',
            'route' => 'admin.all.students',
            'isSubMenu' => false,
        ],
        [
            'title' => 'Today Payments',
            'icon' => 'bi bi-person-lock',
            'route' => 'admin.payments.today',
            'isSubMenu' => false,
        ],
        [
            'title' => 'Tomorrow Payments',
            'icon' => 'bi bi-person-lock',
            'route' => 'admin.payments.tomorrow',
            'isSubMenu' => false,
        ],
        [
            'title' => '3 Days Payments',
            'icon' => 'bi bi-person-lock',
            'route' => 'admin.payments.threeday',
            'isSubMenu' => false,
        ],
        [
            'title' => '7 Days Payments',
            'icon' => 'bi bi-person-lock',
            'route' => 'admin.payments.sevenday',
            'isSubMenu' => false,
        ],
        [
            'title' => 'Penalty Payments',
            'icon' => 'bi bi-person-lock',
            'route' => 'admin.payments.penalty',
            'isSubMenu' => false,
        ],
        [
            'title' => 'Attrition Students',
            'icon' => 'bi bi-person-slash',
            'route' => 'admin.students.disabled',
            'isSubMenu' => false,
        ],
        [
            'title' => 'Reports',
            'icon' => 'bi bi-card-list',
            'route' => 'admin.payments.report',
            'isSubMenu' => false,
        ],
        [
            'title' => 'Admin Mails',
            'icon' => 'bi bi-envelope-at',
            'route' => 'admin.mails.index',
            'isSubMenu' => false,
        ],
        [
            'title' => 'Email Templates',
            'icon' => 'bi bi-blockquote-left',
            'route' => 'admin.templates.index',
            'isSubMenu' => false,
        ],
        [
            'title' => 'Countries',
            'icon' => 'bi bi-globe-americas',
            'route' => 'admin.countries.index',
            'isSubMenu' => false,
        ],
    ];

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.side-bar');
    }
}

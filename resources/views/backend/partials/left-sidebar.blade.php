<aside class="main-sidebar sidebar-dark-primary">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link text-center">
        <img src="{{ asset('/') }}back/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
             class="brand-image">
        <img src="{{ asset('/') }}back/dist/img/img2.png" alt="AdminLTE Logo"
             class="brand-image-logo" height="33">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-none">
            <div class="image">
                <img
                    src="{{ Auth::user()->profile_photo_path ? asset('/storage/'.Auth::user()->profile_photo_path) : Auth::user()->profile_photo_url }}"
                    class="img-circle elevation-2" alt="User Image">
                {{-- <img src="{{ asset('/storage/'.Auth::user()->profile_photo_path) }}" alt="{{ auth()->user()->name }}" class="rounded-full h-20 w-20 object-cover"> --}}
            </div>
            <div class="info">
                <a href="/user/profile" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">MENU</li>
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link {{ Route::is('dashboard') ? 'active':'' }}">
                        <i class="fa-duotone fa-desktop main-icon"></i>
                        <p>{{ __('global.dashboard') }}</p>
                    </a>
                </li>
                <li class="nav-header">MODÜLLER</li>
                <li class="nav-item {{ Route::is('vehicles.index') ? 'menu-is-opened menu-open':'' }}">
                    <a href="#" class="nav-link">
                        <i class="fa-duotone fa-truck-container main-icon"></i>
                        <p>{{ __('vehicles.module_title') }} <i data-feather="chevron-right" class="right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('vehicles.index') }}"
                               class="nav-link {{ Route::is('vehicles.index') ? 'active':'' }}">
                                <p>{{ __('vehicles.module_title') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('vehicles.add') }}"
                               class="nav-link {{ Route::is('vehicles.add') ? 'active':'' }}">
                                <p>{{ __('vehicles.add_vehicle') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ Route::is('locations.index') ? 'menu-is-opened menu-open':'' }}">
                    <a href="#" class="nav-link">
                        <i class="fa-duotone fa-map-location-dot main-icon"></i>
                        <p>{{ __('locations.module_title') }} <i data-feather="chevron-right" class="right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('locations.index') }}"
                               class="nav-link {{ Route::is('locations.index') ? 'active':'' }}">
                                <p>{{ __('locations.module_title') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('locations.add') }}"
                               class="nav-link {{ Route::is('locations.add') ? 'active':'' }}">
                                <p>{{ __('locations.add_location') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ Route::is('materials.index') ? 'menu-is-opened menu-open':'' }}">
                    <a href="#" class="nav-link">
                        <i class="fa-duotone fa-scanner-gun main-icon"></i>
                        <p>{{ __('materials.module_title') }} <i data-feather="chevron-right" class="right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('materials.index') }}"
                               class="nav-link {{ Route::is('materials.index') ? 'active':'' }}">
                                <p>{{ __('materials.module_title') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('materials.add') }}"
                               class="nav-link {{ Route::is('materials.add') ? 'active':'' }}">
                                <p>{{ __('materials.add_material') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ Route::is('employees.index') ? 'menu-is-opened menu-open':'' }}">
                    <a href="#" class="nav-link">
                        <i class="fa-duotone fa-person-dolly-empty main-icon"></i>
                        <p>{{ __('employees.module_title') }} <i data-feather="chevron-right" class="right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('employees.index') }}"
                               class="nav-link {{ Route::is('employees.index') ? 'active':'' }}">
                                <p>{{ __('employees.module_title') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('employees.add') }}"
                               class="nav-link {{ Route::is('employees.add') ? 'active':'' }}">
                                <p>{{ __('employees.add_employee') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ Route::is('tasks.index') ? 'menu-is-opened menu-open':'' }}">
                    <a href="#" class="nav-link">
                        <i class="fa-duotone fa-list-check main-icon"></i>
                        <p>{{ __('tasks.module_title') }} <i data-feather="chevron-right" class="right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('tasks.index') }}"
                               class="nav-link {{ Route::is('tasks.index') ? 'active':'' }}">
                                <p>{{ __('tasks.module_title') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('tasks.add') }}"
                               class="nav-link {{ Route::is('tasks.add') ? 'active':'' }}">
                                <p>{{ __('tasks.add_task') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- MODULES AREA -->
                <li class="nav-header">AYARLAR</li>
                <li class="nav-item {{ Route::is('settings.index') || Route::is('admin.options.homepage') || Route::is('admin.options.contact') ? 'menu-is-opened menu-open':'' }}">
                    <a href="#"
                       class="nav-link {{ Route::is('settings.index') ? 'active':'' }}">
                        <i class="fa-duotone fa-screwdriver-wrench main-icon"></i>
                        <p>{{ __('settings.module_title') }} <i class="fa-regular fa-chevron-right right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('settings.index') }}"
                               class="nav-link {{ Route::is('settings.index') ? 'active':'' }}">
                                <p>{{ __('settings.site_settings') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ Route::is('defines.index') || Route::is('defines.show.edit') ? 'menu-is-opened menu-open':'' }}">
                    <a href="#"
                       class="nav-link {{ Route::is('defines.index') || Route::is('defines.show.edit') ? 'active':'' }}">
                        <i class="fa-duotone fa-book-font main-icon"></i>
                        <p>{{ __('defines.module_title') }} <i class="fa-regular fa-chevron-right right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @foreach($defines as $define)
                            <li class="nav-item">
                                <a href="{{ route('defines.show.edit', ['type' => $define->type]) }}"
                                   class="nav-link {{ Route::is('defines.show.edit',  ['type' => $define->type]) ? 'active':'' }}">
                                    <p>{{ $define->name }}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item {{ Route::is('users.index') ? 'menu-is-opened menu-open':'' }}">
                    <a href="#" class="nav-link">
                        <i class="fa-duotone fa-users main-icon"></i>
                        <p>{{ __('users.module_title') }} <i class="fa-regular fa-chevron-right right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}"
                               class="nav-link {{ Route::is('users.index') ? 'active':'' }}">

                                <p>{{ __('users.module_title') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users.add') }}"
                               class="nav-link {{ Route::is('users.add') ? 'active':'' }}">

                                <p>{{ __('users.add_user') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ Route::is('languages.index') ? 'menu-is-opened menu-open':'' }}">
                    <a href="#" class="nav-link">
                        <i class="fa-duotone fa-language main-icon"></i>
                        <p>
                            Dil ve Çeviri
                            <i class="fa-regular fa-chevron-right right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('languages.index') }}"
                               class="nav-link {{ Route::is('languages.index') ? 'active':'' }}">

                                <p>Diller</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('translations.index') }}" class="nav-link">

                                <p>Çeviriler</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

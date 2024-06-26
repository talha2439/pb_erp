<ul class="sidebar-vertical">
    {{-- Menu Settings --}}
    @forelse ($data['menu'] as $menu )
        @if ($menu->has_sub == 0)
            @if (!empty($menu->menu_title))
                <li class="menu-title"><span>{{ $menu->menu_title }}</span></li>
            @endif
            <li><a href="{{ route($menu->route) }}"
                    @if (Route::is($menu->route)) class=" active " @else @endif><i
                        class="{{ $menu->icon }}"></i> <span> {{ $menu->name }}</a></li>
        @else
            @if (!empty($menu->menu_title))
                <li class="menu-title"><span>{{ $menu->menu_title }}</span></li>
            @endif
            <li class="submenu dynamic_menu">
                <a href="#" class="active_link"><i class="{{ $menu->icon }}"></i> <span>
                        {{ $menu->name }} </span> <span class="menu-arrow"></span></a>
                <ul style="display: none;">

                    @foreach ($menu->submenu as $submenu)
                        <li data-route="{{ $submenu->route }}"
                            class="menu-link  dynamic_sub_menu d-flex ">
                            <a class="d-flex @if (Route::is($submenu->route)) active @endif"
                                href="{{ route(@$submenu->route) }}">
                                <i class="fe fe-plus"></i>&nbsp;
                                <div>{{ @$submenu->name }}</div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>

            <li>
        @endif
    @empty
    @endforelse
    @if (Auth::user()->role == 1)
        <li class="menu-title"><span>Settings</span></li>

        <li class="submenu">
            <a href="#"><i class="fe fe-settings"></i> <span> Settings </span> <span
                    class="menu-arrow"></span></a>
            <ul style="display: none;">
                <li class="submenu">
                    <a href="#"><i class="fe fe-sidebar"></i> <span> Side Bar menus </span>
                        <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="{{ route('menusettings.create') }}">Create</a></li>
                        <li><a href="{{ route('menusettings.index') }}">All</a></li>

                    </ul>
                </li>

                <li>
                    <li
                    class="menu-link  dynamic_sub_menu d-flex ">
                    <a href="{{ route('settings.create') }}"><i class="fe fe-settings"></i> <span> Panel Settings</span>
                </li>
            </ul>
        </li>

        @endif
            <li>

    <a href="{{ route('auth.logout') }}"><i class="fe fe-power"></i> <span>Logout</span></a>
    </li>
</ul>

{{-- <li class="menu-item menu-item-submenu {{ strpos(Route::currentRouteName(), 'region.place') === 0 || strpos(Route::currentRouteName(), 'region.place') === 0 ? 'menu-item-open' : '' }}"
    aria-haspopup="true" data-menu-toggle="hover">

    <a href="javascript:;" class="menu-link menu-toggle">
        <i class="menu-icon flaticon-lock"></i>
        <span class="menu-text">Placement Report</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="menu-submenu">
        <i class="menu-arrow"></i>
        <ul class="menu-subnav">

            <li class="menu-item {{ strpos(Route::currentRouteName(), 'region.place') === 0 ? 'menu-item-active' : '' }}"
                aria-haspopup="true">
                <a href="{{ route('session.placement', []) }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text"> View Placement</span>
                </a>

            </li>

            <li class="menu-item {{ strpos(Route::currentRouteName(), 'role.index') === 0 ? 'menu-item-active' : '' }}"
                aria-haspopup="true">
                <a href="{{ route('role.index', []) }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text"> Report</span>
                </a>
            </li>
            <li class="menu-item {{ strpos(Route::currentRouteName(), 'permission.index') === 0 ? 'menu-item-active' : '' }}"
                aria-haspopup="true">
                <a href="{{ route('permission.index', []) }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text">Aproval</span>
                </a>
            </li>
        </ul>
    </div>
</li> --}}

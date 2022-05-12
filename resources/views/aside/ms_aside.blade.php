<li class="menu-item menu-item-submenu {{ strpos(Route::currentRouteName(), 'training_session') === 0 ? 'menu-item-open' : '' }}"
    aria-haspopup="true" data-menu-toggle="hover">

    <a href="javascript:;" class="menu-link menu-toggle">
        <i class="menu-icon flaticon-calendar-1"></i>
        <span class="menu-text">Volunteer Program</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="menu-submenu">
        <i class="menu-arrow"></i>
        <ul class="menu-subnav">
            <li class="menu-item menu-item-parent" aria-haspopup="true">
                <span class="menu-link">
                    <span class="menu-text">User</span>
                </span>
            </li>
            <li class="menu-item {{ strpos(Route::currentRouteName(), 'training_session.index') === 0 ? 'menu-item-active' : '' }}"
                aria-haspopup="true">
                <a href="{{ route('training_session.index', []) }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text">All Programs</span>
                </a>
            </li>
            <li class="menu-item {{ strpos(Route::currentRouteName(), 'training_session.create') === 0 ? 'menu-item-active' : '' }}"
                aria-haspopup="true">
                <a href="{{ route('training_session.create', []) }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text">Add Program</span>
                </a>
            </li>
        </ul>
    </div>
</li>
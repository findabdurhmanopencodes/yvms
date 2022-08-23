@can('region.index')
    <li class="menu-item {{ strpos(Route::currentRouteName(), 'region.index') === 0 ? 'menu-item-active' : '' }}"
    aria-haspopup="true">
        <a href="{{ route('region.index', []) }}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
                <span></span>
            </i>
            <span class="menu-text">Region</span>
        </a>
        </li>
@endcan
@can('zone.index')
    <li class="menu-item {{ strpos(Route::currentRouteName(), 'zone.index') === 0 ? 'menu-item-active' : '' }}"
    aria-haspopup="true">
        <a href="{{ route('zone.index', []) }}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
                <span></span>
            </i>
            <span class="menu-text">Zone</span>
        </a>
    </li>
@endcan
@can('woreda.index')
    <li class="menu-item {{ strpos(Route::currentRouteName(), 'woreda.index') === 0 ? 'menu-item-active' : '' }}"
    aria-haspopup="true">
        <a href="{{ route('woreda.index', []) }}" class="menu-link">
            <i class="menu-bullet menu-bullet-dot">
                <span></span>
            </i>
            <span class="menu-text">Woreda</span>
        </a>
    </li>
@endcan

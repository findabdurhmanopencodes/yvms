<li class="menu-item {{ strpos(Route::currentRouteName(), 'educational_level.index') === 0 ? 'menu-item-active' : '' }}"
            aria-haspopup="true">
            <a href="{{ route('educational_level.index', []) }}" class="menu-link">
                <i class="menu-bullet menu-bullet-dot">
                    <span></span>
                </i>
                <span class="menu-text">Educational Level</span>
            </a>
        </li>
        <li class="menu-item {{ strpos(Route::currentRouteName(), 'feild_of_study.index') === 0 ? 'menu-item-active' : '' }}"
            aria-haspopup="true">
            <a href="{{ route('feild_of_study.index', []) }}" class="menu-link">
                <i class="menu-bullet menu-bullet-dot">
                    <span></span>
                </i>
                <span class="menu-text"> Fields of Study</span>
            </a>
        </li>
        <li class="menu-item {{ strpos(Route::currentRouteName(), 'woreda.index') === 0 ? 'menu-item-active' : '' }}"
            aria-haspopup="true">
            <a href="{{ route('disablity.index', []) }}" class="menu-link">
                <i class="menu-bullet menu-bullet-dot">
                    <span></span>
                </i>
                <span class="menu-text">Disablity Type</span>
            </a>
        </li>
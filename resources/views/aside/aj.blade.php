<li class="menu-item {{ strpos(Route::currentRouteName(), 'TrainingCenter.index') === 0 ? 'menu-item-active' : '' }}"
    aria-haspopup="true">
    <a href="{{ route('TrainingCenter.index', []) }}" class="menu-link">
        <i class="menu-bullet menu-bullet-dot">
            <span></span>
        </i>
        <span class="menu-text">Training Center</span>
    </a>
</li>

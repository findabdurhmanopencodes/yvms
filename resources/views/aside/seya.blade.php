<li class="menu-item {{ strpos(Route::currentRouteName(), 'feild_of_study.index') === 0 ? 'menu-item-active' : '' }}"
    aria-haspopup="true">
    <a href="{{ route('feild_of_study.index', []) }}" class="menu-link">
        <i class="menu-bullet menu-bullet-dot">
            <span></span>
        </i>
        <span class="menu-text">Field of study</span>
    </a>
</li>


<li class="menu-item {{ strpos(Route::currentRouteName(), 'payment_type') === 0 ? 'menu-item-active' : '' }}"
    aria-haspopup="true">
    <a href="{{ route('paymentType.index',[]) }}" class="menu-link">
        <i class="menu-bullet menu-bullet-dot">
            <span></span>
        </i>
        <span class="menu-text"> Payment type</span>
    </a>
</li>


<li class="menu-item {{ strpos(Route::currentRouteName(), 'distance') === 0 ? 'menu-item-active' : '' }}"
    aria-haspopup="true">
    <a href="{{ route('distance.index',[]) }}" class="menu-link">
        <i class="menu-bullet menu-bullet-dot">
            <span></span>
        </i>
        <span class="menu-text"> Distance setting</span>
    </a>
</li>

{{-- <li class="menu-item {{ strpos(Route::currentRouteName(), 'disablity.index') === 0 ? 'menu-item-active' : '' }}"
    aria-haspopup="true">
    <a href="{{ route('disablity.index', []) }}" class="menu-link">
        <i class="menu-bullet menu-bullet-dot">
            <span></span>
        </i>
        <span class="menu-text">Disability Type</span>
    </a>
</li> --}}

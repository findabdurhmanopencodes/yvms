@canany(['payroll.list', 'payroll.report'])
    <li class="menu-item menu-item-submenu {{ strpos(Route::currentRouteName(), 'payroll') === 0 ? 'menu-item-open' : '' }}"
    aria-haspopup="true" data-menu-toggle="hover">

        <a href="javascript:;" class="menu-link menu-toggle">
            <i class="menu-icon fa fa-list"></i>

            <span class="menu-text"> Payroll </span>
            <i class="menu-arrow"></i>
        </a>
        <div class="menu-submenu">
            <i class="menu-arrow"></i>
            <ul class="menu-subnav">



                @can('payroll.list')
                    <li class="menu-item {{ strpos(Route::currentRouteName(), 'payroll.index') === 0 ? 'menu-item-active' : '' }}"
                    aria-haspopup="true">
                        <a href="{{ route('payroll.index') }}" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span class="menu-text"> List of payrolls</span>
                        </a>
                    </li>
                @endcan

{{--
                @can('payroll.list') --}}
                <li class="menu-item {{ strpos(Route::currentRouteName(), 'payrollSheet.monthly') === 0 ? 'menu-item-active' : '' }}"
                aria-haspopup="true">
                    <a href="{{ route('payrollSheet.monthly') }}" class="menu-link">
                        <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i>
                        <span class="menu-text"> Montly Payment </span>
                    </a>
                </li>
                {{-- @endcan --}}


                @can('payroll.report')
                    <li class="menu-item {{ strpos(Route::currentRouteName(), 'paymentReport') === 0 ? 'menu-item-active' : '' }}"
                    aria-haspopup="true">
                        <a href="{{ route('paymentReport.index') }} " class="menu-link">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span class="menu-text"> Payment report</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
</li>
@endcanany

<ul class="menu-nav" id="item-color">
  
    <li class="menu-item {{ strpos(Route::currentRouteName(), 'home') === 0 ? 'menu-item-active' : '' }}">
        <a href="{{ route('home') }}" class="menu-link">
            <i  style="color:#5dade2 !important;" class=" fa fa-home"></i>
            <span class="menu-text">&nbsp; Home</span>
            <i class="menu-arrow"></i>
        </a>
    </li>
   
    <li class="menu-item {{ strpos(Route::currentRouteName(), 'aboutus') === 0 ? 'menu-item-active' : '' }}">
        <a  href="{{ route('aboutus') }}" class="menu-link">
            <i  style="color:#5dade2 !important;" class=" fa fa-flag"></i>
            <span  style="color:#5dade2 !important;" class="menu-text"> &nbsp; About Us</span>
            <i class="menu-arrow"></i>
        </a>
    </li>
    
    <li class="menu-item {{ strpos(Route::currentRouteName(), 'contactus') === 0 ? 'menu-item-active' : '' }}">
        <a href="{{ route('contactus') }}" class="menu-link menu-toggle">
            <i  style="color:#5dade2 !important;" class="fa fa-address-book"></i>


            <span  style="color:#5dade2 !important;" class="menu-text"> &nbsp; Contact Us</span>
            <i class="menu-arrow"></i>
        </a>
    </li>

    <li class="menu-item {{ strpos(Route::currentRouteName(), 'vission-and-mission') === 0 ? 'menu-item-active' : '' }}">
        <a href="{{ route('vission-and-mission') }}" class="menu-link menu-toggle">
            <i  style="color:#5dade2 !important;" class="fa fa-eye"></i>
            <span  style="color:#5dade2 !important;" class="menu-text"> &nbsp; Vision & Mision </span>
            <i class="menu-arrow"></i>
        </a>
    </li>
    <li class="menu-item {{ strpos(Route::currentRouteName(), 'login') === 0 ? 'menu-item-active' : '' }}">
        <a href="{{ route('login') }}" class="menu-link menu-toggle">
            <i  style="color:#5dade2 !important;" class="fas fa-sign-in-alt"></i>


            <span  style="color:#5dade2 !important;" class="menu-text"> &nbsp; Login </span>
            <i class="menu-arrow"></i>
        </a>
    </li>
</ul>
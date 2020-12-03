<aside id="leftsidebar" class="sidebar">
    <div class="navbar-brand">
        <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
        <a href="index.html"><img src="{{ asset('backend/images/logo.svg') }}" width="25" alt="Aero"><span class="m-l-10">Aero</span></a>
    </div>
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info">
                    <a class="image" href="profile.html"><img src="{{ asset('backend/images/profile_av.jpg') }}" alt="User"></a>
                    <div class="detail">
                        <h4>Michael</h4>
                        <small>Super Admin</small>
                    </div>
                </div>
            </li>
            <li class="active open"><a href=""><i class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>
            <li><a href="{{ route('add.farmer') }}" class="waves-effect waves-block"><i class="zmdi zmdi-apps"></i><span>Farmer</span></a>
            </li>
            <li><a href="{{ route('admin.collection') }}" class="waves-effect waves-block"><i class="zmdi zmdi-shopping-cart"></i><span>Collection Center</span></a></li>
            <li><a href="{{ route('admin.milk') }}" class="waves-effect waves-block"><i class="zmdi zmdi-shopping-cart"></i><span>Milk Data</span></a></li>
            <li><a href="{{ route('logout') }}" class="waves-effect waves-block" target="_top"><i class="zmdi zmdi-power"></i><span>Sign Out</span></a></li>
        </ul>
    </div>
</aside>
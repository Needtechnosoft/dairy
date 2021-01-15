<aside id="leftsidebar" class="sidebar">
    <div class="navbar-brand">
        <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
        <a href="index.html"><img src="{{ asset('backend/images/logo.svg') }}" width="25" alt="Aero"><span class="m-l-10">Dairy Management</span></a>
    </div>
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info">
                    <a class="image" href="profile.html"><img src="{{ asset('backend/images/user.png') }}" alt="User"></a>
                    <div class="detail">
                        <h4>Admin</h4>
                        <small>Super Admin</small>
                    </div>
                </div>
            </li>
            <li class="active open"><a href="{{ route('admin.dashboard')}}"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>
            <li><a href="javascript:void(0);" class="waves-effect waves-block menu-toggle"><i class="zmdi zmdi-apps"></i><span>Farmer</span></a>
                <ul class="ml-menu">
                    <li><a href="{{ route('admin.farmer') }}" class="waves-effect waves-block">Farmer List</a></li>
                    <li><a href="{{ route('admin.farmer.advance') }}" class="waves-effect waves-block">Advance</a></li>
                    <li><a href="{{ route('admin.farmer.due') }}" class="waves-effect waves-block">Due Payment</a></li>
                    <li><a href="{{ route('admin.farmer.due.add.list') }}" class="waves-effect waves-block">Previous Balance</a></li>
                </ul>
            </li>

            <li><a href="javascript:void(0);" class="waves-effect waves-block menu-toggle"><i class="zmdi zmdi-shopping-cart"></i><span>Milk Collection</span></a>
                <ul class="ml-menu">
                    <li><a href="{{ route('admin.collection') }}" class="waves-effect waves-block">Manage Collection Center</a></li>
                    <li><a href="{{ route('admin.milk') }}" class="waves-effect waves-block"> Milk Collection</a></li>
                    <li><a href="{{ route('admin.snf.fat') }}" class="waves-effect waves-block">Add Fat & Snf</a></li>
                </ul>
            </li>
            <li><a href="javascript:void(0);" class="waves-effect waves-block menu-toggle"><i class="zmdi zmdi-shopping-cart"></i><span>Items</span></a>
                <ul class="ml-menu">
                    <li><a href="{{ route('admin.item') }}" class="waves-effect waves-block">Add Item</a></li>
                    <li><a href="{{ route('admin.sell.item') }}" class="waves-effect waves-block">Sell Items</a></li>
                </ul>
            </li>
            @if (env('tier',1)==1)
            <li><a href="javascript:void(0);" class="waves-effect waves-block menu-toggle"><i class="zmdi zmdi-shopping-cart"></i><span>Distributers</span></a>
                <ul class="ml-menu">
                    <li><a href="{{ route('admin.dis') }}" class="waves-effect waves-block">Distributer List</a></li>
                    <li><a href="{{ route('admin.dis.sell') }}" class="waves-effect waves-block">Distributer Sell</a></li>
                    <li><a href="{{ route('admin.dis.payemnt') }}" class="waves-effect waves-block">payment</a></li>
                    <li><a href="{{ route('distributer.detail.opening') }}" class="waves-effect waves-block">Account Opening</a></li>
                </ul>
            </li>

            <li><a href="javascript:void(0);" class="waves-effect waves-block menu-toggle"><i class="zmdi zmdi-shopping-cart"></i><span>Suppliers</span></a>
                <ul class="ml-menu">
                    <li><a href="{{ route('admin.sup') }}" class="waves-effect waves-block">Supplier List</a></li>
                    <li><a href="{{ route('admin.sup.bill') }}" class="waves-effect waves-block">Supplier Bill</a></li>
                </ul>
            </li>
            <li><a href="{{ route('admin.exp') }}" class="waves-effect waves-block"><i class="zmdi zmdi-shopping-cart"></i><span>Expenses</span></a></li>
            <li><a href="{{ route('admin.emp') }}" class="waves-effect waves-block"><i class="zmdi zmdi-shopping-cart"></i><span>Employees</span></a></li>
            <li><a href="{{route('product.home')}}" class="waves-effect waves-block"><i class="zmdi zmdi-shopping-cart"></i><span>Products</span></a></li>
            @endif
            <li><a href="{{ route('report.home') }}" class="waves-effect waves-block"><i class="zmdi zmdi-shopping-cart"></i><span>Report</span></a></li>
            <li><a href="{{ route('logout') }}" class="waves-effect waves-block" target="_top"><i class="zmdi zmdi-power"></i><span>Sign Out</span></a></li>
        </ul>
    </div>
</aside>

@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu">

            <li class="{{ $request->segment(1) == 'home' ? 'active' : '' }}">
                <a href="{{ url('/admin') }}">
                    <i class="fa fa-wrench"></i>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            
           
            <li class="treeview">
                <a href="javascript:void(0);">
                    <i class="fa fa-users"></i>
                    <span class="title">User Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $request->segment(2) == 'permission' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.permission')}}"> 
                            <i class="fa fa-briefcase"></i>
                            <span class="title">
                               Permissions
                            </span>
                        </a>
                    </li>
                    <li class="{{ $request->segment(2) == 'roles' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.roles')}}"> 
                            <i class="fa fa-briefcase"></i>
                            <span class="title">
                               Roles
                            </span>
                        </a>
                    </li>
                     <li class="{{ $request->segment(2) == 'users' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.users')}}"> 
                            <i class="fa fa-briefcase"></i>
                            <span class="title">
                               Users
                            </span>
                        </a>
                    </li>
                    <!--<li class="{{ $request->segment(2) == 'roles' ? 'active active-sub' : '' }}">
                        <a href=""> 
                            <i class="fa fa-briefcase"></i>
                            <span class="title">
                               Roles
                            </span>
                        </a>
                    </li>
                    <li class="{{ $request->segment(2) == 'users' ? 'active active-sub' : '' }}">
                        <a href="#">
                            <i class="fa fa-user"></i>
                            <span class="title">
                                Users
                            </span>
                        </a>
                    </li> -->
                </ul>
            </li>
           

            <li class="{{ $request->segment(2) == 'change_password' ? 'active' : '' }}">
                <a href="{{ route('admin.change_password')}}">
                    <i class="fa fa-key"></i>
                    <span class="title">Change password</span>
                </a>
            </li>

            <li>
                <a href="#logout" onclick="$('#logout').submit();">
                    <i class="fa fa-arrow-left"></i>
                    <span class="title">Logout</span>
                </a>
            </li>
        </ul>
    </section>
</aside>
{!! Form::open(['route' => 'adminlogout', 'style' => 'display:none;', 'id' => 'logout']) !!}
<button type="submit">Logout</button>
{!! Form::close() !!}

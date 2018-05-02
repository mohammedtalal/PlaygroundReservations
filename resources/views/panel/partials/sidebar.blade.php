<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{URL::asset('LTE/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Alexander Pierce</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">

        <li>
          <a href="{{route('dashboard')}}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        
        @if(Auth::user()->role_id == 1)
          <!-- ============== Users ========== -->
          <li class="treeview">
            <a href="#">
              <i class="fa fa-laptop"></i>
              <span>Users</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ route('users.create')}}"><i class="fa fa-circle-o"></i>Create New User</a></li>
              <li><a href="{{ route('users.index') }}"><i class="fa fa-circle-o"></i>All Users</a></li>

            </ul>
          </li>

          <!-- ============== Playground ========== -->
          <li class="treeview">
            <a href="#">
              <i class="fa fa-laptop"></i>
              <span>Playgrounds</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ route('playgrounds.create')}}"><i class="fa fa-circle-o"></i>Create New Playground</a></li>
              <li><a href="{{ route('playgrounds.index') }}"><i class="fa fa-circle-o"></i>All Playgrounds</a></li>
            </ul>
          </li>

          <!-- ============== Slots ========== -->          
          <li class="treeview">
            <a href="#">
              <i class="fa fa-laptop"></i>
              <span>Playground Schedules</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="#"><i class="fa fa-circle-o"></i>Create Schedule</a></li>
              <li><a href="#"><i class="fa fa-circle-o"></i>All Schedules</a></li>
            </ul>
          </li>

        @elseif(Auth::user()->role_id == 2)
          <li class="treeview">
            <a href="#">
              <i class="fa fa-laptop"></i>
              <span>My Playgrounds</span>
            </a>
          </li> 
          
        @endif



        <li>
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
            Logout
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
        </li>
   
    </section>
    <!-- /.sidebar -->
  </aside>
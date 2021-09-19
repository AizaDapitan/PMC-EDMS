<div class="page-header navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner">
		<!-- BEGIN LOGO -->
		<div class="page-logo">
			<a href="{{ route('home') }}" style="color:white;">
				<br>EDMS Monitoring
			</a>
		</div>
		<!-- END LOGO -->
		<!-- BEGIN HORIZANTAL MENU -->
		<!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
		<!-- DOC: This is desktop version of the horizontal menu. The mobile version is defined(duplicated) sidebar menu below. So the horizontal menu has 2 seperate versions -->
		<div class="hor-menu hidden-sm hidden-xs">
			<ul class="nav navbar-nav">
				<!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the horizontal opening on mouse hover -->
				<li class="classic-menu-dropdown {{ request()->path() =='dashboard' ? 'active' : '' }}">
					<a href="{{ route('home') }}">
						Dashboard <span class=" {{ request()->path() =='dashboard' ? 'selected' : '' }}">
						</span>
					</a>
				</li>
				<li class="classic-menu-dropdown {{ request()->path() =='downtime-list' ? 'active' : '' }}">
					<a href="{{ route('downtime-list') }}">Downtime List <span class="{{ request()->path() =='downtime-list' ? 'selected' : '' }}"></span>
					</a>
				</li>
				<li class="classic-menu-dropdown {{ request()->path() =='genset' ? 'active' : '' }}">
					<a href="{{ route('genset') }}">Genset Units <span class="{{ request()->path() =='genset' ? 'selected' : '' }}"></span>
					</a>
				</li>
				<li class="classic-menu-dropdown {{ request()->path() =='EDMS-assets' ? 'active' : '' }} }}">
					<a href="{{ route('EDMS-assets') }}">Assets <span class="{{ request()->path() =='EDMS-assets' ? 'selected' : '' }} }}"></span>
					</a>
				</li>
				<li class="classic-menu-dropdown">
					<a data-hover="dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
						Input <i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu pull-left">
						<li>
							<a data-toggle="modal" href="#inputdowntime" data-backdrop="static">
								<i class="fa fa-bookmark-o"></i> Add Downtime </a>
						</li>
						<li>
							<a data-toggle="modal" href="#munit" data-backdrop="static">
								<i class="fa fa-bookmark-o"></i> Add Unit</a>
						</li>

					</ul>
				</li>
				<li class="classic-menu-dropdown {{ Request::is('users*') || Request::is('roles*') || Request::is('permissions*') || Request::is('application*') ? 'active' : '' }}">
					<a data-hover="dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
						Maintenance <i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu pull-left">
						<li>
							<a href="{{ route('admin.users') }}">
								<i class="fa fa-bookmark-o"></i> Users</a>
						</li>
						<li>
							<a href="{{ route('admin.roles') }}">
								<i class="fa fa-bookmark-o"></i> Roles</a>
						</li>
						<li>
							<a href="{{ route('admin.permissions') }}">
								<i class="fa fa-bookmark-o"></i> Permissions</a>
						</li>
						<li>
							<a href="{{ route('admin.application.index') }}">
							<i class="fa fa-bookmark-o"></i> Application</a>
						</li>
					</ul>
				</li>

				<li class="classic-menu-dropdown {{ Request::is('roleaccessrights*') || Request::is('useraccessrights*') ? 'active' : '' }}">
					<a data-hover="dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
						Account Management <i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu pull-left">
						<li>
							<a href="{{ route('admin.roleaccessrights') }}">
								<i class="fa fa-bookmark-o"></i> Role Access Rights</a>
						</li>

						<li>
							<a href="{{ route('admin.useraccessrights') }}">
								<i class="fa fa-bookmark-o"></i> User Access Rights</a>
						</li>

					</ul>
				</li>

				<li class="classic-menu-dropdown {{ Request::is('audit-logs*') || Request::is('error-logs*') ? 'active' : '' }}">
					<a data-hover="dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
						Reports <i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu pull-left">
						<li>
							<a href="{{ route('rpt_downtimelist') }}">
								<i class="fa fa-bookmark-o"></i> Input List</a>
						</li>
						<li>
							<a href="{{ route('rpt_flatdata') }}">
								<i class="fa fa-bookmark-o"></i> Downtime Report</a>
						</li>
						<li>
							<a href="{{ route('rpt_chart') }}">
								<i class="fa fa-bookmark-o"></i> Chart Report</a>
						</li>
						<li>
							<a href="{{ route('rpt_masterlist') }}">
								<i class="fa fa-bookmark-o"></i> Equipment Master List</a>
						</li>
						<li>
							<a href="{{ route('rpt_rawdata') }}">
								<i class="fa fa-bookmark-o"></i> Raw Data</a>
						</li>
						<li>
							<a href="{{ route('rpt_daily') }}">
								<i class="fa fa-bookmark-o"></i> Daily Up-Time Report</a>
						</li>
						<li>
							<a href="{{ route('admin.reports.audit-logs') }}">
								<i class="fa fa-bookmark-o"></i> Audit Logs </a>
						</li>
						<li>
							<a href="{{ route('admin.reports.error-logs') }}">
								<i class="fa fa-bookmark-o"></i> Error Logs </a>
						</li>


					</ul>
				</li>

			</ul>
		</div>
		<!-- END HORIZANTAL MENU -->
		<!-- BEGIN HEADER SEARCH BOX -->
		<!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->

		<!-- END HEADER SEARCH BOX -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<!-- BEGIN TOP NAVIGATION MENU -->
		<div class="top-menu">
			<ul class="nav navbar-nav pull-right">
				<!-- BEGIN USER LOGIN DROPDOWN -->
				<li class="dropdown dropdown-quick-sidebar-toggler" style="color:white;">
					<br>{{ Auth::user()->name }}
				</li>
				<!-- END USER LOGIN DROPDOWN -->
				<!-- BEGIN QUICK SIDEBAR TOGGLER -->
				<li class="dropdown dropdown-quick-sidebar-toggler">
					<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="icon-logout"></i></a>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						{{ csrf_field() }}
					</form>

					</a>
				</li>
				<!-- END QUICK SIDEBAR TOGGLER -->
			</ul>
		</div>
		<!-- END TOP NAVIGATION MENU -->
	</div>


	
	<!-- END HEADER INNER -->
</div>
<!-- END HEADER -->

<div class="clearfix"></div>




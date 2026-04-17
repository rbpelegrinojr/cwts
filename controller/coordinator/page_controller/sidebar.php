<style type="text/css">
/*.sidebar.ps-theme-default, .header_class{
    background: #41eb68;
}

.sidebar .logo {
    margin: 30px;
    background: #41eb68;
    border-radius: 7px;
    padding-bottom: 20px;
}*/
</style>
<?php
$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<nav class="sidebar vertical-scroll  ps-container ps-theme-default ps-active-y">
<div class="logo d-flex justify-content-between header_class">
	<a href="index"><img src="<?php echo $resSettings['system_logo']; ?>" alt="" style="margin-left: 40%; height: 100px;width: 100px;"></a>
	<div class="sidebar_close_icon d-lg-none">
		<i class="ti-close"></i>
	</div>
</div>
<ul id="sidebar_menu">
	<li class="">
		<a href="index">
		<div class="icon_menu">
			<span class="fa fa-pie-chart"></span>
		</div>
		<span>Dashboard</span>
		</a>
	</li>
	<li class="">
		<a href="schedules_view">
		<div class="icon_menu">
			<span class="fa fa-book"></span>
		</div>
		<span>Schedules</span>
		</a>
	</li>
	<li class="">
		<a href="#" aria-expanded="false">
			<div class="icon_menu">
				<span class="fa fa-bullhorn"></span>
			</div>
			<span>Announcement/Event</span>
		</a>
		<ul class="mm-collapse">
			<li><a href="active_announcements">Active</a></li>
			<li><a href="inactive_announcements">Archive</a></li>
		</ul>
	</li>
	<li class="">
		<a href="#" aria-expanded="false">
			<div class="icon_menu">
				<span class="fa fa-users"></span>
			</div>
			<span>Students</span>
		</a>
		<ul class="mm-collapse">
			<li><a href="members_view">Personal Data</a></li>
		</ul>
	</li>

	<li class="">
		<a href="#" aria-expanded="false">
		<div class="icon_menu">
			<span class="fa fa-archive"></span>
		</div>
		<span>Archives</span>
		</a>
		<ul class="mm-collapse">
			<li><a href="inactive_announcements">Announcements</a></li>
			<li><a href="archived_schedules_view">Schedules</a></li>
		</ul>
	</li>

	<li class="">
		<a href="#" aria-expanded="false">
		<div class="icon_menu">
			<span class="fa fa-book"></span>
		</div>
		<span>Reports</span>
		</a>
		<ul class="mm-collapse">
			<li><a href="attendance_view">Attendance</a></li>
		</ul>
	</li>

	<!-- <li class="">
		<a href="statistics_view">
		<div class="icon_menu">
			<span class="fa fa-pie-chart"></span>
		</div>
		<span>Statistics</span>
		</a>
	</li> -->


</ul>
</nav>
<?php 	

	$active1 = "";
	$active2 = "";
	$active3 = "";
	$active4 = "";
	$active5 = "";


	switch($curPage) {
		case "reports.php":
		case "manage_report.php":
		case "week_report.php":
			$active1 = "active"; 
			break;
		case "subordinates.php":
			$active2 = "active"; 
			break;
		case "users.php":
		case "user_profile.php":
		case "manage_user.php":
			$active3 = "active"; 
			break;
		case "tasks.php":
        case "all_tasks.php":
		case "manage_task.php":
		case "view_task.php":
			$active4 = "active"; 
			break;
			case "index.php":
			$active2 = "active"; 
			break;
		default:
			$active1 = "";
			$active2 = "";
			$active3 = "";
			$active4 = "";

	}
?>
<aside class="aside">
	<!-- account_info -->
    <div class="account_info has_menu clearfix">
        <div class="user_thumb">
			<img class="" src="<?php echo $baseURL; ?>imgs/avatar.png">
		</div>
		<div class="user clearfix">
			<a class="account_user">
				<?php echo $name; ?>
			</a>
			<i class="fa fa-chevron-down"></i>
		</div>
		<!-- menu -->
		<div class="menu" style="top:105px;">
			<div class="menu_content">
				<div class="menu_section">
					<ul class="menu_list">
						<li><a href="<?php echo $baseURL; ?>profile">Profile &amp; account</a></li>
						<?php
							if($user->hasPrivilege("Manage Roles")) {
								echo "<li>";
								echo "<a href='". $baseURL ."settings/roles'>";
								echo "Settings";
								echo "</a>";
								echo "</li>";
							}
						?>
					</ul>
				</div>
				<div class="menu_divider"></div>
				<div class="menu_section">
					<ul class="menu_list">
					    <li><a href="<?php echo $baseURL; ?>logout">Sign out</a></li>
				    </ul>
			    </div>
		    </div>
	    </div>
		<!-- /menu -->
    </div>
	<!-- /account_info -->

	<!-- nav_list -->
    <ul class="nav_list">
    <?php

    	if($user->hasPrivilege("Manage Reports")) {
    		echo "<li>";
    		echo "<a class='". $active1 ."' href='". $baseURL ."reports'>";
    		echo "<i class=\"fa fa-folder icon_left\"></i>";
    		echo "<span class=\"nav_link\">Reports</span>";
    		echo "</a>";
    		echo "</li>";
    		echo "<li>";
    		echo "<a class='". $active4 ."' href='". $baseURL ."tasks'>";
    		echo "<i class=\"ion ion-settings icon_left\"></i>";
    		echo "<span class=\"nav_link\">Tasks</span>";
    		echo "</a>";
    		echo "</li>";
    	}

    	if($user->hasPrivilege("Supervision Privilege")) {
    		echo "<li>";
    		echo "<a class='". $active2 ."' href='". $baseURL ."subordinates'>";
    		echo "<i class=\"fa fa-clipboard icon_left\"></i>";
    		echo "<span class=\"nav_link\">Subordinates</span>";
    		echo "</a>";
    		echo "</li>";
    	}
    	
    	if($user->hasPrivilege("Manage Users")) {
    		echo "<li>";
    		echo "<a class='". $active3 ."' href='". $baseURL ."users'>";
    		echo "<i class=\"ion ion-person-stalker icon_left\"></i>";
    		echo "<span class=\"nav_link\">Users</span>";
    		echo "</a>";
    		echo "</li>";
    	}
    ?>
    </ul>
	<!-- /nav_list -->
				
	<!-- brand_logo -->
	<div class=""></div>
    <!-- /brand_logo -->
</aside>
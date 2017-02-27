<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
<div>
	<ul class="nav menu">
		<li id="dashboard"><a href="index.php"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Dashboard</a></li>
		<li id ="VMrequest"><a href="VMrequest.php"><svg class="glyph stroked calendar"><use xlink:href="#stroked-calendar"></use></svg> VM Request</a></li>
		<li id ="VMdetails"><a href="VMdetails.php"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> VM Details</a></li>
		<li id="pending_details"><a href="pending_details.php"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg> Pending Requests</a></li>
		<?php
			if($_SESSION['privilege']=='A'){
		?>
		<li id ="xen_host_view"><a href="xen_host_view.php"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg>Host Details (dom0)</a></li>

		<li id ="user_details"><a href="user_details.php"><span class="glyphicon glyphicon-user">&nbsp;Manage Users</span></a></li>
		
		<?php	
			}
		?>
		<li role="presentation" class="divider"></li>
	</ul>
</div>
	<div class="attribution">Developed by : <a href="#">Big Data Centre MNNIT</a><br/><a href="#" style="color: #333;">Students</a></div>
</div><!--/.sidebar-->
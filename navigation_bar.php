<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
<div>
	<ul class="nav menu">
		<li id="dashboard"><a href="index.php" onclick="abortAll();"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg>Dashboard</a></li>
		<li id ="VMrequest"><a href="VMrequest.php" onclick="abortAll();"><svg class="glyph stroked desktop computer and mobile"><use xlink:href="#stroked-desktop-computer-and-mobile"/></svg>VM Request</a></li>
		<li id="hadoop_request"><a href="hadoop_request.php" onclick="abortAll();"><svg class="glyph stroked laptop computer and mobile"><use xlink:href="#stroked-laptop-computer-and-mobile"/></svg>Hadoop Request</a></li>
		<li id ="VMdetails"><a href="VMdetails.php"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> VM Details</a></li>

		<li id ="hadoop_details"><a href="hadoop_details.php"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> Hadoop Cluster Details</a></li>


		<li id ="file_list"><a href="file_list.php" onclick="abortAll();"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> Storage File List </a></li>


		<li id="storage"><a href="storage.php"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg>storage</a></li>

		<li id="pending_details"><a href="pending_details.php"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg>Pending Requests</a></li>
		<?php
			if($_SESSION['privilege']=='A'){
		?>
		<li id ="xen_host_view"><a href="xen_host_view.php" onclick="abortAll();"><svg class="glyph stroked clipboard with paper"><use xlink:href="#stroked-clipboard-with-paper"/></svg>Host Details (dom0)</a></li>


		<li id="storage_server"><a href="storage_server.php" onclick="abortAll();"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg>Storage Servers</a></li>


		<li id="user_storage"><a href="user_storage.php" onclick="abortAll();"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg>User Storage</a></li>

		<li id="management"><a href="#manage-collapse" data-toggle="collapse"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"/></svg>Management&nbsp;&nbsp;<svg id="arrow" class="glyph stroked chevron down"><use xlink:href="#stroked-chevron-down"/></svg></a>
			<ul class=" nav menu collapse" id="manage-collapse">
				<li id ="user_details"><a href="user_details.php">&nbsp;&nbsp;&nbsp;&nbsp;<svg class="glyph stroked male user "><use xlink:href="#stroked-male-user"/></svg>Manage Users</a></li>
				<li id ="new_user"><a href="user_requests.php">&nbsp;&nbsp;&nbsp;&nbsp;<svg class="glyph stroked lock"><use xlink:href="#stroked-lock"/></svg>User Request</a></li>

				<li id="ip_pool"><a href="ip_pool.php">&nbsp;&nbsp;&nbsp;&nbsp;<svg class="glyph stroked basket"><use xlink:href="#stroked-basket"/></svg>Ip Pool</a></li>
			</ul>
		</li>	
		<?php	
			}
		?>
		<li role="presentation" class="divider"></li>
	</ul>
</div><br><br><!-- 
	<div class="attribution">Developed by : <a href="#">Big Data Centre MNNIT</a><br/><a href="#" style="color: #333;">Students</a></div> -->
</div><!--/.sidebar-->

<script type="text/javascript">
	function abortAll(){
		if(ajax){
			console.log("Aborting AJAX");
			ajax.abort();
		}
	}
</script>
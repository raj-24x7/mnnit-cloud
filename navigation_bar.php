	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
<div>
	<ul class="nav menu">
		<li id="dashboard"><a href="index.php" onclick="abortAll();"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg>Dashboard</a></li>

		<li id="vm"><a href="#vm-collapse" data-toggle="collapse"><svg class="glyph stroked desktop computer and mobile"><use xlink:href="#stroked-desktop-computer-and-mobile"/></svg>Virtual Machine&nbsp;&nbsp;<svg id="arrow" class="glyph stroked chevron down"><use xlink:href="#stroked-chevron-down"/></svg></a>
			<ul class=" nav menu collapse" id="vm-collapse">

				<li id ="VMrequest"><a href="VMrequest.php" onclick="abortAll();">&nbsp;&nbsp;&nbsp;&nbsp;<svg class="glyph stroked desktop computer and mobile"><use xlink:href="#stroked-desktop-computer-and-mobile"/></svg>VM Request</a></li>

				<li id ="VMdetails"><a href="VMdetails.php">&nbsp;&nbsp;&nbsp;&nbsp;<svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> VM Details</a></li>

			</ul>
		</li>

		<li id="hadoop"><a href="#hadoop-collapse" data-toggle="collapse"><svg class="glyph stroked laptop computer and mobile"><use xlink:href="#stroked-laptop-computer-and-mobile"/></svg>Hadoop&nbsp;&nbsp;<svg id="arrow" class="glyph stroked chevron down"><use xlink:href="#stroked-chevron-down"/></svg></a>
			<ul class=" nav menu collapse" id="hadoop-collapse">

				<li id="hadoop_request"><a href="hadoop_request.php" onclick="abortAll();">&nbsp;&nbsp;&nbsp;&nbsp;<svg class="glyph stroked laptop computer and mobile"><use xlink:href="#stroked-laptop-computer-and-mobile"/></svg>Hadoop Request</a></li>

				<li id ="hadoop_details"><a href="hadoop_details.php">&nbsp;&nbsp;&nbsp;&nbsp;<svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> HadoopClusters</a></li>

			</ul>
		</li>

		<li id="storage"><a href="#storage-collapse" data-toggle="collapse"><svg class="glyph stroked lock"><use xlink:href="#stroked-lock"/></svg>Storage&nbsp;&nbsp;<svg id="arrow" class="glyph stroked chevron down"><use xlink:href="#stroked-chevron-down"/></svg></a>
			<ul class=" nav menu collapse" id="storage-collapse">

				<li id ="file_list"><a href="file_list.php" onclick="abortAll();">&nbsp;&nbsp;&nbsp;&nbsp;<svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> Storage File List </a></li>

				<li id="storage-details"><a href="storage.php">&nbsp;&nbsp;&nbsp;&nbsp;<svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg>Storage Details</a></li>
<?php
			if($_SESSION['privilege']=='A'){
		?>
				<li id="storage_server"><a href="storage_server.php" onclick="abortAll();">&nbsp;&nbsp;&nbsp;&nbsp;<svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg>Storage Servers</a></li>

				<li id="user_storage"><a href="user_storage.php" onclick="abortAll();">&nbsp;&nbsp;&nbsp;&nbsp;<svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg>User Storage</a></li>
<?php } ?>
		</ul>
		<li id="pending_details"><a href="pending_details.php"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg>Pending Requests</a></li>

		<li id="notifications"><a href="display_notifications.php"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg>Notifications</a></li>
		<?php
			if($_SESSION['privilege']=='A'){
		?>
		
		<li id="Server Details"><a href="#details-collapse" data-toggle="collapse"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"/></svg>&nbsp;&nbsp;Server Details&nbsp;&nbsp;<svg id="arrow" class="glyph stroked chevron down"><use xlink:href="#stroked-chevron-down"/></svg></a>
			<ul class=" nav menu collapse" id="details-collapse">	
				<li id ="xen_pool_view"><a href="xen_pool_view.php" onclick="abortAll();">&nbsp;&nbsp;&nbsp;&nbsp;<svg class="glyph stroked clipboard with paper"><use xlink:href="#stroked-clipboard-with-paper"/></svg>Pool Details</a></li>

				<li id ="xen_host_view"><a href="xen_host_view.php" onclick="abortAll();">&nbsp;&nbsp;&nbsp;&nbsp;<svg class="glyph stroked clipboard with paper"><use xlink:href="#stroked-clipboard-with-paper"/></svg>Host Details</a></li>

				<li id ="xen_SR_view"><a href="xen_SR_view.php" onclick="abortAll();">&nbsp;&nbsp;&nbsp;&nbsp;<svg class="glyph stroked clipboard with paper"><use xlink:href="#stroked-clipboard-with-paper"/></svg>SR Details</a></li>

				<li id ="xen_VDI_view"><a href="xen_VDI_view.php" onclick="abortAll();">&nbsp;&nbsp;&nbsp;&nbsp;<svg class="glyph stroked clipboard with paper"><use xlink:href="#stroked-clipboard-with-paper"/></svg>VDI  Details</a></li>

			</ul>
		</li>

		<li id="management"><a href="#manage-collapse" data-toggle="collapse"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"/></svg>&nbsp;&nbsp;Management&nbsp;&nbsp;<svg id="arrow" class="glyph stroked chevron down"><use xlink:href="#stroked-chevron-down"/></svg></a>
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
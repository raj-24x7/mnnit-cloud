<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php  
		echo "MNNIT Private Data Cloud";
	?></title>
	<meta name="description" content="MNNIT Private Data Cloud">

	<!-- Mobile viewport optimized -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="shortcut icon" href="images/logo-MNNIT.png" type="image/png">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">

	<!-- <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
	<!-- <link href="includes/css/bootstrap-glyphicons.css" rel="stylesheet">
 -->
	<!-- Custom CSS -->	
	<link rel="stylesheet" href="includes/css/styles.css">

	<!-- Include Modernizr in the head, before any other Javascript -->
	<script src="includes/js/modernizr-2.6.2.min.js"></script>

	<script>window.jQuery || document.write('<script src="includes/js/jquery-1.8.2.min.js"><\/script>')</script>
	<!-- Bootstrap JS -->
	<!-- Custom JS -->
	<script src="includes/js/script.js"></script>


	<!--Icons-->
	<script src="js/lumino.glyphs.js"></script>
	<?php   require 'include.php';?>

	<!-- counting notification -->
	<script type="text/javascript">
		function remove_notification(){
			console.log('Remove notification');
			var values = [];
			$('#notification_dropdown li').each(function(){
			    values.push($(this).attr('value'));
			});
			console.log(values);
			dataString = values;
			var jsonString = JSON.stringify(dataString);
			   $.ajax({
			        type: "POST",
			        url: "remove_notification.php",
			        data: {data : jsonString}, 
			        cache: false,

			        success: function(data){
			            // alert("");
			            console.log(data);
			            // location.reload();
			        }
			    });
		}
				function append_html(msg){
					id_numbers = msg;
			        var str="";
			        console.log(msg);
			        $('#datacount').html(msg.length);
			        if(msg.length == 0){
			        	$("#notification_dropdown").append('<li class="list-group-item">No Pending Notification</li>');
			        	return;
			        }
			        for(var i=0;i<msg.length;i++){
			 
			        	$("#notification_dropdown").append('<li class="list-group-item notification" value="'+msg[i]["id"]+'">'+msg[i]["vmname"]+':'+msg[i]["status"]+'</li>');

			        }
			        console.log(str);
				}	
				function get_notification_from_php(){
					$('#notification_dropdown').empty();
					$.ajax({
					    url:"notification.php",
					    type:"POST",
					    success:function(msg){
					        append_html(msg);
					    },
					    dataType:"json"
					});
				}			
	    $(document).ready(function() { 
	    	
			get_notification_from_php();
			setInterval(get_notification_from_php, 30000);
	    });

	</script>

</head>

<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><h4 style="color: white;"><b>MNNIT<span>data</span>Cloud</b></h4></a>
				<ul class="user-menu">
	    			<?php 
	    			if(isset($_SESSION['username'])) {?>	
	    				<li class="dropdown pull-left" onclick="remove_notification();">
	    					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span style="font-size: 20px;" class="glyphicon glyphicon-bell" ></span><font size="3"></font><span class="badge badge-success" style="background-color: red;"><div id="datacount"></div></span></a>

								<ul class="dropdown-menu" id="notification_dropdown">
									
								</ul>
	    				</li>&nbsp;&nbsp;&nbsp;&nbsp;


						<li class="dropdown pull-right">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user" style="margin: 0 0 5px 0;"></span><font size=3><b> <?php echo $_SESSION['username']?> </b></font><strong class="caret"></strong></a>
								<ul class="dropdown-menu">
									<li>
										<a href="user_profile.php"><span class="glyphicon glyphicon-wrench"></span> Profile Settings</a>
									<li class="divider"></li>

									<li>
										<a href="logout.php"><span class="glyphicon glyphicon-off"></span> Sign out</a>
									</li>
								</ul>
						</li>
					<?php } else { 
								echo '<button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#myModal" style="margin: 0 0 5px 0;"><font size=3><b>Login</b></font></button>';
								echo '<button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#signupModal" style="margin: 0 15px 5px 0;"><font size=3><b>Sign UP</b></font></button>';
						  }
					?>
						 
				</ul>
				<!-- <ul class="dropdown dropdown-extended dropdown-notification dropdown-dark" id="header_notification_bar">
			        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
			            <i class="icon-bell">Notification</i>
			            <span class="badge badge-success">
			                <div id="datacount"></div>
			            </span>
			            </span>
			        </a>
			        <ul class="dropdown-menu" >
			            <li class="external">
			                <h3>
			                    <span class="bold">12 pending</span> notifications
			                </h3>
			                <a href="page_user_profile_1.html">view all</a>
			            </li>
			            <li>
			                <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
			                    <li>
			                        <a href="javascript:;">
			                        <span class="time">just now</span>
			                        <span class="details">
			                        <span class="label label-sm label-icon label-success">
			                        <i class="fa fa-plus"></i>
			                        </span> New user registered. </span>
			                        </a>
			                    </li>
			                </ul>
			            </li>
			        </ul>
		        </ul> -->

			</div>					
		</div><!-- /.container-fluid -->
	</nav>
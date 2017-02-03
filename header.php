<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Lumino - Dashboard</title>
	<meta name="description" content="">

	<!-- Mobile viewport optimized -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

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
				<a class="navbar-brand" href="#"><span>Lumino</span>Admin</a>
				<ul class="user-menu">
	    			<?php 
	    			session_start();
	    			if(isset($_SESSION['username'])) {?>	
						<li class="dropdown pull-right">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['username']?> <strong class="caret"></strong></a>
								<ul class="dropdown-menu">
									<li>
										<a href="#"><span class="glyphicon glyphicon-wrench"></span> Profile Settings</a>
									<li class="divider"></li>

									<li>
										<a href="logout.php"><span class="glyphicon glyphicon-off"></span> Sign out</a>
									</li>
								</ul>
						</li>
					<?php } else { 
								echo '<button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#myModal" style="margin-top: 10px;">Login</button>';
						  }
					?>	 
				</ul>
			</div>					
		</div><!-- /.container-fluid -->
	</nav>
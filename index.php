<?php 
	
  session_start();
  	require_once "db_connect.php";
	if(isset($_SESSION['username'])){
		header("location:dashboard.php");
	}


	else{

		if (!empty($_POST)) {
		    
		    $username = $_POST['username'];
		    $password = md5($_POST['password']);
		    
		    $query = " SELECT username , privilege FROM user WHERE  username = :username  AND password = :password ";
		    $param = array(
		        ":username"=>$username,
		        ":password"=>$password
		        );

		    $db = getDBConnection();
		    $stmt = prepareQuery($db,$query);
		    executeQuery($stmt,$param);
		    
		    if ($row = $stmt->fetch()) {
		        session_start();
		        $_SESSION['username']  = $row['username'];
		        $_SESSION['privilege'] = $row['privilege'];
		        header('location:index.php');
		    } else {
		        header('location:index.php');
		    }
		}

	include 'header.php'; 

?>

<div class="container">
  

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog" style="z-index: 10000">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Login</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal-sm" role="form" action="index.php" method="POST" >
                <div class="form-group">                 
                    <input type="text" class="form-control" id="username" placeholder="Username" name="username">
                </div>
                <div class="form-group">                  
                    <input type="password" class="form-control" id="password" placeholder="password" name="password">
                </div>
                <div class="form-group modal-body" width="30%">
                  <input type="submit" class="btn btn-info btn-sm pull-right form-horizontal-sm" value="Login">
                </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  

<?php		
	}
?>
<div class="row">
 <div class="col-sm-12">
    <div class="panel"></div>
  </div>

  <div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-blue panel-widget ">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<svg class="glyph stroked bag"><use xlink:href="#stroked-bag"></use></svg>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large">120</div>
							<div class="text-muted">New Orders</div>
						</div>
					</div>
				</div>
			</div>
			
	<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-orange panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<svg class="glyph stroked empty-message"><use xlink:href="#stroked-empty-message"></use></svg>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large">52</div>
							<div class="text-muted">Comments</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-teal panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large">24</div>
							<div class="text-muted">New Users</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-red panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<svg class="glyph stroked app-window-with-content"><use xlink:href="#stroked-app-window-with-content"></use></svg>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large">25.2k</div>
							<div class="text-muted">Page Views</div>
						</div>
					</div>
				</div>
			</div>
</div>

    <div class="container">
<div class="row">
  <div class="col-sm-12">
    <div class="panel"></div>
  </div>

      <div class="panel-body thumbnail">
        <img src="images/logo-MNNIT.png" height="200" width="120" align="center" \>
        <caption><center><h4>MNNIT Allahabad</h4></center></caption>
      
   <div class="panel panel-blue">
 		<div class="panel-heading">
 			<center>About</center>
 		</div>
 		<div class="panel-body">
 			The website is developed by Big Data Center MNNIT for providing cloud based
 		</div>  
   </div>   
  
   <div class="panel panel-red">
 		<div class="panel-heading">
 			<center>About</center>
 		</div>
 		<div class="panel-body">
 			The website is developed by Big Data Center MNNIT for providing cloud based
 		</div>  
   </div>   

   <div class="panel panel-teal">
 		<div class="panel-heading">
 			<center>About</center>
 		</div>
 		<div class="panel-body">
 			The website is developed by Big Data Center MNNIT for providing cloud based
 		</div>  
   </div>   

   <div class="panel panel-orange">
 		<div class="panel-heading">
 			<center>About</center>
 		</div>
 		<div class="panel-body">
 			The website is developed by Big Data Center MNNIT for providing cloud based
 		</div>  
   </div>   

  <div class="col-sm-4">
    <div class="panel panel-default">
      <div class="panel-header">
      	Infrastructure as a Service
      </div>  
      <div class="thumbnail">
      	<center>
      	<svg class="glyph stroked desktop" ><use xlink:href="#stroked-desktop"/></svg>
      	<ul>
      		<li>Request a Virtual Machine</li>
      	</ul>
      	</center>
      </div>

    </div>  
  </div>
    </div>
</div>
</div>
			

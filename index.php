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
  
</div>

<?php		
	}
?>

	</body>
</html>

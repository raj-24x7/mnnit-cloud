<?php
	session_start();
	require "checksession.php";
	require "db_connect.php";
	require "header.php";
  require_once('logging.php');



  		function test_input($data) {
 		 $data = trim($data);
 		 $data = stripslashes($data);
  		$data = htmlspecialchars($data);
  	return $data;
	}
	  	  			$db = getDBConnection();
	

  	  				if ($_SERVER["REQUEST_METHOD"] == "POST") {
  								$name = test_input($_POST["name"]);
  								$email = test_input($_POST["email"]);
  								$contact= test_input($_POST["contact"]);
  								$department = test_input($_POST["department"]);
  								$programme = test_input($_POST["programme"]);

  								//	echo $name;
  								//	echo $email;
  									//$query="Update `new_user` set name=RObin where username"
  								 $query = " Update   `new_user` set name=:name,email=:email,contact=:contact,department=:department,programme=:programme WHERE username=:username";
  								  $param = array(":username"=>$_SESSION['username'],":name"=>$name,":email"=>$email,":contact"=>$contact,":department"=>	$department,":programme"=>$programme);
										
					
  								  $stmt = prepareQuery($db,$query);
                if(!executeQuery($stmt,$param)){
                      $l = logError("1104");
                      $l[0]->log($l[1]);
                      header("location:error.php?error=1104");
                      die();
                	}


					}







  	  				




  	  			

  	  			 $query = " SELECT * FROM `new_user` WHERE username=:username";
  	  			 $param = array(":username"=>$_SESSION['username']);

               $email="";
               $name="";
               $department="";
               $contact="";
               $programme="";

                $stmt = prepareQuery($db,$query);
                if(!executeQuery($stmt,$param)){
                      $l = logError("1104");
                      $l[0]->log($l[1]);
                      header("location:error.php?error=1104");
                      die();
                }
                $row=$stmt->fetch();	
                if($row){

                	$email=$row['email'];
               		$name=$row['name'];
               		$department=$row['department'];
               		$contact=$row['contact'];
              		$programme=$row['programme'];

                }









?>

<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-2">
		<?php include "navigation_bar.php";?>
	</div>
	<div class="col-sm-8">
		<div class="panel panel-info">
			<div class="panel panel-heading">
				<center><h2><strong><?php echo $_SESSION['username'];?></strong></h2></center>
			<div>	
		
			<div class="panel panel-body">
				<form name="request" class="form-horizontal" role="form"  action="#" method='POST' >
                            <div class="form-group" id="vmvalid">
                                <label class="control-label col-sm-3" for="pwd">Name:</label>
                                <div class="col-sm-7" >
                                    <input type="text" class="form-control" name="name" id="name" value= "<?php echo $name ?>" >
                             </div>
                                <div class="col-sm-2" id="res"></div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-3" for="description">department</label>
                                <div class="col-sm-7">
                                   <input type="text" class="form-control" name="department" id="department"   value= "<?php echo $department ?>" >
                                </div>
                            </div>
                            <div class="form-group" id="main_form">
                                <label class="control-label col-sm-3" for="email">email</label>
                                <div class="col-sm-7">
                                  <input type="email" class="form-control" name="email" id="email" value= "<?php echo $email ?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="pwd">contact</label>
                                <div class="col-sm-7">
                                  <input type="tel" class="form-control" name="contact" id="contact"  value= "<?php echo $contact ?>"  >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="pwd">programme</label>
                                <div class="col-sm-7">
                                     <input type="text" class="form-control" name="programme" id="programme"  value= "<?php echo $programme ?>"  >
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="submit" class="btn btn-info btn-sm form-horizontal-sm pull-right" value="Submit" style="margin: 0 15px 15px 0;">
                                </div>
                            </div>
                        </form>


			</div>

		
			<div class="panel panel-body">
				<a class="btn btn-info" href="reset_password.php">Change Password</a>
				<form class="form-control">
					
				</form>
			</div>
		</div>
	</div>
	<div class="col-sm-1"></div>
</div>



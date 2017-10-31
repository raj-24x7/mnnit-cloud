<?php 
  session_start();
  
  	require_once 'db_connect.php';
  	require_once 'mail.php';
    require_once 'logging.php';

    if (!empty($_POST)) {
            
            $email = $_POST['email'];
           // $contact = $_POST['contact'];
            
            $query = " SELECT *  FROM new_user ";
            $param = array();
        
            $db = getDBConnection();
            $stmt = prepareQuery($db,$query);
            executeQuery($stmt,$param);
            
            $cc=0;
            while($row = $stmt->fetch()) {
                
                	if($email===$row['email']){
                		$cc=1;
                		$token=md5($row['username'].rand());

                		// insert in database
                		$insert_query = "INSERT INTO `forgot_password` VALUES (:username,:token, :tm)";
                		$stmt = prepareQuery($db, $insert_query);
                		if(!executeQuery($stmt, array(":username"=>$row['username'], ":token"=>$token, ":tm"=>time()))){
                			header("location:error.php?error=1104");
                		}

                		// send mail
                		$msg = "
                			Dear ".$row['username'].",\n
                			\tPassword Reset Link : 172.31.76.68/mnnit-cloud/reset_password.php?username=".$row['username']."&token=".$token."\n
                            \tIt is valid for 2 hours.\n\n
                            admin 
                		";
                		notifyByMail($row['email'], $row['username'], "Password Reset",$msg);

                		break;
                	}
            }    
            if($cc==0)
                header('location:error.php?error=1801');
            
        }
    
        require_once 'header.php';
        //require_once 'db_connect.php';
    ?>

<link rel="stylesheet" href="includes/css/jquery-ui.css">
<script src="includes/js/jquery.min.js"></script>
<script src="includes/js/jquery-ui.min.js"></script>


<div class="row">
    <div class="col-sm-2"></div>
   
    <div class="col-sm-8">
        <br><br><br>
        <div class="row" id="features">
            <div class="col-sm-2">
            </div>
            <div class="col-sm-8 text-left">
                <div class="panel">
                    <div class="panel-heading">
                        <h1 class="panel-title">Enter  Email for verification:</h1>
                    </div>
                    
                        <form name="request" class="form-horizontal" role="form"  action="#" method='POST' >
                            <div class="form-group" id="vmvalid">
                                <label class="control-label col-sm-3" for="pwd">Email:</label>
                                <div class="col-sm-7" >
                                    <input type="email" class="form-control" name="email" id="email">
                                </div>
                                <div class="col-sm-2" id="res"></div>
                            </div>

                            <div class="form-group">
                            	 <div class="col-sm-5">
                                   
                                </div>

                                <div class="col-sm-7">
                                    <input type="submit"  class=" btn btn-primary btn-sx" value="Submit" style="margin: 0 15px 15px 0;">
                                </div>
                            </div>
                        </form>
                    
                </div>
            </div>

      
            <div class="col-sm-2">
            </div>
        </div>
   
    </div>

    <div class="col-sm-1"></div>
</div>
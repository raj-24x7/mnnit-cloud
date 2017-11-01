<?php 
    session_start();
    
    require 'db_connect.php';
    require 'checksession.php';
    require 'mail.php';
    require_once('logging.php');
    ?>
<script type="text/javascript">
    window.onload = function (){
      document.getElementById("VMdetails").className = "active";
    }
</script>
<?php 
    
    
    //user_request rejected
    if (isset($_POST['button']) && $_POST['button']=='reject') {
        $param = array (
                ":username" => $_POST['username']
            );
    
        $db = getDBConnection();
        $query='SELECT * FROM `new_user` WHERE username =:username ';
             $stmt = prepareQuery($db,$query);
        if (!executeQuery($stmt,$param)) {
            $l = logError("1104");
            $l[0]->log($l[1]);
            header("location:error.php?error=1104");
            die();
        }
        if($row=$stmt->fetch()){
                $email=$row['email'];
                $uname=$row['name'];           
        }
        notifyByMail(
                $email,
                $uname,
                "MNNIT Cloud : User Request Rejected",
                "$uname, \n \t <br>&nbsp;&nbsp;&nbsp;&nbsp;Your Request for Account on MNNIT Data Cloud has been <b>Rejected</b>.<br>&nbsp;&nbsp;&nbsp;&nbsp; \n Contact System Administrator at Big Data Center. \n
                <br>Admin.<br>Big Data Center<br>MNNIT Allahabad"
            );
    
        $sql = 'DELETE FROM `new_user` WHERE username = :username';
        $stmt = prepareQuery($db,$sql);
        if (executeQuery($stmt,$param)) {
            logSignupRejected($_POST['username'],$_SESSION['username']);
            header("location:user_requests.php");
            die();
        }
        
    
    }
    //user_request approve
    else if (isset($_POST['button']) && $_POST['button']=='approve') {
        $param = array (
                ":username" => $_POST['username'],
                ":password" => $_POST['password']
            );
    
        $db = getDBConnection();
        $sql = "INSERT INTO `user` VALUES (:username,:password,'U')";
        
        $stmt = prepareQuery($db,$sql);
        if (!executeQuery($stmt,$param)) {
            $l = logError("1104");
            $l[0]->log($l[1]);
            header("location:error.php?error=1104");
            die();
        }
    
        $query="UPDATE `new_user` SET  `status`='a' where `username` =:username";
            $param=array(
                ":username"=> $_POST['username']
                );
            $stmt = prepareQuery($db,$query);
        if (!executeQuery($stmt,$param)) {
            $l = logError("1104");
            $l[0]->log($l[1]);
            header("location:error.php?error=1104");
            die();
        }
    
        $query='SELECT * FROM `new_user` WHERE `username` =:username ';
             $stmt = prepareQuery($db,$query);
    
        if (executeQuery($stmt,$param)) {
            if($row=$stmt->fetch()){
                $email=$row['email'];          
                $uname=$row['name']; 
        }
        notifyByMail(
                $email,
                $uname,
                "MNNIT Cloud : User Request Accepted",
                "$uname, <br>\n &nbsp;&nbsp;&nbsp;&nbsp;\t Your Request for Account on MNNIT Data Cloud has been <b>Accepted</b>. <br>&nbsp;&nbsp;&nbsp;&nbsp;\n Please login to use the services. \n
                <br>Admin.<br>Big Data Center<br>MNNIT Allahabad"
            );

            logSignupApproved($_POST['username'],$_SESSION['username']);
            header("location:user_requests.php");
            die();
        }
            
    }
    ?>
<?php     
    $db = getDBConnection();
    if($_SESSION['privilege']=='A') {// A for admin
        
        $query = " 
            SELECT * FROM `new_user` WHERE 1"; 
        $param = array();
    }
    
    $stmt = prepareQuery($db,$query);
    executeQuery($stmt,$param);
    require 'header.php';
    ?> 
<div class="row">
    <div class="col-sm-3">
        <?php include 'navigation_bar.php'; ?>
    </div>
    <div class="col-sm-9">
        <br>
        <table class="table">
            <thead class="thead-inverse">
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Department</th>
                    <th> Programme </th>
                    <th>E-mail</th>
                    <th>Contact</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    while($row = $stmt->fetch()){
                    echo '<tr>';
                        echo'<td>'.$row['name'].'</td>
                        <td>'.$row['username'].'</td>
                        <td>'.$row['department'].'</td>
                        <td>'.$row['programme'].'</td>
                        <td>'.$row['email'].'</td>
                        <td>'.$row['contact'].'</td>
                        <td colspan="2">';
                        
                        if($row['status']=='p'){
                        echo   ' <form action="user_requests.php" method="POST">
                                    <input type="hidden" name="username" value="'.$row['username'].'">
                                    <input type="hidden" name="password" value="'.$row['password'].'">
                                    <input type="submit" class="btn btn-success" name="button" value="approve">
                                    <input type="submit" class="btn btn-danger" name="button" value="reject">
                                
                            </form>
                        </td>
                    ';      
                    }
                    else if($row['status']=='a'){
                        echo ' approved </td>';
                    }
                    echo '</tr>';
                    
                    }
                    ?>
            </tbody>
        </table>
    </div>
</div>
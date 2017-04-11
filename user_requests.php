<?php 
    session_start();
    
    require 'db_connect.php';
    require 'checksession.php';
    require 'mail.php';
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
            header("location:error.php?error=1104");
        }
        if($row=$stmt->fetch()){
                $email=$row['email'];
                $uname=$row['name'];           
        }
       // echo "tgtiyytyt".$email;
        
        //sendmail($email,'r');
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
            header("location:user_requests.php");
        }
        
    
    }
    //user_request approve
    else if (isset($_POST['button']) && $_POST['button']=='approve') {
        $param = array (
                ":username" => $_POST['username'],
                ":password" => md5($_POST['password'])
            );
    
        $db = getDBConnection();
        $sql = "INSERT INTO `user` VALUES (:username,:password,'U')";
        
        $stmt = prepareQuery($db,$sql);
        if (executeQuery($stmt,$param)) {
           header("location:user_requests.php");
    
        }
    
        $query="UPDATE `new_user` SET  `status`='a' where `username` =:username";
            $param=array(
                ":username"=> $_POST['username']
                );
            $stmt = prepareQuery($db,$query);
        if (!executeQuery($stmt,$param)) {
           header("location:error.php?error=1104");
    
        }
    
        $query='SELECT * FROM `new_user` WHERE `username` =:username ';
             $stmt = prepareQuery($db,$query);
    
        if (executeQuery($stmt,$param)) {
            if($row=$stmt->fetch()){
                $email=$row['email'];          
                $uname=$row['name']; 
        }
         //echo "".$email;
       // sendmail($email,'a');
        notifyByMail(
                $email,
                $uname,
                "MNNIT Cloud : User Request Accepted",
                "$uname, <br>\n &nbsp;&nbsp;&nbsp;&nbsp;\t Your Request for Account on MNNIT Data Cloud has been <b>Accepted</b>. <br>&nbsp;&nbsp;&nbsp;&nbsp;\n Please login to use the services. \n
                <br>Admin.<br>Big Data Center<br>MNNIT Allahabad"
            );
            header("location:user_requests.php");
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
    <div class="col-sm-8">
        <br>
        <table class="table">
            <thead class="thead-inverse">
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Department</th>
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
                        <td>'.$row['email'].'</td>
                        <td>'.$row['contact'].'</td>
                        <td>';
                        
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
    <div class="col-sm-1">
    </div>
</div>
<!-- <form action="user_requests.php" method="POST" name="approval">
    <input type="button" class="btn btn-success" name="approve" value="Approve">
    <input type="button" class="btn btn-danger" name="reject" value="Reject">
    </form> -->


<html>
    <body>
        <?php
            require 'db_connect.php';
            session_start();
            require 'checksession.php';


            if($_SERVER['REQUEST_METHOD']=='POST'){
                $param = array(
                	":vm_name" => $_POST['VM_name'],
                	":ram" => $_POST['ram'],
                	":os" => $_POST['os'],
                	":cpu" => $_POST['cpu'],
                	":storage" => $_POST['storage'],
                	":doe" => $_POST['date'],
                    ":username"=>$_SESSION['username']
                );
            
                $db = getDBConnection();	
                $sql="INSERT INTO `VMrequest` (VM_name,username,os,cpu,ram,storage,doe) VALUES (:vm_name,:username,:os,:cpu,:ram,:storage,:doe)";
                $stmt = prepareQuery($db,$sql);
                executeQuery($stmt,$param);
                $sql = "INSERT INTO `name_description` (name,description) VALUES (:vm_name,:description)";
                $param = array(
                        ":vm_name"=>$_POST["VM_name"],
                        ":description"=>$_POST['description']
                    );
                $stmt = prepareQuery($db,$sql);
                if(executeQuery($stmt,$param)){
                    header("location:pending_details.php");
                }
                         
            }
            ?>
    </body>
</html>


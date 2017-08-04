

<html>
    <body>
        <?php
            require 'db_connect.php';
            session_start();
            require 'checksession.php';


            if($_SERVER['REQUEST_METHOD']=='POST'){
                $param = array(
                	":hadoop_name" => $_POST['hadoop_name'],
                    ":number_slave" => $_POST['number_slave'],
                	":ram" => $_POST['ram'],
                	":cpu" => $_POST['cpu'],
                	":storage" => $_POST['storage'],
                	":doe" => $_POST['date'],
                    ":username"=>$_SESSION['username']
                );
            
                $db = getDBConnection();	
                $sql="INSERT INTO `hadoop` (username,hadoop_name,number_slave,cpu,ram,storage,doe,status) VALUES (:username,:hadoop_name,:number_slave,:cpu,:ram,:storage,:doe,'pending')";
                $stmt = prepareQuery($db,$sql);
                executeQuery($stmt,$param);
                $sql = "INSERT INTO `name_description` (name,description) VALUES (:hadoop_name,:description)";
                $param = array(
                        ":hadoop_name"=>$_POST["hadoop_name"],
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


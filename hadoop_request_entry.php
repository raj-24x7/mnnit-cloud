

<html>
    <body>
        <?php
            require_once 'db_connect.php';
            session_start();
            require_once 'checksession.php';
            require_once 'logging.php';

            if($_SERVER['REQUEST_METHOD']=='POST'){
                $no_of_slaves = $_POST['number_vm']-1;
                
                $param = array(
                	":hadoop_name" => $_POST['hadoop_name'],
                    ":number_slave" => $no_of_slaves,
                	":ram" => $_POST['ram'],
                	":cpu" => (int)$_POST['cpu'],
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
                    notifyAllAdmins("HADOOP", $_SESSION['username']." requested hadoop cluster ".$_POST['hadoop_name']);
                    logHadoopRequest($_POST['hadoop_name'],$_SESSION['username']);
                    header("location:pending_details.php");
                }
                         
            }
            ?>
    </body>
</html>


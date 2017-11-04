<?php 

  session_start();
  
  require 'checksession.php';
  require 'header.php';
  require 'db_connect.php';
  require_once('logging.php');

  if($_SESSION['privilege']!='A'){
    header("location:error.php?error=1001");
    die();
  }

?>

<script type="text/javascript">
  window.onload = function (){
    document.getElementById("storage_server").className = "active";var prevClass = document.getElementById("storage-collapse").className;

      document.getElementById("storage-collapse").className = prevClass+" in";
  }
</script>
            
<div class="row">
  
    <div class="col-sm-3">
      <?php include 'navigation_bar.php'; ?>
    </div>

    <div class="col-sm-8">
    <br>
    <?php
  $db=null;
  $db=getDBConnection();

                    $query = " 
                        SELECT * FROM `storage_servers`"; 
                    $param = array();
                

                $stmt = prepareQuery($db,$query);
                executeQuery($stmt,$param);

?>


      <h2> Storage Servers : </h2><br>
      <table class="table">
          <thead class="thead-inverse">
            <tr>
                <th>Server Name</th>
                <th> IP </th>
                <th>Login Name</th>
                <th>Login Password</th>
                <th>Total Space</th>
                <th>Alloted Space</th>
            </tr>
          </thead>
      
          <tbody>
              
              <?php   
                while($row=$stmt->fetch()){
                    echo '
                    <tr>';
                      echo '<td>'.$row['server_name'].'</td>';
                      
                      echo '
                      <td>'.$row['ip'].'</td>
                      <td>'.$row['login_name'].'</td>
                      <td>'.$row['login_password'].'</td>
                      <td>'.getMemoryString($row['total_space']).'</td>
                      <td>'.getMemoryString($row['used_space']).'</td>';  
                  echo '</tr>';         
              }
            ?>

          </tbody>   
      </table>

      </div>





    <div class="col-sm-1">
    </div>
</div>




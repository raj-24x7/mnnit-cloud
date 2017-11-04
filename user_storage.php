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
    document.getElementById("user_storage").className = "active";var prevClass = document.getElementById("storage-collapse").className;

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
      SELECT * FROM `user_storage`"; 
  $param = array();
                

  $stmt = prepareQuery($db,$query);
  executeQuery($stmt,$param);

?>


      <h2> User Storage : </h2><br>
      <table class="table">
          <thead class="thead-inverse">
            <tr>
                <th>Username</th>
                <th>Storage Server</th>
                <th>Alloted Space</th>
                <th>Used Space</th>
                <th>Login Password</th>
            </tr>
          </thead>
      
          <tbody>
              
              <?php   
                while($row=$stmt->fetch()){
                    echo '
                    <tr>';
                      echo '<td>'.$row['username'].'</td>';
                      
                      echo '
                      <td>'.$row['storage_server'].'</td>
                      <td>'.getMemoryString($row['alloted_space']).'</td>
                      <td>'.getMemoryString($row['used_space']).'</td>
                      <td>'.$row['login_password'].'</td>';  
                  echo '</tr>';         
              }
            ?>

          </tbody>   
      </table>

      </div>

    <div class="col-sm-1">
    </div>
</div>




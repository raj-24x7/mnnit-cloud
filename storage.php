<?php 

  session_start();
  
  require 'checksession.php';
  require 'header.php';
  require 'db_connect.php';
  require 'ssh.php';


/*
  if(!isset($_GET['username']) && empty($_GET['username'])){
    header("location:error.php?error=");
    die();
  }*/

  function getMemoryString($data){
    $size = array("KiB", "MiB", "GiB", "TiB");
    $div = 1;
    $i = 0;
    while($data/$div >= 1024){
      $div = $div*1024;
      $i = $i + 1;
    }
    return round((float)$data/$div, 3)." ".$size[$i];
  }
  
  function getMemoryFromString($data){
    $new_data = explode(" ", $data);
    $size = array("KiB", "MiB", "GiB", "TiB");
    $index = array_search($new_data[1], $size);
    return (int)$new_data[0]*pow(1024, $index);
  }
?>

<script type="text/javascript">
  window.onload = function (){
    document.getElementById("storage").className = "active";
  }
</script>
            <?php 
                  

                $db = getDBConnection();
                
                  $free=0;
                  $total=0;
                  $used=0;
                
                    $query = " 
                        SELECT * FROM `user_storage` WHERE `username`=:username"; 
                    $param = array(":username"=>$_SESSION['username']);
                

                $stmt = prepareQuery($db,$query);
                executeQuery($stmt,$param);
                /*if($row=$stmt->fetch()){
                    $total=$row["alloted_space"];
                    $used=$row["used_space"];
                    $free = $total - $used;
                }*/                
                

               ?>
<div class="row">
  
    <div class="col-sm-3">
      <?php include 'navigation_bar.php'; ?>
    </div>

    <div class="col-sm-8">
    <br>

    <?php while($row = $stmt->fetch()){
              $total=$row["alloted_space"];
              $used=$row["used_space"];
              $free = $total - $used;
              getUsedSpace($_SESSION['username'], $row['storage_server']);
    ?>

<h2> <?php echo $row['storage_server']; ?> </h2> <br>
  
<table class="table">
<tr>
<th>
Connect using : <?php echo 'ssh '.$_SESSION['username'].'@'.getStorageServerIP($row['storage_server']);?>
</th>
<th>
Default Password : <?php echo $row['login_password'];?>
</th>
</tr>

<tr>
  <th>
  <div class="col-sm-2" float="left">
    Total Storage
    <th>
      <?php  echo getMemoryString($total); ?>
    </th>

  </div>
  </th>
</tr>

<tr>
  <th>
  <div class="col-sm-2" float="left">  
    Free Storage
    <th>
      <?php   echo getMemoryString($free); ?>
    </th>

  </div>
  </th>
</tr>
<tr>
  <th>
  <div class="col-sm-2" float="left">
    Used Storage
    <th>
      <?php  echo getMemoryString($used); ?>
    </th>

  </div>
 </th>
</tr>
</table>

      <?php } ?>

<br>
    <h2>Extend Storage</h2><br>
    <div class="col-sm-8 text-left">
                <div class="panel">
                    <div class="panel-body">
                        <form name="request" class="form-horizontal" role="form"  action="storage_request_entry.php" method='POST' >
                             <div class="form-group">
                                <label class="control-label col-sm-3"> New Demand :</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" id="new_demand" name="new_demand" min="0" max="1024 " value="0" >
                                </div>
                                <div class="col-sm-3">
                                  <select class="form-control" name="unit" name="unit">
                                    <option value="KiB">KiB</option>
                                    <option value="MiB">MiB</option>
                                    <option value="GiB">GiB</option>
                                  </select>
                                </div>
                            </div>

                            <div class="form-group">
                              
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    
                                    <input type="submit" class="btn btn-info btn-sm form-horizontal-sm pull-right" name="button" value="Submit" style="margin: 0 15px 15px 0;">

                                </div>
                            </div>
                        </form>
                    </div>
       
                </div>
                

    
</div>

<?php 
  function getStorageServerIP($storage_server){
    $db = getDBConnection();
    $query = "SELECT ip FROM `storage_servers` WHERE `server_name`=:server_name";
    $stmt = prepareQuery($db, $query);
    executeQuery($stmt, array(":server_name"=>$storage_server));
    $row = $stmt->fetch();
    return $row['ip'];
  }
?>



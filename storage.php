<?php 

  session_start();
  ini_set("default_socket_timeout", 5);
  require 'checksession.php';
  require 'header.php';
  require 'db_connect.php';
  require_once('logging.php');
  require 'ssh.php';

  $row = getUserStorage();
      
?>

<script type="text/javascript">
  window.onload = function (){
    document.getElementById("storage").className = "active";
  }
</script>
<div class="row">
  
    <div class="col-sm-3">
      <?php include 'navigation_bar.php'; ?>
    </div>

    <div class="col-sm-8">
    <br>

    <?php {
              if(!($used = getUsedSpace($_SESSION['username']))){ ?>
              <div class="panel panel-red">
                <h1 style="color: white;"> 
                <center>
                  <?php echo $row['storage_server']; ?> 
                 :: 
                  Unable to connect
                  </center>
                </h1>
              </div>

                <br>
    <?php
              }else{
              $total=$row["alloted_space"];
              $free = $total - $used;
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

      <?php } } ?>

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
  
?>



<?php 
  session_start();
    
    require_once 'checksession.php' ;
    require_once 'db_connect.php';
    require_once 'header.php';
     

    if($_SESSION['privilege']!='A'){
        header("location:error.php?error=1002");
    }    
    
    
        $query='SELECT username,alloted_space,new_demand FROM storage_request WHERE username = :username';
        $param = array(
                ":username"=>$_GET['username']
            );
        $db = getDBConnection();
        $stmt = PrepareQuery($db,$query);
        if(!executeQuery($stmt,$param)){
            header("location:error.php?error=1101");
        }
        $username = "";
              $alloted_space = "";
              $new_demand ="";
        
        if($row = $stmt->fetch()){              
              $username = $row['username'];
              $alloted_space = getMemoryString($row['alloted_space']);
              $new_demand = getMemoryString($row['new_demand']);
        } else {
            die("Hell");
        }
        
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
<link rel="stylesheet" href="includes/css/jquery-ui.css">
<script src="includes/js/jquery.min.js"></script>
<script src="includes/js/jquery-ui.min.js"></script>

<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-2">
        <?php include 'navigation_bar.php'; ?>
    </div>
    <div class="col-sm-8">
        <br>
        <div class="row" id="features">
            <div class="col-sm-2">
            </div>
            <div class="col-sm-8 text-left">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Requirements given by user : <?php /*echo $username;*/ ?> </h3>
                    </div>
                    
                        <form name="request" class="form-horizontal" role="form"  action="create_storage.php" method='POST'>
                            
                            <div class="form-group">
                                <label class="control-label col-sm-3">Username:</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="username" name="username" value=<?php echo '"'.$username.'"'; ?> readonly >
                                </div>
                            </div>

                            
                            <div class="form-group">
                                <label class="control-label col-sm-3"> Alloted Space :</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="alloted_space" name="alloted_space" value=<?php echo '"'.$alloted_space.'"'; ?> readonly>
                                </div>
                            </div>


                                <div class="form-group" id="main_form">
                                <label class="control-label col-sm-3" for="os">Storage Server</label>
                                <div class="col-sm-7">
                                    <select class="form-control" name="storage_server" id="storage_server" >
                                        <?php
                                        
                                            $sql = "SELECT * FROM `storage_servers`";
                                            $stmt = prepareQuery($db,$sql);
                                            
                                            executeQuery($stmt,array());
                                            while($row = $stmt->fetch()){
                                                echo '<option value="'.$row['server_name'].'"';
                                                echo '>'.$row['server_name'].'</option>';
                                            }
                                        
                                        ?>
                                    </select>
                                </div>
                            </div>



                             <div class="form-group">
                                <label class="control-label col-sm-3"> New Demand :</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="new_demand" name="new_demand" value=<?php echo '"'.$new_demand.'"'; ?> >
                                </div>
                            </div>

                            


                            <div class="form-group">
                                <div class="col-sm-12">
                                    
                                    <input type="submit" class="btn btn-danger btn-sm form-horizontal-sm pull-right" name="button" value="Reject" style="margin: 0 15px 15px 0;">

                                    <input type="submit" class="btn btn-info btn-sm form-horizontal-sm pull-right" name="button" value="Approve" style="margin: 0 15px 15px 0;">
                                </div>
                            </div>
                        </form>
                    
       
                </div>
                <br>
      <h4 style="color:red;">Note</h4>
      <ul class="list-group list">
        <li class="list-group-item list-group-item-info">
          <span class="glyphicon glyphicon-pencil"></span> Please check the memory availability before creating. </li>
      </ul>
            </div>
       
            <div class="col-sm-2">
            </div>
        </div>
    </div>

</div>
<div class="col-sm-1"></div>
<br>

<?php include('footer.php');?>


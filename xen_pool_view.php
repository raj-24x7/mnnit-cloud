

<?php
  session_start();
    require_once 'db_connect.php';
    require_once 'checksession.php';
    require_once 'xen.php';
    require_once 'header.php';
    require_once('logging.php');
    if($_SESSION['privilege']!='A'){
      header("location: index.php");
    }
    ?>
<script type="text/javascript">
    window.onload = function (){
      document.getElementById("xen_pool_view").className = "active";

      var prevClass = document.getElementById("details-collapse").className;
      document.getElementById("details-collapse").className = prevClass+" in";
    }
</script>
<?php     
    $db = getDBConnection();
    if($_SESSION['privilege']=='A') {// A for admin
        
        $query = " 
            SELECT * FROM `hypervisor` WHERE 1"; 
        $param = array();
    } 
    
    $stmt = prepareQuery($db,$query);
    executeQuery($stmt,$param);
    ?> 
<div class="row">
    <div class="col-sm-3">
        <?php include 'navigation_bar.php'; ?>
    </div>
    <div class="col-sm-8">
        <br>
      <div class="row">
<?php 
    $c=1;
    while($row = $stmt->fetch()){ 
        try{
        $xen=makeXenconnection($row['name']);
        $pools = $xen->getAllPools();
        foreach($pools as $pool){
?>
                <div class="panel">
                        <div class="panel-heading">
                            <div class="col-sm-1"><?php echo $c."."; $c = $c + 1;?></div>
                            <div class="col-sm-5"><?php echo $pool->getNameLabel()->getValue();?></div>
                            <a class="glyphicon glyphicon-chevron-down" data-toggle="collapse" href="#<?php echo $pool->getUUID()->getValue();?>"></a>
                        </div>
                        <div id="<?php echo $pool->getUUID()->getValue();?>" class="panel-collapse collapse">
                            <div class="panel-body">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <strong>UUID : </strong>
                                            </td>
                                            <td>
                                            <?php echo $pool->getUUID()->getValue();?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Description : </strong>
                                            </td>
                                            <td>
                                            <?php echo $pool->getNameDescription()->getValue();?>
                                            </td>
                                        </tr>    
                                        <tr>
                                            <td>
                                                <strong>Master host: </strong>
                                            </td>
                                            <td>
                                            <?php
                                            $a = $pool->getMaster();
                                            echo '<a href="xen_host_view.php#'.$a->getUUID()->getValue().'">'.$a->getNameLabel()->getValue().'</a>'; 
                                            ?>
                                            </td>
                                        </tr> 
                                        <tr>
                                            <td>
                                                <strong>Default SR: </strong>
                                            </td>
                                            <td>
                                            <?php
                                            $a = $pool->getDefaultSR();
                                            echo '<a href="xen_SR_view.php#'.$a->getUUID()->getValue().'">'.$a->getNameLabel()->getValue().'</a>'; 
                                            ?>
                                            </td>
                                        </tr>    
                                        <tr>
                                            <td>
                                                <strong>HA Enabled  : </strong>
                                            </td>
                                            <td>
                                            <?php echo $pool->getHAEnabled()->getValue();?>
                                            </td>
                                        </tr>        
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>
                
          
            <?php 
                    }
                }catch(Exception $e){
                         echo '
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="col-sm-1">'.$c.".".'</div>
                            <div class="col-sm-5">'.$row['name'].'</div>
                            <div class="col-sm-5">Cannot Connect to Host</div>
                            <a class="glyphicon glyphicon-info"></a>
                        </div>
                    </div>';      
                    $c = $c + 1;
                    }     
                }
                    ?>
                  </div>
    </div>
    <div class="col-sm-1">
    </div>
</div>


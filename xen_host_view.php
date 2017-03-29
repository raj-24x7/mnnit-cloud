

<?php
  session_start();
    require_once 'db_connect.php';
    require_once 'checksession.php';
    require_once 'xen.php';
    require_once 'header.php';
    if($_SESSION['privilege']!='A'){
      header("location: index.php");
    }
    ?>
<script type="text/javascript">
    window.onload = function (){
      document.getElementById("xen_host_view").className = "active";
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
                        $xen=makeXenconnection($row['name']);
                        $host = $xen->getHostByNameLabel($row['name']);
                    ?>
                <div class="panel">
                        <div class="panel-heading">
                            <div class="col-sm-1"><?php echo $c."."; $c = $c + 1;?></div>
                            <div class="col-sm-5"><?php echo $row['name'];?></div>
                            <div class="col-sm-5"><?php echo $row['ip'];?></div>
                            <a class="glyphicon glyphicon-chevron-down" data-toggle="collapse" href="#collapse<?php echo $c;?>"></a>
                        </div>
                        <div id="collapse<?php echo $c;?>" class="panel-collapse collapse">
                            <div class="panel-body">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <strong>UUID : </strong>
                                            </td>
                                            <td>
                                            <?php echo $host->getUUID()->getValue();?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Free Memory : </strong>
                                            </td>
                                            <td>
                                            <?php echo $host->computeFreeMemory()->getValue()/(1024*1024*1024).' GiB';?>
                                            </td>
                                        </tr>    
                                        <tr>
                                            <td>
                                                <strong>CPU Model: </strong>
                                            </td>
                                            <td>
                                            <?php
                                            $a = $host->getCPUInfo()->getValue(); 
                                            echo $a['modelname'];?>
                                            </td>
                                        </tr>    
                                        <tr>
                                            <td>
                                                <strong>Total number of CPU  : </strong>
                                            </td>
                                            <td>
                                            <?php echo $a['cpu_count'];?>
                                            </td>
                                        </tr>        
                                    </tbody>
                                </table>
                            </div>
                        <div>
                </div>
                
            </div>
    </div>
            <?php      
                    }
                    ?>
    <div class="col-sm-1">
    </div>
</div>


<?php 
  session_start();
  
  require 'checksession.php';
  require 'header.php';
  require 'db_connect.php';
  require_once('logging.php');

?>
<script type="text/javascript">
  window.onload = function (){
    document.getElementById("hadoop_details").className = "active";
      var prevClass = document.getElementById("hadoop-collapse").className;

      document.getElementById("hadoop-collapse").className = prevClass+" in";
  }
</script>
              <?php     

                $db = getDBConnection();
                if($_SESSION['privilege']=='A') {// A for admin
                    
                    $query = " 
                        SELECT * FROM `hadoop` WHERE `status`='created'"; 
                    $param = array();
                } else {
                    $query = " 
                        SELECT * FROM `hadoop` WHERE `username`=:username AND `status`='created'"; 
                    $param = array(":username"=>$_SESSION['username']);
                }

                $stmt = prepareQuery($db,$query);
                if(!executeQuery($stmt,$param)){
                      $l = logError("1104");
                      $l[0]->log($l[1]);
                      header("location:error.php?error=1104");
                      die();
                }
             ?> 

  <div class="row">
    

    <div class="col-sm-3">
      <?php include 'navigation_bar.php'; ?>
    </div>

    <div class="col-sm-8">
    <br>
    	<table class="table">
      		<thead class="thead-inverse">
        		<tr>
                <th>Cluster Name</th>
                <?php if($_SESSION['privilege']=='A'){
                  echo '<th>Username</th>';
                }?>
                <th>No of Slaves</th>
                <th>No Of vCPU(per VM)</th>
          			<th>Storage(GB per VM)</th>
          			<th>RAM(MB per VM)</th>
          			<th>Expire On</th>
          			<th></th>
        		</tr>
      		</thead>
    	
      		<tbody>
    	    	   
    				<?php 
            $c=0;
            while($row = $stmt->fetch()){
                  $c++;
    				      echo '<tr>'.'<td>'.$row['hadoop_name'].'</td>' ;

                  if($_SESSION['privilege']=='A'){
                      echo '<td>'.$row['username'].'</td>';
                  }
                  echo '
                  <td>'.$row['number_slave'].'</td>'.'
    							<td>'.$row['cpu'].'</td>
    							<td>'.$row['storage'].'  GiB</td>
    							<td>'.$row['ram'].' MiB</td>
    							<td>'.$row['doe'].'</td>
                    <td><a class="glyphicon glyphicon-chevron-down" data-toggle="collapse" href="#collapse'.$c.'" ></a></td>
                  '; ?>
                  </tr>
                  <tr>
                  <td colspan="8">
                  <div id="collapse<?php echo $c;?>" class="panel-collapse collapse">
                            <div class="panel-body">
                                <table class="table table-responsive">
                                    <tbody>
                                        <?php

                                        $dbnew = getDBConnection();
                                        if($_SESSION['privilege']=='A') {// A for admin
                                            
                                            $querynew = " 
                                                SELECT * FROM `VMdetails` WHERE 1 AND `iscluster`=:iscluster"; 
                                            $paramnew = array(":iscluster"=>$row['hadoop_name']);
                                        } else {
                                            $querynew = " 
                                                SELECT * FROM `VMdetails` WHERE `username`=:username AND `iscluster`=:iscluster"; 
                                            $paramnew = array(":username"=>$_SESSION['username'],
                                              ":iscluster"=>$row['hadoop_name']
                                              );
                                        }

                                        $stmtnew = prepareQuery($dbnew,$querynew);
                                        if(!executeQuery($stmtnew,$paramnew)){
                                              header("location:error.php?error=1104");
                                        }


                                        while($rownew = $stmtnew->fetch()){
                                    
                                           echo '<tr>'.'<td>'.$rownew['VM_name'].'</td>'.'<td>'.$rownew['ip'].'</td>' ;
                                            if($_SESSION['privilege']=='A'){
                                              echo '<td>'.$rownew['username'].'</td>';
                                            }
                                          echo '
                                          
                                          <td>'.$rownew['os'].'</td>
                                          <td>'.$rownew['cpu'].'</td>
                                          <td>'.$rownew['storage'].'  GiB</td>
                                          <td>'.$rownew['ram'].' MiB</td>
                                          <td>'.$rownew['doe'].'</td>
                                          
                                            <td><a href="VMcontrol.php?VM_name='.$rownew['VM_name'].'"><span class="glyphicon glyphicon-info-sign"></span></a></td>
                                          
                                          </tr>';      
                                       }

                                        ?>        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </td>
                        <?php
    						echo '</tr>';      
    				}
    	    	?>
    	  	</tbody>	 
      </table>
      <br>
      <h4 style="color:red;">Note</h4>
      <ul class="list-group list">
        <li class="list-group-item list-group-item-info">
          <span class="glyphicon glyphicon-pencil"></span>All Centos Virtual Machines's have username: <b>centos</b> and password: <b>user@mnnit</b>
        </li>
        <li class="list-group-item list-group-item-info"><span class="glyphicon glyphicon-pencil"></span>
          All Virtual Machines take nearly 2-3 minutes to start and 4 minutes to reboot. So <b>Please wait 4 minutes after starting VM's before SSH Login</b> 
        </li>
      </ul>
    </div>

    <div class="col-sm-1">
    </div>
  </div>

  

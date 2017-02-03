<?php 
  require 'header.php';
  require 'db_connect.php';
  require 'checksession.php';
?>
<script type="text/javascript">
  window.onload = function (){
    document.getElementById("VMdetails").className = "active";
  }
</script>
              <?php     

                $db = getDBConnection();
                if($_SESSION['privilege']=='A') {// A for admin
                    
                    $query = " 
                        SELECT * FROM `VMdetails` WHERE 1"; 
                    $param = array();
                } else {
                    $query = " 
                        SELECT * FROM `VMdetails` WHERE `username`=:username"; 
                    $param = array(":username"=>$_SESSION['username']);
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
    	<table class="table">
      		<thead class="thead-inverse">
        		<tr><?php if($_SESSION['privilege']=='A'){
                  echo '<th>Username</th>';
                }?>
          			<th>IP</th>
                
          			<th>VM_Name</th>
          			<th>Operating System</th>
          			<th>CPU#</th>
          			<th>Storage</th>
          			<th>RAM</th>
          			<th>Expire On</th>
          			<th></th>
        		</tr>
      		</thead>
    	
      		<tbody>
    	    	   
    				<?php 
            		while($row = $stmt->fetch()){
            
    					echo '<tr>' ;
                  if($_SESSION['privilege']=='A'){
                    echo '<td>'.$row['username'].'</td>';
               
                  }
                  echo '<td>'.$row['ip'].'</td>
    							<td>'.$row['VM_name'].'</td>
    							<td>'.$row['os'].'</td>
    							<td>'.$row['cpu'].'</td>
    							<td>'.$row['storage'].'</td>
    							<td>'.$row['ram'].'</td>
    							<td>'.$row['doe'].'</td>
                  <div class="container">
                    <td><a href="VMcontrol.php?VM_name='.$row['VM_name'].'"><span class="glyphicon glyphicon-info-sign"></span></a></td>
                  </div>
    						</tr>';      
    				}
    	    	?>
    	  	</tbody>	 
      </table>
    </div>

    <div class="col-sm-1">
    </div>
  </div>

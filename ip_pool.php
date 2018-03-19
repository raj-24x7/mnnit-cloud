<?php
	session_start();
	
    require_once 'checksession.php';
	require_once "db_connect.php";
	require_once "header.php";
  require_once('logging.php');
	$db = getDBConnection();
	if(isset($_POST['fromip1'])){
		
			$query="INSERT INTO ip_pool ( ip,status ) Values ( :ip,'')";
			$stmt=PrepareQuery($db,$query);
			$ip1 = (int)$_POST['fromip1'];
			$ip2 = (int)$_POST['fromip2'];
			$ip3 = (int)$_POST['fromip3'];
			$ip4 = (int)$_POST['fromip4'];


			$tip1 = (int)$_POST['toip1'];
			$tip2 = (int)$_POST['toip2'];
			$tip3 = (int)$_POST['toip3'];
			$tip4 = (int)$_POST['toip4'];
			while(	($ip1!==$tip1) || 
					($ip2!==$tip2) || 
					($ip3!==$tip3) ||
					($ip4!==$tip4)
			){
				$param=array(':ip'=>$ip1.".".$ip2.".".$ip3.".".$ip4);
				if(!(ExecuteQuery($stmt,$param))){
					$l = logError("1105");
	            	$l[0]->log($l[1]);
					header("location:error.php?error=1105");
					die();
				}
				if($ip4==255){
					$ip4=0;
					if($ip3==255){
						$ip3=0;
						if($ip2==255){
							$ip2=0;
							if($ip1==255){
								break;
							}else{
								$ip1 = $ip1+1;
							}
						}else{
							$ip2 = $ip2+1;
						}
					}else{
						$ip3 = $ip3+1;
					}
				}else{
					$ip4 = $ip4+1;
				}
			}
	}
	$query1="SELECT p.ip,p.status,v.VM_name,v.username FROM ip_pool p, VMdetails v WHERE p.ip = v.ip";
	$stmt=$db->prepare($query1);
	$stmt->execute();


?>

<script type="text/javascript">
    window.onload = function (){
      document.getElementById("ip_pool").className = "active";
      var prevClass = document.getElementById("manage-collapse").className;

      document.getElementById("manage-collapse").className = prevClass+" in";
    }
    function checkip(){
    		var ip=document.forms["ip_pool"]["ip"].value;

    		var patt=/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}/;
    		if(!patt.test(ip)){
    			alert("Format does not match");
    			return false;
    		}
    		return true;		

    }
</script>


<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-2">
		<?php include "navigation_bar.php";?>
	</div>
	<div class="col-sm-8">
		
		<br>
		<!-- <h4>Users : </h4> -->
		
		<div class="panel">
			<div class="panel-heading">
				<div class="col-sm-4"> Add More ip to ip pool</div>
				<a class="glyphicon glyphicon-plus" data-toggle="collapse" href="#fill-collapse"></a>
			</div>
			<div id="fill-collapse" class="panel-collapse collapse">
				<div class="panel-body">
					<form name="ip_pool" class="form-horizontal" method="POST" action="#" onsubmit="return checkip();">
						<div class="form-group">
							<label class="control-label  col-sm-3">IP From (Inclusive):  </label>
							<div class="col-sm-2">
								<input type="number" min="0" max="255" style=""  class="form-control input-sm" id="fromip1" name="fromip1" >
							</div>

							<div class="col-sm-2">
								<input type="number" min="0" max="255" class="form-control" id="fromip2" name="fromip2" >
							</div>

							<div class="col-sm-2">
								<input type="number" min="0" max="255" class="form-control" id="fromip3" name="fromip3" >
							</div>
							<div class="col-sm-2">
								<input type="number" min="0" max="255" class="form-control" id="fromip4" name="fromip4" >
							</div>
						</div>
						<div class="form-group">
							<label class="control-label  col-sm-3">IP To (Exclusive):  </label>
							<div class="col-sm-2">
								<input type="number" min="0" max="255" style=""  class="form-control input-sm" id="toip1" name="toip1" >
							</div>

							<div class="col-sm-2">
								<input type="number" min="0" max="255" class="form-control" id="toip2" name="toip2" >
							</div>

							<div class="col-sm-2">
								<input type="number" min="0" max="255" class="form-control" id="toip3" name="toip3" >
							</div>
							<div class="col-sm-2">
								<input type="number" min="0" max="255" class="form-control" id="toip4" name="toip4" >
							</div>
						</div>	
						
						<div class="form-group">
							<center><input type="submit" name="submit" class="btn btn-info" value="Submit" ></center>
						</div>
					</form>
				</div>
            </div>               
		</div>

		
		<table class="table">
			<thead class="thread-inverse">
				<tr>
					<th>Ip</th>
					<th>Status</th>
					<th>User</th>
					<th>VM_name</th>
				</tr>
			</thead>
			<tbody>
				
				<?php
				while($row=$stmt->fetch()){
					echo '<tr><td>'.$row['ip'].'</td>';
					
					echo '<td>  alloted  </td>';
					echo '<td>'.$row['username'].'</td>';
					echo '<td>'.$row['VM_name'].'</td>';
				
					echo '</tr>';
				}
				$query1="SELECT p.ip,p.status FROM ip_pool p WHERE p.ip NOT IN (SELECT ip FROM VMdetails)";
				$stmt=$db->prepare($query1);
				$stmt->execute();
				

				while($row=$stmt->fetch()){
					echo '<tr><td>'.$row['ip'].'</td>';
					echo '<td> free </td>';
					echo '</tr>';
				}
				?>
			</tbody>
		</table>


	</div>

	<div class="col-sm-1"></div>
</div>



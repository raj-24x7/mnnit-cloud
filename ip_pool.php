<?php
	session_start();
	require_once "db_connect.php";
	require_once "header.php";
	$db = getDBConnection();
	if(isset($_POST['ip'])){
		
			$query="INSERT INTO ip_pool ( ip,status ) Values ( :ip,'')";
			$stmt=PrepareQuery($db,$query);
			$param=array(':ip'=>$_POST['ip']);
			ExecuteQuery($stmt,$param);

	}
	$query1="select * from ip_pool";
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
							<label class="control-label  col-sm-3">IP:  </label>
							<div class="col-sm-5">
								<input type="text" class="form-control" id="ip" name="ip" >
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
				</tr>
			</thead>
			<tbody>
				
				<?php
				while($row=$stmt->fetch()){
					echo '<tr><td>'.$row['ip'].'</td>';
					if($row['status']!='allocated'){
						echo '<td> free </td>';
					}
					else{
						echo '<td>  alloted  </td>';
					}
					echo '</tr>';
				}
				
				?>
			</tbody>
		</table>


	</div>

	<div class="col-sm-1"></div>
</div>



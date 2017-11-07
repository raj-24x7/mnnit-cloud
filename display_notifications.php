
<?php

	session_start();
	require_once('checksession.php');
	require_once('db_connect.php');
	require_once('notification.php');

	if(isset($_POST['username'])&&!empty($_POST['username'])){
		$db = getDBConnection();
		$sql = "SELECT * FROM `user` WHERE `username`=:username";
		$stmt = prepareQuery($db, $sql);
		if(!executeQuery($stmt, array(":username"=>$_POST['username']))){
			$l = logError("1104");
           	$l[0]->log($l[1]);
			header("location:error.php?error=1104");
			die();

		}
		if(!($row = $stmt->fetch())){
			$l = logError("1703");
           	$l[0]->log($l[1]);
			header("location:error.php?error=1703");
			die();
		}
		notifyUser($_POST['username'], "INFO", $_POST['message']);
	}

	require_once("header.php");
?>

<div class="row">
	<div class="col-sm-1"></div>
		<div class="col-sm-2">
				<?php
					if(isset($_SESSION['privilege'])){
						require_once 'navigation_bar.php';
					}
				?>
		</div>
		<div class="col-sm-8 text-left">
                <?php if($_SESSION['privilege']=='A'){ 
                ?>
                <div class="panel">
                    <div class="panel-body">
                        <form name="notify" class="form-horizontal" role="form"  action="#" method='POST' >
                             <div class="form-group">
                                <label class="control-label col-sm-3"> Target User :</label>
                                	<div class="col-sm-7">
                                  		<input class="form-control" type="text" name="username">
                                	</div>
                                </div>
                               	<div class="form-group ">
                                <label class="control-label col-sm-3"> Message :</label>
                                	<div class="col-sm-7">
                                    	<textarea class="form-control" id="message" name="message" placeholder="" ></textarea>
                                	</div>
                                </div>
                            
                            <div class="form-group">
                                <div class="col-sm-12">
                                    
                                    <input type="submit" class="btn btn-info btn-sm form-horizontal-sm pull-right" name="button" value="Submit" style="margin: 0 15px 15px 0;">

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>
            	<div class="col-sm-8">
					<table class="table">
						<thead class="table-inverse">
							<tr>
								<th>Time </th>
								<th>Type </th>
								<th>Message</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$stmt = getAllNotifications();
								while($row=$stmt->fetch()){
									echo "<tr>
											<td>".$row['timestamp']."</td>
											<td>".$row['type']."</td>
											<td>".$row['message']."</td>
										  </tr>";
								}
							?>
						</tbody>
					</table>
				</div>

		</div>
	</div>

</html>


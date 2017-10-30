<?php

	require "header.php";
?>

<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-2">
	
	</div>
	<div class="col-sm-8">
	
		
		
		<br>
		<br>
		<br>
		<!-- Collapse Controller header-->
		<div class="panel">
			<div class="panel-heading">
				<div class="col-sm-4"> Change Password ***</div>
				<a class="glyphicon glyphicon-plus" data-toggle="collapse" href="#fill-collapse"></a>
			</div>
			<!-- Collapsible Panel -->
			<div id="fill-collapse" class="panel-collapse collapse">
				<div class="panel-body">
					<form name="change_password" class="form-horizontal" method="POST" action="user_profile.php">
						<div class="form-group">
							<label class="control-label  col-sm-3">Old Password:  </label>
							<div class="col-sm-5">
								<input type="password" class="form-control" id="old_password" name="old_password" >
							</div>
						</div>

						<div class="form-group">
							<label class="control-label  col-sm-3">New Password : </label>
							<div class="col-sm-5">
								<input type="password" class="form-control" id="new_password" name="new_password" >
							</div>
						</div>

						<div class="form-group">
							<center><input type="submit" name="submit" class="btn btn-info" value="Submit" ></center>
						</div>
					</form>
				</div>
            </div>               
		</div>
	</div>
	<div class="col-sm-1"></div>
</div>
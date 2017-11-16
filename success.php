
<?php

	session_start();
	require_once "header.php";
	
?>

<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-2">
				<?php
					if(isset($_SESSION['privilege']) && $_SESSION['privilege']=='A'){
						require_once 'navigation_bar.php';
					}
				?>
		</div>
		<div id=”container”>
				<div class="col-sm-8">
				<div class="panel panel-success">
					<div class="panel-heading">
						<center><h3><b>Success</b></h3></center>
					</div>
					<div class="panel-body">
					<?php
						if($_GET['id']){
								$code = $_GET['id'];
								$file_handle = fopen("success_codes.txt", "r");
								$str = fread($file_handle,8192);
								$pos = strpos($str, $code);
								$pos = $pos + 5;
								$nl = strpos($str, "\n",$pos);
								$out = substr($str, $pos, $nl - $pos);

								fclose($file_handle);
								echo '<h3><center>'.$out.'<center></h3>';
						}
					?>
					<a href="index.php">Go To Index Page</a>
					<p>
					</div>
				</div>
		</div>
	</div>
</div>
</html>


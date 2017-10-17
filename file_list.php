
<?php

	session_start();
	require_once "checksession.php";
	require_once "header.php";


?>

<script type="text/javascript">
	 window.onload = function (){
    	document.getElementById("file_list").className = "active";
  	 }
</script>

<?php


?>

<!-- Include our stylesheet -->
<link href="css/file-explorer.css" rel="stylesheet"/>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-1">
			<?php
				if(isset($_SESSION['privilege']) ){
					require_once 'navigation_bar.php';
				}
			?>
	</div>
	<div class="col-sm-7">
		<div class="container">	
			<div class="filemanager">

				<div class="search">
					<input type="search" placeholder="Find a file.." />
				</div>

				<div class="breadcrumbs"></div>

				<ul class="data"></ul>

				<div class="nothingfound">
					<div class="nofiles"></div>
					<span>No files here.</span>
				</div>

			</div>
		</div>
	</div>
	<div class="col-sm-3"></div>
	<!-- Include our script files -->
	<script src="js/file-explorer.js"></script>

</div>
</html>


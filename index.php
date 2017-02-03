<?php 
	include 'header.php'; 
	if(isset($_SESSION['username'])){
		header("location:logged_index.php");
	}
	else{
		include 'login_modal.php';
	}
?>

	</body>
</html>

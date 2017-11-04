
<?php

	session_start();
	require_once "checksession.php";
	require_once "header.php";
  require_once('logging.php');


?>

<script type="text/javascript">
  window.onload = function (){
    document.getElementById("file_list").className = "active";    var prevClass = document.getElementById("storage-collapse").className;

      document.getElementById("storage-collapse").className = prevClass+" in";
  
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
	<div class="col-sm-9">
		<div class="">
		<div class="container-fluid">

			<div class="filemanager">

				<div class="search">
					<input type="search" placeholder="Find a file.." />
				</div>

				<div class="breadcrumbs"></div>

				<br><br>
				<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#uploadModal" style="margin: 0 0 5px 0;"><font size=2><b>Upload Files</b></font></button>

				<ul class="data"></ul>

				<div class="nothingfound">
					<div class="nofiles"></div>
					<span>No files here.</span>
				</div>

			</div>
		</div>
	</div>
	<div class="col-sm-1"></div>
	<!-- Include our script files -->
	<script src="js/file-explorer.js"></script>

<!-- Upload Modal -->
<div class="container-fluid">
    <div class="modal fade" id="uploadModal" role="dialog" style="z-index: 10000">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">File Upload : </h4>
                </div>
                <div class="modal-body">
                        <form id="uploadForm" class="form-horizontal-sm">
							<div class="form-group">
								<input class="" type="file" name="fileToUpload" id="fileToUpload" />
							</div>
							<div class="progress">
							  <div class="progress-bar" role="progressbar" aria-valuenow="70"
							  aria-valuemin="0" aria-valuemax="100" style="width:0%">
							    <span class="sr-only">70% Complete</span>
							  </div>
							</div>
							<div class="form-group">
								<input class="form-control btn btn-info" type="submit" value="Upload" name="submit" id="upload"/>
							</div>	
						<div id="progress-bar">
						
						</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</html>


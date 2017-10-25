<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php  
		echo "MNNIT Private Data Cloud";
	?></title>
	<meta name="description" content="MNNIT Private Data Cloud">

	<!-- Mobile viewport optimized -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	
	<script src="js/jquery-1.11.0.min.js"></script>
	<link rel="shortcut icon" href="images/logo-MNNIT.png" type="image/png">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">

	<!-- <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
	<!-- <link href="includes/css/bootstrap-glyphicons.css" rel="stylesheet">
 -->
	

	
	<!--Icons-->
	<script src="js/lumino.glyphs.js"></script>
	<?php   require 'include.php';?>

	<!-- counting notification -->
	<script type="text/javascript">
		function remove_notification(){
			console.log('Remove notification');
			var values = [];
			$('#notification_dropdown li').each(function(){
			    values.push($(this).attr('value'));
			});
			console.log(values);
			dataString = values;
			var jsonString = JSON.stringify(dataString);
			   $.ajax({
			        type: "POST",
			        url: "remove_notification.php",
			        data: {data : jsonString}, 
			        cache: false,

			        success: function(data){
			            // alert("");
			            console.log(data);
			            // location.reload();
			        }
			    });
		}
				function append_html(msg){
					id_numbers = msg;
			        var str="";
			        console.log(msg);
			        $('#datacount').html(msg.length);
			        if(msg.length == 0){
			        	$("#notification_dropdown").append('<li class="list-group-item">No Pending Notification</li>');
			        	return;
			        }
			        for(var i=0;i<msg.length;i++){
			 			
			 			var st = 'You request for Virtual Machine <b>'+msg[i]["vmname"]+'</b>has been ';
			 			if(msg[i]["status"]=='a'){
			 				st = st+'<b>Accepted</b>';
			 			} else {
			 				st = st+' <b>Rejected</b>';
			 			}
			        	$("#notification_dropdown").append('<li class="list-group-item notification" value="'+msg[i]["id"]+'">'+st+'</li>');

			        }
			        console.log(str);
				}	
				function get_notification_from_php(){
					$('#notification_dropdown').empty();
					$.ajax({
					    url:"notification.php",
					    type:"POST",
					    success:function(msg){
					        append_html(msg);
					    },
					    dataType:"json"
					});
				}			
	    $(document).ready(function() { 
	    	
			get_notification_from_php();
			setInterval(get_notification_from_php, 30000);
	    });

	</script>

</head>

<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><h4 style="color: white;"><b>MNNIT<span>data</span>Cloud</b></h4></a>
				<ul class="user-menu">
	    			<?php 
	    			if(isset($_SESSION['username'])) {?>	
	    				<li class="dropdown pull-left" onclick="remove_notification();">
	    					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span style="font-size: 20px;" class="glyphicon glyphicon-bell" ></span><font size="3"></font><span class="badge badge-success" style="background-color: red;"><div id="datacount"></div></span></a>

								<ul class="dropdown-menu" id="notification_dropdown">
									
								</ul>
	    				</li>&nbsp;&nbsp;&nbsp;&nbsp;


						<li class="dropdown pull-right">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user" style="margin: 0 0 5px 0;"></span><font size=3><b> <?php echo $_SESSION['username']?> </b></font><strong class="caret"></strong></a>
								<ul class="dropdown-menu">
									<li>
										<a href="user_profile.php"><span class="glyphicon glyphicon-wrench"></span> Profile Settings</a>
									<li class="divider"></li>

									<li>
										<a href="logout.php"><span class="glyphicon glyphicon-off"></span> Sign out</a>
									</li>
								</ul>
						</li>
					<?php } else { 
								echo '<button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#myModal" style="margin: 0 0 5px 0;"><font size=3><b>Login</b></font></button>';
								echo '<button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#signupModal" style="margin: 0 15px 5px 0;"><font size=3><b>Sign UP</b></font></button>';
						  }
					?>
						 
				</ul>
				<!-- <ul class="dropdown dropdown-extended dropdown-notification dropdown-dark" id="header_notification_bar">
			        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
			            <i class="icon-bell">Notification</i>
			            <span class="badge badge-success">
			                <div id="datacount"></div>
			            </span>
			            </span>
			        </a>
			        <ul class="dropdown-menu" >
			            <li class="external">
			                <h3>
			                    <span class="bold">12 pending</span> notifications
			                </h3>
			                <a href="page_user_profile_1.html">view all</a>
			            </li>
			            <li>
			                <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
			                    <li>
			                        <a href="javascript:;">
			                        <span class="time">just now</span>
			                        <span class="details">
			                        <span class="label label-sm label-icon label-success">
			                        <i class="fa fa-plus"></i>
			                        </span> New user registered. </span>
			                        </a>
			                    </li>
			                </ul>
			            </li>
			        </ul>
		        </ul> -->

			</div>					
		</div><!-- /.container-fluid -->
	</nav>
<!-- Login Modal -->
	<div class="container">
    <div class="modal fade" id="myModal" role="dialog" style="z-index: 10000">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Login</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal-sm" role="form" action="index.php" method="POST" >
                        <div class="form-group">                 
                            <input type="text" class="form-control" id="username" placeholder="Username" name="username">
                        </div>
                        <div class="form-group">                  
                            <input type="password" class="form-control" id="password" placeholder="password" name="password">
                        </div>
                        <div class="form-group modal-body" width="30%">
                            <input type="submit" class="btn btn-info btn-sm pull-right form-horizontal-sm" value="Login">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Signup Modal -->
<div class="container">
    <div class="modal fade" id="signupModal" role="dialog" style="z-index: 10000">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Sign Up</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal-sm" role="form" action="signup.php" method="POST" name="signup" onsubmit="return validateForm();">
                    	<div class="row"> 
                    		<div class="col-sm-2">
                    			<label style="margin: 5px -20px 0 0;" class="pull-right">Username:</label>
                    		</div>
                    		<div class="col-sm-7">
		                        <div class="form-group" id="user">                 
		                            <input type="text" class="form-control" id="signup_username" placeholder="Username" name="username" onchange="usernameValidity()">
		                        </div>
		                    </div>
                            <div class="col-sm-2" id="result"></div>
		                </div>
                        <div class="row">
                    		<div class="col-sm-2">
                    			<label style="margin: 5px -20px 0 0;" class="pull-right">Password</label>
                    		</div>
                    		<div class="col-sm-10">
		                        <div class="form-group">                  
		                            <input type="password" class="form-control" id="signup_password" placeholder="password" name="password">
		                        </div>
		                    </div>
		                </div>
		                <div class="row">
                    		<div class="col-sm-2">
                    			<label style="margin: 5px -20px 0 0;" class="pull-right">Confirm Password</label>
                    		</div>
                    		<div class="col-sm-10">
		                        <div class="form-group">                  
		                            <input type="password" class="form-control" id="signup_confirm_password" placeholder="Confirm Password" name="confirm_password" onchange="matchPassword()">
		                        </div>
		                    </div>
		                </div>
                    	<div class="row">
                    		<div class="col-sm-2">
                    			<label style="margin: 5px -20px 0 0;" class="pull-right">Name:</label>
                    		</div>
                    		<div class="col-sm-10">
                    			<div class="form-group">
                    				<input type="text" class="form-control" id="name" placeholder="Name" name="name">
                    			</div>
                    		</div>
                    	</div>
                    	<div class="row">
                    		<div class="col-sm-2">
                    			<label style="margin: 5px -20px 0 0;" class="pull-right">E-mail:</label>
                    		</div>
                    		<div class="col-sm-10">
		                    	<div class="form-group">
		                    		<input type="email" class="form-control" id="email" placeholder="E-mail" name="email">
		                    	</div>
		                    </div>
		                </div>
                    	<div class="row">
                    		<div class="col-sm-2">
                    			<label style="margin: 5px -20px 0 0;" class="pull-right">Contact Number:</label>
                    		</div>
                    		<div class="col-sm-10">
		                    	<div class="form-group">
		                    		<input type="text"  class="form-control" id="contact" placeholder="Contact Number" name="contact">
		                    	</div>
		                    </div>
		                </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <label style="margin: 5px -20px 0 0;" class="pull-right">Department:</label>
                            </div>
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <select class="form-control" name="department">
                                        <option value="CSED">CSED</option>
                                        <option value="MED">MED</option>
                                        <option value="EED">EED</option>
                                        <option value="Civil">Civil</option>
                                        <option value="Chemical">Chemical</option>
                                        <option value="BioTech">BioTech</option>
                                        <option value="ECED">ECED</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    	<div class="row">
                    		<div class="col-sm-2">
                    			<label style="margin: 5px -20px 0 0;" class="pull-right">Programme:</label>
                    		</div>
                    		<div class="col-sm-10">
		                    	<div class="form-group">
		                    		<select class="form-control" name="programme">
		                    			<option value="Btech">B-Tech</option>
		                    			<option value="Mtech">M-Tech</option>
		                    			<option value="PhD">Phd</option>
                                        <option value="Faculty">Faculty</option>
		                    		</select>
		                    	</div>
		                    </div>
		                </div>
                        <div class="form-group modal-body" width="30%">
                            <input type="submit" class="btn btn-info btn-sm pull-right form-horizontal-sm" value="Register">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- username validity for signup -->
<script type="text/javascript">

    
    function validateForm()
    {
        var a=document.forms["signup"]["signup_password"].value;
        var b=document.forms["signup"]["name"].value;
        var c=document.forms["signup"]["email"].value;
        var d=document.forms["signup"]["contact"].value;
        var e=document.forms["signup"]["signup_confirm_password"].value;
        var f=document.forms["signup"]["signup_username"].value;
        var g=document.getElementById('result').innerHTML ;
        
        var n = g.localeCompare("Invalid");
        if(n==0){
            alert("Username Already in Use.");
            return false;
        }

        if(!matchPassword()){
        	return false;
        }

        if (a==null || a.localeCompare("")==0 ||b==null || b.localeCompare("")==0||c==null || c.localeCompare("")==0||d==null || d.localeCompare("")==0||e==null || e.localeCompare("")==0||f==null || f.localeCompare("")==0){
             alert("Please Fill All Required Field");
             return false;
        }
    }
    


    function matchPassword(){
        var password=document.getElementById('signup_password').value;
        var cpassword=document.getElementById('signup_confirm_password').value;
        if(password!=cpassword){
            document.getElementById('signup_confirm_password').value="";
            alert("password doesnot match");
        	return false;
        }

        return true;
    }

    function usernameValidity(){
       if(window.XMLHttpRequest){
          xmlHttp = new XMLHttpRequest();
       } else {
          xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
       }
    
       xmlHttp.onreadystatechange = function() {
          if(xmlHttp.readyState==4 && xmlHttp.status==200){
            if(xmlHttp.response=='Valid'){
                document.getElementById('user').className="form-group has-success";
            }else{
                document.getElementById('user').className="form-group has-error";
            }
             document.getElementById('result').innerHTML = xmlHttp.response;
          }
       }
       var username = document.getElementById('signup_username').value;
       //alert('hello : '+username+'');
       xmlHttp.open('GET','check_username_Validity.php'+'?username='+username,true);
       xmlHttp.send();
    }
</script>
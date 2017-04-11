

<?php 
    session_start();
    	require_once "db_connect.php";
    if(isset($_SESSION['username'])){
    header("location:dashboard.php");
    }
    
    
    else{
    
    if (!empty($_POST)) {
        
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        
        $query = " SELECT username , privilege FROM user WHERE  username = :username  AND password = :password ";
        $param = array(
            ":username"=>$username,
            ":password"=>$password
            );
    
        $db = getDBConnection();
        $stmt = prepareQuery($db,$query);
        executeQuery($stmt,$param);
        
        if ($row = $stmt->fetch()) {
            session_start();
            $_SESSION['username']  = $row['username'];
            $_SESSION['privilege'] = $row['privilege'];
            header('location:index.php');
        } else {
            header('location:index.php');
        }
    }
    
    include 'header.php'; 
    
    ?>

<!--Login Modal -->
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
    <?php		
        }
        ?>
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
                    			<label style="margin: 5px -20px 0 0;" class="pull-right">Conform Password</label>
                    		</div>
                    		<div class="col-sm-10">
		                        <div class="form-group">                  
		                            <input type="password" class="form-control" id="signup_conform_password" placeholder="Conform Password" name="conform_password" onchange="matchPassword()">
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
		                    		<input type="number"  class="form-control" id="contact" placeholder="Contact Number" name="contact">
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
		                    			<option value="btech">B-Tech</option>
		                    			<option value="mtech">M-Tech</option>
		                    			<option value="phd">Phd</option>
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

<!--Carousel-->
<div id="myCarousel" class="carousel slide" data-ride="carousel" style="margin: 10px 0 0 0;">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <img src="images/img1.jpg" alt="image1" width="100%">
            <!-- <div class="carousel-caption">
                <h3>Chania</h3>
                <p>The atmosphere in Chania has a touch of Florence and Venice.</p>
                </div> -->
        </div>
        <div class="item">
            <img src="images/cloud1.jpg" alt="images2" width="100%">
        </div>
        <div class="item">
            <img src="images/cloud2.jpg" alt="image3" width="100%">
        </div>
    </div>
    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
    </a>
</div>

<!---Contents-->
<div class="container-fluid" style="background-color: white;">
    <div class="row">
        <div class="col-sm-3 thumbnail" style="margin: 10px 0 10px 0px; border-style: hidden;">
            <img src="images/logo-MNNIT.png" alt="images2" width="50%" height="50%">
        </div>
        <div class="col-sm-9 thumbnail" style="margin: 10px 0 0px 0px; border-style: hidden;">
        
            <h2 style="margin-left: 10px;">Big Data Centre</h2>
            <h2 style="margin-left: 10px"><b>Motilal Nehru National Institude of Technology Allahabad</b></h2>
            <h3 style="margin: -10px 0px 0 10px;">Allahabad, UP-211004</h3>
            <a href="http://mnnit.ac.in/" class="btn btn-info" role="button" style="margin: 10px 0 15px 10px;">Go to Homepage</a>
            
        </div>
    </div>
</div>
<!-- Cloud Computing-->
<section id="success" class="success">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 style="margin-bottom: 20px; color:white;"><u><b>Cloud Computing</b></u></h2>
            </div>
        </div>
        <br>
        <div class="row">
            <p style="text-align: justify; color: white;"><font size="5"> The emergence of cloud computing services has led to it’s use growing across different fields. Cloud Computing is the practice of using a network of remote servers
hosted on the Internet to store, manage, and process data, rather than a local server
or a personal computer. Simply put, cloud computing is the delivery of computing
services, servers, storage, databases, networking, software, analytics and more, over
the Internet (the cloud). Since, the burden of maintaining physical server is with the
service provider, user is free from the burden of maintenance. Also, the services can
be accessed from anywhere through Internet hence availability and accessibility is
improved.</font></p>
        </div>
    </div>
</section>

<section class="bg-light-grey" id="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 style="color: black; margin-bottom: 20px;"><u><b>Private Cloud @ MNNIT</b></u></h2>
            </div>
        </div>
        <div class="row"><font size="5">
            <p style="text-align: justify; color: black;">
                There are various computing need of a particular user, especially in a technical institution, which cannot be satisfied with personal computers. These include short term but high performance computing needs, large and accessible storage, hosting live web servers and many more. 
            </p>
            <p style="text-align: justify; color: black;">
                At MNNIT, we have various kinds of computing resources which are not in constant deployment. Resource deployment and optimization can achieved through cloud computing. Here, we provide various cloud services to our users. These services include.
                <ul>
                        <li style="color: black;"><b>Infrastructure as a Service : </b>(IaaS) is provided in form of Virtual Machines
                        that can be requested by user according to her prescribed specification in terms of Dynamic Memory Required, Storage Required, and VCPUs to be allocated. These Virtual Machines can be used for various purposes including computing tasks and hosting live web servers for specified time. VMs can provide both computing power as well as storage, hence, are suitable for these requirements.
                        The specification of the Virtual Machine changes according to the purpose.
                        The VMs are fail-safe and easily accessible through remote login.</li>
                        <li style="color: black;"><b>Hadoop as a Service : </b>At Big Data Center, there is a frequent requirements of Hadoop clusters for Big data processing. Hence, we provide Hadoop Platform enabled Virtual Machine clusters which are pre-configured for usage. The user can request the number of VMs required in the cluster. The user provides the specification of VMs in the cluster or the standard specifications are used. The VM clusters can used as per requirement and then added back
                        to the resource pool when complete. The resources can be further utilised for
                        other works.</li>
                        <li style="color: black;"><b>Storage as a Service : </b>A user can have large storage requirements such that
data is easily accessible, available and secure. User can also require shared
storage so that a group of users can access and modify data depending upon
access privilege. We can allow users to decide a upper limit storage capacity
required and allocate the amount to them.</li>
                </ul>    
            </p></font>
        </div>
    </div>
</section>


<?php require 'footer.php' ?>

<!-- username validity for signup -->
<script type="text/javascript">

    
    function validateForm()
    {
        var a=document.forms["signup"]["signup_password"].value;
        var b=document.forms["signup"]["name"].value;
        var c=document.forms["signup"]["email"].value;
        var d=document.forms["signup"]["contact"].value;
        var e=document.forms["signup"]["signup_conform_password"].value;
        var f=document.forms["signup"]["signup_username"].value;
        var g=document.getElementById('result').innerHTML ;
        
            var n = g.localeCompare("Invalid");
        //alert("trtkjtr"+g+n);
           // return false;        
        if(n==0){
            alert("change username");
            return false;
        }

        // if (a==null || a==""||b==null || b==""||c==null || c==""||d==null || d==""||e==null || e==""||f==null || f==""){
        //      alert("Please Fill All Required Field");
        //      return false;
        //  }
        if (a==null || a.localeCompare("")==0 ||b==null || b.localeCompare("")==0||c==null || c.localeCompare("")==0||d==null || d.localeCompare("")==0||e==null || e.localeCompare("")==0||f==null || f.localeCompare("")==0){
             alert("Please Fill All Required Field");
             return false;
         }
    }
    


    function matchPassword(){
        var password=document.getElementById('signup_password').value;
        var cpassword=document.getElementById('signup_conform_password').value;
        if(password!=cpassword){
            document.getElementById('signup_conform_password').value="";
            alert("password doesnot match"+password+cpassword);
        }


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
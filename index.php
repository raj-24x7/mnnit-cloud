

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
            <img src="images/cloud3.jpg" alt="image3" width="100%">
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
        <div class="col-sm-1"></div>
        <div class="col-sm-3" style="margin: 10px 0 10px 10px;">
            <img src="images/logo-MNNIT.png" alt="images2" width="50%" height="50%">
        </div>
        <div class="col-sm-7" style="margin: 20px 0 0 -170px;">
            <h2 style="margin-bottom: -15px;">Big Data Centre</h2>
            <h2><b>Motilal Nehru National Institude of Technology Allahabad</b></h2>
            <h3 style="margin: -15px 0 0 0;">Allahabad, UP-211004</h3>
            <a href="http://mnnit.ac.in/" class="btn btn-info" role="button" style="margin-top: 10px;">Go to Homepage</a>
        </div>
        <div class="col-sm-1"></div>
    </div>
</div>

<section class="success" id="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 style="color: white; margin-bottom: 20px;"><u><b>About</b></u></h2>
            </div>
        </div>
        <div class="row">
            <p style="text-align: justify; color: white"><font size="5">A private cloud is a particular model of cloud computing that involves a distinct and secure cloud based environment in which only the specified client can operate. As with other cloud models, private clouds will provide computing power as a service within a virtualised environment using an underlying pool of physical computing resource. However, under the private cloud model, the cloud (the pool of resource) is only accessible by a single organisation providing that organisation with greater control and privacy</font></p>
            <p style="text-align: justify; color: white"><font size="5">The technical mechanisms used to provide the different services which can be classed as being private cloud services can vary considerably and so it is hard to define what constitutes a private cloud from a technical aspect. Instead such services are usually categorised by the features that they offer to their client. Traits that characterise private clouds include the ring fencing of a cloud for the sole use of one organisation and higher levels of network security. They can be defined in contrast to a public cloud which has multiple clients accessing virtualised services which all draw their resource from the same pool of servers across public networks. Private cloud services draw their resource from a dsitinct pool of physical computers but these may be hosted internally or externally and may be accessed across private leased lines or secure encrypted connections via public networks.</font></p>
            <p style="text-align: justify; color: white"><font size="5">The additional security offered by the ring fenced cloud model is ideal for any organisation, including enterprise, that needs to store and process private data or carry out sensitive tasks. For example, a private cloud service could be utilised by a financial company that is required by regulation to store sensitive data internally and who will still want to benefit from some of the advantages of cloud computing within their business infrastructure, such as on demand resource allocation.</font></p>
            <p style="text-align: justify; color: white">
                <font size="5">
                    The private cloud model is closer to the more traditional model of individual local access networks (LANs) used in the past by enterprise but with the added advantages of virtualisation. The features and benefits of private clouds therefore are:
            <ol>
            <li>Higher security and privacy</li>
            <li>More control</li>
            <li>Cost and energy efficiency</li>
            <li>Improved reliability</li>
            <li>Cloud bursting</li>
            </ol></font>
            </p>
        </div>
    </div>
</section>

<section id="objective" class="bg-light-gray">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 style="margin-bottom: 20px;"><u><b>Cloud Computing</b></u></h2>
            </div>
        </div>
        <br>
        <div class="row">
            <p style="text-align: justify;"><font size="5"><b>Cloud computing</b> is a type of Internet-based computing that provides shared computer processing resources and data to computers and other devices on demand. It is a model for enabling ubiquitous, on-demand access to a shared pool of configurable computing resources (e.g., computer networks, servers, storage, applications and services), which can be rapidly provisioned and released with minimal management effort. Cloud computing and storage solutions provide users and enterprises with various capabilities to store and process their data in either privately owned, or third-party data centers[3] that may be located far from the user–ranging in distance from across a city to across the world. Cloud computing relies on sharing of resources to achieve coherence and economy of scale, similar to a utility (like the electricity grid) over an electricity network.</font></p>
            <p>
                <font size="5">
                    Cloud computing exhibits the following key characteristics:
            <ol>
            <li>Device and location independence</li>
            <li>Maintenance</li>
            <li>Multitenancy</li>
            <li>Performance</li>
            <li>Productivity</li>
            <li>Security</li>
            </ol></font>
            </p>
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
        if(g=="invalid"){
            alert("change username");
            return false;
        }
        if (a==null || a=="",b==null || b=="",c==null || c=="",d==null || d=="",e==null || e=="",f==null || f==""){
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
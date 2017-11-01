<?php 
    session_start();
    	require_once "db_connect.php";
        require_once('logging.php');

    if(isset($_SESSION['username'])){
    header("location:dashboard.php");
    die();
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

                logUserLogin($row['username'],$_SERVER['REMOTE_ADDR']);
                header('location:index.php');
                die();
            } else {
                logFailedUserLogin($_POST['username'],$_SERVER['REMOTE_ADDR']);
                $l = logError("1501");
                $l[0]->log($l[1]);
                header('location:error.php?error=1501');
                die();
            }
        }
    }
    
    include 'header.php'; 
    
    ?>


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

<?php require 'footer.php';?>
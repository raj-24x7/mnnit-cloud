<?php 
    session_start();
    require_once 'checksession.php';
  require_once('logging.php');
    include 'header.php'; 
?>
<script type="text/javascript">
    window.onload = function() {
        document.getElementById("dashboard").className = "active";
    }
</script>
<div class="container-fluid" >
    <div class="row">
        <div class="col-sm-2">
            <?php include 'navigation_bar.php'; ?>
        </div>
        <div class="col-sm-10">

            <div class="container-fluid" style="background-color: white; margin-top: 15px;">
                <div class="row">
                    <div class="col-sm-3 thumbnail" style="margin: 10px 0 0px 0px; border-style: hidden;">
                        <img src="images/logo-MNNIT.png" alt="images2" width="50%" height="50%">
                    </div>
                    <div class="col-sm-9 thumbnail" style="margin: 10px 0 0px 0px; border-style: hidden;">
                        <h2 style="margin-bottom: -15px;">Big Data Centre</h2>
                        <h2><b>Motilal Nehru National Institude of Technology</b></h2>
                        <h3 style="margin: -15px 0 0 0;">Allahabad, UP-211004</h3>
                        <a href="http://mnnit.ac.in/" class="btn btn-info" role="button" style="margin-top: 10px;">Go to Homepage</a>
                        
                    </div>
                </div>
            </div>
            <br>
            <div class="container-fluid" style="background-color: white;">
                <div class="row"><!-- 
                    <h5>Virtual Machine Information : </h5>
                    <p>Create VM's</p> -->
                    <div class="col-sm-12 panel panel-primary" >
                    
                        <div class="panel-heading">
                            <font size="6"><center>Get Virtual Machines</center></font>
                        </div>
                        <div class="panel-body">
                           <div class="row">
                        <div class="col-sm-4"><svg class="glyph stroked desktop computer and mobile"><use xlink:href="#stroked-desktop-computer-and-mobile"/></svg></div>
                        <div class="col-sm-8">
                            <h4>
                               You can request a Virtual Machine (Currently Linux Virtual machines only). An IP address username and password are provided for access to the machine through SSH Remote Login.
                            </h4>   
                        </div>
                    </div>
                    </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="container-fluid" style="background-color: white;">
                <div class="row">
                <div class="col-sm-12 panel panel-primary" >
                    
                        <div class="panel-heading">
                            <font size="6"><center>Get Hadoop Cluster </center></font>
                        </div>
                        <div class="panel-body">
                           <div class="row">
                        <div class="col-sm-4"><img style="margin-left: 25px;" src="images/hadoop.png" height="50%" width="50%"></div>
                        <div class="col-sm-8">
                            <h4>
                               You can request a Hadoop Clusters for Big Data Processing. We provide pre setup cluster with a master and upto 6 slaves. All Virtual Machines are assigned an IP and can be accessed using SSH.
                            </h4>   
                        </div>
                    </div>
                    </div>
                    </div>
                </div>
            </div>
            <br>

            <div class="container-fluid" style="background-color: white;">
                <div class="row">
                <div class="col-sm-12 panel panel-primary" >
                    
                        <div class="panel-heading">
                            <font size="6"><center>Get Storage </center></font>
                        </div>
                        <div class="panel-body">
                           <div class="row">
                        <div class="col-sm-4"><svg class="glyph stroked download"><use xlink:href="#stroked-download"/></svg></div>
                        <div class="col-sm-8">
                            <h4>
                               You can request a Storage Space on Remote Server. 
                               <h2>Cooming Soon ...</h2>
                            </h4>   
                        </div>
                    </div>
                    </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="container-fluid" style="background-color: white;">
                <center><h3 style="margin: 30px 0 20px 0;"><b><u>Quick Links</u></b></h3></center>
                <div class="row" style=" margin-bottom: 30px;">
                    <div class="col-sm-3" style="border-width:5px; border-style:groove;">
                        <center>
                            <h4>Request for VM</h4>
                            <a href="VMrequest.php" class="btn btn-info" role="button" style="margin-top: 10px; margin-bottom: 10px;">Click Here</a>
                        </center>
                    </div>
                    <div class="col-sm-3" style="border-width:5px; border-style:groove;">
                        <center>
                            <h4>Request for Hadoop Cluster</h4>
                            <a href="hadoop_request.php" class="btn btn-info" role="button" style="margin-top: 10px; margin-bottom: 10px;">Click Here</a>
                        </center>
                    </div>
                    <div class="col-sm-3" style="border-width:5px; border-style:groove;">
                        <center>
                            <h4>Request for VM</h4>
                            <a href="VMrequest.php" class="btn btn-info" role="button" style="margin-top: 10px; margin-bottom: 10px;">Click Here</a>
                        </center>
                    </div>
                    <div class="col-sm-3" style="border-width:5px; border-style:groove;">
                        <center>
                            <h4>Request for Hadoop Cluster</h4>
                            <a href="hadoop_request.php" class="btn btn-info" role="button" style="margin-top: 10px; margin-bottom: 10px;">Click Here</a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

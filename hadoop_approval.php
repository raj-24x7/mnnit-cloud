<?php 
  session_start();
  
    require_once 'checksession.php' ;
    require_once 'db_connect.php';
    require_once 'header.php';
     

    if($_SESSION['privilege']!='A'){
        header("location:VMdetails.php");
    }    
    
    if( isset($_GET['hadoop_name']) && (!empty($_GET['hadoop_name'])) )
    {
        $query='SELECT hadoop_name,number_slave,username,cpu,ram,storage,doe FROM hadoop WHERE hadoop_name = :hadoop_name';
        $param = array(
                ":hadoop_name"=>$_GET['hadoop_name']
            );
        $db = getDBConnection();
        $stmt = PrepareQuery($db,$query);
        ExecuteQuery($stmt,$param);
        
        if($row = $stmt->fetch()){
              $hadoop_name = $row['hadoop_name'];
              $number_slave=$row['number_slave'];  
              $username = $row['username'];
              $cpu = $row['cpu'];
              $ram = $row['ram'];
              $storage = $row['storage'];
              $doe = $row['doe'];

        }
        $query = "SELECT description FROM name_description WHERE name=:hadoop_name";
        $stmt = prepareQuery($db,$query);
        executeQuery($stmt,$param);
        $row = $stmt->fetch();
        $description = $row['description'];
     }
    
    
    ?>
<link rel="stylesheet" href="includes/css/jquery-ui.css">
<script src="includes/js/jquery.min.js"></script>
<script src="includes/js/jquery-ui.min.js"></script>

<script>
    function isValidDate(date)
    {
        var matches = /^(\d{1,2})[-\/](\d{1,2})[-\/](\d{4})$/.exec(date);
        if (matches == null) return false;
        var d = matches[2];
        var m = matches[1] - 1;
        var y = matches[3];
        var composedDate = new Date(y, m, d);
        return composedDate.getDate() == d &&
                composedDate.getMonth() == m &&
                composedDate.getFullYear() == y;
    }

     function validateForm(){
        //var name = document.forms["request"]["hadoop_name"].value;
        var date = document.forms["request"]["doe"].value;
        
        //var val = document.getElementById("res");
        //alert("wait:"+name+"res:"+val.innerHTML);
        //checkVMNameValidity();
        /*if(name=="" || val.innerHTML!="Valid"){
            alert("Hadoop name should be unique and should not contain special characters or spaces");
            return false;
        }*/

        alert("hello");
        if(!isValidDate(date)){
            alert("Date Format is : mm/dd/yyyy");
            return false;
        }
        var x = date.split("/");
        var newdate = ""+x[2]+"-"+x[0]+"-"+x[1]+"";
        document.forms["request"]["doe"].value = newdate;
        alert(""+newdate);
        return true;
    }


    function checkVMNameValidity(){ //
       if(window.XMLHttpRequest){
          xmlHttp = new XMLHttpRequest();
       } else {
          xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
       }
    
       xmlHttp.onreadystatechange = function() {
          if(xmlHttp.readyState==4 && xmlHttp.status==200){
             document.getElementById('res').innerHTML = xmlHttp.response;
          }
       }
       var hadoop_name = document.getElementById('hadoop_name').value;
       //alert('hello : '+VM_name+'');
       xmlHttp.open('GET','check_hadoopname_validity.php'+'?hadoop_name='+hadoop_name+'&t='+Math.random(),true);
       xmlHttp.send();
        }
    $(document).ready(function() {
        $("#datepicker").datepicker();
    });

    window.onload = function(){
        //alert('hello');
        var date = document.forms["request"]["doe"].value;
        //alert(date);
        var arr = date.split('-');
        //alert('hi/');
        var newdate = arr[1]+'/'+arr[2]+'/'+arr[0];
        //alert(''+newdate);
        document.forms["request"]["doe"].value = newdate;
    }
  </script>
<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-2">
        <?php include 'navigation_bar.php'; ?>
    </div>
    <div class="col-sm-8">
        <br>
        <div class="row" id="features">
            <div class="col-sm-2">
            </div>
            <div class="col-sm-8 text-left">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Requirements given by user : <?php echo $username; ?> </h3>
                    </div>
                    
                        <form name="request" class="form-horizontal" role="form"  action="create_hadoop.php" method='POST' onsubmit="return validateForm();">
                            <div class="form-group">
                                <label class="control-label col-sm-3">Username:</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="username" placeholder="Username" name="username" value=<?php echo '"'.$username.'"'; ?> readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="pwd">Hadoop Name:</label>
                                <div class="col-sm-7" >
                                    <input type="text" class="form-control" id="hadoop_name" name="hadoop_name" value=<?php echo '"'.$hadoop_name.'"'; ?> >
                                </div>
                                <div class="col-sm-2" id="res"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="description">Description:</label>
                                <div class="col-sm-7">
                                    <textarea class="form-control" name="description" id="description"><?php echo $description;?></textarea>
                                </div>
                            </div>
                                 <div class="form-group">
                                <label class="control-label col-sm-3">Number of Slaves:</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" id="number_slave" name="number_slave" value=<?php echo '"'.$number_slave.'"'; ?> >
                                </div>
                            </div>      
                            
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="pwd">CPU:</label>
                                <div class="col-sm-7">
                                    <select class="form-control" name="cpu" id="cpu" value=<?php echo '"'.$cpu.'"'; ?> >
                                        <option value="1">1</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="pwd">Storage:</label>
                                <div class="col-sm-7">
                                    <select class="form-control" name="storage" id="storage" value=<?php echo '"'.$storage.'"'; ?> >
                                        <option value="10">10GB</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="pwd">RAM:</label>
                                <div class="col-sm-7">
                                    <select class="form-control" name="ram" id="ram" value=<?php echo '"'.$ram.'"'; ?> >
                                        <option value="256">256MB</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Date of Expiry:</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="datepicker" placeholder="mm/dd/yyyy" name="doe" value=<?php echo '"'.$doe.'"'; ?> >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="pwd">Hypervisor:</label>
                                <div class="col-sm-7">
                                    <select class="form-control" name="hypervisor" id="hypervisor" >
                                    <?php
                                                                
                                    $query= "SELECT * FROM hypervisor";
                                    $stmt = PrepareQuery($db,$query);
                                    executeQuery($stmt,array());
                                    while($row = $stmt->fetch()){
                                        echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    
                                    <input type="submit" class="btn btn-danger btn-sm form-horizontal-sm pull-right" name="button" value="Reject" style="margin: 0 15px 15px 0;">

                                    <input type="submit" class="btn btn-info btn-sm form-horizontal-sm pull-right" name="button" value="Approve" style="margin: 0 15px 15px 0;">
                                </div>
                            </div>
                        </form>
                    
                </div>
            </div>
            <div class="col-sm-2">
            </div>
        </div>
    </div>
</div>
<div class="col-sm-1"></div>
<br>


<?php require_once('footer.php');?>

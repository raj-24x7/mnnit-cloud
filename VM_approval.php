<?php 
  session_start();
    
    require_once 'checksession.php' ;
    require_once 'db_connect.php';
    require_once 'header.php';
     

    if($_SESSION['privilege']!='A'){
        header("location:VMdetails.php");
    }    
    
    if( isset($_GET['VM_name']) && (!empty($_GET['VM_name'])) )
    {
        $query='SELECT VM_name,username,os,cpu,ram,storage,doe FROM VMrequest WHERE VM_name = :vm_name';
        $param = array(
                ":vm_name"=>$_GET['VM_name']
            );
        $db = getDBConnection();
        $stmt = PrepareQuery($db,$query);
        if(!executeQuery($stmt,$param)){
            header("location:error.php?error=1101");
        }
        
        if($row = $stmt->fetch()){
              $VM_name = $row['VM_name'];
              $username = $row['username'];
              $os = $row['os'];
              $cpu = $row['cpu'];
              $ram = $row['ram'];
              $storage = $row['storage'];
              $doe = $row['doe'];

        }
        $query = "SELECT description FROM name_description WHERE name=:vm_name";
        $stmt = prepareQuery($db,$query);
        if(!executeQuery($stmt,$param)){
            header("location:error.php?error=1102");
        }
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
        
        var name = document.forms["request"]["VM_name"].value;
        var date = document.forms["request"]["doe"].value;
        
        //var val = document.getElementById("res");
        //alert("wait:"+name+"res:"+val.innerHTML);
        if(name==""){
            alert("VM name should be unique and should not contain special characters or spaces");
            return false;
        }
        if(!isValidDate(date)){
            alert("Date Format is : mm/dd/yyyy");
            return false;
        }
        var x = date.split("/");
        var newdate = ""+x[2]+"-"+x[0]+"-"+x[1]+"";
        document.forms["request"]["doe"].value = newdate;
        //alert(""+newdate);
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
       var VM_name = document.getElementById('VM_name').value;
       //alert('hello : '+VM_name+'');
       xmlHttp.open('GET','check_VMname_validity.php'+'?VM_name='+VM_name+'&t='+Math.random(),true);
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
                    
                        <form name="request" class="form-horizontal" role="form"  action="create_vm.php" method='POST' onsubmit="return validateForm();">
                            <div class="form-group">
                                <label class="control-label col-sm-3">Username:</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="username" name="username" value=<?php echo '"'.$username.'"'; ?> readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="pwd">VM Name:</label>
                                <div class="col-sm-7" >
                                    <input type="text" class="form-control" id="VM_name" name="VM_name" value=<?php echo '"'.$VM_name.'"'; ?> >
                                </div>
                                <div class="col-sm-2" id="res"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="description">Description:</label>
                                <div class="col-sm-7">
                                    <textarea class="form-control" name="description" id="description"><?php echo $description;?></textarea>
                                </div>
                            </div>
                            
                            <div class="form-group" id="main_form">
                                <label class="control-label col-sm-3" for="os">OS:</label>
                                <div class="col-sm-7">
                                    <select class="form-control" name="os" id="os" >
                                        <?php
                                            $sql = "SELECT * FROM `template`";
                                            $stmt = prepareQuery($db,$sql);
                                            executeQuery($stmt,array());
                                            while($row = $stmt->fetch()){
                                                echo '<option value="'.$row['name'].'"';
                                                if($os == $row['name']){
                                                    echo ' selected="selected"';
                                                }
                                                echo '>'.$row['name'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="pwd">CPU:</label>
                                <div class="col-sm-7">
                                    <input class="form-control" type="integer" name="cpu" id="cpu" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="pwd">Storage:</label>
                                <div class="col-sm-7">
                                    <select class="form-control" name="storage" id="storage" value=<?php echo '"'.$storage.'"'; ?> >
                                        <option value="10">10GB</option>
                                        <option value="15">15GB</option>
                                        <option value="50">50GB</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="pwd">RAM:</label>
                                <div class="col-sm-7">
                                    <select class="form-control" name="ram" id="ram" value=<?php echo '"'.$ram.'"'; ?> >
                                        <option value="256">256MB</option>
                                        <option value="512">512MB</option>
                                        <option value="1024">1024MB</option>
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
                <br>
      <h4 style="color:red;">Note</h4>
      <ul class="list-group list">
        <li class="list-group-item list-group-item-info">
          <span class="glyphicon glyphicon-pencil"></span> Please check the memory availability before creating VM. VM would be created but not start if low on memory.</li>
      </ul>
            </div>
       
            <div class="col-sm-2">
            </div>
        </div>
    </div>

</div>
<div class="col-sm-1"></div>
<br>
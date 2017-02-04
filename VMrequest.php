

<?php 
    require_once 'header.php';
    require_once 'checksession.php';
    require_once 'db_connect.php';
    ?>

<link rel="stylesheet" href="includes/css/jquery-ui.css">
<script src="includes/js/jquery.min.js"></script>
<script src="includes/js/jquery-ui.min.js"></script>

<script type="text/javascript">
  window.onload = function (){
    document.getElementById("VMrequest").className = "active";
  }
</script>
<script type="text/javascript">
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
        var date = document.forms["request"]["date"].value;
        
        var val = document.getElementById("res");
        //alert("wait:"+name+"res:"+val.innerHTML);
        if(name=="" || val.innerHTML!="Valid"){
            alert("VM name should be unique and should not contain special characters or spaces");
            return false;
        }
        if(!isValidDate(date)){
            alert("Date Format is : mm/dd/yyyy");
            return false;
        }
        var x = date.split("/");
        var newdate = ""+x[2]+"-"+x[0]+"-"+x[1]+"";
        document.forms["request"]["date"].value = newdate;
        //alert(""+newdate);
        return true;
    }

    function checkVMNameValidity(){
       if(window.XMLHttpRequest){
          xmlHttp = new XMLHttpRequest();
       } else {
          xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
       }
    
       xmlHttp.onreadystatechange = function() {
          if(xmlHttp.readyState==4 && xmlHttp.status==200){
            if(xmlHttp.response=='Valid'){
                document.getElementById('vmvalid').className="form-group has-success";
            }else{
                document.getElementById('vmvalid').className="form-group has-error";
            }
             document.getElementById('res').innerHTML = xmlHttp.response;
          }
       }
       var VM_name = document.getElementById('VM_name').value;
       //alert('hello : '+VM_name+'');
       xmlHttp.open('GET','check_VMname_validity.php'+'?VM_name='+VM_name+'&t='+Math.random(),true);
       xmlHttp.send();
    }
</script>
<script>
  $(document).ready(function() {
    $("#calendar").datepicker();
  });
  </script>
<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-2">
        <?php include 'navigation_bar.php'; ?>
    </div>
    <div class="col-sm-8">
        <br><br><br><br><br><br><br>
        <div class="row" id="features">
            <div class="col-sm-2">
            </div>
            <div class="col-sm-8 text-left">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Enter your Requirement:</h3>
                    </div>
                    
                        <form name="request" class="form-horizontal" role="form"  action="request_entry.php" method='POST' onsubmit="return validateForm();">
                            <div class="form-group" id="vmvalid">
                                <label class="control-label col-sm-3" for="pwd">VM Name:</label>
                                <div class="col-sm-7" >
                                    <input type="text" class="form-control" name="VM_name" id="VM_name" onchange="checkVMNameValidity();">
                                </div>
                                <div class="col-sm-2" id="res"></div>
                            </div>
                            <div class="form-group" id="main_form">
                                <label class="control-label col-sm-3" for="email">OS:</label>
                                <div class="col-sm-7">
                                    <select class="form-control" name="os" id="os" onChange="">
                                        <?php
                                            $db = getDBConnection();
                                            $sql = "SELECT * FROM `template`";
                                            $stmt = prepareQuery($db,$sql);
                                            executeQuery($stmt,array());
                                            while($row = $stmt->fetch()){
                                                echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="pwd">CPU:</label>
                                <div class="col-sm-7">
                                    <select class="form-control" name="cpu" id="cpu" onChange="">
                                        <option value="1">1</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="pwd">Storage:</label>
                                <div class="col-sm-7">
                                    <select class="form-control" name="storage" id="storage">
                                        <option value="10GB">10GB</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="pwd">RAM:</label>
                                <div class="col-sm-7">
                                    <select class="form-control" name="ram" id="ram">
                                        <option value="256MB">256MB</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Date of Expiry:</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="calendar" placeholder="mm/dd/yyyy" name="date"/>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="submit" class="btn btn-info btn-sm form-horizontal-sm pull-right" value="Submit" style="margin: 0 15px 15px 0;">
                                </div>
                            </div>
                        </form>
                    
                </div>
            </div>
            <div class="col-sm-2">
            </div>
        </div>
    </div>
    <div class="col-sm-1"></div>
</div>
<br><br><br>
</body>
</html>


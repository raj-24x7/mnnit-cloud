<?php 

  session_start();
  
  require 'checksession.php';
  require 'header.php';
  require 'db_connect.php';

  function getMemoryString($data){
    $size = array("Bytes", "KiB", "MiB", "GiB", "TiB");
    $div = 1;
    $i = 0;
    while($data/$div >= 1024){
      $div = $div*1024;
      $i = $i + 1;
    }
    return round((float)$data/$div, 3)." ".$size[$i];
  }
?>

<script type="text/javascript">
  window.onload = function (){
    document.getElementById("storage").className = "active";
  }
</script>
            <?php 
                  

                $db = getDBConnection();
                
                  $free=0;
                  $total=0;
                  $used=0;
                
                    $query = " 
                        SELECT alloted_space,used_space FROM `user_storage` WHERE `username`=:username"; 
                    $param = array(":username"=>$_SESSION['username']);
                

                $stmt = prepareQuery($db,$query);
                executeQuery($stmt,$param);
                if($row=$stmt->fetch()){
                    $total=$row["alloted_space"];
                    $used=$row["used_space"];
                    $free = $total - $used;
                }
                
                /*
                $totalG=(int)($total/(1024*1024*1024));
                $usedG=(int)($used/(1024*1024*1024));
                $freeG=$totalG-$usedG;
                $total= $total%(1024*1024*1024);
                $used=$used%(1024*1024*1024);

                 $totalM=(int)($total/(1024*1024));
                $usedM=(int)($used/(1024*1024));
                 $freeM=$totalM-$usedM;

                $total= $total%(1024*1024);
                $used=$used%(1024*1024);

                $totalK=(int)($total/(1024));
                $usedK=(int)($used/(1024));
                 $freeK=$totalK-$usedK;


                $total= $total%(1024);
                $used=$used%(1024);

                 $totalB=$total;
                $usedB=$used;
                 $freeB=$totalB-$usedB;*/


               ?>
<div class="row">
  
    <div class="col-sm-3">
      <?php include 'navigation_bar.php'; ?>
    </div>

    <div class="col-sm-8">
    <br>
    
<h2>Allocated Storage </h2> <br>
  
<table class="table">
<thead class="thead-inverse">
<tr>
  <th>
  <div class="col-sm-2" float="left">
  
    <h4> Total </h4> 
    <th>
      <?php  echo getMemoryString($total); ?>
    </th>

  </div>
  </th>
  </tr>
<tr>
  <th>
  <div class="col-sm-2" float="left">
  
    <h4> Free </h4> 
    <th>
      <?php   echo getMemoryString($free); ?>
    </th>

  </div>
  </th>
</tr>
<tr>
  <th>
  <div class="col-sm-2" float="left">
  
    <h4> Used </h4> 
    <th>
      <?php  echo getMemoryString($used); ?>
    </th>

  </div>
 </th>
</tr>
</table>



<br>
    <h2>Extend Storage</h2><br>
    <form action="VMrequest.php" method="GET" name="extend_storage">

    <div class="form-group">
      
    </div>

    <div class="form-group">
        <label class="control-label col-sm-3" for="description">Description:</label>
        <div class="col-sm-7">
            <textarea class="form-control" name="description" id="description"></textarea>
        </div>
    </div>
      <table class="table">
          <thead class="thead-inverse">
            <tr>
                <th>Enter Amount</th>
                <th>
                    <div class="col-sm-3">
                                   <input type="number"  min="0" max="99" value="0" name="GB" id="GB" style="width:70px;">
                                </div>
                               
                </th>
                <th> GB</th>
                <th>
                    <div class="col-sm-3">
                                   <input type="number" name="quantity" min="0" max="1024"value="0" name="MB" id="MB" style="width:70px;">
                                </div>
                                
                </th>
                <th> MB</th>
                <th>
                    <div class="col-sm-3">
                                    <input type="number" name="quantity" min="0" max="1024" value="0"  name="KB" id="KB"style="width:70px;">
                                </div>

                </th>
                 <th> KB</th>
                <th>
                    <div class="col-sm-3">
                                    <input type="number" name="quantity" min="0" max="1024" value="0" name="Bytes" id="Bytes" style="width:70px;">
                                </div>
                                
                </th>
                 <th> Bytes</th>
                
                 <th> 
                  <P><INPUT TYPE="SUBMIT" VALUE="Submit" name="submit" id="suubmit"></P>
                 </th>
            </tr>
          </thead>
      
         
      </table>
      </form>
    </div>

    
</div>




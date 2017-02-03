
<div class="container">
  

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog" style="z-index: 10000">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Login</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal-sm" role="form" action="login_process.php" method="POST" >
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


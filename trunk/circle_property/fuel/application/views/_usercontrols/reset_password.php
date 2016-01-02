<center>
    
    <div id="reset_password" class="modal-dialog modal-sm popup">
<div class="modal-header">
    <button type="button" class="reset_close close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <img  class="logo" alt="" src="<?php echo $Logo?>"/>
  </div>
  <div class="modal-body">
    <input type="text" id="reset_login" class="form-control" placeholder="Please insert existing password"/><br/>
   
    <div id="Forgot_Password_Message">
       
    </div>
  </div>
  <div class="modal-footer">
    <center>
        
        <button class="reset_close btn">Close</button>
        <button id="reset_retrieve" class="btn btn-primary">Retrieve</button><br/><br/>
    </center>
  </div>
</div></center>
<script type="text/javascript">
    <?=$script?>
</script>

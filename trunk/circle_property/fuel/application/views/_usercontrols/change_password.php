
<center>
    
    <div id="reset_password" class="modal-dialog modal-sm popup">
<div class="modal-header">
    <button type="button" class="reset_close close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <img  class="logo" alt="" src="<?php echo $Logo?>"/>
  </div>
  <div class="modal-body">
    <input type="password" id="crt_password" class="form-control" placeholder="<?php echo $old_pass?>"/><br/>
    <input type="password" id="chg_password" class="form-control" placeholder="<?php echo $new_pass?>"/><br/>
    <input type="password" id="chg_confirmedPassword" class="form-control" placeholder="<?php echo $confirm_pass?>"/><br/>
   
    <div id="Change_Password_Message">
        
    </div>
  </div>
  <div class="modal-footer">
    <center>
        
        <button class="change_close btn">Close</button>
        <button id="chg_pass_submit" class="btn btn-primary">Submit</button><br/><br/>
    </center>
  </div>
</div></center>
<script type="text/javascript">
    <?=$script?>
</script>


<center>
    
    <div id="login" class="modal-dialog modal-sm popup">
<div class="modal-header">
    <button type="button" class="login_cancel close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <img class="logo" alt="" src="<?php echo $Logo?>"/>
  </div>
  <div class="modal-body">
    <input type="text" id="Username" class="form-control" placeholder="<?php echo $Username?>"/><br/>
    <input type="password" id="Password" class="form-control" placeholder="<?php echo $Password?>"/><br/>
    <div id="login_captcha">
        <?php
            if(isset($Captcha))
            {
                echo $Captcha;
            }
        ?>
    </div>
    <div id="Message">
        
    </div>
  </div>
  <div class="modal-footer">
    <center>
        <button class="login_cancel btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button id="login_sign_in" class="btn btn-primary">Sign In</button><br/><br/>
        <button id="login_sign_up" class="btn btn-warning">Create Account</button><br/><br/>
        <a id="login_forgotten_pwd" href="#">Forget your password?</a>
    </center>
  </div>
</div></center>
<script type="text/javascript">
    <?=$script?>
</script>
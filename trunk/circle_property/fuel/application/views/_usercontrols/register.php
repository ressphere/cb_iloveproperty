
<center>
    
    <div id="register" class="modal-dialog modal-sm popup">
        
<div class="modal-header">
    <button type="button" class="register_cancel close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <img class="logo" alt="" src="<?php echo $Logo?>"/>
  </div>
  <div class="modal-body">
    <div class="input-group">
     <input type="text" id="register_display_name" class="form-control" placeholder="<?php echo $Displayname?>"/>
     <span class="register_display_name-feedback input-group-addon glyphicon glyphicon-asterisk"></span>
        
    </div>
    <br/>
    <div class="input-group">
     <input type="text" id="register_username" class="form-control" placeholder="<?php echo $Username?>"/>
     <span class="register_username-feedback input-group-addon glyphicon glyphicon-asterisk"></span>
        
    </div>
    <br/>
    <div class="input-group">
        <input type="password" id="register_password" class="form-control" placeholder="<?php echo $Password?>">
        <span class="register_password-feedback input-group-addon glyphicon glyphicon-asterisk"></span>
        
    </div>
    <span class="error password_help-block"></span>
    <br/>
    <div class="input-group">
        <input type="password" id="register_confirmed_password" class="form-control" placeholder="<?php echo $RePassword?>">
        <span class="register_confirmed_password-feedback input-group-addon glyphicon glyphicon-asterisk"></span>
    </div>
    
    <span class="error repeatable_help-block"></span>
    <br>
    <div class="select-div" style="width:230px;float: none">
        <select class="form-control" id="register_country" style="width:280px">
        
        <?php
            foreach ($Countries as $val)
            {
                $val = strtoupper($val);
                $Selected = strtoupper($Selected);
                if($val == $Selected)
                {
                    echo "\t<option selected value=\"".$val."\">".$val."</option>\n";
                }
                else
                {
                    echo "\t<option value=\"".$val."\">".$val."</option>\n";
                }
            }
            
        ?>
        
        </select>
    </div>
    <br/>
    
    <div  id="phonegroup" class="input-group">
        <span class="register_phone_areacode-feedback input-group-addon">
            <div  id="scrollable-dropdown-menu">
                <input type="text" id="register_area_code" class="input-small typeahead form-control" placeholder="Area Code"/>
            </div>
            
        </span>
        <span class="register_phone-extension-label input-group-addon glyphicon glyphicon-minus"></span>
        <input type="text" id="register_phone" style="background-color: white; border-color: white" class="form-control numericOnly" placeholder="Phone Number"/>
        <span class="register_phone-feedback input-group-addon glyphicon glyphicon-asterisk"></span>
    </div><br/>
    <center>

        <div class="g-recaptcha" data-sitekey="6LfyyG0UAAAAAD8RC2kWvimr9yr50squ4wTB6Qg0"></div>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>

	</center><br>
  
    <input id ="register_term_condition" type="checkbox" value="Term_Condition"> I have read and agree with the <a href="<?=$terms_conditions?>" target="_blank"><em>Terms & Conditions</em></a></input> 
    <div id="register_message"></div>
  </div>
  <div class="modal-footer">
    <center>
        <button class="register_cancel btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button id="register_sign_in" class="btn btn-primary">Register</button><br/><br/>
    </center>
  </div>
  
</div>
    
</center>
<script type="text/javascript">
    <?=$script?>
     var areaCodes = [
          <?php
                if(!is_null($Area_Code) && array_count_values($Area_Code) > 0)
                {
                    foreach ($Area_Code as $code)
                    {
                        echo "\t\"".$code . "\",\n";
                    }
                }               
            ?>
          ];
     var areaCodes = new Bloodhound({
         datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
         queryTokenizer: Bloodhound.tokenizers.whitespace,
         local: $.map(areaCodes, function(areacode){return {value: areacode};})
     });
     areaCodes.initialize();
          $("#scrollable-dropdown-menu .typeahead").typeahead(
            {
                hint:true,
                highlight: true,
                minLength: 1
            }
            ,
            {
                name: 'areaCodes',
                displayKey: 'value',
                source:  areaCodes.ttAdapter()//substringMatcher(areaCodes)
            }
        );
</script>
<div id="contact" class="unfixed_content container-fluid">
        
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Contact Us</h2>
                    <h3 class="section-subheading text-muted"></h3>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-md-12 column">
        <form id="ressphere_contact_form" class="form-horizontal" action="<?php echo $post_link?>" method="post">
            <div class="row clearfix">
                
            <?php
                $i = 0;
                $is_first_input = TRUE;
                echo '  <div class="col-md-6">';
                foreach ($contact_list as $contacts)
                {
                    $label = $contacts[0];
                    $placeholder = $contacts[1];
                    $input_type = $contacts[2];
                    echo '<div class="form-group">';
                    //echo '<label for="contact_us_input_'.$i.'" class="col-sm-2 control-label">'.$label.'</label>';
                    
                    if ($input_type !== 'textarea')
                    {
                        echo '<input id = "contact_user_info_'.$i.'" type="'.$input_type.'" class="form-control" value="" id="contact_us_input_'.$i.'" placeholder="'.$placeholder.'"/><br/>';
                    }
                    
                    echo '</div>';
                    $i++;
                }
                echo '  </div>';
                $message_id =  count($contact_list) - 1;
                echo '  <div class="col-md-6">';
                    echo '<textarea id="contact_us_msg" maxlength="300" id="contact_us_input_'.$message_id.'"rows="14" class="contact_us_textarea" value="" class="form-control" placeholder="'. $contact_list[$message_id][1] . '"></textarea>';
                echo '</div>';
          ?>
            </div><br>
           <div class="row clearfix">
          <div class="form-group">
            <div class="col-md-12">  
                <center><div id="contact_us_send">Send Message</div></center>
            </div>
          </div>
           </div>
        </form>
   </div>
            </div>
</div><br><br><br>
   

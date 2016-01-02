<div id="about" class="unfixed_content row clearfix container-fluid">
       
       <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">About Us</h2>
                    <h3 class="section-subheading text-muted"></h3>
                </div>
            </div>
       <div class="row">
                <div class="col-md-12 column">
                    <?php

                        foreach ($news as $new) {
                            if(strcmp($new[0], 'video') == 0)
                            {
                                echo '<iframe  class="about_us" src="' . $new[1] . '" style="height:100%" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
                            }
                            elseif(strcmp($new[0], 'image') == 0) 
                            {
                                echo '<img  class="about_us" src="'.$new[1].'" style="height:100%" />';
                            }
                            else
                            {
                                echo '<div class="about_us" style="height:100%" >'.$new[1].'</div>';
                            }
                        }
                    ?>
                </div>
            </div>
</div>


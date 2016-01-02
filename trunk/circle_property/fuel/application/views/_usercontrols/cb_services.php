<div id="services" class="unfixed_content row clearfix container-fluid">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Services</h2>
                <h3 class="section-subheading text-muted">Our services</h3>
            </div>
        </div>
        <div class="row text-center">
        <?php 
            foreach ($feature_list as $details)
            {
                if(strpos($details[2], "http://") !== false)
                {
                    echo '<div class="icon col-xs-4 col-sm-4 col-md-4">';
                    echo '<a href="' . $details[2] . '"><img src="'.$details[1].'" alt="'.$details[0].'"></a>';
                    echo '<h4 class="service-heading">'.$details[0].'</h4>';
                    echo '</div>';
                }
                else
                {
                   echo '<div class="icon col-xs-4 col-sm-4 col-md-4">';
                   echo '<img src="'.$details[1].'" alt="'.$details[0].'">';
                   echo '<h4 class="service-heading">'.$details[0].'</h4>';
                   echo '</div>';
                }
            }
         ?>



        </div>
</div>


        
    
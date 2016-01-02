<div id="ads" class="unfixed_content content row clearfix">
    <div class="col-md-12 column">
        <ul id="slider_ads">
          <?php
            foreach ($news as $new) {
                echo '<li>';
                if(strcmp($new[0], 'video') == 0)
                {
                    echo '<iframe src="' . $new[1] . '" style="height:100%" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
                }
                elseif(strcmp($new[0], 'image') == 0) 
                {
                    echo '<img src="'.$new[1].'" style="height:100%" />';
                }
                else
                {
                    echo '<div style="height:100%" >'.$new[1].'</div>';
                }
                echo '</li>';
            }
          ?>
        </ul>
    </div>
</div>
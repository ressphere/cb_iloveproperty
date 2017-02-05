<div class="aroundyou_footer row clearfix">

    <div id="" class="col-md-offset-4  col-md-4 column">
        <center><?=$copyright?></center>
    </div>

    <div id="" class="aroundyou_footer_link col-md-4 column">
        <center><ul>
        <?php
            
            foreach ($footer_link as $menu => $link) {
                if($menu === "Sitemap") {
                    echo "<li class=\"hide\">";
                }
                else
                { 
                    echo "<li>";
                }
                
                echo '<span class="divider">|</span>&nbsp;&nbsp;&nbsp;<a href="'.$link.'" target="_self">'.$menu.'</a>&nbsp;&nbsp;&nbsp;';
                echo "</li>";
                
            }
            echo "<li>";
            echo '<span class="divider">|</span>';
            echo "</li>";
        ?>

        </ul></center>
    </div>
</div>
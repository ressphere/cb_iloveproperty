<div class="col-md-4 column">
    
</div>
<div id="copyright" class="col-md-4 column">
    <center><?php echo $copyright?></center>
</div>
<div id="footer_link" class="col-md-4 column">
    <center><ul>
    <?php
                foreach ($menus as $menu => $link) {
                    echo "<li>";
                    echo '<span class="divider">|</span>&nbsp;&nbsp;&nbsp;<a target="_self" href="'.$link.'">'.$menu.'</a>&nbsp;&nbsp;&nbsp;';
                    echo "</li>";
                }
                echo '<span class="divider">|</span>'
    ?>
    
    </ul></center>
</div>

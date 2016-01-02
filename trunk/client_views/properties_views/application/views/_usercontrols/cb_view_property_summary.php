<div class="cb_view_property_listing_list_display">
    <p> Serach count is <?php echo $search_count ?> </p> 
    <?php if($list_of_properties !== NULL): // To skip property display if no data recieved?>
        <div class='list-group'>
            <?php foreach ($list_of_properties as $property_info):  // Loop through all data in array and display?>
                <div class="list-group-item ">
                   <h4 class="list-group-item-heading">
                        <a href="<?php if(array_key_exists('detail_link', $property_info)){echo $property_info['detail_link'];}else{echo "Page Not Found";} ?>">
                            <?php if(array_key_exists('Name', $property_info)){echo $property_info['Name'];}else{echo "Please Contact Agent or Admin";}  ?>
                        </a>
                    </h4>
                    <div class="list-group-item row">
                        <div class="col-sm-4 col-md-3 cb_view_property_img_customize">
                            <a href="<?php if(array_key_exists('detail_link', $property_info)){echo $property_info['detail_link'];}else{echo "Page Not Found";} ?>">
                                <img src="<?php if(array_key_exists('Property_info_image', $property_info)){echo $property_info["Property_info_image"];}else{echo "No Photo";} ?>" width="140" height="auto" alt="No Photo"/>
                            </a>
                        </div>
                        
                        <div class="col-sm-8 col-md-9">
                            <div class="cb_view_property_list_view_content_area">
                                <p>
                                    Price: RM <?php  if(array_key_exists('Price', $property_info)){echo $property_info["Price"];}else{echo "-- ";} ?><br>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
        <ul class="pagination">
            <?php 
                $max_page_display = 5; 
                $minus_num = 0; 
                $m_count = $page - $minus_num;
                while($m_count > 1)
                {
                    $minus_num = $minus_num + 1; 
                    $m_count = $page - $minus_num; 
                    if(($minus_num + 1) >= ($max_page_display/2))
                    {
                        break;
                    }
                }
            ?>
            <?php if($page > 1): // To manipulate left arrow?>
                <li><a href="<?php echo $searched_url ; echo"&page="; echo $page-1 ?>">&laquo;</a></li>
            <?php else:?>
                <li class="disabled"><span>&laquo;</span></li>
            <?php endif ?>
                
            <?php for($page_index = $page - $minus_num; $page_index < $max_page_display && $page_index <= $total_page ; $page_index = $page_index + 1): ?>
                <?php if($page == $page_index): ?>
                    <li class="active"><a href="<?php echo $searched_url ; echo"&page="; echo $page_index ?>"><?php echo $page_index?></a></li>
                <?php else: ?>
                     <li><a href="<?php echo $searched_url; echo"&page="; echo $page_index ?>"><?php echo $page_index?></a></li>
                <?php endif ?>
            <?php endfor ?>
                
            <?php if($page != $total_page): // To manipulate right arrow?>
                <li><a href="<?php echo $searched_url; echo"&page="; echo $page+1 ?>">&raquo;</a></li>
            <?php else:?>
                <li class="disabled"><span>&raquo;</span></li>
            <?php endif ?>
                
        </ul>
    <?php endif ?>
</div>
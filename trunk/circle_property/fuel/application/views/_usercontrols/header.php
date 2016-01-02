<div class="navbar-header">
    <!-- circle properties logo-->
    <button type="button" class="navbar-toggle" data-toggle="collapse" 
            data-target="#bs-example-navbar-collapse-1"> 
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button> <a class="navbar-brand" href="#page-top">
    <img class="header_logo"  alt="<?=$logo_desc?>" src="<?=$logo?>"></a>
    
</div>				
<div class="collapse navbar-collapse header_menu" id="bs-example-navbar-collapse-1">
	<ul class="nav navbar-nav">
            <?php
                foreach ($menus as $menu => $link) {
                    $pos = strpos($link, "#");
                    
                    if($pos === FALSE)
                    {
                        echo "<li>";
                        echo '<a href="'.$link.'">'.$menu.'</a>';
                        echo "</li>";
                    }
                    else
                    {
                        echo "<li>";
                        echo '<a class="page-scroll" href="'.$link.'">'.$menu.'</a>';
                        echo "</li>";
                    }
                    
                }  
            ?> 
      </ul>

	<ul class="nav navbar-nav navbar-right header_menu">
           
           <li>
                <div class="dropdown" id="after_login_menu">
                    <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" style="background-color: transparent">
                        <span class="glyphicon glyphicon-th-large"></span>
                        <img src ="<?php echo $user_image?>"/>
                        <span id="username"><?php echo $username?></span>
                    </button>
                
                    <ul class="dropdown-menu" role="menu">
                            <?php
                                foreach($services as $service)
                                {
                                    echo "<li>";
                                        echo '<a class="page-scroll" target="_self" href="'.$service[2].'">'.$service[0].'</a>';
                                    echo "</li>";
                                }
                            ?> 
                            <li role="presentation" class="divider"></li>
                            <li role="presentation">
                                    <a role="menuitem"
                                       tabindex="-1" id="my_profile" target="_self" href="<?php echo $myprofileurl?>">
                                        My Profile</a>
                            </li>
                            <li role="presentation">
                                    <button class="btn btn-danger" id="system_logout_btn"><a role="menuitem" 
                                           tabindex="-1" id="system_logout" style="color:white" 
                                           data-toggle="modal" data-target="#popup_logout" href="#">Logout</a>
                                    </button>
                            </li>
                            
                            
                    </ul>
                </div>
            </li>
            <li>
                <button class="btn" id="system_login_parent" data-toggle="modal" data-target="#popup" href="#"><a id="system_login" 
                   data-backdrop="static" data-keyboard="false">Sign In</a>
                </button>
                
            </li>
		
					</ul>
</div>
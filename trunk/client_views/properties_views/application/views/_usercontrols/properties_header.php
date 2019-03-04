<nav class="navbar navbar-default" role="navigation" style="border-bottom: transparent;">
    <div class="navbar-header" style="margin:7px;">
        <!-- circle properties logo-->
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="<?=base_url()?>" target="_self"><img width="133px" height="35px" class="header_logo"  alt="<?=$logo_desc?>" src="<?=$logo?>"></a>

    </div>

    <div class="collapse navbar-collapse header_menu" id="bs-example-navbar-collapse-1" style="padding-left: 0px; padding-right: 0px;">
        <div class="row col-md-12" style="margin-left: 0px; margin-right: 0px">
            <ul class="nav navbar-nav navbar-right header_menu">
                <li>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle header_all_product_btn" type="button" data-toggle="dropdown">
                            <img src="images/pluss.svg" alt="resshphereservice">
                            <P class="navbar-word" style="display:inline; padding-left:5px; letter-spacing: 1px;">All Products</P>
                        </button>
                        <ul class="dropdown-menu" style="padding:10px 10px">
                            <li><a href="#">Ressphere Property</a></li>
                            <li><a href="#">Ressphere AroundYou</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                   <div class="dropdown" id="after_login_menu" style="padding-right:10px">
                        <button class="btn btn-primary dropdown-toggle header_all_product_btn" type="button" data-toggle="dropdown" style="background-color: transparent">
                            <img src ="<?php echo $user_image?>"/>
                            <span id="username"><?php echo $username?></span>
                        </button>

                        <ul class="dropdown-menu" role="menu" style="padding:10px 10px">
                                <li role="presentation">
                                        <a role="menuitem" target="_self" tabindex="-1" id="add_new_listing" href="<?php echo $newlistingurl?>">New Listing</a>
                                </li>
                                <li role="presentation">
                                        <a role="menuitem" target="_self" tabindex="-1" id="view_listing" href="<?php echo $viewlistingurl?>">Find Listing</a>
                                </li>
                                <li role="presentation">
                                        <a role="menuitem" target="_self" tabindex="-1" id="my_profile" href="<?php echo $myprofileurl?>">My Profile</a>
                                </li>
                                <li role="presentation" class="system_logout_group">
                                        <a role="menuitem" 
                                               tabindex="-1" id="system_logout"
                                               data-toggle="modal">Logout</a>
                                </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <div class="dropdown" style="padding-right:15px;" id="system_login_key">
                        <button class="btn btn-primary dropdown-toggle header_all_product_btn" type="button" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#popup_login" href="#">
                           <img src="images/profile.svg"></img>
                           <P class="navbar-word" style="display:inline; padding-left:5px; letter-spacing: 0.5px; font-family:'Segoe UI' 'Helvetica' 'Neue Apple' 'Color Emoji' 'Segoe UI Emoji' 'Segoe UI Symbol';">Sign In</P>
                        </button>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="row col-md-12" id="property_header_nav_bar">
    <ul class="nav navbar-left header_menu" id="property_header_nav_menu" style="display: inline-flex; padding-left: inherit; padding-top: 10px;">
        <li><a class="state" id="buy" target = "_top">BUY</a></li>
        <li><a class="state" id="rent" target = "_top">RENT</a></li>
        <li><a class="state" id="sell" target = "_top">SELL</a></li>
        <li><a class="state" id="lease" target = "_top">LEASE</a></li>
        <!-- 
        temporary disable it until we support them.
        <li><a class="state_disable" id="launch" target = "_top">LAUNCH</a></li>
        <li><a class="state_disable" id="services" target = "_top">SERVICE</a></li>
        -->
    </ul>
</div>
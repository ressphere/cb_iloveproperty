<div>
    
    <div class="navbar-header" style="height:55px; padding: 5px 15px 5px 15px">
        <!-- circle properties logo-->
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="<?=base_url()?>" target="_self" style="padding: 0px 15px 0px 15px"><img width="133px" height="35px" class="header_logo"  alt="<?=$logo_desc?>" src="<?=$logo?>"></a>

    </div>

    <div class="collapse navbar-collapse header_menu" id="bs-example-navbar-collapse-1" style="padding-left: 0px; padding-right: 0px">
        <div class="row col-md-12" style="margin-left: 0px; margin-right: 0px">
            <ul class="nav navbar-nav navbar-right header_menu" style="margin-top: 3px; margin-bottom:3px;">
                <li>
                    <div class="btn currency_group">
                        <button class="btn btn-primary ng-scope" id="btn_currency">Currency</button>&nbsp;
                    </div>
                </li>
                <li>
                    <div class="btn measurement_type_group">
                        <button class="btn btn-primary ng-scope" id="btn_measurement_type">
                            Measurement (<span class="lbl_measurement_type"></span>)
                        </button>&nbsp;
                    </div>
                </li>
                <li>
                   <div class="dropdown" id="after_login_menu">
                        <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" style="background-color: transparent">
                            <span class="glyphicon glyphicon-th-large"></span>
                            <img src ="<?php echo $user_image?>"/>
                            <span id="username"><?php echo $username?></span>
                        </button>

                        <ul class="dropdown-menu" role="menu">
                                <li role="presentation">
                                        <a role="menuitem" target="_self" tabindex="-1" id="add_new_listing" href="<?php echo $newlistingurl?>">New Listing</a>
                                </li>
                                <li role="presentation">
                                        <a role="menuitem" target="_self" tabindex="-1" id="view_listing" href="<?php echo $viewlistingurl?>">Find Listing</a>
                                </li>
    <!--                            <li role="presentation">
                                        <a role="menuitem" target="_self" tabindex="-1" id="enquiries" href="#">Enquiries</a>
                                </li>-->
                                                            <li role="presentation" class="divider"></li>
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
                    <div class="btn">
                        <button class="btn" id="system_login_parent" data-toggle="modal" 
                           data-backdrop="static" data-keyboard="false" data-target="#popup_login" href="#"><a id="system_login">Sign In</a>
                        </button>
                    </div>
                </li>
            </ul>
        </div>
        <div class="row col-md-12" id="property_header_nav_bar" style="margin-left: 0px; margin-right: 0px">
            <ul class="nav navbar-nav navbar-right header_menu" id="property_header_nav_menu">
                    <li><a class="state" id="buy" target = "_top" style="padding: 10px 29px;">BUY</a></li>
                    <li><a class="state" id="rent" target = "_top" style="padding: 10px 29px;" >RENT</a></li>
                    <li><a class="state" id="sell" target = "_top" style="padding: 10px 29px;">SELL</a></li>
                    <li><a class="state" id="lease" target = "_top" style="padding: 10px 29px;">LEASE</a></li>
                    <!-- 
                    temporary disable it until we support them.
                    <li><a class="state_disable" id="launch" target = "_top">LAUNCH</a></li>
                    <li><a class="state_disable" id="services" target = "_top">SERVICE</a></li>
                    -->

            </ul>
        </div>
    </div>
</div>
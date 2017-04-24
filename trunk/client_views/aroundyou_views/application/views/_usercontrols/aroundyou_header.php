
<div ng-controller="aroundyou_header__ng__CONTROLLER">
    <div class="navbar-header col-sm-12" style="height:55px; padding: 5px 15px 5px 15px">

        <!-- circle properties logo-->
        <a class="navbar-brand" href="{{base_url}}" target="_self" style="padding: 0px 15px 0px 15px">
            <img width="133px" height="35px" class="header_logo"  alt="<?= $logo_desc ?>" src="<?= $logo ?>">
        </a>

        <ul class="nav cb_string_type" style="margin-top: 3px; margin-bottom:3px; float:right;">

            <!-- Display button for login user -->
            <li>
                <div class="dropdown" id="after_login_menu">
                    <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" style="background-color: transparent">
                        <span class="glyphicon glyphicon-th-large"></span>
                        <img src ="<?php echo $user_image ?>"/>
                        <span id="username"><?php echo $username ?></span>
                    </button>

                    <ul class="dropdown-menu" role="menu">
                        <li role="presentation">
                            <a role="menuitem" target="_self" tabindex="-1" id="my_profile" href="<?php echo $myprofileurl ?>">My Profile</a>
                        </li>
                        <li role="presentation" class="system_logout_group">
                            <a role="menuitem" 
                               tabindex="-1" id="system_logout"
                               data-toggle="modal">Logout</a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Display button when not login -->
            <li>
                <div class="btn">
                    <button class="btn" id="system_login_parent" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#popup" href="#">
                        <a id="system_login">Sign In</a>
                    </button>
                </div>
            </li>
        </ul>
    </div>
</div>

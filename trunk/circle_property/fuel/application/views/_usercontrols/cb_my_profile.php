
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>
            Ressphere - My Profile  </title>
  <base href="http://www.ressphere.com/" target="_blank">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="ressphere">
  <meta name="description" content="ressphere home search"/>
  <meta name="keywords" content="ressphere home search"/>
  <meta name="generator" content="ressphere home search"/>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta property="og:title" content="ressphere home search" />
  <meta property="og:image" content="http://www.ressphere.com/images/ressphere-white.png" />
  <meta property="og:description" content="ressphere home search" />
        <link type="text/css" rel="stylesheet" href="http://www.ressphere.com/css/bootstrap.min.css" /><link type="text/css" rel="stylesheet" href="http://www.ressphere.com/css/animate.min.css" /><link type="text/css" rel="stylesheet" href="http://www.ressphere.com/css/base.css" /><link type="text/css" rel="stylesheet" href="http://www.ressphere.com/css/home.css" /><link type="text/css" rel="stylesheet" href="http://www.ressphere.com/css/_sidebar/simple-sidebar.css" /><link type="text/css" rel="stylesheet" href="http://www.ressphere.com/css/cb_user_profile_update.css" /><link type="text/css" rel="stylesheet" href="http://www.ressphere.com/css/_scrolling_nav/scrolling-nav.css" /><link type="text/css" rel="stylesheet" href="http://www.ressphere.com/css/_switch-toggle/bootstrap-switch.css" /><link type="text/css" rel="stylesheet" href="http://www.ressphere.com/css/user_profile.css" />

  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="assets/images/favicon.ico">
</head>

<body data-spy="scroll" data-target=".navbar-fixed-top" data-offset="85">
    <div id="wrapper" class="wrapper">
	<div id="main_content" class="row clearfix">
		<div class="col-md-12 column">
			<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
                            <div class="container-fluid">
				<div class="navbar-header">
    <!-- circle properties logo-->
    <button type="button" class="navbar-toggle" data-toggle="collapse" 
            data-target="#bs-example-navbar-collapse-1"> 
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button> <a class="navbar-brand" href="http://www.ressphere.com/" target="_self">
    <img class="header_logo"  alt="" src="http://www.ressphere.com/images/ressphere-white.png"></a>
    
</div>				
<div class="collapse navbar-collapse header_menu" id="bs-example-navbar-collapse-1">
	<ul class="nav navbar-nav">
            <li><a class="page-scroll" href="#services">Services</a></li><li><a class="page-scroll" href="#about">About Us</a></li><li><a class="page-scroll" href="#contact">Contact Us</a></li> 
      </ul>

	<ul class="nav navbar-nav navbar-right header_menu">
           
           <li>
                <div class="dropdown" id="after_login_menu">
                    <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" style="background-color: transparent">
                        <span class="glyphicon glyphicon-th-large"></span>
                        <img src ="http://www.ressphere.com/images/user_profile.png"/>
                        <span id="username">test</span>
                    </button>
                
                    <ul class="dropdown-menu" role="menu">
                            <li><a class="page-scroll" target="_self" href="http://www.ressphere.com/">Home</a></li><li><a class="page-scroll" target="_self" href="http://www.ressphere.com/properties/">Properties</a></li><li class='disabled'><a class="page-scroll" target="_self" href="not ready">Around You</a></li><li class='disabled'><a class="page-scroll" target="_self" href="not ready">Coming Soon</a></li> 
                            <li role="presentation" class="divider"></li>
                            <li role="presentation">
                                    <a role="menuitem"
                                       tabindex="-1" id="my_profile" target="_self" href="http://www.ressphere.com/index.php/cb_user_profile_update/my_profile">
                                        My Profile</a>
                            </li>
                            <li role="presentation" class="system_logout_group">
                                    <a role="menuitem" tabindex="-1" id="system_logout" data-toggle="modal">Logout</a>
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
</div>                            </div>
			</nav>
			
		</div>
                
	</div>
        <div id="user_profile" class="unfixed_content content container" ng-app="ProfileApps" ng-controller="ProfileController">
	<!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li ng-repeat="service in services">
                    <a id="profile_sidebar_content" class="page-scroll" href="#{{service.id}}">{{service.name}}</a>
                </li>
            </ul>
        </div>
         <div  class="sidebar_toggle">
                 <button id ="menu-toggled" type="button" class="btn btn-default btn-xs">
                    <span class="glyphicon glyphicon-list"></span>
                 </button>
         </div>
                
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
             <section id="{{service.id}}" class="{{service.id}}-section section"  ng-repeat="service in services">
                <div class="container">
                    <div class="row">
                        <div class="section-content">
						    <div id="section_in_profile" class="row">
								<div>
									<h1>{{service.name}} <a class="btn btn-xs btn-success" role="button" ng-if='key_available_for_service_map_with_url(service.link_id)' target='_self' href ='{{service_map_with_url[service.link_id]}}' >Launch {{service.link_id}}</a></h1> 
								</div>
							</div>
                            <div class="row" ng-if="id == 'username'" ng-repeat="(id, info) in service">
                                <div id="username_in_profile" class="col-md-2">{{info}}</div>
                                <a class="col-md-8"> 
                                    <span id="change_pwd_req">
                                        <button id="chpass_in_profile">change your password</button>
                                    </span>
                                </a>
                            </div>
                            <div id="general_info_in_profile" class="row" ng-if="id != 'username' && id != 'password' && id != 'name' && id !='link_id' && id !='id' && id !='active' && id != 'information'" ng-repeat="(id, info) in service">
				<div class="col-md-2">{{id}}</div>
                                <div class="col-md-8">{{info}}</div>
                            </div><br/>
                            <div class="row" ng-if="id == 'information'" ng-repeat="(id, info) in service">
                                <div class="tabbable" id="tabs-123805">
                                    <ul class="nav nav-tabs">
                                        <li class="active" ng-if="detail.active == 'true'" ng-repeat='(detail_id, detail) in info'>
                                            <a href="#{{detail_id}}" data-toggle="tab">{{detail_id}}&nbsp;<span class="badge" ng-if="detail_id == 'listings'">{{listing_used}}/{{listing_limit}}</span></a>
                                        </li>
                                        <li ng-if="detail.active == 'false'" ng-repeat='(detail_id, detail) in info'>
                                            <a href="#{{detail_id}}" data-toggle="tab">{{detail_id}}&nbsp;<span class="badge" ng-if="detail_id == 'listings'">{{listing_used}}/{{listing_limit}}</span></a>
                                        </li>
                                    </ul>
                                    <div  class="tab-content">
                                        <div class="tab-pane" id="{{detail_id}}" ng-if="detail.active == 'false' && detail.url != ''" 
                                            ng-include="detail.url" ng-repeat='(detail_id, detail) in info'>
                                            
                                        </div>
                                        <div class="tab-pane" id="{{detail_id}}" ng-if="detail.active == 'false' && detail.url == ''" 
                                            ng-repeat='(detail_id, detail) in info'>
                                            
                                        </div>
                                        <div class="tab-pane active" id="{{detail_id}}" ng-if="detail.active == 'true' && detail.url == ''" 
                                             ng-repeat='(detail_id, detail) in info'>
                                            
                                        </div>
                                        <div class="tab-pane active" id="{{detail_id}}" ng-if="detail.active == 'true'" 
                                             ng-include="detail.url" ng-repeat='(detail_id, detail) in info'>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div><br/>
                            
                            
                        </div>
                    </div>
                </div>
            </section>
            
        </div>
</div>
<div id="popup_property_preview" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <center>
                <div id="property_preview" class="modal-dialog modal-lg popup">
                      <div class="modal-header">
                        <button class="property_info close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only">Close</span>
                        </button>
                        
                    </div>
                    <div class="modal-body">
                        <div id="property_preview_content">
                            <iframe id="property_preview_content_iframe" frameborder="0" seamless 
                                    width="100%" height="100%"></iframe>
                        </div>
                    </div>
                </div>
            </center>
</div>
<!-- Following space is meant to align the profile content with the sidebar-->
<br>
<br>
<br>
<br>
        <!-- /#page-content-wrapper -->
<!--        </div>--><br><br><br>
        <hr>
        <br><br><br><br><br>
                <div class="push row clearfix"></div>
         <div id="bottom_footer" class="content row clearfix">
            <div class="col-md-12 column">
		<div class="col-md-4 column">
    
</div>
<div id="copyright" class="col-md-4 column">
    <center>Copyright &copy; 2018 Ressphere. All right reserved</center>
</div>
<div id="footer_link" class="col-md-4 column">
    <center><ul>
    <li><span class="divider">|</span>&nbsp;&nbsp;&nbsp;<a target="_self" href="http://www.ressphere.com/#about">About Us</a>&nbsp;&nbsp;&nbsp;</li><li><span class="divider">|</span>&nbsp;&nbsp;&nbsp;<a target="_self" href="http://www.ressphere.com/#contact">Contact Us</a>&nbsp;&nbsp;&nbsp;</li><li class="hide"><span class="divider">|</span>&nbsp;&nbsp;&nbsp;<a target="_self" href="http://www.ressphere.com/sitemap.xml">Sitemap</a>&nbsp;&nbsp;&nbsp;</li><span class="divider">|</span>    
    </ul></center>
</div>
             </div>
        </div>
        
    </div>
   	<script type="text/javascript" src="http://www.ressphere.com/js/jquery.min.js"></script><script type="text/javascript" src="http://www.ressphere.com/js/bootstrap-mit.min.js"></script><script type="text/javascript" src="http://www.ressphere.com/js/typeahead.min.js"></script><script type="text/javascript" src="http://www.ressphere.com/js/angular.min.js"></script><script type="text/javascript" src="http://www.ressphere.com/js/_utils/jquery.makeclass.min.js"></script><script type="text/javascript" src="http://www.ressphere.com/js/jstorage.min.js"></script><script type="text/javascript" src="http://www.ressphere.com/js/base.js"></script><script type="text/javascript" src="http://www.ressphere.com/js/header.js"></script><script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script><script type="text/javascript" src="http://www.ressphere.com/js/_usercontrols/change_password.js"></script><script type="text/javascript" src="http://www.ressphere.com/js/_usercontrols/logout.js"></script><script type="text/javascript" src="http://www.ressphere.com/js/_scrolling_nav/scrolling-nav.js"></script><script type="text/javascript" src="http://www.ressphere.com/js/cb_home.js"></script><script type="text/javascript" src="http://www.ressphere.com/js/jquery.easing.min.js"></script><script type="text/javascript" src="http://www.ressphere.com/js/_switch-toggle/bootstrap-switch.js"></script><script type="text/javascript" src="http://www.ressphere.com/js/cb_update_profile.js"></script>    <!-- Standard place for all popup -->
    <div id="popup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        
<center>
    
    <div id="login" class="modal-dialog modal-sm popup">
<div class="modal-header">
    <button type="button" class="login_cancel close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <img class="logo" alt="" src="http://www.ressphere.com/images/ressphere-white.png"/>
  </div>
  <div class="modal-body">
    <input type="text" id="Username" class="form-control" placeholder="Email"/><br/>
    <input type="password" id="Password" class="form-control" placeholder="Password"/><br/>
    <div id="login_captcha">
            </div>
    <div id="Message">
        
    </div>
  </div>
  <div class="modal-footer">
    <center>
        <button class="login_cancel btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button id="login_sign_in" class="btn btn-primary">Sign In</button><br/><br/>
        <button id="login_sign_up" class="btn btn-warning">Create Account</button><br/><br/>
        <a id="login_forgotten_pwd" href="#">Forget your password?</a>
    </center>
  </div>
</div></center>
</div>
    <div id="register" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        
<center>
    
    <div id="register" class="modal-dialog modal-sm popup">
        
<div class="modal-header">
    <button type="button" class="register_cancel close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <img class="logo" alt="" src="http://www.ressphere.com/images/ressphere-white.png"/>
  </div>
  <div class="modal-body">
    <div class="input-group">
     <input type="text" id="register_display_name" class="form-control" placeholder="Display Name"/>
     <span class="register_display_name-feedback input-group-addon glyphicon glyphicon-asterisk"></span>
        
    </div>
    <br/>
    <div class="input-group">
     <input type="text" id="register_username" class="form-control" placeholder="Email"/>
     <span class="register_username-feedback input-group-addon glyphicon glyphicon-asterisk"></span>
        
    </div>
    <br/>
    <div class="input-group">
        <input type="password" id="register_password" class="form-control" placeholder="Password">
        <span class="register_password-feedback input-group-addon glyphicon glyphicon-asterisk"></span>
        
    </div>
    <span class="error password_help-block"></span>
    <br/>
    <div class="input-group">
        <input type="password" id="register_confirmed_password" class="form-control" placeholder="Retype Password">
        <span class="register_confirmed_password-feedback input-group-addon glyphicon glyphicon-asterisk"></span>
    </div>
    
    <span class="error repeatable_help-block"></span>
    <br>
    <div class="select-div" style="width:230px;float: none">
        <select class="form-control" id="register_country" style="width:280px">
        
        	<option value="CHINA">CHINA</option>
	<option selected value="MALAYSIA">MALAYSIA</option>
	<option value="SINGAPORE">SINGAPORE</option>
	<option value="UNITED STATES">UNITED STATES</option>
        
        </select>
    </div>
    <br/>
    
    <div  id="phonegroup" class="input-group">
        <span class="register_phone_areacode-feedback input-group-addon">
            <div  id="scrollable-dropdown-menu">
                <input type="text" id="register_area_code" class="input-small typeahead form-control" placeholder="Area Code"/>
            </div>
            
        </span>
        <span class="register_phone-extension-label input-group-addon glyphicon glyphicon-minus"></span>
        <input type="text" id="register_phone" style="background-color: white; border-color: white" class="form-control numericOnly" placeholder="Phone Number"/>
        <span class="register_phone-feedback input-group-addon glyphicon glyphicon-asterisk"></span>
    </div><br/>
    <center>
	<div id='register_captcha_image'>
	</div>
	</center><br>
  
    <input id ="register_term_condition" type="checkbox" value="Term_Condition"> I have read and agree with the <a href="http://www.ressphere.com/index.php/policy" target="_blank"><em>Terms & Conditions</em></a></input> 
    <div id="register_message"></div>
  </div>
  <div class="modal-footer">
    <center>
        <button class="register_cancel btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button id="register_sign_in" class="btn btn-primary">Register</button><br/><br/>
    </center>
  </div>
  
</div>
    
</center>
</div>
    <div id="popup_logout" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        
<center>
    <div class="modal-dialog modal-sm popup">
    <div class="modal-header">
        <button type="button" class="logout_close close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <img class="logo" alt="" src="http://www.ressphere.com/images/ressphere-white.png"/>
    </div>
    <div id="logout_body" class="modal-body">
            </div>
    <div class="modal-footer">
        <center>
            <button class="logout_close btn">Close</button>
        </center>
    </div>
</div></center>     
    </div>
     <div id="forgot_password" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        
<center>
    
    <div id="reset_password" class="modal-dialog modal-sm popup">
<div class="modal-header">
    <button type="button" class="reset_close close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <img  class="logo" alt="" src="http://www.ressphere.com/images/ressphere-white.png"/>
  </div>
  <div class="modal-body">
    <input type="text" id="reset_login" class="form-control" placeholder="Please enter your email"/><br/>
   
    <div id="Forgot_Password_Message">
       
    </div>
  </div>
  <div class="modal-footer">
    <center>
        
        <button class="reset_close btn">Close</button>
        <button id="reset_retrieve" class="btn btn-primary">Retrieve</button><br/><br/>
    </center>
  </div>
</div></center>
    </div>
    <div id="change_password" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        
<center>
    
    <div id="reset_password" class="modal-dialog modal-sm popup">
<div class="modal-header">
    <button type="button" class="reset_close close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <img  class="logo" alt="" src="http://www.ressphere.com/images/ressphere-white.png"/>
  </div>
  <div class="modal-body">
    <input type="password" id="crt_password" class="form-control" placeholder="Please enter your existing password"/><br/>
    <input type="password" id="chg_password" class="form-control" placeholder="Please enter your new password"/><br/>
    <input type="password" id="chg_confirmedPassword" class="form-control" placeholder="Please re-enter your new password"/><br/>
   
    <div id="Change_Password_Message">
        
    </div>
  </div>
  <div class="modal-footer">
    <center>
        
        <button class="change_close btn">Close</button>
        <button id="chg_pass_submit" class="btn btn-primary">Submit</button><br/><br/>
    </center>
  </div>
</div></center>
    </div>

    <div id="popup_general_info" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <center>
                <div id="general_info" class="modal-dialog modal-sm popup">
                    <div class="modal-header">
                        <button class="general_info close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <img class="logo" src="images/ressphere-white.png" alt="">
                    </div>
                    <div class="modal-body">
                        <div id="general_info_content"></div>
                    </div>
                    <div class="modal-footer">
                        <center>
                            <button class="general_info btn" data-dismiss="modal" type="button">Close</button>
                            
                            <br>
                        </center>
                    </div>
                </div>
            </center>
        </div>

</body>
</html>

<!DOCTYPE html>
<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>
  <?php
    echo $title;
  ?>
  </title>
  <base href="<?=base_url();?>" target="_blank">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="<?=$author?>">
  <meta name="description" content="<?=$metadesc?>"/>
  <meta name="keywords" content="<?=$metakey?>"/>
  <meta name="generator" content="<?=$generator?>"/>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta property="og:title" content="<?=$og_title?>" />
  <meta property="og:image" content="<?=$og_image?>" />
  <meta property="og:description" content="<?=$og_desc?>" />

  <!-- Print CSS through $this->extemplate->add_css() function -->
  <?php echo $_styles; ?>

  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="assets/images/favicon.ico">
</head>

    <body class="appear-animate">
        
        <!-- Page Loader -->        
        <div class="page-loader">
            <b class="spinner">Loading...</b>
        </div>
        <!-- End Page Loader -->
        
        <!-- Page Wrap -->
        <div class="page" id="top">
            
            <!-- Home Section -->
            <section class="home-section bg-color-alfa-70 parallax-2" data-background="images/section-bg-15.jpg" id="home">
                <div class="js-height-full">
                    
                    <!-- Home Page Content -->
                    <div class="home-content container">
                        <div class="home-text animate-init" data-anim-type="fade-in-up" data-anim-delay="100">
                            <div class="container">
                                
                                <!-- Headings -->
                                
                                <div class="hs-line-6 black mb-20">
                                    Resonance &amp; Resolution</strong>
                                </div>
                                
                                <div class="hs-line-7 black mb-30">
                                    Ressphere
                                </div>
                                
                                <div class="local-scroll">
                                    
                                    <a href="#services" class="btn btn-mod btn-w btn-circle btn-icon btn-large mb-xxs-10">
                                        <span><i class="fa fa-chevron-down"></i></span>
                                        Our Services
                                    </a>
                                    
                                    <span>&nbsp;</span>
                                    
                                    <a href="" class="btn btn-mod btn-w btn-circle btn-icon btn-large lightbox mfp-iframe">
                                        <span><i class="fa fa-youtube-play"></i></span>
                                        Intro Video
                                    </a>
                                    
                                </div>
                                
                                <!-- End Headings -->
                                
                            </div>
                        </div>
                    </div>
                    <!-- End Home Page Content -->
                    
                    <!-- Scroll Down -->
                    <div class="local-scroll">
                        <a href="#about" class="scroll-down static"><i class="fa fa-5x fa-angle-down black"></i></a>
                    </div>
                    <!-- End Scroll Down -->
                    
                </div>
            </section>
            <!-- End Home Section -->
            
            <!-- Navigation panel -->
            <nav class="main-nav dark stick-fixed">
                <div class="full-wrapper relative clearfix">
                	
                    <!-- Logo ( * your text or image into link tag *) -->
                    <div class="nav-logo-wrap local-scroll">
                        <a href="#top" class="logo"><img src="images/ressphere-white.png" width="280" height="227" alt="" /></a>
                    </div>
					
					<div class="mobile-nav"><i class="fa fa-bars"></i></div>
					
					<!-- Main Menu -->
            		<div class="inner-nav desktop-nav">            			               
                    	<ul class="clearlist scroll-nav local-scroll">
                    		<li class="active"><a href="#home">Home</a></li>
                        	<li><a href="#about">About us</a></li>                        	
							<li><a href="#services">Services</a></li>
							<li><a href="#contact">Contacts</a></li>
                        </ul>
                    </div>
                
                </div>
            </nav>		
            <!-- End Navigation panel -->
            
            
            <!-- About Us Section -->
            <section class="page-section bg-gray-lighter" id="about">
                <div class="container relative">
                    
                    <!-- Section Headings -->
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
                            <div class="section-title">
                                About Us<span class="st-point">.</span>
                            </div>
                            <div class="section-line mb-60 mb-xxs-30"></div>
                        </div>
                        
                    </div>
                    <!-- End Section Headings -->
                    
                    <!-- Nav Tabs -->
                    <div class="align-center mb-50 mb-xxs-30">
                        <ul class="nav nav-tabs tpl-minimal-tabs animate">
                            <li class="active">
                                <a href="#one" data-toggle="tab">About</a>
                            </li>
                            <li>
                                <a href="#two" data-toggle="tab">A.C.E.S</a>
                            </li>
                            <li>
                                <a href="#three" data-toggle="tab">missions Vision</a>
                            </li>
                        </ul>
                    </div>
                    <!-- End Nav Tabs -->
                    
                    <!-- Tab Content -->
                    <div class="tab-content tpl-minimal-tabs-cont">
                        
                        <!-- About -->
                        <div class="tab-pane fade in active" id="one">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
                                    <div class="section-text">
                                        Ressphere is founded on 17th of March, 2014.
Ressphere's vision is to create a platform that joins people from different background, different location, having different interest, mastering different expertise together to communicate and collaborate. 
Its name is derived from “Resonance/Resolution” and “Sphere” which symbolizes a society that contains people from all around the world where they can work together to achieve consensus that bring the best solution to each other.
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Skills -->
                        <div class="tab-pane fade" id="two">
                            
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
                                    <div class="section-text">
                                        <strong>We aim to complete our A.C.E.S missions with</strong>
<br>&#9679; &nbsp;Superior competency
&#9679;&nbsp;Passionate attitude
&#9679;&nbsp;Intelligent solution
&#9679;&nbsp;Contemporary style
&#9679;&nbsp;Endless creativity
                                        <br>The company now offers a circle binding platform, property circle and service circle. In the future, where there will be more circles that touch on different parts of our life to be launched.
                                    </div>
                                </div>
                        </div>
                        </div>
                        <!-- End Skills -->
                        <!-- Process -->
                        <div class="tab-pane fade" id="three">
                            
                            <!-- Process Grid -->
                            <div class="section-text" style="margin-bottom: 20px">
                                        <strong>We strike to achieve 4 missions that is aligned with our vision</strong>
                                    </div>
                            <div class="benefits-grid">
                                
                                <!-- Process Item -->
                                <div class="benefit-item">
                                    <div class="benefit-number">
                                        1
                                    </div>
                                    <div class="benefit-icon">
                                        <span class="icon-magnet"></span>
                                    </div>
                                    <h3 class="benefit-title">Affiliate</h3>
                                    <div class="benefits-descr">
                                        Affiliate join forces by creating a boundaryless environment.
                                    </div>
                                </div>
                                <!-- End Process Item -->
                                
                                <!-- Process Item -->
                                <div class="benefit-item">
                                    <div class="benefit-number">
                                        2
                                    </div>
                                    <div class="benefit-icon">
                                        <span class="icon-bubbles"></span>
                                    </div>
                                    <h3 class="benefit-title">Communicate</h3>
                                    <div class="benefits-descr">
                                        prepare an effective and efficient communication channel via internet.
                                    </div>
                                </div>
                                <!-- End Process Item -->
                                
                                <!-- Process Item -->
                                <div class="benefit-item">
                                    <div class="benefit-number">
                                        3
                                    </div>
                                    <div class="benefit-icon">
                                        <span class="icon-globe"></span>
                                    </div>
                                    <h3 class="benefit-title">Enhance</h3>
                                    <div class="benefits-descr">
                                        Build an online society that complement daily life. 
                                    </div>
                                </div>
                                <!-- End Process Item -->
                                
                                <!-- Process Item -->
                                <div class="benefit-item">
                                    <div class="benefit-number">
                                        4
                                    </div>
                                    <div class="benefit-icon">
                                        <span class="icon-shield"></span>
                                    </div>
                                    <h3 class="benefit-title">Secure</h3>
                                    <div class="benefits-descr">
                                        create a safe and trustworthy virtual online platform.
                                    </div>
                                </div>
                                <!-- End Process Item -->
                                
                            </div>
                            <!-- End Process Grid -->
                            
                        </div>
                        <!-- End Process -->
                        
                    </div>
                    <!-- End Tab Content -->
                    
                  
                    
                </div>
            </section>
            <!-- End About Us Section -->
            
            
            
            <!-- Features Section -->
            <section class="page-section bg-scroll bg-dark-alfa-50" data-background="images/section-bg-5.jpg"  id="services">
                <div class="container relative">
                    
                    <!-- Features Grid -->
                    <div class="item-carousel owl-carousel animate-init" data-anim-type="bounce-in-right-large" data-anim-delay="200">
                        
                        <!-- Features Item -->
                       <a href="http://www.ressphere.com/properties/"> <div class="features-item"> 
                            <div class="features-icon">
                                <span class="icon-home"></span>
                            </div>
                            <div class="features-title">
                                Ressphere Property
                            </div>
                            <div class="features-descr">
                                Find your home now!
                            </div>
                        </div>
                           </a>
                        <!-- End Features Item -->
                        
                        <!-- Features Item -->
                        <div class="features-item">
                            <div class="features-icon">
                                <span class="icon-map"></span>
                            </div>
                            <div class="features-title">
                                Around You
                            </div>
                            <div class="features-descr">
                                What Nearby you
                            </div>
                        </div>
                        <!-- End Features Item -->
                        
                        <!-- Features Item -->
                        <div class="features-item">
                            <div class="features-icon">
                                <span class="icon-diamond"></span>
                            </div>
                            <div class="features-title">
                                Comming Soon
                            </div>
                            <div class="features-descr">
                                Still in progress
                            </div>
                        </div>
                        <!-- End Features Item -->
                    </div>
                    <!-- Features Grid -->
                </div>
            </section>
            <!-- Features Section -->
            <!-- Contact Section -->
            <section class="page-section bg-scroll bg-dark-alfa-90" data-background="images/section-bg-8.jpg" id="contact">
                <div class="container relative">
                        <div class="col-md-12">
                            <!-- Contact Form -->                            
                                <div class="clearfix mb-20 mb-xs-0">
                                    <div class="cf-left-col">
                                        <!-- Name class="ci-field form-control"-->
                                        <div class="form-group">
                                            <input type="text" name="name" id="contact_user_info_0"  placeholder="Name" pattern=".{3,100}" required style="background: transparent; height: 44px; padding: 10px 5px; font-size: 17px; font-weight: 400; text-transform: none; color: #fff; border: none; border-bottom: 1px solid rgba(255,255,255, .15); letter-spacing: 1px; border-radius: 0px; box-shadow: none; width: 100%; display: block; font-family: inherit; font: inherit; margin: 0; ">
                                        </div>
                                        <!-- Email -->
                                        <div class="form-group">
                                            <input type="email" name="email" id="contact_user_info_1" placeholder="Email" pattern=".{5,100}" required style="background: transparent; height: 44px; padding: 10px 5px; font-size: 17px; font-weight: 400; text-transform: none; color: #fff; border: none; border-bottom: 1px solid rgba(255,255,255, .15); letter-spacing: 1px; border-radius: 0px; box-shadow: none; width: 100%; display: block; font-family: inherit; font: inherit; margin: 0; ">
                                        </div>
                                        <!-- Phone Number -->
                                        <div class="form-group">
                                            <input type="contact_number" name="contact_number" id="contact_user_info_2" placeholder="Your Phone Number" pattern=".{5,100}" required style="background: transparent; height: 44px; padding: 10px 5px; font-size: 17px; font-weight: 400; text-transform: none; color: #fff; border: none; border-bottom: 1px solid rgba(255,255,255, .15); letter-spacing: 1px; border-radius: 0px; box-shadow: none; width: 100%; display: block; font-family: inherit; font: inherit; margin: 0; ">
                                        </div>
                                    </div>
                                    <div class="cf-right-col">
                                        <!-- Message -->
                                        <div class="form-group">
                                            <label for="message" style="margin-top: 10px; margin-bottom: 6px; font-size: 17px; font-weight: 400; color: rgba(255,255,255, .5); display: inline-block; box-sizing: border-box;">Message</label>
                                            <textarea name="message" id="contact_us_msg" style="background: transparent; height: 75px; min-height:120px; padding: 5px; font-size: 13px; font-weight: 400; text-transform: none; color: #fff; letter-spacing: 1px; border: 1px solid rgba(255, 255, 255, .15); box-shadow: none; width: 100%; display: block; font-family: inherit; font: inherit; margin: 0; resize:none;" ></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!-- Send Button -->
                                <button class="contact_us_send btn btn-mod btn-large btn-full ci-btn" id="contact_us_send" style="color: rgba(255,255,255, .5);">
                                    Send
                                </button>
                            <!-- End Contact Form -->
                        </div>
                    </div>
            </section>
            <!-- End Contact Section -->
    <!-- Print js through $this->extemplate->add_js() function -->
    <?php echo $_scripts; ?>
  
    <!-- Standard place for all popup -->
    <div id="popup" tabindex="-1" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <?php echo $login_view?>
    </div>
    <div id="register" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <?php echo $register_view?>
    </div>
    <div id="popup_logout" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <?php echo $logout_view?>
        
    </div>
     <div id="forgot_password" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <?php echo $forgotpass_view?>
    </div>
    <div id="change_password" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <?php echo $changepass_view?>
    </div>

    <div id="popup_general_info" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <center>
                <div id="general_info" class="modal-dialog modal-sm popup" style="background: #131212f0; border: solid #ababab 1px; box-shadow: 1px 1px 8px 1px #888888, 2px 2px 8px 2px #888888 inset, -1px -1px 8px -1px #888888, -2px -2px 8px -2px #888888 inset;" >
                    <div class="modal-header">
                        <button class="general_info close" data-dismiss="modal" type="button" style="font-size: 30px; color: #ff0000;">
                            <span aria-hidden="true" >x</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <img class="logo" src="images/ressphere-white.png" alt="">
                    </div>
                    <div class="modal-body">
                        <div id="general_info_content" style="color:white;"></div>
                    </div>
                    <div class="modal-footer">
                        <center>
                            <button class="general_info btn" data-dismiss="modal" type="button" style="font-weight: 700; color: rgba(255, 255, 255, 0.5); outline: transparent; padding: 15px 40px 14px; width: 100%; background: rgba(34,34,34, .9); border: 2px solid transparent; text-transform: uppercase; letter-spacing: 2px; border-radius: 0; font-family: inherit; font-size: 13px;" >CLOSE</button>
                            <br>
                        </center>
                    </div>
                </div>
            </center>
        </div>
        
</body>
</html>

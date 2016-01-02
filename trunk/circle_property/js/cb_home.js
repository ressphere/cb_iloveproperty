function centeralize_image(width)
{

    return -(parseFloat(width)/2.0);
}

var page_scroll_func = function()
{
    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
        $('a.page-scroll').parent().removeClass('active');
        //$(this).parent().addClass('active');
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top - 10
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
        
    });
//    // Highlight the top nav as scrolling occurs
//    $('body').scrollspy({
//        target: '.navbar-fixed-top',
//        data-offset:'80'
//    });

    // Closes the Responsive Menu on Menu Item Click
    $('.navbar-collapse ul li a').click(function() {
        $('.navbar-toggle:visible').click();
    });
};
 
var send_contact_us_create_captcha = function()
{
    Recaptcha.destroy();
    Recaptcha.create("6Le-mg0TAAAAAM_HWZc35jAtjRfsuAYTh9_J9CqL",
            "send_contact_us_captcha_image",
            {
                theme: "white",
                callback: Recaptcha.focus_response_field
            }
         );
};


$(document).ready(
   function() {
       
       var home= {
            Extends: get_base(),
            Initialize: function( private ){       
                this.parent.Initialize();
      
            },
            Private:{
      
            },
            Public:{
      
            }
        };
    
        var objHome = $.makeclass(home);
        
        var waitForFinalEvent = (function () {
             var timers = {};
              return function (callback, ms, uniqueId) {
                if (!uniqueId) {
                  uniqueId = "Don't call this twice without a uniqueId";
                }
                if (timers[uniqueId]) {
                  clearTimeout (timers[uniqueId]);
                }
                timers[uniqueId] = setTimeout(callback, ms);
              };
        })();
        $( window ).resize(function(){
            var objBase = $.makeclass(get_base());
            waitForFinalEvent(function() {
                objBase.set_footer_position();
		delete objBase;
                 jQuery('[data-spy="scroll"]').each(function () {
                    var $spy = jQuery(this).scrollspy('refresh')
                  });
                }, 100, objBase.generateUUID());
            }
        );
        waitForFinalEvent(function() {
            objHome.set_footer_position();
            page_scroll_func();
        }, 100, objHome.generateUUID());
        var hide = true;
        
        $('#main_content .navbar-toggle').click(
                function()
                {
                    if(hide)
                        {
                            if($('.collapse').hasClass('in'))
                            {
                                $('.collapse.in').css("display", "block");
                            }
                           
                            hide = false;
                        }
                   else
                       {
                           if($('.collapse').hasClass('in'))
                           {
                                 $('.collapse.in').css("display", "none");
                           }
                           
                           hide = true;
                       }
                }
        );
        $("#contact_us_send").click(function()
                {
                    var base_path = objHome.getBaseUrl();
                    var _url_to_send = String.format("{0}index.php/cb_home/send_contact_msg",base_path);
                    var senddata = "contact_user_info_0="+$("#contact_user_info_0").val()+
                        "&contact_user_info_1="+$("#contact_user_info_1").val()+
                        "&contact_us_msg="+$("#contact_us_msg").val()+
                        "&contact_number="+$("#contact_user_info_2").val();
                    
                    $("#contact_send_status_message").html("Sending now ...");
                    $('button').prop('disabled', true);
                    $('input').prop('disabled', true);
                    $('textarea').prop('disabled', true);
                    $.ajax(
                        {
                            url: _url_to_send, 
                            async: false,
                            data: senddata,
                            type: 'POST',
                            success: function(result){
                
                                $("#general_info_content").html(result);
                                $('button').prop('disabled', false);
                                $('input').prop('disabled', false);
                                $('textarea').prop('disabled', false);
                                $('input').val("");       
                                $('textarea').val("");
                                $("#popup_general_info").modal("show");

                            }
                        }
                    );
                }
            );

        
        
   }
);


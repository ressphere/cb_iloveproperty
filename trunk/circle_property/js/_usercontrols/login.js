        var id = '#Message';
        var exceeded_login = false;
        function reset_ui()
        {
            $('#Username').val('');
            $('#Password').val('');
            $(id).html('');
            
        }
        Recaptcha.focus_response_field = function()
        {
            if(exceeded_login === false)
            {
                $('#login_captcha').css('display', 'none');
            }
            return false;
        };
        function login_create_captcha()
        {
            try
            {
                Recaptcha.destroy();
            }
            catch(e)
            {

            }
            Recaptcha.create("6Le-mg0TAAAAAM_HWZc35jAtjRfsuAYTh9_J9CqL",
                    "login_captcha",
                    {
                        theme: "white",
                        callback: Recaptcha.focus_response_field
                    }
                 );
        }
        $('#login_sign_up').click(function() {                
                $('#register').modal({
                    'keyboard': false,
                    'backdrop':'static',
                    'show': true
                });
                $('#popup').modal('hide');
         });
         
       $('#popup').on('show.bs.modal', function () {
            reset_ui();
            login_create_captcha();
        });
        $('#popup').on('hidden.bs.modal', function () {
            reset_ui();
           
            
        });
       function set_login_btn(disable)
       {
           $('#login_sign_in').prop('disabled', disable);
           $('#login_sign_up').prop('disabled', disable);
           $('.login_cancel').prop('disabled', disable);
           if(disable)
           {
                $('#login_forgotten_pwd').css('display', 'none');
           }
           else
           {
                $('#login_forgotten_pwd').css('display', 'block');
           }
       }
       function resend_email()
       {
           var objBase = $.makeclass(get_base());
           var base_path = objBase.getWsdlBaseUrl("index.php/cb_user_registration/get_wsdl_base_url");
           url = base_path + "index.php/cb_user_registration/resend_activation_email";
           
           objBase.setLoading(id);
           $.ajax({
                        url: url,
                        type: 'POST',
                        data: null,
						timeout: 3000000,
                        success: function(html)
                        {
                            $(id).html(html);
                        },
                        error:function (xhr, ajaxOptions, thrownError){

                            window.console&&console.log(xhr.status.toString());
                            window.console&&console.log(xhr.statusText);
                  
                        }  
                    });
       }
       $('#login_sign_in').click(function() {
                var objBase = $.makeclass(get_base());
                var base_path = objBase.getWsdlBaseUrl("index.php/cb_user_registration/get_wsdl_base_url");
                //var current_base_path = objBase.getBaseUrl();
                var senddata = "";
                var response = null;
                var challenge = null;
                try
                {
                    var response = Recaptcha.get_response();
                    var challenge = Recaptcha.get_challenge();
                }
                catch(e)
                {
                    
                }
                
                if(response === null || challenge === null)
                 {
                     response = "";
                     challenge = "";
                 }
                
                senddata = "username=" + $('#Username').val() +"&password=" +  $('#Password').val() + "&captcha=" +  response;
		senddata = senddata + "&challenge="+ challenge;
                url = base_path + "index.php/cb_user_registration/beginLogin";
                    
                    objBase.setLoading(id);
                    set_login_btn(true);
                    //var location = $('#login_forgotten_pwd').attr('href');
                    //$('#login_forgotten_pwd').removeAttr('href');
                   // alert($('#login_forgotten_pwd').attr('href'));
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: senddata,
			timeout: 3000000,
                        success: function(html)
                        {
                            Recaptcha.reload();
                            if(html.indexOf("Success") === -1)
                            {
                                if(html.indexOf("exceeded_login") !== -1)
                                {
                                    var res = html.split(";");
                                    
                                    if(exceeded_login === false)
                                    {
                                        $(id).html("<font color='red'>Exceeded login...</font>");
                                    }
                                    else
                                    {
                                        $(id).html(res[1]);
                                    }
                                    exceeded_login = true;
                                    $('#login_captcha').css('display', '');
                                }
                                else {
                                    $(id).html(html);
                                }
                                $('#resend_activation').click(function(event) {
                                    event.preventDefault();
                                    resend_email();
                                });
                            }
                            
                            else
                            {
                                //username
                                var username = $('#Username').val().split('@');
                                $('#username').html( username[0]);
                                $(id).html('');
                                $('#Password').val('');
                                $('#after_login_menu').css('display','block');
                                $('#system_login_parent').css('display','none');
                                $('#popup').modal('hide');
                                window.location.href = objBase.getBaseUrl();
                                //window.location.href = current_base_path;
                                
                            }
                            set_login_btn(false);
                            //$('#login_forgotten_pwd').attr('href', location);    
                        },
                        error:function (xhr, ajaxOptions, thrownError){

                            window.console&&console.log(xhr.status.toString());
                            window.console&&console.log(xhr.statusText);
                            set_login_btn(false);
                            //$('#login_forgotten_pwd').attr('href', location);
                        }  
                    });
                
            });
       
       $('#login_forgotten_pwd').click(function(event) {
                event.preventDefault();
				$("#reset_retrieve").show();
                $('#forgot_password').modal({
                    'keyboard': false,
                    'backdrop':'static',
                    'show': true
                });
                $('#popup').modal('hide');
       });
       
       $(document).ready(
            function() {
                reset_ui();
               
            }
   );

            
            



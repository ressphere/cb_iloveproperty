        var id = '#Message';
        var exceeded_login = false;
        var captcha_token = "";
        function reset_ui()
        {
            
            $('#Username').val('');
            $('#Password').val('');
            $(id).html('');
            
        }
        
        grecaptcha.ready(function () {
            grecaptcha.execute('6LfBpbEUAAAAAP_5vfKjUXr1Nf3o_c5R_GwveSvM', { action: 'homepage' }).then(function (token) {
                  captcha_token = token;
                  console.log("captcha_token: "+token)
            });
        });
        
        $('#login_sign_up').click(function() {                
                $('#register').modal({
                    'keyboard': false,
                    'backdrop':'static',
                    'show': true
                });
                $('#popup_login').modal('hide');
         });
         
       $('#popup_login').on('show.bs.modal', function () {
            reset_ui();
        });
        $('#popup_login').on('hidden.bs.modal', function () {
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
                var token = "";
                var senddata = "";
                 
                
                senddata = "username=" + $('#Username').val() +"&password=" +  $('#Password').val() + "&token=" +  captcha_token;
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
                            if(typeof grecaptcha !== 'undefined' && grecaptcha && grecaptcha.execute) { 
                                grecaptcha.ready(function () {
                                    grecaptcha.execute('6LfBpbEUAAAAAP_5vfKjUXr1Nf3o_c5R_GwveSvM', { action: 'homepage' }).then(function (token) {
                                    captcha_token = token;
                                    console.log("captcha_token: "+token)
                                    });
                                });
                            }
                            if(html.indexOf("Success") === -1)
                            {
                                if(html.indexOf("exceeded_login") !== -1)
                                {
                                    var res = html.split(";");
                                    
                                    if(exceeded_login === false)
                                    {
                                        $(id).html("<font color='red'>Invalid username or password</font>");
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
                                //$('#after_login_menu').css('display','block');
                                $('#system_login').css('display','none');
                                $('#post_login_menu').css('display','block');
                                $('#system_login_parent').css('display','none');
                                $('#system_login_key').css('display','none');
                                $('#popup_login').modal('hide');
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
                $('#popup_login').modal('hide');
       });
       
       $(document).ready(
            function() {
                reset_ui();
               
            }
   );

            
            



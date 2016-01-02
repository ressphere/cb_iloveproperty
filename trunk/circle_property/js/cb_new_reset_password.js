$(document).ready(
    function() {
        var objBase = $.makeclass(get_base());
        $('.reset_close').click(function()
            {
               $('#reset_password_modal').modal('hide'); 
               /*$('#popup').modal({'keyboard': false,
                  'backdrop':'static',
                  'show': true}); */
                
                window.location.href = objBase.getBaseUrl();
            });
        $('#reset_retrieve').click(
                function()
                {
                    $('button').prop('disabled', true);
  
                    var senddata = "password="+$('#reset_password').val() + "&confirmed_password=" + $('#reset_confirmedPassword').val();
                    var objBase = $.makeclass(get_base());
                    var base_path = objBase.getBaseUrl();
                    url = base_path + "index.php/cb_user_registration/begin_reset_password";
                    id = '#Reset_Message';
                    objBase.setLoading(id);
                    $.ajax({
                        url: url,
						timeout: 3000000,
                        type: 'POST',
                        data: senddata,
                        success: function(html)
                        {
                           var data = jQuery.parseJSON(html);
                           $('button').prop('disabled', false);
                           if(data['msg'] === "Success")
                           {
                                  $('#reset_password_activation .modal-body').html('<span class="info">Your password is resetted <BR> please login with new password</span>');     
                                  
                           }   
                           else
                           {
                              $(id).html(data['msg']);     
							 
                           }
                            if(data['msg'].indexOf('auth_message_new_password_failed') >= 0 || data['msg'] === "Success")
							{
							        $('#reset_retrieve').hide();
							}
                           
                            $('input').val('');
                        },
                        error:function (xhr, ajaxOptions, thrownError){

                            alert(xhr.status.toString());
                            alert(xhr.statusText);
                            $('button').prop('disabled', false);
                            $('input').val('');
                        }  
                    });
                   // alert('reset start');
                }
        );
            
            //objBase.getLogin('#popup');
            //objBase.getRegister('#register');
            //alert('show');
            $('#reset_password_modal').modal({'keyboard': false,
                  'backdrop':'static',
                  'show': true});
            //alert('show');
   }
);

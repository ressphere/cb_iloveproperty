/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var forgot_password_id = '#Forgot_Password_Message';
function reset_ui()
{
    $('#reset_login').val('');
      $(forgot_password_id).html('');
      $('#reset_password button').prop('disabled', false);
}

$('.reset_close').click(
        function(event)
        {
            event.preventDefault();
            $('#forgot_password').modal('hide');
        }
);
$('#forgot_password').on('hidden.bs.modal', function () {
    reset_ui();
});
$('#reset_retrieve').click(
        function()
        {
                var objBase = $.makeclass(get_base());
                //var base_path = objBase.getBaseUrl();
                var base_path = objBase.getWsdlBaseUrl("index.php/cb_user_registration/get_wsdl_base_url");
                var senddata = "email="+$('#reset_login').val();
                url = base_path + "index.php/cb_user_registration/begin_password";
                    $('#reset_password button').prop('disabled', true);
                    objBase.setLoading(forgot_password_id);
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: senddata,
						timeout: 3000000,
                        success: function(html)
                        {
                           var data = jQuery.parseJSON(html);
                           if(data['msg'] === "Success")
                           {
                             message = "An email has been sent, <BR> please follow the instruction in your email to reset password";
                             $(forgot_password_id).html(message);   
                           }
                           else
                           {
                                $(forgot_password_id).html(data['msg']);
                           }
                           $('#reset_login').val('');
						   if(data['msg'] !== 'Password does not match with confirmed password')
							  {
							        $('#reset_password button').hide();
							  }
						    else
							{
							    	$('#reset_password button').prop('disabled', false);
						    }
                                
                        },
                        error:function (xhr, ajaxOptions, thrownError){

                            window.console&&console.log(xhr.status.toString());
                            window.console&&console.log(xhr.statusText);
                            $('#reset_password button').prop('disabled', false);
                  
                        }  
                    });
        }
);


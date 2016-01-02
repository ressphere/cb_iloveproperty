/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var change_password_id = '#Change_Password_Message';
function reset_ui()
{
      $('#crt_password').val('');
      $('#chg_password').val('');
      $('#chg_confirmedPassword').val('');
      $(change_password_id).html('');
      $('#reset_password button').prop('disabled', false);
}

$('.change_close').click(
        function(event)
        {
            event.preventDefault();
            $('#change_password').modal('hide');
        }
);
    
$('#change_password').on('hidden.bs.modal', function () {
    reset_ui();
});

$('#chg_pass_submit').click(
        function()
                {
                    $('button').prop('disabled', true);
  
                    var senddata = "current_password="+$('#crt_password').val() + 
                                   "&password="+$('#chg_password').val() + 
                                   "&confirmed_password=" + $('#chg_confirmedPassword').val();
                    var objBase = $.makeclass(get_base());
                    var base_path = objBase.getBaseUrl();
                    url = base_path + "index.php/cb_user_registration/change_password";
                    id = '#Change_Password_Message';
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
                           
                           //display the change password message
                           $(id).html(data['msg']);     
							
                            if(data['msg'].indexOf('auth_message_new_password_failed') >= 0 || data['status'] === TRUE)
			    {
                                $('#chg_pass_submit').hide();
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
                }
);


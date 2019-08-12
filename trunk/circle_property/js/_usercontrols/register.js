function register_create_captcha()
{
   try
   {
        Recaptcha.destroy();
        Recaptcha.create("6Le-mg0TAAAAAM_HWZc35jAtjRfsuAYTh9_J9CqL",
                "register_captcha_image",
                {
                    theme: "white",
                    callback: Recaptcha.focus_response_field
                }
             );
//      grecaptcha.ready(function () {
//            grecaptcha.execute('6LfBpbEUAAAAAP_5vfKjUXr1Nf3o_c5R_GwveSvM', { action: 'homepage' }).then(function (token) {
//                  console.log("my register key");
//                  console.log(token);
//                  captcha_token = token;
//                  
//            });
//        });
   }
   catch(e)
   {
       if (window.console) 
           console.log(e);
   }
}

$('#register_country').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var countrySelected = this.value;
    //call ajax
     var objBase = $.makeclass(get_base());
     //var base_path = objBase.getBaseUrl();
     var base_path = objBase.getWsdlBaseUrl("index.php/cb_user_registration/get_wsdl_base_url");
     senddata = "country=" + countrySelected;
     objBase.setLoading('#phonegroup .register_phone_areacode-feedback');
     $.ajax({
        url: base_path + "index.php/cb_user_registration/getAreaCode",
        type: 'POST',
        data: senddata,
		timeout: 3000000,
        success: function(html)
        {
           var codes = jQuery.parseJSON(html);
           $('#phonegroup .register_phone_areacode-feedback').html('<div id="scrollable-dropdown-menu"><input type="text" id="register_area_code" class="input-small typeahead form-control" placeholder="Area Code"/></div>');
           var i = 0;
           var areaCodes = [];
           if(codes.length > 0)
           {		
		for(i = 0; i < codes.length; i++)
                {
                    areaCodes.push(codes[i]);
		}
                var areaCodes = new Bloodhound({
                        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                        queryTokenizer: Bloodhound.tokenizers.whitespace,
                        local: $.map(areaCodes, function(areacode){return {value: areacode};})
                });
                areaCodes.initialize();
                $("#scrollable-dropdown-menu .typeahead").typeahead(
                {
                        hint:true,
                        highlight: true,
                        minLength: 1
                }
                ,
                {
                        name: 'areaCodes',
                        displayKey: 'value',
                        source:  areaCodes.ttAdapter()
                }
                );
           }
		   
           enable_disable_button();
        },
        error:function (xhr, ajaxOptions, thrownError){
                window.console&&console.log(xhr.status.toString());
                window.console&&console.log(xhr.statusText);
                enable_disable_button();
        }  
     });

    
});

function reset_ui()
{
    $('#register_username').val('');
    $('#register_display_name').val('');
    $('#register_password').val('');
    $('#register_confirmed_password').val('');
    $('#register_phone').val('');
    $('#register_term_condition').removeAttr('checked');
    $('#register_message').html("");
    
    reset_status_feedback();
    enable_disable_button();
}

function reset_status_feedback()
{
	$('.register_display_name-feedback').css('color', 'gray');
    $('.register_display_name-feedback').removeClass('glyphicon-ok');
    $('.register_display_name-feedback').removeClass('glyphicon-remove');
    $('.register_display_name-feedback').addClass('glyphicon-asterisk');
	
    $('.register_username-feedback').css('color', 'gray');
    $('.register_username-feedback').removeClass('glyphicon-ok');
    $('.register_username-feedback').removeClass('glyphicon-remove');
    $('.register_username-feedback').addClass('glyphicon-asterisk');
    
    $('.register_confirmed_password-feedback').css('color', 'gray');
    $('.register_confirmed_password-feedback').removeClass('glyphicon-ok');
    $('.register_confirmed_password-feedback').removeClass('glyphicon-remove');
    $('.register_confirmed_password-feedback').addClass('glyphicon-asterisk');
    
    $('.register_password-feedback').css('color', 'gray');
    $('.register_password-feedback').removeClass('glyphicon-ok');
    $('.register_password-feedback').removeClass('glyphicon-remove');
    $('.register_password-feedback').addClass('glyphicon-asterisk');
    
    $('.register_phone-feedback').css('color', 'gray');
    $('.register_phone-feedback').removeClass('glyphicon-ok');
    $('.register_phone-feedback').removeClass('glyphicon-remove');
    $('.register_phone-feedback').addClass('glyphicon-asterisk');
}
$('#register').on('hidden.bs.modal', function () {
            reset_ui();            
});
$('#register').on('show.bs.modal', function () {
            reset_ui();
});
 
 $(document).ready(
            function() {
                reset_ui();
                register_create_captcha();
                $('#register_sign_in').prop('disabled', true);
            }
   );

$(function () {
    try
    {
        Recaptcha.destroy();
    }
    catch(e)
    {
        
    }
    
});

$('#register_confirmed_password').on('change',
    function() 
    {
        $('.register_confirmed_password-feedback').removeClass('glyphicon-asterisk');
        if ($(this).val() !== $('#register_password').val())
        {
            $('.repeatable_help-block').html('Whoops, password does not match');
            $('.register_confirmed_password-feedback').removeClass('glyphicon-ok');
            $('.register_confirmed_password-feedback').addClass('glyphicon-remove');
            $('.register_confirmed_password-feedback').css('color', 'red');
        }
        else
        {
            $('.repeatable_help-block').html('');
            $('.register_confirmed_password-feedback').addClass('glyphicon-ok');
            $('.register_confirmed_password-feedback').removeClass('glyphicon-remove');
            $('.register_confirmed_password-feedback').css('color', '#3c763d');
        }
        enable_disable_button();
    }
    
    
);

$('#register_password').on('change',
    function() 
    {
        $('.register_password-feedback').removeClass('glyphicon-asterisk');
        if ($(this).val() === '')
        {
            $('.password_help-block').html('Password cannot be empty');
             $('.register_password-feedback').removeClass('glyphicon-ok');
            $('.register_password-feedback').addClass('glyphicon-remove');
            $('.register_password-feedback').css('color', 'red');
        }
        else if ($(this).val().length < 6 || $(this).val().length > 12)
        {
            $('.password_help-block').html('Password must in between 6 to 12 characters');
             $('.register_password-feedback').removeClass('glyphicon-ok');
            $('.register_password-feedback').addClass('glyphicon-remove');
            $('.register_password-feedback').css('color', 'red');
        }
        else
        {
            $('.password_help-block').html('');    
            $('.register_password-feedback').addClass('glyphicon-ok');
            $('.register_password-feedback').removeClass('glyphicon-remove');
            $('.register_password-feedback').css('color', '#3c763d');
        }
        if ($(this).val() !== $('#register_confirmed_password').val())
        {
            $('.repeatable_help-block').html('Whoops, password does not match');
            //glyphicon glyphicon-remove
            $('.register_confirmed_password-feedback').removeClass('glyphicon-ok');
            $('.register_confirmed_password-feedback').addClass('glyphicon-remove');
            $('.register_confirmed_password-feedback').css('color', 'red');
            
        }
        else
        {
            $('.repeatable_help-block').html('');
            $('.register_confirmed_password-feedback').addClass('glyphicon-ok');
            $('.register_confirmed_password-feedback').removeClass('glyphicon-remove');
            //#3c763d
            $('.register_confirmed_password-feedback').css('color', '#3c763d');
        }
        enable_disable_button();
//        if ($(this).val() !== $('register_confirmed_password').val())
//        {
//            $('.repeatable_help-block').html('Whoops, password does not match')
//        }
//        else
//        {
//            $('.repeatable_help-block').html('')
//        }
    }
);
$('#register_sign_in').on('click',
       function ()
       {
           var objBase = $.makeclass(get_base());
            var countrySelected = $( "#register_country option:selected" ).text();
            var code = null;
            if($("#register_area_code").is("input"))
            {
              code = $("#register_area_code").val();
            }
            else
            {
              code = $("#register_area_code option:selected").text();      
            }
            //var base_path = objBase.getBaseUrl();
            var base_path = objBase.getWsdlBaseUrl("index.php/cb_user_registration/get_wsdl_base_url");
            var path = base_path + "index.php/cb_user_registration/beginRegister";
            //alert($("#register_display_name").val());
            var senddata = "email=" + $("#register_username").val();
            
            senddata = senddata + "&password=" + $('#register_password').val();
            senddata = senddata + "&repassword="+ $('#register_confirmed_password').val();
            senddata = senddata + "&country="+ countrySelected;
            senddata = senddata + "&area="+ code;
            senddata = senddata + "&phone="+ $("#register_phone").val();
            senddata = senddata + "&term_condition="+ $("#register_term_condition").is(':checked');
            senddata = senddata + "&captcha="+ grecaptcha.getResponse();
            senddata = senddata + "&display_name=" + $('#register_display_name').val();
            objBase.setLoading('#register_message');
            $('.register_cancel').prop('disabled', true);
            $('#register_sign_in').prop('disabled', true);
            $.ajax({
                url: path,
                type: 'POST',
                data: senddata,
		timeout: 3000000,
                success: function(html)
                {
                    //for debug purpose only. Not for release!
                    //console.log(html);
                    
                    data = jQuery.parseJSON(html);
                    $('#register_message').html(data["msg"]);
                    $('#register_password').val('');
                    $('#register_confirmed_password').val('');
                    if(data["msg"] === "Success")
                    {
                        //reset_ui();
                        $('#register_username').val('');
                        $('#register_display_name').val('');
                        $('#register_password').val('');
                        $('#register_confirmed_password').val('');
                        $('#register_phone').val('');
                        $('#register_term_condition').removeAttr('checked');
                        $('#register_message').html("");

                        reset_status_feedback();
                        var activation_msg = "<B>Congratulation</B><BR>An activation email is sent to " + $("#register_username").val();
                        $('#register_message').html('');
                        $("#register").modal("hide");
                        $("#general_info_content").html(activation_msg);
                        $("#popup_general_info").modal("show");
                        
                    }
                    else {
                        $('.register_confirmed_password-feedback').css('color', 'gray');
                        $('.register_confirmed_password-feedback').removeClass('glyphicon-ok');
                        $('.register_confirmed_password-feedback').removeClass('glyphicon-remove');
                        $('.register_confirmed_password-feedback').addClass('glyphicon-asterisk');
    
                        $('.register_password-feedback').css('color', 'gray');
                        $('.register_password-feedback').removeClass('glyphicon-ok');
                        $('.register_password-feedback').removeClass('glyphicon-remove');
                        $('.register_password-feedback').addClass('glyphicon-asterisk');
                    }
                    $('.register_cancel').prop('disabled', false);
                    //$('#register_sign_in').prop('disabled', false);
                    grecaptcha.reset();
                    enable_disable_button();
                },
                error:function (xhr, ajaxOptions, thrownError){

                        alert(xhr.status.toString());
                        alert(xhr.statusText);
                        $('.register_cancel').prop('disabled', false);
                        $('#register_sign_in').prop('disabled', false);

                }  
            });
       }
 );
 function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
$('#register_phone').on('change',
    function()
    {
        $('.register_phone-feedback').removeClass('glyphicon-asterisk');
        if($(this).val() === '')
        {
            $('.register_phone-feedback').removeClass('glyphicon-ok');
            $('.register_phone-feedback').addClass('glyphicon-remove');
            $('.register_phone-feedback').css('color', 'red');
        }
        else
        {
            $('.register_phone-feedback').addClass('glyphicon-ok');
            $('.register_phone-feedback').removeClass('glyphicon-remove');
            //#3c763d
            $('.register_phone-feedback').css('color', '#3c763d');
        }
        enable_disable_button();
    }
);
$('#register_username').on('change',
    function() 
    {
        $('.register_username-feedback').removeClass('glyphicon-asterisk');
        if(IsEmail($(this).val()))
        {
                $('.register_username-feedback').addClass('glyphicon-ok');
            $('.register_username-feedback').removeClass('glyphicon-remove');
            //#3c763d
            $('.register_username-feedback').css('color', '#3c763d');
        }
        else
        {
             $('.register_username-feedback').removeClass('glyphicon-ok');
            $('.register_username-feedback').addClass('glyphicon-remove');
            $('.register_username-feedback').css('color', 'red');
        }
        enable_disable_button();
            
    }
);
//register_display_name
$('#register_display_name').on('change',
    function() 
    {
        $('.register_display_name-feedback').removeClass('glyphicon-asterisk');
        if($(this).val() !== "")
        {
                $('.register_display_name-feedback').addClass('glyphicon-ok');
            $('.register_display_name-feedback').removeClass('glyphicon-remove');
            //#3c763d
            $('.register_display_name-feedback').css('color', '#3c763d');
        }
        else
        {
             $('.register_display_name-feedback').removeClass('glyphicon-ok');
            $('.register_display_name-feedback').addClass('glyphicon-remove');
            $('.register_display_name-feedback').css('color', 'red');
        }
        enable_disable_button();
            
    }
);

$('#register_term_condition').change(
  function()
  {
      enable_disable_button();
  }      
);

function enable_disable_button()
{
    var error_count = $('.glyphicon-remove').length;
    var asterisk_count = $('.glyphicon-asterisk').length;
    
    if ((error_count + asterisk_count) > 0 || $('#register_term_condition').prop("checked") === false)
    {
        $('#register_sign_in').prop('disabled', true);
    }
    else
    {
        $('#register_sign_in').prop('disabled', false);    
    }
}




$('#system_logout').click(
                function(event)
                {//var link = $(this);
                    event.preventDefault();
                    var objBase = $.makeclass(get_base());
                    objBase.invokeLogout('#logout_body');
                    $('.logout_close').css('display', 'none');
                    $('#popup_logout').modal('show');
                }
 );
 $('#logout_body').bind('DOMNodeInserted', function(e) {
    //console.log('element: ', e.target, ' was inserted);
    $('.logout_close').css('display', 'block');
});
 $('.logout_close').click(
            function(){
                var objBase = $.makeclass(get_base());
                objBase.is_login('#after_login_menu', '#system_login_parent');
                $('#popup_logout').modal('hide');
        });
$('#popup_logout').on('hidden.bs.modal', function () {
    var objBase = $.makeclass(get_base());
    window.location.href = objBase.getBaseUrl();
});
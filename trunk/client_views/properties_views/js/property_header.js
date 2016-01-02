var get_updated_category = {
  update : function() {
    var obj = StaticHomeObject.getInstance();
    $('.state').css('display', 'none');
    var categories = obj.get_current_category();

    for (var category in categories) {
        var id = category.toLowerCase();
        $('#'+id).css('display', "");
        $('#'+id).attr('href',categories[category]);
        console.log(window.location.href);
        if(window.location.href.indexOf(categories[category]) > 0)
        {
           $('#'+id).css('color', 'black');
           $('#'+id).css('font-weight', 'bold');
        }
        
        
    };
  }
};
$(document).ready(function() {
         var obj = StaticHomeObject.getInstance();
         obj.setup_auth_ui();
         obj.preload_login();
         obj.removeObserver(get_updated_category);
         obj.addObserver(get_updated_category);
         obj.update_category();
         $('#btn_currency').click(function()
         {
            $("#popup_currency_change").modal('show');
         });
         $('#btnChangeCurrency').click(function()
         {
            var $to = $('#select_currency').val();
            var objHome = StaticHomeObject.getInstance();
            objHome.set_fav_currency($to);
            $('#btn_currency').html("Currency (<span id='btn_currency_type'>"+$to+"</span>)");
            $("#select_currency").val($to);
         });
         
         var fav_currency = obj.get_fav_currency();
         if(typeof fav_currency === 'undefined' || fav_currency === null)
         {
            fav_currency = "MYR";
         }
         $('#btn_currency').html("Currency (<span id='btn_currency_type'>"+fav_currency+"</span>)");
         $("#select_currency").val(fav_currency);
});



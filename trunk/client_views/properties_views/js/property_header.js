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
           $('#'+id).css('border-bottom', '3px solid #662D91');
        }
        else
        {
            $('#'+id).css('color', 'grey');
        }
        
    };
  }
};
var update_currency_list = function()
{
    if($('#select_currency').length > 0)
       {
            var objBase = StaticHomeObject.getInstance();
            $.ajax
             ({
                 type: "POST",
                 url: objBase.getWsdlBaseUrl() + 'index.php/base/get_list_of_currency',
                 async:true,
                 data: null,
                 success: function(result)
                 {
                     var result_dict = JSON.parse(result)['data']['result'];
                     $("#select_currency").html('');
                     for (var key in result_dict) {
                        if (result_dict.hasOwnProperty(key)) {
                            $("#select_currency").append("<option value='"+key+"'>"+result_dict[key]+"</option>");
                        }
                    }
                    

                 },
                 error:function (xhr, ajaxOptions, thrownError)
                 {    
                     window.console&&console.log(xhr.status.toString());
                     window.console&&console.log(xhr.statusText);
                 }  
             });
       }
};
$(document).ready(function() {
         var obj = StaticHomeObject.getInstance();
         obj.setup_auth_ui();
         obj.preload_login();
         obj.removeObserver(get_updated_category);
         obj.addObserver(get_updated_category);
         obj.update_category();
         update_currency_list();
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
         var objHome = StaticHomeObject.getInstance();
         objHome.set_fav_currency(fav_currency);
         $('#btn_currency').html("Currency (<span id='btn_currency_type'>"+fav_currency+"</span>)");
         $("#select_currency").val(fav_currency);
});
$(document).ready(
   function() {
        var objHome = StaticHomeObject.getInstance();
        
        load_category();
        //Call server to identify which doughnat to display
        
        //objHome.set_properties_category_as_doughnut();
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
        $(window).resize(function()
            {
                var objBase = $.makeclass(get_base());
                objHome.resize_main_menu();
                waitForFinalEvent(function() {
                    objBase.set_footer_position(); 
					delete objBase;
                    }, 100, objBase.generateUUID());
            }
       
        );
        waitForFinalEvent(function() {
            objHome.set_footer_position();
           

        }, 100, objHome.generateUUID());
        
  
        var listing_uploaded_status = $.jStorage.get("listing_uploaded");
        if(listing_uploaded_status)
        {
           $.jStorage.deleteKey("listing_uploaded");
           //TODO pop the listing uploaded
           $("#property_info_content").html(listing_uploaded_status);
           $("#popup_property_info").modal('show');
        }
        
        
   }
);

var load_category = function(private)
{
    var objHome = StaticHomeObject.getInstance();
    //TODO: ajax implementation here
    //var objBase = $.makeclass(get_base());
    var base_path = objHome.getWsdlBaseUrl("index.php/cb_user_registration/get_wsdl_base_url");
    var _url = base_path + "index.php/cb_user_registration/isLogin";
    //if (window.console) console.log(url);
    $.ajax({url: _url,
        success: function(result, status, xhr) {
            if(result === "-1")
            {
                //alert('set_anonymous_properties_category_as_doughnut()');
                objHome.set_anonymous_properties_category_as_doughnut();
            }
            else
            {
                objHome.set_properties_category_as_doughnut();
            }
        },
        data: null,
        type: "POST",
        dataType: "text",
        timeout: 3000000,
        async: false,
        error: function(xhr) {
            window.console&&console.log("There is An error occured: " + xhr.status + " " + xhr.statusText);
        }
    });

};


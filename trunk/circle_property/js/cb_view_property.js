$(document).ready(
    function() {
        var objBase = $.makeclass(get_base());
        objBase.setNumericInput(".numericOnly");
        
        
    }
);


// This function is use to generate search result page
function cb_view_property_submit() {

    var input_name = document.getElementById('cb_view_property_nameInput').value;
    var input_price_min = document.getElementById('cb_view_property_priceMin').value;
    var input_price_max = document.getElementById('cb_view_property_priceMax').value;

    // To obtain current URL so can generate new URL
    var l = window.location;
    var pathname_array = l.pathname.split('/');
    var base_url = l.protocol + "//" + l.host + "/" + pathname_array[1] + "/" + pathname_array[2] + "/" + pathname_array[3] + "/" + pathname_array[4] + "/" + pathname_array[5];

    var new_url = base_url + "/search_result?page=1&Name="+input_name+"&Price_min="+input_price_min+"&Price_max="+input_price_max;
    //alert (new_url);

   window.location.href = new_url;
}
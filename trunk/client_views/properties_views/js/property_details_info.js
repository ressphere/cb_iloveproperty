var send_contact_captcha_obj = null;
var current_scope = null;
var getParameterByName = function(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
};

var on_send_contact_captcha = function ()
{
    try
    {
        Recaptcha.destroy();
    }
    catch(e)
    {

    }
    Recaptcha.create("6Le-mg0TAAAAAM_HWZc35jAtjRfsuAYTh9_J9CqL",
            "send_contact_captcha",
            {
                theme: "white",
                callback: Recaptcha.focus_response_field
            }
    );

};

var reset_send_contact_ui = function()
{
    $('#send_contact_name').val('');
    $('#send_contact_phone').val('');
    document.getElementById('send_contact').disabled = true;
};
/*
 * 
 * @param {angular js entities} $scope
 * @returns {undefined}
 */
var get_new_listing_data = function($scope,  $sce)
{
    var objHome = StaticHomeObject.getInstance();
    current_scope = $scope;
    var base_path = objHome.getBaseUrl();
    var ref_tag = getParameterByName("reference");
    var _url = String.format("{0}index.php/properties_details/get_property_info_list?{1}={2}",
            base_path,"reference", ref_tag);
    var listing = null;
  
    $.ajax({url: _url,
        success: function(result, status, xhr) {
            listing = result;
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
    if (listing !== null)
    {
        var listing_obj = jQuery.parseJSON(listing)["data"];
        //set google map location
        var Price = parseFloat(listing_obj["price"]);
        var buildup = parseFloat(listing_obj["buildup"]);
        var PricePer = Price / buildup;
		var is_occupied = (listing_obj["occupied"] === 1) ? "Yes":"No";
		var map_location_obj = jQuery.parseJSON(listing_obj["map_location"]);

        $scope.current_url = window.location.href;
        $scope.accounting = accounting;
        $scope.property_information.Price = Price.toFixed(2);
        $scope.property_information.currency = listing_obj["currency"];
        $scope.property_information.PropertyName = listing_obj["property_name"];
        $scope.property_information.RoomCount =  listing_obj["bedrooms"];
        $scope.property_information.ToiletCount =  listing_obj["bathrooms"];
        $scope.property_information.ParkingCount = listing_obj["car_park"];
        $scope.property_information.PricePer = (PricePer).toFixed(2);
        $scope.property_information.Area = listing_obj["area"] + " " + listing_obj["state"];
        //$scope.property_information.NearbyPlaces = listing_obj["nearest_spot"];
        $scope.property_information.Remark =  $sce.trustAsHtml(listing_obj["remark"]);
        $scope.property_information.PropertyImages = map_image_path(listing_obj["property_photo"]);
        $scope.person.email = listing_obj["email"];
        $scope.person.name = listing_obj["displayname"];
        $scope.person.phone = listing_obj["phone"];
        
        setup_details_info("reference", listing_obj["ref_tag"], $scope);
        //reserve_type
        setup_details_info("reserve_type", listing_obj["reserve_type"], $scope);
        setup_details_info("type", listing_obj["service_type"], $scope);
        setup_details_info("tenure", listing_obj["tenure"], $scope);
        setup_details_info("property_category", listing_obj["property_category"], $scope);
        setup_details_info("property_type", listing_obj["property_type"], $scope);
        setup_details_info("measurement_type", listing_obj["size_measurement_code"], $scope);
        
        setup_details_info("monthly", listing_obj["monthly_maintanance"], $scope);
        setup_details_info("land_title_type", listing_obj["land_title_type"], $scope);
        setup_details_info("auction", listing_obj["auction"], $scope);
        setup_details_info("reserve_type", listing_obj["reserve_type"], $scope);
        setup_details_info("land_area", listing_obj["landarea"], $scope);
        setup_details_info("built_up", listing_obj["buildup"], $scope);
        setup_details_info("furnishing", listing_obj["furnished_type"], $scope);
		
        setup_details_info("occupied", is_occupied, $scope);
        set_facilities($scope, listing_obj["facilities"]);
        
        $scope.property_information.Country = listing_obj["country"];
        $scope.property_information.State = listing_obj["state"];
        $scope.property_information.Area = listing_obj["area"];
        $scope.property_information.PostCode = listing_obj["post_code"];
        $scope.property_information.Street = listing_obj["street"];
        $scope.property_information.MapLocationK = map_location_obj["k"];
        $scope.property_information.MapLocationB = map_location_obj["B"];        
        
        set_google_map_data(map_location_obj["k"], map_location_obj["B"]);
        
        $scope.enabled_contact = true;
        $scope.contact_click = function()
        {
            $("#popup_property_contact").modal('show');
        };
       
        $scope.send_contact_click = function()
        {
            //Begin to send the contact to customer 
            var objHome = StaticHomeObject.getInstance();
            var base_path = objHome.getBaseUrl();
            var url = base_path + "index.php/properties_details/send_user_contact";
            var response = null;
            var challenge = null;
            try
            {
                var response = Recaptcha.get_response();
                var challenge = Recaptcha.get_challenge();
            }
            catch(e)
            {

            }

            if(response === null || challenge === null)
            {
                 response = "";
                 challenge = "";
            }
            //$display_name, $phone, $msg, $cap, $challenge
            var senddata = "display_name=" + $('#send_contact_name').val() +"&phone=" +  
                    $('#send_contact_phone').val() + "&captcha=" +  response + "&challenge="+ challenge 
                    + "&msg=" + $('#send_contact_comment').val();
            $("#send_status_msg").html("<span class='error'>Sending ...</span>");
            document.getElementById('send_contact').disabled = true;
            $.ajax({
                        url: url,
                        type: 'POST',
                        data: senddata,
			timeout: 3000000,
                        success: function(response_json)
                        {          
                            var response = JSON.parse(response_json);
                            
                            reset_send_contact_ui();
                            if(response["status"] === -2)
                            {
                               $("#send_status_msg").html("<span class='error'>"+ response["reason"]+ "</span>");
                               Recaptcha.reload();
                               
                               
                            }
                            else
                            {
                                $("#send_status_msg").html("");
                                Recaptcha.reload();
                                $("#property_info_content").html(response["reason"]);
                                $("#popup_property_contact").modal('hide');
                                $("#popup_property_info").modal('show');
                            }
                        },
                        error:function (xhr, ajaxOptions, thrownError){
                            reset_send_contact_ui();
                            window.console&&console.log(xhr.status.toString());
                            window.console&&console.log(xhr.statusText);
                            
                        }  
                    });
            
        };
        $scope.validate_sending_contact_details = function()
        {
            $('.contact_owner_required_data').keyup(
                    function()
                    {
                        setTimeout(function(){
                            //$scope.enabled_send_contact = true;
                            var enabled = true;
                            $('.contact_owner_required_data').each(
                                function()
                                {
                                    if($(this).val() === "")
                                    {
                                        //alert('disable send contact');
                                        enabled = false;
                                    }
                                }
                            );
                            //$scope.enabled_send_contact = enabled;
                            document.getElementById('send_contact').disabled = !enabled;
                        }, 0);
                       
                    }
            );  
        };
        
    }


};

var set_google_map_data = function(k, B)
{
    var listing_obj = {"location":{"k":k, "B":B}};
    $.jStorage.set("details_data", JSON.stringify(listing_obj));
};
var add_details = function(data, details)
{
    for(var j=0; j<data.length; j++)
    {
       if(data[j].has_detail === false)
       {
          data[j].detail = details;
          data[j].has_detail = true;
          if(data[j].detail.photos)
          {
             var temp_photos = [];
             for(var k = 0; k<data[j].detail.photos.length;k++)
             {
                 var photo_url = data[j].detail.photos[k].getUrl({
                     'maxWidth': data[j].detail.photos[k].width, 
                     'maxHeight': data[j].detail.photos[k].height});
                 temp_photos.push(photo_url);
             }
             data[j].detail.photos = temp_photos;
          }
          //return data;
          break;
       }
    }
};
var get_google_map_data = function($scope)
{
    var listing = $.jStorage.get("details_data");
    if (listing !== null)
    {
        var listing_obj = jQuery.parseJSON(listing);
        $scope.country_state.location["k"] = listing_obj["location"]["k"];
        $scope.country_state.location["B"] = listing_obj["location"]["B"];
        $.jStorage.deleteKey("details_data");
        var ngGPlacesAPI_obj = $scope.get_ngGPlacesAPI();
        ngGPlacesAPI_obj.nearbySearch(
        {
             latitude:$scope.country_state.location["k"], 
             longitude:$scope.country_state.location["B"]
        }
        ).then(
            function(data){

                for (var i = 0; i < data.length; i++) {
                    data[i]['has_detail'] = false;
                    ngGPlacesAPI_obj.placeDetails({reference:data[i].reference}).then(
                        function (details) {
                            add_details(data, details);

                        },
                        function (details) {

                        }
                    );
                }
                $scope.property_information.NearbyPlaces = data;
                
        });
    }
    //$.jStorage.
};

var text_to_html = function($text)
{
    $text = $text.replace('&lt;', '<');
    $text = $text.replace('&gt;', '>');
    return $text;
};
/*
 * 
 * @param {angular js entities} $scope
 * @param {property_base object} objProperty
 * @returns {undefined}
 */
var get_initial_data = function($scope, objProperty, $http)
{
    //oveerided in get_new_listing_data
    return;
};

var convert_facilities_name = function($scope, facility)
{
    if(facility in $scope.property_facility_1)
    {
        return $scope.property_facility_1[facility];
    }
    if(facility in $scope.property_facility_2)
    {
        return $scope.property_facility_2[facility];
    }
    if(facility in $scope.property_facility_3)
    {
        return $scope.property_facility_3[facility];
    }
};

var set_facilities = function($scope, facilities)
{
  var count = 0;
  
  $scope.property_information.property_facilities = [[],[],[]];
  for(var i = 0; i< facilities.length; i++)
  {
      var facility_real_name = convert_facilities_name($scope, facilities[i]);
      $scope.property_information.property_facilities[count].push(facility_real_name);
      
      
      if(++count > 2)
      {
          count = 0;
      }
  }
};

var map_image_path = function(image_list)
{
    var image_dict = [];
    for(var i = 0; i < image_list.length; i++)
    {
       image_dict.push([image_list[i]["path"], image_list[i]["description"]]);
    }
    return image_dict;
};
$(document).ready(function()
{
    $('#popup_property_contact').on('show.bs.modal', function () {
            on_send_contact_captcha();
            reset_send_contact_ui();       
    });
    $('#popup_property_contact').on('hide.bs.modal', function () {
            reset_send_contact_ui();
            
    });
    
});



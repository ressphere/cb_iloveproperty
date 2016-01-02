/*
 * 
 * @param {angular js entities} $scope
 * @returns {undefined}
 */
var get_new_listing_data = function($scope,  $sce)
{
    var listing = $.jStorage.get("preview_data");
    if (listing !== null)
    {
        var listing_obj = jQuery.parseJSON(listing);
        //set google map location
        var Price = parseFloat(listing_obj["price"]);
        var buildup = parseFloat(listing_obj["buildup"]);
        
        if (listing_obj["service_type"] === "RENT" || 
                listing_obj["service_type"] === "ROOM")
        {
            $scope.property_information.PricePer = '--';
            $('.PricePer').css('display', 'none');
            
        }
        else
        {
            $scope.property_information.PricePer = ((Price / buildup)).toFixed(2);
            $('.PricePer').css('display', '');
        }
        
       
        $scope.accounting = accounting;
        $scope.property_information.Price = Price.toFixed(2);
        $scope.property_information.currency = listing_obj["currency"];
        $scope.property_information.PropertyName = listing_obj["unit_name"];
        $scope.property_information.RoomCount =  listing_obj["bedrooms"];
        $scope.property_information.ToiletCount =  listing_obj["bathrooms"];
        $scope.property_information.ParkingCount = listing_obj["car_park"];
        $scope.property_information.Area = listing_obj["area"] + " " + listing_obj["state"];
        $scope.property_information.NearbyPlaces = listing_obj["nearest_spot"];
        $scope.property_information.Remark =  $sce.trustAsHtml(listing_obj["remark"]);
        $scope.property_information.PropertyImages = listing_obj["property_photo"];
        setup_details_info("reference", null, $scope);
        setup_details_info("tenure", listing_obj["tenure"], $scope);
        setup_details_info("property_category", listing_obj["property_category"], $scope);
        setup_details_info("property_type", listing_obj["property_type"], $scope);
        
        
        setup_details_info("measurement_type", listing_obj["size_measurement_code"], $scope);
        setup_details_info("monthly", listing_obj["monthly_maintanance"], $scope);
        setup_details_info("land_title_type", listing_obj["land_title_type"], $scope);
        setup_details_info("auction", listing_obj["auction"], $scope);
        setup_details_info("reserve_type", listing_obj["reserve_type"], $scope);
        setup_details_info("type", listing_obj["service_type"], $scope);
        setup_details_info("land_area", listing_obj["landarea"], $scope);
        setup_details_info("built_up", listing_obj["buildup"], $scope);
        setup_details_info("furnishing", listing_obj["furnished_type"], $scope);
        setup_details_info("occupied", listing_obj["occupied"], $scope);
        set_facilities($scope, listing_obj["facilities"]);
        
    }


};

var get_google_map_data = function($scope)
{
    var listing = $.jStorage.get("preview_data");
    if (listing !== null)
    {
        var listing_obj = jQuery.parseJSON(listing);
        $scope.country_state.location["k"] = listing_obj["location"]["k"];
        $scope.country_state.location["B"] = listing_obj["location"]["B"];
    }
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
    var url = objProperty.getWsdlBaseUrl() + "index.php/base/obtain_user_information";
    $http({
        method: 'GET',
        url: url,
        data: null,
        cache: true,
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function(response) {
        $scope.person.email = response.data.username;
        $scope.person.phone = response.data.phone;
        $scope.person.name = response.data.displayname;
    });
};

var set_facilities = function($scope, facilities)
{
  var count = 0;
  $scope.property_information.property_facilities = [[],[],[]];
  for(var i = 0; i< facilities.length; i++)
  {
      $scope.property_information.property_facilities[count].push(facilities[i]);
      if(++count > 3)
      {
          count = 0;
      }
  }
};

 var setup_details_info = function(key, value, $scope)
{
    for(var i = 0; i < $scope.property_information["details"].length; i++)
    {
       for(var j = 0; j < $scope.property_information["details"][i].length; j++)
       {
            switch($scope.property_information["details"][i][j].id)
            {
                case key:
                    if(value === null)
                    {
                       $scope.property_information["details"][i][j].value = "--";
                    }
                    else
                    {
                        $scope.property_information["details"][i][j].value = value;
                    }
            }
       }
    }
};
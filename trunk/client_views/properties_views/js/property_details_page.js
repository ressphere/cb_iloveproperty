/**Angular js code for details page
 * @author Tan Chun Mun
 * @description This is partial script that needed by details
 * page
 * **/
// <editor-fold desc="set google nearby place radius and type(special for property)"  defaultstate="collapsed">

ng_map_profile.config(function(ngGPlacesAPIProvider, $compileProvider) {
            $compileProvider.aHrefSanitizationWhitelist(/^\s*(geo|https?|ftp|mailto|whatsapp|chrome-extension):/);
            ngGPlacesAPIProvider.setDefaults({
                radius: 1000,
                types: ['bank', 'school', 'shopping_mall', 'hospital', 'airport', 'subway_station', 'bus_station', 'train_station',
                    'university', 'taxi_stand', 'gas_station'],
                nearbySearchKeys: ['name', 'reference', 'vicinity', 'types', 'icon']
            });
});
// </editor-fold>

ng_map_profile.controller('previewPage', function($scope, $controller, ngGPlacesAPI, flowFactory, $http, $sce)
{
    $controller('google_maps', {$scope: $scope, ngGPlacesAPI: ngGPlacesAPI, flowFactory: flowFactory});
    $controller('facilities', {$scope: $scope});
    $controller('listing_prefix', {$scope: $scope});
        
    $scope.person = {
        'email': '',
        'name': '',
        'phone': ''
    };
    $scope.current_url = window.location.href;
    $scope.enabled_contact = false;
    $scope.enabled_send_contact = false;
    $scope.loan_measurement_type = 'loan_percentage';
    $scope.has_next_page = false;
    $scope.has_prev_page = false;
    $scope.my_position = {"latitude": null, "longitude":null};
    
    $scope.show_map = function(lat, lgt)
    {
        var objHome = StaticHomeObject.getInstance();
        var wsdl_path = objHome.getWsdlBaseUrl();
        $('#popup_google_location').modal('show');
        $('#frameMap').attr('src', wsdl_path + 'ressphere_map/map?lat="'+lat+'"&lgt="'+lgt+'"&width="100%"&height="300"');
        $scope.gps.lat = lat;
        $scope.gps.lgt = lgt;
    };
     
    $scope.get_ngGPlacesAPI = function()
    {
          return ngGPlacesAPI;
    };
    $scope.update_installment = function()
    {
        var amount = $scope.property_information.Total_loan;
	var interest_rate = $scope.property_information.interest_rate;
	var months = $scope.property_information.years * 12;
	
        var rate_per_period = interest_rate / 100 / 12;
        var pay_back_ratio = 1 / months;
        if(rate_per_period > 0)
        {
            //amortization-calculation
            //A = p * (r*(1+r)^n/((1+r)^n - 1))
            pay_back_ratio = rate_per_period * Math.pow((1 + rate_per_period), months)/
                (Math.pow((1 + rate_per_period), months) - 1);
        }
	$scope.property_information.installment = (pay_back_ratio * amount).toFixed(2);
    };
    
    $scope.change_total_loan_by_percentage = function(percentage)
    {
        var loan_amount = $scope.property_information.Converted_Price * percentage / 100.00;
        $scope.property_information.Total_loan = loan_amount.toFixed(2);
    };
    $scope.contact_click = function()
    {
        //TDOD: override this function in another js
    };
    var begin_change_measurement_value = function(measurement_value, measurement_id, 
        from, to, base_path, $scope)
    {
        var senddata = "measurement_value="+measurement_value + 
                "&from_measurement_type=" + from +
                "&to_measurement_type=" + to;
        
        var objHome = StaticHomeObject.getInstance();
        var _url = String.format("{0}index.php/properties_details/get_converted_measurement_value", base_path);
        $http({
            method: 'POST',
            url: _url,
            data: senddata,
            cache: true,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
          }).then(function successCallback(response) {
               setup_details_info(measurement_id, accounting.toFixed(response.data, 5) , $scope);
               objHome.set_fav_measurement_type(to);
               $scope.property_information.selected_measurement_type = to;
               $('.lbl_measurement_type').html(to);
               $scope.property_information.PricePer = 
                    $scope.property_information.Converted_Price / 
                    get_details_info("built_up", $scope);
          },function errorCallback(response) {
                    console.log('internal error');
             }
          );
    };
    
    
    var on_change_measurement_type = function()
    {

        var objHome = StaticHomeObject.getInstance();
        var base_path = objHome.getBaseUrl();
 
        var measurement_to_change = ["land_area", "built_up"];
        for (var i = 0; i < measurement_to_change.length; i++) {
           var origin_value = 0.00;
           if(measurement_to_change[i] === "land_area")
           {
               origin_value = $scope.property_information.origin_land_area;
           }
           else if(measurement_to_change[i] === "built_up")
           {
               origin_value = $scope.property_information.origin_built_up;
           }
           begin_change_measurement_value(origin_value, 
            measurement_to_change[i], 
            $scope.property_information.origin_measurement_type, 
            $('#select_property_measurement').val(),
            base_path,
            $scope);
        }
       
    
        $scope.property_information.selected_measurement_type = $('#select_property_measurement').val();
        setup_details_info("measurement_type",$scope.property_information.selected_measurement_type , $scope);
    };
    
    // <editor-fold desc="On google map and marker loaded completely"  defaultstate="collapsed">
    var initialize_google_map = function(lat, lng) {
        if (Object.keys($scope.googleMap).length > 0)
        {
            var EnlargeControlDiv = document.createElement('div');
            var map = $scope.googleMap.getGMap();

            GoogleMapControl(EnlargeControlDiv, $scope, ngGPlacesAPI);

            EnlargeControlDiv.index = 1;
            map.controls[google.maps.ControlPosition.TOP_RIGHT].push(EnlargeControlDiv);
            //Disable marker to be draggable
            var markers = $scope.googleMarker.getGMarkers();
            for (var i = 0; i < markers.length; i++)
            {
                markers[i].draggable = false;
                markers[i].setPosition(
                        {
                            lat: lat,
                            lng: lng
                        });
            }
            $scope.map.center.latitude = lat;
            $scope.marker.coords.latitude = lat;
            $scope.map.center.longitude = lng;
            $scope.marker.coords.longitude = lng;


        }
    };
    $scope.update_currency = function(price, $from, $to, $i)
    {
        var objHome = StaticHomeObject.getInstance();
        
        if(price === null)
        {
            price = $scope.property_information.Price;
            $from = $scope.property_information.currency;
            
        }
        var senddata = "currency_value="+price + 
                "&from_currency=" + $from +
                "&to_currency=" + $to;
        //start change the currency here
        var objHome = StaticHomeObject.getInstance();
        var base_path = objHome.getBaseUrl();
        var _url = String.format("{0}index.php/properties_details/get_converted_currency_value", base_path);
        $http({
            method: 'POST',
            url: _url,
            data: senddata,
            cache: true,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
          }).then(function successCallback(response) {
                  var converted_price = response.data;
                  $scope.property_information.Converted_Price = converted_price;
                  $scope.property_information.ToCurrency = $to;
                  $scope.property_information.PricePer = $scope.property_information.Converted_Price / get_details_info("built_up", $scope);
                  
             }, function errorCallback(response) {
                  console.log('internal error');
        });
        
    };
    var watcher_of_country_state = function() {
        $scope.$watchCollection("country_state", function(newVal, oldVal)
        {
            //use jquery to get the ISO 3166-1 Alpha-2 compatible country code and capital location

            if (newVal === oldVal)
            {
                return;
            }
            else {
                $scope.map.center.latitude = newVal["location"]["k"];
                $scope.marker.coords.latitude = newVal["location"]["k"];
                $scope.map.center.longitude = newVal["location"]["B"];
                $scope.marker.coords.longitude = newVal["location"]["B"];
                $scope.googleMarker.getGMarkers()[0].setPosition({lat: $scope.map.center.latitude, lng: $scope.map.center.longitude});
            }
        });
    };
    $scope.update_currency_callback = {
	update :{ 
            apply: function(price, currency, index) {
                var objHome = StaticHomeObject.getInstance();
                $scope.update_currency(price, currency, objHome.get_fav_currency(), index);
            }
        }
   
    };
    // </editor-fold> 
    get_new_listing_data($scope, $sce);
    
    angular.element(document).ready(
            function() {
                var property_preview = {
                    Extends: get_base(),
                    Initialize: function(private) {
                        this.parent.Initialize();


                    },
                    Private: {
                    },
                    Public: {
                    }
                };
                var objProperty = $.makeclass(property_preview);
                // <editor-fold desc="load_initial_data"  defaultstate="collapsed">
                var objHome = StaticHomeObject.getInstance();
                $scope.country_state = {
                    country: 'Malaysia',
                    short: 'my',
                    location: {
                        "k": 3.140307520038235,
                        "B": 101.6866455078125
                    },
                    states: ['Penang', 'Johor']
                };

                // </editor-fold>
                
                watcher_of_country_state();
                get_initial_data($scope, objProperty, $http);
                get_google_map_data($scope);
                
                initialize_google_map($scope.country_state.location["k"], $scope.country_state.location["B"]);
                
                $scope.$watch("property_information.percentage_value", function(newVal, oldVal){
                    if (_.isEqual(newVal, oldVal))
                        return;
                    if($scope.loan_measurement_type === 'loan_percentage')
                        $scope.change_total_loan_by_percentage(newVal);
                });
                
                $scope.$watch("property_information.Converted_Price", function(newVal, oldVal){
                    if (_.isEqual(newVal, oldVal))
                        return;
                    if($scope.loan_measurement_type === 'loan_percentage')
                    {
                        $scope.property_information.Total_loan = newVal * 
                            $scope.property_information.percentage_value / 100.00;
                    }
                    $scope.update_installment();
                });
                
                $scope.$watch("loan_measurement_type", function(newVal, oldVal){
                    if (_.isEqual(newVal, oldVal))
                        return;
                    if($scope.loan_measurement_type === 'loan_percentage')
                    {
                        $scope.property_information.Total_loan = $scope.property_information.Price * 
                            $scope.property_information.percentage_value / 100.00;
                    }
                    $scope.update_installment();
                });
                
                $scope.$watch("property_information.Total_loan", function(newVal, oldVal){
                    if (_.isEqual(newVal, oldVal))
                        return;
                    $scope.property_information.percentage_value = newVal * 100 /  
                         $scope.property_information.Converted_Price;
                    $scope.property_information.Total_loan = newVal;
                    $scope.update_installment();
                });
                
                $scope.$watch("property_information.installment", function(newVal, oldVal){
                    if (_.isEqual(newVal, oldVal))
                        return;
                    $scope.property_information.installment = newVal;
                    $scope.update_installment();
                });
                
                $scope.$watch("property_information.interest_rate", function(newVal, oldVal){
                    if (_.isEqual(newVal, oldVal))
                        return;
                    $scope.property_information.interest_rate = newVal;
                    $scope.update_installment();
                });
                
                $scope.$watch("property_information.years", function(newVal, oldVal){
                    if (_.isEqual(newVal, oldVal))
                        return;
                    $scope.property_information.years = newVal;
                    $scope.update_installment();
                });
             
                $scope.get_property_type_string = function(type)
                {
                   switch(type)
                   {
                       case "sell":
                           return "Property For Sell";
                       case "rent":
                           return "Property For Lease";
                       case "room":
                           return "Room To Let";
                       default:
                           return false;
                   }
                };
                $scope.$watch("property_information.details[0][0].value", function(newVal, oldVal){
                      var type_string = $scope.get_property_type_string(newVal.toLowerCase());
                      if(type_string)
                      {
                            $('.sell, .rent, .room').parent().css('display', 'none');
                            $('.sell, .rent, .room').css('display', 'none');
                            $("."+newVal.toLowerCase()).css('display', '');
                            $("."+newVal.toLowerCase()).parent().css('display', '');
                            $scope.property_information.details[0][0].value = type_string;
                      }
                });
                
               
                $scope.next_page_clicked = function()
                {
                    $('#books').turn('next');
                };
                $scope.prev_page_clicked = function()
                {
                    $('#books').turn('previous');
                };
                $scope.gps={
                    "lat":null,
                    "lgt":null
                };
                $("#books").bind("turning", function(event, page, view) {
                    check_page(page, $scope);
                });
                
                $scope.change_total_loan_by_percentage($scope.property_information.percentage_value);
                $scope.update_installment();
                photo_paging();
		
                $.jStorage.deleteKey("preview_data");
                check_page(1, $scope);
                $scope.property_information.origin_land_area = get_details_info("land_area", $scope);
                $scope.property_information.origin_built_up = get_details_info("built_up", $scope);
                $scope.property_information.origin_measurement_type = 
                        get_details_info("measurement_type", $scope);
                var measurement_type = objHome.get_fav_measurement_type();
                
                if(!measurement_type)
                {
                    
                    $('.lbl_measurement_type').val(
                            $scope.property_information.selected_measurement_type);
                }
                else
                {
                    $('.lbl_measurement_type').val(measurement_type);
                    $scope.property_information.selected_measurement_type = 
                            measurement_type;
                }
                 
                objHome.set_fav_measurement_type(
                        $scope.property_information.selected_measurement_type);
                
                //setup_details_info("measurement_type",$scope.property_information.selected_measurement_type , $scope);
                objHome.set_currency_value($scope.property_information.Price);
                objHome.set_currency_from($scope.property_information.currency);
   
                $('.lbl_measurement_type').html(
                        $scope.property_information.selected_measurement_type
                );
                
                if(typeof objHome.OnUpdatingCurrency !== 'undefined')
                {
                   objHome.removeCurrencyObserver($scope.update_currency_callback);
                   objHome.addCurrencyObserver($scope.update_currency_callback); 
                   objHome.OnUpdatingCurrency($scope.property_information.Price,
                  $scope.property_information.currency, null);
                    
                  $('#btn_measurement_type').click(function() 
                    {
                        measurement_type_change_click();
                    });
                  $('#btn_change_measurement').click(
                    function()
                    {
                        on_change_measurement_type();
                    }
                  );
                }
                $scope.isMobile = function()
                {
                    return objHome.isMobile().any();
                };
                $('#select_property_measurement').val($('.lbl_measurement_type').text());
                on_change_measurement_type();
                
                 $('#popup_google_location').on('hidden.bs.modal', function () {
                    
                    $('#frameMap').attr('src', ""); 
                 });
                
                
                if(objHome.getCurrentPosition().latitude !== null)
                {
                      $scope.my_position = objHome.getCurrentPosition();
                      
                }
                else
                {
                      if (navigator.geolocation) {
                          navigator.geolocation.getCurrentPosition(objHome.setCurrentPosition);
                     }
                     $scope.my_position = objHome.getCurrentPosition();
                     $scope.$apply();
                }
            }   
        );
            
});

var photo_paging = function()
{
    $("#books").height($(window).height() * 60 / 100);
    $('#books').turn({
        display: 'single',
        acceleration: true,
        gradients: true,
        elevation: 50,
        corners: 'all',
        when: {
            turned: function(e, page) {
                /*console.log('Current view: ', $(this).turn('view'));*/
                $(".description").fadeOut('fast', function() {
                });
            }
        }
    });

    $(".property_photo").on('mouseenter touchstart',
            function()
            {
                $(this).find(".description").fadeIn('slow', function() {

                });
            }
    );

    $(".property_photo").on("mouseleave touchend",
            function()
            {
                $(this).find(".description").fadeOut('fast', function() {

                });
            }
    );
};

var check_page = function(page, $scope)
{
    if ((page - 1) > 0) {
         $scope.has_prev_page = true;
    }
    else
    {
         $scope.has_prev_page = false;
    }
    if ($("#books").turn("hasPage", page + 1)) {
         $scope.has_next_page = true;
    }
    else
    {
        $scope.has_next_page = false;
    }
    //$scope.$apply();
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

var get_details_info = function(key, $scope)
{
    for(var i = 0; i < $scope.property_information["details"].length; i++)
    {
       for(var j = 0; j < $scope.property_information["details"][i].length; j++)
       {
            switch($scope.property_information["details"][i][j].id)
            {
                case key:
                    return $scope.property_information["details"][i][j].value;
                    
            }
       }
    }
};


$(window).resize(function()
{
    $("#books").height($(window).height() * 60 / 100);
    $("#books").turn("resize");
    $("#books").turn("size", $(".books_frame").width(), $(".books_frame").height());
});
$(window).bind('keydown', function(e) {

    if (e.keyCode === 37)
    {
        $('#books').turn('previous');
    }
    else if (e.keyCode === 39)
    {
        $('#books').turn('next');
    }

});

$(document).ready(function()
{
    $('.measurement_type_group').css('display', 'inline-block');
    
   
});
 
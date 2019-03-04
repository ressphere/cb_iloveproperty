/******************************************************************************
 * This is to contain all JS that related to porperty search page
 ******************************************************************************/
/*
 * To do list
 *    - link to detail page when data click
 *    - Hide side bar and change it to button when in small size (talk to cm)
 *    - Cut naming when exceed string number
 *    - Search include ',' and remove it when pass to WS
 */

// ================== Angular Implementation ====== Start ==============
var searchrst_information = angular.module("SearchHighLightApp",[]);

searchrst_information.controller("FilterSearchHighLightCtrl", function($scope, $http){
    
    // ------ Variable declare and initialize section --- Start ----------------
    // Base object
    $scope.ObjBase = {};
    
    // Settings for information query
    $scope.base_url = "";   // Will initialize at the angular document ready
    $scope.information_url = "index.php/_utils/properties_info";
    $scope.data_ready = 0;
    //$scope.measurement_type = "sqft";
    
    $scope.property_information = 
    {
        "origin_measurement_type": "sqft",
	"selected_measurement_type":"sqft",
        "list_of_unit_conversion": [
            {
                    'value':'sqft',
                    'display':'Square feet (sqft)'
            },
            {
                    'value':'m2',
                    'display':'Square metres (m2)'
            }
        ]
    };
    
    // location section and default for serach
    $scope.selected_country = "Malaysia";
    $scope.selected_state = "Pulau Pinang";
    $scope.location_list = [];
    $scope.currency = "MYR";
            
    // Filter property type
    $scope.property_category_type_list = ["All Type"];
    $scope.property_category_selection = "All Category";
    $scope.property_type_selection = "All Type";
    
    // Search result 
    $scope.highlight = [];
    $scope.search = [];
    $scope.total_result = 0;
    $scope.cur_display_min = 0;
    $scope.cur_display_max = 0;
    
    // Pagination - info
    $scope.nav_page = 1;    // Obtain from selection
    $scope.nav_total_page = 0;  // Obtain from server
    $scope.nav_search_base_url = "";    // Will initialize at the angular document ready

    // Pagination - Settings
    $scope.nav_left_num_margin = 1;
    $scope.nav_max_page_display = 8;
    $scope.nav_first_num = 1; // Will be recal when page update
     $scope.update_currency_callback = {
	update :{ 
            apply: function(price, currency, index) {
                var objHome = StaticHomeObject.getInstance();
                
                $scope.update_currency(price, currency, objHome.get_fav_currency(), index);
               
            }
        }
   
    };
    var update_price_search_range = function($scope, $from, $to)
    {
        var objHome = StaticHomeObject.getInstance();        
        //start change the currency here
        var base_path = objHome.getBaseUrl();
        var _url = String.format("{0}index.php/properties_details/get_converted_currency_value", base_path);
        

        $(".label_currency").each(function()
        {
            $(this).html($to);
        });
        var senddata = "currency_value="+ $scope.ui_min_price + 
                    "&from_currency=" + $from +
                    "&to_currency=" + $to;
   
        if($scope.ui_min_price > 0)
        {
            $http({
                method: 'POST',
                url: _url,
                data: senddata,
                cache: true,
                async: false,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
              }).then(function successCallback(response) {
                      var converted_price = response.data;
                      if($.isNumeric(converted_price))
                      {
                        $('#ui_min_price').val(converted_price);
                      }
                 }, function errorCallback(response) {
                      console.log('internal error');
            });
        }
        senddata = "currency_value="+ $scope.ui_max_price + 
                    "&from_currency=" + $from +
                    "&to_currency=" + $to;
        if($scope.ui_max_price > 0)
        {
            $http({
                method: 'POST',
                url: _url,
                data: senddata,
                cache: true,
                async: false,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
              }).then(function successCallback(response) {
                      var converted_price = response.data;
                      if($.isNumeric(converted_price))
                      {
                        $('#ui_max_price').val(converted_price);
                      }
                 }, function errorCallback(response) {
                      console.log('internal error');
            });
        }
    };
    var update_price = function($scope,price, $from, $to, $i)
    {
        var objHome = StaticHomeObject.getInstance();
        var senddata = "currency_value="+price + 
                "&from_currency=" + $from +
                "&to_currency=" + $to;
       
        //start change the currency here
        var base_path = objHome.getBaseUrl();
        var _url = String.format("{0}index.php/properties_details/get_converted_currency_value", base_path);
        $http({
            method: 'POST',
            url: _url,
            data: senddata,
            cache: true,
            async: false,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
          }).then(function successCallback(response) {
                  var converted_price = response.data;
                  $scope.search[$i].converted_price = $to + " " +converted_price;
                  if($scope.search[$i].disableTagButton['visibility'] === 'hidden')
                  {
                        $scope.search[$i].disableTagButton = {'visibility': 'visible'};
                  }
             }, function errorCallback(response) {
                  console.log('internal error');
        });
    };
    
    $scope.update_currency = function(price, $from, $to, $i)
    {
        
        if(typeof $i === "undefined" || $i === null)
        {
           update_price_search_range($scope, $('#btn_currency_type').text(), $to);
           for(var i = 0; i < $scope.search.length; i++)
           {
               update_price($scope,$scope.search[i].price, $scope.search[i].currency, $to, i);
           }
        }
        else
        {
            update_price_search_range($scope, $from, $to);
            update_price($scope,price, $from, $to, $i);
        }
        
        
    };
    
    $scope.get_history_data_from_storage = function()
    {
            // Query cookies to see any pre-record data
            $query_cookies = $.jStorage.get("search_data_scope_array");
            if($query_cookies !== null)
            {
                $query_cookies_array = JSON.parse($query_cookies);
                if (document.URL === $query_cookies_array.path)
                {
                    if($query_cookies_array.selected_country !== null){ $scope.selected_country = $query_cookies_array.selected_country;}
                    if($query_cookies_array.selected_state !== null){ $scope.selected_state = $query_cookies_array.selected_state;}
                    if($query_cookies_array.property_category_selection !== null){ $scope.property_category_selection = $query_cookies_array.property_category_selection;}
                    if($query_cookies_array.property_type_selection !== null){ $scope.property_type_selection = $query_cookies_array.property_type_selection;}
                    if($query_cookies_array.nav_page !== null){ $scope.nav_page = $query_cookies_array.nav_page;}
                    if($query_cookies_array.place_name !== null){ $scope.ui_place_name = $query_cookies_array.place_name;}
                    if($query_cookies_array.min_price !== null){ $scope.ui_min_price = $query_cookies_array.min_price;}
                    if($query_cookies_array.max_price !== null){ $scope.ui_max_price = $query_cookies_array.max_price;}
                    if($query_cookies_array.min_sqft !== null){ $scope.ui_min_sqft = $query_cookies_array.min_sqft;}
                    if($query_cookies_array.max_sqft !== null){ $scope.ui_max_sqft = $query_cookies_array.max_sqft;}
                    if($query_cookies_array.bedroom !== null){ $scope.ui_bedroom = $query_cookies_array.bedroom;}
                }
            }
            if($scope.property_category_selection === "")
            {
                $scope.property_category_selection = "All Category";
            }
            if($scope.property_type_selection === "")
            {
                $scope.property_type_selection = "All Type";
            }
    };
    var sidebar_positioning = function()
    {
        var toolbar_height = $(".navbar").height() + $("#property_header_nav_bar").height();
        // For displaying new UI for properties details
        var toolbar_height_2 = $(".navbar").height() + $("#property_header_nav_bar").height() + $("#page-content-wrapper").height();
        //var footer_height = $("#bottom_footer").height();
        var new_height = $(this).height() - toolbar_height;
        var new_height_2 = $(this).height() - toolbar_height_2;
        $('#sidebar-wrapper, .sidebar_content').height(new_height);
        $('#property-details-wrapper').height(new_height_2);
        $('#property-details-wrapper').css('top', toolbar_height_2.toString() + "px");
        $('#sidebar-wrapper, .sidebar_content, .sidebar_toggle').css('top', toolbar_height.toString() + "px");
    };
    
    var search_result_positioning = function()
    {
        var toolbar_height = $(".navbar").height() + $("#property_header_nav_bar").height();
        $('#page-content-wrapper').css('margin-top', toolbar_height.toString() + "px");
    };
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
    // ------ Variable declare and initialize section --- End ----------------
    // ------ UI Feature --- Start ----------------
    angular.element(document).ready(
        
        function()
        {  
            var original_sidebar_height = $("#sidebar-wrapper").height();
            // Decalre base object to access generic API
            $scope.ObjBase = $.makeclass(get_base());
            var ObjHome = StaticHomeObject.getInstance();
            // ------ Variable declare and initialize section --- Start ----------------
            // Initialize information that require base generic API
            $scope.base_url = $scope.ObjBase.getBaseUrl();
            $scope.nav_search_base_url = $scope.base_url+"index.php/properties_search";
            $scope.information_url =  $scope.base_url+"/"+$scope.information_url;
            
            
            // Detfault countries and state list
            $scope.ObjBase.url_data_invoker($http, $scope.information_url, "obtain_location_list" , "").then(function(location_json){
                $scope.location_list = location_json["location_list"];
                $scope.selected_country = location_json["selected_country"];
                $scope.selected_state = location_json["selected_state"];
                $scope.property_category_type_list = location_json["property_category_type_list"];
                $scope.property_category_selection = location_json["property_category_selection"];
                $scope.property_type_selection = location_json["property_type_selection"];
                $scope.get_history_data_from_storage();
            });
            
            // Currencies list
            $scope.ObjBase.url_data_invoker($http, $scope.information_url, "obtain_currencies_list" , "").then(function(currencies){
                $scope.currencies_list = currencies;
            });
            $scope.get_history_data_from_storage();
            
            // Highlight settings
            $scope.obtain_highlight_data();

            // Result settings
            $scope.obtain_result_data();

            // ------ Variable declare and initialize section --- End ----------------
            
            // ------ Button Interaction --- Start ----------------
            // Filter info type Button group handler
            $('.filter_info_button').click(function(){
                // Remove the active class tag regardless on which is set as active
                 $('.filter_info_button').removeClass("active");

                 // Allow the click button have the active effect
                 $("#"+this.id).addClass("active");   

                 // Extract Property type from id, remove prefix "property_type_btn_"
                 var property_type = this.id;
                 property_type = property_type.replace("property_type_btn_","");

                 // Update page information
                 //obj_page_information.setPropertyType(property_type);

                 // Reset navgation page and refresh data
                 $scope.nav_page = 1;
                 $scope.obtain_highlight_data();
                 $scope.obtain_result_data();

             });

             // Search button handler
             $("#filter_info_confrim_btn").click(function(){
                 // Data read back is at the API itself
                 $scope.nav_page = 1;
                 $scope.obtain_highlight_data();
                 $scope.obtain_result_data();
                 
                 //alert(obj_page_information.getPropertyType());
                 //console.log($scope.search_property_type);
             });

	    $(window).resize(function()
                {
                    var objBase = $.makeclass(get_base());
                    waitForFinalEvent(function() {
                            sidebar_positioning();
                            search_result_positioning();
                            objBase.set_footer_position();
                            delete objBase;
                        }, 100, objBase.generateUUID());
                      
                }

            );
	    waitForFinalEvent(function() {
               sidebar_positioning();
               search_result_positioning();
               $scope.ObjBase.set_footer_position();
	    }, 100, $scope.ObjBase.generateUUID());
            
            $('.measurement_type_group').css('display', 'inline-block');

            var measurement_type = ObjHome.get_fav_measurement_type();
            
            if(measurement_type !== null)
            {
                $('.lbl_measurement_type').text(measurement_type);
                 $scope.property_information.selected_measurement_type = 
                            measurement_type;
                 ObjHome.set_fav_measurement_type(measurement_type);
            }
            else
            {
                $('.lbl_measurement_type').text($scope.property_information.selected_measurement_type);
                ObjHome.set_fav_measurement_type($scope.property_information.selected_measurement_type);
            }
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
             $("#menu-toggled").click(function(e) {
                        e.preventDefault();
                        $("#sidebar-wrapper").toggleClass("toggled");
                        $(".sidebar_content").toggleClass("toggled");
                        $(".sidebar_toggle").toggleClass("toggled");
                        $("#page-content-wrapper").toggleClass("toggled");
                });
           
             
             // ------ Button Interaction --- End ----------------
        }
    );
    // ------ UI Feature --- End ----------------
    
    // ------ Angular API --- Start ----------------
    // Retrieve data for the highlight portion base on current settings
    $scope.obtain_highlight_data = function(){
        // Obtain necessary data and pack them
        input_data = {};
        input_data.property_category_selection = $scope.property_category_selection;
        input_data.property_type_selection = $scope.property_type_selection;
        
        //console.log(input_data);
        $scope.ObjBase.url_data_invoker($http, $scope.information_url, "obtain_highlight_result" , input_data).then(function(highlight_json){
            //console.log(highlight_json);
            $scope.highlight = highlight_json;
        });
    };
    
    // Retrieve data for the search result base on current settings
    $scope.obtain_result_data = function(){
        // Obtain necessary data and pack them
        // Require the data up to date before start query
        input_data = {};
        input_data.selected_country = $scope.selected_country;
        input_data.selected_state = $scope.selected_state;
        input_data.property_category_selection = $scope.property_category_selection;
        input_data.property_type_selection = $scope.property_type_selection;
        input_data.nav_page = $scope.nav_page;
        input_data.place_name = $scope.ui_place_name;
        input_data.min_price = $scope.ui_min_price;
        input_data.max_price = $scope.ui_max_price;
        input_data.min_sqft = $scope.ui_min_sqft;
        input_data.max_sqft = $scope.ui_max_sqft;
        
        input_data.measurement_type = $scope.property_information.selected_measurement_type;
        input_data.bedroom = $scope.ui_bedroom;
        input_data.currency = $('#btn_currency_type').text();
        
        $scope.data_ready = 0;
        $scope.ObjBase.url_data_invoker($http, $scope.information_url, "obtain_search_result" , input_data).then(function(result_json){
            $scope.search = result_json["search_result"];
            $scope.nav_total_page = result_json["nav_total_page"];
            $scope.total_result = result_json["total_result"];
            
            $scope.cur_display_min = (($scope.nav_page-1) * ($scope.nav_max_page_display+1)) +1;
            $max_dis_number = ($scope.nav_page) * ($scope.nav_max_page_display+1);
            $scope.cur_display_max = ($max_dis_number >= $scope.total_result) ? $scope.total_result : $max_dis_number;

            $scope.refresh_nav_frist_num();
            $scope.data_ready = 1;
            var objHome = StaticHomeObject.getInstance();
            //console.log($scope.search);
            objHome.removeCurrencyObserver($scope.update_currency_callback);
            objHome.addCurrencyObserver($scope.update_currency_callback);
            
            if($scope.search.length === 0)
            {
                update_price_search_range($scope, $scope.currency, input_data.currency);
            }
            else
            {
                $('#select_property_measurement').val(objHome.get_fav_measurement_type());
                on_change_measurement_type();
                for(var i = 0; i < $scope.search.length; i++)
                {
                    $scope.search[i].converted_size = $scope.search[i].sqft;
                    $scope.search[i].disableTagButton = {'visibility': 'hidden'};
                    $scope.search[i].converted_price = $scope.search[i].price;
                    
                    var price = $scope.search[i].price;
                    var currency = $scope.search[i].currency;
                    objHome.OnUpdatingCurrency(price, currency, i);
                }
            }
             
            waitForFinalEvent(function() {
                
                sidebar_positioning();
                search_result_positioning();
                $scope.ObjBase.set_footer_position();
                
            }, 100, $scope.ObjBase.generateUUID());
        });
       
        input_data.path = document.URL;
        $.jStorage.set("search_data_scope_array", JSON.stringify(input_data));
        $("body").scrollTop(0);
    };
    
    // Country and state button action
    $scope.update_contry_state = function(country, state) 
    {
        // Update data
        $scope.selected_country = country;
        $scope.selected_state = state;
        
        // Refresh result
        $scope.obtain_highlight_data();
        $scope.obtain_result_data();
    };
    
    // Country and state button action
    $scope.property_type_dp_click = function(dp_category, dp_selection) 
    {
        if (dp_selection === "")
        {
            dp_selection = "All Type";
        }
        
        // Update data
        $scope.property_category_selection = dp_category;
        $scope.property_type_selection = dp_selection;
        //alert(dp_selection);
    };
    
    // Page Navigation button action
    $scope.page_nav = function(action, num) 
    {
        if (action === "prev") {
            $scope.nav_page = $scope.nav_page - num;
        }
        else if (action === "next") {
            $scope.nav_page = $scope.nav_page + num;
        }
        else {
            $scope.nav_page = num;
        }
        
        // Refresh data
        $scope.refresh_nav_frist_num();
        $scope.obtain_result_data();
    };
    
    // location section - determine which collapse need expend
    $scope.is_requie_expend_country = function(current_country){
        return current_country === $scope.selected_country ? "in": "";
    };

    // location section - determine which state should be highlight
    $scope.is_requie_highlight_state = function(current_country, current_state){
        return current_country === $scope.selected_country ? 
            current_state === $scope.selected_state ? "active" : "" : "";
    };

    // location section - Name change to id or class usable
    $scope.change_to_id_class = function(name){
        return name.replace(/\s+/, "_");
    };
    
    // Search result - picture and info position
    $scope.get_position = function(type, display_type) {
        if (type === "info") {
            if(display_type === 1) {
                position = "bottom";
            } 
            else {
                position = "top";
            }
        }
        else {
            if(display_type === 1) {
                position = "top";
            } 
            else {
                position = "bottom";
            }
        }
        return position;
    };
    
    // Pagination - cal first display number
    $scope.refresh_nav_frist_num = function(){
        $scope.nav_first_num = 
        $scope.nav_page - $scope.nav_left_num_margin < 1 ?
              1
            : $scope.nav_page - $scope.nav_left_num_margin + $scope.nav_max_page_display > $scope.nav_total_page ?
                  $scope.nav_total_page - $scope.nav_max_page_display < 1 ?
                      1
                    : $scope.nav_total_page - $scope.nav_max_page_display + 1
                : $scope.nav_page - $scope.nav_left_num_margin;
    };
    
    // Pageination - to highlight the current page number
    $scope.active_current_page_number= function($display_num, $cur_num) {
        if ($display_num === $cur_num) {return "active";}
        else {return "";}
    };
    
    // Pagination - function to retrieve number for looping
    $scope.getNumber = function(num) {
        return new Array(num);
    };
    
    $scope.detail_page_load = function(ref_tag) {
        window.location.href = $scope.base_url+"index.php/properties_details?reference="+ref_tag;
    };
    
    var begin_change_measurement_value = function(measurement_value, measurement_index, 
        from, to, base_path, $scope)
    {
        var senddata = "measurement_value="+measurement_value + 
                "&from_measurement_type=" + from +
                "&to_measurement_type=" + to;
        var _url = String.format("{0}index.php/properties_details/get_converted_measurement_value", base_path);
        $http({
            method: 'POST',
            url: _url,
            data: senddata,
            cache: true,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
          }).then(function successCallback(response) {
               //setup_details_info(measurement_id, accounting.toFixed(response.data, 5) , $scope);
               $scope.search[measurement_index].converted_size = to + " " + accounting.toFixed(response.data, 5);
               
               $scope.property_information.selected_measurement_type = to;
               
          },function errorCallback(response) {
                    console.log('internal error');
             }
          );
    };
    
    var update_measurement_range = function($scope, from, to)
    {
        var size_range_list = {"min":$scope.ui_min_sqft, "max":$scope.ui_max_sqft};
        var objHome = StaticHomeObject.getInstance();
        var base_path = objHome.getBaseUrl();
        for (var key in size_range_list)
        {
            if(isNaN(size_range_list[key]))
            {
                continue;
            }
            var senddata = "measurement_value="+ size_range_list[key] + 
                "&from_measurement_type=" + from +
                "&to_measurement_type=" + to;
            var _url = String.format("{0}index.php/properties_details/get_converted_measurement_value", base_path);
            $http({
                method: 'POST',
                url: _url,
                data: senddata,
                cache: true,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(response) {
                   
                   if(key === "min")
                   {
                       $scope.ui_min_sqft = accounting.toFixed(response.data, 5);
                   }
                   else
                   {
                       $scope.ui_max_sqft = accounting.toFixed(response.data, 5);
                   }
                },function errorCallback(response) {
                    console.log('internal error');
                }
            );
        }
        
    };
    var on_change_measurement_type = function()
    {

        var objHome = StaticHomeObject.getInstance();
        var base_path = objHome.getBaseUrl();
        
        objHome.set_fav_measurement_type($('#select_property_measurement').val());
        $('.lbl_measurement_type').text($('#select_property_measurement').val());
        update_measurement_range($scope, $scope.property_information.selected_measurement_type, $('#select_property_measurement').val());
        for(var i = 0; i < $scope.search.length; i++)
        {
            var origin_measurement_type = $scope.search[i].measurement_type;
            var origin_measurement_value = $scope.search[i].sqft;
            begin_change_measurement_value(origin_measurement_value, 
                i, 
                origin_measurement_type, 
                $('#select_property_measurement').val(),
                base_path,
                $scope);
        }
    
        $scope.property_information.selected_measurement_type = $('#select_property_measurement').val();
    };
    
    var objHome = StaticHomeObject.getInstance();
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
     
    }
    
    
    // ------ Angular API --- End ----------------
});
// ================== Angular Implementation ====== End ================
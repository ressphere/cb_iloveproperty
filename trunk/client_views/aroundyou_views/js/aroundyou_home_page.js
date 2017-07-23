/******************************************************************************
 * This is for aroundyou header - angularjs
 ******************************************************************************/
// <editor-fold desc="set google nearby place radius and type(special for property)"  defaultstate="collapsed">
/*
aroundyou_base_apps.config(function(ngGPlacesAPIProvider, $compileProvider) {
    
});
*/
/*
aroundyou_base_apps.config(function(ngGPlacesAPIProvider, $compileProvider) {
            $compileProvider.aHrefSanitizationWhitelist(/^\s*(geo|https?|ftp|mailto|chrome-extension):/);
            ngGPlacesAPIProvider.setDefaults({
                radius: 1000,
                types: ['bank', 'school', 'shopping_mall', 'hospital', 'airport', 'subway_station', 'bus_station', 'train_station',
                    'university', 'taxi_stand', 'gas_station'],
                nearbySearchKeys: ['name', 'reference', 'vicinity', 'types', 'icon']
        });
});*/
// </editor-fold>

// ================== Angular Implementation ====== Start ==============

/* 
 *  This directive is use to adjust width of the google map and sidetab width 
 *    and hight to match the browser 
 */
aroundyou_base_apps.directive('resize', function ($window) {
    return function (scope, element) {
        var w = angular.element($window);
        scope.getWindowDimensions = function () {
            return {
                'h': w.height(),
                'w': w.width()
            };
        };
        scope.$watch(scope.getWindowDimensions, function (newValue, oldValue) {
            // Google map 
            scope.style_aroundyou_google_map = function () {
                return {
                    'height': (newValue.h - (57 + 40)) + 'px',
                };
            };
            // side tab hight
            scope.style_aroundyou_sidetab = function () {
                return {
                    'height': (newValue.h - (57 + 40)) + 'px',
                };
            };
            scope.style_aroundyou_sidetab_scrollable = function () {
                return {
                    'height': (newValue.h - (57 + 40 + 64)) + 'px',
                };
            };
        }, true);
        
        w.bind('resize', function () {
            scope.$apply();
        });
    };
});


/*
 *  Follwing are the controller contain all the main function
 */
aroundyou_base_apps.controller('aroundyou_home__ng__CONTROLLER', function($scope, uiGmapGoogleMapApi)
{
    // ------ Variable declare and initialize section --- Start ----------------
    $scope.aroundyou_base_obj = AroundYou_base__base_Object.getInstance();
    // Field use variable
    $scope.base_url = $scope.aroundyou_base_obj.getBaseUrl();
    
    // Initial value for sidetab button
    $scope.aroundyou_sidetab_show_search = true;
    $scope.aroundyou_sidetab_show_result = false;
    $scope.aroundyou_sidetab_show_event = false;
    
    // Initial and default value for sidetab search distance 
    $scope.aroundyou_sidetab_distance_value = 500;
    $scope.aroundyou_sidetab_distance_min = 100;
    $scope.aroundyou_sidetab_distance_max = 1000;
    
    // Center coordinate point
    $scope.g_center_latitude = 5.416665;
    $scope.g_center_longitude = 100.3166654;
    
    // Google Map related default. 
    $scope.map = { center: { latitude: $scope.g_center_latitude, longitude: $scope.g_center_longitude }, zoom: 16 }; 
    $scope.aroundyou_sidetab_search_dropbox_map_value = "k:5.416665::b:100.3166654"; // George Town value
    $scope.aroundyou_google_map_center_marker = {idkey: "center_marker", coords: {latitude: $scope.g_center_latitude, longitude: $scope.g_center_longitude}, icon: $scope.base_url+'/images/aroundyou_marker_current_point.png'};
    
    // Contain search result. @todo - need to move this to backend
    $scope.aroundyou_search_result_markers = [
     {id: 1, title: 'm1', 
         latitude: $scope.aroundyou_base_obj.latitude_longitude_converter($scope.g_center_latitude, 500, "latitude", "up"), 
         longitude:$scope.g_center_longitude, 
         icon: $scope.base_url+'/images/aroundyou_marker_result_point.png'},
     {id: 2, title: 'm2', 
         latitude: $scope.aroundyou_base_obj.latitude_longitude_converter($scope.g_center_latitude, 500, "latitude", "down"), 
         longitude:$scope.g_center_longitude, 
         icon: $scope.base_url+'/images/aroundyou_marker_result_point.png'},
     {id: 3, title: 'm3', 
         latitude: $scope.g_center_latitude, 
         longitude: $scope.aroundyou_base_obj.latitude_longitude_converter($scope.g_center_longitude, 500, "longitude", "left"), 
         icon: $scope.base_url+'/images/aroundyou_marker_result_point.png'},
     {id: 4, title: 'm4', 
         latitude: $scope.g_center_latitude, 
         longitude:$scope.aroundyou_base_obj.latitude_longitude_converter($scope.g_center_longitude, 500, "longitude", "right"),  
         icon: $scope.base_url+'/images/aroundyou_marker_result_point.png'},
     {id: 5, title: 'm5', 
         latitude: $scope.aroundyou_base_obj.latitude_longitude_converter($scope.g_center_latitude, 1000, "latitude", "up"), 
         longitude:$scope.g_center_longitude, 
         icon: $scope.base_url+'/images/aroundyou_marker_result_point.png'},
     {id: 6, title: 'm6', 
         latitude: $scope.aroundyou_base_obj.latitude_longitude_converter($scope.g_center_latitude, 1000, "latitude", "down"), 
         longitude:$scope.g_center_longitude, 
         icon: $scope.base_url+'/images/aroundyou_marker_result_point.png'},
     {id: 7, title: 'm7', 
         latitude: $scope.g_center_latitude, 
         longitude: $scope.aroundyou_base_obj.latitude_longitude_converter($scope.g_center_longitude, 1000, "longitude", "left"), 
         icon: $scope.base_url+'/images/aroundyou_marker_result_point.png'},
     {id: 8, title: 'm8', 
         latitude: $scope.g_center_latitude, 
         longitude:$scope.aroundyou_base_obj.latitude_longitude_converter($scope.g_center_longitude, 1000, "longitude", "right"),  
         icon: $scope.base_url+'/images/aroundyou_marker_result_point.png'}
    ];
    
    $scope.aroundyou_google_search_rectangle ={
        sw: {
            latitude: $scope.aroundyou_base_obj.latitude_longitude_converter($scope.g_center_latitude, 500, "latitude", "up"),
            longitude: $scope.aroundyou_base_obj.latitude_longitude_converter($scope.g_center_longitude, 500, "longitude", "left")
        },
        ne: {
            latitude: $scope.aroundyou_base_obj.latitude_longitude_converter($scope.g_center_latitude, 500, "latitude", "down"),
            longitude: $scope.aroundyou_base_obj.latitude_longitude_converter($scope.g_center_longitude, 500, "longitude", "right")
        } 
    };
    
    
    // Holder for search state and area, k is latitude, b is longitude, @todo - need to move this to backend
    $scope.aroundyou_sidetab_state_area =[{
                            "state": "Penang",
                            "area_list": [
                                {name:"George Town", location:"k:5.416665::b:100.3166654"},
                                {name:"Gelugor", location:"k:5.3569197::b:100.2860428"},
                                {name:"Batu Maung", location:"k:5.2859622::b:100.2813038"},
                            ]
                        },{
                            "state": "Johor",
                            "area_list": [
                                {name:"Kluang", location:"k:2.0246141::b:103.2360842"},
                                {name:"Kulai", location:"k:1.6507705::b:103.5484342"},
                                {name:"Sukdai", location:"k:1.5388621::b:103.6188152"},
                            ]
                        }];
    
    // Holder for search categories, @todo - need to move this to backend
    $scope.aroundyou_sidetab_group_categories =[{
                            "group": "Restaurant",
                            "categories_list": [
                                "Asian Cuisine",
                                "western Cuisine",
                                "Fusion Cuisine"
                            ]
                        },{
                            "group": "Car",
                            "categories_list": [
                                "Petrol Station",
                                "Car Wash",
                                "Car Part shop"
                            ]
                        }];
                    
    // ------ Variable declare and initialize section --- End ----------------
    
    // ------ UI Feature --- Start ----------------
    angular.element(document).ready(
        function()
        {
            
        }
    );
    // ------ UI Feature --- End ----------------
    
    // ------ Google map Feature --- Start ----------------
    // Update google map according to selected location
    $scope.aroundyou_sidetab_dropbox_map = function(map_location) {
        // Decode that location string, e.g. k:5.2751849::b:100.2496362,14
        var location = map_location.split("::");
        var k_latitude = location[0].split(":")[1];
        var b_longitude = location[1].split(":")[1];
        //console.log("k_latitude is "+k_latitude+" b_longitude is "+b_longitude);
        
        // Update map accordingly
        $scope.map = { center: { latitude: k_latitude, longitude: b_longitude }, zoom: 15 };
        
        // Update center search marker
        $scope.aroundyou_google_map_center_marker.coords = {latitude: k_latitude, longitude: b_longitude};
    
    };
    
    // @todo - link up the marker
    // @todo - update search marker and square box, 
    // @todo - fix the scroll initial location of bullete wrong issue
    // 
    // @todo - remove reference code, which this can be use to change or read the center of the map
    //    $scope.map = { center: { latitude: 6.416665, longitude: 102.3166654 }, zoom: 15 };  
    // ------ Google map Feature --- End ----------------
    
    // ------ Angular API --- Start ----------------
    // To handle sidebar toogling
    $scope.aroundyou_sidebar_toggle = function(){
        $(".aroundyou_sidetab_div").toggleClass("ng-hide");
        $(".aroundyou_toogle_sidebar_btn_div").toggleClass("ng-hide");
    };
    
    // To handle sidebar top button toogling
    $scope.aroundyou_sidebar_top_btn = function(btn_type){
        
        // Reset everything
        $("#aroundyou_sidetab_top_search_btn").removeClass("highlight");
        $("#aroundyou_sidetab_top_result_btn").removeClass("highlight");
        $("#aroundyou_sidetab_top_event_btn").removeClass("highlight");
        
        $(".aroundyou_sidetab_content_search_div").addClass("ng-hide");
        $(".aroundyou_sidetab_content_result_div").addClass("ng-hide");
        $(".aroundyou_sidetab_content_event_div").addClass("ng-hide");
        
        // Group enable per specified type of btn click
        if (btn_type === "search")
        {
            $("#aroundyou_sidetab_top_search_btn").addClass("highlight");
            $(".aroundyou_sidetab_content_search_div").removeClass("ng-hide");
        }
        else if (btn_type === "result")
        {
            $("#aroundyou_sidetab_top_result_btn").addClass("highlight");
            $(".aroundyou_sidetab_content_result_div").removeClass("ng-hide");
        }
        else if (btn_type === "event")
        {
            $("#aroundyou_sidetab_top_event_btn").addClass("highlight");
            $(".aroundyou_sidetab_content_event_div").removeClass("ng-hide");
        }
    }; 
    
    
    // ------ Angular API --- End ----------------
});
// ================== Angular Implementation ====== End ================

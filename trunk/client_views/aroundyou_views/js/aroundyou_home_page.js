/******************************************************************************
 * This is for aroundyou header - angularjs
 ******************************************************************************/
// <editor-fold desc="set google nearby place radius and type(special for property)"  defaultstate="collapsed">
/*
ng_map_profile.config(function(ngGPlacesAPIProvider, $compileProvider) {
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
aroundyou_base_apps.controller('aroundyou_home__ng__CONTROLLER', function(
        $scope)
{
    // ------ Variable declare and initialize section --- Start ----------------
    $scope.aroundyou_base_obj = AroundYou_base__base_Object.getInstance();
    // Field use variable
    $scope.base_url = $scope.aroundyou_base_obj.getBaseUrl();
    $scope.map = { center: { latitude: 5.416665, longitude: 100.3166654 }, zoom: 15 };  
    
    // Initial value for sidetab button
    $scope.aroundyou_sidetab_show_search = true;
    $scope.aroundyou_sidetab_show_result = false;
    $scope.aroundyou_sidetab_show_event = false;
    
    // Initial and default value for sidetab search distance 
    $scope.aroundyou_sidetab_distance_value = 25;
    $scope.aroundyou_sidetab_distance_min = 5;
    $scope.aroundyou_sidetab_distance_max = 50;
    
    // Holder for search state and area, @todo - need to move this to backend
    $scope.aroundyou_sidetab_state_area =[{
                            "state": "Penang",
                            "area_list": [
                                {name:"George Town", location:"k:5.416665::b:100.3166654"},
                                {name:"Gelugor", location:"k:5.3569197::b:100.2860428"},
                                {name:"Batu Maung", location:"k:5.2751849::b:100.2496362,14"},
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

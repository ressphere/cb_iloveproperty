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
 *  This directive is use to adjust width of the content
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
            scope.style = function () {
                return {
                    'height': (newValue.h - (57 + 40)) + 'px',
                    'width': (newValue.w - 100) + 'px'
                };
            };

        }, true);

        w.bind('resize', function () {
            scope.$apply();
        });
    }
})

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
    
    
     
    // ------ Variable declare and initialize section --- End ----------------
    
    // ------ UI Feature --- Start ----------------
    angular.element(document).ready(
        function()
        {
            //$('.aroundyou_google_map_div').css({ height: $(window).innerHeight() });
            
            // initialize google map
            //initialize_google_map(100, 20);
        }
    );
    // ------ UI Feature --- End ----------------
    
    // ------ Google map Feature --- Start ----------------
    /*
    $controller('google_maps', {$scope: $scope, ngGPlacesAPI: ngGPlacesAPI, flowFactory: flowFactory});
    $scope.map = { center: { latitude: 45, longitude: -73 }, zoom: 8 };
    
    $scope.get_ngGPlacesAPI = function()
    {
          return ngGPlacesAPI;
    };
    
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
    */
    // ------ Google map Feature --- End ----------------
    
    // ------ Angular API --- Start ----------------
    // ------ Angular API --- End ----------------
});
// ================== Angular Implementation ====== End ================

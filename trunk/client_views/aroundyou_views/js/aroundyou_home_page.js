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
aroundyou_base_apps.controller('aroundyou_home__ng__CONTROLLER', function(
        $scope)
{
    // ------ Variable declare and initialize section --- Start ----------------
    /*
    $scope.aroundyou_base_obj = AroundYou_base__base_Object.getInstance();
    alert("Dsfs");
    // Field use variable
    $scope.base_url = $scope.aroundyou_base_obj.getBaseUrl();
    */
    
    // ------ Variable declare and initialize section --- End ----------------
    
    // ------ UI Feature --- Start ----------------
    angular.element(document).ready(
        function()
        {
            alert("hihi");
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

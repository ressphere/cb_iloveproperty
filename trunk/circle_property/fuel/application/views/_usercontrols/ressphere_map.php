<script language='javascript' type='text/javascript'>

ng_map_profile.config(function(ngGPlacesAPIProvider) {
    ngGPlacesAPIProvider.setDefaults({
        radius: 1000,
        types: ['bank', 'school', 'shopping_mall', 'hospital', 'airport', 'subway_station', 'bus_station', 'train_station',
            'university', 'taxi_stand', 'gas_station'],
        nearbySearchKeys: ['name', 'reference', 'vicinity', 'types', 'icon']
    });
});

ng_map_profile.controller('ressphereMap', function($scope, $controller, ngGPlacesAPI, flowFactory, $http, $sce)
{
    if(typeof ngGPlacesAPI !== 'undefined')
        {
                $controller('google_maps', {$scope: $scope, ngGPlacesAPI:ngGPlacesAPI, flowFactory: flowFactory});
        }
        else
        {
                $controller('google_maps', {$scope: $scope, flowFactory: flowFactory});
        }
    
});
    
</script>
<div class="container" ng-app="ng_map_profile" ng-controller='ressphereMap'>
<div id="map_canvas" class="map_canvas_group" class="row clearfix">
   <ui-gmap-google-map center="map.center" zoom="map.zoom" draggable="false" 
                        options="options" control="googleMap">
        <ui-gmap-marker coords="marker.coords" options="marker.options" 
                events="marker.events" idkey="marker.id" control="googleMarker">


        </ui-gmap-marker>

    </ui-gmap-google-map>
</div>
</div>

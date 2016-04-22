<script>
    ng_map_profile.controller('ressphereMap', function($scope, $controller)
    {
        $controller('google_maps', {$scope: $scope});
        angular.element(document).ready(
        
        function()
        {
            $scope.geometry.lat = <?=$lat?>;
            $scope.geometry.lgt = <?=$lgt?>;
            $('.angular-google-map-container').height(<?php if(isset($height)) echo $height?>);
            $('.angular-google-map-container').width(<?php if(isset($width)) echo $width?>);
        });
  });

</script>
<div class="container" ng-app="user_profileApp" ng-controller='ressphereMap'>
    <div id="map_canvas" class="map_canvas_group" class="row clearfix">
       <ui-gmap-google-map center="map.center" zoom="map.zoom" draggable="false" 
                            options="options" control="googleMap">
            <ui-gmap-marker coords="marker.coords" options="marker.options" 
                    events="marker.events" idkey="marker.id" control="googleMarker">


            </ui-gmap-marker>

        </ui-gmap-google-map>
    </div>
</div>


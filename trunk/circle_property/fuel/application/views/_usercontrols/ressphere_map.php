<div class="container" ng-app="user_profileApp" ng-controller='google_maps'>
<div id="map_canvas" class="map_canvas_group" class="row clearfix">
   <ui-gmap-google-map center="map.center" zoom="map.zoom" draggable="false" 
                        options="options" control="googleMap">
        <ui-gmap-marker coords="marker.coords" options="marker.options" 
                events="marker.events" idkey="marker.id" control="googleMarker">


        </ui-gmap-marker>

    </ui-gmap-google-map>
</div>
</div>

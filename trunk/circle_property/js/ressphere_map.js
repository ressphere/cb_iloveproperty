var HomeControl = function (controlDiv, scope, ngGPlacesAPI) {

      // Set CSS styles for the DIV containing the control
      // Setting padding to 5 px will offset the control
      // from the edge of the map
      controlDiv.style.padding = '5px';

      // Set CSS for the control border
      var controlUI = document.createElement('div');
      controlUI.style.backgroundColor = 'white';
      controlUI.style.borderStyle = 'solid';
      controlUI.style.borderWidth = '2px';
      controlUI.style.cursor = 'pointer';
      controlUI.style.textAlign = 'center';
      controlUI.title = 'Click to set the map to Home';
      controlDiv.appendChild(controlUI);

      // Set CSS for the control interior
      var controlText = document.createElement('div');
      controlText.style.fontFamily = 'Arial,sans-serif';
      controlText.style.fontSize = '12px';
      controlText.style.paddingLeft = '4px';
      controlText.style.paddingRight = '4px';
      controlText.innerHTML = '<b>Point Here</b>';
      controlUI.appendChild(controlText);

      // Setup the click event listeners: simply set the map to
      // Chicago
      google.maps.event.addDomListener(controlUI, 'click', function() {
          scope.googleMarker.getGMarkers()[0].setPosition({lat: 
                      scope.map.center.latitude, 
                      lng: scope.map.center.longitude});
          scope.marker.coords.latitude = scope.map.center.latitude;
          scope.marker.coords.longitude = scope.map.center.longitude;
          scope.$apply();
      });

};


var GoogleMapControl = function (controlDiv, scope, ngGPlacesAPI) {

      // Set CSS styles for the DIV containing the control
      // Setting padding to 5 px will offset the control
      // from the edge of the map
      controlDiv.style.padding = '5px';

      // Set CSS for the control border
      var controlUI = document.createElement('div');
      controlUI.style.backgroundColor = 'white';
      controlUI.style.borderStyle = 'solid';
      controlUI.style.borderWidth = '2px';
      controlUI.style.cursor = 'pointer';
      controlUI.style.textAlign = 'center';
      controlUI.title = 'Go to google map';
      controlDiv.appendChild(controlUI);

      // Set CSS for the control interior
      var controlText = document.createElement('div');
      controlText.style.fontFamily = 'Arial,sans-serif';
      controlText.style.fontSize = '12px';
      controlText.style.paddingLeft = '4px';
      controlText.style.paddingRight = '4px';
      controlText.innerHTML = '<b>Google Maps</b>';
      controlUI.appendChild(controlText);

      // Setup the click event listeners: simply set the map to
      // Chicago
      google.maps.event.addDomListener(controlUI, 'click', function() {
          console.log(scope.googleMarker.getGMarkers()[0]);
           var latitude = scope.googleMarker.getGMarkers()[0].position.lat();
           var longitude = scope.googleMarker.getGMarkers()[0].position.lng();
           var url = String.format("https://www.google.com.my/maps/place/5%C2%B020'27.9%22N+100%C2%B018'31.0%22E/@{0},{1},17z/data=!3m1!4b1!4m2!3m1!1s0x0:0x0?hl=en",latitude ,longitude);
           
          window.open(url,
                '_blank'
          );
      });

};

var ng_map_profile = null;

ng_map_profile = angular.module('user_profileApp',['google-maps'.ns()]);

ng_map_profile.controller('google_maps', function($scope) {
        
        // <editor-fold desc="Google map and marker angular settings"  defaultstate="collapsed">
        // <editor-fold desc="Google map"  defaultstate="collapsed">
        $scope.geometry = {"lat": 5.37857,
                            "lgt": 100.3137089};
        $scope.map = {center: {latitude: $scope.geometry.lat, 
                               longitude: $scope.geometry.lgt }, 
                                zoom: 16 };
                            
        $scope.options = {scrollwheel: false};
        $scope.coordsUpdates = 0;
        $scope.dynamicMoveCtr = 0;

        // </editor-fold>
        // <editor-fold desc="Google map marker"  defaultstate="collapsed">
        $scope.marker = {
          id: 0,
          coords: {
                latitude: $scope.geometry.lat,
                longitude: $scope.geometry.lgt
          },
          //Set draggable to false to disable marker
          //Eg: $scope.marker.options.draggable = false;
          options: { draggable: false },
          events: { 

          }
        };
        $scope.googleMarker = {}; // this is filled when google map is initiated
        $scope.googleMap = {}; // this is filled when google map is initiated

        // <editor-fold desc="On map location changed"  defaultstate="collapsed">
        $scope.$watchCollection("geometry", function(newVal, oldVal){
                if (_.isEqual(newVal, oldVal))
                        return;
                $scope.map.center.latitude = $scope.geometry.lat;
                $scope.marker.coords.latitude = $scope.geometry.lat;
                $scope.map.center.longitude = $scope.geometry.lgt;
                $scope.marker.coords.longitude = $scope.geometry.lgt;

                $scope.googleMarker.getGMarkers()[0].setPosition({lat: 
                            parseFloat($scope.geometry.lat), 
                    lng: parseFloat($scope.geometry.lgt)});

        });
        // </editor-fold>
        // </editor-fold>
        // </editor-fold>
});

/******************************************************************************
 * This is the base JS, in which the only one doesn't contain Angularjs format
 *    - Please assert prefix "aroundyou_base__"
 ******************************************************************************/

/* This the the entry for the aroundyou base class obj
 * 
 * @returns obj AroundYou base object
 */
var AroundYou_base__base_Object = (function () {
        var aroundyou_base_obj;

        function create_AroundYou_base_Instance() {
            var aroundyou_base_obj = $.makeclass(get_aroundyou_base());
            return aroundyou_base_obj;
        }

        return {
            getInstance: function () {
                if (!aroundyou_base_obj) {
                    aroundyou_base_obj = create_AroundYou_base_Instance();
                }
                return aroundyou_base_obj;
            }
        };
})();

/* This is the AroundYou actual class, which wrap around server base class
 * Will need to cast to object before using this, please use AroundYou_base_Object as entries
 * 
 */
var get_aroundyou_base = function() {
        return {
            Extends: get_base(),
            Initialize: function( private ){       
                this.parent.Initialize();
                
                
            },
            Private:{
                
            },
            Public:{         
                     
            }
        };
 };


/*
 * Following are the common apps for aroundyou
 */

var aroundyou_base_apps = angular.module("aroundyou_base_apps",['ngAutocomplete', 'ngGPlaces', 'google-maps'.ns(),'ngSanitize']);

aroundyou_base_apps.controller('google_maps', function($scope, $http, ngGPlacesAPI) {
        // <editor-fold desc="Google place autocomplete angular settings"  defaultstate="collapsed">
        $scope.google_maps = {
                result:'',
                details: {geometry:{
                                location:{
                                        "k":3.140307520038235, 
                                        "B":101.6866455078125
                                }
                        }
                },
                options: {},
                area:'',
                autocomplete:'',
                form: {
                        type: 'Establishment',
                        bounds: {SWLat: 49, SWLng: -97, NELat: 50, NELng: -96},
                        country: 'my',
                        typesEnabled: false,
                        boundsEnabled: false,
                        componentEnabled: false,
                        watchEnter: true
                }
        };
        $scope.google_maps.options.watchEnter = $scope.google_maps.form.watchEnter;
        $scope.google_maps.options.country = $scope.google_maps.form.country;
        // </editor-fold>

        // <editor-fold desc="Google map and marker angular settings"  defaultstate="collapsed">
        // <editor-fold desc="Google map"  defaultstate="collapsed">
        $scope.map = {center: {latitude: 
                                        $scope.google_maps.details.geometry.location['k'], 
                                        longitude: $scope.google_maps.details.geometry.location['B'] }, 
                                zoom: 16 };
                            
        $scope.options = {scrollwheel: false};
        $scope.coordsUpdates = 0;
        $scope.dynamicMoveCtr = 0;

        // </editor-fold>
        // <editor-fold desc="Google map marker"  defaultstate="collapsed">
        $scope.marker = {
          id: 0,
          coords: {
                latitude: $scope.google_maps.details.geometry.location['k'],
                longitude: $scope.google_maps.details.geometry.location['B']
          },
          //Set draggable to false to disable marker
          //Eg: $scope.marker.options.draggable = false;
          options: { draggable: true },
          events: { 

          }
        };
        $scope.googleMarker = {}; // this is filled when google map is initiated
        $scope.googleMap = {}; // this is filled when google map is initiated

        // <editor-fold desc="On map location changed"  defaultstate="collapsed">
        $scope.$watchCollection("google_maps.details.geometry.location", function(newVal, oldVal){
                if (_.isEqual(newVal, oldVal))
                        return;
                $scope.map.center.latitude = $scope.google_maps.details.geometry.location.lat();
                $scope.marker.coords.latitude = $scope.google_maps.details.geometry.location.lat();
                $scope.map.center.longitude = $scope.google_maps.details.geometry.location.lng();
                $scope.marker.coords.longitude = $scope.google_maps.details.geometry.location.lng();

                $scope.googleMarker.getGMarkers()[0].setPosition({lat: $scope.map.center.latitude, lng: $scope.map.center.longitude});

        });
        // </editor-fold>
        // </editor-fold>
        // </editor-fold>
});
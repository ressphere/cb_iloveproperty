/******************************************************************************
 * This is for aroundyou header - angularjs
 ******************************************************************************/
angular.module('myApplicationModule', ['uiGmapgoogle-maps']).config(
    ['uiGmapGoogleMapApiProvider', function(GoogleMapApiProviders) {
        GoogleMapApiProviders.configure({
            china: true
        });
    }]
);

// ================== Angular Implementation ====== Start ==============
var aroundyou_home_agm = angular.module("aroundyou_home__ng__APP",['uiGmapgoogle-maps']);

aroundyou_home_agm.controller("aroundyou_home__ng__CONTROLLER", function($scope){
    // ------ Variable declare and initialize section --- Start ----------------
    $scope.aroundyou_base_obj = AroundYou_base__base_Object.getInstance();
    
    // Field use variable
    $scope.base_url = $scope.aroundyou_base_obj.getBaseUrl();
    $scope.map = { center: { latitude: 45, longitude: -73 }, zoom: 8 };
    
    // ------ Variable declare and initialize section --- End ----------------
    
    // ------ UI Feature --- Start ----------------
    angular.element(document).ready(
        function()
        {
            
        }
    );
    // ------ UI Feature --- End ----------------
    
    // ------ Angular API --- Start ----------------
    // ------ Angular API --- End ----------------
});
// ================== Angular Implementation ====== End ================
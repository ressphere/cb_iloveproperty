/******************************************************************************
 * This is for aroundyou header - angularjs
 ******************************************************************************/

// ================== Angular Implementation ====== Start ==============
var aroundyou_header_agm = angular.module("aroundyou_header__ng__APP",[]);

aroundyou_header_agm.controller("aroundyou_header__ng__CONTROLLER", function($scope){
    // ------ Variable declare and initialize section --- Start ----------------
    $scope.aroundyou_base_obj = AroundYou_base__base_Object.getInstance();
    
    // Field use variable
    $scope.base_url = $scope.aroundyou_base_obj.getBaseUrl();
    
    // ------ Variable declare and initialize section --- End ----------------
    
    // ------ UI Feature --- Start ----------------
    angular.element(document).ready(
        function()
        {
            $scope.aroundyou_base_obj.setup_auth_ui();
            $scope.aroundyou_base_obj.preload_login();
            $scope.aroundyou_base_obj.removeObserver(get_updated_category);
            $scope.aroundyou_base_obj.addObserver(get_updated_category);
            $scope.aroundyou_base_obj.update_category();
        }
    );
    // ------ UI Feature --- End ----------------
    
    // ------ Angular API --- Start ----------------
    // ------ Angular API --- End ----------------
});
// ================== Angular Implementation ====== End ================
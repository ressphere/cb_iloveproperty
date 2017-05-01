<div ng-controller="aroundyou_home__ng__CONTROLLER" >
    <!-- This handle google map display -->
    <div class="aroundyou_google_map_div" ng-style="style_aroundyou_google_map()" resize>
        <ui-gmap-google-map center='map.center' zoom='map.zoom'></ui-gmap-google-map>
    </div>

    <!-- This handle side tab button -->
    <div class="aroundyou_toogle_sidebar_btn_div">
        <button type="button" class="btn btn-default btn-xs" id="aroundyou_sidebar_btn" ng-click="aroundyou_sidebar_toggle()">
        </button>
    </div>
    
    <!-- This handle side tab display-->
    <div class="aroundyou_sidetab_div"ng-style="style_aroundyou_sidetab()" resize>
        
        <!-- This handle side tab top button -->
        <div class="btn-group aroundyou_sidetab_top_btn_div">
            <button type="button"  class="btn btn-primary aroundyou_sidetab_top_btn" id="aroundyou_sidetab_top_collapse_btn" ng-click="aroundyou_sidebar_toggle()"></button>
            <button type="button"  class="btn btn-primary aroundyou_sidetab_top_btn highlight" id="aroundyou_sidetab_top_search_btn" ng-click="aroundyou_sidebar_search_btn()"></button>
            <button type="button"  class="btn btn-primary aroundyou_sidetab_top_btn" id="aroundyou_sidetab_top_result_btn"ng-click="aroundyou_sidebar_result_btn()"></button>
            <button type="button"  class="btn btn-primary aroundyou_sidetab_top_btn" id="aroundyou_sidetab_top_event_btn" ng-click="aroundyou_sidebar_event_btn()"></button>   
        </ul>
 
    </div>
    
</div>

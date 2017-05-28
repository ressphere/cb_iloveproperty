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
    <div class="aroundyou_sidetab_div ng-hide" ng-style="style_aroundyou_sidetab()" resize>
        
        <!-- This handle side tab top button -->
        <div class="btn-group aroundyou_sidetab_top_btn_div">
            <button type="button"  class="btn btn-primary aroundyou_sidetab_top_btn" id="aroundyou_sidetab_top_collapse_btn" ng-click="aroundyou_sidebar_toggle()"></button>
            <button type="button"  class="btn btn-primary aroundyou_sidetab_top_btn highlight" id="aroundyou_sidetab_top_search_btn" ng-click="aroundyou_sidebar_search_btn()"></button>
            <button type="button"  class="btn btn-primary aroundyou_sidetab_top_btn" id="aroundyou_sidetab_top_result_btn" ng-click="aroundyou_sidebar_result_btn()"></button>
            <button type="button"  class="btn btn-primary aroundyou_sidetab_top_btn" id="aroundyou_sidetab_top_event_btn" ng-click="aroundyou_sidebar_event_btn()"></button>   
        </div>
 
        
        <div class="aroundyou_sidetab_scrollable_div" ng-style="style_aroundyou_sidetab_scrollable()" resize>
            <!-- This handle side tab content -- search tab -->
            <div class="aroundyou_sidetab_scrollable aroundyou_sidetab_content_search_div" ng-style="style_aroundyou_sidetab_scrollable()" resize>
                <div class="aroundyou_sidetab_search_wrapper_div">

                        <!-- search tab -- Distance-->
                        <p class="text-left col-md-8 aroundyou_sidetab_text">Cover Distance KM</p>
                        <p class="text-right col-md-4 aroundyou_sidetab_text">{{aroundyou_sidetab_distance_value}} KM</P>

                        <input id="aroundyou_sidetab_slider" class="col-md-12" type="range" name="aroundyou_sidetab_distance" ng-model="aroundyou_sidetab_distance_value" min="{{aroundyou_sidetab_distance_min}}"  max="{{aroundyou_sidetab_distance_max}}"> 
                        
                        <!-- search tab -- state_area-->
                        <p class="text-left col-md-12 aroundyou_sidetab_text aroundyou_sidetab_space">Fast Travel State and Area</p>
                        
                        <select class="aroundyou_sidetab_search_dropbox aroundyou_sidetab_text">
                            <optgroup ng-repeat='state_area in aroundyou_sidetab_state_area' label="{{state_area.state}}">
                                <option ng-repeat='area in state_area.area_list' value='{{area}}'>{{area}}</option>
                            </optgroup>
                        </select>
                        
                        <!-- search tab -- Categories-->
                        <p class="text-left col-md-12 aroundyou_sidetab_text aroundyou_sidetab_space">category</p>
                        
                        <select class="aroundyou_sidetab_search_dropbox aroundyou_sidetab_text">
                            <optgroup ng-repeat='group_categories in aroundyou_sidetab_group_categories' label="{{group_categories.group}}">
                                <option ng-repeat='categories in group_categories.categories_list' value='{{categories}}'>{{categories}}</option>
                            </optgroup>
                        </select>
                        
                        <!-- search tab -- Search Button-->
                        <button type="button"  class="btn btn-primary" id="aroundyou_sidetab_search_btn" ng-click="aroundyou_sidetab_search_event_btn()"></button>   
                </div>
            </div>
            
            <!-- This handle side tab content -- result tab -->
            <div class="ng-hide aroundyou_sidetab_scrollable aroundyou_sidetab_content_result_div" ng-style="style_aroundyou_sidetab_scrollable()" resize>
                <p>Scroll Me 2 !</p>
                <p>Hello World 2 </p>
                <p>Hello World 2 </p>
                <p>Hello World 2 </p>
                <p>Hello World 2 </p>
                <p>Hello World 2 </p>
                <p>Hello World 2 </p>
                <p>Hello World 2 </p>
                <p>Hello World 2 </p>
                <p>Hello World 2 </p>
                <p>Hello World 2 </p>
            </div>
            
            <!-- This handle side tab content -- event tab -->
            <div class="ng-hide aroundyou_sidetab_scrollable aroundyou_sidetab_content_event_div" ng-style="style_aroundyou_sidetab_scrollable()" resize>
                <p>Scroll Me 3 !</p>
                <p>Hello World 3 </p>
                <p>Hello World 3 </p>
                <p>Hello World 3 </p>
                <p>Hello World 3 </p>
                <p>Hello World 3 </p>
                <p>Hello World 3 </p>
                <p>Hello World 3 </p>
                <p>Hello World 3 </p>
                <p>Hello World 3 </p>
            </div>
        </div>
    </div>
    
</div>

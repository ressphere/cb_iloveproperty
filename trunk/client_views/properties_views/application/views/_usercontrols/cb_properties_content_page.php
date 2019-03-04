<div id="" class="wrapper" ng-app="SearchHighLightApp">
	<div class="row clearfix" ng-controller="FilterSearchHighLightCtrl">                
            <!-- This is the right section, contain the search promotion section and searched result -->
            <div id="page-content-wrapper" class="column">
                <?php
                    echo "Just try;;;;;;asdaslk;fhwoiefh ;ashfhaegj hdskhngvps"
                ?>
                <div class="col-md-12 col-sm-12 col-xs-12 column properties_result_div">
                    </div>
                    
                    <!-- Page index section -->
                    <div >
                        <!-- When data is loading -->
                        <div ng-if = "data_ready == 0">
                            <p class="gothic_bool_font">Loading data .... </p>
                        </div>
                        
                        <!-- When doesn't have data -->
                        <div ng-if = "data_ready != 0 && (nav_total_page == 0 || nav_total_page == NULL)">
                            <p class="gothic_bool_font">Sorry, no match found</p>
                        </div>
                        
                        <!-- If have data -->
                        <div ng-if = "nav_total_page > 0" class="row clearfix search_pagination_div">
                            <div class="pull-left">
                                
                                <p ng-if = "nav_page <= nav_total_page" class="gothic_bool_font">Total result {{total_result}}, current display {{cur_display_min}}~{{cur_display_max}}</p>
                                <p ng-if = "nav_page > nav_total_page" class="gothic_bool_font">The navigation selection is invalid, please re-select</p>
                                
                                <ul class="pagination" ng-show="nav_total_page !== 0">
                                    <li ng-show="nav_page > 1"><a ng-click="page_nav('prev',1)">&lsaquo;&lsaquo;&lsaquo;</a></li>
                                    <li ng-repeat="i in getNumber(nav_max_page_display) track by $index" ng-show="nav_first_num + $index <= nav_total_page" ng-class="active_current_page_number(nav_first_num + $index, nav_page)"><a ng-click="page_nav('goto',nav_first_num + $index)">{{nav_first_num + $index}}</a></li>
                                    <li ng-show="nav_page != nav_total_page && nav_total_page !== 1"><a ng-click="page_nav('next',1)">&rsaquo;&rsaquo;&rsaquo;</a></li>
                                </ul>
                            </div>  
                        </div>
                    </div>
		</div>
        <div id="property-details-wrapper" class="column">
            <?php
                echo "CH: YAY! Got the height!"
            ?>
        </div>
            </div>
            <div id="popup_property_measurement" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <center>
                        <div id="property_measurement" class="modal-dialog modal-lg popup">
                              <div class="modal-header">
                                <button class="property_info close" data-dismiss="modal" type="button">
                                    <span aria-hidden="true">×</span>
                                    <span class="sr-only">Close</span>
                                </button>

                            </div>
                            <div class="modal-body">
                                <div id="property_measurement_content">
                                    <select id="select_property_measurement">
                                        <option ng-repeat="available_unit in property_information.list_of_unit_conversion"  value="{{available_unit.value}}">{{available_unit.display}}</option>
                                    </select>

                                </div>
                            </div>
                             <div class="modal-footer">
                                <center>
                                    <button class="change_measurement_type btn btn-default" id="btn_change_measurement" data-dismiss="modal" type="button">
                                                                        OK
                                                                </button>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <button class="cancel_measurement_type btn" data-dismiss="modal" type="button">Cancel</button>

                                    <br>
                                </center>
                            </div>
                        </div>
                    </center>
            </div>
	</div>
</div>

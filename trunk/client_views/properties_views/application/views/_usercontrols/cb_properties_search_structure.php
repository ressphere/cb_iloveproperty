<div id="search_wrapper" class="wrapper" ng-app="SearchHighLightApp">
	<div class="row clearfix" ng-controller="FilterSearchHighLightCtrl">
        <!-- This is the left section, contain area selection and filter option-->
            <div id="sidebar-wrapper" class="column">
              
		<div class="col-md-12 col-sm-12 col-xs-12 column filter_location_div sidebar_content " >
			<div class="row clearfix filter_div" >
                            <div class="col-md-12 column filter_div">
                                <div class="tabbable filter_div" id="tabs-448371">
                                    <ul class="nav nav-tabs">
                                            <li class="active location_label">
                                                    <a class="gothic_bool_font location_label_text" href="#panel-location" data-toggle="tab">Location</a>
                                            </li>
                                            <li class=" location_label">
                                                    <a class="gothic_bool_font location_label_text" href="#panel-filters" data-toggle="tab">Filters</a>
                                            </li>
                                    </ul>
                                    <div class="tab-content filter_div">
                                        
                                        <!-- location part -->
                                        <div class="tab-pane filter_div active" id="panel-location">
                                            <!-- Start information inside -->
                                            <div class="panel-group filter_div" id="accordion">
                                                <div class="panel panel-default filter_div" ng-repeat="(country_data, state_array) in location_list">
                                                  <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                      <a data-toggle="collapse" data-parent="#accordion" href="#collapse_{{change_to_id_class(country_data)}}">
                                                        {{country_data}} <img height="15px" src="<?=base_url();?>images/property_search/location_drop.jpg">
                                                      </a>
                                                    </h4>
                                                  </div>
                                                  <div id="collapse_{{change_to_id_class(country_data)}}" class="panel-collapse collapse" ng-class="is_requie_expend_country(country_data)">
                                                    <div class="panel-body">
                                                        <div class="list-group">
                                                            <a ng-click="update_contry_state(country_data, state_data)" class="state_group_list list-group-item" ng-class="is_requie_highlight_state(country_data, state_data)" ng-repeat="state_data in state_array" style="background-color:#eff0f5; border-color:#d8d8d8"> {{state_data}}</a>
                                                        </div>
                                                    </div>
                                                  </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Filter part -->
                                        <div class="tab-pane " id="panel-filters">
                                            <div class="clearfix filter_info_div ">
                                                <!-- Option filter group -->
                                                <div class="column col-md-12 filter_info_first_div">
                                                    
                                                    <div class="">
                                                        <input type="text" class="form-control gothic_font" style ="font-size: 10pt;" ng-model="ui_place_name" placeholder="Place Name" maxlength="100">
                                                    </div>
                                                    
                                                    <div class="dropdown filter_info_option_type_div_2" >
                                                        <button class="btn btn-default dropdown-toggle gothic_font" style="width:241px; text-align: left; font-size: 10pt;" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                                          {{property_category_selection}}
                                                          <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu scrollable-menu" style="width:241px;" role="menu" aria-labelledby="dropdownMenu1">
                                                          <li role="presentation" ng-repeat="(property_category, property_type_list) in property_category_type_list" ><a role="menuitem" ng-click="property_type_dp_click(property_category,'')">{{property_category}}</a></li>
                                                        </ul>
                                                    </div>
                                                    
                                                    <div class="dropdown filter_info_option_type_div" >
                                                        <button class="btn btn-default dropdown-toggle gothic_font" style="width:241px; text-align: left; font-size: 10pt;" type="button" id="dropdownMenu2" data-toggle="dropdown">
                                                          {{property_type_selection}}
                                                          <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu scrollable-menu" style="width:241px;" role="menu" aria-labelledby="dropdownMenu2">
                                                          <li role="presentation" ng-repeat="property_type in property_category_type_list[property_category_selection]" ><a role="menuitem" ng-click="property_type_dp_click(property_category_selection,property_type)">{{property_type}}</a></li>
                                                        </ul>
                                                    </div>
                                                    
                                                </div>
                                                
                                                <!-- line between -->
                                                <div class="filter_info_line_option_requirement"></div>
                                                
                                                <!-- requirement filter group -->
                                                <div>
                                                    <div class="">
                                                        <div  class="col-md-12 filter_info_requirement_div_2">
                                                            <div class="gothic_bool_font filter_info_requirement_label">
                                                                <p>Min Price</p>
                                                            </div>
                                                            <div class="input-group ">
                                                                <span class="input-group-addon gothic_font filter_info_requirement_input_label label_currency">MYR</span>
                                                                <input id="ui_min_price" type="text" class="numericOnly form-control gothic_font filter_info_requirement_input_text" ng-model="ui_min_price" placeholder="0" maxlength="10">
                                                            </div>
                                                        </div>
                                                        
                                                      
                                                        
                                                        <div  class="col-md-12 filter_info_requirement_div">
                                                            <div class="gothic_bool_font filter_info_requirement_label">
                                                                <p>Max Price</p>
                                                            </div>
                                                            <div class="input-group ">
                                                                <span class="input-group-addon gothic_font filter_info_requirement_input_label label_currency">MYR</span>
                                                                <input id="ui_max_price" type="text" class="numericOnly form-control gothic_font filter_info_requirement_input_text" ng-model="ui_max_price" placeholder="100,000,000" maxlength="10">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="filter_info_line_requirement_requirement"></div>
                                                        
                                                        <div  class="col-md-12 filter_info_requirement_div_2">
                                                            <div class="gothic_bool_font filter_info_requirement_label">
                                                                <p>Min Built-Up Area</p>
                                                            </div>
                                                            <div class="input-group ">
                                                                <span class="input-group-addon gothic_font filter_info_requirement_input_label lbl_measurement_type">sqft</span>
                                                                <input type="text" class=" numericOnly form-control gothic_font filter_info_requirement_input_text" ng-model="ui_min_sqft" placeholder="0" maxlength="10">
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                        
                                                        
                                                        <div  class="col-md-12 filter_info_requirement_div">
                                                            <div class="gothic_bool_font filter_info_requirement_label">
                                                                <p>Max Built-Up Area</p>
                                                            </div>
                                                            <div class="input-group ">
                                                                <span class="input-group-addon gothic_font filter_info_requirement_input_label lbl_measurement_type">sqft</span>
                                                                <input type="text" class="numericOnly form-control gothic_font filter_info_requirement_input_text" ng-model="ui_max_sqft" placeholder="100,000" maxlength="10">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="filter_info_line_requirement_requirement"></div>
                                                        
                                                        <!--
                                                        <div  class="col-md-12 filter_info_requirement_div">
                                                            <div class="gothic_bool_font filter_info_requirement_label">
                                                                <p>Bedroom</p>
                                                            </div>
                                                            <div class="input-group ">
                                                                <span class="input-group-addon gothic_font filter_info_requirement_input_label">Room</span>
                                                                <input type="text" class="numericOnly form-control gothic_font filter_info_requirement_input_text" ng-model="ui_bedroom" placeholder="Any" maxlength="3">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="filter_info_line_requirement_confrim"></div>
                                                        -->
                                                        
                                                        <!-- Search Button -->
                                                        <div class="col-md-12" >
                                                                <div class="">
                                                                    <button type="button" id="filter_info_confrim_btn" class="btn btn-default gothic_bool_font filter_info_confrim_btn">Search</button>
                                                                </div>
                                                        </div>
                                                            
     
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
			</div>
                        
                        <!-- Mortgage Calculator Button -->
                        <!--
			<div class="row clearfix" >
				<div class="">
                                    <button type="button" class="btn btn-default gothic_bool_font mortgage_calculator_btn">Mortgage Calculator</button>
                                </div>
			</div>
                        -->
		</div>

               
            </div>
            <div  class="sidebar_toggle">
                 <button id ="menu-toggled" type="button" class="btn btn-default btn-xs">
                    <span class="icon-search icon-large"></span></button>
            </div>
                
                
            <!-- This is the right section, contain the search promotion section and searched result -->
            <div id="page-content-wrapper" class="column">
                <div class="col-md-12 col-sm-12 col-xs-12 column properties_result_div">
                    
                    <!-- Build the location indicator --> 
                    <div class="row clearfix">
                        <div class="col-md-12 column search_location_div gothic_bool_italic_font">
                            <p>{{selected_state}}, {{selected_country}}</p>
                        </div>
                    </div>
                    
                    <!-- Build the right highlight listing part -->
                    <!-- Line between highlight and search result is using border -->
                    <!--
                    <div class="row clearfix">
                        <div class="highlight_div">
                             <div  ng-repeat="highlight_data in highlight" >
                                <div class ="col-md-2 col-xs-2 column highlight_data_div">
                                    <!-- purple image on the highlight -->
                                    <!--
                                    <div class="highlight_top_line"></div>

                                    <!-- image for the highlight -->
                                    <!--
                                    <div class="highlight_picture" style="background-image:url({{highlight_data.image}});"></div>

                                    <!-- Overlay information in grey-->
                                    <!-- 
                                    <div class="highlight_info_box"> 
                                        <!-- Highlight data set -->
                                        <!--
                                        <p class="gothic_bool_font highlight_info" style="margin-top:2px;">{{highlight_data.name}}</p>
                                        <p class="gothic_font highlight_info">{{highlight_data.price}}</p>
                                        <p class="gothic_font highlight_info">{{highlight_data.sqft}}</p>
                                    </div>
                                </div>
                                
                                <!-- Space between highlight data -->
                                <!--
                                <div class="col-md-1 col-xs-1 column highlight_space" ng-show=" ! $last"></div>
                             </div> 
                        </div>
                    </div>
                    
                    <!-- line between highlight and search result -->
                    <!--
                    <div class="row clearfix ">
                        <div class="col-md-12 column line_between_highligh_result"></div>
                        <div class="col-md-12 column space_between_line_result"></div>
                    </div>
                    -->
                    
                    <!-- Build the normal search result part -->
                    <div class="row clearfix ">
                        <div class="search_result_div">
                      
                                <!-- Data set-->
                                <div class ="col-md-4 col-sm-4 col-xs-4 search_result_data_div" ng-click="detail_page_load(search_data.ref_tag)"  ng-repeat="search_data in search">
                                    <!-- Type2 - Purple Shadow -->
                                    <div class="search_result_purple_shadow" ng-show="search_data.display_type == 2"> </div>
                                    
                                    <!-- info and image that auto swap -->
                                    <div class="search_result_image search_result_img_{{get_position('img', search_data.display_type)}}" style="background-image:url('{{search_data.image}}');" > </div>

                                    <div class ="search_result_info search_result_info_{{get_position('info', search_data.display_type)}}" > 
                                        <p class="gothic_bool_font search_result_info_name_data">{{search_data.name}}</font></p>
                                        <p class="gothic_font search_result_info_data" ng-style="search_data.disableTagButton" ng-model="search_data.converted_price">{{search_data.converted_price}}</p>
                                        <p class="gothic_font search_result_info_data">{{search_data.converted_size}}</p>
                                        <p class="gothic_font search_result_info_data">{{search_data.furnish}}</p>
                                        <p class="gothic_font search_result_info_data">{{search_data.date}}</p>

                                        <!-- Icon part - parking, room and wc -->
                                        <div class="search_result_icon_div" >

                                            <div class="search_result_icon_wc_div">
                                                <p class="gothic_font search_result_icon_number">{{search_data.wc}}</font></p>
                                                <div class="search_result_icon">
                                                    <img height="9.66px" src="<?=base_url();?>images/property_search/wc_icon.png">
                                                </div>
                                            </div>

                                            <!-- line -->
                                            <div class="search_result_icon_line_bed_wc"></div>

                                            <div class="search_result_icon_bed_div">
                                                <p class="gothic_font search_result_icon_number">{{search_data.room}}</p>
                                                <div class="search_result_icon">
                                                    <img height="9.66px" src="<?=base_url();?>images/property_search/bedroom_icon.png">
                                                </div>
                                            </div>

                                            <!-- line -->
                                            <div class="search_result_icon_line_car_bed"></div>

                                            <div class="search_result_icon_car_div">
                                                <p class="gothic_font search_result_icon_number">{{search_data.parking}}</p>
                                                <div class="search_result_icon">
                                                    <img height="9.66px"  src="<?=base_url();?>images/property_search/parking_icon.png">
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                        </div>
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
                            <div class="pull-right">
                                
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

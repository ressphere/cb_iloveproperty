<br><br>
<div  class="fuelux container upload_properties" ng-app="user_profileApp" ng-controller="uploadProfile">
    
    <div class="userprofile row clearfix">
        <div class="title"><span>Personal Information</span></div>
        <div class="oceanblue col-md-8 column">
            <div  class="col-md-4 column">
                <div><span class="gothic_font">Name</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="gothic_font" id="name" value="{{person.name}}" disabled></div><br>
                <div><span class="gothic_font">Email</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="gothic_font" id="email" value="{{person.email}}"  disabled></div> <br>

            </div>
            <div class="col-md-4 column">
                <div><span class="gothic_font">Contact No.</span>&nbsp;&nbsp;&nbsp;<input class="gothic_font" type="text" id="contact_number" value="{{person.phone}}" disabled></div><br>

            </div>
        </div>
    </div><br>
   <div class="row">
        <div class="title">
            <span>Upload Photo</span>
        </div>
       <br>
        <div id="ng-app"
            flow-prevent-drop="" flow-drag-enter="dropClass=&#39;drag-over&#39;" 
            flow-name="uploader.flow"
            flow-drag-leave="dropClass=&#39;&#39;" 
            flow-init="uploader.opts" 
            flow-files-submitted="$flow.upload()" 
            flow-file-added="!!{png:1,gif:1,jpg:1,jpeg:1}[$file.getExtension()]"
            class="ng-scope">
             <div  class="drop row clearfix" flow-drop="" ng-class="dropClass">
                <div>
                <span class="btn btn-default" flow-btn="">Upload Image
                    <input type="file" multiple="multiple" 
                    style="visibility: hidden; position: absolute;">
                </span>
                <span class="gothic_font btn btn-default" 
                      flow-btn="" flow-directory="" 
                      ng-show="$flow.supportDirectory">Upload Folder of Images<input type="file" multiple="multiple"
                        webkitdirectory="webkitdirectory" 
                        style="visibility: hidden; position: absolute;">
                </span>

              </div><br>

                <div class="row clearfix">
                <div>
                    <div ng-repeat="file in $flow.files" class="col-sm-6 col-md-4">
                          <span class="title ng-binding" ng-binding="file.name"></span>
                          <div class="row thumbnail" ng-show="$flow.files.length">
                            <img flow-img="file" style="max-width: 200px; height: 150px"
                                 ng-src="{{file.name}}">
                          </div>
                          <div>
                              <center><textarea maxlength="200" class="form-control photo-desc" style='resize: none;' cols='35' rows='5' placeholder='Describe Your Photo Here'></textarea></center>
                          </div>
                          <br>
                          <div class="progress progress-striped" ng-class="{active: file.isUploading()}">
                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" ng-style="{width: (file.progress() * 100) + '%'}" style="width: 100%;">
                              <span class="gothic_font sr-only ng-binding">1% Complete</span>
                            </div>
                          </div>
                          <div class="btn-group">
                              <a class="gothic_font btn btn-xs btn-danger" ng-click="file.cancel()">Remove</a>
                          </div>
                          <br>
                          <br>
                    </div>
                </div>
                 
              </div>
                 
            
            </div>
        </div>
       <br><br>
        <div class="properties_details">
            <div class="title row clearfix">
                <span class="gothic_bold_font">Property Information</span>
            </div>
            <div class="oceanblue row clearfix">
                <div class="col-md-6 column">
                    <div class="property_info_location row clearfix" class="row clearfix"  ng-repeat="property_category in property_category_1">
                        <div  class="col-md-4 {{property_category.category}}">
                            <span ng-if="property_category.id === 'auction'">
                                <input class="gothic_bold_font" type="checkbox" id="chk_{{property_category.id}}" value="{{property_category.name}}">
                            </span>
                             <span ng-else>{{property_category.name}}</span> 
                             <span class="gothic_bold_font"
                                 ng-if="property_category.id === 'asking_price' || 
                                    property_category.id === 'asking_price_per' ||
                                    property_category.control === 'input-currency' ||
                                    property_category.id === 'monthly_rental'">(<B>{{currency_value.currency}}</B>)</span>
                        </div>
                        
                        
                        <div class="{{property_category.category}} col-md-4" ng-switch on='property_category.id'>
                           
                            <div class="select-div gothic_font" ng-switch-when='currency' ng-if="property_category.control === 'select'">
                                <select  id='{{property_category.id}}' ng-model='currency_value.currency'>
                                    <option ng-repeat="property_category_val in property_category.values">{{property_category_val}}</option>
                                </select>
                            </div>
                            <div class="select-div gothic_font" ng-switch-when='property_type_rent' ng-if="property_category.control === 'select-title'">
                                <select id='{{property_category.id}}' ng-model='property_type_rent_value.value'>
                                        <optgroup label="{{property_category_key}}" ng-repeat="(property_category_key, property_category_val) in property_category.values">
                                            <option ng-repeat="property_type_value in property_category_val" ng-click="change_category_type(property_category_key, property_type_value)">{{property_type_value}}</option>
                                        </optgroup>
                                </select>
                            </div>
                            <div class="select-div gothic_font" ng-switch-when='property_type_sell' ng-if="property_category.control === 'select-title'">
                                <select id='{{property_category.id}}'  ng-model='property_type_sell_value.value'>
                                        <optgroup label="{{property_category_key}}" ng-repeat="(property_category_key, property_category_val) in property_category.values">
                                            <option ng-repeat="property_type_value in property_category_val" ng-click="change_category_type(property_category_key, property_type_value)">{{property_type_value}}</option>
                                        </optgroup>
                                </select>
                            </div>
                           <div ng-switch-when='asking_price' id='{{property_category.id}}'  class="input-group" ng-if="property_category.control === 'input-currency'">
                               <div class="number-div gothic_font">
                                    <input class="currencyOnly" type='number' ng-model="asking_price.value" min="1"/>
                               </div>
                           </div>
                            <div ng-switch-when='monthly_rental' id='{{property_category.id}}'  class="input-group" ng-if="property_category.control === 'input-currency'">
                               <div class="number-div gothic_font">
                                    <input class="currencyOnly" type='number' ng-model="monthly_rental.value" min="1"/>
                               </div>
                           </div>
                           <div  class="number-div  gothic_font" ng-switch-when='built_up'>
                               <input class="currencyOnly" id='{{property_category.id}}' type='number' ng-model="build_up.value" ng-if="property_category.control === 'input-number'" min='{{property_category.values[0]}}' max='{{property_category.values[1]}}' value='{{property_category.values[2]}}'/>
                           </div>
                           <div ng-switch-when='asking_price_per' id='{{property_category.id}}'  class="gothic_font {{property_category.category}} input-group" ng-if="property_category.control === 'input-currency'">
                                    <!--<span class="input-group-addon" ng-bind="currency_value.currency"></span>-->
                                    <input id='{{property_category.id}}' width="200" style="width: 200px" type='text' value="{{asking_price.value/build_up.value | number:2}}" disabled/>

                           </div>
                           <div ng-switch-default>
                                <!-- select control with title for property type-->
                                 <div class="select-div  gothic_font"  ng-if="property_category.control === 'select-title'">
                                    <select id='{{property_category.id}}'>
                                        <optgroup label="{{property_category_key}}" ng-repeat="(property_category_key, property_category_val) in property_category.values">
                                            <option ng-repeat="property_category in property_category_val">{{property_category}}</option>
                                        </optgroup>
                                    </select>
                                 </div>
                                <!-- below is the general control without binding-->
                                <!-- normal select control-->
                                <div class="select-div  gothic_font"  ng-if="property_category.control === 'select'">
                                    <select id='{{property_category.id}}'>
                                        <option ng-repeat="property_category_val in property_category.values">
                                            {{property_category_val}}
                                        </option>
                                    </select>
                                </div>
                                <!-- input-text-->
                                <input class="gothic_font" id='{{property_category.id}}' width="200" style="width: 200px" type='text'  ng-if="property_category.control == 'input-text'" value='{{property_category.values[0]}}' placeholder='{{property_category.placeholder}}'/>
                                <!-- input-currency-->
                                <div id='{{property_category.id}}' class="input-group" ng-if="property_category.control === 'input-currency'">
                                    <div  class="gothic_font number-div">
                                        <input class="currencyOnly" width="190" type='number' value='{{property_category.values[0]|number:2}}'/>
                                    </div>
                                    <span class="input-group-addon  gothic_font">.00</span>
                                </div>
                                <!--input date-->
                                <input id='{{property_category.id}}' class="date gothic_font" width="200" style="width: 200px" ng-if="property_category.control === 'input-date'" value='{{property_category.values[0]}}'/>
                                <!-- input number-->
                                <div class="number-div gothic_font"  ng-if="property_category.control === 'input-number'">
                                    <input id='{{property_category.id}}' class="numericOnly" type='number' min='{{property_category.values[0]}}' max='{{property_category.values[1]}}' value='{{property_category.values[2]}}'/>
                                </div>
                            </div>
                        </div>
                    </div>                 
                </div>
                <div class="col-md-6" column>
                    <div class="property_info_location row clearfix"  ng-repeat="property_category in property_category_2">
                        <div class="{{property_category.category}} col-md-4">
                             <span class="gothic_font" id='lbl_{{property_category.id}}'>{{property_category.name}}</span>
                        </div>
                        <div class="{{property_category.category}} col-md-4">
                            <div class="select-div gothic_font"  ng-if="property_category.control === 'select'">
                             <select id='{{property_category.id}}'>
                                    <option ng-repeat="property_category_val in property_category.values">
                                        {{property_category_val}}
                                    </option>
                             </select>
                            </div>
                            <div class="select-div gothic_font"  ng-if="property_category.control == 'select-title'">
                                <select id='{{property_category.id}}'>

                                        <optgroup label="{{property_category_key}}" ng-repeat="(property_category_key, property_category_val) in property_category.values">
                                            <option ng-repeat="property_category in property_category_val">{{property_category}}</option>
                                        </optgroup> 

                                </select>
                            </div>
                             <input id='{{property_category.id}}' class="gothic_font" width="200" maxlength="200" style="width: 200px" 
                                    type='text'  ng-if="property_category.control == 'input-text'" 
                                    value='{{property_category.values[0]}}' 
                                    placeholder='{{property_category.placeholder}}'/>
                             
                             <div  class="input-group gothic_font" ng-if="property_category.control == 'input-currency'">
                                 <div class="number-div">
                                  <input class="currencyOnly gothic_font" id='{{property_category.id}}' type='number' value='{{property_category.values[0]|number:2}}'/> 
                                 </div>
                                    <!--<span class="input-group-addon">.00</span>-->
                             </div>
                             <input class="gothic_font" id='{{property_category.id}}' width="200" style="width: 200px" type='date'  ng-if="property_category.control == 'input-date'" value="{{property_category.value}}"/>
                             <div class="number-div gothic_font" ng-if="property_category.control == 'input-number'">
                                <input class="numericOnly gothic_font" id='{{property_category.id}}' width="200" 
                                    type='number'  
                                     min='{{property_category.values[0]}}' max='{{property_category.values[1]}}' value='{{property_category.values[2]}}'/>
                             </div>

                        </div>
                    </div>
                </div>
                
            </div>
            <br><br>
            <div class="title row clearfix">
                <span>Location</span>
            </div>
            <div class="oceanblue row clearfix">
                <div class="col-md-12">
                    <div class="property_info_location row clearfix"  ng-repeat="property_category in property_category_3">
                        <div class="{{property_category.category}} col-md-4 div_{{property_category.id}}">
                             <span class="gothic_font" id='lbl_{{property_category.id}}'>{{property_category.name}}</span>
                        </div>
                        <div class="{{property_category.category}} col-md-8" ng-switch on='property_category.id'>
                            <div class="select-div gothic_font"  ng-switch-when='country'>
                                <select ng-change="change_country()" ng-model='country_state.country' id='{{property_category.id}}'>
                                    <option ng-repeat="property_category_val in property_category.values">{{property_category_val}}</option>
                                </select>
                            </div>
                            <div ng-switch-when='area'>
                                <div class="validation_input_group_small input-group">
                                    <input class="gothic_font" id='{{property_category.id}}' width="200" style="width: 200px" type='text'
                                    value='{{get_ngPlace_info_by_name(google_maps.details.adr_address, "locality")}}'
                                    placeholder='{{property_category.placeholder}}' maxlength="200"/>
                                    <span class="feedback {{property_category.id}}-feedback input-group-addon glyphicon glyphicon-asterisk"></span>
                                </div>
                            </div>
                            <div class="select-div div_{{property_category.id}} gothic_font" ng-switch-when='state'>
                                <select id='{{property_category.id}}'>
                                    <option ng-repeat="state in country_state.states">
                                        {{state}}
                                    </option>
                                </select>
<!--                                <div class="validation_input_group_small input-group">
                                    <input id='{{property_category.id}}' width="200" style="width: 200px" type='text'
                                    value="{{google_maps.details.address_components[2].long_name}}"
                                    placeholder='{{property_category.placeholder}}' maxlength="200"/>
                                    <span class="feedback {{property_category.id}}-feedback input-group-addon glyphicon glyphicon-asterisk"></span>
                                </div>-->
                            </div>
                            <div ng-switch-when='postcode'>
                                <div class="validation_input_group_small input-group gothic_font">
                                    <input id='{{property_category.id}}' width="200" style="width: 200px" type='text'
                                    value='{{get_ngPlace_info_by_name(google_maps.details.adr_address, "postal-code")}}'
                                    placeholder='{{property_category.placeholder}}' maxlength="200"/>
                                    <span class="feedback {{property_category.id}}-feedback input-group-addon glyphicon glyphicon-asterisk"></span>
                                </div>
                            </div>
                            <div ng-switch-when='street'>
                                <div class="validation_input_group_small input-group gothic_font">
                                    
                                        <input id='{{property_category.id}}' width="200" style="width: 200px" type='text'
                                        value='{{get_ngPlace_info_by_name(google_maps.details.adr_address, "street-address")}}'
                                        placeholder='{{property_category.placeholder}}' maxlength="200"/>
                                        <span class="feedback {{property_category.id}}-feedback input-group-addon glyphicon glyphicon-asterisk"></span>
                                    
                                </div>
                            </div>
<!--                            <textarea ng-switch-when='street' maxlength="200" rows='6' id='{{property_category.id}}' type='text'  
                                      ng-if="property_category.control == 'input-word'" placeholder='{{property_category.placeholder}}' 
                                      ng-bind="google_maps.details.address_components[0].long_name"></textarea>-->
                          
                            <!-- google_maps.details.geometry.location-->
                            <div ng-switch-when='unit_name'>
                                <div class="validation_input_group_default input-group gothic_font">
                                    <input ng-model="google_maps.autocomplete" 
                                       class="form-control" 
                                       ng-autocomplete options="google_maps.options"
                                       details="google_maps.details" id='{{property_category.id}}'/>

                                    <span class="feedback {{property_category.id}}-feedback input-group-addon glyphicon glyphicon-asterisk"></span>
                                </div>
                            </div>
                            <div ng-switch-default>
                                <!-- below is the general control without binding-->
                                <!-- normal select control-->
                                <div class="select-div gothic_font"  ng-if="property_category.control === 'select'">
                                    <select id='{{property_category.id}}'>
                                        <option ng-repeat="property_category_val in property_category.values">
                                            {{property_category_val}}
                                         </option>
                                    </select>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
            <br><br>
          
            <div id="map_canvas" class="row clearfix">
                <ui-gmap-google-map center="map.center" zoom="map.zoom" draggable="true" options="options" control="googleMap">
                    <ui-gmap-marker coords="marker.coords" options="marker.options" 
                                    events="marker.events" idkey="marker.id" control="googleMarker">


                    </ui-gmap-marker>

                </ui-gmap-google-map>
            </div>
            <br><br>
            <div class="title row clearfix">
                <span>Facilities</span>
            </div>
            <div id ="facilities" class="oceanblue row clearfix">
                <div class="col-md-12">
                    <div class="col-md-4" ng-repeat="(property_facility_key, property_facility) in property_facility_1">
                        <label class="property_facility gothic_font">
                        <input type="checkbox" name="property_facility" value="{{property_facility_key}}">&nbsp;&nbsp;{{property_facility}}<br><br>
                        </label>
                    </div>
                    
                    <div class="col-md-4" ng-repeat="(property_facility_key, property_facility) in property_facility_2">
                        <label class="property_facility gothic_font">
                        <input type="checkbox" name="property_facility" value="{{property_facility_key}}">&nbsp;&nbsp;{{property_facility}}<br><br>
                        </label>
                    </div>
                    <div class="col-md-4" ng-repeat="(property_facility_key, property_facility) in property_facility_3">
                        <label class="property_facility gothic_font">
                        <input type="checkbox" name="property_facility" value="{{property_facility_key}}">&nbsp;&nbsp;{{property_facility}}<br><br>
                        </label>
                    </div>
                </div>
                
            </div>
            <br><br>
            <div id ="nearest_places" class="row clearfix">
                <div role="tabpanel">
                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active gothic_font">
                        <a href="#transportations" class="gothic_font" aria-controls="transportations" role="tab" data-toggle="tab">
                            Transportations
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#schools" class="gothic_font" aria-controls="schools" role="tab" data-toggle="tab">
                            Schools
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#shopping_malls" class="gothic_font" aria-controls="shopping_malls" role="tab" data-toggle="tab">
                            Shopping malls
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#medicals" class="gothic_font" aria-controls="medicals" role="tab" data-toggle="tab">
                            Medical Centers
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#banks" class="gothic_font" aria-controls="banks" role="tab" data-toggle="tab">
                            Banks
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#gas_stations" class="gothic_font" aria-controls="gas_stations" role="tab" data-toggle="tab">
                            Gas Station
                        </a>
                    </li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                      
                    <div role="tabpanel" class="tab-pane active" id="transportations">
                        <div class="nearest_details col-md-8" ng-repeat="place in NearbyPlaces"
                             ng-if="place.types[0]=='subway_station' || place.types[0]=='bus_station' ||
                             place.types[0] == 'train_station' || place.types[0] == 'taxi_stand' || place.types[0] == 'airport'">
                           
                            <div class="col-md-6">
                                <span class="icon-large icon-train" aria-hidden="true" ng-if="place.types[0] == 'train_station'">
                                     
                                 </span>
                                 <span class="icon-large icon-busalt" aria-hidden="true" ng-if="place.types[0] == 'bus_station'">
                                     
                                 </span>
                                <span class="icon-large icon-metro-subway" aria-hidden="true" ng-if="place.types[0] == 'subway_station'">
                                     
                                 </span>
                                <span class="icon-large  icon-automobile-car" aria-hidden="true" ng-if="place.types[0] == 'taxi_stand'">
                                     
                                 </span>
                                <span class="icon-large icon-plane" aria-hidden="true" ng-if="place.types[0] == 'airport'">
                                     
                                 </span>
                                <span class="place_name gothic_font">{{place.name}}</span>
                            </div>
                            
                            
                            <div class="col-md-4 location">
                                <span style="display: none">"{{place.detail.geometry.location}}"</span>
                            </div>
                                
                        </div>
                        
                    </div>
                    <div role="tabpanel" class="tab-pane" id="schools">
                        <div class="nearest_details col-md-8" ng-repeat="place in NearbyPlaces" 
                             ng-if="place.types[0]=='school' || place.types[0]=='university'">
                            <div class="col-md-4">
                                <img width='14px' height='auto' src='images/uni.jpg' alt='university'>
                                
                                <span class="place_name gothic_font">{{place.name}}</span>
                            </div>
                             <div class="col-md-4 location">
                                <span style="display: none">"{{place.detail.geometry.location}}"</span>
                            </div>
                                
                        </div>
                        
                    </div>
                    <div role="tabpanel" class="tab-pane" id="shopping_malls">
                         <div class="nearest_details col-md-8" ng-repeat="place in NearbyPlaces" 
                              ng-if="place.types[0]=='shopping_mall'">
                            <div class="col-md-4">
                                
                                <span class="icon-shoppingcartalt" aria-hidden="true">
                                     
                                 </span>
                                <span class="place_name gothic_font">{{place.name}}</span>
                            </div>
                             <div class="col-md-4 location gothic_font">
                                <span style="display: none">"{{place.detail.geometry.location}}"</span>
                            </div>
                                
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="medicals">
                         <div class="nearest_details  col-md-8" ng-repeat="place in NearbyPlaces" 
                                ng-if="place.types[0]=='hospital'">
                            <div class="col-md-4">
                                <span class='icon-hospital' aria-hidden="true"></span>
                                <span class="place_name">{{place.name}}</span>
                            </div>
                            <div class="col-md-4 location gothic_font">
                                <span style="display: none">"{{place.detail.geometry.location}}"</span>
                            </div>
                                
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="banks">
                        <div class="nearest_details col-md-8" ng-repeat="place in NearbyPlaces" 
                                ng-if="place.types[0]=='bank'">
                            <div class="col-md-4">
                                <span class="icon-moneybag" aria-hidden="true">
                                     
                                 </span>
                                <span class="place_name gothic_font">{{place.name}}</span>
                            </div>
                             <div class="col-md-4 location gothic_font">
                                <span style="display: none">"{{place.detail.geometry.location}}"</span>
                            </div>
                                
                        </div>
                    </div>
                   <!--gas_stations-->   
                   <div role="tabpanel" class="tab-pane" id="gas_stations">
                        <div class="nearest_details col-md-8" ng-repeat="place in NearbyPlaces" 
                                ng-if="place.types[0]=='gas_station'">
                            <div class="col-md-4">
                                
                                <span class="icon-gasstation" aria-hidden="true">
                                     
                                 </span>
                                <span class="place_name gothic_font">{{place.name}}</span>
                            </div>
                             <div class="col-md-4 location gothic_font">
                                <span style="display: none">"{{place.detail.geometry.location}}"</span>
                            </div>
                                
                        </div>
                    </div>
                  </div>

                </div>
            </div>
            <br><br>
            <div class="title row clearfix gothic_font">
                <span>Remarks</span>
            </div>
            <div class="row clearfix">
                <textarea class="gothic_font" name="remark_editor" id="remark"  maxlength="400" rows="10" placeholder="Describe more about your property"></textarea>
            </div>
            <br><br>
            <div id="upload_controls" class="pull-right">
                <B><span id="upload_status" ng-show="disable_button" class="blink" ng-bind="photo_upload_status"></span></B>
                <button id="listing_preview" ng-disabled="disable_button" ng-click="preview_click()" type="button" class="btn">Preview</button>
                <button id="submit_listing" ng-disabled="disable_button" ng-click="submit_click()" type="button" class="btn">Save & Next</button>
            </div>
        </div>
       
        <br><br>
    </div>
</div>

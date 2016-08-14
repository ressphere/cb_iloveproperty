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
       <div ng-model="reload_photo"> 
           <div  class="clearfix" ng-hide="reload_photo">
                <span class="btn btn-default" ng-click="reload_photo_click()">Re-upload Image </span>
                <br>
                <br>
                <div class="col-sm-6 col-md-4" ng-model="uploaded_files" ng-repeat="uploaded_file in uploaded_files">
                     <div class="row thumbnail" ng-show="uploaded_file.length">
                         <img style="max-width: 200px; height: 150px" ng-src="{{uploaded_file[0]}}">
                     </div>
                     <div>
                         <center>
                             <textarea readonly maxlength="50" class="form-control photo-desc" style='resize: none;' cols='35' rows='3'>{{uploaded_file[1]}}</textarea>
                         </center>
                     </div>
                </div>
            </div>
            
            <div ng-show="reload_photo" 
            id="ng-app"
            flow-prevent-drop="" flow-drag-enter="dropClass=&#39;drag-over&#39;" 
            flow-name="uploader.flow"
            flow-drag-leave="dropClass=&#39;&#39;" 
            flow-init="uploader.opts" 
            flow-files-submitted="$flow.upload()" 
            flow-file-added="!!{png:1,gif:1,jpg:1,jpeg:1}[$file.getExtension()]"
            class="ng-scope">
             <div  class="drop row clearfix" flow-drop="" ng-class="dropClass">
                <div>
                <span class="btn btn-default" ng-click="reload_photo_click()">Cancel Re-upload </span>
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
                                    value="{{google_maps.details.address_components[1].long_name}}"
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
                                    value="{{google_maps.details.address_components[google_maps.details.address_components.length - 1].long_name}}"
                                    placeholder='{{property_category.placeholder}}' maxlength="200"/>
                                    <span class="feedback {{property_category.id}}-feedback input-group-addon glyphicon glyphicon-asterisk"></span>
                                </div>
                            </div>
                            <div ng-switch-when='street'>
                                <div class="validation_input_group_small input-group gothic_font">
                                    
                                        <input id='{{property_category.id}}' width="200" style="width: 200px" type='text'
                                        value="{{google_maps.details.address_components[0].long_name}}"
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
            <div class="title row clearfix gothic_font">
                <span>Remarks</span>
            </div>
            <div class="row clearfix">
                <textarea class="gothic_font" name="remark_editor" id="remark"  maxlength="400" rows="10" placeholder="Describe more about your property"></textarea>
            </div>
            <br><br>
            <div id="upload_controls" class="pull-right">
                <B><span id="upload_status" ng-show="disable_button" class="blink" ng-bind="photo_upload_status"></span></B>
                <input id="upload_term_condition"  type="checkbox" ng-click="term_click()"> I have read and agree with the <a href="index.php/properties_policy" target="_blank"><em>Terms & Conditions</em></a></input><br>
                <span class='error'>{{err_msg}}</span><br> 
                <button id="cancel" ng-disabled="disable_button" ng-click="navigate_back()" type="button" class="btn btn-danger">Cancel</button>
                <button id="listing_preview" ng-disabled="disable_button" ng-click="preview_click()" type="button" class="btn">Preview</button>
                <button id="submit_listing" ng-disabled="disable_button" ng-click="submit_click()" type="button" class="btn">Update & Next</button>
            </div>
        </div>
       
        <br><br>
    </div>
</div>

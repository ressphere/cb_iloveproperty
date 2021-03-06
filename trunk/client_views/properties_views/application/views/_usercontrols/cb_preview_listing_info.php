<div class="container" ng-app="user_profileApp" ng-controller="previewPage">
	<div class="row clearfix information">
		<div class="col-md-12 column">
			<div class="row clearfix">
				<div class="col-md-6 column">
                                    <h1 class="gothic_bold_font">{{property_information.PropertyName}}</h1><br>
                                    <h3 class="gothic_font">Area: {{property_information.Area}} &nbsp; <br><br>
                                        <small class="InsideContent">{{property_information.ToiletCount}}
                                        <img src="images/toilet.jpg"/></small> |
                                        <small class="InsideContent">{{property_information.RoomCount}}
                                        <img src="images/bed.jpg"/></small> |
                                        <small class="InsideContent">{{property_information.ParkingCount}}
                                        <img src="images/car.jpg"/></small>
                                        
                                    </h3>
				</div>

                                <div class="text-align-left col-md-6 column">
                                    <h1 class="gothic_bold_font">{{property_information.currency}}&nbsp;<span ng-bind="accounting.format(property_information.Price)">&nbsp;</span><span><span style ="font-size: small" class="gothic_font rent room">Monthly</span></span></h1>
                                    <h3 class="gothic_font"> <span class="PricePer">{{property_information.currency}}</span>&nbsp;<span class="PricePer" ng-bind="accounting.format(property_information.PricePer)"></span> <span class="PricePer">Per {{property_information.Unit}}</span></h3>
				</div>
			</div>
			<div class="row clearfix">
                               
				<div class="books_frame col-md-12 column">
                                    <div class="left_nav" ng-show='has_prev_page == true' ng-click='prev_page_clicked()'><img ng-click='prev_page_clicked' src='<?=base_url()?>images/left-icon.png'/></div>
                                    <div class="right_nav" ng-show='has_next_page == true' ng-click='next_page_clicked()'><img ng-click='next_page_clicked' src='<?=base_url()?>images/right-icon.png'/></div>
                                    <div id="books">
                                        <div class="property_photo" style="background-image: url('{{PropertyImage[0]}}')" ng-repeat='PropertyImage in property_information.PropertyImages'>
                                            <span class="gothic_font description">{{PropertyImage[1]}}</span>
                                        </div>
                                    </div>
				</div><br><br>
			</div>
		</div>
        </div><br>
	<div class="row clearfix">
		<div class="col-md-6 column">
                    <div class="contact_div gothic_font row">
                        <div class="row title">
                            <span class="gothic_bold_font">Please Contact</span>
                        </div>
                        <div class="row information">
                            <br>
                            <div class="col-lg-8 col-md-6">
                                <div class="row">
                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                            <span class="gothic_bold_font">Name</span>
                                        </div>
                                        <div class="col-lg-8 col-md-6 col-sm-6">
                                            <span class="gothic_font">{{person.name}}</span>
                                        </div>
                                </div><br>
                                <div class="row">
                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                            <span class="gothic_bold_font">Contact</span>
                                        </div>
                                       <div class="col-lg-8 col-md-6 col-sm-6">
                                            <span class="gothic_font">{{person.phone}}</span>
                                        </div>
                                </div><br>
                                
                                <div class="row">
                                        <div class="pull-left col-lg-4 col-md-6 col-sm-6">
                                            <span class="gothic_bold_font">Email</span>
                                        </div>
                                        <div class="pull-left col-lg-8 col-md-6 col-sm-6">
                                            <span id="txtEmail" class="gothic_font">{{person.email}}</span>
                                        </div>
                                </div><br>
                                <div class="row">
                                    <button ng-disabled="!enabled_contact" id="contact" ng-disabled="disable_button" ng-click="contact_click()" type="button" class="btn">Contact</button>
                                 </div><br>
                        

                            </div>
                            <div class="col-lg-4 col-md-6 profile" style="display: none">
                                
                                <div class="row">
                                    <img class="pull-right" src="images/user_profile_big.png" width="80px"/>
                                </div>
       
                                 
                            </div>
                            
                        </div>
                    </div><br/>
                    <div class="social_media_div sell gothic_font row">
                        <div class="row title">
                            <span class="gothic_bold_font">Social Media</span>
                            
                        </div>
                        <div class="row information">
                            <br>
                            <div class="g-plus col-md-4  col-sm-4 col-sm-4 column preview-none-click">
                                <div class="g-plus" data-action="share" data-annotation="bubble" ></div>
                            </div>
                            <div class="twitter col-md-4  col-sm-4 col-sm-4 column preview-none-click">
                                <a href="https://twitter.com/share" class="twitter-share-button" 
                                   data-url="{{current_url}}">Tweet</a>
                                <script>
                                    !function(d,s,id){
                                    var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
                                    if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';
                                        fjs.parentNode.insertBefore(js,fjs);}
                                    }(document, 'script', 'twitter-wjs');
                                </script>
                            </div>
                            <div class="fb col-md-4  col-sm-4 col-sm-4 column">
                                <div class="fb-share-button preview-none-click" data-href="{{current_url}}" data-layout="button_count"></div>
                            </div>
                             <div class="whatsapp col-md-4  col-sm-4 col-sm-4 column">
                                 <a href="whatsapp://send?text=Let's check out this good deal: {{current_url}} " data-action="share/whatsapp/share">
                                        <img src='images/whatsapp.jpg' style='height:25px; width:auto'/>
                                 </a>      
                             </div>
                             <div class="line col-md-4  col-sm-4 col-sm-4 column">
                                    <div class="line-it-button" data-lang="en" data-type="share-a" data-url="{{current_url}}" style="display: none;"></div>
                                    <script src="https://d.line-scdn.net/r/web/social-plugin/js/thirdparty/loader.min.js" async="async" defer="defer"></script>
             
                            </div>      
                             <div class="telegram col-md-4  col-sm-4 col-sm-4 column">
                                    <div><a href='https://telegram.me/share/url?url=' onclick='window.open(&apos;https://telegram.me/share/url?url==&apos;+encodeURIComponent(location.href)+&apos;&amp;bodytext=&amp;tags=&amp;text=&apos;+encodeURIComponent(document.title));return false;' rel='nofollow' style='text-decoration:none;' title='Share on Telegram'><img src='images/telegram.jpg' style='height:23px; width:auto'/></a></div>
                            </div>
                            <br><br>
                        </div>
                    </div>
                    
		</div>
		<div class="col-md-6 column gothic_font">
                    <div class="row title">
                        <span class="gothic_bold_font">Details</span>         
                    </div>
                    <div class="row information">
                        <br>
                        <div class="col-md-6 column gothic_font">
                            <div class="row-fluid" ng-repeat="detail in property_information.details[0]">
                                <div class="{{detail.category}} span6">
                                    <span class="gothic_bold_font" id='lbl_{{detail.id}}'>
                                            {{detail.label}}</span>
                                </div>
                                <div class="span6 {{detail.category}} column gothic_font">
                                    <span id="{{detail.id}}">{{detail.value}}</span>
                                </div><br><br>
                            </div>
                        </div>
                        <div class="col-md-6 column gothic_font">
                            <div class="row-fluid" ng-repeat="detail in property_information.details[1]">
                                <div class="{{detail.category}} span6">
                                    <span class="gothic_bold_font" 
                                              id='lbl_{{detail.id}}'>
                                            {{detail.label}}</span>
                                </div>
                                <div class="span6 {{detail.category}} column gothic_font">
                                    <span id="{{detail.id}}">{{detail.value}}</span>
                                </div><br><br>
                            </div>
                        </div>
                        
                    </div>
                </div>
	</div><br>
	
	<div class="row clearfix">
		<div class="col-md-12 column gothic_font">
                    <div class="row title">
                        <span class="gothic_bold_font">Location</span>
                        <span class="gothic_italic_font">({{country_state.location["k"]}}, {{country_state.location["B"]}})</span>
                    </div>
                    <div id="map_canvas" class="map_canvas_group" class="row clearfix">
                        <ui-gmap-google-map center="map.center" zoom="map.zoom" draggable="true" options="options" control="googleMap">
                            <ui-gmap-marker coords="marker.coords" options="marker.options" 
                                    events="marker.events" idkey="marker.id" control="googleMarker">


                            </ui-gmap-marker>

                        </ui-gmap-google-map>
                    </div>
                      
                </div>
	</div><br>
        
       <div class="row clearfix">
                <div class="col-md-12 column gothic_font">
                    <div class="row title">
                        <span class="gothic_bold_font">Facilities</span>         
                    </div>
                    <div class="row information">
                          <div class="col-md-12">
                            <div class="col-md-4" ng-repeat="property_facility in property_information.property_facilities[0]">
                                <br><span class="glyphicon glyphicon-chevron-right"></span>
                                <span>{{property_facility}}</span><br><br>
                            </div>
                            <div class="col-md-4" ng-repeat="property_facility in property_information.property_facilities[1]">
                                <br><span class="glyphicon glyphicon-chevron-right"></span>
                                <span>{{property_facility}}</span><br><br>
                            </div>
                            <div class="col-md-4" ng-repeat="property_facility in property_information.property_facilities[2]">
                               <br><span class="glyphicon glyphicon-chevron-right"></span>
                                <span>{{property_facility}}</span><br><br>
                            </div>
                            <div class="col-md-4" ng-if="(!property_information.property_facilities[0].length) &&
                                                         (!property_information.property_facilities[1].length) &&
                                                         (!property_information.property_facilities[2].length)">
                               <br><span class="glyphicon glyphicon-minus-sign"></span>
                               <span>"Not Available"</span><br><br>
                            </div>
                        </div>
                    </div>
		</div>
        </div><br>
	<div class="row clearfix">
               <div class="col-md-12 column gothic_font">
                    <div class="row title">
                        <span class="gothic_bold_font">Remark</span>         
                    </div>
                    <div class="row information" id='remark'>
                        <br><span ng-bind-html="property_information.Remark"/></div>
		</div>
            </div><br>
        <div class="row clearfix">
		<div class="col-md-12 column gothic_font">
                    <div class="row title">
                        <span class="gothic_bold_font">Mortgage Calculator</span>         
                    </div>
                    <div class="row information">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <br>
                                        <span class="purchase_price_input gothic_bold_font">Purchase Price:</span>
                                        <input type="text" class="gothic_font" id="price" ng-bind='property_information.Converted_Price' value="{{accounting.format(property_information.Converted_Price)}}" disabled><br><br>
                                        <span class="loan_total_input gothic_bold_font">Loan Total:</span>
                                        <input type="text" class="gothic_font" id="loan" ng-bind ='property_information.Total_loan' value="{{accounting.format(property_information.Total_loan)}}" disabled><br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <br>
                                        <input gothic_font" type="radio" name="loan_calc_type" value="loan_percentage" ng-model ="loan_measurement_type"> <span class="loan_percentage_input">loan in percentage(%)</span>
                                        <input ng-disabled="loan_measurement_type != 'loan_percentage'" id="txtPercentage" class="currencyOnly gothic_font" ng-model="property_information.percentage_value" value='{{property_information.percentage_value}}'><br><br>
                                        <input class="gothic_font" type="radio" name="loan_calc_type" value="loan_total" ng-model="loan_measurement_type"> <span class="loan_loaned_total_input">loan in total</span>
                                        <input ng-disabled="loan_measurement_type != 'loan_total'" ng-model="property_information.Total_loan" value='{{property_information.total_loan_value}}' id="txtLoanTotal" class="currencyOnly gothic_font"><br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <br>
                                        <span class="interest_rate_input gothic_bold_font currencyOnly">interest rate (%):</span>
                                        <input type="text" class="currencyOnly gothic_font" id="txtInterest" ng-model='property_information.interest_rate'><br>
                                    </div>
                                </div>
                                 <div class="row">
                                    <div class="col-md-12">
                                        <br><span class="loan_period_input gothic_bold_font currencyOnly">loan period (years):</span>
                                        <input type="text" class="numericOnly gothic_font" id="txtLoanPeriod" ng-model='property_information.years'><br>
       
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <br>
                                        <span class="monthly_installment_input gothic_bold_font">Monthly installment</span>
                                        <input type="text" class="gothic_font" id="price" ng-bind='property_information.installment' value="{{accounting.format(property_information.installment)}}" disabled><br><br>
                                        
       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
		</div>
	</div><br>
       <div id="nearest_place" class="row clearfix">
                <div class="col-md-12 column gothic_font">
                    <div class="row title">
                        <span class="gothic_bold_font">Nearest Place</span>         
                    </div>
                    <div class="row information">
                        <br>
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
                                <div class="nearest_details col-md-12">
                                    <br>
                                    <div class="col-md-4" ng-repeat="place in property_information.NearbyPlaces"
                                     ng-if="place.types[0] =='subway_station' || place.types[0]=='bus_station' ||
                                     place.types[0] == 'train_station' || place.types[0] == 'taxi_stand' || place.types[0] == 'airport'">
                                        <span class="icon-large icon-train" aria-hidden="true" ng-if="place.types[0] == 'train_station'">

                                         </span>
                                         <span class="icon-large icon-busalt" aria-hidden="true" ng-if="place.types[0] == 'bus_station'">

                                         </span>
                                        <span class="icon-large icon-metro-subway" aria-hidden="true" ng-if="place.types[0] == 'subway_station'">

                                         </span>
                                        <span  class="icon-large  icon-automobile-car" aria-hidden="true" ng-if="place.types[0] == 'taxi_stand'">

                                         </span>
                                        <span  class="icon-large icon-plane" aria-hidden="true" ng-if="place.types[0] == 'airport'">

                                         </span>
                                        <span ng-if='place.has_detail' ng-click='show_map(place.detail.geometry.location.lat(), place.detail.geometry.location.lng());'  class="place_name gothic_font">{{place.name}}<br><br></span>
                                        <span ng-if='!place.has_detail'   class="place_name non_clickable gothic_font">{{place.name}}<br><br></span>
                                    </div>

                                    <div class="col-md-4 location">
                                        <span style="display: none">"{{place.detail.geometry.location}}"</span>
                                    </div>

                                </div>
                                

                            </div>
                            <div role="tabpanel" class="tab-pane" id="schools">
                                <div class="nearest_details col-md-12"><br>
                                    <div class="col-md-4"  ng-repeat="place in property_information.NearbyPlaces" 
                                     ng-if="(place.types[0]=='school' || place.types[0]=='university')">
                                        <img width='14px' height='auto' src='images/uni.jpg' alt='university'>

                                        <span ng-if='place.has_detail' ng-click='show_map(place.detail.geometry.location.lat(), place.detail.geometry.location.lng())' class="place_name gothic_font">{{place.name}} {{count}}<br><br></span>                                        
                                        <span ng-if='!place.has_detail'   class="place_name non_clickable gothic_font">{{place.name}} {{count}}<br><br></span>
                                    </div>
      
<!--                                     <div class="col-md-4 location">
                                        <span style="display: none">"{{place.detail.geometry.location}}"</span>
                                    </div>-->

                                </div>

                            </div>
                            <div role="tabpanel" class="tab-pane" id="shopping_malls">
                                 <div class="nearest_details col-md-12"><br>
                                    <div class="col-md-4"   ng-repeat="place in property_information.NearbyPlaces" 
                                      ng-if="place.types[0]=='shopping_mall'">

                                        <span class="icon-shoppingcartalt" aria-hidden="true">

                                         </span>
                                        <span ng-if='place.has_detail' ng-click='show_map(place.detail.geometry.location.lat(), place.detail.geometry.location.lng());' class="place_name gothic_font">{{place.name}}<br><br></span>
                                        <span ng-if='!place.has_detail'   class="place_name non_clickable gothic_font">{{place.name}}<br><br></span>
                                    </div>
                                     
<!--                                     <div class="col-md-4 location gothic_font">
                                        <span style="display: none">"{{place.detail.geometry.location}}"</span>
                                    </div>-->

                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="medicals">
                                 <div class="nearest_details  col-md-12"><br>
                                    <div class="col-md-4" ng-repeat="place in property_information.NearbyPlaces" 
                                        ng-if="place.types[0]=='hospital'">
                                        <span class='icon-hospital' aria-hidden="true"></span>
                                        <span ng-if='place.has_detail' ng-click='show_map(place.detail.geometry.location.lat(), place.detail.geometry.location.lng());' class="place_name">{{place.name}}<br><br></span>
                                        <span ng-if='!place.has_detail'   class="place_name non_clickable gothic_font">{{place.name}}<br><br></span>
                                    </div>
<!--                                    <div class="col-md-4 location gothic_font">
                                        <span style="display: none">"{{place.detail.geometry.location}}"</span>
                                    </div>-->

                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="banks">
                                <div class="nearest_details col-md-12"><br>
                                    <div class="col-md-4" ng-repeat="place in property_information.NearbyPlaces" 
                                        ng-if="place.types[0]=='bank'">
                                        <span class="icon-moneybag" aria-hidden="true">

                                         </span>
                                        <span ng-if='place.has_detail' ng-click='show_map(place.detail.geometry.location.lat(), place.detail.geometry.location.lng());' class="place_name gothic_font">{{place.name}}<br><br></span>
                                        <span ng-if='!place.has_detail'   class="place_name non_clickable gothic_font">{{place.name}}<br><br></span>
                                    </div>
                                     

                                </div>
                            </div>
                           <!--gas_stations-->   
                           <div role="tabpanel" class="tab-pane" id="gas_stations">
                                <div class="nearest_details col-md-12"><br>
                                    <div class="col-md-4" ng-repeat="place in property_information.NearbyPlaces" 
                                        ng-if="place.types[0]=='gas_station'">

                                        <span class="icon-gasstation" aria-hidden="true">

                                         </span>
                                        <span ng-if='place.has_detail' ng-click='show_map(place.detail.geometry.location.lat(), place.detail.geometry.location.lng());' class="place_name gothic_font">{{place.name}}<br><br></span>
                                        <span ng-if='!place.has_detail'   class="place_name non_clickable gothic_font">{{place.name}}<br><br></span>
                                    </div>
                                     
                                </div>
                            </div>
                          </div>

                        </div>
                    </div>
                </div>
        </div>
</div>

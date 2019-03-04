<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

<div class="container" ng-app="user_profileApp" ng-controller="previewPage" style="background-color: white;">
    <div class="row clearfix information">
        <div class="col-md-12 column">
            <div class="row clearfix">
                <div class="col-md-6 column">
                    <h2>{{property_information.PropertyName}}</h1>
                    <h4>
                        <small class="subtext utility">{{property_information.Area}} &nbsp;</small>
                        <small class="InsideContent subtext utility">
                        <i class="fas fa-bed"></i>    {{property_information.RoomCount}}</small>
                        <small class="InsideContent subtext utility">
                        <i class="fa fa-bath"></i>    {{property_information.ToiletCount}}</small>
                        <small class="InsideContent subtext utility">
                        <i class="fas fa-car"></i>    {{property_information.ParkingCount}}</small>
                    </h4>
                </div>
                <div class="text-align-left col-md-6 column">
                    <h2>{{property_information.ToCurrency}} &nbsp;<span ng-bind="accounting.format(property_information.Converted_Price)"></span></h2>
                    <h4 class="PricePer gothic_font"><span ng-bind="property_information.ToCurrency"></span>&nbsp;<span class="sell">{{accounting.format(property_information.PricePer)}}</span> <span class="sell">per sqrt</span></h4>
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
                </div>
                <br><br>
            </div>
        </div>
    </div><br>
    <div class="row clearfix information">
        <div class="col-md-12 column">
            <div class="row clearfix">
                <div class="col-md-6-table column">
                <ul class="nav nav-tabs detail-tabs" role="tablist"> 
                    <li class="nav-item active"> 
                        <a class="nav-link active detail-tab-color" style="border-radius: 0px; margin-right: auto;" href="#details" data-toggle="tab" role="tab" aria-controls="details" aria-expanded="true">Details</a> 
                    </li>

                    <li class="nav-item"> 
                        <a class="nav-link detail-tab-color" style="border-radius: 0px; margin-right: auto;" href="#facilities" data-toggle="tab" role="tab" aria-controls="facilities" aria-expanded="true">Facilities</a> 
                    </li>

                    <li class="nav-item"> 
                        <a class="nav-link detail-tab-color" style="border-radius: 0px; margin-right: auto;" href="#remarks" data-toggle="tab" role="tab" aria-controls="remarks" aria-expanded="true">Remarks</a> 
                    </li>
                </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-content" style="padding-left: 12px; margin-top: -2px;">
        <div class="tab-pane active tab-content-size" role="tabpanel" aria-labelledby="details-tab" id="details">
            <div class="row content-style"> 
                <div class="alert alert-info tab-content-alert">
                    <div class="row information" style="background-color: transparent;">
                        <br>
                        <div class="col-md-4 column gothic_font">
                            <div class="row-fluid" ng-repeat="detail in property_information.details[0]">
                                <div class="{{detail.category}} span6">
                                    <span class="span12 gothic_bold_font" id='lbl_{{detail.id}}'>
                                        {{detail.label}}
                                    </span>
                                </div>
                                <div class="span6 {{detail.category}} column gothic_font">
                                    <span id="{{detail.id}}" ng-if="detail.id == 'built_up' || detail.id == 'land_area'">{{detail.value | number:2}}</span>
                                    <span id="{{detail.id}}" ng-if="detail.id != 'built_up' && detail.id != 'land_area'">{{detail.value}}</span>
                         
                                </div><br>
                            </div>
                        </div>
                        <div class="col-md-4 column gothic_font">
                            <div class="row-fluid" ng-repeat="detail in property_information.details[1]">
                                <div class="{{detail.category}} span6">
                                    <span class="span12 gothic_bold_font" 
                                              id='lbl_{{detail.id}}'>
                                            {{detail.label}}</span>
                                </div>
                                <div class="span6 {{detail.category}} column gothic_font">
                                    <span id="{{detail.id}}">{{detail.value}}</span>
                                </div><br>
                            </div>
                        </div>
                        <div class="col-md-4 column gothic_font">
                            <div class="row-fluid" ng-repeat="detail in property_information.details[2]">
                                <div class="{{detail.category}} span6">
                                    <span class="span12 gothic_bold_font" 
                                              id='lbl_{{detail.id}}'>
                                            {{detail.label}}</span>
                                </div>
                                <div class="span6 {{detail.category}} column gothic_font">
                                    <span id="{{detail.id}}">{{detail.value}}</span>
                                </div><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane tab-content-size" role="tabpanel" aria-labelledby="facilities-tab" id="facilities">
            <div class="row content-style"> 
                <div class="alert alert-info tab-content-alert" style="padding-bottom: 30px;">
                    <div class="row information" style="background-color: transparent;">
                          <div class="col-md-12">
                            <div class="col-md-3" ng-repeat="property_facility in property_information.property_facilities[0]">
                                <br>
                                <span>{{property_facility}}</span>
                            </div>
                            <div class="col-md-3" ng-repeat="property_facility in property_information.property_facilities[1]">
                                <br>
                                <span>{{property_facility}}</span>
                            </div>
                            <div class="col-md-3" ng-repeat="property_facility in property_information.property_facilities[2]">
                               <br>
                               <span>{{property_facility}}</span>
                            </div>
                            <div class="col-md-3" ng-repeat="property_facility in property_information.property_facilities[3]">
                               <br>
                               <span>{{property_facility}}</span>
                            </div>
                            <div class="col-md-3" ng-repeat="property_facility in property_information.property_facilities[4]">
                               <br>
                               <span>{{property_facility}}</span>
                            </div>
                            <div class="col-md-3" ng-if="(!property_information.property_facilities[0].length) &&
                                                         (!property_information.property_facilities[1].length) &&
                                                         (!property_information.property_facilities[2].length) &&
                                                         (!property_information.property_facilities[3].length) &&
                                                         (!property_information.property_facilities[4].length)">
                                <br><span class="glyphicon glyphicon-minus-sign"></span>
                                <span>"Not Available"</span><br>
                            </div><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane tab-content-size" role="tabpanel" aria-labelledby="remarks-tab" id="remarks">
            <div class="row content-style"> 
                <div class="alert alert-info tab-content-alert" style="padding-bottom: 20px;">
                    <div class="row information" style="background-color: transparent;">
                        <br><span ng-bind-html="property_information.Remark"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="map-outline-style">
            <div class="title-bar">
                Map &amp; Nearby
                <a ng-if='my_position.latitude === null && my_position.longitude === null' ng-href='http://maps.google.com/maps?q={{country_state.location["k"]}},{{country_state.location["B"]}}&ll={{country_state.location["k"]}},{{country_state.location["B"]}}&z=17'> <button class="navigatemap-btn">Navigate</button></a>
            </div>
            <div class="row content-style map-content"> 
                <div class="alert alert-info tab-content-alert">
                    <div id="map_canvas" class="map_canvas_group" class="row clearfix">
                        <ui-gmap-google-map center="map.center" zoom="map.zoom" draggable="true" options="options" control="googleMap">
                            <ui-gmap-marker coords="marker.coords" options="marker.options" 
                                    events="marker.events" idkey="marker.id" control="googleMarker">
                            </ui-gmap-marker>
                        </ui-gmap-google-map>
                    </div>
                </div>
            </div>
            <!-- To display list of nearby places -->
            <div class="row clearfix">
                <div class="col-md-6-table column">
                    <ul class="nav nav-tabs detail-tabs detail-map-tabs" role="tablist"> 
                        <li class="nav-item active"> 
                            <a class="nav-link active detail-tab-color" style="border-radius: 0px; margin-right: auto;" href="#transport" data-toggle="tab" role="tab" aria-controls="transport" aria-expanded="true">Transportation</a> 
                        </li>

                        <li class="nav-item"> 
                            <a class="nav-link detail-tab-color" style="border-radius: 0px; margin-right: auto;" href="#education" data-toggle="tab" role="tab" aria-controls="education" aria-expanded="true">Education</a> 
                        </li>

                        <li class="nav-item"> 
                            <a class="nav-link detail-tab-color" style="border-radius: 0px; margin-right: auto;" href="#shopping" data-toggle="tab" role="tab" aria-controls="shopping" aria-expanded="true">Shopping</a> 
                        </li>

                        <li class="nav-item"> 
                            <a class="nav-link detail-tab-color" style="border-radius: 0px; margin-right: auto;" href="#bank" data-toggle="tab" role="tab" aria-controls="bank" aria-expanded="true">Bank</a> 
                        </li>

                        <li class="nav-item"> 
                            <a class="nav-link detail-tab-color" style="border-radius: 0px; margin-right: auto;" href="#medical" data-toggle="tab" role="tab" aria-controls="medical" aria-expanded="true">Medical</a> 
                        </li>

                        <li class="nav-item"> 
                            <a class="nav-link detail-tab-color" style="border-radius: 0px; margin-right: auto;" href="#petrol" data-toggle="tab" role="tab" aria-controls="petrol" aria-expanded="true">Petrol Station</a> 
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active tab-content-size map-tab-content-size" role="tabpanel" aria-labelledby="transport-tab" id="transport">
                            <div class="row content-style"> 
                                <div class="alert alert-info tab-content-alert">
                                    <div class="row information" style="background-color: transparent;">
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
                            </div>
                        </div>
                        <div class="tab-pane tab-content-size map-tab-content-size" role="tabpanel" aria-labelledby="education-tab" id="education">
                            <div class="row content-style"> 
                                <div class="alert alert-info tab-content-alert">
                                    <div class="row information" style="background-color: transparent;">
                                        <br>
                                        <div class="col-md-4"  ng-repeat="place in property_information.NearbyPlaces" 
                                          ng-if="(place.types[0]=='school' || place.types[0]=='university')">
                                            <img width='14px' height='auto' src='images/uni.jpg' alt='university'>

                                            <span ng-if='place.has_detail' ng-click='show_map(place.detail.geometry.location.lat(), place.detail.geometry.location.lng())' class="place_name gothic_font">{{place.name}} {{count}}<br><br></span>                                        
                                            <span ng-if='!place.has_detail'   class="place_name non_clickable gothic_font">{{place.name}} {{count}}<br><br></span>
                                        </div>
                                        <!--<div class="col-md-4 location">
                                            <span style="display: none">"{{place.detail.geometry.location}}"</span>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane tab-content-size map-tab-content-size" role="tabpanel" aria-labelledby="shopping-tab" id="shopping">
                            <div class="row content-style"> 
                                <div class="alert alert-info tab-content-alert">
                                    <div class="row information" style="background-color: transparent;">
                                        <br>
                                        <div class="col-md-4"   ng-repeat="place in property_information.NearbyPlaces" 
                                          ng-if="place.types[0]=='shopping_mall'">

                                            <span class="icon-shoppingcartalt" aria-hidden="true">

                                             </span>
                                            <span ng-if='place.has_detail' ng-click='show_map(place.detail.geometry.location.lat(), place.detail.geometry.location.lng());' class="place_name gothic_font">{{place.name}}<br><br></span>
                                            <span ng-if='!place.has_detail'   class="place_name non_clickable gothic_font">{{place.name}}<br><br></span>
                                        </div>
                                         
                                        <!--<div class="col-md-4 location gothic_font">
                                            <span style="display: none">"{{place.detail.geometry.location}}"</span>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane tab-content-size map-tab-content-size" role="tabpanel" aria-labelledby="bank-tab" id="bank">
                            <div class="row content-style"> 
                                <div class="alert alert-info tab-content-alert">
                                    <div class="row information" style="background-color: transparent;">
                                        <br>
                                        <div class="col-md-4" ng-repeat="place in property_information.NearbyPlaces" 
                                          ng-if="place.types[0]=='bank'">
                                            <span class="icon-moneybag" aria-hidden="true">

                                            </span>
                                            <span ng-if='place.has_detail' ng-click='show_map(place.detail.geometry.location.lat(), place.detail.geometry.location.lng());' class="place_name gothic_font">{{place.name}}<br><br></span>
                                            <span ng-if='!place.has_detail'   class="place_name non_clickable gothic_font">{{place.name}}<br><br></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane tab-content-size map-tab-content-size" role="tabpanel" aria-labelledby="medical-tab" id="medical">
                            <div class="row content-style"> 
                                <div class="alert alert-info tab-content-alert">
                                    <div class="row information" style="background-color: transparent;">
                                        <br>
                                        <div class="col-md-4" ng-repeat="place in property_information.NearbyPlaces" 
                                          ng-if="place.types[0]=='hospital'">
                                            <span class='icon-hospital' aria-hidden="true"></span>
                                            <span ng-if='place.has_detail' ng-click='show_map(place.detail.geometry.location.lat(), place.detail.geometry.location.lng());' class="place_name">{{place.name}}<br><br></span>
                                            <span ng-if='!place.has_detail'   class="place_name non_clickable gothic_font">{{place.name}}<br><br></span>
                                        </div>
                                        <!--<div class="col-md-4 location gothic_font">
                                                <span style="display: none">"{{place.detail.geometry.location}}"</span>
                                            </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane tab-content-size map-tab-content-size" role="tabpanel" aria-labelledby="petrol-tab" id="petrol">
                            <div class="row content-style"> 
                                <div class="alert alert-info tab-content-alert">
                                    <div class="row information" style="background-color: transparent;">
                                        <br>
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
        
        <div class="map-outline-style">
            <div class="title-bar">
                <span class="gothic_bold_font">Mortgage Calculator</span>
            </div>
            <p class="description-bar"> Update the details below to calculate your home loan repayments.</p>
            <div class="row content-style mortage-cal-outline-style"> 
                <div class="alert alert-info tab-content-alert" style="padding-bottom: 30px;">
                    <div class="row information" style="background-color: transparent;">
                        <ul class="calculator-text">
                            <li >
                                <span class="purchase_price_input gothic_bold_font">Purchase Price:</span>
                                <input type="text" class="gothic_font" ng-bind='property_information.Converted_Price' value="{{accounting.format(property_information.Converted_Price)}}" disabled><br><br>
                            </li>
                            <li>
                                <span class="interest_rate_input gothic_bold_font currencyOnly">interest rate (%):</span>
                                <input type="text" class="currencyOnly gothic_font" id="txtInterest" ng-model='property_information.interest_rate'><br><br>
                            </li>
                            <li>
                                <span class="loan_period_input gothic_bold_font currencyOnly">loan period (years):</span>
                                <input type="text" class="numericOnly gothic_font" id="txtLoanPeriod" ng-model='property_information.years'><br><br>
                            </li>
                            <li>
                                <span class="monthly_installment_input gothic_bold_font">Monthly installment</span>
                                <input type="text" class="gothic_font" ng-bind='property_information.installment' value="{{accounting.format(property_information.installment)}}" disabled>
                            </li>
                            <li>
                                <span class="loan_total_input gothic_bold_font">Loan Total:</span>
                                <input type="text" class="gothic_font" id="loan" ng-bind ='property_information.Total_loan' value="{{accounting.format(property_information.Total_loan)}}" disabled><br><br>
                                <input gothic_font" type="radio" name="loan_calc_type" value="loan_percentage" ng-model ="loan_measurement_type"> <span class="loan_percentage_input">loan in percentage(%)</span>
                                <input ng-disabled="loan_measurement_type != 'loan_percentage'" id="txtPercentage" class="currencyOnly gothic_font" ng-model="property_information.percentage_value" value='{{property_information.percentage_value}}'><br><br>
                                <input class="gothic_font" type="radio" name="loan_calc_type" value="loan_total" ng-model="loan_measurement_type"> <span class="loan_loaned_total_input">loan in total</span>
                                <input ng-disabled="loan_measurement_type != 'loan_total'" ng-model="property_information.Total_loan" value='{{property_information.total_loan_value}}' id="txtLoanTotal" class="currencyOnly gothic_font"><br><br>
                            </li>
                        </ul>
                          </div>
                </div>
            </div>
        </div>
        <div class="contact-outline-style">
            <div class="title-bar">
                <span class="gothic_bold_font">Contact Information</span>
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
                                <div class="row" style="padding: 10px;">
                                    <button ng-disabled="!enabled_contact" class="contact-btn" id="contact" ng-disabled="disable_button" ng-click="contact_click()" type="button" >Contact</button><br>
                                </div>
                        
                            </div>
                            <div class="col-lg-4 col-md-6 profile" style="display: none">
                                
                                <div class="row">
                                    <img class="pull-right" src="images/user_profile_big.png" width="80px"/>
                                </div>
       
                                 
                            </div>
                            
                        </div>
        </div>
        <div class="social-outline-style">
            <div class="title-bar">
                <span class="gothic_bold_font">Social Media</span>
            </div>
            <div class="row information">
                <br>
                <div class="g-plus col-md-4  col-sm-4 col-sm-4 column">
                    <div class="g-plus" data-action="share" data-annotation="bubble" ></div>
                </div>
                <div class="twitter col-md-4  col-sm-4 col-sm-4 column">
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
                    <div class="fb-share-button" data-href="{{current_url}}" data-layout="button_count"></div>
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
            </div>
        </div>

        <div class="row clearfix">
        
        </div><br>
        
        <div id="popup_property_contact" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <center>
                <div id="property_preview" class="modal-dialog modal-lg popup">
                      <div class="modal-header">
                        <button class="property_info close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only">Close</span>
                        </button>
                        
                    </div>
                    <div class="modal-body">
                        <input type="text" id="send_contact_name"
                               ng-keypress="validate_sending_contact_details()"
                               class="contact_owner_required_data form-control" placeholder="Please insert your name"/><br/>
                        <input type="text" id="send_contact_phone" 
                               ng-keypress="validate_sending_contact_details()" 
                               class="contact_owner_required_data phoneOnly form-control" placeholder="Please insert handphone contact"/><br/>
                        <textarea class="contact_owner_required_data form-control" id="send_contact_comment" ng-keypress="validate_sending_contact_details()">
I am interested in your property.&#13;&#10;Please contact me if the listed property is still available.&#13;&#10;Thank you &#38; have a nice day 
                        </textarea><br/><br/>
                        <div id="send_contact_captcha">
                        </div><br/>
                        <div id="send_status_msg">
                        </div><br/>
                        <button id="send_contact" type="button" class="btn" ng-click="send_contact_click()"
                                disabled>SEND</button><br/><br/>
                    </div>
                </div>
            </center>
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
        <div id="popup_google_location" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <center>
                <div id="google_location" class="modal-dialog modal-lg popup">
                      <div class="modal-header">
                        <button class="property_info close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only">Close</span>
                        </button>
                        
                    </div>
                    <div class="modal-body">
                        <div id="google_location_content">
                            <iframe id='frameMap' frameborder="0" seamless 
                                    width="300px" height="300px"></iframe>
                        </div>
                    </div>
                     <div class="modal-footer">
                        <center>
                            
                            <button class="cancel_google_location_type btn" data-dismiss="modal" type="button">Cancel</button>
                            
                            <a ng-if='my_position == null && my_position.longitude == null' href="http://maps.google.com/maps?q={{gps.lat}},{{gps.lgt}}&ll={{gps.lat}},{{gps.lgt}}&z=17" class="navigate_button btn btn-warning" type="button">Navigate</a>
                            <a ng-if='my_position.latitude != null && my_position.longitude != null' href="https://maps.google.com/maps?f=d&saddr={{my_position.latitude}},{{my_position.longitude}}&daddr={{gps.lat}},{{gps.lgt}}" class="navigate_button btn btn-warning" type="button">Navigate</a>
                            
                            <br>
                        </center>
                    </div>
                </div>
            </center>
        </div>
       </div><br/>
</div>

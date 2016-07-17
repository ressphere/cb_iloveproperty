<div id="user_profile" class="unfixed_content content container" ng-app="ProfileApps" ng-controller="ProfileController">
	<!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li ng-repeat="service in services">
                    <a class="page-scroll" href="#{{service.id}}">{{service.name}}</a>
                </li>
            </ul>
        </div>
         <div  class="sidebar_toggle">
                 <button id ="menu-toggled" type="button" class="btn btn-default btn-xs">
                    <span class="glyphicon glyphicon-list"></span>
                 </button>
         </div>
                
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
             <section id="{{service.id}}" class="{{service.id}}-section section"  ng-repeat="service in services">
                <div class="container">
                    <div class="row">
                        <div class="section-content">
						    <div id="section_in_profile" class="row">
								<div>
									<h1>{{service.name}} <a class="btn btn-xs btn-success" role="button" ng-if='key_available_for_service_map_with_url(service.link_id)' target='_self' href ='{{service_map_with_url[service.link_id]}}' >Launch {{service.link_id}}</a></h1> 
								</div>
							</div>
                            <div class="row" ng-if="id == 'username'" ng-repeat="(id, info) in service">
                                <div id="username_in_profile" class="col-md-2">{{info}}</div>
                                <a class="col-md-8"> 
                                    <span id="change_pwd_req">
                                        <button id="chpass_in_profile">change your password</button>
                                    </span>
                                </a>
                            </div>
                            <div id="general_info_in_profile" class="row" ng-if="id != 'username' && id != 'password' && id != 'name' && id !='link_id' && id !='id' && id !='active' && id != 'information'" ng-repeat="(id, info) in service">
				<div class="col-md-2">{{id}}</div>
                                <div class="col-md-8">{{info}}</div>
                            </div><br/>
                            <div class="row" ng-if="id == 'information'" ng-repeat="(id, info) in service">
                                <div class="tabbable" id="tabs-123805">
                                    <ul class="nav nav-tabs">
                                        <li class="active" ng-if="detail.active == 'true'" ng-repeat='(detail_id, detail) in info'>
                                            <a href="#{{detail_id}}" data-toggle="tab">{{detail_id}}&nbsp;<span class="badge" ng-if="detail_id == 'listings'">{{available_listing_count}}</span></a>
                                        </li>
                                        <li ng-if="detail.active == 'false'" ng-repeat='(detail_id, detail) in info'>
                                            <a href="#{{detail_id}}" data-toggle="tab">{{detail_id}}&nbsp;<span class="badge" ng-if="detail_id == 'listings'">{{available_listing_count}}</span></a>
                                        </li>
                                    </ul>
                                    <div  class="tab-content">
                                        <div class="tab-pane" id="{{detail_id}}" ng-if="detail.active == 'false' && detail.url != ''" 
                                            ng-include="detail.url" ng-repeat='(detail_id, detail) in info'>
                                            
                                        </div>
                                        <div class="tab-pane" id="{{detail_id}}" ng-if="detail.active == 'false' && detail.url == ''" 
                                            ng-repeat='(detail_id, detail) in info'>
                                            
                                        </div>
                                        <div class="tab-pane active" id="{{detail_id}}" ng-if="detail.active == 'true' && detail.url == ''" 
                                             ng-repeat='(detail_id, detail) in info'>
                                            
                                        </div>
                                        <div class="tab-pane active" id="{{detail_id}}" ng-if="detail.active == 'true'" 
                                             ng-include="detail.url" ng-repeat='(detail_id, detail) in info'>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div><br/>
                            
                            
                        </div>
                    </div>
                </div>
            </section>
            
        </div>
</div>
<div id="popup_property_preview" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <center>
                <div id="property_preview" class="modal-dialog modal-lg popup">
                      <div class="modal-header">
                        <button class="property_info close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only">Close</span>
                        </button>
                        
                    </div>
                    <div class="modal-body">
                        <div id="property_preview_content">
                            <iframe id="property_preview_content_iframe" frameborder="0" seamless 
                                    width="100%" height="100%"></iframe>
                        </div>
                    </div>
                </div>
            </center>
</div>
        <!-- /#page-content-wrapper -->
<!--        </div>-->
<div class="row clearfix" ng-if="key=='listings'" ng-repeat="(key, info_listing) in info" >
    <div class="col-md-12 column" ng-if="key=='listing'" ng-repeat="(key, listing) in info_listing" id="record_list">
        <div class="col-md-8 column">
            <div class="col-md-4 column gothic_bold_font" >
                <p class="ng-binding">Ref No</p>
            </div>
            <div class="col-md-4 column gothic_bold_font">
                <p class="ng-binding" >Name</p>
            </div>
            <div class="col-md-2 column gothic_bold_font" >
                <p class="ng-binding">Price</p>
            </div>
            <div class="col-md-2 column gothic_bold_font" >
                <p class="ng-binding">Active</p>
            </div>
        </div>
        
        <div ng-repeat="data in listing">
		<div class="col-md-8 column">
                    <div class="col-md-4 column">
                        <input type="checkbox" name="del_option" value="{{data.ref_tag}}" style="width:50px; box-shadow: 0 0 0">{{data.ref_tag}}
                        <span> ( </span>
                        <a href="{{ref_tag_details+data.ref_tag}}">View</a>
                        <span> | </span>
                        <a href="{{edit_details+data.ref_tag}}">Edit</a>
                        <span> ) </span> <br>
                    </div>
                    <div class="col-md-4 column">
                        <span>
                            {{data.property_name}}<br>
                        </span>
                    </div>
                    <div class="col-md-2 column">
                        <span>
                            {{data.price}}<br>
                        </span>
                    </div>
                    <div class="col-md-2 column">
                        <span>
                            {{data.activate}}<br>
                        </span>
                    </div>
		</div>
	</div>
        <div class="col-md-2">
            <button class="btn btn-primary" type="button" ng-click='rm_record("listing")'> Remove </button>
        </div>
        
        <div id="Remove_Record_Message">
        
        </div>
    </div>
</div>
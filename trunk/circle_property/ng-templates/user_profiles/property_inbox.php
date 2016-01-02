<div class="row clearfix" ng-if="key=='inbox'" ng-repeat="(key, inbox) in info">
    <div class="col-md-12 column" ng-if="key=='email'" ng-repeat="(key, email) in inbox" id="record_list">
        <div class="col-md-8 column">
            <div class="col-md-4 column gothic_bold_font" >
                <p class="ng-binding">Ref No</p>
            </div>
            <div class="col-md-4 column gothic_bold_font">
                <p class="ng-binding" >Title</p>
            </div>
            <div class="col-md-2 column gothic_bold_font" >
                <p class="ng-binding">From</p>
            </div>
            <div class="col-md-2 column gothic_bold_font" >
                <p class="ng-binding">Date</p>
            </div>
        </div>
        
        <div ng-repeat="data in email">
		<div class="col-md-8 column">
                    <div class="col-md-4 column">
                        <input type="checkbox" name="del_option" value="{{data.ref_tag}}" style="width:50px; box-shadow: 0 0 0">{{data.ref_tag}}<br>
                    </div>
                    <div class="col-md-4 column">
                        <span>
                            {{data.title}}<br>
                        </span>
                    </div>   
                    <div class="col-md-2 column">
                        <span>
                            {{data.sender}}<br>
                        </span>
                    </div> 
                    <div class="col-md-2 column">
                        <span>
                            {{data.date}}<br>
                        </span>
                    </div>
                </div>
	</div>
        <div class="col-md-2">
            <button class="btn btn-primary" type="button" ng-click='rm_record("mail")'> Remove </button>
        </div>
        
        <div id="Remove_Record_Message">
        
        </div>
    </div>
</div>
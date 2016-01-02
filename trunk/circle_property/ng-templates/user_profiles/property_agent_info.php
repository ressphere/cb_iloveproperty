<div class="row clearfix" ng-if="key=='home'" ng-repeat="(key, data) in info">
    <div class="col-md-12 column">
	<div style='margin-bottom:58px' class="row clearfix">
		<div class="col-md-2 column">
                    <img style='margin-left:44.56px;margin-top:33.533px' height='144' 
                         src={{data.agent_photo}}>
		</div>
		<div class="col-md-6 column">
                    <div style='margin-left:45.221px;margin-top:80px'>
                        <span>
                            {{data.agent_name}}<br>
                            {{data.company_name}}
                        </span>
                    </div>                    
		</div>
		<div class="col-md-4 column">
                    {{data.company_logo}}
		</div>
	</div>
	<div class="row clearfix">
            <div class="col-md-12 column">
                {{data.description}}
	    </div>
	</div>
    </div>
</div>
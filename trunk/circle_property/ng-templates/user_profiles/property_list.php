<div class="row clearfix" ng-if="key=='listings'" ng-repeat="(key, info_listing) in info" >
    <div class="col-md-12 column" ng-if="key=='listing'" ng-repeat="(key, listing) in info_listing" id="record_list">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Ref No.</th>
                <th></th>
                <th>Name</th>
                <th>Price</th>
                <th>Active</th>
              </tr>
            </thead>
            <tbody  ng-repeat="data in listing | filter:{ref_tag:'RSP'}">
              <tr>
                <td>
<!--                    <div class="checkbox">
                        <label><input type="checkbox" name="del_option" value="{{data.ref_tag}}">{{data.ref_tag}}</label>
                    </div>-->
                     <input type="checkbox" name="del_option" value="{{data.ref_tag}}" style="width:50px; box-shadow: 0 0 0">{{data.ref_tag}}
                </td>
                <td>
                     <a class="view_{{data.ref_tag}}" href="{{ref_tag_details+data.ref_tag}}">View</a>
                     <span class="view_{{data.ref_tag}}"> | </span>
                     <a target='_self' href="{{edit_details+data.ref_tag}}">Edit</a>
                </td>
                <td>
                    <span>
                      {{data.property_name}}<br>
                    </span>
                </td>
                <td>
                   <span>
                       {{data.price}}<br>
                   </span>
                </td>
                <td>
                    <span ng-if="data.activate == 1">
                        <!-- Rounded switch -->
                        <label class="switch">
                          <input id="chk_{{data.ref_tag}}" class="listing_activation" type="checkbox" checked ng-click="activate(data.ref_tag)">
                          <div class="slider round"></div>
                        </label>
                    </span>
                    <span ng-if="data.activate == 0">
                        <!-- Rounded switch -->
                        <label class="switch">
                            <input id="chk_{{data.ref_tag}}" class="listing_activation" type="checkbox" ng-click="activate(data.ref_tag)">
                            <div class="slider round"></div>
                        </label>
                    </span>
                </td>
              </tr>
            </tbody>
        </table>
        <div class="row">
            <button id="btn_delete" ng-disabled="delete_btn" class="btn btn-danger" type="button" ng-click='rm_record("listing")'> Remove </button>
        </div>
    </div>
</div>
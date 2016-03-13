var get_upload_reached_limit_home = function() {
        return {
            Extends: get_base(),
            Initialize: function( private ){       
                this.parent.Initialize();
            },
            Private:{
                
            },
            Public:{         
            }
        };
 };

var StaticUploadReachedLimitObject = (function () {
        var objUploadReachedLimit;

        function createHomeInstance() {
            var objUploadReachedLimit = $.makeclass(get_upload_reached_limit_home());
            return objUploadReachedLimit;
        }

        return {
            getInstance: function () {
                if (!objUploadReachedLimit) {
                    objUploadReachedLimit = createHomeInstance();
                }
                return objUploadReachedLimit;
            }
        };
})();



$(document).ready(function()
{
   var uploadListing = StaticUploadReachedLimitObject.getInstance();
   $('#btn_profile').click(function()
       {
           var wsdl = uploadListing.getWsdlBaseUrl() + 'index.php/cb_user_profile_update/my_profile#Property_Profile';
           
           window.location.href = wsdl;
       }
    );
   $("#btnBack").click(
      function()
      {
          parent.history.back();
      }
   );
   $("#btnBack").on('focus', function() {$(this).css('outline', 'transparent');});
});


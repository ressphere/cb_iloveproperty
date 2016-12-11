// <editor-fold desc="set google nearby place radius and type(special for property)"  defaultstate="collapsed">
ng_map_profile.config(function(ngGPlacesAPIProvider){
                ngGPlacesAPIProvider.setDefaults({
                radius:1000,
                types:['bank','school','shopping_mall', 'hospital','airport', 'subway_station', 'bus_station','train_station',
                'university', 'taxi_stand', 'gas_station'],
                nearbySearchKeys: ['name', 'reference', 'vicinity', 'types', 'icon']
        });
});
 // </editor-fold>

ng_map_profile.controller('uploadProfile', function($injector, $scope, $controller, ngGPlacesAPI, flowFactory, $http, $sce) {
        $controller('listing_prefix', {$scope: $scope});

        if(typeof ngGPlacesAPI !== 'undefined')
        {
                $controller('google_maps', {$scope: $scope, ngGPlacesAPI:ngGPlacesAPI, flowFactory: flowFactory});
        }
        else
        {
                $controller('google_maps', {$scope: $scope, flowFactory: flowFactory});
        }

        $controller('facilities', {$scope: $scope});
        // <editor-fold desc="configure photo uploader"  defaultstate="collapsed">
        $scope.message = 'uploader';
        $scope.uploader = flowFactory;
        $scope.uploader.opts = {
           target:'/cb_iloveproperty/trunk/client_views/properties_views/index.php/_utils/properties_upload/images',
           testChunks:false,
           simultaneousUploads: 3};
        $scope.person = {
            'email': '',
            'name': '',
            'phone': '',
            'user_id':''
        };
	$scope.back_count = -1;
        $scope.temp_ref = "";
        // </editor-fold>
        // <editor-fold desc="property information column 4"  defaultstate="collapsed">
        $scope.property_category_4 =
                [
                    {
                        id:'street',
                        name:'Street',
                        control:'input-word',
                        category:'sell rent room',
                        placeholder:'Enter your street name',
                        values:
                        [
                            ''
                        ]
                    },
                    {
                        id:'area',
                        name:'Area',
                        control:'input-text',
                        category:'sell rent room',
                        placeholder:'Enter Your Area',
                        values:
                        [
                           ''
                        ]
                    },
                  
                    {
                        id:'postcode',
                        name:'Postcode',
                        control:'input-text',
                        category:'sell rent room',
                        placeholder:'Enter your poscode number',
                        values:
                        [
                            ''
                        ]
                    }
                ];
        // </editor-fold>
        // <editor-fold desc="property information column 3"  defaultstate="collapsed">
        $scope.property_category_3 =
                [
                    {
                        id:'unit_name',
                        name:'Unit Name',
                        control:'input-text',
                        category:'sell rent room',
                        placeholder:'Your Property Name',
                        values:
                        [
                            ''
                        ]
                    },
                    {
                        id:'country',
                        name:'Country',
                        control:'select',
                        category:'sell rent room',
                        values:
                        [
                            'Malaysia'
                        ]
                    },
                    {
                        id:'state',
                        name:'State',
                        control:'select',
                        category:'sell rent room',
                        values:
                        [
                        ]
                    }
                ];
        // </editor-fold>
        // <editor-fold desc="property information column 2"  defaultstate="collapsed">
        $scope.property_category_2 =
                [
                    {
                        id:'bedroom',
                        name:'Bedroom',
                        control:'input-number',
                        category:'sell rent',
                        values:
                        [
                            1,
                            10,
                            3
                        ]
                    },
                    {
                        id:'bathroom',
                        name:'Bathroom',
                        control:'input-number',
                        category:'sell rent room',
                        values:
                        [
                            1,
                            10,
                            2
                        ]   
                    },
                    {
                        id:'car_park',
                        name:'Car Park',
                        control:'input-number',
                        category:'sell rent room',
                        values:
                        [
                            0,
                            10,
                            2
                        ]   
                    },
                    {
                        id:'tenure',
                        name:'Tenure',
                        control:'select',
                        category:'sell',
                        values:
                         [
                            'Freehold',
                            'Leasehold'

                         ]
                    },
                    {
                    id:'land_title_type',
                    name:'Land Title Type',
                    control:'select',
                    category:'sell',
                    values:
                     [
                        'Residential',
                        'Commercial',
                        'Industrial'

                     ]
                    },
                    {
                        id:'furnishing',
                        name:'Furnishing',
                        control:'select',
                        category:'sell rent room',
                        values:
                        [
                            'Full Furnished',
                            'Partially Furnished',
                            'No Furnished'
                        ]             
                    },
                    {
                        id:'occupied',
                        name:'Occupied',
                        control:'select',
                        category:'sell rent room',
                        values:
                        [
                            'No',
                            'Yes'
                        ]
                    }, 
                    {
                        id:'monthly_maintanance',
                        name:'Monthly Maintanance',
                        control:'input-currency',
                        category:'sell ',
                        values:
                        [
                            0.00
                        ]
                    }
                ];
        // </editor-fold>
        // <editor-fold desc="property information column 1"  defaultstate="collapsed">
        $scope.property_category_1=
            [

                {
                    id:'type',
                    name:'Type',
                    control:'select',
                    category:'sell rent room',
                    values:
                    [
                        'Property For Sale',
                        'Property For Lease'
                    ]
                },
                {
                    id:'auction',
                    name:'Auction',
                    control:'input-date',
                    category:'sell',
                    values:
                    [
                        ''
                    ]
                },
                {
                    id:'property_type_sell',
                    name: 'Property Type',
                    control:'select-title',
                    category:'sell',
                    values:
                    {
                         'Apartment/Flat':[
                            'Apartment',
                            'Apartment Duplex',
                            'Flat',
                            'Service Apartment',
                            'Other'
                        ],
                        'Condo/Residence':[
                            'Condo',
                            'Duplex',
                            'Penthouse',
                            'Residence',
                            'Serviced Condo',
                            'Serviced Residence',
                            'Soho',
                            'Studio',
                            'Townhouse Condo',
                            'Triplex',
                            'Other'
                        ],
                        'Semi-D/Banglo':[
                            'Bungalow House',
                            'Country House',
                            'Semi-Detached',
                            'Other'
                        ],
                        'Terrace/Link/Townhouse':[
                             'Single Storey',
                             '1.5 Storey',
                             'Double Storey',
                             '2.5 Storey',
                             'Triple Storey',
                             '3.5 Storey',
                             'quadruple Storey',
                             '4.5 Storey',
                             'Other'
                         ],
                        'Land':[
                            'Aqricultural Land',
                            'Bungalow Land',
                            'Commercial Land',
                            'Residential Land',
                            'Other'
                        ],
                        'Shop':[
                            'Retail Shop',
                            'Shop House',
                            'Shop Lot',
                            'Shopping Mall',
                            'Other'
                        ],
                        'Office':[
                            'Office Lot',
                            'Office Suite',
                            'Soho Office',
                            'Shopping mall',
                            'Other'
                        ],
                        'Industrial':[
                            'Factories',
                            'Light Industrial',
                            'Warehouse',
                            'Other'
                        ],
                        'Hotel':[
                            'Hotel'
                        ]
                    }
                },
                {
                    id:'property_type_rent',
                    name: 'Property Type',
                    control:'select-title',
                    category:'rent',
                    values:
                    {
                        'Apartment/Flat':[
                            'Apartment',
                            'Apartment Duplex',
                            'Flat',
                            'Service Apartment',
                            'Other'
                        ],
                        'Condo/Residence':[
                            'Condo',
                            'Duplex',
                            'Penthouse',
                            'Residence',
                            'Serviced Condo',
                            'Serviced Residence',
                            'Soho',
                            'Studio',
                            'Townhouse Condo',
                            'Triplex',
                            'Other'
                        ],
                        'Semi-D/Banglo':[
                            'Bungalow House',
                            'Country House',
                            'Semi-Detached',
                            'Other'
                        ],
                        'Terrace/Link/Townhouse':[
                             'Single Storey',
                             '1.5 Storey',
                             'Double Storey',
                             '2.5 Storey',
                             'Triple Storey',
                             '3.5 Storey',
                             'quadruple Storey',
                             '4.5 Storey',
                             'Other'
                         ],
                        'Land':[
                            'Aqricultural Land',
                            'Bungalow Land',
                            'Commercial Land',
                            'Residential Land',
                            'Other'
                        ],
                        'Shop':[
                            'Retail Shop',
                            'Shop House',
                            'Shop Lot',
                            'Shopping Mall',
                            'Other'
                        ],
                        'Office':[
                            'Office Lot',
                            'Office Suite',
                            'Soho Office',
                            'Shopping mall',
                            'Other'
                        ],
                        'Industrial':[
                            'Factories',
                            'Light Industrial',
                            'Warehouse',
                            'Other'
                        ],
                        'Hotel':[
                            'Hotel'
                        ],
                        'Room':[
                            'Master',
                            'Junior Master',
                            'Big Room',
                            'Middle Room',
                            'Small Room'
                        ]
                    }
                },
                {
                    id:'size_measurement_code',
                    name:'Size Measure Code',
                    control:'select',
                    category:'sell rent',
                    values:['sqft','m2']
                },
                {
                    id:'built_up',
                    name:'Built Up',
                    control:'input-number',
                    category:'sell rent',
                    values:
                    [
                        1,
                        1000000,
                        1500
                    ]
                },
                {
                    id:'land_area',
                    name:'Land Area',
                    control:'input-number',
                    category:'sell rent',
                    values:
                    [
                        1000,
                        1000000,
                        2000
                    ]
                },
                //Need to load from DB
                {
                    id:'currency',
                    name:'Currency',
                    control:'select',
                    category:'sell rent room',
                    values:
                    [
                        'MYR',
                        'SGD',
                        'USD'
                        
                    ] 
                },
                {
                    id: 'asking_price',
                    name:'Asking Price',
                    control:'input-currency',
                    category:'sell',
                    values:[
                        1000000
                    ]
                },
                {
                    id: 'asking_price_per',
                    name:'Asking Price Per',
                    control:'input-currency',
                    category:'sell',
                    values:[
                       500 
                    ]
                },
                {
                        id:'reserve_type',
                        name:'Reserve Type',
                        control:'select',
                        category:'sell',
                        values:
                        [
                            '--',
                            'BUMI LOT'
                        ]
                        
               },
               {
                    id: 'monthly_rental',
                    name:'Monthly Rental',
                    control:'input-currency',
                    category:'rent room',
                    values:[
                        600
                    ]
                }
            ];
       // </editor-fold>
        $scope.mapping = {
            'Property For Sale':'sell',
            'Property For Lease':'rent',
            'Room To Let':'room',
            'Fully':'Full Furnished',
            'Partially':'Partially Furnished',
            'No':'No Furnished'
            
        };
        $scope.mapping_reverse = {
            'sell':'Property For Sale',
            'rent':'Property For Lease',
            'room':'Room To Let',
            'Full Furnished': 'Fully',
            'Partially Furnished': 'Partially',
            'No Furnished':'No'
        };

        
       // <editor-fold desc="On google map and marker loaded completely"  defaultstate="collapsed">
        angular.element('ui-gmap-google-map').ready(function () {
        //var homeControlDiv = document.createElement('div');
       
       if(Object.keys($scope.googleMap).length > 0)
       {
            var homeControlDiv = document.createElement('div');
            var map = $scope.googleMap.getGMap();

            HomeControl(homeControlDiv, $scope, ngGPlacesAPI);

            homeControlDiv.index = 1;
            map.controls[google.maps.ControlPosition.TOP_RIGHT].push(homeControlDiv);
            //hoke to country change
            $scope.$watchCollection("country_state", function(newVal, oldVal)
            {
                //use jquery to get the ISO 3166-1 Alpha-2 compatible country code and capital location
                
               if(newVal === oldVal)
                   return;
               var objProperty = $.makeclass(get_base());
               objProperty.setWSDL();
               var url = objProperty.getWsdlBaseUrl() + "index.php/base/get_country_short_name";
               senddata = "country=" + newVal.country;
               $http({
                 method: 'POST',
                 url: url,
                 data: senddata,
                 cache: true,
                 headers: {'Content-Type': 'application/x-www-form-urlencoded'}
               }).then(function(response) {
                   if(newVal.short.toLowerCase() !== response.data.toLowerCase())
                       {
                           newVal.short =  response.data.toLowerCase();
                           $scope.google_maps.form.country = newVal.short;
                           $scope.google_maps.options.country = $scope.google_maps.form.country;
                           get_country_location_param = "country_short_name=" + newVal.short.toUpperCase();
                           var url = objProperty.getWsdlBaseUrl() + "index.php/base/get_country_location";
                           $scope.google_maps.autocomplete = '';
                           
                           $http({
                             method: 'POST',
                             url: url,
                             cache: true,
                             data: get_country_location_param,
                             headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                           }).then(function(response) {			   
                               $scope.map.center.latitude = response.data[0];
                               $scope.marker.coords.latitude = response.data[0];
                               $scope.map.center.longitude = response.data[1];
                               $scope.marker.coords.longitude = response.data[1];
                               
                               $scope.googleMarker.getGMarkers()[0].setPosition({lat: $scope.map.center.latitude, lng: $scope.map.center.longitude});
                           });
                           
                       }
  
                }, 
                function(response) { // optional
                    console.log(response);
                }
              );
            });

            $scope.$watchCollection("google_maps.details", function(newVal, oldVal)
            {
                //use jquery to get the ISO 3166-1 Alpha-2 compatible country code and capital location
              if(newVal === oldVal)
                   return;
             
               var found = false;
               for(var i = 0; i < newVal.address_components.length; i++)
               {
                  var component_name = newVal.address_components[i].long_name;
                  
                  $("#state > option").each(function()
                  {
                     
                     if($(this).text() === component_name)
                     {
                         $("#state").val(component_name);
                         found = true;
                      }
                  });
                  if(found) break;
               }
               
            });

            var add_details = function(data, details)
            {
                for(var j=0; j<data.length; j++)
                {
                   if(data[j].has_detail === false)
                   {
                      data[j].detail = details;
                      data[j].has_detail = true;
                      if(data[j].detail.photos)
                      {
                         var temp_photos = [];
                         for(var k = 0; k<data[j].detail.photos.length;k++)
                         {
                             var photo_url = data[j].detail.photos[k].getUrl({
                                 'maxWidth': data[j].detail.photos[k].width, 
                                 'maxHeight': data[j].detail.photos[k].height});
                             temp_photos.push(photo_url);
                         }
                         data[j].detail.photos = temp_photos;
                      }
                      //return data;
                      break;
                   }
                }
            };
            //marker.coords
            $scope.$watchCollection("marker.coords", function(newVal, oldVal)
            {
                if(newVal === oldVal)
                   return;
                else
                {
                    //var callbacks = $.Callbacks();
                    //callbacks.add(add_details);
                    ngGPlacesAPI.nearbySearch(
                    {
                         latitude:newVal.latitude, 
                         longitude:newVal.longitude
                    }
                    ).then(
                        function(data){
                            
                            for (var i = 0; i < data.length; i++) {
                                data[i]['has_detail'] = false;
                                ngGPlacesAPI.placeDetails(
                                {reference:data[i].reference}).then(
                                    function (details) {
                                        add_details(data, details);
                                        
                                    },
                                    function (details) {
                                        
                                        }
                                    );
                            }
                            $scope.NearbyPlaces = data;
                    });
                }
            });
           
       }
    });
    // </editor-fold>
     
      angular.element(document).ready(
        function() 
        {
            var uploaded_images = "NULL";
            var property_edit_listing= {
                Extends: get_base(),
                Initialize: function( private ){       
                    this.parent.Initialize();


                },
                Private:{
                },
                Public:{

                }
            };
            var prop_ref = getParameterByName("reference");
            var objProperty = $.makeclass(property_edit_listing);
            var waitForFinalEvent = (function () {
                 var timers = {};
                  return function (callback, ms, uniqueId) {
                    if (!uniqueId) {
                      uniqueId = "Don't call this twice without a uniqueId";
                    }
                    if (timers[uniqueId]) {
                      clearTimeout (timers[uniqueId]);
                    }
                    timers[uniqueId] = setTimeout(callback, ms);
                  };
            })();
            $(window).resize(function()
                {
                    var objBase = $.makeclass(get_base());
                    waitForFinalEvent(function() {
                        objBase.set_footer_position();
						delete objBase;
                        }, 100, objBase.generateUUID());
                }

            );
            var error_ids = [];
            // <editor-fold desc="User triggered event"  defaultstate="collapsed">
            $scope.preview_click = function()
            {
              if( preview_check() === true) 
              {
                  $scope.back_count -= 1;			  
                  set_preview();
              }
            };
            
            $scope.term_click = function()
            {
                $scope.err_msg = "";
            };
            
            var get_property_type_info = function(category_name)
            {
                var search_category = "property_type_sell";
                var property_type = $('#property_type_sell').val();

                if(category_name === "rent")
                {
                    search_category = "property_type_rent";
                    property_type = $('#property_type_rent').val();
                }
                
                for (i = 0; i < ($scope.property_category_1.length); i++) { 
                    if($scope.property_category_1[i]['id']===search_category)
                    {
                        for (var category in ($scope.property_category_1[i]['values'])){
                            if (($scope.property_category_1[i]['values']).hasOwnProperty(category))
                            {
                                for(j = 0; j < ($scope.property_category_1[i]['values'][category].length); j++){
                                    if(($scope.property_category_1[i]['values'][category][j]) === property_type)
                                    {
                                        var property_category = category;
                                    }
                                }
                            }
                         }
                    }      
                }
                
                var property_type_info = new Array();
                property_type_info['property_category']= property_category;
                property_type_info['property_type']=property_type;
                
                return property_type_info;
            };
            
            /**
             * @description This function preparing message data
             */
            var prepare_message_data = function($scope)
            {
                var category_name = $scope.mapping[$.trim($('#type').val())];
                var prop_info = get_property_type_info(category_name);
                var property_category = prop_info['property_category'];
                var property_type = prop_info['property_type'];
                
                var listing;
                $scope.country_state.location["k"] = $scope.googleMarker.getGMarkers()[0].position.lat();
                $scope.country_state.location["B"] = $scope.googleMarker.getGMarkers()[0].position.lng();
                
                var remark = CKEDITOR.instances.remark.getData();
                var objHome = StaticHomeObject.getInstance();
                remark = objHome.remove_special_character_from_data(remark);
                
                switch(category_name)
                {
                    case "sell":
                        listing = {
                            'service_type' : category_name.toUpperCase(),
                            'price': parseFloat($('#asking_price input').val()).toFixed(2),
                            'car_park':$('#car_park').val(),
                            'auction': $('#auction').val(),
                            'size_measurement_code': $.trim($('#size_measurement_code').val()),
                            'buildup': $('#built_up').val(),
                            'landarea': $('#land_area').val(),
                            'bedrooms': $('#bedroom').val(),
                            'bathrooms': $('#bathroom').val(),
                            'ref': prop_ref,
                            'furnished_type':$.trim($('#furnishing').val()),
                            'occupied':$.trim($('#occupied').val()),
                            'monthly_maintanance': parseFloat($('#monthly_maintanance').val()).toFixed(2),
                            'remark': remark, //$('textarea#remark').val(),
                            'property_category':property_category,
                            'property_type':property_type,
                            'tenure':$.trim($('#tenure').val()),
                            'land_title_type': $.trim($('#land_title_type').val()),
                            'active':1,
                            'user_id':'',
                            'property_photo': '',
                            'facilities': get_facilities(),
                            'unit_name' : get_unit_name(),
                            'state': $.trim($('#state').val()),
                            'area': $('#area').val(),
                            'postcode':$('#postcode').val(),
                            'street':$('#street').val(),
                            'country':$.trim($('#country').val()),
                            'location':$scope.country_state.location,
                            'reserve_type': $.trim($('#reserve_type').val()),
                            'currency': $.trim($('#currency').val())
                        };
                        break;
                    case "rent":
                        listing = {
                            'service_type' : category_name.toUpperCase(),
                            'price': parseFloat($('#monthly_rental input').val()).toFixed(2),
                            'car_park':$('#car_park').val(),
                            'buildup': $('#built_up').val(),
                            'landarea': $('#land_area').val(),
                            'bedrooms': $('#bedroom').val(),
                            'bathrooms': $('#bathroom').val(),
                            'ref': prop_ref,
                            'furnished_type':$.trim($('#furnishing').val()),
                            'occupied':$.trim($('#occupied').val()),
                            'remark': remark,//$('textarea#remark').val(),
                            'land_title_type': $.trim($('#land_title_type').val()),
                            'active':1,
                            'user_id':'',
                            'property_photo': '',
                            'size_measurement_code': $.trim($('#size_measurement_code').val()),
                            'property_category':property_category,
                            'property_type':property_type,
                            'facilities': get_facilities(),
                            'unit_name' : get_unit_name(),
                            'state': $.trim($('#state').val()),
                            'area': $('#area').val(),
                            'postcode':$('#postcode').val(),
                            'street':$('#street').val(),
                            'country':$.trim($('#country').val()),
                            'location':$scope.country_state.location,
                            'currency': $.trim($('#currency').val())
                        };
                        break;
                        /*
                    case "room":
                           listing = {
                            'service_type' : category_name.toUpperCase(),
                            'price': parseFloat($('#monthly_rental input').val()).toFixed(2),
                            'car_park':$('#car_park').val(),
                            'bathrooms': $('#bathroom').val(),
                            'ref': prop_ref,
                            'furnished_type':$.trim($('#furnishing').val()),
                            'occupied':$.trim($('#occupied').val()),
                            'remark': CKEDITOR.instances.remark.document.getData().getHtml(),//$('textarea#remark').val(),
                            'property_category':$.trim($('#property_category').val()),
                            'property_type':$.trim($('#property_type').val()),
                            'active':1,
                            'user_id':'',
                            'property_photo': '',
                            'facilities': get_facilities(),
                            'unit_name' : get_unit_name(),
                            'state': $.trim($('#state').val()),
                            'area': $('#area').val(),
                            'postcode':$('#postcode').val(),
                            'street':$('#street').val(),
                            'country':$.trim($('#country').val()),
                            'location':$scope.country_state.location,
                            'currency': $.trim($('#currency').val())
                        };
                        break;
                            */
                }
                return listing;
            };
            /**
             * @description This function will invoke when user submitting their listing
             */
            $scope.submit_click = function()
            {
              if( submit_check() === true) 
              {
                clear_errors();
                var listing = prepare_message_data($scope);
                var photo_list = get_uploaded_image();
                var senddata = "image_list=" + JSON.stringify(photo_list) + "&listing_information=" + JSON.stringify(listing);
                var url = objProperty.getBaseUrl() + "index.php/_utils/properties_upload/commit_images_and_validation";
                $scope.disable_button = 1;
                $scope.photo_upload_status = "Updating Listing..."; 
                //console.log(senddata);
                $http({
                   method: 'POST',
                   url: url,
                   data: senddata,
                   cache: true,
                   headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                 }).then(function(response) {

                     var parsed_result = response.data;
                     if(parsed_result["status"] === "success")
                     {
                         listing['property_photo'] = parsed_result["data"];
                         set_listing(listing, $scope);
                     }
                     else
                     {
                         if( Object.prototype.toString.call( parsed_result["data"] ) === '[object Array]' ) {
                             set_error(parsed_result["data"]);
                         }
                         else
                         {
                             // Will drop into here if is a generic issue (mean no object structure)
                             console.log(parsed_result);
                             alert("Fail to submit listing, please contact admin");
                             $scope.disable_button = 0;
                         }
                     }


                 });
                }
            };
            //</editor-fold>
            var set_error = function(ids)
            {
                error_ids = ids;
                
                for(var i = 0; i < ids.length; i++ )
                {
                    var id = ids[i]+"-feedback";
                    $('.'+error_ids[i]+'-feedback').removeClass('glyphicon-ok');
                    $('.'+error_ids[i]+'-feedback').addClass('glyphicon-remove');
                    $('.'+error_ids[i]+'-feedback').css('color', 'red');
                    //$(id).css('border-color','red');
                    if(i===0)
                    {
                        document.getElementById("lbl_"+ids[i]).scrollIntoView(true);
                        // Offset according to top label
                        var cur_top = document.body.scrollTop;
                        cur_top = cur_top - 80;
                        document.body.scrollTop=cur_top;
                        
                    }
                }
            };
            var set_all_ticks = function()
            {
                $('.feedback').addClass('glyphicon-ok');
                $('.feedback').removeClass('glyphicon-remove');
                $('.feedback').removeClass('glyphicon-asterisk');
                error_ids = [];
            };
            var clear_errors = function()
            {
                
                for(var i = 0; i < error_ids.length; i++ )
                {
                    $('.'+error_ids[i]+'-feedback').removeClass('glyphicon-ok');
                    $('.'+error_ids[i]+'-feedback').removeClass('glyphicon-remove');
                    $('.'+error_ids[i]+'-feedback').addClass('glyphicon-asterisk');
                    /*if(i===0)
                    {
                        $('html, body').animate({
                            scrollTop: $(id).offset().top
                        }, 1000);
                    }*/
                    }
                error_ids = [];
            };
            // <editor-fold desc="get_uploaded_image"  defaultstate="collapsed">
            /*
            * get_uploaded_image will return the temporary image name and the origin name
            */
            var initialize_events = function()
            {
              $('#popup_property_preview').on('hidden.bs.modal', function () {
                  $('#property_preview_content_iframe').attr('src', null);
              });
            };
            var get_uploaded_image = function()
            {
               var photo_list = new Array();
               var index = 0;
               var php_vals = uploaded_images;
                
               $('.thumbnail-photo').each(
                    function()
                    {
                        var desc = $(this).find('textarea').first().val();
                        if($(this).hasClass('photo-default'))
                        {
                            var img = $(this).find('img').first();
                            photo_list.push({
                             'name': '',
                              'desc': desc,
                              'tmp_files': [img.attr('src')],
                              'exists':true  
                           });    
                        }
                        else
                        {
                            var tmp_files = new Array();
                            
                            if(index < $scope.uploader.flow.files.length)
                            {
                                var filename = $scope.uploader.flow.files[index].name;
                                
                                for (var i = 0; i < php_vals.length; i++) { 
                                    if(php_vals[i].post.flowFilename === filename)
                                    {
                                        tmp_files.push(objProperty.get_filebaseName(php_vals[i].files.file.tmp_name));      
                                    }
                                }
                                photo_list.push({
                                    'name': filename,
                                    'desc': desc,
                                    'tmp_files': tmp_files,
                                    'exists':false
                                });
                                index = index +1;
                            }
                        }
                    }
                );
                
                return photo_list;
           };
            // </editor-fold>
            // <editor-fold desc="set_listing preview"  defaultstate="collapsed">
            var get_unit_name = function()
            {
                var name = $.trim($('#unit_name').val()).toLowerCase();
                if(typeof $scope.google_maps.details.name !== 'undefined' &&
                        name.indexOf($scope.google_maps.details.name.toLowerCase()) > -1)
                {
                     return   $scope.google_maps.details.name; 
                }
                else
                {
                    return name;    
                }
            };
            var prepare_image_list_for_preview = function()
            {
               var photo_list = [];
               var index = 0;
               var php_vals = uploaded_images;
               var uploaded_images = get_uploaded_image();
               
               for(var i=0; i< uploaded_images.length; i++)
               {
                  var exists = uploaded_images[i]['exists'];
                  var desc = uploaded_images[i]['desc'];
                  if(exists)
                  {
                      uploaded_images[i]['tmp_files'].forEach(
                              function(value)
                              {
                                  photo_list.push([
                                      value,
                                      desc
                                  ]);
                              }
                      );
                      
                  }
                  else
                  {
                      photo_list.push([
                                String.format("../../temp/images/{0}/{1}/{2}",
                                    $scope.person.user_id, $scope.temp_ref, 
                                    uploaded_images[i]['tmp_files'][0]),
                                    desc
                      ]);
                  }
               }
               return photo_list;  
            };
            var set_preview = function()
            {  
                $scope.country_state.location["k"] = $scope.googleMarker.getGMarkers()[0].position.lat();
                $scope.country_state.location["B"] = $scope.googleMarker.getGMarkers()[0].position.lng();
                var service_type = new String($('#type').val()).indexOf('For Sale') >= 0? "SELL" : "RENT";
                
                if ($('#type').val().indexOf('Room To Let') > 0)
                {
                    service_type = "ROOM";
                }
                
                var category_name = $scope.mapping[$.trim($('#type').val())];
                
                var prop_info = get_property_type_info(category_name);
                var property_category = prop_info['property_category'];
                var property_type = prop_info['property_type'];
                
                var remark = CKEDITOR.instances.remark.getData();
                var objHome = StaticHomeObject.getInstance();
                remark = objHome.remove_special_character_from_data(remark);
                
                var listing = {
                    'service_type' : service_type,
                    'price': (service_type === "SELL")?parseFloat($('#asking_price input').val()).toFixed(2) : parseFloat($('#monthly_rental input').val()).toFixed(2),
                    'auction': ($('#auction').val() === "")?"--":$('#auction').val(),
                    'buildup': $('#built_up').val(),
                    'landarea': $('#land_area').val(),
                    'bedrooms': $('#bedroom').val(),
                    'bathrooms': $('#bathroom').val(),
                    'car_park':$('#car_park').val(),
                    'ref': prop_ref,
                    'furnished_type':$.trim($('#furnishing').val()),
                    'occupied':$.trim($('#occupied').val()),
                    'monthly_maintanance': parseFloat($('#monthly_maintanance').val()).toFixed(2),
                    'remark': remark,//$('textarea#remark').val(),
                    'property_category':property_category,
                    'property_type':property_type,
                    'tenure':$.trim($('#tenure').val()),
                    'land_title_type': $.trim($('#land_title_type').val()),
                    'active':1,
                    'user_id':'',
                    'property_photo': prepare_image_list_for_preview(),
                    'facilities': get_facilities(),
                    'unit_name' : get_unit_name(),
                    'state': $('#state').val(),
                    'area': $('#area').val(),
                    'postcode':$('#postcode').val(),
                    'street':$('#street').val(),
                    'country':$.trim($('#country').val()),
                    'location':$scope.country_state.location,
                    'reserve_type': $.trim($('#reserve_type').val()),
                    //'nearest_spot':get_nearest_spots(),
                    'nearest_spot' :$scope.NearbyPlaces,
                    'currency': $scope.currency_value["currency"],
                    'size_measurement_code': $.trim($('#size_measurement_code').val())
                };
                
                
                var senddata = "listing_information=" + JSON.stringify(listing);
                
		var url = (service_type === "SELL")?objProperty.getBaseUrl() + "index.php/properties_preview":
				objProperty.getBaseUrl() + "index.php/properties_preview_rent";
				
                //window.openDialog(url, "preview", "preview", JSON.stringify(listing));
                $.jStorage.set("preview_data", JSON.stringify(listing));
                $('#property_preview_content_iframe').attr('src', url);
                $("#popup_property_preview").modal('show');

            };
            
            // Push state to allow back button close the modal, if any.
            $("#popup_property_preview").on("shown.bs.modal", function()  { // any time a modal is shown
                var urlReplace = "#preview"; // make the hash the id of the modal shown
                history.pushState(null, null, urlReplace); // push state that hash into the url
            });

            // If a pushstate has previously happened and the back button is clicked, hide any modals.
            $(window).on('popstate', function() { 
                $("#popup_property_preview").modal('hide');
            });
            
            var preview_check = function()
            {
                // Confirm remark lenght should not over 800 width
                var remark = CKEDITOR.instances.remark.getData();
                if (remark.length > 1000)
                {
                    alert("Remark is too long, please reduce the lenght to 800");
                    return false;
                }
                
                // To check all unit related inputs must be entered
                var ids = [];
                $(".validation_input_group_small input, .validation_input_group_default input").each(
                        function()
                        {
                            if($(this).val() === "")
                            {
                              ids.push($(this).attr('id'));       
                            }
                        }
                );
                    
                if(ids.length > 0) // Error when there is empty input 
                {
                    set_error(ids);
                    return false;
                }
                
                // No issue
                return true;
                
            };
            
            var submit_check = function()
            {
                // Confirm remark lenght should not over 800 width
                var remark = CKEDITOR.instances.remark.getData();
                if (remark.length > 1000)
                {
                    alert("Remark is too long, please reduce the lenght to 800");
                    return false;
                }
                
                // User must agree with the term and condition
                if($('#upload_term_condition:checkbox:checked').length === 0)
                {
                    $scope.err_msg = "Please understand and agree to the terms and conditions";
                    return false;       
                }
                
                // No issue
                return true;                
            };
            
            // </editor-fold>
            // <editor-fold desc="set_listing"  defaultstate="collapsed">
            var set_listing = function(listing, $scope)
            {
                var senddata = "listing_information=" + JSON.stringify(listing).replace('&nbsp;','%26nbsp;').replace('&', '%26');
                //console.log(senddata);
                var url = objProperty.getBaseUrl() + "index.php/_utils/properties_upload/upload_listing";
                $http({
                 method: 'POST',
                 url: url,
                 data: senddata,
                 cache: false,
                 headers: {'Content-Type': 'application/x-www-form-urlencoded'}
               }).then(function(response) {
                    //console.log(response);
                    //nav to main page
                    var objBase = $.makeclass(get_base());
                    var parsed_result = response.data;
                    if(parsed_result["status"] === "success")
                    {
                         $.jStorage.set("listing_uploaded", parsed_result["info"]);
                         window.location.replace(objBase.getBaseUrl());
                    }
                    else
                    {
                       if( Object.prototype.toString.call( parsed_result["data"] ) === '[object Array]' ) {
                          set_error(parsed_result["data"]);
                       }
                       else
                       {
                           console.log(parsed_result);
                       }
                       $scope.disable_button = 0;
                       $scope.photo_upload_status = "Error found!!!"; 
                       
                    }
                    
               });
                
            };
            // </editor-fold>
            // <editor-fold desc="set_auction"  defaultstate="collapsed">
            var set_auction = function()
            {
                if($('#chk_auction').prop('checked'))
                {
                   $("#auction").removeAttr('disabled');   
                }
                else
                {
                    $("#auction").attr('disabled','disabled');
                    $("#auction").val('');
                }
            };
            // </editor-fold>
            
            // <editor-fold desc="get_photo_list_description"  defaultstate="collapsed">
            var get_photo_list_description = function()
            {
              var spots = [];
              $('.place_name').each(
                   function()
                   {
                       spots.push($(this).text());
                   }
                );
              return spots;
            };
            // </editor-fold>
            // <editor-fold desc="get_nearest_spots"  defaultstate="collapsed">
            var get_nearest_spots = function()
            {
              var spots = [];
              $('.place_name').each(
                   function()
                   {
                       spots.push($(this).text());
                   }
                );
              return spots;
            };
            //</editor-fold>
            // <editor-fold desc="get_transportation_list"  defaultstate="collapsed">
            var get_transportation_list = function()
            {
              var transportations = [];
              $('#transportations .place_name').each(
                   function()
                   {
                       transportations.push($(this).text());
                   }
                );
              return transportations;
            };
            // </editor-fold>
            
            // <editor-fold desc="get_facilities"  defaultstate="collapsed">
            var get_facilities = function()
            {
                var facilities = [];
                $('.property_facility input').each(
                   function()
                   {
                       if($(this).is(':checked'))
                       {
                            facilities.push($(this).val());   
                       }
                   }
                );
                return facilities;
            };
            
            var facilities_dict = function(facility)
            {
                var return_val;
                if(facility === "Barbeque Area")
                {
                    return_val = "BBQ";
                }
                else if(facility === "Parking")
                {
                    return_val = "PARKING";
                }
                else if(facility === "Jogging Track")
                {
                    return_val = "JOGGING";
                }
                else if(facility === "Playground")
                {
                    return_val = "PLAYGROUND";
                }
                else if(facility === "Tennis court")
                {
                    return_val = "TENNIS";
                }
                else if(facility === "Squash court")
                {
                    return_val = "SQUASH";
                }
                else if(facility === "Club House")
                {
                    return_val = "CLUB";
                }
                else if(facility === "Jacuzzi")
                {
                    return_val = "JACUZZI";
                }
                else if(facility === "Nursery")
                {
                    return_val = "NURSERY";
                }
                else if(facility === "Sauna")
                {
                    return_val = "SAUNA";
                }
                else if(facility === "Cafeteria")
                {
                    return_val = "CAFE";
                }
                else if(facility === "Library")
                {
                    return_val = "LIBRARY";
                }
                else if(facility === "Bussiness Center")
                {
                    return_val = "BusinessCenter";
                }
                else if(facility === "Gymnasium")
                {
                    return_val = "GYM";
                }
                else if(facility === "Mini market")
                {
                    return_val = "MINIMART";
                }
                else if(facility === "Salon")
                {
                    return_val = "SALON";
                }
                else if(facility === "Swimming Pool")
                {
                    return_val = "SWIMMING";
                }
                else if(facility === "24 Hours Security")
                {
                    return_val = "SECURITY";
                }
                else
                {
                    console.log("missing key value pair in facility dictionary");
                }
                return return_val;
            };
            
            var set_selected_facilities = function()
            {
                $('.property_facility input').each(
                   function()
                   {
                       var facility_list_ptr  = $(this).val();

                       for(var counter=0; counter<3; counter++)
                       {
                           var returned_facility_array_ptr = $scope.property_information.property_facilities[counter];
                           
                           for(var i =0; i<returned_facility_array_ptr.length;i++)
                           {
                                if(facilities_dict(returned_facility_array_ptr[i]) === facility_list_ptr)
                                {
                                      $(this).attr('checked', true);
                                }
                           }
                       }
                   }
                );
            };
            
            // </editor-fold>
            // <editor-fold desc="load_initial_data"  defaultstate="collapsed">
            var get_initial_data = function()
            {
                var url = objProperty.getWsdlBaseUrl() + "index.php/base/obtain_user_information";
                $http({
                 method: 'GET',
                 url: url,
                 data: null,
                 cache: true,
                 headers: {'Content-Type': 'application/x-www-form-urlencoded'}
               }).then(function(response) {
                    $scope.person.email= response.data.username;
                    $scope.person.phone= response.data.phone;
                    $scope.person.name= response.data.displayname;
                    $scope.person.user_id= response.data.user_id;
               });
               
               url = objProperty.getBaseUrl() + "index.php/properties_base/get_property_reference";
               $http({
                 method: 'GET',
                 url: url,
                 data: null,
                 cache: true,
                 headers: {'Content-Type': 'application/x-www-form-urlencoded'}
               }).then(function(response) {
                    $scope.temp_ref = JSON.parse(response.data); 
               });
               
               var url = objProperty.getBaseUrl() + "index.php/properties_base/get_current_action";
                $http({
                 method: 'GET',
                 url: url,
                 data: null,
                 cache: true,
                 headers: {'Content-Type': 'application/x-www-form-urlencoded'}
               }).then(function(response) {
                    for(var key in $scope.mapping)
                    {
                        if($.trim($scope.mapping[key]) === response.data)
                        {
                             $('#type option').prop('selected', false)
                                  .filter(function()
                                  {
                                      if($.trim($(this).val()) === key)
                                      {
                                          return true;
                                      }
                                      else
                                      {
                                          return false;        
                                      }
                                  }).prop('selected', true);
                        }
                    }
                    $('#type').change();
                   
               });
               
               $scope.set_state_list_by_country();
                
            };
            // </editor-fold>
            $scope.navigate_back = function()
            {
		//console.log("$scope.back_count: " + $scope.back_count);
                history.go($scope.back_count);
            };
            $scope.$watch('country_state.states', function(val, prev){
                if(val !== prev){
                    // do whatever you need here
                    $("#state").empty();
                    if(val.length > 0)
                    { 
                        $(".div_state").css('display', '');
                        val.forEach(
                         function(value, index, arr)
                         {
                             var option = $('<option></option>').attr("value", value).text(value);
                             if($scope.property_information.State === value)
                             {
                                option = $('<option selected></option>').attr("value", value).text(value);
                             }
                             $("#state").append(option);
                         }
                        );
                    }
                    else
                    {
                       $(".div_state").css('display', 'none');
                    }
                    
                }
            });
            $scope.change_country = function()
            {
                    $scope.country_state["country"] = $("#country").val();
                    $scope.set_state_list_by_country();
            };
            $scope.set_state_list_by_country = function()
            {
                var url = objProperty.getBaseUrl() + "index.php/properties_base/get_states";
                var senddata = "country_name=" + JSON.stringify($.trim($scope.country_state["country"]));
                $http({
                 method: 'POST',
                 url: url,
                 data: senddata,
                 cache: true,
                 headers: {'Content-Type': 'application/x-www-form-urlencoded'}
               }).then(function(response) {
                   $scope.country_state["states"] = response.data;
               });
            };
            
            var display_by_category = function(category_mapping)
            {
               $('#type').change(
               function(){
                  var category_name = category_mapping[$.trim($(this).val())];
                  $('.sell, .rent, .room').css('display', 'none');
                  $("."+category_name).css('display', '');
               });
              
            };
            var set_scope_value = function($scope)
            {
                // Set flag to let detail query return data even is deactivate
                $scope.proeprty_edit_tag = "true";
                
                // Query back the detail information
                get_new_listing_data($scope, $sce);
                //console.log($scope.property_information);
                
                // Loop though detail and set value accordingly for property_category_1
                for(var i =0; i< $scope.property_category_1.length; i++)
                {
                    var id_value = $scope.property_category_1[i].id;
                    
                    switch(id_value)
                    {
                        case "type":
                            var type_value = $scope.mapping_reverse[get_details_info("type",$scope).toLowerCase()];
                            $("#type").val(type_value);
                            break;
                        case "property_type_sell":
                            $scope.property_category_sell_value = get_details_info("property_category", $scope);
                            $scope.property_type_sell_value = {value: $scope.property_category_1[i]['values'][$scope.property_category_sell_value][0]};
                            $scope.property_category_sell_value_sel = $scope.property_category_sell_value;
                            $scope.property_type_sell_value_sel = $scope.property_category_1[i]['values'][$scope.property_category_sell_value][0];
                            break;
                        case "property_type_rent":
                            $scope.property_category_rent_value = get_details_info("property_category", $scope);
                            $scope.property_type_rent_value = {value: $scope.property_category_1[i]['values'][$scope.property_category_rent_value][0]};
                            $scope.property_category_rent_value_sel = $scope.property_category_rent_value;
                            $scope.property_type_rent_value_sel = $scope.property_category_1[i]['values'][$scope.property_category_rent_value][0];
                            break;
                        case "currency":
                            $scope.currency_value = {currency:$scope.property_information.currency};
                            break;
                        case "built_up":
                            $scope.build_up = {value:Number(get_details_info("built_up", $scope))};
                            break;
                        case "monthly_rental":
                            $scope.monthly_rental = {value:Number($scope.property_information.Price)};
                            break;
                        case "asking_price":
                            $scope.asking_price = {value:Number($scope.property_information.Price)};
                            break;
                        case "size_measurement_code":
                            var size_measurement_code = get_details_info("measurement_type",$scope);
                            $("#size_measurement_code").val(size_measurement_code);
                            break;
                        case "land_area":
                            var land_area = get_details_info("land_area",$scope);
                            $("#land_area").val(land_area);
                            break;
                        case "asking_price_per":
                            var asking_price_per = $scope.property_information.PricePer;
                            $("#asking_price_per").val(asking_price_per);
                            break;
                        case "reserve_type":
                            var reserve_type = get_details_info("reserve_type",$scope);
                            $("#reserve_type").val(reserve_type);
                            break;
                        case "auction":
                            var auction_value = get_details_info("auction",$scope);
                            if (auction_value !== "--")
                            {
                                $("#auction").removeAttr('disabled'); 
                                $("#chk_auction")[0].checked = true;
                                $("#auction").val(auction_value);
                            }
                            else
                            {
                                set_auction();
                            }
                            
                            break;
                        default:
                            //console.log(id_value);
                            break;
                    }
                };
                
                // Loop though detail and set value accordingly for property_category_2
                for(var i =0; i< $scope.property_category_2.length; i++)
                {
                    var id_value = $scope.property_category_2[i].id;
                    
                    switch(id_value)
                    {
                        case "bedroom":
                            $("#bedroom").val($scope.property_information.RoomCount);
                            break;
                        case "bathroom":
                            $("#bathroom").val($scope.property_information.ToiletCount);
                            break;
                        case "car_park":
                            $("#car_park").val($scope.property_information.ParkingCount);
                            break;
                        case "tenure":
                            var tenure = get_details_info("tenure",$scope);
                            $("#tenure").val(tenure);
                            break;
                        case "land_title_type":
                            var land_title_type = get_details_info("land_title_type",$scope);
                            $("#land_title_type").val(land_title_type);
                            break;
                        case "furnishing":
                            var furnishing = $scope.mapping[get_details_info("furnishing",$scope)];
                            $("#furnishing").val(furnishing);
                            break;
                        case "occupied":
                            var occupied = get_details_info("occupied",$scope);
                            $("#occupied").val(occupied);
                            break;
                        case "monthly_maintanance":
                            var monthly_maintanance = get_details_info("monthly",$scope);
                            $("#monthly_maintanance").val(monthly_maintanance);
                            break;
                        default:
                            console.log(id_value);
                            break;
                    }
                };

                //to update the remark
                $("#remark").val($scope.property_information.Remark);
                
                // Set the rest of the field
                set_location_map($scope);
                set_loaded_image($scope);
                set_selected_facilities();
            };
            
            var set_location_map = function($scope)
            {
                //to update location
                document.getElementById('country').value = $scope.property_information.Country;
                document.getElementById('unit_name').value = $scope.property_information.PropertyName;
                document.getElementById('area').value = $scope.property_information.Area;
                document.getElementById('postcode').value = $scope.property_information.PostCode;
                document.getElementById('street').value = $scope.property_information.Street;  
                
                //to update google map marker
                var markers = $scope.googleMarker.getGMarkers();
                for (var i = 0; i < markers.length; i++)
                {
                    markers[i].draggable = true;
                    markers[i].setPosition(
                           {
                                lat: $scope.property_information.MapLocationK,
                                lng: $scope.property_information.MapLocationB
                            });
                }
                $scope.map.center.latitude = $scope.property_information.MapLocationK;
                $scope.marker.coords.latitude = $scope.property_information.MapLocationK;
                $scope.map.center.longitude = $scope.property_information.MapLocationB;
                $scope.marker.coords.longitude = $scope.property_information.MapLocationB;
            };

            var set_loaded_image = function($scope)
            {
                $scope.reload_photo = "false";
                //to set uploaded image                
                $scope.uploaded_files = [];
                for(var i = 0; i < $scope.property_information.PropertyImages.length; i++)
                {
                    var PropertyImageSrc = $scope.property_information.PropertyImages[i][0];
                    var PropertyImageDesc = $scope.property_information.PropertyImages[i][1];
                    var PropertyImageName = "img"+i;
                    
                    $scope.uploaded_files.push([PropertyImageSrc, PropertyImageDesc,PropertyImageName]);
                }
            };
            
            $scope.reload_photo_click = function()
            {
              if($scope.reload_photo === "true")
              {
                  $scope.reload_photo = "false";
              }
              else
              {
                  $scope.reload_photo = "true";
              }
            };
            
            $scope.remove_uploaded_file = function(image_groupname)
            {
              $('#'+image_groupname).remove();
            };
            
            // <editor-fold desc="data initialization"  defaultstate="collapsed">
			waitForFinalEvent(function() {
					objProperty.set_footer_position();
			}, 100, objProperty.generateUUID());
            
            $scope.country_state = {
                country:'Malaysia',
                short:'my',
                location:{
                    "k":3.140307520038235, 
                    "B":101.6866455078125
                },
                states:['Penang', 'Johor']
            };
            $scope.photo_upload_status = "";
            $scope.disable_button = 0;
            $scope.property_edit_tag = true;
            
            // To capture the user selection
            $scope.change_category_type = function(category, type)
            {
                var category_name = $scope.mapping[$.trim($('#type').val())];
                switch(category_name)
                {
                    case "sell":
                        $scope.property_category_sell_value_sel = category;
                        $scope.property_type_sell_value_sel = type;
                        break;
                    case "rent":
                        $scope.property_category_rent_value_sel = category;
                        $scope.property_type_rent_value_sel = type;
                        break;
                }
                
            };
            
            set_scope_value($scope);
            // </editor-fold>
            display_by_category($scope.mapping);
            get_initial_data();
            initialize_events();
            $('#type').change();
            // <editor-fold desc="controls event update"  defaultstate="collapsed">
             $('.validation_input_group_small > input, .validation_input_group_default > input').bind('keypress change paste focusin focusout', function()
              {
                  //Dirty way of implementation
                  setTimeout(function(){ 
                    $('.validation_input_group_small > input, .validation_input_group_default > input').each(
                        function()
                        {
                          var id = '.'+$(this).context.id+'-feedback';
                          if($(this).val() === "")
                          {
                            $(id).removeClass('glyphicon-ok');
                            $(id).addClass('glyphicon-remove');
                            $(id).css('color', 'red');
                          }
                          else if($(this).context.id === "postcode" && !$.isNumeric($(this).val()))
                          {
                            $(id).removeClass('glyphicon-ok');
                            $(id).addClass('glyphicon-remove');
                            $(id).css('color', 'red');
                          }
                          else
                          {
                            $(id).removeClass('glyphicon-remove');
                            $(id).addClass('glyphicon-ok');
                            $(id).css('color', '#3c763d');           
                          }
                        } 
                   
                  );}, 100);
              }
            );
            $('#chk_auction').on('click', function(){set_auction();});
            // </editor-fold>
            
            flowFactory.flow.on('catchAll', function (event) {
                if(event === "fileSuccess")
                {
                    var php_val = jQuery.parseJSON(arguments[2]);
                    if (uploaded_images !== "NULL")
                    {   
                        uploaded_images.push(php_val);

                    }
                    else
                    {
                        uploaded_images = new Array();
                        uploaded_images.push(php_val);
                    }
                }
            });
            flowFactory.flow.on('uploadStart', function () {
                    $scope.disable_button = 1;
                    $scope.photo_upload_status = "Processing..."; 
                });
            flowFactory.flow.on('fileAdded', function (file, event) {
                if(file.size > 5000000)
                {
                    file.error = true;
                    file.error_msg = 
                         "This file exceeds the maximum upload size for this server.";
                }
                else if (!{png:1,gif:1,jpg:1,jpeg:1}[file.getExtension()])
                {
                    file.error = true;
                    file.error_msg = 
                            "This file type is not supported.";
                }
                
                if (file.error === true)
                {
                    console.log(file.error_msg);
                    file.done = true;
                    file.flowObj.preventEvent(event);
                    return false;
                }
                
            });

            flowFactory.flow.on('complete', function () {
                $scope.disable_button = 0;
                $scope.photo_upload_status = "";
				$(".progress").hide();
            });

            CKEDITOR.replace( 'remark_editor',{removeButtons:'Link,Unlink,Anchor'});
            
            set_all_ticks();
            
            $scope.$apply();
            
     });
});

$(function () {
     $('.date').datetimepicker();
     
 });
 

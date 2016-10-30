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
        // <editor-fold desc="property information column 3"  defaultstate="collapsed">
        $scope.property_category_3 =
                [
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
                    },
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
                    category:'sell rent',
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
                    id:'room_type',
                    name:'Room Type',
                    control:'select',
                    category:'room',
                    values:
                    [
                        'Master Room',
                        'Middle Room',
                        'Small Room'
                    ]
                },
                {
                    id:'property_type',
                    name: 'Property Type',
                    control:'select-title',
                    category:'sell rent room',
                    values:
                    {
                         'Condo/Service Residence':[
                            'Condo',
                            'Service Apartment',
                            'Serviced Residence',
                            'Duplex',
                            'Triplex',
                            'Soho',
                            'Penthouse',
                            'Townhouse Condo'
                        ],
                        'Apartment/Flat':[
                            'Flat',
                            'Apartment',
                            'Apartment Duplex'
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
                             'Townhouse'
                         ],
                        'Semi-D/Banglo':[
                            'Semi-Detached',
                            'Bungalow House',
                            'Bungalow Land',
                            'Link Bungalow',
                            'Twin Villas',
                            'Twin Courtyard Villa',
                            'Zero Lot Bangalow',
                            'Cluster Homes'
                        ],
                        'Residential Land':[
                            'Residential Land'
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
       
       $scope.property_information = {
        "PropertyName": "Test Suites",
        "Price": 1000000,
        "Country": "Test1",
        "State": "Test2",
        "Area": "Test3",
        "PostCode": "Test4",
        "Street": "Test5",
        "MapLocationK": "1.234567",
        "MapLocationB": "100.234567",
        "ToiletCount": "2",
        "RoomCount": "3",
        "ParkingCount": "3",
        "PricePer": "1,000",
        "currency": "RM",
        "Unit": "sqft",
        "Total_loan": "900000.00",
        "PropertyImages": [
           ['../../temp/images/2/test/php67D8.tmp', 'Apartment road side view']
           ['../../temp/images/2/test/php3329.tmp', 'Kids Swimming Pool'],
           ['../../temp/images/2/test/php4848.tmp', 'Swimming Pool']
        ],
        "Remark": "",
        "property_facilities":[
            [],
            [],
            []
        ],
        "details": [
            [{
                'label': 'Type',
                'id':'type',
                'value': 'Sell',
                'category':'sell rent room'

            },
            {
                'label': 'Tenure',
                'id':'tenure',
                'value': 'Freehold',
                'category':'sell'

            },
            {
                'label': 'Property Type',
                'id':'property_type',
                'value': 'Condo',
                'category':'sell rent room'
            },
            {
                'label': 'Room Type',
                'id':'room_type',
                'value': 'Master room',
                'category':'room'
            },
            {
                'label': 'Built Up',
                'id':'built_up',
                'value': '2500',
                'category':'sell rent'

            },
            {
                'label': 'Land Area',
                'id':'land_area',
                'value': 'Sell',
                'category':'sell rent'
                

            },
            {
                'label': 'Size Measure Code',
                'id':'measurement_type',
                'value': 'Square Feet',
                'category':'sell rent'

            }],
            [{
                'label': 'Monthly Maintenance',
                'id':'monthly',
                'value': '100.00',
                'category':'sell'

            },
            {
                'label': 'Reserve Type',
                'id':'reserve_type',
                'value': 'Bumi Lot',
                'category':'sell'

            },
            {
                'label': 'Land Title Type',
                'id':'land_title_type',
                'value': 'Residential',
                'category':'sell'

            },
            {
                'label': 'Furnishing',
                'id':'furnishing',
                'value': 'Fully Furnished',
                'category':'sell rent room'

            },
            {
                'label': 'Occupied',
                'id':'occupied',
                'value': 'No',
                'category':'sell rent room'

            },
            {
                'label': 'Reference',
                'id':'reference',
                'value': '12345678',
                'category':'sell rent room'

            },
            {
                'label': 'Auction',
                'id':'auction',
                'value': '--',
                'category':'sell'

            }]

        ],
        "facilities": "",
        "NearbyPlaces": [],
        "percentage_value": 90,
        "interest_rate": 4.5,
        "years": 35,
        "installment": 0.0
        


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
                if(newVal === oldVal) return;
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
            
            var prop_ref = location.search.split('reference=')[1];
            
            /**
             * @description This function preparing message data
             */
            var prepare_message_data = function($scope)
            {
                var category_name = $scope.mapping[$.trim($('#type').val())];
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
                            'listing_Type' : category_name.toUpperCase(),
                            'price': parseFloat($('#asking_price input').val()).toFixed(2),
                            'car_park':$('#car_park').val(),
                            'auction': $('#auction').val(),
                            'buildup': $('#built_up').val(),
                            'landarea': $('#land_area').val(),
                            'bedrooms': $('#bedroom').val(),
                            'bathrooms': $('#bathroom').val(),
                            'ref_tag': prop_ref,
                            'furnished':$.trim($('#furnishing').val()),
                            'occupied':$.trim($('#occupied').val()),
                            'monthly_maintanance': parseFloat($('#monthly_maintanance').val()).toFixed(2),
                            'remark': remark,
                            'property_type':$.trim($('#property_type').val()),
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
                            'listing_Type' : category_name.toUpperCase(),
                            'price': parseFloat($('#monthly_rental input').val()).toFixed(2),
                            'car_park':$('#car_park').val(),
                            'buildup': $('#built_up').val(),
                            'landarea': $('#land_area').val(),
                            'bedrooms': $('#bedroom').val(),
                            'bathrooms': $('#bathroom').val(),
                            'ref_tag': prop_ref,
                            'furnished':$.trim($('#furnishing').val()),
                            'occupied':$.trim($('#occupied').val()),
                            'remark': remark,
                            'land_title_type': $.trim($('#land_title_type').val()),
                            'active':1,
                            'user_id':'',
                            'property_photo': '',
                            'property_type':$.trim($('#property_type').val()),
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
                    case "room":
                           listing = {
                            'listing_Type' : category_name.toUpperCase(),
                            'price': parseFloat($('#monthly_rental input').val()).toFixed(2),
                            'car_park':$('#car_park').val(),
                            'bathrooms': $('#bathroom').val(),
                            'ref_tag': prop_ref,
                            'furnished':$.trim($('#furnishing').val()),
                            'occupied':$.trim($('#occupied').val()),
                            'remark': remark,
                            'room_type':$.trim($('#room_type').val()),
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
                console.log(senddata);
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
                        
                        document.getElementById("lbl_"+ids[i]).scrollIntoView();
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
                    if(i===0)
                    {
                        $('html, body').animate({
                            scrollTop: $(id).offset().top
                        }, 1000);
                    }
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
                var listing_type = new String($('#type').val()).indexOf('For Sale') >= 0? "SELL" : "RENT";
                var remark = CKEDITOR.instances.remark.getData();
                var objHome = StaticHomeObject.getInstance();
                remark = objHome.remove_special_character_from_data(remark);
                
                if ($('#type').val().indexOf('Room To Let') > 0)
                {
                    listing_type = "ROOM";
                }
                var listing = {
                    'listing_type' : listing_type,
                    'price': (listing_type === "SELL")?parseFloat($('#asking_price input').val()).toFixed(2) : parseFloat($('#monthly_rental input').val()).toFixed(2),
                    'auction': ($('#auction').val() === "")?"--":$('#auction').val(),
                    'buildup': $('#built_up').val(),
                    'landarea': $('#land_area').val(),
                    'bedrooms': $('#bedroom').val(),
                    'bathrooms': $('#bathroom').val(),
                    'car_park':$('#car_park').val(),
                    'ref_tag': prop_ref,
                    'furnished':$.trim($('#furnishing').val()),
                    'occupied':$.trim($('#occupied').val()),
                    'monthly_maintanance': parseFloat($('#monthly_maintanance').val()).toFixed(2),
                    'remark': remark,
                    'room_type':$.trim($('#room_type').val()),
                    'property_type':$.trim($('#property_type').val()),
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
                
                var url = objProperty.getBaseUrl() + "index.php/properties_preview";
                //window.openDialog(url, "preview", "preview", JSON.stringify(listing));
                $.jStorage.set("preview_data", JSON.stringify(listing));
                $('#property_preview_content_iframe').attr('src', url);
                $("#popup_property_preview").modal('show');
                

            };
            
            var preview_check = function()
            {
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
                if(ids.length > 0)
                {
                    set_error(ids);
                    return false;
                }
                return true;
                
            };
            
            var submit_check = function()
            {
                if($('#upload_term_condition:checkbox:checked').length === 0)
                {
                    $scope.err_msg = "Please understand and agree to the terms and conditions";
                    return false;       
                }

                return true;                
            };
            
            // </editor-fold>
            // <editor-fold desc="set_listing"  defaultstate="collapsed">
            var set_listing = function(listing, $scope)
            {
                var senddata = "listing_information=" + JSON.stringify(listing);   
                //console.log(senddata);
                var url = objProperty.getBaseUrl() + "index.php/_utils/properties_upload/upload_listing";
                $http({
                 method: 'POST',
                 url: url,
                 data: senddata,
                 cache: false,
                 headers: {'Content-Type': 'application/x-www-form-urlencoded'}
               }).then(function(response) {
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
            
            var set_prop_info = function($scope)
            {
                $('select option').each(function()
                {
                   var value = $(this).val();
                   $(this).val($.trim(value));
                });
                
                //to update property information
                             
                //temporary hardcode for currency and type
                if($scope.property_information.currency === "RM")
                {
                    $scope.currency_value = {currency:"MYR"};
                }
                else
                {
                    $scope.currency_value = {currency:$scope.property_information.currency};
                }
                
                if($scope.property_information.details[0][0].value === "SELL")
                {
                    document.getElementById('property_type').value = "Property For Sale";
                }
                else if($scope.property_information.details[0][0].value === "RENT")
                {
                    document.getElementById('property_type').value = "Property For Lease";
                }
                else if($scope.property_information.details[0][0].value === "ROOM")
                {
                    document.getElementById('property_type').value = "Room To Let";
                }
                
                $scope.build_up = {value:Number($scope.property_information.details[0][4].value)};
                $scope.monthly_rental = {value:Number($scope.property_information.Price)};
                $scope.asking_price = {value:Number($scope.property_information.Price)};
                
                document.getElementById('property_type').value = $scope.property_information.details[0][2].value; 
                document.getElementById('chk_auction').checked = !($scope.property_information.details[1][6].value);
                document.getElementById('size_measurement_code').value = $scope.property_information.details[0][6].value; 
                document.getElementById('reserve_type').value = $scope.property_information.details[1][1].value; 
                document.getElementById('bedroom').value = $scope.property_information.RoomCount;
                document.getElementById('bathroom').value = $scope.property_information.ToiletCount;
                document.getElementById('car_park').value = $scope.property_information.ParkingCount; 
                document.getElementById('tenure').value = $scope.property_information.details[0][1].value;
                document.getElementById('land_title_type').value = $scope.property_information.details[1][2].value;   
                
                //furnishing
                var furnished;
                if($scope.property_information.details[1][3].value === "Fully")
                {
                    $furnished = "Full Furnished";
                }
                else if($scope.property_information.details[1][3].value === "Partially")
                {
                    $furnished = "Partially Furnished";
                }
                else
                {
                    $furnished = "No Furnished";
                }
                
                //occupied
                var occupied;
                if($scope.property_information.details[1][4].value === 0)
                {
                    $occupied = "No";
                }
                else
                {
                    $occupied = "Yes";
                }
                document.getElementById('furnishing').value = $furnished;
                document.getElementById('occupied').value = $occupied;
                document.getElementById('monthly_maintanance').value = $scope.property_information.details[1][0].value;
                
                //to update the remark
                document.getElementById('remark').value =  $scope.property_information.Remark;
                
                $scope.mapping = {
                  'Property For Sale':'sell',
                  'Property For Lease':'rent',
                  'Room To Let':'room'
              };
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
            
            get_new_listing_data($scope, $sce);
            set_prop_info($scope);
            set_location_map($scope);
            set_loaded_image($scope);
            set_selected_facilities();
            
            // </editor-fold>
            display_by_category($scope.mapping);
            set_auction();
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
 

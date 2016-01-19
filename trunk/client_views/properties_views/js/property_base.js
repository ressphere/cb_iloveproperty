var get_property_home = function() {
        return {
            Extends: get_base(),
            Initialize: function( private ){       
                this.parent.Initialize();
    
                private.categories = {
                    "RENT" : "index.php/properties_rent",  
                    "LEASE":"index.php/properties_lease",  
                    "SELL":"index.php/properties_sell",
                    "LAUNCH":"index.php/properties_new",
                    "SERVICES":"index.php/properties_services",
                    "BUY":"index.php/properties_buy"
                    
                };
                
            },
            Private:{
                categories: null,
                doughnutData: [],
                doughnut_size : 400,
                font_size : 10,
                fixed_landarea: 0.00,
                fixed_builtup: 0.00,
                measurement_type: null,
                fixed_currency_value: 0.00,
                fixed_currency_from: "",
                myDoughnut: null,
                currency: null,
                
                title_source: 'property_title',
                property_category_subject: new Subject(),
                _category_updated: function (private) {
                        this.property_category_subject.notify( this.categories );
                 },
                get_currency_subject: new Subject(),
                _currency_updated: function (private, price, from, to, index) {
                        var obj = {"0":price, 
                                    "1":from,
                                    "2": to,
                                    "3":index,
                                length:4};
                        this.get_currency_subject.notify(obj);
                 },
                _set_doughnut_title: function()
                {
                   var c = $('#property_service_category');
                   var ctx = c[0].getContext("2d");
                   var img=document.getElementById(this.title_source);
                   //adjust the image witdh and height
                   var w_ratio = this._get_width_ratio();
                   var h_ratio = this._get_height_ratio();
                   var ratio = 1;
                   if(w_ratio < h_ratio) 
                       ratio = w_ratio;
                   else
                       ratio = h_ratio;
                   var width = (img.width) * ratio;
                   var height = (img.height) * ratio;
                   var x = (this._get_width() - width) / 2.0;
                   var y = (this._get_height() - height) / 2.0;
                   ctx.drawImage(img,x, y, width, height);
                },
                _get_width_ratio: function() {
                    var w_ratio = 1;
                    var w_doughnut_size = this.doughnut_size + 100;
                    if($(window).width() < w_doughnut_size)
                    {
                            w_ratio = w_ratio = $(window).width()/w_doughnut_size;
                    }
                    return w_ratio;
                },
                _get_height_ratio: function() {
                    var h_ratio = 1;
                    var h_doughnut_size = this.doughnut_size + 100;
                    if($(window).height() < h_doughnut_size)
                    {
                         h_ratio = $(window).height()/h_doughnut_size;
                    }
                    return h_ratio;
                },
                _get_width: function() {
                    return this.doughnut_size * this._get_width_ratio();
                },
                _get_height: function() {
                    return this.doughnut_size * this._get_height_ratio();
                },
                _get_font_size: function() {
                    var new_font_size = this.font_size;
                    var w_ratio = this._get_width_ratio();
                    var h_ratio = this._get_height_ratio();
                    
                    if(w_ratio < h_ratio)
                    {
                        new_font_size = new_font_size * w_ratio; 
                    }
                    else
                    {
                        new_font_size = new_font_size * h_ratio;    
                    }
                    return new_font_size;
                },
                _get_doughnat_distance: function(x, y, top_offset) {
                     var _x = Math.round(x - ($(window).width() / 2.0));
                     var _y = Math.round(((this._get_height()/2) + top_offset) - y);
                     var distance = Math.sqrt(Math.pow(_x, 2) + Math.pow(_y, 2));
                     return distance;
                },
                _get_doughnat_degree: function(x,y, top_offset, distance) {
                     var _x = Math.round(x - ($(window).width() / 2.0));
                     var _y = Math.round(((this._get_height()/2) + top_offset) - y);
                     var degree = Math.acos(_y/distance);    
                          
                      if (_x < 0)
                      {
                        degree = (2 * Math.PI - degree );
                      }
                      return degree;
                },
                _on_property_service_category_click: function(ev) {
                   var top = ev.target.offsetTop + $("#content-top").offset().top + $("#content-top").height() + parseFloat($(".unfixed_content").css("padding-top").replace("px", ""));
                    var distance = this._get_doughnat_distance(ev.pageX, ev.pageY, top);
                    //alert(this.myDoughnut.get_doughnutRadius() +','+ this.myDoughnut.get_cutoutRadius()+' : '+distance);
                    if(distance < this.myDoughnut.get_doughnutRadius() && 
                            distance > this.myDoughnut.get_cutoutRadius())
                    {
                          // Get the data tan
                          var degree = this._get_doughnat_degree(ev.pageX, ev.pageY, top, distance);
                          
                          var arr_angle = this.myDoughnut.get_segmentAngleList();
                          for(i=0; i < arr_angle.length; i++ )
                          {
                            if(arr_angle[i][0] < degree && arr_angle[i][1] >  degree)
                            {
                               window.location.href = this.doughnutData[i].url;
                            }
                               
                          }
                          
                    }
                }
            },
            Public:{
               addObserver: function ( private, newObserver ) 
                   {
                       private.property_category_subject.observe( newObserver );
                   },
  
               removeObserver: function ( private, deleteObserver ) {
                        private.property_category_subject.unobserve( deleteObserver );
                    },
               
               addCurrencyObserver: function ( private, newObserver ) 
                   {
                       private.get_currency_subject.observe( newObserver );
                   },
  
               removeCurrencyObserver: function ( private, deleteObserver ) {
                        private.get_currency_subject.unobserve( deleteObserver );
                    },
  
               
               resize_main_menu: function (private) {
                        var c = $("#property_service_category");
                        
                        var canvas_width = private._get_width();
                        var canvas_height = private._get_height();
                        var new_font_size = private._get_font_size();
                        if (new_font_size < 14)
                        {
                            new_font_size = 14;
                        }
                        //LabelFontSize
                         c.attr('width', canvas_width);
                         c.attr('height', canvas_height);
                       var options = {
                                   animation : false, 
                                   LabelFontSize: new_font_size, 
                                   onAnimationComplete: function() { private._set_doughnut_title(); }};
                        //Call a function to redraw other content (texts, images etc)
                        private.myDoughnut = new Chart(document.getElementById("property_service_category").getContext("2d")).Doughnut(private.doughnutData, options);
                },
                set_anonymous_properties_category_as_doughnut: function(private)
                {
                    private.categories = {
                        "RENT" : "index.php/properties_rent",
                         //uncomment this when the service category is ready
                        //"LAUNCH":"index.php/properties_new",
                        //"SERVICES":"index.php/properties_services",
                        "BUY":"index.php/properties_buy"
                    };
                    this.set_properties_category_as_doughnut();
                    
                },
                set_properties_category_as_doughnut: function(private)
                {
                    var degree = 360 / Object.keys(private.categories).length;//private.categories.length
                    //Loop from the categories
                    //var doughnutData = [];
                    $.each(private.categories, function( key, value ) {
                        //alert( index + ": " + value + ":" + degree );
                    
                        private.doughnutData.push(
                        {
                                        Label: key,
					value: degree,
					color:"#808285",
                                        url: value
                         });
                    });
                    var c = $("#property_service_category");
                    var canvas_width = private._get_width();
                    var canvas_height = private._get_height();
                    var new_font_size = private._get_font_size();
                     if (new_font_size < 14)
                        {
                            new_font_size = 14;
                        }
                    //LabelFontSize
                    c.attr('width', canvas_width);
                    c.attr('height', canvas_height);
                       
                       
                    var options = {
                            onAnimationComplete: function() { private._set_doughnut_title(); },
                            animation : true, 
                            animateRotate: false,
                            animateScale : true, 
                            LabelFontSize: new_font_size
                            
                    };
                    
                    private.myDoughnut = new Chart(document.getElementById("property_service_category").getContext("2d")).Doughnut(private.doughnutData, options);
                    c.click(function(e){
//                    
                        private._on_property_service_category_click(e);
                    });
                   $(document).mousemove(function(ev){
                      var top = ev.target.offsetTop + $("#content-top").offset().top + $("#content-top").height() + parseFloat($(".unfixed_content").css("padding-top").replace("px", ""));
					  
                      var distance = private._get_doughnat_distance(ev.pageX, ev.pageY, top);

                      var c = $("#property_service_category"); 
                     //var _x = ev.pageX;
                      //var _y = ev.pageY;
                      //_x = Math.round(_x - ($(window).width() / 2.0));
                      //_y = Math.round(((private._get_height()/2) + top) - _y);
                      //distance = Math.sqrt(Math.pow(_x,2) + Math.pow(_y,2));
                      //$("#log").text("x: " + _x + " y: " + _y +" outer radius: " + private.myDoughnut.get_doughnutRadius() +" inner radius: "+private.myDoughnut.get_cutoutRadius() + " distance:" + _distance); 
                      //$("#log").text("x: " + _x + " y: " + _y +" outer radius: " + private.myDoughnut.get_doughnutRadius() +" inner radius: "+private.myDoughnut.get_cutoutRadius() + " distance:" + distance); 
                      if(distance < private.myDoughnut.get_doughnutRadius() && 
                            distance > private.myDoughnut.get_cutoutRadius())
                      {
                          
                           c.css('cursor', 'pointer');
                      }
                      else
                      {
                              c.css('cursor', 'initial');
                      }
                    });
                   
                   
                },
                get_current_category: function(private) {
                    return private.categories;
                },
                update_category:function(private) {
                        var base_path = this.getWsdlBaseUrl("index.php/cb_user_registration/get_wsdl_base_url");
                        var _url = base_path + "index.php/cb_user_registration/isLogin";
        
                        $.ajax({url: _url,
                            success: function(result, status, xhr) {
                                if(result === "-1")
                                {
                                    private.categories = {
                                        "RENT" : "index.php/properties_rent",
                                        //uncomment this when the service category is ready
                                        //"LAUNCH":"index.php/properties_new",
                                        //"SERVICES":"index.php/properties_services",
                                        "BUY":"index.php/properties_buy"
                                    };
                                }
                                else
                                {
                                    private.categories = {
                                        "RENT" : "index.php/properties_rent",  
                                        "LEASE":"index.php/properties_lease",  
                                        "SELL":"index.php/properties_sell",
                                        //uncomment this when the service category is ready
                                        //"LAUNCH":"index.php/properties_new",
                                        //"SERVICES":"index.php/properties_services",
                                        "BUY":"index.php/properties_buy"
                    
                                     };
      
                                }
                                private._category_updated();
                        },
                        data: null,
                        type: "POST",
                        dataType: "text",
                        timeout: 3000000,
                        async: false,
                        error: function(xhr) {
                            window.console&&console.log("There is An error occured: " + xhr.status + " " + xhr.statusText);
                        }
                    });

                },
                set_fav_currency: function(private, currency)
                {
                     $.cookie("currency", currency);
                     $.jStorage.set("currency", currency);
                     private._currency_updated(null, null, currency, null);
                },
                set_fav_measurement_type: function(private, measurement_type)
                {
                    $.cookie("measurement_type", measurement_type);
                    $.jStorage.set("measurement_type", measurement_type);
		    private.measurement_type = measurement_type;
                },
                get_fav_currency: function(private)
                {
                   var currency = $.cookie("currency");
                   if(typeof(currency) === 'undefined')
                   {
                      currency = $.jStorage.get("currency");
                   }
                   if(!currency)
                   {
                       currency = private.currency;
                   }
                   return currency;
                },
                get_fav_measurement_type: function(private)
                {
                   var measurement_type = $.cookie("measurement_type");
                   if(typeof(measurement_type) === 'undefined')
                   {
                      measurement_type = $.jStorage.get("measurement_type");
                   }
		   if(!measurement_type)
                   {
                       measurement_type = private.measurement_type;
                   }
                   return measurement_type;
                },
                OnUpdatingCurrency: function(private, price, from_currency, index)
                {
                    var to_currency = this.get_fav_currency();
                    
                    if (typeof to_currency !== 'undefined' && to_currency !== null)
                    {
                        private._currency_updated(price, from_currency, to_currency, index);
                    }
                    else
                    {
                        this.get_currency_type_from_ip(price, from_currency, index);
                    }
                },
		get_currency_type_from_ip:function(private,price, from_currency, index)
		{
                    
                    var currency = this.get_fav_currency();
                    
                    if (typeof currency === 'undefined' || currency === null)
                    {
                        
                        $.getJSON("http://freegeoip.net/json/", function (data,status,xhr) {
                             if(status === "success")
                             {
                                var country = data.country_name;
                                switch(country)
                                {
                                    case "Malaysia":
					private.currency = "MYR";
                                        break;
                                    case "Singapore":
					private.currency = "SGD";
                                        break;
                                    default:
                                        private.currency = "USD";
                                }
                                
				private._currency_updated(price, from_currency, private.currency, index);
                             }
                             else
                             {
                                 $.getJSON("http://www.telize.com/geoip?callback=?",
                                        function(json) {
                                            switch(json.country)
                                            {
                                                case "Malaysia":
                                                    private.currency = "MYR";
                                                    break;
                                                case "Singapore":
                                                    private.currency = "SGD";
                                                    break;
                                                default:
                                                    private.currency = "USD";
                                            }
                                            private._currency_updated(price, from_currency, private.currency, index);
	    	
                                        }
                                    );
                             }
                                
                         });
                    }
                },
                get_landarea:function(private)
                {
                    return private.fixed_landarea;
                },
                set_landarea:function(private, fixed_landarea)
                {
                    private.fixed_landarea = fixed_landarea;
                },
                get_built_up:function(private)
                {
                    return private.fixed_builtup;
                },
                set_built_up:function(private, fixed_builtup)
                {
                    private.fixed_builtup = fixed_builtup;
                },
                get_currency_value:function(private)
                {
                    return private.fixed_currency_value;
                },
                set_currency_value:function(private, fixed_currency_value)
                {
                    private.fixed_currency_value = fixed_currency_value;
                },
                get_currency_from:function(private)
                {
                    return private.fixed_currency_from;
                },
                set_currency_from:function(private, fixed_currency_from)
                {
                    private.fixed_currency_from = fixed_currency_from;
                }
                
            }
        };
 };
var measurement_type_change_click = function()
    {
        var measurement_type = $('.lbl_measurement_type').first().text();
        $('#select_property_measurement').val(measurement_type);
        $("#popup_property_measurement").modal('show');  
    };
var StaticHomeObject = (function () {
    var objHome;
 
    function createHomeInstance() {
        var objHome = $.makeclass(get_property_home());
        return objHome;
    }
 
    return {
        getInstance: function () {
            if (!objHome) {
                objHome = createHomeInstance();
            }
            return objHome;
        }
    };
})();
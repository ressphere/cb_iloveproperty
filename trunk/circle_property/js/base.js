/******************************************************************************
 * This is the default javascript that will be shared among all of the page
 *    - This base.js (base obj) doesn't mean to be inherite by other object
 * 
 *    
 * Pre-define HTML Class tag:
 *    1. numericOnly - Only allow numeric and action input
 *    2. currencyOnly - Only allow numeric, single dot and action input
 * 
 * Preserve HTML ID:
 *    1. popup - Login popup div id, define under setup_auth_ui API
 *    2. register - Register popup div id, define under setup_auth_ui API
 *    3. popup_logout - Logout popup div id, define under setup_auth_ui API
 *    4. forgot_password - Forget password popup div id, define under setup_auth_ui API
 *    5. after_login_menu - User login section, div for after login (signout and user info)
 *    6. system_login - User login section, div for login button
 * 
 * Animation embedded when base.js is included
 *    1. Initial load page while pocess HTML and fade in animation
 *    2. Page fade out navigate away animation
 * 
 * 
 * Useful Information:
 *    1. All common use API for base.js can be search with /*base_common_API: prefix
 ******************************************************************************/
/**
 * 
 * @type base (global variable)
 */

// build the Subject base class
var Subject = ( function( window, undefined ) {

  function Subject() {
    this._list = [];
  }

  // this method will handle adding observers to the internal list
  Subject.prototype.observe = function observeObject( obj ) {
    this._list.push( obj );
  };
  
  Subject.prototype.unobserve = function unobserveObject( obj ) {
    for( var i = 0, len = this._list.length; i < len; i++ ) {
      if( this._list[ i ] === obj ) {
        this._list.splice( i, 1 );
        return true;
      }
    }
    return false;
  };
  
  Subject.prototype.notify = function notifyObservers() {
    var args = Array.prototype.slice.call( arguments );
    for( var i = 0, len = this._list.length; i < len; i++ ) {
      this._list[ i ].update.apply( null, args );
    }
  };

  return Subject;

} )( window );

var get_base = function() {
    /**
     * @class base
     */
    return {
        /**
         * @class base
         * @constructor
         * @param {attributes} private private attribute of the base class defined in private
         * @returns {void}
         */
        Initialize: function( private )
        {
          // Dedicated Link name initialization
          private.enter_form = "index.php/cb_user_registration/loginView";
          private.exit_form = "index.php/cb_user_registration/logoutView";
          private.login = "index.php/cb_user_registration/beginLogin";
          private.register_form = "index.php/cb_user_registration/registerView";
          private.logout = "index.php/cb_user_registration/logout";
          private.login_check = "index.php/cb_user_registration/isLogin";
          private.get_user_info = "index.php/cb_user_registration/get_user_info";
          private.reload_captcha = "index.php/cb_user_registration/create_captcha";
          private.forgot_password = "index.php/cb_user_registration/forgotpassView";
          private.image_loader = "images/ajax-loader.gif";
          private.wsdl_path = "index.php/cb_user_registration/get_wsdl_base_url";
          
          // @Todo - Should have better algs to determine the wsdl base url
          //         Sould not hardcode and initial determine the value
          private.wsdl = null;
          //this.setWSDL();
          //private.wsdl = this.getWsdlBaseUrl("index.php/cb_user_registration/get_wsdl_base_url");
         
        },
        /**
         * Private attributes
         */
        Private:{
            // Link name variable
            enter_form: null,
            base_url: null,
            login: null,
            logout: null,
            register_form: null,
            image_loader: null,
            exit_form: null,
            login_check: null,
            _invoked_after_getting_your_country: null
  
        },
        Public:{
            // ------- Common function ------- Start --------
            // Can Search using /*base_common_API:
            
            /*base_common_API: setWSDL
             * To retrieve the WSDL url from a common place
             * Must invoke before function getWsdlBaseUrl call
             * 
             * @param {type} url
             * @returns {undefined}
             */
            setWSDL: function(private, url)
            {
                if(typeof url !== 'undefined')
                {
                    private.wsdl = url;
                }
                else
                {
                    private.wsdl = this.getWsdlBaseUrl(private.wsdl_path);  
                }
            },
                    
            /*base_common_API: getWsdlBaseUrl
             * To obtain WebService Base URL 
             * 
             * @param String (Optional, obsolate) obtain the url through php API
             * @returns String Web service base url
             */
            getWsdlBaseUrl: function(private, wsdl_url)
            {
                if (private.wsdl !== null)
                {
                   return private.wsdl;
                }
                if(typeof(Storage) !== "undefined") {
                    private.wsdl = sessionStorage.wsdl;
                }
                else
                {
                    private.wsdl = $.cookie("wsdl");
                }
                
                if(typeof(private.wsdl) !== "undefined")
                {
                    return private.wsdl;
                }
                if(wsdl_url === undefined) {
                    wsdl_url = private.wsdl_path;
                }
                // This part should be remove or move to initial stage
                $.ajax
                ({
                    type: "POST",
                    url: this.getBaseUrl() + wsdl_url,
                    async:false,
                    timeout: 3000000,
                    data: null,
                    success: function(html)
                    {
                        private.wsdl = html;
                        if(typeof(Storage) !== "undefined") {
                            sessionStorage.wsdl = private.wsdl;
                        }
                        else
                        {
                            $.cookie("wsdl", private.wsdl, {expires :1,secure: true});
                        }
                        
                    },
                    error:function (xhr, ajaxOptions, thrownError)
                    {    
                        window.console&&console.log(xhr.status.toString());
                        window.console&&console.log(xhr.statusText);
                    }  
                });
                
                return private.wsdl;
            },
            
            /*base_common_API: setLoading
             * For loading effiect and display, overwrite HTML content for specific ID
             *  - DO overwite the id.html into empty string for lighten the process power
             * 
             * @param String HTML DIV id for content overwite to display purpose
             * @return Effect Overwrite the HTML content
             */
            setLoading: function(private, id) 
            {
                var base_path = this.getBaseUrl();
                $loading_html = '<center><img src="'+base_path+private.image_loader+'" id="loading-img" alt="Please Wait"/></center>';
                $(id).html($loading_html);
            },
			set_data:function(private, key, value)
            {
                if(typeof(Storage) !== "undefined") {
                   sessionStorage[key] = value;
				   
                }
                else
                {
                    $.cookie(key, value, {expires :1,secure: true});
					
                }
            },
            get_data:function(private, key)
            {
                var data = null;
                if(typeof(Storage) !== "undefined") {
                        data = sessionStorage[key];
                }
                if(data === null)
                {
                    data = $.cookie(key);
                }
                return data;
            },
                    
            /*base_common_API: generateUUID
             * Random generate an uniqu HTML ID to avoid conflic
             * 
             * @returns Sting Unique ID
             */
            generateUUID: function(private) 
            {
                var d = new Date().getTime();
                var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace
                (
                    /[xy]/g, 
                    function(c) 
                    {
                        var r = (d + Math.random()*16)%16 | 0;
                        d = Math.floor(d/16);
                        return (c==='x' ? r : (r&0x7|0x8)).toString(16);
                    }
                );
                    
                return uuid;
            },
            
            /*base_common_API: url_data_invoker
             * Perform URL call, pass and recieve data
             * 
             * @param obj   For ajax call
             * @param string URL path to invoke
             * @param string API to in the URL path to be incoke
             * @param undef Input data post to the specific URL
             * 
             * @return undef Data return from the url call
             */
            url_data_invoker: function(private, $http, url, api, input_data)
            {
                //console.log(input_data);
                return_data_api =  $http({
                    method: 'GET',
                    url: url+"/"+api,
                    cache: true,
                    params: input_data,
                    //obj_return_data : obj_return_data,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                })
                .then(
                    function(response) {
                        //console.log(response.data);
                        return response.data;
                    },
                    // If fail to invoke the url, following code will be executed
                    function(response) {
                        console.log(response);
                    }  
                );
                    
                return return_data_api;
            },
            
            
            /*base_common_API: callServer
             * Invoke php though ajax and direct overwrite the HTML
             * 
             * @param String HTML div ID
             * @param String Php url to be invoke
             * @param String input parameter
             * @returns Effect Overwrite the HTML content
             */
            callServer: function(private, id, url, senddata) 
            {
                this.setLoading(id);
                $.ajax
                ({
                    url: url,
                    type: 'POST',
                    data: senddata,
                    timeout: 3000000,
                    success: function(html)
                    {
                       $(id).html(html);
                    },
                    error:function (xhr, ajaxOptions, thrownError)
                    {
                            window.console&&console.log(xhr.status.toString());
                            window.console&&console.log(xhr.statusText);
                    }  
                });
            },
            
            /*base_common_API: getBaseUrl
             * Obtain current page base URL
             * 
             * @returns String Current page base URL
             */
            getBaseUrl: function()
            {
                var l = window.location;
                base_url = "";
                if(l.protocol)
                {
                    base_url = base_url + l.protocol + "//";
                }
           
                base_url = base_url + l.host + "/";
                
                var paths = l.pathname.split( '/' );
                for (var i=0;i<paths.length;i++)
                {
                    if(paths[i]!=="index.php" && paths[i] !== "")
                    {
                        base_url = base_url + paths[i] + "/";
                    }
                    if(paths[i]==="index.php")
                    {
                       break;     
                    }
                }
                return base_url;
            },
            
            /*base_common_API: getUserInfo
             * Get user profile and information
             * 
             * @returns json User information (user_id, username, displayname) or NULL if not login
             */
            getUserInfo: function(private)
            {
                this.setWSDL();
                var base_path = private.wsdl;
                url = base_path + private.get_user_info;
                var senddata = "";
                var userInfo = "";
                $.ajax
                ({
                    url: url,
                    type: 'POST',
                    data: senddata,
                    async: false,
		    timeout: 3000000,
                    success: function(html)
                    {
                       userInfo =  html;
                    },
                    error:function (xhr, ajaxOptions, thrownError)
                    {
                            window.console&&console.log(xhr.status.toString());
                            window.console&&console.log(xhr.statusText);
                    }  
                });
                return userInfo;
            },
            
            /*base_common_API: get_lastname
             * Use to retreive the last string from the provided URL string
             * 
             * @param String URL path for extraction
             * @returns String last string from the URL
             */
            get_lastname: function(private, full_path)
            {
                var index = full_path.lastIndexOf("/") + 1;
                var filename = full_path.substr(index);
                return filename;
            },
                    
            // ------- Common function ------- End ----------
            
            // =================================================================
            // ------- Predefine function ------- Start --------
            
            /*
             * Only allow number and action key input
             * Html class: numericOnly
             * 
             * @param String HTML class name to have this effect
             * @returns NULL 
             */
            setNumericInput: function(private, id) 
            {
                $(id).keydown
                (
                    function (e) 
                    {
                        // Allow: backspace, delete, tab, escape, enter and .
                        //alert($(this).val().indexOf('.'));

                        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
                            // Allow: Ctrl+A
                            (e.keyCode === 65 && e.ctrlKey === true) || 
                            // Allow: home, end, left, right
                            (e.keyCode >= 35 && e.keyCode <= 39)) 
                        {
                            // let it happen, don't do anything
                            return;
                        }

                        // Ensure that it is a number and stop the keypress
                        else if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) 
                        {
                            e.preventDefault();
                        }
                    }
                );
            },
                    
            /*
             * Only allow number, action key and dot "." input
             * Html class: currencyOnly
             * 
             * @param String HTML class name to have this effect
             * @returns NULL 
             */
            setCurrencyInput: function(private, id) 
            {
                $(id).keydown
                (
                    function (e) 
                    {
                        // Allow: backspace, delete, tab, escape, enter and .
                        //alert($(this).val().indexOf('.'));

                        if(e.keyCode === 190 && $(this).val().indexOf('.') !== -1)
                        {
                            //alert();
                            e.preventDefault();
                        }

                        else if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                            // Allow: Ctrl+A
                            (e.keyCode === 65 && e.ctrlKey === true) || 
                            // Allow: home, end, left, right
                            (e.keyCode >= 35 && e.keyCode <= 39)) 
                        {
                            // let it happen, don't do anything
                            return;
                        }

                        // Ensure that it is a number and stop the keypress
                        else if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) 
                        {
                            e.preventDefault();
                        }
                });
            },
			 /*
             * Only allow number, action key, dash "-" and plus "+" input
             * Html class: currencyOnly
             * 
             * @param String HTML class name to have this effect
             * @returns NULL 
             */
            setPhoneNumberInput: function(private, id) 
            {
                $(id).keydown
                (
                    function (e) 
                    {
                        // Allow: backspace, delete, tab, escape, enter and .
						//alert(e.keyCode);
                        if(e.keyCode === 189 && $(this).val().indexOf('-') !== -1)
                        {
                            //alert();
                            e.preventDefault();
                        }
						else if(((e.shiftKey && e.keyCode === 187) || e.keyCode === 107) && $(this).val().indexOf('+') !== -1)
                        {
                            //alert();
                            e.preventDefault();
                        }

                        else if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 107, 189]) !== -1 ||
                            // Allow: Ctrl+A
                            (e.keyCode === 65 && e.ctrlKey === true) || 
                            // Allow: home, end, left, right
                            (e.keyCode >= 35 && e.keyCode <= 39) ||
							(e.shiftKey && e.keyCode === 187)) 
                        {
                            // let it happen, don't do anything
                            return;
                        }

                        // Ensure that it is a number and stop the keypress
                        else if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) 
                        {
                            e.preventDefault();
                        }
                });
            },
                    
                    
            // ------- Predefine function ------- End ----------
            
            // =================================================================
            // ------- Base Header and Footer Features --- Start --------
            
            /* 
             * Initialize or setup the user section according to login status
             *    new gateway for is_login API, which have predefine ID
             *    - Must invoke by the UI base js script (e.g property_header.js)
             * 
             * @returns Effect Update all the UI related to user login section
             */
            preload_login: function(private)
            {
                this.is_login('#after_login_menu', '#system_login_parent');
            },
            
            /*
             * Initialize or preload all popup HTML for login/logout features
             *    New gateway for all popup, which have predefine ID
             *    - Must invoke by the UI base js script (e.g property_header.js)
             * 
             * @returns Effect Obtain and preload the HTML content for corresponding popup
             */
            setup_auth_ui: function()
            {
                    this.getLogin('#popup');
                    this.getRegister('#register');
                    this.getLogout('#popup_logout');
                    this.getForgot('#forgot_password');
            },
                    
            /*
             * Obtain HTML code for UI and overwrite the id HTML content
             *    For registeration pop up page
             * 
             * @param String HTML div id for content overwrite
             * @returns Effect Overwrite ID HTML with pop up registeration UI
             */
            getRegister: function(private, id)
            {
                this.setWSDL();
                var base_path = private.wsdl;
                this.setLoading(id);
				var register_html = this.get_data("register");
				if(typeof(register_html) !== "undefined")
				{
					$(id).html(register_html);
				}
				else
				{
				    var sender = this;
					$.ajax
					({
						url: base_path + private.register_form,
						type: 'POST',
						data: null,
						timeout: 3000000,
						success: function(html)
						{
							$(id).html(html);
							sender.set_data("register", html);
						},
						error:function (xhr, ajaxOptions, thrownError)
						{
								window.console&&console.log(xhr.status.toString());
								window.console&&console.log(xhr.statusText);
						}  
					});
				}
            },
            
            /*
             * Obtain HTML code for UI and overwrite the id HTML content
             *    For login pop up page
             * 
             * @param String HTML div id for content overwrite
             * @returns Effect Overwrite ID HTML with pop up login UI
             */
            getLogin: function(private, id)
            {
                this.setWSDL();
                var base_path = private.wsdl;
                this.setLoading(id);
				var login_html = this.get_data("login");
				if(typeof(login_html) !== "undefined")
				{
					$(id).html(login_html);
				}
				else
				{
					var sender = this;
					$.ajax
					({
						url: base_path + private.enter_form,
						type: 'POST',
						async:false,
						timeout: 3000000,
						data: null,
						success: function(html)
						{
							$(id).html(html);
							sender.set_data("login", html);
						},
						error:function (xhr, ajaxOptions, thrownError)
						{
                            window.console&&console.log(xhr.status.toString());
                            window.console&&console.log(xhr.statusText);
						}  
					});
				}
                //return return_html;
            },
            
            /*
             * Obtain HTML code for UI and overwrite the id HTML content
             *    For logout pop up page
             * 
             * @param String HTML div id for content overwrite
             * @returns Effect Overwrite ID HTML with pop up logout UI
             */
            getLogout: function(private, id){
                this.setWSDL();
                
                var base_path = private.wsdl;
                this.setLoading(id);
                var senddata = null;
                var url = base_path + private.exit_form;
                
                this.callServer(id, url, senddata);
                
            },
            
            /*
             * Obtain HTML code for UI and overwrite the id HTML content
             *    For forget password pop up page
             * 
             * @param String HTML div id for content overwrite
             * @returns Effect Overwrite ID HTML with pop up forget password UI
             */
            getForgot: function(private, id)
            {
                this.setWSDL();
                var base_path = private.wsdl;
                this.setLoading(id);
				var forgot_html = this.get_data("forgot");
				if(typeof(forgot_html) !== 'undefined')
				{
					$(id).html(forgot_html);
				}
				else
				{
					var sender = this;
					$.ajax
					({
						url: base_path + private.forgot_password,
						type: 'POST',
						data: null,
						timeout: 3000000,
						success: function(html)
						{
							$(id).html(html);
							sender.set_data("forgot", html);
							
						},
						error:function (xhr, ajaxOptions, thrownError)
						{
								window.console&&console.log(xhr.status.toString());
								window.console&&console.log(xhr.statusText);
						}  
					});
				}
            },
            
            /*
             * Reload Captcha image for verification purpose
             * 
             * @param String Captcha div ID for HTML overwrite
             * @param String Info request type, currently accept only "register" as input
             * @returns Effect Overwrite HTML content with new captcha image
             */
            reload_captcha: function(private, updatesection, type)
            {
                this.setWSDL();
                var base_path = private.wsdl;
                url = base_path + private.reload_captcha;
                var senddata = "type=" + type;
                $.ajax
                ({
                    url: url,
                    type: 'POST',
                    timeout: 3000000,
                    data: senddata,
                    success: function(html) 
                    {
                        $(updatesection).html(html);
                    },
                    error:function (xhr, ajaxOptions, thrownError)
                    {
                            window.console&&console.log(xhr.status.toString());
                            window.console&&console.log(xhr.statusText);
                    }
                 });
            },
            
            /* 
             * Show login button
             *    Obsolated
             * 
             * @param String Login button HTML div id
             * @returns Effect added show class tag toward div class
             */
            showLogin:function(private, id) {
                $(id).modal('show');
            },
            
            /* 
             * Hide login button
             *    Obsolated
             * 
             * @param String Login button HTML div id
             * @returns Effect added hide class tag toward div class
             */
            hideLogin:function(private, id) {
                $(id).modal('hide');
            },
                    
            /*
             * Perform logout proccedure, which give back the login button
             *    Will overwrite the user login section HTML content
             * 
             * @param String User login section HTML div ID
             * @returns Effect Overwrite HTML to provide login button
             */
            invokeLogout: function (private, id) 
            {
                this.setWSDL();
                var base_path = private.wsdl;
                senddata = null;
                url = base_path + private.logout;
                this.callServer(id, url, senddata);
            },
                    
            /*
             * UI control to display corresponding status
             *  Show login button or user detail
             *  !! Not user for check login status, name have issue !!
             * 
             * @param String logout HTML div ID
             * @param String login HTML div ID
             * @param String register HTML div ID
             * @returns Effect Update the HTML accordingly
             */
            is_login: function(private, logout_id, login_id, register_id)
            {
                this.setWSDL();
                var base_path = private.wsdl;
                url = base_path + private.login_check;
                var senddata = "";
                $.ajax
                ({
                    url: url,
                    type: 'POST',
                    data: senddata,
		    timeout: 3000000,
                    success: function(html)
                    {
                        if(html !== "-1")
                        {
                            //login success
                            $(logout_id).css('display','block');
                            $(login_id).css('display','none');
                            $(register_id).css('display','none');
                            $('#popup').modal('hide');
                        }
                        else
                        {
                            $(logout_id).css('display','none');
                            $(login_id).css('display','block');
                            $(register_id).css('display','block');
                        }
                    },
                    error:function (xhr, ajaxOptions, thrownError)
                    {
                            window.console&&console.log(xhr.status.toString());
                            window.console&&console.log(xhr.statusText);
                    }  
                });
            },
            /*
             * Set footer position and alignment
             * 
             * @returns Effect beutify the footer
             */
            set_footer_position: function()
            {
                var content_height = 0;
                $('.push').css('visibility', 'collapse');
                $('.push').height(0);
                $('.unfixed_content').each
                (
                    function() 
                    {
                        content_height = content_height + $(this).outerHeight(true);
                    }
                );
                $('.content').each
                (
                    function() 
                    {
                        if(!$(this).hasClass("unfixed_content"))
                        {
                            content_height = content_height + $(this).outerHeight(true);
                        }
                    }
                );
                var windows_height = 0;
                windows_height = windows_height + window.innerHeight;
                var extra_space = (windows_height - content_height) / 2.0;
                
                if(extra_space > 0)
                {
                    $('.push').css('visibility', 'visible');		
                    $('.push').height(extra_space);
                }    
                else
                {
                    $('.push').css('visibility', 'collapse');
                    $('.push').height(0);     
                }
            },
	
             /*
             * Get file base name Eg. a/a.txt -> a.txt
             * 
             * @returns Effect beutify the footer
             */
            get_filebaseName: function(private, str)
            {
               var last_index = str.lastIndexOf('/');
               if(last_index < 0)
               {
                   last_index = str.lastIndexOf('\\');
               }
               
               var base = new String(str).substring(last_index + 1);
               return base;
            },
            showPosition:   function(private, position, mapholderID) {
                    var latlon = position.coords.latitude + "," + position.coords.longitude;

                    var img_url = "http://maps.googleapis.com/maps/api/staticmap?center="+latlon+"&zoom=14&size=400x300&sensor=false";
                    document.getElementById(mapholderID).innerHTML = "<img src='"+img_url+"'>";
            },
            successGetMyLocation:  function(private, position) {
                    var geocoder = new google.maps.Geocoder();
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    var latlng = new google.maps.LatLng(lat, lng);
                    geocoder.geocode({'latLng': latlng}, function(results, status) {
                        if (status === google.maps.GeocoderStatus.OK) {
                            var country =  null;
                            var currency = null;
                            if (results[1]) {
                                 for (var i=0; i<results[0].address_components.length; i++) {
                                    for (var b=0;b<results[0].address_components[i].types.length;b++) {
                                        if (results[0].address_components[i].types[b] === "country") {
                                            //this is the object you are looking for
                                            country= results[0].address_components[i];
                                            break;
                                        }
                                    }
                                }
                                switch(country.short_name)
                                {
                                    case "MY":
                                        currency = "MYR";
                                        break;
                                    case "SG":
                                         currency = "SGD";
                                         break;
                                    case "US":
                                        currency = "USD";
                                        break;
                                    default:
                                        currency = "MYR";
                                }


                            } else {
                              currency = "MYR";
                            }
                            $.cookie("currency", currency, { expires : 1 });
                            $.jStorage.set("currency", currency);
                          }
                          if(private._invoked_after_getting_your_country)
                          {
                              private._invoked_after_getting_your_country(currency);
                                
                          }
                          else
                          {
                              console.log("private._invoked_after_getting_your_country is undefined");
                          }
                    });
                },errorGetMyLocation: function(private){
                            private.currency = "MYR";
            },
            isMobile: function(private) {
               return  {
                    Android: function() {
                        return navigator.userAgent.match(/Android/i);
                    },
                    BlackBerry: function() {
                        return navigator.userAgent.match(/BlackBerry/i);
                    },
                    iOS: function() {
                        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
                    },
                    Opera: function() {
                        return navigator.userAgent.match(/Opera Mini/i);
                    },
                    Windows: function() {
                        return navigator.userAgent.match(/IEMobile/i);
                    },
                    any: function() {
                        return (this.Android() || this.BlackBerry() || this.iOS() || this.Opera() || this.Windows());
                    }
                };
            }     
            // ------- Base Header and Footer Features --- End -----------
            
        }
    };
};


/*
 * To contribute initial load page animation while pocess HTML printing
 */
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

var  getScrollBarWidth = function() {
  var inner = document.createElement('p');
  inner.style.width = "100%";
  inner.style.height = "200px";

  var outer = document.createElement('div');
  outer.style.position = "absolute";
  outer.style.top = "0px";
  outer.style.left = "0px";
  outer.style.visibility = "hidden";
  outer.style.width = "200px";
  outer.style.height = "150px";
  outer.style.overflow = "hidden";
  outer.appendChild (inner);

  document.body.appendChild (outer);
  var w1 = inner.offsetWidth;
  outer.style.overflow = 'scroll';
  var w2 = inner.offsetWidth;
  if (w1 === w2) w2 = outer.clientWidth;

  document.body.removeChild (outer);

  return (w1 - w2);
};
var adjust_menu_size = function()
{
    if($(".wrapper").height() > $(window).height())
    {
        var ratio =  $(window).width() - getScrollBarWidth();
        $('#main_content').css("width",ratio);
    }
    else
    {
        $('#main_content').css("width","100%");
    }  
};

var auto_check_login_status = function(objBase)
{
     
        var logoutTimeout = setInterval(
                function()
                { 
                    $.ajax
                    ({
                        type: "POST",
                        url: objBase.getWsdlBaseUrl() + 'index.php/cb_home/check_login_status',
                        async:true,
                        data: null,
                        success: function(result)
                        {
                            if(result !== "1")
                            {
                               clearInterval(logoutTimeout);
                               alert("You are logout from the system. Please re-login again");
                               window.location.replace(objBase.getBaseUrl());
                               
                            }
                        },
                        error:function (xhr, ajaxOptions, thrownError)
                        {    
                            window.console&&console.log(xhr.status.toString());
                            window.console&&console.log(xhr.statusText);
                        }  
                    });
                }, 
        10000);  
};

$(window).load
(
    function()
    {
        
        $('body').css("opacity", "1");
        $('body').removeClass('animated fadeOut');
        $('body').addClass('animated fadeIn');
        var activate_login = $.jStorage.get("init_login");
        if(activate_login === "1")
        {
           $('#popup').modal('show');
           $.jStorage.deleteKey("init_login");
        }
        $('.system_logout_group').removeClass('active');
        adjust_menu_size();
        $('.modal').on('show.bs.modal', function () {
            setTimeout( function() {$('body').css('overflow', 'hidden');}, 100 );
            
        });
        
        $('.modal').on('hide.bs.modal', function () {
            $('body').css('overflow', 'auto');
        });
        var objBase = $.makeclass(get_base()); 
        $.ajax
        ({
            type: "POST",
            url: objBase.getWsdlBaseUrl() + 'index.php/cb_home/is_page_secure',
            async:true,
            data: null,
            success: function(result)
            {
                if (result === "1")
                {
                    auto_check_login_status(objBase);
                }
            },
            error:function (xhr, ajaxOptions, thrownError)
            {    
                window.console&&console.log(xhr.status.toString());
                window.console&&console.log(xhr.statusText);
            }  
        });
        
    }
);

$(window).resize(function(){adjust_menu_size();});
 

/*
 * To contribute page navigate away animation
 */
 $(window).on('beforeunload', function(){  
     $('body').removeClass('animated fadeIn');
     $('body').addClass('animated fadeOut');
 });
 
 /*
  * Pre-define Follow HTML Class tag:
 *    1. numericOnly - Only allow numeric and action input
 *    2. currencyOnly - Only allow numeric, single dot and action input
  * 
  */
 $(function () {
    var objBase = $.makeclass(get_base());
    objBase.setNumericInput(".numericOnly");
    objBase.setCurrencyInput(".currencyOnly");
    objBase.setPhoneNumberInput(".phoneOnly");
    $('input, select, textarea, button, div').on('focus',
        function()
        {
            $(this).css('outline', 'transparent');
        }
    );
});

/*
 * Allow format string as sprintf (php), printf(C)
 */
String.format = function() {
    // The string containing the format items (e.g. "{0}")
    // will and always has to be the first argument.
    var theString = arguments[0];
    for (var i = 1; i < arguments.length; i++) {
        var regEx = new RegExp("\\{" + (i - 1) + "\\}", "gm");
        theString = theString.replace(regEx, arguments[i]);
    }
    
    return theString;
};

 
 
 
 
 
 
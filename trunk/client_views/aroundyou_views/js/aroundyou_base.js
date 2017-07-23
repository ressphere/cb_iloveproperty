/******************************************************************************
 * This is the base JS, in which the only one doesn't contain Angularjs format
 *    - Please assert prefix "aroundyou_base__"
 ******************************************************************************/

/* This the the entry for the aroundyou base class obj
 * 
 * @returns obj AroundYou base object
 */
var AroundYou_base__base_Object = (function () {
        var aroundyou_base_obj;

        function create_AroundYou_base_Instance() {
            var aroundyou_base_obj = $.makeclass(get_aroundyou_base());
            return aroundyou_base_obj;
        }

        return {
            getInstance: function () {
                if (!aroundyou_base_obj) {
                    aroundyou_base_obj = create_AroundYou_base_Instance();
                }
                return aroundyou_base_obj;
            }
        };
})();

/* This is the AroundYou actual class, which wrap around server base class
 * Will need to cast to object before using this, please use AroundYou_base_Object as entries
 * 
 */
var get_aroundyou_base = function() {
        return {
            Extends: get_base(),
            Initialize: function( private ){       
                this.parent.Initialize();
                
                
            },
            Private:{
                // degrees to radians
                _deg2rad: function(private, degrees){
                    return (Math.PI * degrees / 180.0);
                },
                        
                // radians to degrees
                _rad2deg: function(private, radians) {
                    return (180.0 * radians / Math.PI);
                },
                
                // Earth radius at a given latitude, according to the WGS-84 ellipsoid in meter
                // http://en.wikipedia.org/wiki/Earth_radius
                _earthRadius: function(private, lat)
                {
                    // Semi-axes of WGS-84 geoidal reference
                    var major_semiaxis = 6378137.0;  // Major semiaxis [m]
                    var minor_semiaxi = 6356752.3;  // Minor semiaxis [m]
                    var An = major_semiaxis * major_semiaxis * Math.cos(lat);
                    var Bn = minor_semiaxi * minor_semiaxi * Math.sin(lat);
                    var Ad = major_semiaxis * Math.cos(lat);
                    var Bd = minor_semiaxi * Math.sin(lat);
                    return Math.sqrt( (An*An + Bn*Bn)/(Ad*Ad + Bd*Bd) );
                }
            },
            Public:{ 
                // Provided shifted coordinate
                //
                // @param float Degree value that represent longitude or latitude
                // @param int   Shifted distance in meter
                // @param string    Indicator of the degree value is "logitude" or "latitude"
                // @param string    Indicator of the shift direction, "left", "right", "up" or "down"
                // @return float    Degree value that after shifted
                latitude_longitude_converter : function(private, ori_degree, shift_m, log_la, direction){
                    ori_rad = private._deg2rad(private, ori_degree);
                    halfSide = shift_m;
                    earth_ori_rad = private._earthRadius(private, ori_rad);
                    
                    if (log_la === "latitude")
                    {
                        shift_rad = halfSide/earth_ori_rad;
                        
                        //console.log("shift_rad is " + shift_rad);
                        
                        if (direction === "up")
                        {
                            //console.log("shift up and get " + private._rad2deg(private, ori_rad + shift_rad));
                            return private._rad2deg(private, ori_rad + shift_rad);
                        }
                        else if (direction === "down")
                        {
                            return private._rad2deg(private, ori_rad - shift_rad);
                        }
                        else
                        {
                            console.log("Error: Unregconize latitude shift to "+direction);
                        }
                    }
                    else if (log_la === "longitude")
                    {
                        parallel_rad = earth_ori_rad * Math.cos(ori_rad)
                        shift_rad = halfSide/earth_ori_rad;
                        //console.log("shift_rad is " + shift_rad);
                        if (direction === "left")
                        {
                            return private._rad2deg(private, ori_rad - shift_rad);
                        }
                        else if (direction === "right")
                        {
                            return private._rad2deg(private, ori_rad + shift_rad);
                        }
                        else
                        {
                            console.log("Error: Unregconize longitude shift to "+direction);
                        }
                    }
                    else
                    {
                        console.log("Error: Unregconize log_la is "+log_la);
                    }
                },
                
            }
        };
 };


/*
 * Following are the common apps for aroundyou
 */

var aroundyou_base_apps = angular.module("aroundyou_base_apps",['uiGmapgoogle-maps', 'ngGPlaces']);

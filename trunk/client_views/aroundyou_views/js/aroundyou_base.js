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
                
            },
            Public:{         
                     
            }
        };
 };

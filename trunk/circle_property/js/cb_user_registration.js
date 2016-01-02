/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(
    function() {
        var objBase = $.makeclass(get_base());
        $('.activation_close').click(function()
            {
               $('#activation').modal('hide'); 
              /* $('#popup').modal({
                  'keyboard': false,
                  'backdrop':'static',
                  'show': true
               }); */
                
                window.location.href = objBase.getBaseUrl();
            });
            
           // objBase.getLogin('#popup');
            //objBase.getRegister('#register');
             
            $('#activation').modal('show');
        });





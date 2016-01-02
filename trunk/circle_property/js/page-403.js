$(document).ready(
   function()
   {
       $('#login403').click(
           function()
           {
                $.jStorage.set("init_login", "1");
                var url = $(this).children("input[name='nav']");
                $(this).prop('disabled', true);
                window.location.replace(url.val());
           }
       );
   }
);


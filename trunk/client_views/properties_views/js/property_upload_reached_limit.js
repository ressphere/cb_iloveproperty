$(document).ready(function()
{
   $("#btnBack").click(
      function()
      {
          parent.history.back();
      }
   );
   $("#btnBack").on('focus', function() {$(this).css('outline', 'transparent');});
});


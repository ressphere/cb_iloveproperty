$(document).ready(
    function() {
        var objBase = $.makeclass(base);
        objBase.setNumericInput(".numericOnly");
        objBase.setCurrencyInput(".currencyOnly");
        
    }
);

/**
 * readData method
 *
 * read in input key in by user(property's owner) according to element tag "input"
 *
 * @param	null
 * @return	null
 */

function readData() 
{

    var inputs = document.getElementsByTagName('input');
    var data_input = new Array;
    for (i in inputs) {
        data_input[i - 0] = inputs[i].value;
    }

    passToServer(data_input);
}

/**
 * passToServer method
 *
 * convert the data input to json format and pass to server
 *
 * @param	data_input
 * @return	null
 */

function passToServer(data_input)
{
    var data_input_string = "html_syntext=" + JSON.stringify(data_input);
    var _url = "create_request";
    $.ajax({url: _url,
        success: function(result, status, xhr) {
            alert(result);
        },
        data: data_input_string,
        type: "POST",
		timeout: 3000000,
        dataType: "text",
        error: function(xhr) {
            alert("There is An error occured: " + xhr.status + " " + xhr.statusText);
        }
    });
}

/**
 * handleFileSelect method
 *
 * insert a span element to show the thumbnail of the selected image files
 *
 * @param	evt
 * @return	null
 */

function handleFileSelect(evt) {
    var files = evt.target.files; // FileList object

    var list = document.getElementsByClassName("thumb");
    if(list)
    {
        for (var j = list.length; j > 0 ; j--) {
        list[j-1].parentNode.removeChild(list[j-1]);
        }
    }

    // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, f; f = files[i]; i++) {

        // Only process image files.
        if (!f.type.match('image.*')) {
            continue;
        }

        var reader = new FileReader();

        // Closure to capture the file information.
        reader.onload = (function(theFile) {
            return function(e) {
                
                // Render thumbnail.
                var span = document.createElement('span');
                span.innerHTML = ['<img class="thumb" src="', e.target.result,
                    '" title="', escape(theFile.name), '"/>'].join('');
                document.getElementById('image_uploader').insertBefore(span, "#status");
            };
        })(f);

        // Read in the image file as a data URL.
        reader.readAsDataURL(f);
    }
}

$(document).ready(function() {
    document.getElementById('files').addEventListener('change', handleFileSelect, false);
   
   
});

$(function() {
  /* variables */
  var status = $('#status');
  var percent = $('#percent');
  var bar = $('#bar');
  
  /* submit form with ajax request using jQuery.form plugin */
  $('form').ajaxForm({

    /* set data type json */
    dataType:'json',

    /* reset before submitting */
    beforeSend: function() {
      status.fadeOut();
      bar.width('0%');
      percent.html('0%');      
    },

    /* progress bar call back*/
    uploadProgress: function(event, position, total, percentComplete) {
      var pVel = percentComplete + '%';
      bar.width(pVel);
      percent.html(pVel);
    },

    /* complete call back */
    complete: function(data) {
      status.html(data.responseJSON.count + 'Files uploaded!').fadeIn();
    }

  });
});
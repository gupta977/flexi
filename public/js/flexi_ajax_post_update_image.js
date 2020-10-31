jQuery(document).ready(function () {
//Update primary image
jQuery(".flexi_ajax_post_update_image").on("submit", function (e) {
    e.preventDefault();
    var form = jQuery("#flexi-request-form-update-primary")[0];
    var formData = new FormData(form);
    var i = 0;
    var progress = true;
    alert("heeeexxxx");
    
    jQuery.ajax({
      type: "post",
      dataType: "json",
      url: myAjax.ajaxurl,
      enctype: "multipart/form-data",
      processData: false,
      contentType: false,
      data: formData,
      xhr: function () {
        var jqXHR = null;
        if (window.ActiveXObject) {
          jqXHR = new window.ActiveXObject("Microsoft.XMLHTTP");
        } else {
          jqXHR = new window.XMLHttpRequest();
        }

        //Upload progress
        jqXHR.upload.addEventListener(
          "progress",
          function (evt) {
            if (evt.lengthComputable) {
              var percentComplete = Math.round((evt.loaded * 100) / evt.total);
              //Do something with upload progress
              console.log('Uploaded percent', percentComplete);
              
            }
          },
          false
        );
        //Download progress
        jqXHR.addEventListener(
          "progress",
          function (evt) {
            if (evt.lengthComputable) {
              var percentComplete = Math.round((evt.loaded * 100) / evt.total);
              //Do something with download progress
              // console.log("Downloaded percent", percentComplete);
            }
          },
          false
        );
        return jqXHR;
      },
      beforeSend: function () {
        jQuery("#flexi_form_internal").slideUp();
        jQuery("#flexi_loader_internal").show();
        i = 0;
        progress = true;
      },

      success: function (response) {
        if (response.type == "success") {
          jQuery(".flexi_response_internal").show();
          jQuery(".flexi_response_internal").empty();
          jQuery(".flexi_response_internal").append(response.msg);
          //jQuery("#load_more_reset").click();
          jQuery(".flexi_response_internal").append(response);

         //console.log(response);
        } else {
          //console.log("Blank Response");
          jQuery(".flexi_response_internal").append(response.msg);
        }
      },
      complete: function (data) {
        // Hide image container
        //console.log("Submission completed");
        jQuery("#flexi_loader_internal").hide();
        //jQuery("#flexi_after_response").show();
        i = 0;
        progress = false;
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("Error occurred");
        jQuery(".flexi_response_internal").show();
        jQuery(".flexi_response_internal").empty();
        jQuery(".flexi_response_internal").append(
          "<div class='flexi_alert-box flexi_error'>Error: " +
            errorThrown +
            "</div>"
        );
      },
    });

  });
  

});
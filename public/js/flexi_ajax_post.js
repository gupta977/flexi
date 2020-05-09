jQuery(document).ready(function () {
  jQuery(".flexi_ajax_post").on("submit", function (e) {
    e.preventDefault();
    //post_id = jQuery(this).attr("data-post_id")
    //nonce = jQuery(this).attr("data-nonce")
    var form = jQuery("#flexi-request-form")[0];
    var formData = new FormData(form);
    var i = 0;
    var progress = true;
    //alert("start");

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
              //console.log('Uploaded percent', percentComplete);
              document.getElementById("flexi_progress").style.width =
                percentComplete + "%"; // width
              document.getElementById("flexi_progress").innerHTML =
                percentComplete + "%";

              if (percentComplete > 90) {
                setInterval(function () {
                  if (i < 100 && progress) {
                    document.getElementById(
                      "flexi_progress_process"
                    ).style.width = i + "%";
                    document.getElementById(
                      "flexi_progress_process"
                    ).innerHTML = i;
                    i++;
                  } else {
                    clearInterval(this);
                  }
                }, 1000);
              }
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
              console.log("Downloaded percent", percentComplete);
            }
          },
          false
        );
        return jqXHR;
      },
      beforeSend: function () {
        jQuery("#flexi_form").slideUp();
        jQuery("#flexi_loader").show();
        i = 0;
        progress = true;
      },

      success: function (response) {
        if (response.type == "success") {
          jQuery(".flexi_response").show();
          jQuery(".flexi_response").empty();
          jQuery(".flexi_response").append(response.msg);
          jQuery("#load_more_reset").click();
          jQuery(".flexi_response").append(response);

          console.log(response);
        } else {
          //console.log("Blank Response");
          jQuery(".flexi_response").append(response.msg);
        }
      },
      complete: function (data) {
        // Hide image container
        console.log("Submission completed");
        jQuery("#flexi_loader").hide();
        jQuery("#flexi_after_response").show();
        i = 0;
        progress = false;
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("Error occurred");
        jQuery(".flexi_response").show();
        jQuery(".flexi_response").empty();
        jQuery(".flexi_response").append(
          "<div class='flexi_alert-box flexi_error'>Error: " +
            errorThrown +
            "</div>"
        );
      },
    });
  });

  jQuery(document).on("click", ".flexi_send_again", function (e) {
    e.preventDefault();
    //alert("hello");
    jQuery("#flexi_after_response").hide();
    jQuery("#flexi_form").slideDown();
    jQuery(".flexi_response").empty();
    //jQuery('.flexi_response').hide();

    document.getElementById("flexi_progress").style.width = "0%"; // width
    document.getElementById("flexi_progress_process").style.width = "0%";
    document.getElementById("flexi_progress").innerHTML = "0%";
    document.getElementById("flexi_progress_process").innerHTML = "0";
  });

  jQuery(".flexi_send_again").click(function (e) {});
});

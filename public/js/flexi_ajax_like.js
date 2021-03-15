jQuery(document).ready(function () {
  jQuery(document).on("click", "#flexi_like", function (e) {
    e.preventDefault();
    post_id = jQuery(this).attr("data-post_id");
    media_id = jQuery(this).attr("data-media_id");
    key_type = jQuery(this).attr("data-key_type");
    var flexi_cookie = flexi_getCookie('flexi_c_' + post_id);
    //alert(post_id+'--'+media_id);
    nonce = jQuery(this).attr("data-nonce");
    if (flexi_cookie == '') {
      jQuery.ajax({
        type: "post",
        dataType: "json",
        url: myAjax.ajaxurl,
        data: { action: "flexi_ajax_like", post_id: post_id, nonce: nonce, media_id: media_id, key_type: key_type },
        success: function (response) {
          if (response.type == "success") {
            if (post_id) {
              //jQuery("#flexi_media_" + media_id).slideUp("slow");
              //alert(response.data_count);
              // jQuery("#flexi_like_count_"+post_id).slideUp("slow");



              if (key_type == "like") {
                jQuery("#flexi_like_count_" + post_id).empty();
                jQuery("#flexi_like_count_" + post_id).append(response.data_count).fadeIn("slow");
              }

              if (key_type == "unlike") {
                jQuery("#flexi_unlike_count_" + post_id).empty();
                jQuery("#flexi_unlike_count_" + post_id).append(response.data_count).fadeIn("slow");
              }
              var cookie_name = 'flexi_c_' + post_id;
              flexi_setCookie(cookie_name, 1, 365);


            }
            else {
              // jQuery("#flexi_content_" + post_id).slideUp("slow");
              // jQuery("#flexi_" + post_id).slideUp();
              // alert("alrfeady voted");
            }


          } else {
            alert("Error" + post_id);
          }
        },
      });
    }
    else {
      alert("alrady");
      console.log(flexi_cookie);
    }
  });
});

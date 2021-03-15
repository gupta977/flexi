jQuery(document).ready(function () {
  jQuery(document).on("click", "#flexi_like", function (e) {
    e.preventDefault();
    post_id = jQuery(this).attr("data-post_id");
    media_id = jQuery(this).attr("data-media_id");
    key_type = jQuery(this).attr("data-key_type");
    //alert(post_id+'--'+media_id);
    nonce = jQuery(this).attr("data-nonce");
       jQuery.ajax({
        type: "post",
        dataType: "json",
        url: myAjax.ajaxurl,
        data: { action: "flexi_ajax_like", post_id: post_id, nonce: nonce, media_id:media_id,key_type:key_type },
        success: function (response) {
          if (response.type == "success") {
            if(post_id)
            {
              //jQuery("#flexi_media_" + media_id).slideUp("slow");
             alert(response.data_count);
            // jQuery("#flexi_like_count_"+post_id).slideUp("slow");
             jQuery("#flexi_like_count_"+post_id).empty();
            jQuery("#flexi_like_count_"+post_id).append(response.data_count).fadeIn("slow");
            }
            else
            {
             // jQuery("#flexi_content_" + post_id).slideUp("slow");
             // jQuery("#flexi_" + post_id).slideUp();
             alert("alrfeady voted");
            }
            
                        
          } else {
            alert("some error: " + post_id);
          }
        },
      });
    
  });
});

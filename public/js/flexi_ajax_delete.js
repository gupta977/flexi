function reply_click(clicked_id) {
  //alert("You have clicked Link " + clicked_id);
}

jQuery(document).ready(function () {
  jQuery(document).on("click", "#flexi_ajax_delete", function (e) {
    e.preventDefault();
    post_id = jQuery(this).attr("data-post_id");
    nonce = jQuery(this).attr("data-nonce");
    var x = confirm(myAjax.delete_string);
    if (x) {
      jQuery.ajax({
        type: "post",
        dataType: "json",
        url: myAjax.ajaxurl,
        data: { action: "flexi_ajax_delete", post_id: post_id, nonce: nonce },
        success: function (response) {
          if (response.type == "success") {
            jQuery("#flexi_content_" + post_id).slideUp("slow");
            jQuery("#flexi_" + post_id).slideUp();
          } else {
            alert("Deleted: " + post_id);
          }
        },
      });
    }
  });
  jQuery("#abc").click(function (e) {
    //alert("hi");
  });
  jQuery(".xyz").click(function (e) {
    // alert("bye");
  });
});

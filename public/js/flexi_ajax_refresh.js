  //Load more button
  jQuery(document).ready(function () {
    var paged = 1;
    var count = 0;
  
    jQuery(document).on("click", "#flexi_ajax_refresh", function (e) {
      e.preventDefault();
      id = jQuery(this).attr("data-id");
      method_name = jQuery(this).attr("data-method_name");
      param1 = jQuery(this).attr("data-param1");
      param2 = jQuery(this).attr("data-param2");
      param3 = jQuery(this).attr("data-param3");
//alert("am reaed");
  
      jQuery.ajax({
        type: "post",
        dataType: "json",
        url: myAjax.ajaxurl,
        data: {
          action: "flexi_ajax_refresh",
          id: id,
          method_name: method_name,
          param1: param1,
          param2:param2,
          param3:param3,
        },
        beforeSend: function () {
          //alert("about to send");
          jQuery("#flexi_ajax_refresh_loader").show();
        },
        success: function (response) {
            jQuery("#flexi_ajax_refresh_content").empty();
          jQuery("#flexi_ajax_refresh_content").append(response.msg).fadeIn("normal");
         // alert(method_name);
          //alert("sssss");
          //alert(max_paged + "--" + paged);
        },
        complete: function (data) {
            jQuery("#flexi_ajax_refresh_loader").hide();
          var lightbox = GODude();
          var lightboxDescription = GODude({
            selector: ".godude",
          });
          // alert("response complete "+method_name);
        },
      });
    });
  });
  
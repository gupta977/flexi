//Toggle submission form
jQuery(document).ready(function () {
  jQuery("#flexi_submit_form").click(function (e) {
    jQuery("#flexi_toggle_form").slideToggle("slow");
  });
});

//Load more button
jQuery(document).ready(function () {
  var paged = 1;
  var count = 0;

  jQuery(".flexi_load_more").click(function (e) {
    e.preventDefault();
    gallery_layout = jQuery("#gallery_layout").text();
    popup = jQuery("#popup").text();
    padding = jQuery("#padding").text();
    hover_effect = jQuery("#hover_effect").text();
    php_field = jQuery("#php_field").text();
    hover_caption = jQuery("#hover_caption").text();
    evalue = jQuery("#evalue").text();
    column = jQuery("#column").text();
    max_paged = jQuery("#max_paged").text();
    album = jQuery("#album").text();
    search = jQuery("#search").text();
    postsperpage = jQuery("#postsperpage").text();
    orderby = jQuery("#orderby").text();
    user = jQuery("#user").text();
    keyword = jQuery("#keyword").text();
    attach = jQuery("#attach").text();
    attach_id = jQuery("#attach_id").text();
    filter = jQuery("#filter").text();
    reset = jQuery(this).attr("data-reset");
    post_status = jQuery("#post_status").text();

    if (reset == "true") {
      paged = 1;
      count = 0;
      jQuery("#flexi_main_loop").empty();
    }

    jQuery.ajax({
      type: "post",
      dataType: "json",
      url: myAjax.ajaxurl,
      data: {
        action: "flexi_load_more",
        max_paged: paged,
        gallery_layout: gallery_layout,
        popup: popup,
        padding: padding,
        hover_effect: hover_effect,
        php_field: php_field,
        hover_caption: hover_caption,
        evalue: evalue,
        column: column,
        album: album,
        search: search,
        postsperpage: postsperpage,
        orderby: orderby,
        user: user,
        keyword: keyword,
        attach: attach,
        attach_id: attach_id,
        filter: filter,
        post_status: post_status,
      },
      beforeSend: function () {
        //alert("about to send");
        jQuery("#flexi_load_more").slideUp();
        jQuery("#flexi_loader_gallery").show();
      },
      success: function (response) {
        jQuery("#flexi_main_loop").append(response.msg).fadeIn("normal");
        paged++;
        count = response.count;

        //alert(max_paged + "--" + paged);
      },
      complete: function (data) {
        // Hide image container
        jQuery("#flexi_loader_gallery").hide();
        jQuery("#flexi_load_more").slideDown();
        var lightbox = GODude();
        var lightboxDescription = GODude({
          selector: ".godude",
        });
        // alert("response complete");
        // alert(count);
        if (count > 0) jQuery("#flexi_no_record").hide();
        if (paged > max_paged) jQuery("#flexi_load_more").slideUp();
      },
    });
  });
});

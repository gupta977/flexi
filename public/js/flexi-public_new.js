jQuery(document).ready(function($) { 
  "use strict";

    //Uses in standalone gallery
    $("#flexi_thumb_image .flexi-image-wrapper-icon").hover(function () {
      var photo_fullsize = $(this).find("img").attr("large-src");
      $("#flexi_large_image").attr("src", photo_fullsize);
    });
  
});

function flexi_download_file(id) {
  alert(id);
  window.location.href = id;
}

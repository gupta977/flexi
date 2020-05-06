jQuery(document).ready(function () {
  jQuery(document).on("click", ".flexi_ajax_download", function (e) {
    e.preventDefault();
    post_id = jQuery(this).attr("data-post_id");
    nonce = jQuery(this).attr("data-nonce");
    var x = confirm(myAjax.download_string);
    if (x) {
      jQuery.ajax({
        type: "post",
        dataType: "json",
        url: myAjax.ajaxurl,
        data: { action: "flexi_ajax_download", post_id: post_id, nonce: nonce },
        success: function (response) {
          if (response.type == "success") {
            console.log(response);
            window.location = "http://localhost/test.php";
            /*
            var blob = new Blob([data]);
            var a = document.createElement("a");
            var url = window.URL.createObjectURL(blob);
            a.href = url;
            a.download = "v.png";
            document.body.append(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(url);
*/
            alert("Download completed");
          } else {
            alert("Error downloading");
          }
        },
      });
    }
  });
});

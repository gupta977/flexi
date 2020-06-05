(function ($) {
  "use strict";

  $(window).load(function () {
    function flexi_layout_value(lname) {
      if (lname == "basic" || lname == "regular") {
        $('form input[id*="column"]').prop("disabled", true);
        $('form input[id*="evalue_excerpt"]').prop("disabled", true);
        $('form input[id*="evalue_custom"]').prop("disabled", true);
        $('form input[id*="evalue_icon"]').prop("disabled", true);
        $('form input[id*="evalue_tag"]').prop("disabled", true);
        $('form input[id*="evalue_category"]').prop("disabled", true);
      } else if (lname == "masonry") {
        $('form input[id*="column"]').prop("disabled", false);
        $('form input[id*="evalue_excerpt"]').prop("disabled", true);
        $('form input[id*="evalue_custom"]').prop("disabled", true);
        $('form input[id*="evalue_icon"]').prop("disabled", true);
        $('form input[id*="evalue_tag"]').prop("disabled", true);
        $('form input[id*="evalue_category"]').prop("disabled", true);
      } else {
        $('form input[id*="column"]').prop("disabled", false);
        $('form input[id*="evalue_excerpt"]').prop("disabled", false);
        $('form input[id*="evalue_custom"]').prop("disabled", false);
        $('form input[id*="evalue_icon"]').prop("disabled", false);
        $('form input[id*="evalue_tag"]').prop("disabled", false);
        $('form input[id*="evalue_category"]').prop("disabled", false);
      }
    }

    flexi_layout_value($("select[id*='layout']").val());

    $("select[id*='layout']").change(function () {
      $(this)
        .find("option:selected")
        .each(function () {
          var optionValue = $(this).attr("value");
          flexi_layout_value(optionValue);
        });
    });
  });

  /**
   * All of the code for your admin-facing JavaScript source
   * should reside in this file.
   *
   * Note: It has been assumed you will write jQuery code here, so the
   * $ function reference has been prepared for usage within the scope
   * of this function.
   *
   * This enables you to define handlers, for when the DOM is ready:
   *
   * $(function() {
   *
   * });
   *
   * When the window is loaded:
   *
   * $( window ).load(function() {
   *
   * });
   *
   * ...and/or other possibilities.
   *
   * Ideally, it is not considered best practise to attach more than a
   * single DOM-ready or window-load handler for a particular page.
   * Although scripts in the WordPress core, Plugins and Themes may be
   * practising this, we should strive to set a better example in our own work.
   */
})(jQuery);

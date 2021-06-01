<?php
$navigation = "off";
$style_class = flexi_get_param_value("class", $evalue);
if ($style_class == '') {
  $style_class = "display compact responsive nowrap";
}

$title_enable = flexi_get_param_value('title', $evalue);

?>
<style>
  #flexi_tag_filter {
    display: none;
  }
</style>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.24/b-1.7.0/r-2.2.7/sb-1.0.1/sp-1.2.2/datatables.min.css" />

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.24/b-1.7.0/r-2.2.7/sb-1.0.1/sp-1.2.2/datatables.min.js"></script>

<script>
  jQuery(document).ready(function() {
    jQuery('#table_id').DataTable({
      "paging": <?php echo flexi_get_param_value("paging", $evalue) == "false" ? 'false' : 'true'; ?>,
      "ordering": <?php echo flexi_get_param_value("ordering", $evalue) == "false" ? 'false' : 'true'; ?>,
      "info": <?php echo flexi_get_param_value("info", $evalue) == "false" ? 'false' : 'true'; ?>,
      "filter": <?php echo flexi_get_param_value("filter", $evalue) == "false" ? 'false' : 'true'; ?>,
      responsive: {
        details: true
      },
    });
  });
</script>

<table id="table_id" class="<?php echo $style_class; ?>" style="width:100%">
  <thead>
    <tr>
      <?php
      if ($title_enable == "on") {
        echo '<th>' . __('Title', 'flexi') . '</th>';
      }
      ?>

      <?php
      //Custom Fields
      $count = 20;
      $c = 1;
      if (flexi_evalue_toggle('custom', $evalue) == '') {
        for ($x = 1; $x <= 10; $x++) {
          $label   = flexi_get_option('flexi_field_' . $x . '_label', 'flexi_custom_fields', '');
          $display = flexi_get_option('flexi_field_' . $x . '_display', 'flexi_custom_fields', '');
          if (is_array($display)) {
            if (in_array('gallery', $display)) {
              echo '<th>' . $label . '</th>';

              if ($count == $c) {
                break;
              }
              $c++;
            }
          }
        }
      }
      ?>
      <?php
      //Label from custom php_field parameter
      //0=function, 1-parameter1 (label), 2-parameter2 3-parameter3, 4-parameter4
      $label = flexi_php_field_value($php_field, 1);
      for ($x = 0; $x < count($label); $x++) {
        echo '<th>' . $label[$x] . '</th>';
      }
      ?>

    </tr>
  </thead>
  <tbody>
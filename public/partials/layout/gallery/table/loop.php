<?php
$data = flexi_image_data('thumbnail', get_the_ID(), $popup);
$style_text_color = flexi_get_option('flexi_style_text_color', 'flexi_app_style_settings', '');
$title_enable = flexi_get_param_value('title', $evalue);
?>

<tr>
    <td>
        <?php
        if ($title_enable == "on") {
        ?>
            <div class="<?php echo $data['popup']; ?>"> <?php echo '<a ' . $data['extra'] . ' href="' . $data['url'] . '" data-caption="' . $data['title'] . '" data-src="' . $data['src'] . '" border="0">'; ?><?php echo $data['title']; ?></a></div>
        <?php
        }
        ?>
    </td>
    <?php
    //Custom Fields
    $count = 20;
    $c = 1;
    if (flexi_evalue_toggle('custom', $evalue) == '') {
        for ($x = 1; $x <= 20; $x++) {
            $label   = flexi_get_option('flexi_field_' . $x . '_label', 'flexi_custom_fields', '');
            $display = flexi_get_option('flexi_field_' . $x . '_display', 'flexi_custom_fields', '');
            $value   = get_post_meta($post->ID, 'flexi_field_' . $x, '');
            if (!$value) {
                $value[0] = '';
            }
            if (is_array($display)) {
                if (in_array('gallery', $display)) {
                    echo ' <td>' . $value[0] . '</td>';

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
    //Custom php_field functions
    //0=label, 1-function_name, 2-parameter1 3-parameter2, 4-parameter3
    $php_func = flexi_php_field_value($php_field, 1);
    $param_1 = flexi_php_field_value($php_field, 2);
    $param_2 = flexi_php_field_value($php_field, 3);
    $param_3 = flexi_php_field_value($php_field, 4);

    for ($x = 0; $x < count($php_func); $x++) {

        if (!isset($param_1[$x]))
            $param_1[$x] = "";

        if (!isset($param_2[$x]))
            $param_2[$x] = "";

        if (!isset($param_3[$x]))
            $param_3[$x] = "";

        echo '<th>' . flexi_php_field_execute($php_func[$x], $param_1[$x], $param_2[$x], $param_3[$x]) . '</th>';
    }

    ?>
</tr>
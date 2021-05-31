<?php
$data = flexi_image_data('thumbnail', get_the_ID(), $popup);
$style_text_color = flexi_get_option('flexi_style_text_color', 'flexi_app_style_settings', '');
?>

<tr>
    <td>
        <div class="<?php echo $data['popup']; ?>"> <?php echo '<a ' . $data['extra'] . ' href="' . $data['url'] . '" data-caption="' . $data['title'] . '" data-src="' . $data['src'] . '" border="0">'; ?><?php echo $data['title']; ?></a></div>
    </td>
    <?php
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
</tr>
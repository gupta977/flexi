<?php
$check_enable_gallery = flexi_get_option('enable_gallery', 'flexi_image_layout_settings', 'everyone');
$enable_gallery_access = true;
$notice = "";
if (empty($params)) {
    if ('everyone' == $check_enable_gallery) {
        $enable_gallery_access = true;
    } else if ('member' == $check_enable_gallery) {
        if (!is_user_logged_in()) {
            $enable_gallery_access = false;
            $notice = flexi_login_link();
            return '';
        }
    } else if ('publish_posts' == $check_enable_gallery) {
        if (!is_user_logged_in()) {
            $enable_gallery_access = false;
            $notice = "<div class='flexi_alert-box flexi_error'>" . __('Disabled', 'flexi') . "</div>";
        } else {
            if (current_user_can('publish_posts')) {
                $notice = "<div class='flexi_alert-box flexi_notice'>" . __('Publicly accessible disabled', 'flexi') . "</div>";
                $enable_gallery_access = true;
            } else {
                $enable_gallery_access = false;
                $notice = "<div class='flexi_alert-box flexi_warning'>" . __('You do not have proper rights', 'flexi') . "</div>";
            }
        }
    } else {
        $enable_gallery_access = false;
        $notice = "<div class='flexi_alert-box flexi_error'>" . __('Disabled', 'flexi') . "</div>";
    }
}
echo $notice;
if ($enable_gallery_access) {
    $detail_layout = get_post_meta($post->ID, 'flexi_layout', 'basic');
    if ('default' == $detail_layout || '' == $detail_layout) {
        $detail_layout = flexi_get_option('detail_layout', 'flexi_detail_settings', 'basic');
    }

    if (empty($detail_layout)) {
        $detail_layout = "basic";
    }

    $file = FLEXI_PLUGIN_DIR . 'public/partials/layout/detail/' . $detail_layout . '/single.php';
    if (file_exists($file)) {
        require $file;
    } else {
        echo "Detail Layout Not found: " . $detail_layout;
    }
} else {
    return '';
}

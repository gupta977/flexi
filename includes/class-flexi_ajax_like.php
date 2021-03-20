<?php
class flexi_like
{
    //Display like button
    public function __construct()
    {
        //  if (flexi_get_option('evalue_like', 'flexi_image_layout_settings', 1) == 1) {
        add_action('wp_enqueue_scripts', array($this, "enqueue_script"));
        add_action("wp_ajax_flexi_ajax_like", array($this, "flexi_ajax_like"));
        add_action("wp_ajax_nopriv_flexi_ajax_like", array($this, "flexi_ajax_like"));
        // add_action('flexi_loop_portfolio', array($this, 'display_like'), 10, 1);
        // }
        // add_action('flexi_module_grid', array($this, 'display_like'));
        add_filter('flexi_settings_fields', array($this, 'add_fields'));
        add_filter('flexi_addon_grid', array($this, 'display_unlike_button'), 10, 3);
        add_filter('flexi_addon_grid', array($this, 'display_like_button'), 10, 3);
    }

    //include js file
    public function enqueue_script()
    {
        //Ajax Delete
        wp_register_script('flexi_ajax_like', FLEXI_PLUGIN_URL . '/public/js/flexi_ajax_like.js', array('jquery'), FLEXI_VERSION);
        wp_enqueue_script('flexi_ajax_like');
    }

    public function flexi_ajax_like()
    {

        if (!wp_verify_nonce($_REQUEST['nonce'], "flexi_ajax_like")) {
            exit("No naughty business please");
        }
        $post_id = $_REQUEST["post_id"];
        $key = $_REQUEST["key_type"];

        flexi_log($key . '---' . $post_id);
        $count = 0;
        if ($key == 'like') {
            $this->increase_like($post_id, 'flexi_like_count');
            $count = $this->get_like_count($post_id, 'flexi_like_count');
        }

        if ($key == 'unlike') {
            $this->increase_like($post_id, 'flexi_unlike_count');
            $count = $this->get_like_count($post_id, 'flexi_unlike_count');
        }

        if (true) {
            $data = true;
        } else {
            $data = false;
        }

        if (false === $data) {
            $result['type']       = "error";
            $result['data_count'] = $count;
        } else {
            $result['type']       = "success";
            $result['data_count'] = $count;
        }

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $result = json_encode($result);
            echo $result;
        } else {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }

        die();
    }

    public function display_like_button($container, $evalue = '', $id = '')
    {

        $enable = flexi_get_option('evalue_like', 'flexi_image_layout_settings', 1);

        //If page is detail page
        if ($evalue == '') {
            $evalue .= "like:on";
        }

        $toggle = flexi_evalue_toggle('like', $evalue);
        //flexi_log($toggle);

        if (($enable == 1)) {
            $extra_icon = array();
            $nonce   = wp_create_nonce("flexi_ajax_like");
            $div = '<div id="flexi_like" data-key_type="like" data-nonce="' . $nonce . '" data-post_id="' . $id . '" style="' . flexi_evalue_toggle('like', $evalue) . '" class="fl-button fl-is-small">
        <span class="fl-icon fl-is-small"><i class="fas fa-thumbs-up"></i></span>
        <span id="flexi_like_count_' . $id . '">' . $this->get_like_count($id, 'flexi_like_count') . '</span></div>';
            $extra_icon = array(
                array('field has-addons', $div),

            );

            // combine the two arrays
            if (is_array($extra_icon) && is_array($container)) {
                $container = array_merge($extra_icon, $container);
            }
        }

        return $container;
    }

    public function display_unlike_button($container, $evalue = '', $id = '')
    {
        $enable = flexi_get_option('evalue_unlike', 'flexi_image_layout_settings', 1);

        //If page is detail page
        if ($evalue == '') {
            $evalue .= "unlike:on";
        }

        $toggle = flexi_evalue_toggle('unlike', $evalue);
        //flexi_log($toggle);

        if (($enable == 1)) {
            $extra_icon = array();
            $nonce   = wp_create_nonce("flexi_ajax_like");
            $div = '<div id="flexi_like" data-key_type="unlike" data-nonce="' . $nonce . '" data-post_id="' . $id . '" style="' . flexi_evalue_toggle('unlike', $evalue) . '" class="fl-button fl-is-small">
        <span class="fl-icon fl-is-small"><i class="fas fa-thumbs-down"></i></span>
        <span id="flexi_unlike_count_' . $id . '">' . $this->get_like_count($id, 'flexi_unlike_count') . '</span></div>';
            $extra_icon = array(
                array('field has-addons', $div),

            );

            // combine the two arrays
            if (is_array($extra_icon) && is_array($container)) {
                $container = array_merge($extra_icon, $container);
            }
        }

        return $container;
    }


    //Total number of like & unlike
    public function get_like_count($id, $key)
    {
        $count = get_post_meta($id, $key, true);
        return $count;
    }

    //Increase like
    public function increase_like($post_id, $key)
    {

        $count = (int) get_post_meta($post_id, $key, true);
        $count++;
        update_post_meta($post_id, $key, $count);
    }

    //Decrease likes
    public function decrease_like($post_id, $key)
    {

        $count = (int) get_post_meta($post_id, $key, true);
        $count--;
        update_post_meta($post_id, $key, $count);
    }


    //enable/disable option at Gallery -> Gallery Settings
    public function add_fields($new)
    {

        $fields = array('flexi_image_layout_settings' => array(

            array(
                'name'              => 'evalue_like',
                'label'             => __('Display like', 'flexi') . ' (evalue)',
                'description'       => __('Let user to like the post.', 'flexi'),
                'type'              => 'checkbox',
                'sanitize_callback' => 'intval',
            ),
            array(
                'name'              => 'evalue_unlike',
                'label'             => __('Display un-like', 'flexi') . ' (evalue)',
                'description'       => __('Let user to un-like the post.', 'flexi'),
                'type'              => 'checkbox',
                'sanitize_callback' => 'intval',
            ),
        ),);
        $new = array_merge_recursive($new, $fields);

        return $new;
    }
}

$flexi_like = new flexi_like();

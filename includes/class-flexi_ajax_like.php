<?php
class flexi_like
{
    //Display like button
    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, "enqueue_script"));
        add_action("wp_ajax_flexi_ajax_like", array($this, "flexi_ajax_like"));
        add_action("wp_ajax_nopriv_flexi_ajax_like", array($this, "flexi_ajax_like"));
        add_action('flexi_loop_portfolio', array($this, 'display_like'), 10, 1);
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

    public function display_like($evalue)
    {
        $nonce   = wp_create_nonce("flexi_ajax_like");
        $id = get_the_ID();
?>

        <div style=" <?php echo flexi_evalue_toggle('like', $evalue); ?>" class="fl-button fl-is-small">
            <span id="flexi_like" data-key_type="like" data-nonce="<?php echo $nonce; ?>" data-post_id="<?php echo $id; ?>" class="fl-icon fl-is-small">
                <i class="fas fa-thumbs-up"></i>
            </span>
            <span id="flexi_like_count_<?php echo $id; ?>"><?php echo $this->get_like_count($id, 'flexi_like_count'); ?></span>
        </div>

        <div style="<?php echo flexi_evalue_toggle('unlike', $evalue); ?>" class="fl-button fl-is-small">
            <span id="flexi_like" data-key_type="unlike" data-nonce="<?php echo $nonce; ?>" data-post_id="<?php echo $id; ?>" class="fl-icon fl-is-small">
                <i class="fas fa-thumbs-down"></i>
            </span>
            <span id="flexi_unlike_count_<?php echo $id; ?>"><?php echo $this->get_like_count($id, 'flexi_unlike_count'); ?></span>
        </div>


<?php
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
}

$flexi_like = new flexi_like();

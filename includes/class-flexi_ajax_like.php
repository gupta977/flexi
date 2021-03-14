<?php
class flexi_like
{
    //Display like button
    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, "enqueue_script"));
        add_action("wp_ajax_flexi_ajax_like", array($this, "flexi_ajax_like"));
        add_action("wp_ajax_nopriv_flexi_ajax_like", array($this, "flexi_ajax_like"));
        //add_action('flexi_loop_portfolio', array($this, 'display_like'));
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

        if (!wp_verify_nonce($_REQUEST['nonce'], "flexi_ajax_delete")) {
            exit("No naughty business please");
        }
        $post_id = $_REQUEST["post_id"];
    }

    public function display_like()
    {
?>
        <span class="fl-icon-text fl-tag">
            <span id="abc" class="fl-icon">
                <i class="fas fa-thumbs-up"></i>
            </span>
            <span><?php echo get_the_ID(); ?></span>
        </span>
        <span class="fl-icon-text fl-tag">
            <span id="abc" class="fl-icon">
                <i class="fas fa-thumbs-down"></i>
            </span>
            <span><?php echo get_the_ID(); ?></span>
        </span>

<?php
    }
}

$flexi_like = new flexi_like();

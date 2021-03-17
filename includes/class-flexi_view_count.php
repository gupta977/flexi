<?php
class flexi_view_count
{
    //Display like button
    public function __construct()
    {
        if (flexi_get_option('evalue_count', 'flexi_image_layout_settings', 1) == 1) {
            add_action('flexi_loop_portfolio', array($this, 'display_view_count'), 10, 1);
        }
        add_action('flexi_module_grid', array($this, 'display_view_count'));
        add_filter('flexi_settings_fields', array($this, 'add_fields'));
    }

    public function display_view_count($evalue)
    {
        if ($evalue == null) {
            $evalue = 'count:on';
        }
        $id = get_the_ID();
        //Increase count is each load
        $this->increase_count($id, 'flexi_view_count');
?>
        <div style="<?php echo flexi_evalue_toggle('count', $evalue); ?>" class="fl-button fl-is-small fl-is-static">
            <span id="flexi_count" class="fl-icon fl-is-small">
                <i class="far fa-eye"></i>
            </span>
            <span><?php echo $this->get_view_count($id, 'flexi_view_count'); ?></span>
        </div>


<?php
    }
    //Total number of like & unlike
    public function get_view_count($id, $key)
    {
        $count = get_post_meta($id, $key, true);
        return $count;
    }

    //Increase like
    public function increase_count($post_id, $key)
    {

        $count = (int) get_post_meta($post_id, $key, true);
        $count++;
        update_post_meta($post_id, $key, $count);
    }

    //enable/disable option at Gallery -> Gallery Settings
    public function add_fields($new)
    {

        $fields = array('flexi_image_layout_settings' => array(

            array(
                'name'              => 'evalue_count',
                'label'             => __('Display view count', 'flexi') . ' (evalue)',
                'description'       => __('Counts number of page viewed. Counts only those where count view is shown.', 'flexi'),
                'type'              => 'checkbox',
                'sanitize_callback' => 'intval',
            ),
        ),);
        $new = array_merge_recursive($new, $fields);

        return $new;
    }
}

$flexi_view_count = new flexi_view_count();

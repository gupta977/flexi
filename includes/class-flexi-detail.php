<?php
class Flexi_Public_Detail
{
    private $help = ' <a style="text-decoration: none;" href="https://odude.com/docs/flexi-gallery/information/detail-layout/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a>';

    public function __construct()
    {
        add_filter('flexi_settings_fields', array($this, 'add_fields'));
        //
    }

    /**
     * Filter the post content.
     *
     * @since  1.0.0
     * @param  string $content Content of the current post.
     * @return string $content Modified Content.
     */
    public function the_content($content)
    {
        if (is_singular('flexi') && in_the_loop() && is_main_query()) {
            global $post;

            /*
   if (is_user_logged_in()) {
   $content = __('Sorry, this content is reserved for members only.', 'text-domain');
   }
    */
            // Process output
            ob_start();

            require apply_filters('flexi_load_template', FLEXI_PLUGIN_DIR . 'public/partials/layout/detail/attach.php');

            $content = ob_get_clean();
        }

        return $content;
    }

    //Add section fields at Flexi Setting > Icons & user access settings
    public function add_fields($new)
    {

        $fields = array(
            'flexi_icon_settings' => array(

                array(
                    'name'              => 'detail_flexi_icon',
                    'label'             => __('Detail view button', 'flexi') . ' <span class="dashicons dashicons-external"></span>',
                    'description'       => __('Detail icon at gallery lightbox', 'flexi') . ' ' . $this->help,
                    'type'              => 'checkbox',
                    'sanitize_callback' => 'intval',
                ),
            ),
        );
        $new = array_merge_recursive($new, $fields);

        return $new;
    }

    //Add icons at user grid
    public function add_icon($icon, $post = null)
    {
        if (null == $post) {
            global $post;
        }
        $link              = get_permalink();
        $extra_icon        = array();
        $detail_flexi_icon = flexi_get_option('detail_flexi_icon', 'flexi_icon_settings', 1);

        if ("1" == $detail_flexi_icon && !is_singular('flexi')) {
            $extra_icon = array(
                array("fas fa-external-link-alt", __('Detail', 'flexi'), $link, '#', $post->ID, 'fl-button fl-is-small flexi_css_button'),

            );
        }

        // combine the two arrays
        if (is_array($extra_icon) && is_array($icon)) {
            $icon = array_merge($extra_icon, $icon);
        }

        return $icon;
    }
}

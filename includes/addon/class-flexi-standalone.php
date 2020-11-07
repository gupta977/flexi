<?php
class Flexi_Addon_Standalone
{
    public function __construct()
    {

        add_filter('flexi_settings_sections', array($this, 'add_section'));
        add_filter('flexi_settings_fields', array($this, 'add_fields'));
        add_filter('flexi_settings_fields', array($this, 'add_extension'));
        add_filter("flexi_submit_toolbar", array($this, 'flexi_add_icon_submit_toolbar'), 10, 2);
    }

    //add_filter flexi_settings_tabs
    public function add_tabs($new)
    {
        $tabs = array();
        $new  = array_merge($tabs, $new);
        return $new;
    }

    //Add Section title
    public function add_section($new)
    {
        $enable_addon = flexi_get_option('enable_standalone', 'flexi_extension', 0);
        if ("1" == $enable_addon) {
            $sections = array(
                array(
                    'id'          => 'flexi_standalone_settings',
                    'title'       => __('Sub-Gallery', 'flexi'),
                    'description' => __('You can have sub-gallery of primary post. It will not display in main gallery.', 'flexi'),
                    'tab'         => 'gallery',
                ),
            );
            $new = array_merge($new, $sections);
        }
        return $new;
    }

    //Add enable/disable option at extension tab
    public function add_extension($new)
    {

        $fields = array('flexi_extension' => array(
            array(
                'name'              => 'enable_standalone',
                'label'             => __('Enable Sub-Gallery', 'flexi'),
                'description'       => __('Enable standalone sub-gallery of primary image or post.', 'flexi') . '<a style="text-decoration: none;" href="' . admin_url('admin.php?page=flexi_settings&tab=gallery&section=flexi_standalone_settings') . '"><span class="dashicons dashicons-admin-tools"></span></a>',
                'type'              => 'checkbox',
                'sanitize_callback' => 'intval',

            ),
        ),);

        $new = array_merge_recursive($new, $fields);
        return $new;
    }

    //Add section fields
    public function add_fields($new)
    {
        $enable_addon = flexi_get_option('enable_standalone', 'flexi_extension', 0);
        if ("1" == $enable_addon) {
            $fields = array('flexi_standalone_settings' => array(

                array(
                    'name'              => 'enable_standalone_button',
                    'label'             => __('"Add Sub-Gallery" button', 'flexi'),
                    'description'       => __('Display button after form submission and in manage media page.', 'flexi'),
                    'type'              => 'checkbox',
                    'sanitize_callback' => 'intval',
                ),
                array(
                    'name'              => 'standalone_button_label',
                    'label'             => __('Button Label', 'flexi'),
                    'description'       => __('Label of Sub-Gallery button. Eg. Add Sub-Gallery', 'flexi'),
                    'type'              => 'text',
                    'size'              => 'medium',
                    'sanitize_callback' => '',
                ),
                array(
                    'name'              => 'edit_standalone_page',
                    'label'             => __('Sub-Gallery form', 'flexi'),
                    'description'       => __('Page should contain shortcode [flexi-common-toolbar] [flexi-standalone edit="true"]', 'flexi'),
                    'type'              => 'pages',
                    'sanitize_callback' => 'sanitize_key',
                ),

            ),);
            $new = array_merge($new, $fields);
        }
        return $new;
    }

    //Add Sub-Gallery button after form submit
    public function flexi_add_icon_submit_toolbar($icon, $id = '')
    {

        $extra_icon = array();

        $enable_addon = flexi_get_option('enable_standalone_button', 'flexi_standalone_settings', 1);

        $link = flexi_get_button_url($id, false, 'edit_standalone_page', 'flexi_standalone_settings');

        if ("#" != $link && "1" == $enable_addon) {

            $link = add_query_arg("manage", "standalone", $link);
            $link = add_query_arg("id", $id, $link);
            $button_label = flexi_get_option('standalone_button_label', 'flexi_standalone_settings', "Add Sub-Gallery");
            $extra_icon = array(
                array("gallery", $button_label, $link, $id, 'flexi_css_button'),

            );
        }

        // combine the two arrays
        if (is_array($extra_icon) && is_array($icon)) {
            $icon = array_merge($extra_icon, $icon);
        }

        return $icon;
    }
}

//Ultimate Member: Setting at Flexi & Tab at profile page
$standalone = new Flexi_Addon_standalone();

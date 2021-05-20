<?php
class Flexi_Addon_Appearance_Style
{
    private $help = ' <a style="text-decoration: none;" href="https://odude.com/docs/flexi-gallery/tutorial/shortcode-holder/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a>';


    public function __construct()
    {

        add_filter('flexi_settings_sections', array($this, 'add_section'));
        add_filter('flexi_settings_fields', array($this, 'add_fields'));
        add_filter('flexi_settings_fields', array($this, 'add_extension'));
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
        $enable_addon = flexi_get_option('enable_app_style', 'flexi_extension', 0);
        if ("1" == $enable_addon) {
            $sections = array(
                array(
                    'id'          => 'flexi_app_style_settings',
                    'title'       => __('Appearance CSS Style', 'flexi'),
                    'description' => __('Change colors, fonts of flexi elements using your own css style classes.', 'flexi') . ' ' . $this->help,
                    'tab'         => 'general',
                ),
            );
            $new = array_merge($new, $sections);
        }
        return $new;
    }

    //Add enable/disable option at extension tab
    public function add_extension($new)
    {


        $enable_addon = flexi_get_option('enable_app_style', 'flexi_extension', 0);
        if ("1" == $enable_addon) {

            $description = ' <a style="text-decoration: none;" href="' . admin_url('admin.php?page=flexi_settings&tab=general&section=flexi_app_style_settings') . '"><span class="dashicons dashicons-admin-tools"></span></a>';
        } else {
            $description = '';
        }


        $fields = array(
            'flexi_extension' => array(
                array(
                    'name'              => 'enable_app_style',
                    'label'             => __('Appearance with CSS', 'flexi'),
                    'description'       => __('Change look & feel of own Flexi elements using own css rules.', 'flexi') . ' ' . $this->help . ' ' . $description,
                    'type'              => 'checkbox',
                    'sanitize_callback' => 'intval',

                ),
            ),
        );

        $new = array_merge_recursive($new, $fields);
        return $new;
    }

    //Add section fields
    public function add_fields($new)
    {
        $enable_addon = flexi_get_option('enable_app_style', 'flexi_extension', 0);
        if ("1" == $enable_addon) {
            $fields = array(
                'flexi_app_style_settings' => array(

                    array(
                        'name'        => 'flexi_style_heading',
                        'type'        => 'text',
                        'label'       => __('Title Heading', 'flexi'),
                        'description' => __('fl-is-4 fl-mb-1 fl-has-text-success', 'flexi'),
                    ),
                    array(
                        'name'        => 'flexi_style_tag',
                        'type'        => 'text',
                        'label'       => __('Gallery filter tag style', 'flexi'),
                        'description' => __('fl-is-medium', 'flexi'),
                    ),

                    array(
                        'name'        => 'flexi_style_icon_grid',
                        'type'        => 'text',
                        'label'       => __('Icon grid buttons', 'flexi'),
                        'description' => __('fl-is-small flexi_css_button', 'flexi'),
                    ),

                    array(
                        'name'        => 'flexi_style_common_toolbar',
                        'type'        => 'text',
                        'label'       => __('Common toolbar buttons', 'flexi'),
                        'description' => __('fl-is-light', 'flexi'),
                    ),

                ),
            );
            $new = array_merge($new, $fields);
        }
        return $new;
    }
}

//Ultimate Member: Setting at Flexi & Tab at profile page
$appstyle = new Flexi_Addon_Appearance_Style();

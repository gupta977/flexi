<?php
class Flexi_Addon_Appearance_Style
{
    private $help = ' <a style="text-decoration: none;" href="https://odude.com/docs/flexi-gallery/tutorial/shortcode-holder/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a>';


    public function __construct()
    {

        add_filter('flexi_settings_sections', array($this, 'add_section'));
        add_filter('flexi_settings_fields', array($this, 'add_fields'));
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

    //Add section fields
    public function add_fields($new)
    {

        $fields = array(
            'flexi_app_style_settings' => array(
                array(
                    'name'              => 'flexi_style_text_color',
                    'label'             => __('Text color', 'flexi'),
                    'description'       => __('Applied on text only', 'flexi'),
                    'type'              => 'select',
                    'options'           => array(
                        'fl-has-text-white'      => __('White', 'flexi'),
                        'fl-has-text-black'        => __('Black', 'flexi'),
                        'fl-has-text-danger' => __('Red', 'flexi'),
                        'fl-has-text-success'  => __('Green', 'flexi'),
                    ),
                    'sanitize_callback' => 'sanitize_key',
                ),
                array(
                    'name'              => 'flexi_style_base_color',
                    'label'             => __('Base color', 'flexi'),
                    'description'       => __('Applied on containers.', 'flexi'),
                    'type'              => 'select',
                    'options'           => array(
                        'fl-has-background-white'      => __('White', 'flexi'),
                        'fl-has-background-black'        => __('Black', 'flexi'),
                        'fl-has-background-danger' => __('Red', 'flexi'),
                        'fl-has-background-success'  => __('Green', 'flexi'),
                    ),
                    'sanitize_callback' => 'sanitize_key',
                ),

                array(
                    'name'        => 'flexi_style_heading',
                    'type'        => 'text',
                    'label'       => __('Gallery title heading', 'flexi'),
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

        return $new;
    }
}

//Ultimate Member: Setting at Flexi & Tab at profile page
$appstyle = new Flexi_Addon_Appearance_Style();

<?php
class Flexi_Addon_Custom_Fields
{
    private $help = ' <a style="text-decoration: none;" href="https://odude.com/docs/flexi-gallery/tutorial/custom-field/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a>';
    public function __construct()
    {

        add_filter('flexi_settings_sections', array($this, 'add_section'));
        add_filter('flexi_settings_fields', array($this, 'add_extension'));
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
        $enable_addon = flexi_get_option('enable_custom_fields', 'flexi_extension', 0);
        if ("1" == $enable_addon) {
            $sections = array(
                array(
                    'id'          => 'flexi_custom_fields',
                    'title'       => __('Flexi Custom Fields', 'flexi'),
                    'description' => __('These are the reserved input field name assigned at submission form with [flexi-form-tag name="....."] shortcode. Custom fields display is based on layouts used. It will not work for all layouts.', 'flexi') . ' ' . $this->help,
                    'tab'         => 'form',
                ),
            );
            $new = array_merge($new, $sections);
        }
        return $new;
    }

    //Add enable/disable option at extension tab
    public function add_extension($new)
    {


        $enable_addon = flexi_get_option('enable_custom_fields', 'flexi_extension', 0);
        if ("1" == $enable_addon) {

            $description = ' <a style="text-decoration: none;" href="' . admin_url('admin.php?page=flexi_settings&tab=form&section=flexi_custom_fields') . '"><span class="dashicons dashicons-admin-tools"></span></a>';
        } else {
            $description = '';
        }
        $fields = array('flexi_extension' => array(
            array(
                'name'              => 'enable_custom_fields',
                'label'             => __('Enable Flexi Custom Fields', 'flexi'),
                'description'       => __('Manage Flexi custom fields at gallery & detail page.', 'flexi') . ' ' . $this->help . ' ' . $description,
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

        $enable_addon = flexi_get_option('enable_custom_fields', 'flexi_extension', 0);
        if ("1" == $enable_addon) {
            $fields = array('flexi_custom_fields' => array(

                array(
                    'name'              => 'flexi_field_1_label',
                    'label'             => __('Label: flexi_field_1', 'flexi'),
                    'description'       => __('Enter the label name to be displayed at frontend along with submitted value.', 'flexi'),
                    'type'              => 'text',
                    'size'              => 'medium',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                array(
                    'name'        => 'flexi_field_1_display',
                    'label'       => '',
                    'description' => '',
                    'type'        => 'multicheck',
                    'options'     => array(
                        'gallery' => __('Display at Gallery Page', 'flexi'),
                        'detail'  => __('Display at Detail Page', 'flexi'),
                        'popup'   => __('Display at Popup', 'flexi'),
                    ),
                ),
            ),);

            $count = 3;
            if (is_flexi_pro()) {
                $count = 20;
            }

            for ($x = 1; $x <= $count; $x++) {
                $fields_add = array('flexi_custom_fields' => array(

                    array(
                        'name'              => 'flexi_field_' . $x . '_label',
                        'label'             => __('Label: flexi_field_' . $x, 'flexi'),
                        'description'       => __('Enter the label name to be displayed at frontend along with submitted value.', 'flexi'),
                        'type'              => 'text',
                        'size'              => 'medium',
                        'sanitize_callback' => 'sanitize_text_field',
                    ),
                    array(
                        'name'        => 'flexi_field_' . $x . '_display',
                        'label'       => '',
                        'description' => '',
                        'type'        => 'multicheck',
                        'options'     => array(
                            'gallery' => __('Display at Gallery Page', 'flexi'),
                            'detail'  => __('Display at Detail Page', 'flexi'),
                            'popup'   => __('Display at Popup', 'flexi'),
                        ),
                    ),
                ),);
                $fields = array_merge_recursive($fields, $fields_add);
            }

            //print_r($fields);
            $new = array_merge($new, $fields);
        }
        return $new;
    }
}

//Ultimate Member: Setting at Flexi & Tab at profile page
$captcha = new Flexi_Addon_Custom_Fields();

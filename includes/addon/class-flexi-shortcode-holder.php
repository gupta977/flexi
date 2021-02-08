<?php
class Flexi_Addon_Shortcode_Holder
{
    private $help = ' <a style="text-decoration: none;" href="https://odude.com/docs/flexi-gallery/tutorial/shortcode-holder/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a>';


    public function __construct()
    {

        add_filter('flexi_settings_sections', array($this, 'add_section'));
        add_filter('flexi_settings_fields', array($this, 'add_fields'));
        add_filter('flexi_settings_fields', array($this, 'add_extension'));
        add_filter('flexi_add_element', array($this, 'add_location_element'));
        add_action('flexi_execute_element', array($this, 'flexi_execute_element_callback'), 10, 2);
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
        $enable_addon = flexi_get_option('enable_shortcode_holder', 'flexi_extension', 0);
        if ("1" == $enable_addon) {
            $sections = array(
                array(
                    'id'          => 'flexi_shortcode_holder_settings',
                    'title'       => __('Shortcode Holder', 'flexi'),
                    'description' => __('Display other plugins shortcode or text at detail page & popup page. Specify shortcode display location at layout settings. Useful shortcode could be share button, contact button, banner and so on.', 'flexi') . ' ' . $this->help,
                    'tab'         => 'detail',
                ),
            );
            $new = array_merge($new, $sections);
        }
        return $new;
    }

    //Add enable/disable option at extension tab
    public function add_extension($new)
    {


        $enable_addon = flexi_get_option('enable_shortcode_holder', 'flexi_extension', 0);
        if ("1" == $enable_addon) {

            $description = ' <a style="text-decoration: none;" href="' . admin_url('admin.php?page=flexi_settings&tab=detail&section=flexi_shortcode_holder_settings') . '"><span class="dashicons dashicons-admin-tools"></span></a>';
        } else {
            $description = '';
        }


        $fields = array(
            'flexi_extension' => array(
                array(
                    'name'              => 'enable_shortcode_holder',
                    'label'             => __('Enable Shortcode Holder', 'flexi'),
                    'description'       => __('External plugin shortcode or text to display at detail & popup page. ', 'flexi') . ' ' . $this->help . ' ' . $description,
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
        $enable_addon = flexi_get_option('enable_shortcode_holder', 'flexi_extension', 0);
        if ("1" == $enable_addon) {
            $fields = array(
                'flexi_shortcode_holder_settings' => array(


                    array(
                        'name'        => 'flexi_shortcode_1',
                        'type'        => 'textarea',
                        'label'       => __('1st Shortcode/text', 'flexi'),
                        'description' => __('Insert no.1 shortcode', 'flexi'),
                    ),
                    array(
                        'name'        => 'flexi_shortcode_2',
                        'type'        => 'textarea',
                        'label'       => __('2nd Shortcode/text', 'flexi'),
                        'description' => __('Insert no.2 shortcode', 'flexi'),
                    ),

                    array(
                        'name'        => 'flexi_shortcode_3',
                        'type'        => 'textarea',
                        'label'       => __('3rd Shortcode/text', 'flexi'),
                        'description' => __('Insert no.3 shortcode', 'flexi'),
                    ),

                    array(
                        'name'        => 'flexi_shortcode_4',
                        'type'        => 'textarea',
                        'label'       => __('4th Shortcode/text', 'flexi'),
                        'description' => __('Insert no.4 shortcode', 'flexi'),
                    ),


                ),
            );
            $new = array_merge($new, $fields);
        }
        return $new;
    }

    //Add location in layout as element
    public function add_location_element($labels)
    {
        $extra_labels = array(
            "1st shortcode" => "flexi_shortcode_1",
            "2nd shortcode" => "flexi_shortcode_2",
            "3rd shortcode" => "flexi_shortcode_3",
            "4th shortcode" => "flexi_shortcode_4",

        );

        // combine the two arrays
        $labels = array_merge_recursive($labels, $extra_labels);

        return $labels;
    }

    //Display into detail or popup page based on do_action
    public function flexi_execute_element_callback($value)
    {

        $enable_addon = flexi_get_option('enable_shortcode_holder', 'flexi_extension', 0);
        if ("1" == $enable_addon) {
            if ('flexi_shortcode_1' == $value) {
                $get_shortcode = flexi_get_option('flexi_shortcode_1', 'flexi_shortcode_holder_settings', '');
                echo do_shortcode($get_shortcode);
            } else if ('flexi_shortcode_2' == $value) {
                $get_shortcode = flexi_get_option('flexi_shortcode_2', 'flexi_shortcode_holder_settings', '');
                echo do_shortcode($get_shortcode);
            } else if ('flexi_shortcode_3' == $value) {
                $get_shortcode = flexi_get_option('flexi_shortcode_3', 'flexi_shortcode_holder_settings', '');
                echo do_shortcode($get_shortcode);
            } else if ('flexi_shortcode_4' == $value) {
                $get_shortcode = flexi_get_option('flexi_shortcode_4', 'flexi_shortcode_holder_settings', '');
                echo do_shortcode($get_shortcode);
            } else {
                echo '';
            }
        }
    }
}

//Ultimate Member: Setting at Flexi & Tab at profile page
$buddypress = new Flexi_Addon_Shortcode_Holder();

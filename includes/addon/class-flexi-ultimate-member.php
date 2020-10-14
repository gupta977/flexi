<?php
class Flexi_Addon_Ultimate_Member
{
    public function __construct()
    {

        add_filter('flexi_settings_sections', array($this, 'add_section'));
        add_filter('flexi_settings_fields', array($this, 'add_extension'));
        add_filter('flexi_settings_fields', array($this, 'add_fields'));
        add_filter('um_profile_tabs', array($this, 'add_profile_tab'), 1000);
        add_action('um_profile_content_flexi_default', array($this, 'um_profile_content_flexi_default'));
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
        $enable_addon = flexi_get_option('enable_ultimate_member', 'flexi_extension', 0);
        if ("1" == $enable_addon) {
            $sections = array(
                array(
                    'id'          => 'flexi_ultimate_member_settings',
                    'title'       => __('Ultimate-Member', 'flexi'),
                    'description' => __('If you have installed Ultimate-Member plugin, user can see own submitted images at their profile page. If tab is not visible, deactivate ultimate-member plugin and activate again to implement new settings. https://wordpress.org/plugins/ultimate-member/', 'flexi'),
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
                'name'              => 'enable_ultimate_member',
                'label'             => __('Enable Ultimate Member', 'flexi'),
                'description'       => __('Displays tab on user profile page of Ultimate Member plugin.', 'flexi') . ' https://wordpress.org/plugins/ultimate-member/ <a style="text-decoration: none;" href="' . admin_url('admin.php?page=flexi_settings&tab=gallery&section=flexi_ultimate_member_settings') . '"><span class="dashicons dashicons-admin-tools"></span></a>',
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
        $enable_addon = flexi_get_option('enable_ultimate_member', 'flexi_extension', 0);
        if ("1" == $enable_addon) {
            $fields = array('flexi_ultimate_member_settings' => array(

                array(
                    'name'              => 'ultimate_member_tab_name',
                    'label'             => __('Tab name', 'flexi'),
                    'description'       => __('Name of the tab displays on profile page', 'flexi'),
                    'type'              => 'text',
                    'size'              => 'medium',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                array(
                    'name'              => 'ultimate_member_tab_icon',
                    'label'             => __('Tab icon', 'flexi'),
                    'description'       => __('Ultimate Member\'s icons to be used at profile page. Eg. um-faicon-picture-o', 'flexi'),
                    'type'              => 'text',
                    'size'              => 'medium',
                    'sanitize_callback' => 'sanitize_key',
                ),
            ),);
            $new = array_merge($new, $fields);
        }
        return $new;
    }

    public function add_profile_tab($tabs)
    {

        $enable_addon = flexi_get_option('enable_ultimate_member', 'flexi_extension', 0);
        if ("1" == $enable_addon) {

            $tabs['flexi'] = array(
                'name'   => flexi_get_option('ultimate_member_tab_name', 'flexi_ultimate_member_settings', 'Gallery'),
                'icon'   => flexi_get_option('ultimate_member_tab_icon', 'flexi_ultimate_member_settings', 'um-faicon-picture-o'),
                'custom' => true,
            );
        }

        return $tabs;
    }

    /* Then we just have to add content to that tab using this action */

    public function um_profile_content_flexi_default($args)
    {
        $user_info = get_userdata(um_profile_id());
        echo do_shortcode('[flexi-gallery user="' . $user_info->user_login . '" ] ');
    }
}

//Ultimate Member: Setting at Flexi & Tab at profile page
$ultimate_member = new Flexi_Addon_Ultimate_Member();

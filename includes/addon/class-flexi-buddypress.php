<?php
class Flexi_Addon_BuddyPress
{
    private $help = ' <a style="text-decoration: none;" href="https://odude.com/docs/flexi-gallery/tutorial/buddypress-user-gallery/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a>';


    public function __construct()
    {

        add_filter('flexi_settings_sections', array($this, 'add_section'));
        add_filter('flexi_settings_fields', array($this, 'add_fields'));
        add_action('bp_setup_nav', array($this, 'add_flexi_buddypress_tab'));
        add_action('flexi_submit_complete', array($this, 'add_into_activity'), 10, 1);
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
        $enable_addon = flexi_get_option('enable_buddypress', 'flexi_extension', 0);
        if ("1" == $enable_addon) {
            $sections = array(
                array(
                    'id'          => 'flexi_buddypress_settings',
                    'title'       => __('BuddyPress', 'flexi'),
                    'description' => __('If you have installed BuddyPress plugin, user can see own submitted images at their profile page. https://wordpress.org/plugins/buddypress/', 'flexi') . ' ' . $this->help,
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

        $enable_addon = flexi_get_option('enable_buddypress', 'flexi_extension', 0);
        if ("1" == $enable_addon) {

            $description = ' <a style="text-decoration: none;" href="' . admin_url('admin.php?page=flexi_settings&tab=gallery&section=flexi_buddypress_settings') . '"><span class="dashicons dashicons-admin-tools"></span></a>';
        } else {
            $description = '';
        }

        $fields = array(
            'flexi_extension' => array(
                array(
                    'name'              => 'enable_buddypress',
                    'label'             => __('Enable BuddyPress', 'flexi'),
                    'description'       => __('Displays tab on user profile page of BuddyPress members page.', 'flexi') . ' ' . $this->help . ' ' . $description,
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
        $enable_addon = flexi_get_option('enable_buddypress', 'flexi_extension', 0);
        if ("1" == $enable_addon) {
            $fields = array(
                'flexi_buddypress_settings' => array(

                    array(
                        'name'              => 'buddypress_tab_name',
                        'label'             => __('Tab name', 'flexi'),
                        'description'       => __('Name of the tab displays on profile page', 'flexi'),
                        'type'              => 'text',
                        'size'              => 'medium',
                        'sanitize_callback' => 'sanitize_text_field',
                    ),
                    array(
                        'name'              => 'enable_buddypress_activity',
                        'label'             => __('Enable BuddyPress Activity', 'flexi'),
                        'description'       => __('Displays activity when any flexi post is posted.', 'flexi'),
                        'type'              => 'checkbox',
                        'sanitize_callback' => 'intval',

                    ),

                ),
            );
            $new = array_merge($new, $fields);
        }
        return $new;
    }
    public function add_flexi_buddypress_tab($tabs)
    {
        $enable_addon = flexi_get_option('enable_buddypress', 'flexi_extension', 0);
        if ("1" == $enable_addon) {
            global $bp;

            $yourtab = flexi_get_option('buddypress_tab_name', 'flexi_buddypress_settings', 'Gallery');

            bp_core_new_nav_item(array(
                'name'                => $yourtab,
                'slug'                => 'flexi',
                'screen_function'     => array($this, 'flexi_buddypress_yourtab_screen'),
                'position'            => 40,
                'parent_url'          => $bp->displayed_user->domain,
                'parent_slug'         => $bp->profile->slug,
                'default_subnav_slug' => 'flexi',
            ));
        }
    }

    public function flexi_buddypress_yourtab_screen()
    {

        // Add title and content here - last is to call the members plugin.php template.

        add_action('bp_template_title', array($this, 'flexi_buddypress_yourtab_title'));
        add_action('bp_template_content', array($this, 'flexi_buddypress_yourtab_content'));
        bp_core_load_template('buddypress/members/single/plugins');
    }
    public function flexi_buddypress_yourtab_title()
    {

        //echo flexi_get_option('buddypress_tab_name', 'flexi_buddypress_settings', 'Gallery');

    }

    public function flexi_buddypress_yourtab_content()
    {

        $user_info = bp_get_displayed_user_username();
        echo do_shortcode('[flexi-gallery user="' . $user_info . '" ] ');
    }

    //Add it into buddypress activity
    public function add_into_activity($post_id)
    {
        $enable_addon = flexi_get_option('enable_buddypress', 'flexi_extension', 0);
        $enable_activity = flexi_get_option('enable_buddypress_activity', 'flexi_buddypress_settings', 1);
        if ("1" == $enable_addon && "1" == $enable_activity) {
            if (is_user_logged_in()) {
                $link   = get_permalink(flexi_get_option('primary_page', 'flexi_image_layout_settings', 0));
                $author = wp_get_current_user();
                $link = add_query_arg("flexi_user", $author->user_login, $link);
                $flexi_post = get_post($post_id);
                $content = '<div class="flexi-image-wrapper-thumb"><img src="' . esc_url(flexi_image_src('thumbnail', $flexi_post)) . '"></div>';
                $buddy_post = array(
                    'id'                => false,
                    // Pass an existing activity ID to update an existing entry.
                    'action'            => sprintf(__('%s has posted: <a target="_blank" href = "%s">%s</a>', 'flexi'), bp_core_get_userlink(bp_loggedin_user_id()), esc_url($link), esc_attr(get_the_title($post_id))),
                    // The activity action - e.g. "Jon Doe posted an update"
                    'content'           =>  $content,
                    'component'         => 'flexi',
                    // The name/ID of the component e.g. groups, profile, mycomponent
                    'type'              => 'flexi_submit',
                    // The activity type e.g. activity_update, profile_updated
                    'primary_link'      => '',
                    // Optional: The primary URL for this item in RSS feeds (defaults to activity permalink)
                    'user_id'           => $author->ID,
                    // Optional: The user to record the activity for, can be false if this activity is not for a user.
                    'item_id'           => $post_id,
                    // poll post id
                    'secondary_item_id' => $post_id,
                    // recorded vote id
                    'recorded_time'     => bp_core_current_time(),
                    // The GMT time that this activity was recorded
                    'hide_sitewide'     => false,
                    // Should this be hidden on the sitewide activity stream?
                    'is_spam'           => false,
                    // Is this activity item to be marked as spam?
                );

                return  bp_activity_add($buddy_post);
            }
        }
    }
}

//Ultimate Member: Setting at Flexi & Tab at profile page
$buddypress = new Flexi_Addon_BuddyPress();

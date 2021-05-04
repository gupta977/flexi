<?php
//User dashboard
class Flexi_User_Dashboard
{
    private $help = ' <a style="text-decoration: none;" href="https://odude.com/docs/flexi-gallery/information/my-gallery-page/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a>';

    public function __construct()
    {
        add_shortcode('flexi-user-dashboard', array($this, 'flexi_user_dashboard'));
        add_shortcode('flexi-common-toolbar', array($this, 'flexi_common_toolbar'));
        add_shortcode('flexi-profile-toolbar', array($this, 'flexi_profile_toolbar'));
        add_action('wp', array($this, 'enqueue_styles'));
        add_filter('flexi_settings_sections', array($this, 'add_section'));
        add_filter('flexi_settings_fields', array($this, 'add_fields_general'));
        add_filter("flexi_common_toolbar", array($this, 'logout_button'), 10, 1);
        add_filter("flexi_common_toolbar", array($this, 'submission_form_button'), 10, 1);
        add_filter("flexi_profile_toolbar", array($this, 'submission_form_button_profile'), 10, 1);
        add_filter("flexi_common_toolbar", array($this, 'gallery_button'), 10, 1);
        add_filter("flexi_common_toolbar", array($this, 'user_dashboard_button'), 10, 1);
        add_action('flexi_activated', array($this, 'set_value'));
    }
    public function set_value()
    {
        //Set default location of elements
        flexi_get_option('logout_button_label', 'flexi_user_dashboard_settings', "Logout");
        flexi_get_option('login_button_label', 'flexi_user_dashboard_settings', "Login");
    }

    //Add Section title & description at settings
    public function add_section($new)
    {

        $sections = array(
            array(
                'id'          => 'flexi_user_dashboard_settings',
                'title'       => __('User Dashboard', 'flexi'),
                'description' => __('Configuration for user dashboard page.', 'flexi') . ' ' . $this->help,
                'tab'         => 'general',
            ),
        );
        $new = array_merge($new, $sections);

        return $new;
    }

    //Add section fields
    public function add_fields_general($new)
    {

        $fields = array('flexi_user_dashboard_settings' => array(
            array(
                'name'              => 'my_gallery',
                'label'             => __('Member "User Dashboard" Page', 'flexi'),
                'description'       => __('Page with shortcode [flexi-user-dashboard]. Display gallery of own posts.', 'flexi') . ' ' . $this->help,
                'type'              => 'pages',
                'sanitize_callback' => 'sanitize_key',
            ),
            array(
                'name'              => 'gallery_layout',
                'label'             => __('Select gallery layout', 'flexi'),
                'description'       => __('Selected layout will be used as layout for dashboard page only.', 'flexi'),
                'type'              => 'layout',
                'sanitize_callback' => 'sanitize_key',
                'step'              => 'gallery',
            ),
            array(
                'name'              => 'perpage',
                'label'             => __('Post per page', 'flexi'),
                'description'       => __('Number of images/post/videos to be shown at a time.', 'flexi'),
                'type'              => 'number',
                'size'              => 'small',
                'min'               => '1',
                'sanitize_callback' => 'sanitize_key',
            ),
            array(
                'name'              => 'column',
                'label'             => __('Number of Columns', 'flexi'),
                'description'       => __('Maximum number of post to be shown horizontally & changes based on screen size. May not work for all layouts.', 'flexi'),
                'type'              => 'number',
                'size'              => 'small',
                'min'               => '1',
                'max'               => '10',
                'sanitize_callback' => 'sanitize_key',
            ),
            array(
                'name'              => 'enable_dashboard_search',
                'label'             => __('Disable search box', 'flexi'),
                'description'       => __('Hide search input box from user dashboard', 'flexi'),
                'type'              => 'checkbox',
                'sanitize_callback' => 'intval',
            ),
            array(
                'name'              => 'enable_dashboard_button',
                'label'             => __('"My Dashboard" button', 'flexi'),
                'description'       => __('Display "My Dashboard" button at "Common Toolbar"', 'flexi'),
                'type'              => 'checkbox',
                'sanitize_callback' => 'intval',
            ),

            array(
                'name'              => 'enable_mygallery_button',
                'label'             => __('"My Gallery" button', 'flexi'),
                'description'       => __('Display button at "My Dashboard" & "Common Toolbar"', 'flexi'),
                'type'              => 'checkbox',
                'sanitize_callback' => 'intval',
            ),

            array(
                'name'              => 'enable_submission_form_button',
                'label'             => __('"Submission form" button', 'flexi'),
                'description'       => __('Display submission button at "My Dashboard" & "Common Toolbar". Title displayed on button is based on form page linked.', 'flexi'),
                'type'              => 'checkbox',
                'sanitize_callback' => 'intval',
            ),

            array(
                'name'              => 'enable_logout_button',
                'label'             => __('"Login/Logout" button', 'flexi'),
                'description'       => __('Display logout/login button at user dashboard & common toolbar.', 'flexi'),
                'type'              => 'checkbox',
                'sanitize_callback' => 'intval',
            ),
            array(
                'name'              => 'logout_button_label',
                'label'             => __('Logout Button Label', 'flexi'),
                'description'       => __('Label of Logout button. Eg. Sign out', 'flexi'),
                'type'              => 'text',
                'size'              => 'medium',
                'sanitize_callback' => '',
            ),
            array(
                'name'              => 'login_button_label',
                'label'             => __('Login Button Label', 'flexi'),
                'description'       => __('Label of Login button. Eg. Sign in', 'flexi'),
                'type'              => 'text',
                'size'              => 'medium',
                'sanitize_callback' => '',
            ),

        ),);
        $new = array_merge($new, $fields);

        return $new;
    }

    public function flexi_user_dashboard()
    {
        global $wp_query;
        ob_start();
        if (is_singular()) {
            if (is_user_logged_in()) {


                $current_user = wp_get_current_user();

                $link = flexi_get_button_url('', false, 'my_gallery', 'flexi_user_dashboard_settings');
                $link_public = add_query_arg("tab", "public", $link);
                $link_private = add_query_arg("tab", "private", $link);

                global $wp;
                $current_url = add_query_arg($_SERVER['QUERY_STRING'], '', home_url($wp->request));

                if (isset($_GET['tab'])) {
                    $tab_arg = $_GET['tab'];
                } else {
                    $tab_arg = "public";
                }

?>
                <div class="fl-card">
                    <div class="fl-card-content">
                        <div class="fl-columns fl-is-mobile fl-is-centered">
                            <div class="fl-column fl-is-one-third fl-has-text-centered">
                                <?php echo flexi_author($current_user->user_login); ?>
                            </div>

                            <?php
                            $enable_search = flexi_get_option('enable_dashboard_search', 'flexi_user_dashboard_settings', 1);
                            if ("1" == $enable_search) {
                            ?>
                                <div class="fl-column fl-has-text-right">
                                    <form id="theForm" onkeydown="return event.key != 'Enter';">
                                        <div class="fl-field fl-has-addons">
                                            <div class="fl-control">
                                                <input id="search_value" class="fl-input" name="search" type="text" placeholder="<?php echo __('My search', 'flexi'); ?>">
                                            </div>
                                            <div class="fl-control">
                                                <a id="flexi_search" class="fl-button fl-is-info">
                                                    <?php echo __("Search", "flexi"); ?>
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <?php
                            }
                            ?>
                        </div>


                        <div class="fl-columns fl-is-mobile fl-is-centered">
                            <div class="fl-column fl-is-full fl-has-text-centered">
                                <?php echo do_shortcode("[flexi-common-toolbar]"); ?>
                            </div>
                        </div>


                        <div class="fl-columns fl-is-mobile fl-is-centered">
                            <div class="fl-column fl-is-full">

                                <div class="fl-tabs fl-is-centered fl-is-boxed">
                                    <ul>
                                        <li <?php if ($tab_arg == "public") echo 'class="fl-is-active"'; ?>>
                                            <a href="<?php echo $link_public; ?>" class="flexi-text-style">
                                                <span class="fl-icon fl-is-small"><i class="fas fa-image" aria-hidden="true"></i></span>
                                                <span><?php echo __('Published', 'flexi'); ?></span>
                                            </a>
                                        </li>
                                        <li <?php if ($tab_arg == "private") echo 'class="fl-is-active"'; ?>>
                                            <a href="<?php echo $link_private; ?>" class="flexi-text-style">
                                                <span class="fl-icon fl-is-small"><i class="fas fa-image" aria-hidden="true"></i></span>
                                                <span><?php echo __('Under review', 'flexi'); ?></span>
                                            </a>
                                        </li>

                                    </ul>
                                </div>

                                <div id="my_post">
                                    <?php do_action('flexi_user_dashboard'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<?php

            } else {
                echo flexi_login_link();
            }
        }
        return ob_get_clean();
    }

    //Styles only related to user dashboard
    public function enqueue_styles()
    {
        global $post;

        $my_gallery_id   = flexi_get_option('my_gallery', 'flexi_user_dashboard_settings', 0);
        $current_page_id = get_queried_object_id();
    }


    //common button toolbar shortcode: [flexi-common-toolbar]
    public function flexi_common_toolbar()
    {
        global $post;
        $icon = array();

        $list = '';

        if (has_filter('flexi_common_toolbar')) {
            $icon = apply_filters('flexi_common_toolbar', $icon);
        }

        if (count($icon) > 0) {
            $list .= '<div class="fl-buttons" role="toolbar" id="flexi-common-toolbar_' . get_the_ID() . '">';
        }

        for ($r = 0; $r < count($icon); $r++) {

            if ("" != $icon[$r][0]) {
                $list .= '<a href="' . $icon[$r][2] . '" class="' . $icon[$r][3] . '">
                <span class="fl-icon"><i class="' . $icon[$r][0] . '"></i></span>
                <span>' . $icon[$r][1] . '</span>
              </a>';
                // $list .= '<a href="' . $icon[$r][2] . '" class="' . $icon[$r][3] . '"><span class="' . $icon[$r][3] . '-icon"><span class="flexi_icon_' . $icon[$r][0] . '"></span></span><span class="' . $icon[$r][3] . '-text">' . $icon[$r][1] . '</span></a> ';
            }
        }
        if (count($icon) > 0) {
            $list .= '</div>';
        }
        return $list;
    }

    //profile button toolbar shortcode: [flexi-profile-toolbar]
    public function flexi_profile_toolbar()
    {
        global $post;
        $icon = array();

        $list = '';

        if (has_filter('flexi_profile_toolbar')) {
            $icon = apply_filters('flexi_profile_toolbar', $icon);
        }

        if (count($icon) > 0) {
            $list .= '<div class="fl-buttons" role="toolbar" id="flexi-profile-toolbar_' . get_the_ID() . '">';
        }

        for ($r = 0; $r < count($icon); $r++) {

            if ("" != $icon[$r][0]) {
                $list .= '<a href="' . $icon[$r][2] . '" class="' . $icon[$r][3] . '">
                    <span class="fl-icon"><i class="' . $icon[$r][0] . '"></i></span>
                    <span>' . $icon[$r][1] . '</span>
                  </a>';
            }
        }
        if (count($icon) > 0) {
            $list .= '</div>';
        }
        return $list;
    }


    public function gallery_button($icon)
    {
        if (is_user_logged_in()) {
            $enable_addon = flexi_get_option('enable_mygallery_button', 'flexi_user_dashboard_settings', 1);

            if ("1" == $enable_addon) {

                $extra_icon   = array();
                $post_form_id = flexi_get_option('primary_page', 'flexi_image_layout_settings', 0);
                $link         = get_permalink($post_form_id);
                $current_user = wp_get_current_user();

                $link = add_query_arg("flexi_user", $current_user->user_login, $link);

                $extra_icon = array(
                    array('far fa-images', __('My Gallery', 'flexi'), $link, 'fl-button'),

                );

                // combine the two arrays
                if (is_array($extra_icon) && is_array($icon)) {
                    $icon = array_merge($extra_icon, $icon);
                }
            }
        }
        return $icon;
    }

    public function submission_form_button($icon)
    {
        $enable_addon = flexi_get_option('enable_submission_form_button', 'flexi_user_dashboard_settings', 1);

        if ("1" == $enable_addon) {

            $extra_icon   = array();
            $post_form_id = flexi_get_option('submission_form', 'flexi_form_settings', 0);
            $post_form_object = get_post($post_form_id);
            $link         = get_permalink($post_form_id);
            $current_user = wp_get_current_user();
            // flexi_log($post_form_object);
            $post_title = $post_form_object->post_title;
            $extra_icon = array(
                array('fas fa-image', __($post_title, 'flexi'), $link, 'fl-button'),

            );

            // combine the two arrays
            if (is_array($extra_icon) && is_array($icon)) {
                $icon = array_merge($extra_icon, $icon);
            }
        }
        return $icon;
    }

    public function submission_form_button_profile($icon)
    {
        $enable_addon = flexi_get_option('enable_submission_form_button', 'flexi_user_dashboard_settings', 1);

        if ("1" == $enable_addon) {

            if (is_user_logged_in()) {
                $enable_buddypress = flexi_get_option('enable_buddypress', 'flexi_extension', 0);
                $enable_um = flexi_get_option('enable_ultimate_member', 'flexi_extension', 0);
                if ("1" == $enable_buddypress) {
                    $user_info = bp_get_displayed_user_username();
                } else  if ("1" == $enable_um) {
                    $user_info = get_userdata(um_profile_id());
                } else {
                    $user_info = '';
                }

                $current_user = wp_get_current_user();

                if ($user_info == $current_user->user_login) {
                    $extra_icon   = array();
                    $post_form_id = flexi_get_option('submission_form', 'flexi_form_settings', 0);
                    $post_form_object = get_post($post_form_id);
                    $link         = get_permalink($post_form_id);

                    // flexi_log($post_form_object);
                    $post_title = $post_form_object->post_title;
                    $extra_icon = array(
                        array('fas fa-image', __($post_title, 'flexi'), $link, 'fl-button'),

                    );

                    // combine the two arrays
                    if (is_array($extra_icon) && is_array($icon)) {
                        $icon = array_merge($extra_icon, $icon);
                    }
                }
            }
        }
        return $icon;
    }

    public function logout_button($icon)
    {
        $extra_icon = array();
        $enable_addon = flexi_get_option('enable_logout_button', 'flexi_user_dashboard_settings', 1);

        if ("1" == $enable_addon) {

            if (is_user_logged_in()) {
                $button_label = flexi_get_option('logout_button_label', 'flexi_user_dashboard_settings', "Logout");

                $link       = wp_logout_url(home_url());
            } else {
                $link       = esc_url(wp_login_url(get_permalink()));
                $button_label = flexi_get_option('login_button_label', 'flexi_user_dashboard_settings', "Login");
            }

            $extra_icon = array(
                array("fas fa-sign-out-alt", $button_label, $link, 'fl-button'),

            );

            // combine the two arrays
            if (is_array($extra_icon) && is_array($icon)) {
                $icon = array_merge($extra_icon, $icon);
            }
        }

        return $icon;
    }

    public function user_dashboard_button($icon)
    {
        if (is_user_logged_in()) {
            $extra_icon = array();
            $link         = flexi_get_button_url('', false, 'my_gallery', 'flexi_user_dashboard_settings');
            $enable_addon = flexi_get_option('enable_dashboard_button', 'flexi_user_dashboard_settings', 1);
            $current_page_id = get_the_ID();
            $dashboard_page_id    = flexi_get_option('my_gallery', 'flexi_user_dashboard_settings', 0);
            if ($current_page_id != $dashboard_page_id) {
                if ("#" != $link && "1" == $enable_addon) {

                    $extra_icon = array(
                        array("fas fa-tachometer-alt", __('My Dashboard', 'flexi'), $link, 'fl-button'),

                    );
                }
                // combine the two arrays
                if (is_array($extra_icon) && is_array($icon)) {
                    $icon = array_merge($extra_icon, $icon);
                }
            }
        }
        return $icon;
    }
}
$user_dashboard = new Flexi_User_Dashboard();

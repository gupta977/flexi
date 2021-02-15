<?php

/**
 * Settings Form.
 *
 * @link    https://odude.com
 * @since   1.0.0
 *
 * @package Flexi
 */

$active_tab     = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'general';
$active_section = isset($_GET['section']) ? sanitize_text_field($_GET['section']) : '';

$sections = array();
foreach ($this->sections as $section) {
    $tab = $section['tab'];

    if (!isset($sections[$tab])) {
        $sections[$tab] = array();
    }

    $sections[$tab][] = $section;
}
?>

<div id="flexi-settings" class="wrap flexi-settings">
    <?php
    $flexi_activated = get_option('flexi_activated');
    //if (true) {
    if ($flexi_activated) {
        //Setup completed at: \flexi\includes\user_dashboard\class-flexi-user-dashboard.php

        //Create Pages and assign to settings
        $flexi_pages_created = get_option('flexi_pages_created');
        if (!$flexi_pages_created) {
            flexi_create_pages();
        }

    ?>
        <div class="card">
            <h1><?php esc_html_e('Welcome to Flexi', 'flexi'); ?></h1>
            <p>Flexi is activated but not yet fully setup. Follow the steps below to auto configure the installation.</p>
            <p>

                <br><br><b>Post one image & settings will be applied automatically based on server configuration</b>
            </p>

            <p><?php echo "<a href='" . flexi_get_button_url('', false, 'submission_form', 'flexi_form_settings') . "' class='button button-primary'>" . __('Post to Configure', 'flexi') . "</a>" ?>
                <br> <br><?php
                            echo "<a href='" . flexi_get_button_url('', false, 'my_gallery', 'flexi_user_dashboard_settings') . "' >" . __('Skip, I have already done.', 'flexi') . "</a><br>"
                            ?>
            </p>
        </div>

    <?php

    } else {

    ?>

        <h1><?php esc_html_e('Flexi Plugin Settings', 'flexi'); ?></h1>
        <div style="text-align:right">
            <a href="<?php echo admin_url('admin.php?page=flexi'); ?>" class="button"><?php echo __('Flexi', 'flexi'); ?> <?php echo __('Dashboard', 'flexi'); ?> </a>
            <a href="<?php echo admin_url('admin.php?page=flexi&tab=pages'); ?>" class="button"><?php echo __('Flexi', 'flexi'); ?> <?php echo __('Health', 'flexi'); ?> </a>
            <a href="<?php echo admin_url('admin.php?page=flexi&tab=pro'); ?>" class="button"><?php echo __('Flexi-Pro', 'flexi'); ?></a>
        </div>
        <?php settings_errors(); ?>

        <h2 class="nav-tab-wrapper">
            <?php
            foreach ($this->tabs as $tab => $title) {
                $url = add_query_arg('tab', $tab, admin_url('admin.php?page=flexi_settings'));

                foreach ($sections[$tab] as $section) {
                    $url = add_query_arg('section', $section['id'], $url);

                    if ($tab == $active_tab && empty($active_section)) {
                        $active_section = $section['id'];
                    }

                    break;
                }

                printf(
                    '<a href="%s" class="%s">%s</a>',
                    esc_url($url),
                    ($tab == $active_tab ? 'nav-tab nav-tab-active' : 'nav-tab'),
                    esc_html($title)
                );
            }
            ?>
        </h2>

        <?php
        $section_links = array();

        foreach ($sections[$active_tab] as $section) {
            $url = add_query_arg(
                array(
                    'tab'     => $active_tab,
                    'section' => $section['id'],
                ),
                admin_url('admin.php?page=flexi_settings')
            );

            $section_links[] = sprintf(
                '<a href="%s" class="%s">%s</a>',
                esc_url($url),
                ($section['id'] == $active_section ? 'current' : ''),
                esc_html($section['title'])
            );
        }

        if (count($section_links) > 1) : ?>
            <ul class="subsubsub">
                <li><?php echo implode(' | </li><li>', $section_links); ?></li>
            </ul>
            <div class="clear"></div>
        <?php endif; ?>

        <form method="post" action="options.php">
            <?php
            $page_hook = $active_section;

            settings_fields($page_hook);
            do_settings_sections($page_hook);

            submit_button();
            ?>
        </form>
    <?php
    }
    ?>
</div>
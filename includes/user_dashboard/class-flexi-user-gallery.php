<?php
//User dashboard Gallery

class Flexi_User_Dashboard_Gallery
{
    public function __construct()
    {
        add_action('flexi_user_dashboard', array($this, 'flexi_user_gallery'));
    }

    public function flexi_user_gallery()
    {
        if (isset($_GET['tab'])) {
            $tab_arg = $_GET['tab'];
        } else {
            $tab_arg = "public";
        }

        if ($tab_arg == "public") {
            $shortcode = '[flexi-gallery user="show_mine" layout="regular"]';
            echo do_shortcode($shortcode);
        } else  if ($tab_arg == "private") {
            $shortcode = '[flexi-gallery user="show_mine" layout="wide" post_status="draft"]';
            echo do_shortcode($shortcode);
        } else {
            echo '';
        }
    }

    public function flexi_user_gallery1()
    {
        global $post;
        global $wp_query;

        $put = "";
        ob_start();
        if (is_user_logged_in()) {

            $current_user = wp_get_current_user();
            $user = $current_user->ID;
            $post_status = array('draft', 'publish', 'pending');
            $orderby = '';
            //$popup = flexi_get_option('lightbox_switch', 'flexi_detail_settings', 1);
            $popup = 1; //popup always on at user dashbaord
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $search = (get_query_var('search')) ? get_query_var('search') : '';
            $postsperpage = 20;
?>

            <div class="flexi_wrapper">
                <div class="flexi_table">

                    <?php

                    $args = array(
                        'post_type' => 'flexi',
                        's' => $search,
                        'paged' => $paged,
                        'posts_per_page' => $postsperpage,
                        'author' => $user,
                        'post_status' => $post_status,
                        'orderby' => $orderby,
                        'order' => 'DESC',

                    );
                    $count = 0;
                    //flexi_log($args);
                    $query = new WP_Query($args);
                    while ($query->have_posts()) : $query->the_post();

                        $data = flexi_image_data('thumbnail', get_the_ID(), $popup);

                    ?>
                        <div class="flexi_row" id="flexi_content_<?php echo get_the_ID(); ?>">

                            <div class="flexi_cell flexi-image-wrapper-icon">
                                <a data-fancybox="gallery" <?php echo ' href="' . $data['url'] . '" data-caption="' . $data['title'] . '" border="0"'; ?>>
                                    <img src="<?php echo esc_url(flexi_image_src('thumbnail', $post)); ?>">

                                </a>
                            </div>
                            <div class="flexi_cell" data-title="">
                                <?php echo $data['title']; ?>
                                <div class="flexi_text_group">
                                    <?php echo flexi_list_tags($post, '', 'flexi_text_small', 'dashicons dashicons-tag'); ?> </div>
                                <div class="flexi_text_group">
                                    <?php echo flexi_list_tags($post, '', 'flexi_text_small', 'dashicons dashicons-category', 'flexi_category'); ?>
                                </div>
                            </div>
                            <div class="flexi_cell" data-title="">
                                <?php
                                if (get_post_status() == 'draft' || get_post_status() == "pending") {
                                ?>

                                    <div class="flexi_text_group">
                                        <div class="flexi_text_small">
                                            <span class="dashicons dashicons-hidden"></span>
                                            <?php echo __("Under Review", "flexi"); ?>
                                        </div>
                                    </div>


                                <?php
                                } else {
                                ?>

                                    <div class="flexi_text_group">
                                        <div class="flexi_text_small">
                                            <span class="dashicons dashicons-visibility"></span>
                                            <?php echo __("Public", "flexi"); ?>
                                        </div>
                                    </div>


                                <?php
                                }
                                ?>

                                <div class="flexi_text_group">
                                    <div class="flexi_text_small">
                                        <span class="dashicons dashicons-calendar-alt"></span>
                                        <?php echo get_the_date(); ?>
                                    </div>
                                </div>


                            </div>



                            <div class="flexi_cell" data-title="">
                                <?php echo flexi_show_icon_grid(); ?>
                            </div>
                        </div> <?php
                                $count++;
                            endwhile;

                            wp_reset_query();
                            wp_reset_postdata();
                                ?>

                </div>
            </div>


<?php
            echo __('Total', 'flexi') . ": " . $query->found_posts;
            do_action('flexi_user_gallery_dashboard_footer');
            echo flexi_page_navi($query);
        } else {
            flexi_login_link();
        }

        $put = ob_get_clean();
        echo $put;
    }
}
$user_dashboard = new Flexi_User_Dashboard_Gallery();

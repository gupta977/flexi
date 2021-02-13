<?php
//Process ajax form submitted by [flexi-form] shortcode

add_action("wp_ajax_flexi_ajax_post", "flexi_ajax_post");
add_action("wp_ajax_nopriv_flexi_ajax_post", "flexi_ajax_post");


//Upload all images from frontend
function flexi_ajax_post()
{
    if (
        !isset($_POST['flexi-nonce'])
        || !wp_verify_nonce($_POST['flexi-nonce'], 'flexi-nonce')
    ) {

        exit('The form is not valid');
    }

    // A default response holder, which will have data for sending back to our js file
    $response = array(
        'error' => false,
        'msg'   => 'No Message',
    );

    // Example for creating an response with error information, to know in our js file
    // about the error and behave accordingly, like adding error message to the form with JS
    if (trim($_POST['upload_type']) == '') {
        $response['error']         = true;
        $response['error_message'] = 'Improper form fields. Ajax cannot continue.';

        // Exit here, for not processing further because of the error
        exit(json_encode($response));
    }

    $attr          = flexi_default_args('');
    $detail_layout = $attr['detail_layout'];
    $edit_page = $attr['edit_page'];
    $title         = $attr['user-submitted-title'];
    $content       = $attr['content'];
    $category      = $attr['category'];
    $tags          = $attr['tags'];
    $upload_type   = $attr['upload_type'];
    $post_taxonomy = $attr['taxonomy'];
    $tag_taxonomy  = $attr['tag_taxonomy'];
    $edit          = $attr['edit'];
    $flexi_id      = $attr['flexi_id'];
    $type          = $attr['type'];
    $url           = $attr['user-submitted-url'];

    if ('flexi' == $upload_type) {

        $files = array();
        if (isset($_FILES['user-submitted-image'])) {
            $files = $_FILES['user-submitted-image'];
        }

        if ("false" == $edit) {
            //Insert new post
            if ('url' == $attr['type']) {
                //flexi_log($attr);
                $result = flexi_submit_url($title, $url, $content, $category, $detail_layout, $tags, $edit_page);
            } else {
                $result = flexi_submit($title, $files, $content, $category, $detail_layout, $tags, $edit_page);
            }
            $post_id = false;
            if (isset($result['id'])) {
                $post_id = $result['id'];
            }

            $error = false;
            if (isset($result['error'])) {
                $error = array_filter(array_unique($result['error']));
            }

            //$response['msg'] = $msg . ' ';

            if ($post_id) {
                /* //Submit extra fields data
    for ($x = 1; $x <= 10; $x++) {
    if (isset($_POST['flexi_field_' . $x])) {
    add_post_meta($post_id, 'flexi_field_' . $x, $_POST['flexi_field_' . $x]);
    }

    } */

                do_action("flexi_submit_complete", $post_id);

                $response['type'] = "success";

                if (flexi_get_option('publish', 'flexi_form_settings', 1) == 1) {

                    $response['msg'] = "<div class='flexi_alert-box flexi_success'>" . __('Submission completed', 'flexi') . "</div> " . '' . flexi_get_error($result) . '' . flexi_post_toolbar_grid($post_id, true);
                } else {

                    $response['msg'] = "<div class='flexi_alert-box flexi_warning'>" . __('Your submission is under review', 'flexi') . "</div>" . '' . flexi_get_error($result) . '' . flexi_post_toolbar_grid($post_id, true);
                }
            } else {
                $err = '';

                $reindex_array = array_values(array_filter($result['error']));
                $msg           = "";
                for ($x = 0; $x < count($reindex_array); $x++) {
                    // $err .= $reindex_array[$x] . "  ";
                    $msg .= "<div class='flexi_alert-box flexi_error'>" . flexi_error_code($reindex_array[$x]) . '</div>';
                }
                $response['msg'] = $msg . ' ' . flexi_post_toolbar_grid('', true);
                //flexi_log($reindex_array);
                /*
   if (in_array('file-type', $result['error'])) {
   $response['msg'] = "<div class='flexi_error'>" . __('Check your file type', 'flexi') . " " . __('Submission failed', 'flexi') . "</div>";
   } else if (in_array('required-category', $result['error'])) {
   $response['msg'] = "<div class='flexi_error'>" . __('Category is not specified', 'flexi') . " " . __('Submission failed', 'flexi') . "</div>";
   } else {
   $response['msg'] = "<div class='flexi_error'>" . __('Submission failed', 'flexi') . "<br>" . __('Error message: ') . $err . "</div>";
   }
    */
            }
        } else {
            //Update old post
            $result = flexi_update_post($flexi_id, $title, $files, $content, $category, $tags);

            if ($flexi_id) {
                do_action("flexi_submit_update", $flexi_id);
                $response['type'] = "success";

                if (flexi_get_option('publish', 'flexi_form_settings', 1) == 1) {

                    $response['msg'] = "<div class='flexi_alert-box flexi_success'>" . __('Successfully updated', 'flexi') . "</div>" . flexi_post_toolbar_grid($flexi_id, true);
                } else {

                    $response['msg'] = "<div class='flexi_alert-box flexi_warning'>" . __('Your modification is under review.', 'flexi') . "</div>" . flexi_post_toolbar_grid($flexi_id, true);
                }
            } else {

                $response['msg'] = "<div class='flexi_alert-box flexi_error'>" . __('Submission failed', 'flexi') . "</div>" . flexi_post_toolbar_grid('', false);
            }
        }
    } else {
        $result['error'][] = "Upload Type Not Supported. Check your form parameters.";
    }
    // Don't forget to exit at the end of processing
    $data = json_encode($response);
    echo $data;
    die();
}

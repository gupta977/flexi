<?php
//Update primary image
class flexi_update_image
{

    public function __construct()
    {
        add_action("wp_ajax_flexi_ajax_update_image", array($this, "flexi_ajax_update_image"));
        add_action("wp_ajax_nopriv_flexi_ajax_update_image", array($this, "flexi_my_must_login"));
    }

    //Used in ajax call, force users to login before any action.
    public function flexi_my_must_login()
    {
        echo __("Login Please !", "flexi");
        die();
    }

    //update primary image from edit screen
    public function flexi_ajax_update_image()
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
        $flexi_id      = $attr['flexi_id'];
        $upload_type   = $attr['upload_type'];
        $replace_type   = $attr['type'];

        if ('flexi' == $upload_type) {
            if (isset($_FILES['user-submitted-image'])) {
                $files = $_FILES['user-submitted-image'];
            }
            $response['type'] = "success";

            if ($replace_type == "primary") {
                //Process image to delete old and keep new one
                $result = $this->flexi_update_primary_image($files, $flexi_id);
            } else {
                $result = $this->flexi_add_more_image_standalone($files, $flexi_id);
            }

            $error = false;
            if (isset($result['error'])) {
                $error = array_filter(array_unique($result['error']));
            }
            $response['msg'] = "<div class='flexi_alert-box flexi_success'>" . __('Successfully updated', 'flexi') . "</div>";
        } else {
            $result['error'][] = "Upload Type Not Supported. Check your form parameters.";
            $reindex_array = array_values(array_filter($result['error']));
            $msg           = "";
            for ($x = 0; $x < count($reindex_array); $x++) {
                // $err .= $reindex_array[$x] . "  ";
                $msg .= "<div class='flexi_alert-box flexi_error'>" . flexi_error_code($reindex_array[$x]) . '</div>';
            }
            $response['msg'] = $msg;
        }
        // Don't forget to exit at the end of processing

        $data = json_encode($response);
        echo $data;
        die();
    }

    //Add more images to standalone gallery
    public function flexi_add_more_image_standalone($files, $flexi_id)
    {
        // flexi_log("Adding into standalone gallery");

        $newPost      = array();
        $newPost      = array('id' => false, 'error' => false, 'notice' => false);
        $newPost['error'][] = "";
        $post_author_id = get_post_field('post_author', $flexi_id);

        flexi_include_deps();


        if (isset($files['tmp_name'][0])) {
            $check_file_exist = $files['tmp_name'][0];
        } else {
            $check_file_exist = "";
        }

        $file_count = flexi_upload_get_file_count($files);
        if (0 == $file_count) {
            //Execute loop at least once
            $file_count = 1;
        }
        $i = 0;
        $existing_files = get_post_meta($flexi_id, 'flexi_standalone_gallery', 1);
        if (!is_array($existing_files)) {
            $existing_files = array();
        }
        //flexi_log($existing_files);
        for ($x = 1; $x <= $file_count; $x++) {

            if ($files && !empty($check_file_exist)) {
                $key = apply_filters('flexi_file_key', 'user-submitted-image-{$i}');
                $_FILES[$key]             = array();
                $_FILES[$key]['name']     = $files['name'][$i];
                $_FILES[$key]['tmp_name'] = $files['tmp_name'][$i];
                $_FILES[$key]['type']     = $files['type'][$i];
                $_FILES[$key]['error']    = $files['error'][$i];
                $_FILES[$key]['size']     = $files['size'][$i];

                //Check the file before processing
                $file_data = flexi_check_file($_FILES[$key]);

                $attach_id = media_handle_upload($key, $flexi_id);
                if (!is_wp_error($attach_id) & ('' == trim($file_data['error'][0]))) {

                    $attach_ids[] = $attach_id;
                    //flexi_log($attach_ids);
                    $existing_files[$attach_id] = wp_get_attachment_url($attach_id);
                    //flexi_log($attach_id . "--");
                    //update_post_meta($flexi_id, 'flexi_image', wp_get_attachment_url($attach_id));
                } else {
                    if (!is_wp_error($attach_id)) {
                        //Delete attachment if uploaded
                        wp_delete_attachment($attach_id);
                    }
                    //Delete post if error found
                    $newPost['error'][]  = $file_data['error'][0];
                    $newPost['notice'][] = $_FILES[$key]['name'];
                }
            }
            $i++;
        }
        //flexi_log($existing_files);
        update_post_meta($flexi_id, 'flexi_standalone_gallery', $existing_files);
        return $newPost;
    }

    //Delete old image and keep new one
    public function flexi_update_primary_image($files, $flexi_id)
    {

        //flexi_log("update primary");

        $newPost      = array();
        $newPost      = array('id' => false, 'error' => false, 'notice' => false);
        $newPost['error'][] = "";
        // flexi_log($files);
        $post_author_id = get_post_field('post_author', $flexi_id);
        //Delete the old image 
        if (get_current_user_id() == $post_author_id) {
            $del = new flexi_delete_post();
            $del->flexi_delete_post_media($flexi_id);
        }

        //Assign new image
        flexi_include_deps();


        if (isset($files['tmp_name'][0])) {
            $check_file_exist = $files['tmp_name'][0];
        } else {
            $check_file_exist = "";
        }

        $file_count = flexi_upload_get_file_count($files);
        if (0 == $file_count) {
            //Execute loop at least once
            $file_count = 1;
        }
        $i = 0;
        for ($x = 1; $x <= $file_count; $x++) {
            if ($files && !empty($check_file_exist)) {
                $key = apply_filters('flexi_file_key', 'user-submitted-image-{$i}');
                $_FILES[$key]             = array();
                $_FILES[$key]['name']     = $files['name'][$i];
                $_FILES[$key]['tmp_name'] = $files['tmp_name'][$i];
                $_FILES[$key]['type']     = $files['type'][$i];
                $_FILES[$key]['error']    = $files['error'][$i];
                $_FILES[$key]['size']     = $files['size'][$i];

                //Check the file before processing
                $file_data = flexi_check_file($_FILES[$key]);

                $attach_id = media_handle_upload($key, $flexi_id);
                if (!is_wp_error($attach_id) & ('' == trim($file_data['error'][0]))) {

                    $attach_ids[] = $attach_id;
                    update_post_meta($flexi_id, 'flexi_image_id', $attach_id);
                    update_post_meta($flexi_id, 'flexi_image', wp_get_attachment_url($attach_id));
                } else {
                    if (!is_wp_error($attach_id)) {
                        //Delete attachment if uploaded
                        wp_delete_attachment($attach_id);
                    }
                    //Delete post if error found
                    $newPost['error'][]  = $file_data['error'][0];
                    $newPost['notice'][] = $_FILES[$key]['name'];
                }
            }
        }
        return $newPost;
    }
}
$update_image = new flexi_update_image();

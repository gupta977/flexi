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

        if ('flexi' == $upload_type) {
            if (isset($_FILES['user-submitted-image'])) {
                $files = $_FILES['user-submitted-image'];
            }
            $response['type'] = "success";
            //Process image to delete old and keep new one
            $result = $this->flexi_update_primary_image($files, $flexi_id);

            $error = false;
            if (isset($result['error'])) {
                $error = array_filter(array_unique($result['error']));
            }
        } else {
            $result['error'][] = "Upload Type Not Supported. Check your form parameters.";
        }
        // Don't forget to exit at the end of processing
        $data = json_encode($response);
        echo $data;
        die();
    }

    //Delete old image and keep new one
    public function flexi_update_primary_image($files, $flexi_id)
    {
        flexi_log($files);
    }
}
$update_image = new flexi_update_image();

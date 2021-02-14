<?php
//Certain task to make Flexi stable

class Flexi_Service_Handler
{
    public function __construct()
    {
        add_action('flexi_submit_complete', array($this, 'complete_install'), 10, 1);
    }

    //Complete the installation as soon as first image is posted
    public function complete_install($post_id)
    {

        //Flexi setup complete, enable backend settings
        $flexi_activated = get_option('flexi_activated');
        if ($flexi_activated) {
            if (get_option('flexi_activated', false)) {
                delete_option('flexi_activated');
                delete_option('flexi_pages_created');
            }
        }
    }
}
$links = new Flexi_Service_Handler();

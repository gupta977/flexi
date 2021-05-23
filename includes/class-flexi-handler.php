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
        flexi_install_complete();
    }
}
$links = new Flexi_Service_Handler();

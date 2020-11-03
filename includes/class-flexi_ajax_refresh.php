<?php
class flexi_ajax_refresh
{
    //Refresh function of specific position after some action
    public function __construct()
    {
        add_action("wp_ajax_flexi_ajax_refresh", array($this, "flexi_ajax_refresh"));
        add_action("wp_ajax_nopriv_flexi_ajax_refresh", array($this, "flexi_ajax_refresh"));
    }

    public function flexi_ajax_refresh()
    {
        $id = $_REQUEST["id"];
        $param1 = $_REQUEST["param1"];
        $param2 = $_REQUEST["param2"];
        $param3 = $_REQUEST["param3"];
        $method_name = $_REQUEST["method_name"];

        $response = array(
            'error' => false,
            'msg'   => 'No Message',
            'count' => '0',
        );

        //******************** */
        //Run the function as mentioned on $method_name

        $msg = $this->$method_name($id, $param1, $param2, $param3);

        //******************** */

        $response['msg'] = $msg;
        $result = json_encode($response);
        // flexi_log($result);
        echo $result;
        die();
    }

    public function standalone($id, $param1, $param2, $param3)
    {
        ob_start();
        echo '<div id="flexi_thumb_image">' . flexi_standalone_gallery($id, 'thumbnail', 75, 75, true) . '</div>';
        $put = ob_get_clean();
        return $put;
    }
}

$refresh = new flexi_ajax_refresh();

<?php
class Flexi_Addon_Mime_Type
{
    public function __construct()
    {

        add_filter('flexi_settings_sections', array($this, 'add_section'));
        add_filter('flexi_settings_fields', array($this, 'add_extension'));
        add_filter('flexi_settings_fields', array($this, 'add_fields'));
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
        $enable_addon = flexi_get_option('enable_mime_type', 'flexi_extension', 0);
        if ("1" == $enable_addon) {
            $sections = array(
                array(
                    'id'          => 'flexi_mime_type',
                    'title'       => __('Manage Mime Type', 'flexi'),
                    'description' => __('Add new file type to upload.', 'flexi'),
                    'tab'         => 'form',
                ),
            );
            $new = array_merge($new, $sections);
        }
        return $new;
    }

    //Add enable/disable option at extension tab
    public function add_extension($new)
    {
        $fields = array(
            'flexi_extension' => array(
                array(
                    'name'              => 'enable_mime_type',
                    'label'             => __('Enable Mime Type', 'flexi'),
                    'description'       => __('Select the list of file type user is allowed to upload.', 'flexi') . ' <a style="text-decoration: none;" href="' . admin_url('admin.php?page=flexi_settings&tab=form&section=flexi_mime_type') . '"><span class="dashicons dashicons-admin-tools"></span></a>',
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

        $enable_addon = flexi_get_option('enable_mime_type', 'flexi_extension', 0);
        if ("1" == $enable_addon) {
            $fields = array(
                'flexi_mime_type' => array(
                    //https://developer.wordpress.org/reference/functions/wp_get_mime_types/
                    array(
                        'name'        => 'flexi_mime_type_list',
                        'label'       => __('Select allowed file type', 'flexi'),
                        'description' => 'The selection will be only valid for Flexi plugin.',
                        'type'        => 'multicheck',
                        'options'     => array(
                            'image/jpeg'         => __('Image format', 'flexi') . ' - jpeg',
                            'image/gif'          => __('Image format', 'flexi') . ' - gif',
                            'image/png'          => __('Image format', 'flexi') . ' - png',
                            'video/mpeg'         => __('Video format', 'flexi') . ' - mpeg,mpg,mpe',
                            'video/mp4'          => __('Video format', 'flexi') . ' - mp4,m4v',
                            'video/webm'         => __('Video format', 'flexi') . ' - webm',
                            'text/plain'         => __('Text format', 'flexi') . ' - txt,asc,c,cc,h,srt',
                            'text/csv'           => __('Text format', 'flexi') . ' - csv',
                            'audio/mpeg'         => __('Audio format', 'flexi') . ' - mp3,m4a,m4b',
                            'application/pdf'    => __('Portable Document Format (PDF)', 'flexi') . ' - pdf',
                            'application/msword' => __('Word Document (DOC)', 'flexi') . ' - doc',
                        ),
                    ),

                    array(
                        'name'        => 'flexi_extra_mime',
                        'type'        => 'textarea',
                        'label'       => __('Extra Mime type', 'flexi'),
                        'description' => __('Add extra file type if not listed above separated with comma.<br>Eg. video/avi,video/3gpp,audio/midi<br>Required Flexi-PRO', 'flexi'),
                    ),

                ),
            );

            //print_r($fields);
            $new = array_merge($new, $fields);
        }
        return $new;
    }
}

//Ultimate Member: Setting at Flexi & Tab at profile page
$mime = new Flexi_Addon_Mime_Type();

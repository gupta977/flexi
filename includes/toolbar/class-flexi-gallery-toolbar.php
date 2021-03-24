<?php
class Flexi_Gallery_Toolbar
{
    //TOOLBAR PLACEHOLDER ABOVE GALLERY
    public function __construct()
    {
    }
    public function label($class = "fl-is-info", $class_main = "fl-tags fl-has-addons")
    {
        //Display label at Main gallery page
        if (is_flexi_page('primary_page', 'flexi_image_layout_settings')) {

            //Show TAG Label
            $tag_slug = get_query_var('flexi_tag', "");
            $tag      = get_term_by('slug', $tag_slug, 'flexi_tag');

            if ("" != $tag_slug && true == $tag) {
                return '<div class="' . $class_main . '"><span class="fl-tag"><i class="fa fa-tag"></i></span><span class="fl-tag ' . $class . '">' . $tag->name . '</span></div>';
                //return '<div class="' . $class_main . '"><a class="' . $class . '">' . $tag->name . '</a></div>';
            }

            //Show Search label
            $search = get_query_var('search', "");
            if ($search != "") {
                $o = '<div class="fl-field fl-is-grouped fl-is-grouped-multiline">';

                for ($z = 1; $z <= 20; $z++) {
                    $param_value = flexi_get_param_value('flexi_field_' . $z, $search);
                    if ($param_value != '') {
                        $o .= '<div class="fl-control"><div class="fl-tags fl-has-addons">';
                        $o .= '<span class="fl-tag">flexi_field_' . $z . '</span> <span class="fl-tag fl-is-info">' . $param_value . '</span>';
                        $o .= "</div></div>";
                    }
                }
                $o .= "</div>";
                return $o;
            }

            //Show Album Label
            //Get redirected sub album
            $term_slug = get_query_var('flexi_category');
            $term      = get_term_by('slug', $term_slug, 'flexi_category');

            if ("" != $term_slug && true == $term) {
                //return $term->name;
                return flexi_album_single($term_slug, 'flexi_user-list');
            }

            //Show User Name
            //Author
            $username = get_query_var('flexi_user');
            $user     = get_user_by('login', $username);
            if ("" != $username && $user) {

                //return $user->first_name . ' ' . $user->last_name;
                return flexi_author($username);
            }
        }
    }
}

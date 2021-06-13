<?php

/**
 * Register Meta Boxes
 */
class Flexi_Meta_boxes
{

  public function __construct()
  {
    add_action('bulk_edit_custom_box', array($this, 'quick_edit_add'), 10, 2);
    add_action('quick_edit_custom_box', array($this, 'quick_edit_add'), 10, 2);
    add_action('save_post', array($this, 'save_quick_edit_data'));
  }

  /**
   * Register CMB2 Meta-boxes
   *
   * @link https://github.com/CMB2/CMB2
   */
  public function register_meta_box()
  {
    /**
     * Initiate the metabox
     */
    $cmb = new_cmb2_box(array(
      'id'           => 'flexi_metabox',
      'title'        => __('Flexi Meta Controls', 'flexi'),
      'object_types' => array('flexi'), // Post type
      'context'      => 'normal',
      'priority'     => 'high',
      'show_names'   => true, // Show field names on the left
      // 'cmb_styles' => false, // false to disable the CMB stylesheet
      // 'closed'     => true, // Keep the metabox closed by default
    ));

    // Regular Image Field
    $cmb->add_field(array(
      'name'         => 'Primary image file',
      'desc'         => 'Upload an image',
      'id'           => 'flexi_image',
      'type'         => 'file',
      // Optional:
      'options'      => array(
        'url' => false, // Hide the text input for the url
      ),
      'text'         => array(
        'add_upload_file_text' => 'Add Image File', // Change upload button text. Default: "Add or Upload File"
      ),
      // query_args are passed to wp.media's library query.
      'query_args'   => array(
        //'type' => 'application/pdf', // Make library only display PDFs.
        // Or only allow gif, jpg, or png images
        'type' => array(
          'image/gif',
          'image/jpeg',
          'image/png',
        ),
      ),
      'preview_size' => 'medium', // Image size to use when previewing in the admin.
    ));

    $cmb->add_field(array(
      'name' => 'Physical file',
      'desc' => 'Select file other then images',
      'id'   => 'flexi_file',
      'type' => 'file',
      'text' => array(
        'add_upload_file_text' => 'Add file',
      ),
    ));

    //Add Image gallery
    $cmb->add_field(array(
      'name'       => 'Standalone Image Gallery',
      'desc'       => '',
      'id'         => 'flexi_standalone_gallery',
      'type'       => 'file_list',
      // 'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
      'query_args' => array('type' => 'image'), // Only images attachment
      // Optional, override default text strings
      'text'       => array(
        'add_upload_files_text' => 'Upload Multiple Image Files', // default: "Add or Upload Files"
        //'remove_image_text'     => 'Replacement', // default: "Remove Image"
        //'file_text'             => 'Replacement', // default: "File:"
        //'file_download_text'    => 'Replacement', // default: "Download"
        //'remove_text'           => 'Replacement', // default: "Remove"
      ),
    ));

    $cmb->add_field(array(
      'name'       => 'oEmbed URL',
      'desc'       => 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.',
      'id'         => 'flexi_url',
      'type'       => 'oembed',
      'width'      => '200',
      'attributes' => array(
        'width' => '200',
      ),
    ));

    // Add meta box to flexi_category
    /**
     * Initiate the metabox
     */
    $cmb_category = new_cmb2_box(array(
      'id'           => 'flexi_metabox_category',
      'title'        => __('Category Thumbnail', 'flexi'),
      'object_types' => array('term'), // Tells CMB2 to use term_meta vs post_meta
      'taxonomies'   => array('flexi_category'), // Tells CMB2 which taxonomies should have these fields
      'context'      => 'normal',
      'priority'     => 'high',
      'show_names'   => false, // Show field names on the left
      // 'cmb_styles' => false, // false to disable the CMB stylesheet
      // 'closed'     => true, // Keep the metabox closed by default
    ));

    // Regular Image Field
    $cmb_category->add_field(array(
      'name'         => 'Thumbnail file',
      'desc'         => 'Upload an image',
      'id'           => 'flexi_image_category',
      'show_names'   => true, // Show field names on the left
      'type'         => 'file',
      // Optional:
      'options'      => array(
        'url' => false, // Hide the text input for the url
      ),
      'text'         => array(
        'add_upload_file_text' => 'Add Image File', // Change upload button text. Default: "Add or Upload File"
      ),
      // query_args are passed to wp.media's library query.
      'query_args'   => array(
        //'type' => 'application/pdf', // Make library only display PDFs.
        // Or only allow gif, jpg, or png images
        'type' => array(
          'image/gif',
          'image/jpeg',
          'image/png',
        ),
      ),
      'preview_size' => 'medium', // Image size to use when previewing in the admin.
    ));

    $cmb_category->add_field(array(
      'name'       => 'Hide this category',
      'desc'       => 'Category is hidden in forms & list. But contents are visible.',
      'id'         => 'flexi_hide_cate',
      'show_names' => true, // Show field names on the left
      'type'       => 'checkbox',
    ));



    $cmb_category->add_field(array(
      'name'       => 'Link to sub-category',
      'desc'       =>  '<a href="' . admin_url('admin.php?page=flexi_settings&tab=gallery&section=flexi_categories_settings') . '">' . __("Category", "flexi") . '</a> ' . __("page is linked which displays sub-category", "flexi"),
      'id'         => 'flexi_link_sub_cate',
      'show_names' => true, // Show field names on the left
      'type'       => 'checkbox',
    ));

    $cmb_side = new_cmb2_box(array(
      'id'           => 'flexi_metabox_side',
      'title'        => __('Flexi Shortcode', 'flexi'),
      'object_types' => array('flexi'), // Post type
      'context'      => 'side', //  'normal', 'advanced', or 'side'
      'priority'     => 'high',
      'show_names'   => true, // Show field names on the left
      // 'cmb_styles' => false, // false to disable the CMB stylesheet
      // 'closed'     => true, // Keep the metabox closed by default
    ));

    $shortcode = __('Save & reopen to get shortcode', 'flexi');
    try {
      if (isset($_GET['post']) && !is_array($_GET['post'])) {
        $shortcode = '[flexi-standalone id="' . $_GET['post'] . '"]';
      }
    } catch (Exception $e) {
      //Do nothing
    }

    // Regular text field
    $cmb_side->add_field(array(
      'name'        => 'Shortcode for standalone gallery',
      'description' => 'Display gallery of images available only on this post only.<br>No layouts<br>No Settings',
      'id'          => 'flexi_standalone_shortcode',
      'type'        => 'text',
      'default'     => $shortcode,
      'save_field'  => false, // Otherwise CMB2 will end up removing the value.
      'attributes'  => array(
        'readonly' => 'readonly',
        //'disabled' => 'disabled',
      ),
    ));

    $cmb_side->add_field(array(
      'name'              => 'Detail Layout',
      'desc'              => 'Select detail layout',
      'show_option_none'  => '-- ' . __('Default', 'flexi') . ' --',
      'option_none_value' => 'default',
      'id'                => 'flexi_layout',
      'type'              => 'select',
      'show_option_none'  => true,
      'default'           => 'default',
      'options'           => array(
        'basic'   => __('Basic', 'flexi'),
        'complex' => __('Complex', 'flexi'),
      ),
    ));

    // Add edit page select option
    $cmb_side->add_field(array(
      'name'        => 'Edit Page ID',
      'description' => 'Enter page ID of edit form if you want to change default edit form page. Set value to 0 to use default setting.',
      'id'          => 'flexi_new_edit_page',
      'type'        => 'text',
      'default'     => '',
      'attributes' => array(
        'type' => 'number',
        'pattern' => '\d*',
      ),
      'sanitization_cb' => 'absint',
      'escape_cb'       => 'absint',
    ));
  }

  /**
   * Add detail layout selection quick edit screen
   *
   * @param string $column_name Custom column name, used to check
   * @param string $post_type
   *
   * @return void
   */
  public function quick_edit_add($column_name, $post_type)
  {
    if ('flexi_layout' != $column_name) {
      return;
    }
    wp_nonce_field('flexi-nonce', 'flexi-nonce', false);
    $dropdown_args = array(
      'show_option_none'  => '-- ' . __('Default', 'flexi') . ' --',
      'option_none_value' => '',
      'selected'          => '',
      'name'              => 'flexi_layout',
      'id'                => 'flexi_layout',
      'folder'            => 'detail',

    );
    // echo $args['name'] . "--------";
    //var_dump($args);
    echo '<label class="inline-edit-layout alignleft">
  <span class="title">' . __('Detail Layout', 'flexi') . '</span> ';
    echo flexi_layout_list($dropdown_args);
    echo '</label>';
  }

  /**
   * Save quick edit data
   *
   * @param int $post_id
   *
   * @return void|int
   */
  public function save_quick_edit_data($post_id)
  {
    // check user capabilities
    if (!current_user_can('edit_post', $post_id)) {
      return;
    }

    // check nonce
    if (!isset($_REQUEST['flexi-nonce']) || !wp_verify_nonce($_REQUEST['flexi-nonce'], 'flexi-nonce')) {
      return;
    }

    // update the price
    if (isset($_REQUEST['flexi_layout'])) {
      update_post_meta($post_id, 'flexi_layout', $_REQUEST['flexi_layout']);
    }
  }
}

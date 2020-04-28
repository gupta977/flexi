<?php

/**
 * Register Meta Boxes
 */
class Flexi_Meta_boxes
{

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
   if (isset($_GET['post'])) {
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

 }
}

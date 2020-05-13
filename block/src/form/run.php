<?php
/**
 * Register Gutenberg block on server-side.
 *
 * Register the block on server-side to ensure that the block
 * scripts and styles for both frontend and backend are
 * enqueued when the editor loads.
 *
 * @link https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type#enqueuing-block-scripts
 * @since 1.16.0
 */
register_block_type(
 'cgb/block-flexi-block-form', array(
  // Enqueue blocks.style.build.css on both frontend & backend.
  'style'           => 'flexi_block-cgb-style-css',
  // Enqueue blocks.build.js in the editor only.
  'editor_script'   => 'flexi_block-cgb-block-js',
  // Enqueue blocks.editor.build.css in the editor only.
  'editor_style'    => 'flexi_block-cgb-block-editor-css',
  'attributes'      => array(
   'enable_ajax'       => array(
    'type'    => 'boolean',
    'default' => true,
   ),
   'flexi_type'        => array(
    'type'    => 'string',
    'default' => 'image',
   ),
   'form_class'        => array(
    'type'    => 'string',
    'default' => 'pure-form pure-form-stacked',
   ),
   'form_title'        => array(
    'type'    => 'string',
    'default' => 'My Form',
   ),
   'title_label'       => array(
    'type'    => 'string',
    'default' => 'Title',
   ),
   'title_placeholder' => array(
    'type'    => 'string',
    'default' => '',
   ),
   'button_label'      => array(
    'type'    => 'string',
    'default' => 'Submit',
   ),
   'category_label'    => array(
    'type'    => 'string',
    'default' => 'Select Category',
   ),
   'cat'               => array(
    'type'    => 'integer',
    'default' => 0,
   ),
   'tag_label'         => array(
    'type'    => 'string',
    'default' => 'Insert Tag',
   ),
   'desp_label'        => array(
    'type'    => 'string',
    'default' => 'Description',
   ),
   'desp_placeholder'  => array(
    'type'    => 'string',
    'default' => '',
   ),
   'enable_tag'        => array(
    'type'    => 'boolean',
    'default' => false,
   ),
   'enable_desp'       => array(
    'type'    => 'boolean',
    'default' => false,
   ),
   'enable_category'   => array(
    'type'    => 'boolean',
    'default' => false,
   ),
   'enable_file'       => array(
    'type'    => 'boolean',
    'default' => false,
   ),
   'enable_bulk_file'  => array(
    'type'    => 'boolean',
    'default' => false,
   ),
   'file_label'        => array(
    'type'    => 'string',
    'default' => 'Select File',
   ),
   'url_label'         => array(
    'type'    => 'string',
    'default' => 'Insert oEmbed URL',
   ),
   'enable_url'        => array(
    'type'    => 'boolean',
    'default' => false,
   ),
   'enable_security'   => array(
    'type'    => 'boolean',
    'default' => false,
   ),
  ),
  'render_callback' => 'flexi_form_render_callback',
 )
);

function flexi_form_render_callback($args)
{

 // generate the output html
 ob_start();
 $shortcode = '';

/**
 * Use attribute from the block
 */
 if (isset($args['form_class'])) {

  if (isset($args['enable_ajax']) && '1' == $args['enable_ajax']) {
   $enable_ajax = "true";
  } else {
   $enable_ajax = "false";
  }

  if (isset($args['flexi_type']) && 'plain' == $args['flexi_type']) {
   $flexi_type = '';
  } else {
   $flexi_type = 'type="' . $args['flexi_type'] . '"';
  }

  $shortcode .= '[flexi-form class="' . $args['form_class'] . '" title="' . $args['form_title'] . '" name="' . sanitize_title_with_dashes($args['form_title']) . '" ajax="' . $enable_ajax . '" ' . $flexi_type . ']';

  $shortcode .= '[flexi-form-tag type="post_title" title="' . $args['title_label'] . '" value="" placeholder="' . $args['title_placeholder'] . '" required="true"]';

  if (isset($args['enable_category']) && '1' == $args['enable_category']) {
   $shortcode .= '[flexi-form-tag type="category" title="' . $args['category_label'] . '" id="' . $args['cat'] . '"]';
  }

  if (isset($args['enable_tag']) && '1' == $args['enable_tag']) {
   $shortcode .= '[flexi-form-tag type="tag" title="' . $args['tag_label'] . '"]';
  }

  if (isset($args['enable_desp']) && '1' == $args['enable_desp']) {
   $shortcode .= '[flexi-form-tag type="article" title="' . $args['desp_label'] . '" placeholder="' . $args['desp_placeholder'] . '"]';
  }

  if (isset($args['enable_file']) && '1' == $args['enable_file']) {
   if (isset($args['enable_bulk_file']) && '1' == $args['enable_bulk_file']) {
    $shortcode .= '[flexi-form-tag type="file_multiple" title="' . $args['file_label'] . '" class="flexi_drag_file" multiple="true" required="true"]';
   } else {
    $shortcode .= '[flexi-form-tag type="file" title="' . $args['file_label'] . '" required="true"]';
   }

  }

  if (isset($args['enable_url']) && '1' == $args['enable_url']) {
   $shortcode .= '[flexi-form-tag type="video_url" title="' . $args['url_label'] . '" value="" placeholder="eg. https://www.youtube.com/watch?v=uqyVWtWFQkY" required="true" class="pure-input-1"]';
  }

  if (isset($args['enable_security']) && '1' == $args['enable_security']) {
   $shortcode .= '[flexi-form-tag type="captcha" title="Security"]';
  }

  $shortcode .= '[flexi-form-tag type="submit" name="flexi_submit_button" value="' . $args['button_label'] . '"]';

  $shortcode .= '[/flexi-form]';
 }
 //print_r($args);

 echo do_shortcode($shortcode);
 //echo $shortcode;
 if (defined('REST_REQUEST') && REST_REQUEST) {
  echo "<hr><div style='clear:both;border: 1px solid #999; background: #eee'>";
  echo "<ul><li>Preview is for reference and may not view same.
  <li>Below shortcode generated for this page</ul>";
  echo '<code>' . $shortcode . '</code></div>';

  ?>
<link rel='stylesheet' id='flexi_public_css-css'  href='<?php echo FLEXI_PLUGIN_URL; ?>/public/css/flexi-public.css?ver=<?php echo FLEXI_VERSION; ?>' media='all' />

<link rel='stylesheet' id='flexi_purecss_base-css'  href='<?php echo FLEXI_PLUGIN_URL; ?>/public/css/purecss/base-min.css?ver=<?php echo FLEXI_VERSION; ?>' media='all' />
<link rel='stylesheet' id='flexi_purecss_grids-css'  href='<?php echo FLEXI_PLUGIN_URL; ?>/public/css/purecss/grids-min.css?ver=<?php echo FLEXI_VERSION; ?>' media='all' />
<link rel='stylesheet' id='flexi_purecss_responsive-css'  href='<?php echo FLEXI_PLUGIN_URL; ?>/public/css/purecss/grids-responsive-min.css?ver=<?php echo FLEXI_VERSION; ?>' media='all' />
<link rel='stylesheet' id='flexi_purecss_buttons-css'  href='<?php echo FLEXI_PLUGIN_URL; ?>/public/css/purecss/buttons-min.css?ver=<?php echo FLEXI_VERSION; ?>' media='all' />
<link rel='stylesheet' id='flexi_purecss_forms-css'  href='<?php echo FLEXI_PLUGIN_URL; ?>/public/css/purecss/forms-min.css?ver=<?php echo FLEXI_VERSION; ?>' media='all' />
   <?php

 }

 return ob_get_clean();

}

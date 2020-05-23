<?php

/**
 * Settings Form.
 *
 * @link    https://odude.com
 * @since   1.0.0
 *
 * @package Flexi
 */

$active_tab     = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'general';
$active_section = isset($_GET['section']) ? sanitize_text_field($_GET['section']) : '';

$sections = array();
foreach ($this->sections as $section) {
 $tab = $section['tab'];

 if (!isset($sections[$tab])) {
  $sections[$tab] = array();
 }

 $sections[$tab][] = $section;
}
?>

<div id="flexi-settings" class="wrap flexi-settings">
    <h1><?php esc_html_e('Flexi Plugin Settings', 'flexi');?></h1>

    <?php settings_errors();?>

    <h2 class="nav-tab-wrapper">
        <?php
foreach ($this->tabs as $tab => $title) {
 $url = add_query_arg('tab', $tab, admin_url('admin.php?page=flexi_settings'));

 foreach ($sections[$tab] as $section) {
  $url = add_query_arg('section', $section['id'], $url);

  if ($tab == $active_tab && empty($active_section)) {
   $active_section = $section['id'];
  }

  break;
 }

 printf(
  '<a href="%s" class="%s">%s</a>',
  esc_url($url),
  ($tab == $active_tab ? 'nav-tab nav-tab-active' : 'nav-tab'),
  esc_html($title)
 );
}
?>
    </h2>

    <?php
$section_links = array();

foreach ($sections[$active_tab] as $section) {
 $url = add_query_arg(
  array(
   'tab'     => $active_tab,
   'section' => $section['id'],
  ),
  admin_url('admin.php?page=flexi_settings')
 );

 $section_links[] = sprintf(
  '<a href="%s" class="%s">%s</a>',
  esc_url($url),
  ($section['id'] == $active_section ? 'current' : ''),
  esc_html($section['title'])
 );
}

if (count($section_links) > 1): ?>
        <ul class="subsubsub">
            <li><?php echo implode(' | </li><li>', $section_links); ?></li>
        </ul>
        <div class="clear"></div>
    <?php endif;?>

    <form method="post" action="options.php">
        <?php
$page_hook = $active_section;

settings_fields($page_hook);
do_settings_sections($page_hook);

submit_button();
?>
    </form>
</div>
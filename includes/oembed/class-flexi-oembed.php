<?php
class Flexi_oEmbed
{

  public function __construct()
  {
  }


  /***********************************************/
  /* Get a Youtube or Vimeo video's Thumbnail from a URL
/* ODude.com
/* 
/* Copyright 2020, ODude Network
/* 
/***********************************************/
  function get_video_thumbnail($url)
  {
    $image_url = parse_url($url);
    //if($image_url['host'] == 'www.youtube.com' || $image_url['host'] == 'youtube.com')
    if (strpos($image_url['host'], 'youtu') !== false) {

      // Here is a sample of the URLs this regex matches: (there can be more content after the given URL that will be ignored)
      // $url = http://youtu.be/dQw4w9WgXcQ
      // $url = http://www.youtube.com/embed/dQw4w9WgXcQ
      // $url = http://www.youtube.com/watch?v=dQw4w9WgXcQ
      // $url = http://www.youtube.com/?v=dQw4w9WgXcQ
      preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
      return 'https://img.youtube.com/vi/' . $match[1] . '/maxresdefault.jpg';

      //  $array = explode('&', $image_url['query']);
      //  return 'http://img.youtube.com/vi/'.substr($array[0], 2).'/0.jpg';
    } else if ($image_url['host'] == 'www.vimeo.com' || $image_url['host'] == 'vimeo.com') {
      $hash = unserialize(file_get_contents('http://vimeo.com/api/v2/video/' . substr($image_url['path'], 1) . '.php'));
      return $hash[0]['thumbnail_small'];
    } else {
      return '';
    }
  }


  public function getUrlThumbnail($url, $post_id)
  {
    $check_file = ABSPATH . 'wp-includes/class-wp-oembed.php';
    if (file_exists($check_file)) {
      require_once ABSPATH . 'wp-includes/class-wp-oembed.php';
    } else {
      require_once ABSPATH . 'wp-includes/class-oembed.php';
    }
    $oembed = new WP_oEmbed;

    if (!wp_http_validate_url($url)) {
      return FLEXI_ROOT_URL . 'public/images/noimg_thumb.jpg';
    }

    $raw_provider = parse_url($oembed->get_provider($url));

    if (isset($raw_provider['host'])) {

      //$provider = $oembed->discover($url);
      //$video    = $oembed->fetch($provider, $url);

      $video = $this->get_video_thumbnail($url);

      if (isset($video) && '' != $video) {

        if (isset($video)) {
          add_post_meta($post_id, 'flexi_image', $video);
          return $video;
        } else {
          return FLEXI_ROOT_URL . 'public/images/noimg_thumb.jpg';
        }
      } else {
        return FLEXI_ROOT_URL . 'public/images/noimg_thumb.jpg';
      }
    }
  }

  /**
   * Extracts the daily motion id from a daily motion url.
   * Returns false if the url is not recognized as a daily motion url.
   */
  public function getDailyMotionId($url)
  {

    //return 'http://www.dailymotion.com/thumbnail/video/' . $id;

    if (preg_match('!^.+dailymotion\.com/(video|hub)/([^_]+)[^#]*(#video=([^_&]+))?|(dai\.ly/([^_]+))!', $url, $m)) {
      if (isset($m[6])) {
        return $m[6];
      }
      if (isset($m[4])) {
        return $m[4];
      }
      return $m[2];
    }
    return false;
  }
}

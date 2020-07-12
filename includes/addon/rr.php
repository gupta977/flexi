} else {
     $video = $info->media_path($post_id, false);
     //Works only if ffmpeg library install
     if (file_exists(wp_upload_dir()['basedir'] . '/flexi_ffmpeg/vendor/autoload.php')) {
      require wp_upload_dir()['basedir'] . '/flexi_ffmpeg/vendor/autoload.php';
      $upload_dir_paths = wp_upload_dir();
      $image_name       = $post_id . '_thumbnail.gif';
      $new_file         = $upload_dir_paths['path'] . "/" . $image_name; // Create image file name
      $palette_file     = $upload_dir_paths['path'] . "/palette.png"; // Create image file name
      $ffmpegpath       = flexi_get_option('ffmpeg_path', 'flexi_ffmpeg_setting', '/usr/local/bin/ffmpeg');
      //$new_file = 'E:\wampserver\www\wp5/wp-content/uploads/2020/07/xxxxxxxx.gif';

      $ffmpeg = FFMpeg\FFMpeg::create(array(
       'ffmpeg.binaries' => $ffmpegpath,
       'timeout'         => 3600, // The timeout for the underlying process
       'ffmpeg.threads'  => 12, // The number of threads that FFMpeg should use
      ));
      $video = $ffmpeg->open($video);
      //$video->filters()->clip(FFMpeg\Coordinate\TimeCode::fromSeconds(6), FFMpeg\Coordinate\TimeCode::fromSeconds(2));

      $video
       ->gif(FFMpeg\Coordinate\TimeCode::fromSeconds(2), new FFMpeg\Coordinate\Dimension(200, 200), 2)
       ->save_with_high_quality($new_file, $palette_file);
     }

    }

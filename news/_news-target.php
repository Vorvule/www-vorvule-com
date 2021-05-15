<?php

# BBC $pict = (string) $ci->children('media', True)->thumbnail->attributes()['url'];





# Description trimming
foreach ($news as $i=>$news_item) {
    $desc = strip_tags($news_item['desc']);
    $desc = preg_replace('/\s+/', ' ', $desc);
    $desc = trim($desc);
    $news[$i]['desc'] = $desc;
}




# SWITCHED OFF
function crop_pict($news) {
    global $prefix;
    $quan = count($news);
    for ($i = 0; $i < $quan; $i++) {
        if ($news[$i]['type'] == 'video/mp4' or $news[$i]['type'] == 'video/youtube') continue;
        $extension = pathinfo($news[$i]['pict'], PATHINFO_EXTENSION);
        if ($extension == 'jpeg' or
            $extension == 'JPEG' or
            $extension == 'JPG' or
            $extension == 'jpg?v=0'
            ) $extension = 'jpg';
        switch ($extension) {
            case 'jpg' :
                $source_image = imagecreatefromjpeg($news[$i]['pict']);
                break;
            case 'png' :
                $source_image = imagecreatefrompng($news[$i]['pict']);
                break;
            default:
                echo "\n" . 'Unknown image file extension ' . $extension . '<br>' . "\n";
                $source_image = null;
        }
        if (!$source_image) {
            echo "\n" . $news[$i]['name'] . '@'. $i . ' was unset (no source image)' . "\n";
            unset($news[$i]);
            continue;
        }
        if (imagesx($source_image) > 500) {
          $source_image = imagescale($source_image, 490);
        }
        $sizex = imagesx($source_image);
        $sizey = imagesy($source_image);
        $correctx = round($sizey / 1 * 2);
        $correcty = round($sizex / 2 * 1);
        if ($i < 10) $serial = '0' . $i; else $serial = $i;
        if ($correctx < $sizex) {
            $halfx = round(($sizex - $correctx) / 2);
            $cropped_image = imagecrop($source_image, ['x' => $halfx, 'y' => 0, 'width' => $correctx, 'height' => $sizey]);
        } else if ($correcty < $sizey) {
            $halfy = round(($sizey - $correcty) / 2);
            $cropped_image = imagecrop($source_image, ['x' => 0, 'y' => $halfy, 'width' => $sizex, 'height' => $correcty]);
        } else {
            $cropped_image = $source_image;
        }
        $news[$i]['item_thum'] = $prefix . '-' . $serial . '.' . 'jpg';
        save_pict($serial, $cropped_image, 'jpg', '');
        $news[$i]['item_full'] = $prefix . '-' . $serial . '-full' . '.' . 'jpg';
        save_pict($serial, $source_image, 'jpg', '-full');
    }
    $news = array_values($news);
    imagedestroy($cropped_image);
    imagedestroy($source_image);
    save_json($prefix . '-35-crop.json', $news);
    return $news;
}



# SWITCHED OFF
function make_thum($news) {
    global $prefix;
    $quan = count($news);
    
    for ($i = 0; $i < $quan; $i++) {
        
        $destinationimage = imagecreatetruecolor(160, 90);
        $extension = pathinfo($news[$i]['pict'], PATHINFO_EXTENSION);
        if (!$extension) echo "\n" . 'No extension @' . $news[$i]['name'] . 'ext = ' . $extension . '<br>';
        
        switch ($extension) {
          case 'jpg' :
            $source_image = imagecreatefromjpeg('images/' . $news[$i]['pict']);
            break;
          case 'png' :
            $source_image = imagecreatefrompng('images/' . $news[$i]['pict']);
            break;
          default:
            echo "\n" . '<br>unknown image file extension at ' . $i . '<br>';
            continue 2;
        }
     
        imagecopyresampled ( $destinationimage , $source_image , 0 , 0 , 0 , 0 , 160 , 90 , imagesx($source_image) , imagesy($source_image) );

        if ($i < 10) $serial = '0' . $i; else $serial = $i;
        save_pict($serial, $destinationimage, $extension, '-mini');
        imagedestroy($destinationimage);
        
    $news[$i]['thum'] = $prefix . '-' . $serial . '-mini.' . $extension;
    imagedestroy($source_image);
    }
    return $news;
}




# SWITCHED OFF
# TRANSLATION
function tran($news) {
  for ($i = 0; $i < 6; $i++) {
    $prop = explode(' ', $news[$i]['prop']);
    $lang = $prop[1];
    if ($lang == 'be') continue;
    if ($news[$i]['yand']) {
      echo "\n" . 'Translation avoided\n<br>';
      continue;
    }
    # head translation
    $text_option = '&text=' . urlencode($news[$i]['head']);
    $news[$i]['head'] = yandex_translate($text_option, $lang);
    
    # desc translation
    $text_option = '&text=' . urlencode($news[$i]['desc']);
    $news[$i]['desc'] = yandex_translate($text_option, $lang); # HTTP/1.1 400 Bad Request
    
    # mention yandex
    $news[$i]['yand'] = true;
    
    # check up
    $badheadpos = strpos($news[$i]['head'] , 'HTTP/1');
    if ($badheadpos > -1) {
      unset($news[$i]);
      continue;
    }
    $baddescpos = strpos($news[$i]['desc'] , 'HTTP/1');
    if ($baddescpos > -1) unset($news[$i]);
  }
  $news = array_values($news);
}


    switch ($ext) {
        case 'jpg' :
            if (!$imagejpeg) echo "\n" . '<br>jpeg is not saved<br>';
            break;
        case 'png' :
            $imagepng = imagepng($img, '/var/www/a1056901/data/www/vorvule.com/index-news-pictures/' . $prefix . '-' .  $seria . $postfix . '.png', 7);
            if (!$imagepng) echo "\n" . '<br>png is not saved<br>';
            break;
        default:
            echo "\n" . '<br>image is not saved<br>';
    }




    /*
    $final['pict'] = $pict;
    
    for ($i = 0; $i < $quan; $i++) unset($news[$i]);

    save_json($prefix . '.json', $final);
    return $final;
    */

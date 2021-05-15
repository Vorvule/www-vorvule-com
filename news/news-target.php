<?php # supprimer /dev s'ils vous plait

    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    ini_set('memory_limit', '-1');
    date_default_timezone_set('Europe/Minsk');




    if (isset($_GET['prefix'])) $prefix = $_GET['prefix']; # url
    else { # cron
        parse_str($argv[1], $arguments);
        $prefix = $arguments['prefix'];
    }




    include 'news-source.php'; # $sources





    if ($prefix   != 'by-ribbon-be') { # except ribbon
        $processed_source = $sources[$prefix];
        $json_data = create_news_object($processed_source);
      # if ($prefix == 'by-sports-ru') $json_data = limit_by_category($json_data);
        $json_data = sort_news_object($json_data);
        $json_data = limit_news_quantity($json_data);
        $json_data = unset_horoscope_articels($json_data);
        $json_data = clean_news_titles($json_data); # from remarks
        $json_data = return_kept_news($json_data);
        $json_data = parse_image_urls($json_data);
        $json_data = parse_article_paragraphs($json_data);
      # if ($prefix == 'by-common-be') {$json_data = yandex_translate_news($json_data);}
    } else $json_data = []; # own object ribbon would be added
    $json_data = scale_images_down($json_data);
    create_html_page($json_data);
    delete_vain_images($json_data);
    
    echo "\n<br>Spent " . (microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) . '~' . date('Y.m.d-G:i' , time());




function save_news_object($file_path, $object_data) {
    file_put_contents('/var/www/a1056901/data/www/vorvule.com/news/json/' . $file_path, json_encode($object_data));
}



# START
function create_news_object($rss) {
    global $prefix;
    $news = array();
    foreach ($rss as $rss_source) {
        $headers = @get_headers($rss_source[0]); if ($headers[0] == 'HTTP/1.1 404 Not Found') { echo '404 Not Found'; continue; }
        $simple_object = simplexml_load_file($rss_source[0]); if (!$simple_object) { echo $rss_source[0] . ' No Simple Object' . "\n"; continue; }
        $simple_channel = $simple_object -> channel[0];
        $news = array_merge($news, create_object_article_item($rss_source, $simple_channel));
    }
    return $news;
}


function create_object_article_item($rss_source, $simple_channel) {
    $channel_items_quantity = min(count($simple_channel -> item), 60);
    for ($i = 0; $i < $channel_items_quantity; $i++) {
        $channel_item = $simple_channel -> item[$i];
        # channel:
        $item['source_name']         = $rss_source[1]; # Радыё Свабода ..
        $item['article_text_xpath']  = $rss_source[2]; # xpath to article text
        $item['article_image_xpath'] = $rss_source[3]; # xpath to article picture
        # channel item:
        $item['article_link'] = trim((string) $channel_item -> link); # article url
        $item['article_title'] = trim((string) $channel_item -> title);
        $item['article_category'] = trim((string) $channel_item -> category);
        
        $item['article_enclosure_url'] = trim((string) $channel_item -> enclosure['url']);
        $item['article_enclosure_type'] = '';
        $enclosure_type = $channel_item -> enclosure['type']; # image, audio, video
        if ($enclosure_type) $item['article_enclosure_type'] = trim((string) $enclosure_type);
            
        $item['article_unix_stamp'] = strtotime($channel_item -> pubDate); # (string)
        $item['article_text'] = '';
        $item['translated_by_yandex'] = false;

        $channel_news[] = $item;
    }
    return $channel_news;
}




# SORT
function sort_news_object($news) {
    global $prefix;
    
    # create publication dates array out of news array
    $dates = array();
    
    for ($i = 0; $i < count($news); $i++) $dates[$i] = $news[$i]['article_unix_stamp'];
    
    # associative array reverse sort
    arsort($dates);
    
    # sorted array declaration
    $sort = array();
    
    # sorted array creation
    foreach ($dates as $key => $val) $sort[] = $news[$key];
    
    # result
    $news = $sort;
    
    # save_news_object($prefix . '-sort.json', $news);
    return $news;
}




# LIMIT
function limit_news_quantity($news) {
    global $prefix;

    $initial_news_count = count($news);
    $news_quantity_limit = 120;
    for ($i = $news_quantity_limit; $i < $initial_news_count; $i++) unset($news[$i]);
    
    # save_news_object($prefix . '-limit.json', $news);
    return $news;
}




# CLEAN
function unset_horoscope_articels($news) {
    global $prefix;
    
    foreach($news as $i => $news_i) {
        if (mb_stripos($news_i['article_title'], 'гороскоп') > -1) unset($news[$i]);
    }
    
    $news = array_values($news);
    return $news;
}




# TITLES
function clean_news_titles($news) {
    global $prefix;
    
    if ($prefix == 'by-be-common') {
        foreach($news as $i => $news_i) {
            # delete non-breaking spaces
            # $news_i['article_title'] = preg_replace("/\s+/", ' ', $news_i['article_title']);
            
    $desc = strip_tags($news_i['article_title']);
    $desc = preg_replace("/\s+/", ' ', $desc);
    $desc = trim($desc);
    $news_i['article_title'] = $desc;

            
            
            
            # delete remarks
            setlocale (LC_ALL, 'be_BY');
            $news_i['article_title'] = str_ireplace('ВІДЭА',    '', $news_i['article_title']);
            $news_i['article_title'] = str_ireplace('ФОТА',     '', $news_i['article_title']);
            $news_i['article_title'] = str_ireplace('ФОТЫ',     '', $news_i['article_title']);
            $news_i['article_title'] = str_ireplace('ФОТАФАКТ', '', $news_i['article_title']);
            $news_i['article_title'] = str_ireplace('(фота)',   '', $news_i['article_title']);
            $news_i['article_title'] = str_ireplace('(відэа)',  '', $news_i['article_title']);
            $news_i['article_title'] = str_ireplace('(відео)',  '', $news_i['article_title']);
        }
    }
    return $news;
}



# RESTORING ALREADY PROCESSED NEWS
function return_kept_news ($news) {
    global $prefix;
    
    if (file_exists('/var/www/a1056901/data/www/vorvule.com/news/json/' . $prefix . '.json')) {
        $kept_news = file_get_contents('/var/www/a1056901/data/www/vorvule.com/news/json/' . $prefix . '.json');
    } else return $news;
    
    $kept_news = json_decode($kept_news, true);
    
    for($i = 0; $i < count($news); $i++) {
        for($j = 0; $j < count($kept_news); $j++) {
            
            if ($news[$i]['source_name']        == $kept_news[$j]['source_name']   and
                $news[$i]['article_title']      == $kept_news[$j]['article_title'] and
                $news[$i]['article_unix_stamp'] == $kept_news[$j]['article_unix_stamp']
            ) {
                $news[$i]['article_text']           = $kept_news[$j]['article_text'];
                $news[$i]['article_enclosure_url']  = $kept_news[$j]['article_enclosure_url'];
                $news[$i]['article_enclosure_type'] = $kept_news[$j]['article_enclosure_type']; # all the kept images are of type image/jpeg
              # $news[$i]['translated_by_yandex']   = $kept_news[$j]['translated_by_yandex'];
            }
        }
    }
  # save_news_object($prefix . '-kept.json', $news);
    return $news;
}



# PARSE IMAGE URLS
function parse_image_urls($news) {
    global $prefix;

    foreach($news as $i => $news_item) {
        # check
        if ($news_item['article_enclosure_url'] or
            !$news_item['article_image_xpath']
            ) continue;
        if ($news[$i]['article_enclosure_type'] == 'video/mp4' or
            $news[$i]['article_enclosure_type'] == 'video/youtube' or
            $news[$i]['article_enclosure_type'] == 'image/gif'
            ) continue;

        # get DOM
        $page = file_get_contents($news_item['article_link']);
        $dom  = new DOMDocument();
        @$dom -> loadHTML($page);
        
        # get image url
        $xpath = new DOMXpath($dom);
        $image_object = $xpath -> query($news_item['article_image_xpath']) -> item(0);

        if ($image_object) $image_url = $image_object -> value; else continue;
        if (!$image_url or $image_url === NULL or strpos($image_url, 'data:image') > -1) continue;
        
        # add domain name
        switch ($news_item['source_name']) {
            case 'Новы Час' : $image_url = 'http://novychas.by' . $image_url; break;
          # case 'МИД РБ'   : $image_url = 'http://mfa.gov.by'  . $image_url; break;
            case 'Факты'    : $image_url = 'https:'   . $image_url; break; # fakty.ua
          # case 'xSport'   : $image_url = 'https://xsport.ua'  . $image_url; break;
        }
        
        # add 'http:' if absent
        $http_pos  = strpos($image_url, 'http');
        $https_pos = strpos($image_url, 'https');
        if ($http_pos === FALSE and $https_pos === FALSE) $image_url = 'http:' . $image_url;
        
        # set image url and type
        $news[$i]['article_enclosure_url'] = $image_url;
    }
  # save_news_object($prefix . '-images.json', $news);
    return $news;
}




# PARSE TEXTS
function parse_article_paragraphs($news) {
    global $prefix;
    
    foreach ($news as $i => $news_item) {
        # check for kept
        if ($news_item['article_text']) continue;
        
        # create DOM and DOM xpath
        $page  = file_get_contents($news_item['article_link']);
        $dom   = new DOMDocument();
        @$dom  -> loadHTML('<?xml encoding="utf-8" ?>' . $page);
        $xpath = new DOMXpath($dom);
        
        # get paragraphs array
        $article_parpgraphs = $xpath -> query($news_item['article_text_xpath']);
        
        # unset empty articles
        $length = $article_parpgraphs -> length;
        if ($length < 1) {
            echo "\n\n" . $news_item['source_name'] . ' @' . $i  . ' paragraph array length is ' . $length . "\n<br>";
            unset($news[$i]);
            continue;
        }
        
        # form text array
        $text = array();
        for ($j = 0; $j < $length; $j++) {
            $paragraph = trim($article_parpgraphs -> item($j) -> nodeValue);
            $paragraph = preg_replace("/\xEF\xBB\xBF/", "", $paragraph); # Novy Chas
            $paragraph = preg_replace ( "!\s++!u", ' ', $paragraph );    # Sport.Ua / nbsp
            if ($paragraph
                and  strlen($paragraph) > 0
                and $paragraph != '.'
                and !strpos($paragraph, 'swf')
                and !strpos($paragraph, 'function')
                and !strpos($paragraph, '2003-2020')
                and !strpos($paragraph, 'Telegram-канале') # fakty.ua
            ) $text[] = $paragraph;
        }
        
        if ($text) $news[$i]['article_text'] = $text;
        else {
            unset($news[$i]);
            echo "\n\n" . $news_item['source_name'] . ' @' . $i  . ' text array is empty' . "\n<br>";
        }
    }
    $news = array_values($news);
  # save_news_object($prefix . '-text.json', $news);
    return $news;
}




# SCALE AND SAVE IMAGES
function scale_images_down($news) {
    global $prefix;
    
    # ADD VORVULE OWN FEED
    if ($prefix == 'by-ribbon-be') { include 'news-video.php'; $news = array_merge($own_feed, $news); }
    
    # scale iteration
    for ($i = 0; $i < count($news); $i++) {

        # skip vain processing
        if ($news[$i]['article_enclosure_type'] == 'video/mp4' or
            $news[$i]['article_enclosure_type'] == 'video/youtube' or
            $news[$i]['article_enclosure_type'] == 'image/gif' or
            !$news[$i]['article_enclosure_url'] or
            strpos($news[$i]['article_enclosure_url'], $prefix) > -1 # image is already saved
            ) continue;
        
        # delete tails
        $news[$i]['article_enclosure_url'] = preg_replace('/\?v=\d*/', '', $news[$i]['article_enclosure_url']); # '/\?v=\d+/'
        
        # get image extension
        $extension = pathinfo($news[$i]['article_enclosure_url'], PATHINFO_EXTENSION);
        
        # set image extension
        switch ($extension) {
            case 'jpg'  :
            case 'JPG'  :
            case 'jpeg' : $news[$i]['article_enclosure_type'] = 'image/jpeg'; break;
            case 'png'  :
            case 'PNG'  : $news[$i]['article_enclosure_type'] = 'image/png';  break;
            case 'gif'  :
            case 'GIF'  : $news[$i]['article_enclosure_type'] = 'image/gif';  break;
            case 'webp' :
            case 'WEBP' : $news[$i]['article_enclosure_type'] = 'image/webp'; break;
            default     : $news[$i]['article_enclosure_type'] = 'image/jpeg';
                          if ($extension) echo '<br>Unknown extension ' . $extension . '<br>';
        }
        
        # create image from source
        $source_image = '';
        switch ($news[$i]['article_enclosure_type']) {
            case 'image/jpeg' : $source_image = imagecreatefromjpeg($news[$i]['article_enclosure_url']); break;
            case 'image/png'  : $source_image =  imagecreatefrompng($news[$i]['article_enclosure_url']); break;
            case 'image/gif'  : $source_image =  imagecreatefromgif($news[$i]['article_enclosure_url']); break;
            case 'image/webp' : $source_image = imagecreatefromwebp($news[$i]['article_enclosure_url']); break;
        }
        
        if (!$source_image) {
            $news[$i]['article_enclosure_url']  = ''; # possibly unnecessary
            $news[$i]['article_enclosure_type'] = '';
            continue; 
        }
        
        # scale image down
        if (imagesx($source_image) > 475) $source_image = imagescale($source_image, 475);
        
        # create serial
                    $serial = $i;
        if ($i > 9) $serial =  '0' . $serial;
               else $serial = '00' . $serial;
        
        # name image by prefix and serial
        $news[$i]['article_enclosure_url']  = $prefix . '-' . time() . '-' . $serial . '.jpg';
        $news[$i]['article_enclosure_type'] = 'image/jpeg';
        
        # save local image with prefixed name
        imagejpeg($source_image, '/var/www/a1056901/data/www/vorvule.com/news/jpg/' . $news[$i]['article_enclosure_url'], 80);
    }
  # save_news_object($prefix . '-scale.json', $news);
    return $news;
}




# HTML WRAP NEWS FEED
function create_html_page($news) {
    global $prefix;

    for ($i = 0; $i < count($news); $i++) {
        
        # item : start
        $news[$i]['item'] = '<li>';
        
        # head : start
        $news[$i]['item'] .= '<div class="item-head">';
        # head : image or movie
        if ($news[$i]['article_enclosure_url']) {
            switch ($news[$i]['article_enclosure_type']) {
                case 'image/jpeg':
                    $news[$i]['item'] .= '<img src="https://vorvule.com/news/jpg/' . $news[$i]['article_enclosure_url'] . '">';
                    break;
                case 'video/mp4':
                    $news[$i]['item'] .= '<video preload="auto" controls>';
                    $news[$i]['item'] .= '<source src="' . $news[$i]['article_enclosure_url'] . '" type="video/mp4">';
                    $news[$i]['item'] .= '</video>';
                    break;
                case 'video/youtube':
                    $news[$i]['item'] .= '<iframe src="https://www.youtube.com/embed/' . $news[$i]['article_enclosure_url'] . '"></iframe>';
                    break;
                case 'image/gif':
                    $news[$i]['item'] .= '<img src="' . $news[$i]['article_enclosure_url'] . '">';
                    break;
            }
        }
        # head : item film
        $news[$i]['item'] .= '<p ';
        if (!$news[$i]['article_enclosure_url']) $news[$i]['item'] .= 'class="text" ';
        $news[$i]['item'] .= 'onclick="site.item.swap(this.parentElement.parentElement)">';
        $news[$i]['item'] .= $news[$i]['article_title'] . ' &bull; ' . $news[$i]['source_name']; # &#9662; triangle down
        if ($news[$i]['article_category']) $news[$i]['item'] .= '<span class="hide">' . $news[$i]['article_category'] . '</span>';
        $news[$i]['item'] .= '</p>';
        # head : end
        $news[$i]['item'] .= '</div>';
        
        # body : item header
        $capt_html  = '<p class="item-mark" ';
        $capt_html .= 'onclick="site.item.swap(this.parentElement.parentElement)">';
        $capt_html .= mb_strtoupper($news[$i]['article_title']) . ' &bull; ' . mb_strtoupper($news[$i]['source_name']); # &#9652; triangle up
        $capt_html .= '</p>';
        # body : item text
        $text_html  = '';
        foreach ($news[$i]['article_text'] as $paragraph) $text_html .= '<p>' . $paragraph . '</p>';
        
        # body : yandex merit
        # $yand_html = ''; if ($news[$i]['translated_by_yandex']) $yand_html = '<p onclick="window.open(\'http://translate.yandex.ru/\')">Переведено сервисом "Яндекс.Переводчик"</p>';

        # body : item sign
        $sign_html  = '<div class="item-mark" onclick="location.href=\'' . $news[$i]['article_link'] .'\'"><i class="fa fa-share" aria-hidden="true"></i></div>';
        $sign_html .= '<div class="item-mark right" ';
        $sign_html .= 'onclick="site.item.swap(this.parentElement.parentElement)">';
        $sign_html .=  date('d.m.Y', $news[$i]['article_unix_stamp']) . ' &bull; '; # date | &#9656; = right triangle | &bull; | &#9652; up triangle
        
        # Vorvule News
        if ($news[$i]['source_name'] == 'Vorvule') $sign_html .= date('G:i' , time()) . ' &bull;'; # &#9656;
        else $sign_html .= date('G:i', $news[$i]['article_unix_stamp']); # time
        
        $sign_html .= '</div>';
        
        # body : together
        $news[$i]['item'] .= '<div class="item-body">' . $capt_html . $text_html . $sign_html . '</div>'; #  . $yand_html before sign
        # item : end
        $news[$i]['item'] .= '</li>';
    }
    # unite li items
    $item = '';
    foreach ($news as $news_item) $item .= $news_item['item'];
    $item .= '<p class="hide">' . (microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) . '~' . date('Y.m.d~G:i' , time()) . '</p>';
    # add ul tag
    $item = '<ul>'. $item . '</ul>';
    # save html and keep json
    file_put_contents('/var/www/a1056901/data/www/vorvule.com/news/html/' . $prefix . '.html', $item);
    save_news_object($prefix . '.json', $news);
}



       
# DELETE UNUSED IMAGES
function delete_vain_images($news) {
    global $prefix;
    
    # necessary images array
    $necessary_images = [];
    foreach ($news as $news_i) {
        if($news_i['article_enclosure_url'])
            $necessary_images[] = $news_i['article_enclosure_url'];
    }
    
    # jpg folder images array
    $jpg_folder_images = scandir('/var/www/a1056901/data/www/vorvule.com/news/jpg/');
    
    
    # delete vain images
    $deleted_images = [];
    foreach ($jpg_folder_images as $jpg_folder_images_i) {
        # strpos is obvious not to delete images of all the rest feeds
        if ( strpos($jpg_folder_images_i, $prefix) > -1
             &&
             !in_array($jpg_folder_images_i, $necessary_images) ) {
            unlink('/var/www/a1056901/data/www/vorvule.com/news/jpg/' . $jpg_folder_images_i);
            $deleted_images[] = $jpg_folder_images_i;
        }
    }
    /*
    echo '<pre>';
    echo '</pre>';
    print_r($necessary_images);
    echo '<br>';
    */
}








# TRANSLATION: ЛИМИТ НА ОБЪЕМ ПЕРЕВОДИМОГО ТЕКСТА: 1 000 000 СИМВОЛОВ В СУТКИ, НО НЕ БОЛЕЕ 10 000 000 СИМВОЛОВ МЕСЯЦ
function yandex_translate_news($news) {
    # $counter = 0;
    for ($i = 0; $i < count($news); $i++) {
        /*
        if ($news[$i]['source_name'] == 'Ежедневник' and !$news[$i]['translated_by_yandex']) {
            $counter++;
            if ($counter > 2) break;
        } else continue;
        */
        if ($news[$i]['source_name'] != 'Ежедневник') continue;
        # article title translation
        $text_title = '&text=' . urlencode($news[$i]['article_title']);
        $text_title_yand = yandex_translate($text_title, 'ru');
        if ($text_title_yand) $news[$i]['article_title'] = $text_title_yand;
        # article paragraphs translation
        for ($j = 0; $j < count($news[$i]['article_text']); $j++) { # 2
            $text = '&text=' . urlencode($news[$i]['article_text'][$j]);
            $text_yand = yandex_translate($text, 'ru');
            if ($text_yand) $news[$i]['article_text'][$j] = $text_yand;
        }
        # yandex merit
        $news[$i]['translated_by_yandex'] = true;
    }
    return $news;
}
# 2.7. При использовании Сервиса обязательно указание текста «Переведено сервисом «Яндекс.Переводчик» с активной гиперссылкой на http://translate.yandex.ru
# Указание должно быть выполнено шрифтом, размер которого не менее размера шрифта основного текста, и цвет которого не отличается от цвета шрифта основного текста

function yandex_translate($file_path_middle, $lang) {
    # file path formation
    $file_path_start  = 'https://translate.yandex.net/api/v1.5/tr.json/translate?key=';
    $file_path_start .= 'trnsl.1.1.20190509T194446Z.22c606916680640e.cb676ea038b055ba6cbbcee67778eada18f4e3e7'; # my key
    # $file_path_start .= 'trnsl.1.1.20190523T202413Z.caa0a6126eaa7ea1.e27f9d95f0d5f1a3c095dcc35d11f3354413d1fa'; # Olga key
    if ($lang == 'be') return;
    $file_path_end = '&lang=' . $lang . '-be'; # &format=plain&callback=showNews
    $file_path = $file_path_start . $file_path_middle . $file_path_end;
    # get headers to check for HTTP/1.1 400 Bad Request
    $file_headers = @get_headers($file_path);
    $zero_header = $file_headers[0];
    # translation
    if($zero_header == 'HTTP/1.0 200 OK' or $zero_header == 'HTTP/1.1 200 OK') {
        $yandex_response = file_get_contents($file_path);
        $yandex_response = json_decode($yandex_response, true);
        $translation = $yandex_response['article_text'][0];
    } else $translation = '';

    return $translation;
}




# CATEGORY LIMITATION
function limit_by_category($news) {
    global $prefix;
    setlocale (LC_ALL, 'ru_RU');
    echo '<pre>'; var_dump($news); echo '</pre>';
    
        for ($i = 0; $i < count($news); $i++) {
            if ($news[$i]['source_name'] === 'Sputnik') {
                echo $news[$i]['article_category'] . '<br>';
                if (mb_stripos($news[$i]['article_category'], 'Спорт')) continue;
                else {
                    echo $news[$i]['article_category'] . ' - unset<br>';
                    unset($news[$i]);
                }
            }
        }
    $news = array_values($news);
    return $news;
}
?>
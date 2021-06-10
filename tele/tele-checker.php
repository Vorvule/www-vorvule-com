<?php
    # DELETE /dev BELOW

    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
  # ini_set('memory_limit', '-1');
  # date_default_timezone_set('Europe/Minsk');
    
  # CHANNEL ADDRESSES: PREFIX, URL
    $tv_channels = [
        ['by-belsat-be',   'https://www.youtube.com/user/ibelsat'],
        ['de-dw-de',       'https://www.youtube.com/user/deutschewelle'],
        ['de-dw-en',       'https://www.youtube.com/user/deutschewelleenglish'],
        ['eu-euronews-el', 'https://www.youtube.com/user/euronewsGreek'],
        ['eu-euronews-en', 'https://www.youtube.com/user/Euronews'],
        ['eu-euronews-es', 'https://www.youtube.com/user/euronewses'],
        ['eu-euronews-fr', 'https://www.youtube.com/user/euronewsfr'],
        ['eu-euronews-hu', 'https://www.youtube.com/user/euronewsHungarian'],
        ['eu-euronews-it', 'https://www.youtube.com/user/euronewsit'],
        ['eu-euronews-ru', 'https://www.youtube.com/user/euronewsru'],
        ['fr-france24-en', 'https://www.youtube.com/user/france24english'],
        ['fr-france24-es', 'https://www.youtube.com/channel/UCUdOoVWuWmgo1wByzcsyKDQ'],
        ['fr-france24-fr', 'https://www.youtube.com/user/france24'],
        ['gb-skynews-en',  'https://www.youtube.com/user/skynews'],
        ['ru-mir24-ru',    'https://www.youtube.com/user/Mir24tv'],
        ['ru-nv-ru',       'https://www.youtube.com/user/currenttimetv'],
        ['ru-rbc-ru',      'https://www.youtube.com/user/tvrbcnews'],
        ['ua-112-uk',      'https://www.youtube.com/user/112Ukraine'],
        ['ua-24canal-uk',  'https://www.youtube.com/user/news24ru'],
        ['ua-5canal-uk',   'https://www.youtube.com/user/5channel'],
        ['ua-espreso-uk',  'https://www.youtube.com/user/espresotv'],
        ['ua-newsone-uk',  'https://www.youtube.com/channel/UC9oI0Du20oMOlzsLDTQGfug'],
        ['ua-prymay-uk',   'https://www.youtube.com/channel/UCH9H_b9oJtSHBovh94yB5HA'],
        ['us-nbc2-en',     'https://www.youtube.com/user/NBC2swfl'],
    ];

    foreach ($tv_channels as $tv_channel) {
        $channel_file_name = '/var/www/a1056901/data/www/vorvule.com/tele/html/' . $tv_channel[0] . '.html';
        # GET CURRENT LIVE CHANNEL ADDRESS
        $current_file_content = file_get_contents($channel_file_name);
        $current_live_href = substr($current_file_content, 52, 11);
        # GET ACTUAL LIVE CHANNEL ADDRESS
        $tv_channel_content = file_get_contents($tv_channel[1]);
        $actual_live_href = substr($tv_channel_content, strpos($tv_channel_content, 'watch?v=') + 8, 11);

        if ($actual_live_href != $current_live_href) {
            $new_html_content  = '<iframe id="tvf" src="https://www.youtube.com/embed/' . $actual_live_href;
            $new_html_content .= '?autoplay=1" frameborder="0" allow="accelerometer;autoplay;encrypted-media;gyroscope;picture-in-picture" allowfullscreen></iframe>';
            file_put_contents($channel_file_name, $new_html_content);
            echo $tv_channel[0] . ": " . $current_live_href . " => " . $actual_live_href . "\n<br>\n<br>";
        }
    }
    echo 'OK';

  # <a id="thumbnail" class="yt-simple-endpoint inline-block style-scope ytd-thumbnail" aria-hidden="true" tabindex="-1" rel="null" href="/watch?v=fUr4DN6WQr0">
?>
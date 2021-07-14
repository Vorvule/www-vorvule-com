<?php

$sources = array(
# article url
# article name
# article text xpath
# article image xpath

'by-common-be' =>
[
    [
        'https://novychas.by/rss',
        'Новы Час',
        '//div[@class="novychas-article-lead"] | //div[@class="novychas-article-body"]/p[not(@class="novychas-image-caption")] | //div[@class="novychas-article-body"]/a | //div[@class="novychas-article-body"]/text() | //div[@class="novychas-article-body"]/div',
        '//img[@class="img-responsive novychas-image center-block"]/@src',
    ],
    [
        'http://belapan.com/rss/by_free-of-charge_news.xml',
        'БелаПАН',
        '//div[@class="wysiwygContent"]//p',
        '',
    ],
    [
        'https://bel.sputnik.by/export/rss2/archive/index.xml',
        'Sputnik',
        '//div[@class="b-article__text"]/p',
        '',
    ],
    [
        'https://nn.by/?c=rss-all',     
        'Наша Ніва',  
        '//div[@class="article-content" or @class="article__text"]//p[not(@class or .//span)]',
        '//img[@class="jsLazyImage"]/@src',
    ],
],

/*
    https://budzma.by/feed/
    [
        'https://www.svaboda.org/api/zyvqp_eqoopy',
        'Радыё Свабода',
        '//div[@class="wsw"]/p | //div[@class="wsw"]//li | //h2[@class="wsw__h2"]',
        '',
    ],
    [
        'http://www.nbrb.by/RSS/?p=RatesDaily&l=ru',  
        'НБ РБ',
        'description',
        '',
    ],
    [
        'http://zviazda.by/be/feed',
        'Звязда',
        '//div[@class="field-item even"]/p',
        '//div[@class="field-item even"]//img/@src',
    ]
  case 'BYbebs': $z[0][] = 'БелСат'; $z[1][] = 'https://belsat.eu/feed/'; break;
  case 'BYbeid': $z[0][] = 'Часопіс Ідэя'; $z[1][] = 'https://ideaby.org/feed/'; break;
  case 'BYstmi': $z[0][] = 'МИ РБ'; $z[1][] = 'http://mininform.gov.by/rss.php'; break;
*/


'by-common-ru' =>
[
    [
        'https://www.nv-online.info/feed',
        'Народная Воля',
        '//div[@class="td-post-content tagdiv-type"]//p',
        '//div[@class="td-post-featured-image"]//img/@src',
    ],
    [
        'https://news.tut.by/rss/all.rss', 
        'Tut.By', 
        '//div[@id="article_body"]/p',
        '',
    ],
    [
        'http://belapan.com/rss/ru_free-of-charge_news.xml',
        'БелаПАН',
        '//div[@class="wysiwygContent"]//p',
        '',
    ],
    [
        'https://probusiness.io/rss/all.rss',  
        'Про Бизнес',
        '//div[@id="article_body"]/p',
        '',
    ],
    [
        'http://interfax.by/news/feed',  
        'Interfax', 
        '//div[@class="single-news__body typography"]/p',
        '',
    ],
    [
        'https://neg.by/rss',  
        'Экономическая газета',
        '//div[@class="advanced_new_text_container new_text_contents texts"]//p',
        '',
    ],
    [
        'https://realt.by/news/rss.xml',
        'Realt.By',  
        '//div[@class="csc-textpic csc-textpic-center csc-textpic-above"]//p[not(.//strong or .//a)]',
        '//div[@class="inner-center-content"]//img/@src',
    ],
    [
        'http://www.belrynok.by/feed/', 
        'БелРынок', 
        '//div[@class="content content_text"]/p | //div[@class="content content_text"]/ul/li',
        '//div[@class="article_images focuspoint"]//img/@src',
    ],
],
    
/*
    [
        'https://sputnik.by/export/rss2/archive/index.xml', 
        'Sputnik',
        '//div[@class="b-article__text"]/p', 
        '',
    ],
    [
        'http://www.belta.by/rss',
        'БелТА',
        '//div[@class="js-mediator-article"]//p',
        '//div[@class="main_img"]//img/@src',
    ],
    
    case 'BYrunb': $z[0][] = 'Naviny.By'; $z[1][] = 'https://naviny.by/rss/alls.xml'; break;
    
    [
        'http://mfa.gov.by/rss/get/ru_news_mfa.rss', 
        'МИД РБ',
        '//div[@class="h-ugc"]/p',
        '//div[@class="h-ugc"]//img/@src',
    ],
    encrypted ::    [
        'http://www.ej.by/news/news.rss',     
        'Ежедневник',
        '//div[@class="js-text-resize"]/p',
        '',
    ],


'by-econom-ru' =>
[
    [
        'https://news.tut.by/rss/finance.rss', 
        'Tut.By', 
        '//div[@id="article_body"]/p',
        '',
    ],
],


'by-motive-ru' =>
[
    [
        'https://news.tut.by/rss/auto.rss', 
        'Tut.By',
        '//div[@id="article_body"]/p', 
        '',
    ],
],


'by-techno-ru' =>
[
    [
        'https://news.tut.by/rss/it.rss',   
        'Tut.By', 
        '//div[@id="article_body"]/p',
        '',
    ],
],
  case 'BYstan': $z[0][] = 'НАН РБ'; $z[1][] = 'http://nasb.gov.by/rus/news/rss/'; break;
  case 'BYtepk': $z[0][] = 'ПВТ'; $z[1][] = 'http://www.park.by/rss-mixed/ru'; break;


'by-realty-ru' =>
[
    [
        'https://news.tut.by/rss/realty.rss',
        'Tut.By',  
        '//div[@id="article_body"]/p', 
        '',
    ],
    [
        'https://realt.by/news/rss.xml',
        'Realt.By',  
        '//div[@class="csc-textpic csc-textpic-center csc-textpic-above"]//p[not(.//strong or .//a)]',
        '//div[@class="inner-center-content"]//img/@src',
    ],
],


'by-sports-ru' =>
[
    [
        'https://news.tut.by/rss/sport.rss',  
        'Tut.By',
        '//div[@id="article_body"]/p', 
        '',
    ],
],


'by-ru-styles' =>
[
    [
        'https://news.tut.by/rss/afisha.rss',
        'Tut.By',
        '//div[@id="article_body"]/p',
        '',
    ],
    [
        'https://news.tut.by/rss/go.rss',
        'Tut.By',
        '//div[@id="article_body"]/p',
        '',
    ],
    [
        'http://feeds.feedburner.com/ads?format=xml',
        'UDF',
        '//div[@id="zooming"]/a | //div[@id="zooming"]/b | //div[@id="zooming"]/i | //div[@id="zooming"]/text() | //div[@id="zooming"]//div[@class="quote"]/text()',
        '',
    ],
    [
        'https://sputnik.by/export/rss2/archive/index.xml',
        'Sputnik',
        '//div[@class="b-article__text"]/p',
        '', # category Здоровье Общество Стиль жизни и т.д.
    ],
# case 'BY  zp': $z[0][] = 'Зялёны партал'; $z[1][] = 'http://greenbelarus.info/news.xml'; break;
],


'by-ru-region' =>
[
    [
        'http://lidanews.by/news/rss/',
        'Лідская Газета',
        '//article/p | //article/b | //article/text()',
        '',
    ],
    [
        'Гродна.Life',
        'https://hrodna.life/feed',
        '//div[@class="post-content js-mediator-article"]/p',
        '//a[@class="zoom"]/href',
    ],
  case 'BYrecd': $z[0][] = 'CityDog'; $z[1][] = 'https://citydog.by/rss/'; break;
  case 'BYreex': $z[0][] = 'Ex-Press'; $z[1][] = 'https://ex-press.by/rss'; break;
  case 'BYreng': $z[0][] = 'NewGrodno'; $z[1][] = 'https://newgrodno.by/feed/'; break;
  case 'BYreip': $z[0][] = 'Intex-press'; $z[1][] = 'https://www.intex-press.by/feed/'; break;
  case 'BYrerh': $z[0][] = 'Рэгіянальная Газета'; $z[1][] = 'http://www.rh.by/feed/'; break;
  case 'BYrevb': $z[0][] = 'Виртуальный Брест'; $z[1][] = 'http://virtualbrest.by/rss/news.php'; break;
  case 'BYrevv': $z[0][] = 'Віцебская вясна'; $z[1][] = 'http://vitebskspring.org/?format=feed&type=rss'; break;
  case 'BYrewe': $z[0][] = 'Весткі.Info'; $z[1][] = 'http://westki.info/rss.xml'; break;
],

*/





# RUSSIA

'ru-common-ru' =>
[
    [
        'http://kp.ru/rss/allsections.xml',  
        'Комсомольская Правда',
        '//div[@class="styled__Content-sc-1wayp1z-0 styled__ContentBody-sc-1wayp1z-4 dCVjCd"]/p', 
        '',
    ],
    [
        'http://www.utro.ru/export/rss.xml',  
        'Утро.Ru',
        '//div[@class="js-mediator-article io-article-bod"]/p | //div[@class="js-mediator-article io-article-bod"]/h2 | //div[@class="js-mediator-article io-article-bod"]/h3 | //div[@class="js-mediator-article io-article-bod"]//li', 
        '',
    ],
    [
        'https://www.svoboda.org/api/z-pqpiev-qpp',  
        'Радио Свобода',
        '//div[@class="wsw"]/p', 
        '',
    ],
    [
        'https://www.gazeta.ru/export/rss/lastnews.xml',  
        'Газета.Ru',
        '//div[@itemprop="articleBody"]/p', 
        '',
    ],
    [
        'https://lenta.ru/rss/',  
        'Лента.Ru',
        '//div[@itemprop="articleBody"]/p', 
        '',
    ],
    [
        'https://www.znak.com/rss',  
        'Znak',
        '//article//p', 
        '',
    ],
    [
        'https://www.vesti.ru/vesti.rss',  
        'Вести.Ru',
        '//div[@class="js-mediator-article"]/p', 
        '',
    ],
    [
        'https://tvrain.ru/export/rss/all.xml',  
        'Дождь ТВ',
        '//div[@class="document-lead"]/p', 
        '',
    ],
    [
        'http://www.km.ru/xml/rss/main',  
        'Кирилл и Мефодий',
        '//div[@class="text _ga1_on_ _ga3_on_"]/p', 
        '',
    ],
    [
        'http://www.aif.ru/rss/all.php',  
        'Аргументы и Факты',
        '//div[@class="article_text"]/p', 
        '',
    ],
    [
        'https://www.kommersant.ru/RSS/news.xml', # News
        'Коммерсантъ',
        '//div[@class="article_text_wrapper"]/p', 
        '',
    ],
    [
        'https://www.kommersant.ru/RSS/corp.xml', # Corp
        'Коммерсантъ',
        '//div[@class="article_text_wrapper"]/p', 
        '',
    ],
    [
        'https://www.kommersant.ru/RSS/daily.xml', # Daily
        'Коммерсантъ',
        '//div[@class="article_text_wrapper"]/p', 
        '',
    ],
    [
        'https://rg.ru/xml/index.xml',  
        'Российская Газета',
        '//div[@class="b-material-wrapper__lead"]/p | //div[@class="b-material-wrapper__text"]/p', 
        '',
    ],
],





'ru-styles-ru' =>
[
    [
        'https://24smi.org/rss/',  
        '24smi',
        '//article/p', 
        '',
    ],
    [
        'http://www.fashiontime.ru/rss/content.xml',  
        'Fashion Time',
        '//article//p', 
        '',
    ],
    /*
    [
        'http://www.drive.ru/export/rss.xml',  
        'Drive',
        '//p[class="lead"]//text()',
        '//div[class="afigure-pic afigure-pic_main"]//img/@src',
    ],
    [
        'https://www.adme.ru/rss/',  
        'AdMe',
        '//article//p', 
        'media:content url instead of enclosure',
    ],
    */
],





'ru-techno-ru' =>
[
    [
        'https://3dnews.ru/news/rss/',  
        '3DNews',
        '//div[@class="js-mediator-article"]/p', 
        '',
    ],
    [
        'http://www.cnews.ru/inc/rss/news.xml',  
        'CNews',
        '//article[@class="news_container"]//p', 
        '',
    ],
    [
        'https://www.it-world.ru/it-news/?rss=Y',  
        'IT-World',
        '//div[@class="detail"]//p', 
        '',
    ],
    [
        'https://rg.ru/tema/digital/rss.xml',  
        'Российская Газета',
        '//div[@class="b-material-wrapper__lead"]/p | //div[@class="b-material-wrapper__text"]/p', 
        '',
    ],
],


/*

# regione
#  case 'RUrgfn': $z[0][] = '59.ru'; $z[1][] = 'http://59.ru/text/rss.xml?1476446140'; break;
#  case 'RUrgfs': $z[0][] = '47news.ru'; $z[1][] = 'http://47news.ru/rss/articles/'; break;
  case 'RUgaog': $z[0][] = 'Журнал Огонёк'; $z[1][] = 'https://www.kommersant.ru/RSS/ogoniok.xml'; break;

    [
        'https://meduza.io/rss/all',  
        'Медуза',
        '//p[class="SimpleBlock-p SimpleBlock-center"]', 
        '',
        # wrong encoding
    ],
    [
        'https://rg.ru/tema/sila/rss.xml',  
        'Российская Газета',
        '//div[@class="b-material-wrapper__lead"]/p | //div[@class="b-material-wrapper__text"]/p', 
        '',
    ],

'ru-ru-sports' =>
[
    [
        'https://www.sport.ru/rssfeeds/news.rss',  
        'Спорт.Ru',
        '', 
        'media:content url instead of enclosure',
    ],
    [
        'https://www.sport-express.ru/services/materials/news/se/',  
        'Sport-Express',
        '', 
        'no enclosures in rss',
    ],
    [
        'https://www.eurosport.ru/rss.xml',  
        'Eurosport',
        '//div[@class="storyfull__paragraphs"]/p', 
        'no enclosures in rss',
    ],
],
*/




# UKRAINE
'ua-common-uk' =>
[
    [
        'https://rss.unian.net/site/news_ukr.rss',  
        'УНІАН',
        '//div[@class="article "]/h1 | //p[@class="article__like-h2"] | //div[@class="article-text  "]//p[not(@class="article__author--bottom") and not(.//a[@class="read-also gray-bg"])] | //div[@class="article-text  "]//ul/li', # []
        '',
    ],
    [
        'https://gazeta.ua/rss',  
        'Газета.Ua',
        '//article//p[not(@class)]',
        '',
    ],
    [
        'http://day.kyiv.ua/uk/news-rss.xml',  
        'День',
        '//div[@class="field-item even"]//p', 
        '',
    ],
    [
        'https://www.segodnya.ua/ua/xml/rss',  
        'Сегодня',
        '//div[@class="article__body"]/p', 
        '',
    ],
    [
        'https://www.rbc.ua/static/rss/newsline.ukr.rss.xml',  
        'РБК-Україна',
        '//div[@class="publication-sticky-container"]/p[not(.//img)]', # p contains img
        '',
    ],
    [
        'https://ua.interfax.com.ua/news/last.rss',  
        'Інтерфакс',
        '//div[@class="article-content"]/p', 
        '',
    ],
    [
        'https://glavcom.ua/xml/rss.xml',  
        'Главком',
        '//div[@class="body"]/p', 
        '',
    ],
    [
        'https://www.5.ua/novyny/rss',  
        '5 канал',
        '//p', 
        '',
    ],
    [
        'https://www.radiosvoboda.org/api/zrqiteuuir',  
        'Радіо Свобода',
        '//div[@class="wsw"]/p',
        '',
    ],
    /*
    [
        'https://tsn.ua/rss/full.rss',  
        'ТСН',
        '//div[@class="e-content"]/p', 
        '',
    ],
    */
],





'ua-common-ru' =>
[
    [
        'http://ru.tsn.ua/rss/',  
        'ТСН',
        '//div[@class="e-content"]/p[not(.//strong[text()="Читайте также:"])]',
        '',
    ],
    [
        'http://glavred.info/rss',  
        'Главред', # add in ukrainian
        '//div[@class="article__content "]/p[not(.//span[text()="Читайте также"])] | //div[@class="article__body"]/h2', 
        '',
    ],
    [
        'http://www.bagnet.org/rss',  
        'Багнет',
        '//div[@id="bodytext"]/p', 
        '',
    ],
    [
        'https://gazeta.ua/ru/rss',  
        'Газета.Ua',
        '//article//p',
        '',
    ],
    [
        'https://rss.unian.net/site/news_rus.rss',  
        'УНІАН',
        '//div[@class="article-text margin-bottom-0"]//p[not(.//a)] | //div[@class="like-h2"]/text() | //h2[@class="like-p"]/text()', 
        '',
    ],
    [
        'https://interfax.com.ua/news/last.rss',  
        'Інтерфакс',
        '//div[@class="article-content"]/p', 
        '',
    ],
    [
        'https://www.segodnya.ua/xml/rss.xml',  
        'Сегодня',
        '//div[@class="article__body"]/p[not(.//a)]', # not ready
        '',
    ],
    /*
    [
        'https://www.rbc.ua/static/rss/ukrnet.strong.rus.rss.xml',  
        'РБК-Україна',
        '//article[@class="full"]//p',
        '',
    ],
    */
],
'ua-sports-uk' =>
[
    [
        'https://fakty.ua/rss_feed/sport',  
        'Факты', # russian language
        '//div[@id="article_content3"]/p[not(.//em[text()="Фото Instagram " or text()="Фото Instagram" or text()="Фото Facebook "])]',
        '//div[@class="foto_zag3"]/img/@src',
    ],
    [
        'https://www.rbc.ua/static/rss/ukrnet.sport.ukr.rss.xml',  
        'РБК-Україна',
        '//div[@class="publication-sticky-container"]/p[not(.//img)]', # p contains img
        '',
    ],
    [
        'http://sport.ua/rss/all',  
        'Спорт.Ua', # russian language
        '//div[@id="news_text"]/p[not(.//a)]', 
        '',
    ],
    /*
    [
        'http://xsport.ua/rss/',  
        'xSport', # russian language
        '//div[@class="detail-text-holder"]/p | //div[@class="detail-text-holder"]/h2', 
        '//div[@class="news-full-text__detail-photo"]/div/img/@src',
    ],
    [
        'https://www.liga.net/news/sport/rss.xml',
        'Ліга', # low res
        '//div[@id="news-text"]/p',
        '//div[@class="top-img"]/img/@src',
    ],
    */
],






'ua-econom-uk' =>
[
    [
        'https://www.rbc.ua/static/rss/ukrnet.economic.ukr.rss.xml',
        'РБК-Україна',
        '//div[@class="publication-sticky-container"]/p[not(.//img)]', # p contains img
        '',
    ],
    [
        'https://www.radiosvoboda.org/api/zvpk_eo-kt',
        'Радіо Свобода',
        '//div[@class="wsw"]/p',
        '',
    ],
    [
        'http://k.img.com.ua/rss/ua/economics.xml',
        'Корреспондент',
        '//div[@class="post-item__text"]/h2 | //div[@class="post-item__text"]/div[not(.//script)] | //div[@class="post-item__text"]/p',
        '//div[@class="post-item__photo clearfix"]/img/@src',
    ],
    [
        'http://k.img.com.ua/rss/ua/business.xml',
        'Корреспондент',
        '//div[@class="post-item__text"]/h2 | //div[@class="post-item__text"]/div[not(.//script)] | //div[@class="post-item__text"]/p',
        '//div[@class="post-item__photo clearfix"]/img/@src',
    ],
],



/*
https://112.ua/rss/index.rss
https://ua.112.ua/rsslist

business
case 'UAbulg': $z[0][] = 'Ліга'; $z[1][] = 'https://www.liga.net/biz/all/rss.xml'; break; # low res
case 'UAbutr': $z[0][] = 'Trust.Ua'; $z[1][] = 'http://www.trust.ua/files/xml/rss.xml'; break; // low res
case 'UAbunv': $z[0][] = 'Новое Время'; $z[1][] = 'https://nv.ua/ukr/rss/2292.xml'; break; # low res

#  marquee uk
#  case 'UAuktf': $z[0][] = '24TV'; $z[1][] = 'https://24tv.ua/rss/all.xml'; break; # no pics, tags debris; split at first dot
#  case 'UAukkr': $z[0][] = 'Корреспондент'; $z[1][] = 'http://k.img.com.ua/rss/ua/all_news2.0.xml'; break; # low res photos
#  case 'UAukup': $z[0][] = 'Українська правда'; $z[1][] = 'https://www.pravda.com.ua/rss/'; break;
#  case 'UAukun': $z[0][] = 'УНН'; $z[1][] = 'http://www.unn.com.ua/rss/news_uk.xml'; break; # low res photos
#  case 'UAukcn': $z[0][] = 'Цензор.Net'; $z[1][] = 'https://censor.net.ua/includes/news_uk.xml'; break; # low res photos

#  marquee ru
#  case 'UAruup': $z[0][] = 'Українська правда'; $z[1][] = 'https://www.pravda.com.ua/rus/rss/'; break; # no photos
#  case 'UArust': $z[0][] = 'Страна'; $z[1][] = 'https://strana.ua/xml/rss.xml'; break; # headers only
# https://www.unn.com.ua/rss/news_ru.xml lowres photos
# http://k.img.com.ua/rss/ru/news.xml Korrespondent low
# https://kp.ua/rss/feed.xml lowres
# http://mignews.com.ua/rss.xml # very low
# https://fakty.ua/rss_feed/all # text only
# http://ukr-today.com/rss.xml # few news on weekends (5)
# http://vkurse.ua/rss/ # text only
# http://www.ua3000.info/rss/rss.xml # trash
*/

# array
);
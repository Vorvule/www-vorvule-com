<?php
  # echo json_encode(unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $_SERVER['REMOTE_ADDR'])));
  $geo_array = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $_SERVER['REMOTE_ADDR']));
  echo strtolower($geo_array['geoplugin_countryCode']);  
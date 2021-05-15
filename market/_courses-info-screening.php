<?php
  include 'search-courses-list.php';
  
/*
  echo '<pre>';
  var_dump($courses);
  echo '</pre>';
 */
 
  foreach ($courses as $school) {
    echo '<a href="' . $school['href'] . '">' . $school['name'] . '</a><br>';
    foreach ($school['labs'] as $labs) {
      echo $labs['cost'] . '<br>';
    }
  }
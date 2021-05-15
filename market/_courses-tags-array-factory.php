<?php

    include 'search-courses-list.php';

    foreach($courses as $school) {
        $labs = $school['labs'];
        foreach($labs as $course) {
            $tags = $course['tags'];
            $tags = str_replace(',', '', $tags);
            $tagsArray = explode(' ', $tags);
            foreach($tagsArray as $item) {
                if ($item != '' or $item != ' ') $tagsOutputArray[] = $item;
            }
            $tagsOutputArray = array_unique($tagsOutputArray);
        }
    }
    
    sort($tagsOutputArray);
    echo '<pre>';
    print_r($tagsOutputArray);
    echo '</pre>';
      

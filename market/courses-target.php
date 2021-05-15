<?php
    # Delete dev/ on release

    include 'courses-source.php';
    
    
    # Make courses array out of Schools object included
    $course_array = array();
    foreach($schools as $school) {
        foreach($school['labs'] as $course) {
            $course['logo'] = $school['logo']; # add logo name to course object
            $course['schl'] = $school['name']; # add school name to course object
            $course_array[] = $course;
        }
    }
    
    
    # Sort courses names
    $courses_names_array = array();
    foreach($course_array as $course) { $courses_names_array[] = $course['name']; }
    
    asort($courses_names_array);
    
    $sorted_courses_array = array();
    foreach ($courses_names_array as $key => $val) $sorted_courses_array[] = $course_array[$key];
    
    
    # Make html page    
    $feed = '<ul>';
    foreach($sorted_courses_array as $course) {
        
        # item : start
        $feed .= '<li>';
        
        # head : start
        $feed .= '<div class="item-head">';
        
        # head : image
        $feed .= '<img src="https://vorvule.com/dev/market/logo/' . $course['logo'] . '">';
        
        # head : item caption
        $feed .= '<p onclick="site.item.swap(this.parentElement.parentElement)">Курс ' . $course['name'];
        
        $feed .= '<br><span style="padding-left:24px">' . $course['schl'] . ' &#9662;' . '</span><br>';
        
        $feed .= '<span style="display:none">' . $course['tags'] . '</span>';
        $feed .= '</p>';
        
        # head : end
        $feed .= '</div>';
        
        # body : start
        $feed .= '<div class="item-body">';

        # body : item caption
        $feed .= '<p class="item-mark" ';
        $feed .= 'onclick="site.item.swap(this.parentElement.parentElement)">КУРС ';
        $feed .= mb_strtoupper($course['name']) . ' &#9652;';
        $feed .= '</p>';
        
        # body : item text
        $feed .= '<p>Срок обучения ' . $course['term'] . '</p>';
        $feed .= '<p>Стоимость ' . $course['cost'] . '</p>';
        
        # body : item tags
        $feed .= '<p class="marked">ТЕГИ</p>';
        $tag_array = explode(',', $course['tags']);
        foreach($tag_array as $tag) { $tag = trim($tag); }
        asort($tag_array);
        foreach($tag_array as $tag) { $feed .= '<p>' . $tag . '</p>'; }
        
        # body : item sign
        $feed .= '<p class="item-mark" onclick="location.href=\'' . $course['href'] . '\'">';
        $feed .= 'Программа курса | ' . $course['schl'] . ' &#9656;</p>';
        
        # body : end
        $feed .= '</div>';
        
        # item : end
        $feed .= '</li>';
    }
    
    $feed .= '</ul>';

    file_put_contents('/var/www/a1056901/data/www/vorvule.com/dev/market/html/services-courses-ru.html', $feed);
    echo 'OK )';
?>
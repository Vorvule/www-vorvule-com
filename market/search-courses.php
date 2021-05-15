<?php
  # Поиск курсов по тегам
  include 'search-courses-list.php';
  $inputRequest = $_REQUEST['inputRequest'];
  $coursesArray = '';
  $outputString = '';

  if ($inputRequest !== '') {
      $inputRequest = strtolower($inputRequest);
      $len = strlen($inputRequest);
      foreach($courses as $school) {
          $labs = $school['labs'];
          foreach($labs as $course) {
              $tags = $course['tags'];
              if (stristr($tags, $inputRequest)) {
                $course['schl'] = $school['plus'] . $school['name'];
                $coursesArray[] = $course;
              }
          }
      }
  }
  
  # Change list for table:
  # Course school
  # Course name
  # Course term
  # Course cost
  
  foreach($coursesArray as $item) {
    $outputString .= '<li>';
    $outputString .= '<div onclick="location.href=\'' . $item['href'] . '\'">' . mb_strtoupper($item['name']) . '</div>';
    $outputString .= '<div>Срок ' . $item['term'] . '</div>';
    $outputString .= '<div>Цена ' . $item['cost'] . '</div>';
    $outputString .= '<div>' . $item['schl'] . '</div>';
    $outputString .= '</li>';
  }

  echo $outputString === '' ? '<li>Мы не нашли таких курсов</li>' : '<ul class="market">' . $outputString . '</ul>';
?>
<?php

  $Name = $Email = $Subject = $Comment = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Name = test_input($_POST["Name"]);
    $Email = test_input($_POST["Email"]);
    $Subject = test_input($_POST["Subject"]);
    $Comment = test_input($_POST["Comment"]);
  }
  
  if (!$Name && !$Email && !$Subject && !$Comment) exit();

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  $to = '7105690@gmail.com';
  $subject = 'Vorvule.com: піша ' . $Name;
  $message = '
  <p>Імя: ' . $Name . '</p>
  <p>E-mail: ' . $Email . '</p>
  <p>Тэма: ' . $Subject . '</p>
  <p>Допіс: ' . $Comment . '</p>
  ';
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $headers .= 'From: ' . $Email . "\r\n";
  $headers .= 'Reply-To: ' .$Email . "\r\n";
  $headers .= 'X-Mailer: PHP/' . phpversion();
  mail($to, $subject, $message, $headers);
  
  echo true;
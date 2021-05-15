<?php

    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    
    
    if (substr($_SERVER['REMOTE_ADDR'], 0, 7) == '46.216.') exit();
    
    # new line
    $appended_line = "\r\n" .
        date('Y.m.d-G:i' , $_SERVER['REQUEST_TIME']) . ' | ' .
        $_SERVER['REMOTE_ADDR'] . ' | ' .
        detect_user_agent($_SERVER['HTTP_USER_AGENT']) . ' | ' .
        # $_SERVER['QUERY_STRING'] . ' | ' .
        $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    file_put_contents('data.php', $appended_line, FILE_APPEND);
    
    function detect_user_agent($user_agent_data) {
        if (strpos($user_agent_data, 'OPR') > -1) return 'Opera';
        if (strpos($user_agent_data, 'Edge') > -1) return 'Edge';
        if (strpos($user_agent_data, 'Firefox') > -1) return 'Firefox';
        
        if (strpos($user_agent_data, 'Aviator') > -1) return 'Aviator';
        if (strpos($user_agent_data, 'ChromePlus') > -1) return 'ChromePlus';
        if (strpos($user_agent_data, 'coc_') > -1) return 'coc_';
        if (strpos($user_agent_data, 'Dragon') > -1) return 'Dragon';
        if (strpos($user_agent_data, 'Flock') > -1) return 'Flock';
        if (strpos($user_agent_data, 'Iron') > -1) return 'Iron';
        if (strpos($user_agent_data, 'Kinza') > -1) return 'Kinza';
        if (strpos($user_agent_data, 'Maxthon') > -1) return 'Maxthon';
        if (strpos($user_agent_data, 'MxNitro') > -1) return 'MxNitro';
        if (strpos($user_agent_data, 'Nichrome') > -1) return 'Nichrome';
        if (strpos($user_agent_data, 'Perk') > -1) return 'Perk';
        if (strpos($user_agent_data, 'Rockmelt') > -1) return 'Rockmelt';
        if (strpos($user_agent_data, 'Seznam') > -1) return 'Seznam';
        if (strpos($user_agent_data, 'Sleipnir') > -1) return 'Sleipnir';
        if (strpos($user_agent_data, 'Spark') > -1) return 'Spark';
        if (strpos($user_agent_data, 'UBrowser') > -1) return 'UBrowser';
        if (strpos($user_agent_data, 'Vivaldi') > -1) return 'Vivaldi';
        if (strpos($user_agent_data, 'WebExplorer') > -1) return 'WebExplorer';
        if (strpos($user_agent_data, 'YaBrowser') > -1) return 'Yandex';
        
        return 'Chrome';
    }

?>
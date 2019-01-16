<?php


//For iOS

    if ((strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile/') !== false) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/') == false) {
        echo 'WebView';
    } else{
        echo 'Not WebView';
    }

//For Android

    if ($_SERVER['HTTP_X_REQUESTED_WITH'] == "com.company.app") {
        echo 'WebView';
    } else{
        echo 'Not WebView';
    }
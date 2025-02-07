<?php

$requesUri = $_SERVER['REQUEST_URI'];
$requestMethod  = $_SERVER['REQUEST_METHOD'];

if ($requesUri === '/profile') {
    if ($requestMethod === 'GET') {
        require_once './profile.php';
    } elseif ($requestMethod === 'POST') {
        require_once './profile.php';
    }
}elseif ($requesUri === '/editedProfile') {
        if ($requestMethod === 'GET') {
            require_once './FORMeditedProfile.php';
        } elseif ($requestMethod === 'POST') {
            require_once './profileEDITED.php';
        }
} elseif ($requesUri === '/registration') {
    if ($requestMethod === 'GET') {
        require_once './registration_form.php';
    } elseif ($requestMethod === 'POST') {
        require_once './registration.php';
    }

}elseif ($requesUri === '/login') {
    if ($requestMethod === 'GET') {
        require_once './login_form.php';
    } elseif ($requestMethod === 'POST') {
        header( 'location: http://localhost:81/catalog');
    }
} elseif ($requesUri === '/catalog') {
    if ($requestMethod === 'GET') {
        require_once './catalog.php';
    } elseif ($requestMethod === 'POST') {
        require_once './catalog.php';
    }
}
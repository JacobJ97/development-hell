<?php

$server_request = $_GET['site-page'];

if (empty($server_request)) {
    include_once($_SERVER['DOCUMENT_ROOT'] . "../files/includes/pages/home.php");
}
else {
    $all_webpages = scandir($_SERVER['DOCUMENT_ROOT'] . "../files/includes/pages/", 1);

    foreach ($all_webpages as &$page) {
        $page = str_replace(".php", "", $page);
    }

    $all_webpages = array_diff($all_webpages, [".", "..", "home"]);
    $num_of_webpages = count($all_webpages);

    for ($i = 0; $i < $num_of_webpages; $i++) {
        switch($server_request) {
            case $all_webpages[$i]:
                include_once($_SERVER['DOCUMENT_ROOT'] . "../files/includes/pages/" . $all_webpages[$i] . ".php");
                break;

        }
    }
}


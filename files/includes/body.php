<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "../files/includes/User.php");
$user = new User();
$server_request = $_GET['site-page'];

if (empty($server_request)) {
    include_once($_SERVER['DOCUMENT_ROOT'] . "../files/includes/pages/home.php");
}
else {
    $role = $user->check_user_role($user->get_user());
    if ($role == "admin") {
        $all_webpages = array_merge(scandir($_SERVER['DOCUMENT_ROOT'] . "../files/includes/admin/", 1), scandir($_SERVER['DOCUMENT_ROOT'] . "../files/includes/pages/", 1));
    } else {
        $all_webpages = scandir($_SERVER['DOCUMENT_ROOT'] . "../files/includes/pages/", 1);
    }

    foreach ($all_webpages as &$page) {
        $page = str_replace(".php", "", $page);
    }

    $is_admin = substr($server_request, 0, 5) === "admin";

    $all_webpages = array_diff($all_webpages, [".", "..", "home"]);
    $all_webpages = array_values($all_webpages);
    $num_of_webpages = count($all_webpages);

    for ($i = 0; $i < $num_of_webpages; $i++) {
        switch($server_request) {
            case $all_webpages[$i]:
                if ($all_webpages[$i] == "login") {
                    $_SESSION['js_loaded'] = "login";
                }
                elseif ($all_webpages[$i] == "survey") {
                    $_SESSION['js_loaded'] = "survey";
                }
                elseif ($all_webpages[$i] == "update") {
                    $_SESSION['js_loaded'] = "update";
                }

                if ($is_admin) {
                    include_once($_SERVER['DOCUMENT_ROOT'] . "../files/includes/admin/" . $all_webpages[$i] . ".php");
                    break;
                }
                else {
                    include_once($_SERVER['DOCUMENT_ROOT'] . "../files/includes/pages/" . $all_webpages[$i] . ".php");
                    break;
                }
            break;
        }
    }
    //die("file not valid");
}


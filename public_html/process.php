<?php

header('Content-type: application/json');

$name = $_POST['pname'];
$gender = $_POST['gender'];
$age = $_POST['age'];
$fav_pony = $_POST['favpony'];
$location = $_POST['location'];

$id = $_POST['id'];

if (!$location) {
    $location = "NULL";
}

if (empty($name) || empty($gender) || empty($age) || empty($fav_pony)) {
    $response_array['status'] = 'failure';
    $response_array['reason'] = 'One or more required fields are empty.';
}

include_once($_SERVER['DOCUMENT_ROOT'] . "../files/includes/Database.php");
$db = new Database();

if ($_POST['form-action'] === 'delete_row') {
    $response_array = $db->remove_data($id);
} else {
    if (!$id) {
        $response_array = $db->send_data([$name, $gender, $age, $fav_pony, $location]);
    } else {
        $response_array = $db->update_data([$name, $gender, $age, $fav_pony, $location], $id);
    }
}

echo json_encode($response_array);










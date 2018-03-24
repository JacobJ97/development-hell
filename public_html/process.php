<?php

//if(count(get_included_files()) ==1) exit("Direct access not permitted.");

header('Content-type: application/json');

$name = $_POST['pname'];
$gender = $_POST['gender'];
$age = $_POST['age'];
$fav_pony = $_POST['favpony'];
$location = $_POST['location'];
$id = $_POST['id'];

include_once($_SERVER['DOCUMENT_ROOT'] . "../files/includes/Database.php");
$db = new Database();

switch ($_POST['form-action']) {
    case 'update_row':
        $response_array = $db->update_data([$name, $gender, $age, $fav_pony, $location], $id);
        break;
    case 'delete_row':
        $response_array = $db->remove_data($id);
        break;
    case 'add_survey':
        if (empty($name) || empty($gender) || empty($age) || empty($fav_pony)) {
            $response_array['status'] = 'failure';
            $response_array['reason'] = 'One or more required fields are empty.';
        } else {
            if (!$location) {
                $location = "NULL";
            }
            $response_array = $db->send_data([$name, $gender, $age, $fav_pony, $location]);
        }
        break;
    case 'password':
        $username = $_POST['username'];
        $password = $_POST['password'];

        //echo "password";
}

echo json_encode($response_array);










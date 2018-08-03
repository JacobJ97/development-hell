<?php
session_start();

header('Content-type: application/json');

/* Pointless security over obscurity check, lol
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest')
{
    die("Direct access not permitted.");
}*/

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
        $array_of_titles = ["name", "gender", "age", "pony", "location"];
        $updated_new_data = [$name, $gender, $age, $fav_pony, $location];
        $response_array = $db->update_data(["Demographics"], [$array_of_titles], [$updated_new_data], [$id]);
        break;
    case 'delete_row':
        $response_array = $db->remove_data("Demographics", $id);
        break;
    case 'add_survey':
        if (empty($name) || empty($gender) || empty($age) || empty($fav_pony)) {
            $response_array['status'] = 'failure';
            $response_array['reason'] = 'One or more required fields are empty.';
        } else {
            if (!$location) {
                $location = "NULL";
            }
            $array_of_titles = ["name", "gender", "age", "pony", "location"];
            $db->table_exists("Demographics", $array_of_titles);
            $array_of_values = [$name, $gender, $age, $fav_pony, $location];
            $response_array = $db->send_data(["Demographics"], [$array_of_titles], [$array_of_values], $_POST['form-action']);
        }
        break;
    case 'password':
        $username = $_POST['puname1'];
        $password = $_POST['pword2'];

        $array_of_titles = ["User", "Hash"];
        $db->table_exists("Details", $array_of_titles);
        $array_of_titles2 = ["User", "Fname", "Lname", "userEmail", "Description"];
        $db->table_exists("Users", $array_of_titles2);
        $array_of_values = [$username];

        if (isset($_POST['ncheck3'])) {
            $hash = $db->hash_data($password);
            $array_of_values[] = $hash;
            $array_of_values2 = [$username, "", "", "", ""];
            $response_array = $db->send_data(["Details", "Users"], [$array_of_titles, $array_of_titles2], [$array_of_values, $array_of_values2], $_POST['form-action']);
        }
        else {
            $array_of_values[] = $password;
            $response_array = $db->verify_data("Details", $array_of_values);
        }

        if ($response_array['status'] === 'successful') {
            $_SESSION['loggedIn'] = true;
            $_SESSION['userName'] = $username;
        }
}
$db->disconnect();

echo json_encode($response_array);
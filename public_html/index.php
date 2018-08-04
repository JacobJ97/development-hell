<?php session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . "../files/includes/Database.php");
$db = new Database();
$array_of_titles = ["User", "Hash"];
$db->table_exists("Details", $array_of_titles);
$array_of_titles2 = ["User", "Role", "Fname", "Lname", "userEmail", "Description"];
$db->table_exists("Users", $array_of_titles2);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once($_SERVER['DOCUMENT_ROOT'] . "../files/includes/headings.php") ?>
</head>
<body>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . "../files/includes/nav.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "../files/includes/body.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "../files/includes/scripts.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "../files/includes/footer.php") ?>
</body>
</html>
<?php
class User {
    protected $db;

    function __construct() {
        include_once($_SERVER['DOCUMENT_ROOT'] . "../files/includes/Database.php");
        $this->db = new Database();
    }

    function get_user() {
        if (empty($_SESSION['userName']) && !isset($_SESSION['userName'])) {
            return "guest";
        }
        else {
            return $_SESSION['userName'];
        }
    }

    function check_user_role($username) {
        $data = $this->db->get_data("Users");
        for ($i = 0; $i < $data[1]; $i++) {
            $stored_username = $data[0][$i][1];
            if ($stored_username === $username) {
                return $data[0][$i][2];
            }
        }
        return "guest";
    }
}
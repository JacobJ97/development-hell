<?php
class Database {

    protected $mysqli;

    function __construct() {
        $this->mysqli = new mysqli("192.168.33.10", 'user', 'password', 'test');
    }

    function disconnect() {
        $this->mysqli->close();
    }

    function get_data() {
        $result = $this->mysqli->query("SELECT * FROM Demographics");
        $result_array = $result->fetch_all();
        $array_count = count($result_array);
        $this->disconnect();

        return [$result_array, $array_count];
    }

    function send_data($array_of_data) {
        $result = $this->mysqli->query("INSERT INTO `Demographics` (`name`, `gender`, `age`, `pony`, `location`) VALUES ('$array_of_data[0]', '$array_of_data[1]', '$array_of_data[2]', '$array_of_data[3]', '$array_of_data[4]')");
        $this->disconnect();
        return $this->response($result, "sent");
    }

    function update_data($array_of_new_data, $id) {
        $result = $this->mysqli->query("UPDATE `Demographics` SET `name` ='$array_of_new_data[0]', `gender`='$array_of_new_data[1]', `age`='$array_of_new_data[2]', `pony`='$array_of_new_data[3]', `location`='$array_of_new_data[4]' WHERE `id_pone` = $id");
        $this->disconnect();
        return $this->response($result, "updated");
    }


    function remove_data($id) {
        $result = $this->mysqli->query("DELETE FROM `Demographics` WHERE  `id_pone` = $id");
        return $this->response($result, "deleted");
    }

    function response($result, $message) {
        if ($result) {
            $response_array['status'] = 'successful';
            $response_array['reason'] = 'The row has successfully been ' .  $message . '.';
        }
        else {
            $response_array['status'] = 'failure';
            $response_array['reason'] = 'The row has unsuccessfully been ' .  $message . '.';
        }

        return $response_array;
    }
}

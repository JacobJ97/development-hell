<?php
class Database {

    protected $mysqli;

    function __construct() {
        $this->mysqli = new mysqli("192.168.33.10", 'user', 'password', 'test');
    }

    function disconnect() {
        $this->mysqli->close();
    }

    function table_exists($table_name, $table_details) {
        $query = "";
        $tables = $this->mysqli->query("SELECT * FROM information_schema.tables");

        foreach ($tables as $table) {
            if ($table === $table_name) {
                return;
            }
        }

        $counter = 0;
        $detail_count = count($table_details);
        foreach($table_details as $detail) {
            if ($detail_count - $counter === 1) {
                $query .= $detail . ")";
            }
            else {
                $query .= $detail . ", ";
            }
            $counter++;
        }

        $this->mysqli->query("CREATE TABLE $table_name (id int(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, " . $query);
    }

    function query_builder($table_name, $array_of_titles, $array_of_values) {
        $query = "INSERT INTO $table_name (";
        $aot_count = count($array_of_titles);
        $aov_count = count($array_of_values);
        for ($i = 0; $i < $aot_count; $i++) {
            $title = $array_of_titles[$i];
            if ($aot_count - $i !== 1) {
                $query .= "$title, ";
            }
            else {
                $query .= "$title)";
            }
        }

        $query .= "VALUES (";

        for ($j = 0; $j < $aov_count; $j++) {
            $value = $array_of_values[$j];
            if ($aov_count - $j !== 1) {
                $query .= "'$value', ";
            }
            else {
                $query .= "'$value')";
            }
        }

        return $query;
    }

    function get_data($table_name) {
        $result = $this->mysqli->query("SELECT * FROM " . $table_name);
        $result_array = $result->fetch_all();
        $array_count = count($result_array);
        $this->disconnect();

        return [$result_array, $array_count];
    }

    function send_data($table_name, $array_of_titles, $array_of_values) {
        $query = $this->query_builder($table_name, $array_of_titles, $array_of_values);
        $result = $this->mysqli->query($query);
        $this->disconnect();
        return $this->response("add", $result, "sent");
    }

    function hash_data($password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        return $hash;
    }

    function verify_data($table_name, $array_of_values) {
        $result_array = $this->get_data($table_name);
        $ra_count = count($result_array);
        for ($i = 0; $i < $ra_count; $i++) {
            if ($result_array[0] === $array_of_values[0]) {
                for ($j = 0; $i < $ra_count; $i++) {
                    $stored_hash = $result_array[1];
                    $password = $array_of_values[1];
                    if (password_verify($password, $stored_hash)) {
                        return $this->response("login", true, "correct");
                    }
                }
                return $this->response("login", false, "incorrect");
            }
        }
        return $this->response("login", false, "incorrect");
    }

    function update_data($array_of_new_data, $id) {
        $result = $this->mysqli->query("UPDATE `Demographics` SET `name` ='$array_of_new_data[0]', `gender`='$array_of_new_data[1]', `age`='$array_of_new_data[2]', `pony`='$array_of_new_data[3]', `location`='$array_of_new_data[4]' WHERE `id_pone` = $id");
        $this->disconnect();
        return $this->response("update", $result, "updated");
    }


    function remove_data($id) {
        $result = $this->mysqli->query("DELETE FROM `Demographics` WHERE  `id_pone` = $id");
        return $this->response("remove", $result, "deleted");
    }

    function response($action, $result, $message) {
        if ($result) {
            $response_array['status'] = 'successful';
            if ($action === "login") {
                $response_array['reason'] = 'Your details were ' . $message . '.';
            }
            else {
                $response_array['reason'] = 'The row has successfully been ' .  $message . '.';
            }

        }
        else {
            $response_array['status'] = 'failure';
            if ($action === "login") {
                $response_array['reason'] = 'Your details were ' . $message . '.';
            } else {
                $response_array['reason'] = 'The row has unsuccessfully been ' . $message . '.';
            }
        }

        return $response_array;
    }
}

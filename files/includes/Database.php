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
        return $this->response($result, "sent");
    }

    function hash_data($password) {

    }

    function verify_data($table_name, $array_of_data) {
        $result_array = $this->get_data($table_name);
        for ($i = 0; $i < $result_array[1]; $i++) {

        }


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

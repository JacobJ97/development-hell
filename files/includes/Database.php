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
        $tables = $this->mysqli->query("SHOW tables");
        $tables_assoc = mysqli_fetch_assoc($tables);

        foreach ($tables_assoc as $table) {
            if ($table === $table_name) {
                return;
            }
        }

        $counter = 0;
        $detail_count = count($table_details);
        foreach($table_details as $detail) {
            if ($detail_count - $counter === 1) {
                $query .= $detail . " VARCHAR(100))";
            }
            else {
                $query .= $detail . " VARCHAR(100), ";
            }
            $counter++;
        }

        $this->mysqli->query("CREATE TABLE $table_name (id int(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, " . $query);
    }

    function query_builder_add($table_name, $array_of_titles, $array_of_values) {
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

    function get_id_column_name($table_name) {
        $result = $this->mysqli->query("SHOW COLUMNS FROM $table_name");
        $row = $result->fetch_assoc();
        $id_name = $row['Field'];
        return $id_name;
    }

    function query_builder_update($table_name, $array_of_titles, $array_of_new_data, $id) {
        $query = "UPDATE $table_name SET ";
        $aond_count = count($array_of_new_data);
        for ($i = 0; $i < $aond_count; $i++) {
            $title = $array_of_titles[$i];
            $new_data = $array_of_new_data[$i];
            if ($aond_count - $i === 1) {
                $query .= "$title = '$new_data' ";
            } else {
                $query .= "$title = '$new_data', ";
            }
        }

        $id_name = $this->get_id_column_name($table_name);

        $query .= "WHERE $id_name = $id";
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
        $query = $this->query_builder_add($table_name, $array_of_titles, $array_of_values);
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
        $assoc_result_array = $result_array[0];
        $ra_count = $result_array[1];
        foreach ($assoc_result_array as $row) {
            if ($row[1] === $array_of_values[0]) {
                for ($j = 0; $j < $ra_count; $j++) {
                    $stored_hash = $row[2];
                    $password = $array_of_values[1];
                    if (password_verify($password, $stored_hash)) {
                        return $this->response("login", true, "correct");
                    }
                }
                return $this->response("login", false, "incorrect $row[2]");
            }
        }
        return $this->response("login", false, "incorrect");
    }

    function update_data($table_name, $array_of_titles, $array_of_new_data, $id) {
        $query = $this->query_builder_update($table_name, $array_of_titles, $array_of_new_data, $id);
        $result = $this->mysqli->query($query);
        $this->disconnect();
        return $this->response("update", $result, "updated");
    }

    function remove_data($table_name, $id) {
        $id_name = $this->get_id_column_name($table_name);
        $result = $this->mysqli->query("DELETE FROM $table_name WHERE $id_name = $id");
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

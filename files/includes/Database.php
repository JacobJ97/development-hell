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

        $this->mysqli->query("CREATE TABLE $table_name (id_" . strtolower($table_name) . " int(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, " . $query);
    }

    function query_builder_add($table_name, $array_of_titles, $array_of_values) {
        $table_count = count($table_name);
        $query_multi = array();
        for ($x = 0; $x < $table_count; $x++) {
            $query = "INSERT INTO $table_name[$x] (";
            $aot_count = count($array_of_titles[$x]);
            $aov_count = count($array_of_values[$x]);
            for ($i = 0; $i < $aot_count; $i++) {
                $title = $array_of_titles[$x][$i];
                if ($aot_count - $i !== 1) {
                    $query .= "$title, ";
                } else {
                    $query .= "$title) ";
                }
            }

            $query .= "VALUES (";

            for ($j = 0; $j < $aov_count; $j++) {
                $value = $array_of_values[$x][$j];
                if ($aov_count - $j !== 1) {
                    $query .= "'$value', ";
                } else {
                    $query .= "'$value')";
                }
            }

            $query_multi[] = $query;
        }

        return $query_multi;
    }

    function get_id_column_name($table_name) {
        $result = $this->mysqli->query("SHOW COLUMNS FROM $table_name");
        $row = $result->fetch_assoc();
        $id_name = $row['Field'];
        return $id_name;
    }

    function query_builder_update($table_name, $array_of_titles, $array_of_new_data, $id) {
        $table_count = count($table_name);
        $query_multi = array();
        for ($x = 0; $x < $table_count; $x++) {
            $query = "UPDATE " . $table_name[$x] . "SET (";
            $aond_count = count($array_of_new_data[$x]);
            for ($i = 0; $i < $aond_count; $i++) {
                $title = $array_of_titles[$x][$i];
                $new_data = $array_of_new_data[$x][$i];
                if ($aond_count - $i === 1) {
                    $query .= "$title = '$new_data' ";
                } else {
                    $query .= "$title = '$new_data', ";
                }
            }

            $id_name = $this->get_id_column_name($table_name[$x]);

            $query .= "WHERE $id_name = $id[$x]";
            $query_multi[] .= $query . "; ";
        }

        return $query_multi;
    }

    function get_data($table_name) {
        $result = $this->mysqli->query("SELECT * FROM " . $table_name);
        $result_array = $result->fetch_all();
        $array_count = count($result_array);

        return [$result_array, $array_count];
    }

    function send_data($table_name, $arrays_of_titles, $arrays_of_values, $form_action) {
        $queries = $this->query_builder_add($table_name, $arrays_of_titles, $arrays_of_values);
        foreach ($queries as $query) {
            $result = $this->mysqli->query($query);
            if (!$result) {
                if ($form_action === "password") {
                    return $this->response("registration", FALSE, "created");
                }
                else {
                    return $this->response("add", FALSE, "sent");
                }
            }
        }

        if ($form_action === "password") {
            return $this->response("registration", TRUE, "created");
        }
        else {
            return $this->response("add", TRUE, "sent");
        }
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
            else if ($action === "add") {
                $response_array['reason'] = 'The row has successfully been ' .  $message . '.';
            }
            else if ($action === "registration") {
                $response_array['reason'] = 'Your account has successfully been ' .  $message . '.';
            }

        }
        else {
            $response_array['status'] = 'failure';
            if ($action === "login") {
                $response_array['reason'] = 'Your details were ' . $message . '.';
            }
            else if ($action === "add") {
                $response_array['reason'] = 'The row has unsuccessfully been ' . $message . '.';
            }
            else if ($action === "registration") {
                $response_array['reason'] = 'Your account has unsuccessfully been ' .  $message . '.';
            }
        }

        return $response_array;
    }
}
<?php
    // department

    function find_all_departments() {
        global $db;

        $sql = "SELECT * FROM department ";
        $sql .= "ORDER BY did asc" .";";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result, "dept");
        return $result;
    }

    function find_department_by_did($did) {
        global $db;

        $sql = "SELECT * FROM department ";
        $sql .= "WHERE did=" . db_escape($db, $did) .";";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result, "dept_by_did");
        $department = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $department; //assoc. arry
    }
    // disease

    // patient

    // patient_treatment

    // physician

    // treatment
    
    // users

    function find_all_users() {
        global $db;

        $sql = "SELECT * FROM users ";
        $sql .= "ORDER BY UID asc, did asc;";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result, "users");
        return $result;
    }

    function find_user_by_uid($UID) {
        global $db;

        $sql = "SELECT * FROM users ";
        $sql .= "WHERE UID =" .db_escape($db, $UID) .";";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result, "users_uid");
        $user = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $user; // assoc. arry
    }

    function validate_user($user) {
        $errors = [];

        $UID = (int) $user['UID'];
        $ufname = $user['ufname'];
        $ulname = $user['ulname'];
        $urole = $user['urole'];
        $did = (int) $user['did'];

        // UID
        if ($UID < 0 || $UID > 9999) {
            $errors[] = "User ID must be an integer between 0 and 9999.";
        }

        // ufname
        if (!is_string($ufname)) {
            $errors[] = "User's first name is required.";
        } else if (!ctype_alpha($ufname)) {
            $errors[] = "User's first name should only consist of letters.";
        } else if (strlen($ufname) > 20) {
            $errors[] = "User's first name can't be longer than 20 letters.";
        }

        // ulname
        if (!is_string($ulname)) {
            $errors[] = "User's last name is required.";
        } else if (!ctype_alpha($ulname)) {
            $errors[] = "User's last name should only consist of letters.";
        } else if (strlen($ulname) > 20) {
            $errors[] = "User's last name can't be longer than 20 letters.";
        }

        // urole
        if (!is_string($urole)) {
            $errors[] = "User's role is required.";
        } else if (!ctype_alpha($urole)) {
            $errors[] = "User's role should only consis of letters.";
        } else if (strlen($urole) > 20) { 
            $errors[] = "User's role can't be longer than 20 letters.";
        }

        // did
        if ($did < 0 || $did > 99) {
            $errors[] = "User's department id must be an integer between 0 and 99.";
        }

        return $errors;
    }

    function update_user($user) {
        global $db;

        $errors = validate_user($user);
        if (!empty($errors)) {
            return $errors;
        }

        $sql = "UPDATE users SET ";
        $sql .= "ufname = upper(\"" . db_escape($db, $user['ufname']) ."\"), ";
        $sql .= "ulname = upper(\"" . db_escape($db, $user['ulname']) ."\"), ";
        $sql .= "urole = \"" . db_escape($db, $user['urole']) ."\", ";
        $sql .= "did = " . db_escape($db, $user['did']) ." ";
        $sql .= "WHERE UID = " .db_escape($db, $user['UID']) ." ";
        $sql .= "LIMIT 1" . ";";

        $result = mysqli_query($db, $sql);
        if ($result) {
            // true
            return true;
        } else {
            // false
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function delete_user($UID) {
        global $db;

        $sql = "DELETE FROM users ";
        $sql .= "WHERE UID = " . db_escape($db, $UID) ." ";
        $sql .= "LIMIT 1" .";";
        
        $result = mysqli_query($db, $sql);
        if ($result) {
            // true
            return true;
        } else {
            // false
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }
?>
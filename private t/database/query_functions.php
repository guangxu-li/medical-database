<?php
    // department
    function find_department_by_did($did) {
        global $db;

        $sql = "SELECT * FROM department ";
        $sql .= "WHERE did=" . db_escape($db, $did);
        $result = mysqli_query($db, $sql);
        confirm_result_set($result, "dept_did");
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
        $sql .= "ORDER BY UID asc, did asc";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result, "users");
        return $result;
    }

    function find_user_by_id($uid) {
        global $db;

        $sql = "SELECT * FROM users ";
        $sql .= "WHERE uid =" .db_escape($db, $uid);
        $result = mysqli_query($db, $sql);
        confirm_result_set($result, "users_uid");
        $user = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $user; // assoc. arry
    }
?>
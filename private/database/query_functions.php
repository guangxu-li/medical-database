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
    function find_all($table_name, $pk) {
        global $db;

        $sql = "SELECT * FROM " .$table_name ." ";
        $sql .= "ORDER BY " .$pk ." asc" .";";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result, $table_name);
        return $result;
    }

    function find_record_by_pk($table_name, $pk, $pk_val) {
        global $db;

        if ($table_name == "patient_treatment") {
            $sql = "SELECT * FROM " .$table_name ." ";
            $sql .= "WHERE " .$pk['tdate'] ." = \"" .db_escape($db, $pk_val['tdate']) ."\" and ";
            $sql .= $pk['tfreq'] ." = \"" .db_escape($db, $pk_val['tfreq']) ."\" and ";
            $sql .= $pk['pid'] ." = " .db_escape($db, $pk_val['pid']) ." and ";
            $sql .= $pk['tid'] ." = " .db_escape($db, $pk_val['tid']) ." and ";
            $sql .= $pk['phid'] ." = " .db_escape($db, $pk_val['phid']) .";";
        } else {
            $sql = "SELECT * FROM " .$table_name ." ";
            $sql .= "WHERE " .$pk ." =" .db_escape($db, $pk_val) .";";
        }

        $result = mysqli_query($db, $sql);
        confirm_result_set($result, $pk);
        $record = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $record; // assoc. arry
    }
    
    function validate_string($string, $maxlen, $skip, $strname) {
        $errors = [];

        $indice = 0;
        foreach ($string as $str) {
            if (!is_string($str)) {
                $errors[] = $strname[$indice] ." is required.";
            } else if (!(ctype_alpha(str_replace(" ", "", $str)) || 
                        is_numeric(str_replace("-", "", $str))) || $skip) {
                $errors[] = $strname[$indice] ." is required and should only consist of letters/numbers";
            } else if (strlen($str) > $maxlen[$indice]) {
                $errors[] = $strname[$indice] ." can't be longer than " .$maxlen[$indice] ." letters/numbers.";
            }

            $indice++;
        }

        return $errors;
    }

    function validate_number($number, $maxnum, $numname) {
        $errors = [];

        foreach ($number as $num) {
            if (!is_int($num)) {
                $errors[] = $numname[$indice] ." is required and should be an integer.";
            }
            if ($num < 0 || $num > $maxnum[$indice]) {
                $errors[] = $numname[$indice] ." is a number between 0 and " .maxnum[$indice];
            }
        }
    }

    function validate_record($record, $table_name) {
        $string = [];
        $maxlen = [];
        $strname = [];
        
        $number = [];
        $maxnum = [];
        $numname = [];
        $skip = false;

        switch ($table_name) {
            case 'department':
                $string[] = $record['dname'];
                $maxlen[] = 20;
                $strname[] = ucfirst($table_name) ."'s name";
                $string[] = $record['dtel'];
                $maxlen[] = 13;
                $strname[] = ucfirst($table_name) ."'s tel";

                break;

            case 'disease':
                $string[] = $record['dename'];
                $maxlen[] = 30;
                $strname[] = ucfirst($table_name) ."'s name";
                
                break;

            case 'patient':
                $string[] = $record['pfname'];
                $maxlen[] = 30;
                $strname[] = ucfirst($table_name) ."'s first name";

                $string[] = $record['plname'];
                $maxlen[] = 20; 
                $strname[] = ucfirst($table_name) ."'s last name";

                $string[] = $record['prace'];
                $maxlen[] = 20;
                $strname[] = ucfirst($table_name) ."'s race";

                break;

            case 'physician':
                $string[] = $record['phfname'];
                $maxlen[] = 30;
                $strname[] = ucfirst($table_name) ."'s first name";
                
                $string[] = $record['phtel'];
                $maxlen[] = 13;
                $strname[] = ucfirst($table_name) ."'s tel";

                $string[] = $record['phspl'];
                $maxlen[] = 30;
                $strname[] = ucfirst($table_name) ."'s field";

                break;

            case 'treatment':
                $string[] = $record['tname'];
                $maxlen[] = 50;
                $strname[] = ucfirst($table_name) ."'s name";
                $skip = true;

                break;

            case 'users':
                $string[] = $record['ufname'];
                $maxlen[] = 20;
                $strname[] = ucfirst($table_name) ."'s first name";
                $string[] = $record['ulname'];
                $maxlen[] = 20;
                $strname[] = ucfirst($table_name) ."'s last name";
                $string[] = $record['urole'];
                $maxlen[] = 20;
                $strname[] = ucfirst($table_name) ."'s role";

                break;
            
            default:
            
                break;
        }
        
        if (!empty($string)) {
            $str_errors = validate_string($string, $maxlen, $skip, $strname);
        }
        if (!empty($number)) {
            $num_errors = validate_number($number, $maxnum);
        }
        return array_merge($str_errors??[], $num_errors??[]);
    }

    function insert_record($record, $table_name) {
        global $db;
        
        $errors = validate_record($record, $table_name);
        if (!empty($errors)) {
            return $errors;
        }

        switch ($table_name) {
            case 'department':
                $sql = "INSERT INTO " .$table_name ." VALUES (NULL, ";
                $sql .= "upper(\"" .db_escape($db, $record['dname']) ."\"), ";
                $sql .= db_escape($db, $record['dtel']) .", ";
                $sql .= db_escape($db, $record['hid']) .");";

                break;
            
            case 'disease':
                $sql = "INSERT INTO " .$table_name ." VALUES (NULL, ";
                $sql .= "upper(\"" .db_escape($db, $record['dename']) ."\"));";
                
                break;

            case 'patient':
                $sql = "INSERT INTO " .$table_name ." VALUES (NULL, ";
                $sql .= "upper(\"" .db_escape($db, $record['pfname']) ."\"), ";
                $sql .= "upper(\"" .db_escape($db, $record['plname']) ."\"), ";
                $sql .= "upper(\"" .db_escape($db, $record['pgender']) ."\"), ";
                $sql .= "date(\"" .db_escape($db, $record['pbd']) ." 11:11:11\") , \"";
                $sql .= db_escape($db, $record['prace']) ."\", ";
                $sql .= "upper(\"" .db_escape($db, $record['pstatus']) ."\"));";

                break;

            case 'patient_treatment':
                $sql = "INSERT INTO " .$table_name ." VALUES (";
                $sql .= "date(\"" .db_escape($db, $record['tdate']) ." 11:11:11\"), ";
                $sql .= db_escape($db, $record['tfreq']) .", ";
                if ($record['tstatus'] == "") {
                    $sql .= "NULL, ";
                } else {
                    $sql .= "\"" .db_escape($db, $record['tstatus']) ."\", ";
                }
                $sql .= db_escape($db, $record['pid']) .", ";
                $sql .= db_escape($db, $record['tid']) .", ";
                $sql .= db_escape($db, $record['phid']) .");";

                break;

            case 'physician':
                $sql = "INSERT INTO " .$table_name ." VALUES (NULL, ";
                $sql .= "upper(\"" .db_escape($db, $record['phfname']) ."\"), ";
                $sql .= db_escape($db, $record['phtel']) .", ";
                $sql .= "upper(\"" .db_escape($db, $record['phspl']) ."\"), ";
                $sql .= db_escape($db, $record['hid']) .";";

                break;

            case 'treatment':
                $sql = "INSERT INTO " .$table_name ." VALUES (NULL, ";
                $sql .= "upper(\"" .db_escape($db, $record['tname']) ."\"), ";
                $sql .= "upper(\"" .db_escape($db, $record['ttype']) ."\"), ";
                $sql .= db_escape($db, $record['deid']) .";";

                break;
            
            case 'users':
                $sql = "INSERT INTO " .$table_name ." VALUES (NULL, ";
                $sql .= "upper(\"" .db_escape($db, $record['ufname']) ."\"), ";
                $sql .= "upper(\"" .db_escape($db, $record['ulname']) ."\"), ";
                $sql .= "upper(\"" .db_escape($db, $record['urole']) ."\"), ";
                $sql .= db_escape($db, $record['did']) .");";
 
                break;
            
            default:
                
                break;
        }
echo $sql;
        $result = mysqli_query($db, $sql);

        if($result) {
            // true
            return true;
        } else {
            // false
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function update_record($record, $table_name, $pk, $pk_val) {
        global $db;

        $errors = validate_record($record, $table_name);
        if (!empty($errors)) {
            return $errors;
        }
        switch ($table_name) {
            case 'department':
                $sql = "UPDATE department SET ";
                $sql .= "dname = upper(\"" .db_escape($db, $record['dname']) ."\"), ";
                $sql .= "dtel = \"" .db_escape($db, $record['dtel']) ."\", ";
                $sql .= "hid = " .db_escape($db, $record['hid']) ." ";
                $sql .= "WHERE did = " .db_escape($db, $record['did']) ." ";
                $sql .= "LIMIT 1;";

                break;

            case 'disease':
                $sql = "UPDATE disease SET ";
                $sql .= "dename = upper(\"" .db_escape($db, $record['dename']) ."\"), ";
                $sql .= "WHERE deid = " .db_escape($db, $record['deid']) ." ";
                $sql .= "LIMIT 1;";

                break;

            case 'patient':
                $sql = "UPDATE patient SET ";
                $sql .= "pfname = upper(\"" .db_escape($db, $record['pfname']) ."\"), ";
                $sql .= "plname = upper(\"" .db_escape($db, $record['plname']) ."\"), ";
                $sql .= "pgender = upper(\"" .db_escape($db, $record['pgender']) ."\"), ";
                $sql .= "pbd = date(\"" .db_escape($db, $record['pbd']) ." 11:11:11\"), ";
                $sql .= "prace = \"" .db_escape($db, $record['prace']) ."\", ";
                $sql .= "pstatus = \"" .db_escape($db, $record['pstatus']) ."\" ";
                $sql .= "WHERE pid = " .db_escape($db, $record['pid']) ." ";
                $sql .= "LIMIT 1;";

                break;

            case 'patient_treatment':
                $original_record = find_record_by_pk($table_name, $pk, $pk_val);

                $sql = "UPDATE patient_treatment SET ";
                $sql .= "tstatus = \"" .db_escape($db, $record['tstatus']) ."\", ";
                $sql .= "tdate = date(\"" .db_escape($db, $record['tdate']) ." 11:11:11\"), ";
                $sql .= "tfreq = " .db_escape($db, $record['tfreq']) .", ";
                $sql .= "pid = " .db_escape($db, $record['pid']) .", ";
                $sql .= "tid = " .db_escape($db, $record['tid']) .", ";
                $sql .= "phid = " .db_escape($db, $record['phid']) ." ";
                $sql .= "WHERE ";
                $sql .= "tdate = \"" .db_escape($db, $original_record['tdate']) ."\" and ";
                $sql .= "tfreq = " .db_escape($db, $original_record['tfreq']) ." and ";
                $sql .= "pid = " .db_escape($db, $original_record['pid']) ." and ";
                $sql .= "tid = " .db_escape($db, $original_record['tid']) ." and ";
                $sql .= "phid = " .db_escape($db, $original_record['phid']) ." ";
                $sql .= "LIMIT 1;"; 

                break;
            case 'physician':
                $sql = "UPDATE physician SET ";
                $sql .= "phfname = upper(\"" .db_escape($db, $record['phfname']) ."\"), ";
                $sql .= "phtel = " .db_escape($db, $record['phtel']) .", ";
                $sql .= "phspl = upper(\"" .db_escape($db, $record['phspl']) ."\"), ";
                $sql .= "hid = " .db_escape($db, $record['hid']) ." ";
                $sql .= "WHERE phid = " .db_escape($db, $record['phid']) ." ";
                $sql .= "LIMIT 1;";
                
                break;

            case 'treatment':
                $sql = "UPDATE treatment SET ";
                $sql .= "tname = upper(\"" .db_escape($db, $record['tname']) ."\"), ";
                $sql .= "ttype = upper(\"" .db_escape($db, $record['ttype']) ."\"), ";
                $sql .= "deid = " .db_escape($db, $record['deid']) ." ";
                $sql .= "WHERE tid = " .db_escape($db, $record['tid']) ." ";
                $sql .= "LIMIT 1;";

                break;

            case 'users':
                $sql = "UPDATE users SET ";
                $sql .= "ufname = upper(\"" . db_escape($db, $record['ufname']) ."\"), ";
                $sql .= "ulname = upper(\"" . db_escape($db, $record['ulname']) ."\"), ";
                $sql .= "urole = \"" . db_escape($db, $record['urole']) ."\", ";
                $sql .= "did = " . db_escape($db, $record['did']) ." ";
                $sql .= "WHERE UID = " .db_escape($db, $record['UID']) ." ";
                $sql .= "LIMIT 1;";

                break;
            
            default:
            
                break;
        }
echo $sql;
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

    function delete_record($table_name, $pk, $pk_val) {
        global $db;
        
        if ($table_name == "patient_treatment") {
            $sql = "DELETE FROM " .$table_name ." ";
            $sql .= "WHERE " .$pk['tdate'] ." = \"" .db_escape($db, $pk_val['tdate']) ."\" and ";
            $sql .= $pk['tfreq'] ." = " .db_escape($db, $pk_val['tfreq']) ." and ";
            $sql .= $pk['pid'] ." = " .db_escape($db, $pk_val['pid']) ." and ";
            $sql .= $pk['tid'] ." = " .db_escape($db, $pk_val['tid']) ." and ";
            $sql .= $pk['phid'] ." = " .db_escape($db, $pk_val['phid']) ." ";
            $sql .= "LIMIT 1;";
        } else {
            $sql = "DELETE FROM " .$table_name ." ";
            $sql .= "WHERE " .$pk ." = " . db_escape($db, $pk_val) ." ";
            $sql .= "LIMIT 1;";
        }

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

        $ufname = $user['ufname'];
        $ulname = $user['ulname'];
        $urole = $user['urole'];
        $did = (int) $user['did'];

        // ufname
        if (!is_string($ufname)) {
            $errors[] = "User's first name is required.";
        } else if (!ctype_alpha($ufname)) {
            $errors[] = "User's first name is required and should only consist of letters.";
        } else if (strlen($ufname) > 20) {
            $errors[] = "User's first name can't be longer than 20 letters.";
        }

        // ulname
        if (!is_string($ulname)) {
            $errors[] = "User's last name is required.";
        } else if (!ctype_alpha($ulname)) {
            $errors[] = "User's last name is required and should only consist of letters.";
        } else if (strlen($ulname) > 20) {
            $errors[] = "User's last name can't be longer than 20 letters.";
        }

        // urole
        if (!is_string($urole)) {
            $errors[] = "User's role is required.";
        } else if (!ctype_alpha($urole)) {
            $errors[] = "User's role is required and should only consis of letters.";
        } else if (strlen($urole) > 20) { 
            $errors[] = "User's role can't be longer than 20 letters.";
        }

        return $errors;
    }

    function insert_user($user) {
        global $db;

        $errors = validate_user($user);
        if(!empty($errors)) {
            return $errors;
        }

        $sql = "INSERT INTO users VALUES (NULL, ";
        $sql .= "upper(\"" .db_escape($db, $user['ufname']) ."\"), ";
        $sql .= "upper(\"" .db_escape($db, $user['ulname']) ."\"), ";
        $sql .= "upper(\"" .db_escape($db, $user['urole']) ."\"), ";
        $sql .= db_escape($db, $user['did']) .");";
        $result = mysqli_query($db, $sql);

        if($result) {
            // true
            return true;
        } else {
            // false
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
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
        $sql .= "LIMIT 1;";

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
        $sql .= "LIMIT 1;";
        
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
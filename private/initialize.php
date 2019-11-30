<?php
    ob_start(); //output buffering
    session_start();

    define("PRIVATE_PATH", dirname(__FILE__));
    define("PROJECT_PATH", dirname(PRIVATE_PATH));
    define("PUBLIC_PATH", PROJECT_PATH ."/public");
    define("SHARED_PATH", PRIVATE_PATH ."/shared");
    define("DATABASE_PATH", PRIVATE_PATH ."/database");

    $public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
    $doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
    define("WWW_ROOT", $doc_root);

    require_once('functions.php');
    // require_once('certain_city.php');
    // require_once('certain_state.php');
    // require_once('certain_zip.php');
    require_once(DATABASE_PATH .'/database.php');
    require_once(DATABASE_PATH .'/query_functions.php');
    require_once(DATABASE_PATH .'/validation_functions.php');

    $db = db_connect();
    $errors = [];
    global $skip;
    $skip = 1;
    if((!isset($_COOKIE['uname'])||!isset($_COOKIE['psw']))&&$skip) {
        redirect_to(url_for('index.php'));
    }
    // if(empty($_COOKIE['uname'])&&empty($_COOKIE['password'])) {
    //     if(!isset($_SESSION['username'])) {
    //        redirect_to(url_for('index.php')); 
    //     }
    // }
?>
<?php

    function redirect_to($location) {
        header("Location: " .$location);
    }
    function url_for($script_path) {
        if ($script_path[0] != '/') {
            $script_path = "/" . $script_path;
        }
        return WWW_ROOT . $script_path;
    }

    setcookie('uname', '', time()-3600);
    setcookie('psw', '', time()-3600);
    setcookie('remember', '', time()-3600);
    redirect_to('./index.php');
?>
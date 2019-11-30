<?php
    require_once('../private/initialize.php');
    setcookie('uname', '', time()-3600);
    setcookie('psw', '', time()-3600);
    setcookie('remember', '', time()-3600);
    redirect_to(url_for('index.php'));
?>
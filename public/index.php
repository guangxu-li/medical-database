<?php

    require_once('../private/check.php');

    if (is_post_request()) {

      $uname = sha1(encode($_POST['uname']));
      $psw = sha1($_POST['psw']);
      $remember = $_POST['remember']??0;

      $sql = "SELECT * FROM admin WHERE uname = \"" .db_escape($db, $uname) ."\" and psw = \"" .db_escape($db, $psw) ."\";";

      $record = mysqli_query($db, $sql);

      $rows = mysqli_num_rows($record);

      if ($rows) {

        redirect_to(url_for('/admin/index.php'));

        if ($remember == 1) {
          setcooke('uname', $uname, time()+36000);
          setcookie('psw', $psw, time()+36000);
          setcookoie('remember', $remember, time()+36000);
        } else {
          setcooke('uname', $uname, time()+3600);
          setcookie('psw', $psw, time()+3600);
          setcookoie('remember', $remember, time()+3600);
        }
      } else {
        echo "Login info doesn't match in the database!";
        echo "
            <script>
              setTimeout(function() {windows.location.href='index.php';},1000);
            </script>
        ";
      }
    }  
    $page_title = "Login";
    require(SHARED_PATH .'/header.php');
?>

<h1>Welcom! Please login to continue.</h1>

<div class="modal">
  
  <form action="index.php" method="post">

    <div class="login">
      <label for="uname"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="uname" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw" required>
      <label>
        <input type="checkbox" name="remember"> Remember me
      </label>  
      <button type="submit" value = "submit">Login</button>
      
    </div>
  </form>
</div>

<?php require(SHARED_PATH .'/footer.php'); ?>
<?php
  if(!isset($page_title)) { $page_title = 'We Do Care'; }
?>

<!doctype html>

<html lang="en">
  <head>
    <title>WDC - <?php echo h($page_title); ?></title>
    <meta charset="utf-8">
    <script src = "../../../private/js/jquery.min.js"></script>
    <link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/staff.css'); ?>" />
    <script src="../../../private/js/bootstrap.min.js"></script>
    <script src="../../../private/js/state_city_zip.js"></script>
  </head>

  <body>
    <header>
      <h1>We Do Care</h1>
    </header>

    <navigation>
      <ul>
        <li><a href="<?php echo url_for('/admin/index.php'); ?>">Menu</a></li>
        <li><a href="<?php echo url_for('index.php'); ?>">Login</a></li>
        <li><a href="<?php echo url_for('logout.php'); ?>">Log out</li>
      </ul>
    </navigation>

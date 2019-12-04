<?php
    require_once('../../private/initialize.php');

    $page_title = "Admin Portal";
    require(SHARED_PATH .'/header.php');
?>

<a class="link" href="<?php echo url_for('/admin/department/index.php'); ?>">Department</a>
<a class="link" href="<?php echo url_for('/admin/disease/index.php'); ?>">Disease</a>
<a class="link" href="<?php echo url_for('/admin/hospital/index.php'); ?>">Hospital</a>
<a class="link" href="<?php echo url_for('/admin/patient/index.php'); ?>">Patient</a>
<a class="link" href="<?php echo url_for('/admin/patient_treatment/index.php'); ?>">Patient_treatment</a>
<a class="link" href="<?php echo url_for('/admin/physician/index.php'); ?>">Physician</a>
<a class="link" href="<?php echo url_for('/admin/treatment/index.php'); ?>">Treatment</a>
<a class="link" href="<?php echo url_for('/admin/users/index.php'); ?>">Users</a>

<?php require(SHARED_PATH .'/footer.php');
<?php
    require_once('../../../private/initialize.php');
    if (!isset($_GET['UID'])){
        redirect_to(url_for('/admin/users/index.php'));
    }
    $UID = $_GET['UID'];

    if (is_post_request()) {
        // value comes from new.php

        $user = [];
        $user['UID'] = $UID;
        $user['ufname'] = $_POST['ufname']??"";
        $user['ulname'] = $_POST['ulname']??"";
        $user['urole'] = $_POST['urole']??"";
        $user['did'] = $_POST['did']??"";

        $result = update_user($user);
        if ($result === true) {
            redirect_to(url_for('/admin/users/show.php?UID=' . $UID));
        } else {
            $errors = $result;
        }
    } else {
        $user = find_user_by_uid($UID);
    }

    $user_set = find_all_users();
    $user_count = mysqli_num_rows($user_set);
    mysqli_free_result($user_set);
 
    $page_title = "Edit User";
    require(SHARED_PATH ."/header.php");
?>

<div id = "content">
    <a class = "back-link" href="<?php echo url_for('/admin/users/index.php'); ?>">&laquo; Back to List</a>

    <div class = "user edit">
        <h1>Edit User</h1>
        <?php echo display_errors($errors); ?>

        <form action = "<?php echo url_for('/admin/users/edit.php?UID=' . h(u($UID))); ?>" method = "post">
            <dl>
                <dt>First Name</dt>
                <dd>
                    <input type = "text" name = "ufname" value = "<?php echo h($user['ufname']); ?>" />
                </dd>
            </dl>
            <dl>
                <dt>Last Name</dt>
                <dd>
                    <input type = "text" name = "ulname" value = "<?php echo h($user['ulname']); ?>" />
                </dd>
            </dl>
            <dl>
                <dt>Role</dt>
                <dd>
                    <input type = "text" name = "urole" value = "<?php echo h($user['urole']); ?>" />
                </dd>
            </dl>
            <dl>
                <dt>Department</dt>
                <dd>
                    <select name = "did">
                    <?php   
                        $department_set = find_all_departments();
                        while ($department = mysqli_fetch_assoc($department_set)) {
                            echo "<option value=\"" . h($department[''])
                        }
</div>
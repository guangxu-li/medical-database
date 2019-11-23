<?php 

    require_once("../../../private/initialize.php");

    if(is_post_request()) {

        $user = [];
        $user['ufname'] = $_POST['ufname'] ?? "";
        $user['ulname'] = $_POST['ulname'] ?? "";
        $user['urole'] = $_POST['urole'] ?? "";
        $user['did'] = $_POST['did'] ?? "";

        $result = insert_user($user);
        if($result === true) {
            $new_UID = mysqli_insert_id($db);
            redirect_to(url_for('/admin/users/show.php?id=' . $new_UID));
        } else {
            $errors = $result;
        }
    } else {
        $user = [];
        $user['ufname'] = "";
        $user['ulname'] = "";
        $user['urole'] = "";
    }

    $page_title = "Create User";
    require(SHARED_PATH .'/header.php');
?>

<div id="content">

    <a class="back-link" href="<?php echo url_for('/admin/users/index.php'); ?>">&laquo; Back to List</a>

    <div class="user new">
    <h1>Create User</h1>

    <?php echo display_errors($errors); ?>

    <form action = "<?php echo url_for('/admin/users/new.php'); ?>" method = "post">
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
                            echo "<option value = \"" . h($department['did']) . "\"";
                            echo ">" .h($department['did']) ." " .h($department['dname']) . "</option>";
                        }
                        mysqli_free_result($department_set);
                    ?>
                    </select>
                </dd>
            </dl>
            <div id = "operations">
                <input type = "submit" value = "Create User" />
            </div>
        </form>
    </div>
</dvi>

<?php require(SHARED_PATH .'/footer.php'); ?>
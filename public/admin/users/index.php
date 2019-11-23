<?php 
    require_once('../../../private/initialize.php');
    
    $user_set = find_all_users();

    $page_title = "Users";
    require(SHARED_PATH ."/header.php");
?>

<div id = "content">
    <div class = "users listing">
        <h1>Users</h1>

        <div class = "actions">
            <a class = "action" href = "<?php echo url_for('/admin/users/new.php'); ?>">Create New User</a>
        </div>

        <table class = "list">
            <tr>
                <th>User ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Role</th>
                <th>Department</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>

            <?php while ($user = mysqli_fetch_assoc($user_set)) { ?>
                <?php $department = find_department_by_did($user['did']); ?>
                <tr>
                    <td><?php echo h($user['UID']); ?></td>
                    <td><?php echo h($user['ufname']); ?></td>
                    <td><?php echo h($user['ulname']); ?></td>
                    <td><?php echo h($user['urole']); ?></td>
                    <td><?php echo h($department['did']) ." " .h($department['dname']); ?></td>
                    <td><a class = "action" href = "<?php echo url_for('/admin/users/show.php?UID=' .h(u($user['UID']))); ?>">View</a></td>
                    <td><a class = "action" href = "<?php echo url_for('/admin/users/edit.php?UID=' .h(u($user['UID']))); ?>">Edit</a></td>
                    <td><a class = "action" href = "<?php echo url_for('/admin/users/delete.php?UID=' .h(u($user['UID']))); ?>">Delete</a></td>
                </tr>
            <?php } ?>
        </table>

        <?php mysqli_free_result($user_set); ?>
    </div>
</div>

<?php require(SHARED_PATH ."/footer.php"); ?>
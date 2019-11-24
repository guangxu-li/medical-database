<?php
    require_once('../../../private/initialize.php');

    if(!isset($_GET['UID'])) {
        redirect_to(url_for('/admin/users/index.php'));
    }
    $UID = $_GET['UID'];

    if(is_post_request()) {
        $result = delete_user($UID);
        redirect_to(url_for('/admin/users/index.php'));
    } else {
        $user = find_user_by_uid($UID);
    }

    $page_title = "Delete User";
    require(SHARED_PATH ."/header.php");
?>

<div id = "content">
    <a class = "back-link" href = "<?php echo url_for('/admin/users/index.php'); ?>">&laquo; Back to List</a>

    <div class = "user delete">

        <h1>Delete User</h1>
        <p>Are you sure you want to delete this user?</p>
        <p class = "item"><?php echo h($user['UID']) ." " .h($user['ufname']) ." " .h($user['ulname']); ?></p>

        <form action = "<?php echo url_for('/admin/users/delete.php?UID=' .h(u($user['UID']))); ?>" method = "post">
            <div id = "operations">
                <input type = "submit" name = "commit" value = "Delete Page" />
            </div>
        </form>
    </div>
</div>

<?php require(SHARED_PATH . '/footer.php'); ?>
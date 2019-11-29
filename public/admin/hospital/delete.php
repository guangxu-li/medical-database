<?php

    $table_name = "hospital";
    $pk = "hid";
    require_once('../../../private/initialize.php');

    if(!isset($_GET[$pk])) {
        redirect_to(url_for('/admin/' .$table_name .'/index.php'));
    }
    $pk_val = $_GET[$pk];

    if(is_post_request()) {
        $result = delete_record($table_name, $pk, $pk_val);
        redirect_to(url_for('/admin/' .$table_name .'/index.php'));
    } else {
        $record = find_record_by_pk($table_name, $pk, $pk_val);
    }

    $page_title = "Delete " .ucfirst($table_name);
    require(SHARED_PATH ."/header.php");
?>

<div id = "content">
    <a class = "back-link" href = "<?php echo url_for('/admin/' .$table_name .'/index.php'); ?>">&laquo; Back to List</a>

    <div class = "<?php echo $table_name ."delete"; ?>">

        <h1><?php echo "Delete " .ucfirst($table_name); ?></h1>
        <p><?php echo "Are you sure you want to delete this " .$table_name ."?"; ?></p>
        <p class = "item"><?php echo h($record[$pk]) ." " .h($record['hname']) ." " .h($record['hst_city']) ." " .h($record['hstate']) ." " .h($record['hzip']); ?></p>

        <form action = "<?php echo url_for('/admin/' .$table_name .'/delete.php?' .$pk .'=' .h(u($pk_val))); ?>" method = "post">
            <div id = "operations">
                <input type = "submit" name = "commit" value = "<?php echo "Delete " .ucfirst($table_name); ?>" />
            </div>
        </form>
    </div>
</div>

<?php require(SHARED_PATH . '/footer.php'); ?>
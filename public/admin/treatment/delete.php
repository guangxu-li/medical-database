<?php
    require_once('../../../private/initialize.php');

    $table_name = "treatment";
    $pk = "tid";
    $fk_table_name = "disease";
    $fk = "deid";

    if(!isset($_GET[$pk])) {
        redirect_to(url_for('/admin/' .$table_name .'/index.php'));
    }
    $pk_val = $_GET[$pk];

    if(is_post_request()) {
        $result = delete_record($table_name, $pk, $pk_val);
        redirect_to(url_for('/admin/' .$table_name .'/index.php'));
    } else {
        $record = find_record_by_pk($table_name, $pk, $pk_val);
        $fk_record = find_record_by_pk($fk_table_name, $fk, $record[$fk]);
    }

    $page_title = "Delete " .ucfirst($table_name);
    require(SHARED_PATH ."/header.php");
?>

<div id = "content">
    <a class = "back-link" href = "<?php echo url_for('/admin/' .$table_name .'/index.php'); ?>">&laquo; Back to List</a>

    <div class = "<?php echo $table_name ."delete"; ?>">

        <h1><?php echo "Delete " .ucfirst($table_name); ?></h1>
        <p><?php echo "Are you sure you want to delete this " .$table_name ."?"; ?></p>
        <p class = "item"><?php echo h($record[$pk]) ." " .h($record['tname']) ." to target for " .h($fk_record['dename']); ?></p>

        <form action = "<?php echo url_for('/admin/' .$table_name .'/delete.php?' .$pk .'=' .h(u($record[$pk]))); ?>" method = "post">
            <div id = "operations">
                <input type = "submit" name = "commit" value = "<?php echo "Delete " .ucfirst($table_name); ?>" />
            </div>
        </form>
    </div>
</div>

<?php require(SHARED_PATH . '/footer.php'); ?>
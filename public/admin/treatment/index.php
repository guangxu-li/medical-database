<?php 
    require_once('../../../private/initialize.php');
    
    $table_name = "treatment";
    $pk = "tid";
    $fk_table_name = "disease";
    $fk = "deid";

    $record_set = find_all($table_name, $pk);

    $page_title = ucfirst($table_name);
    require(SHARED_PATH ."/header.php");
?>

<div id = "content">
    <div class = "<?php echo $table_name ." listing"; ?>">
        <h1><?php echo ucfirst($table_name); ?></h1>
        
        <a class="back-link" href="<?php echo url_for('/admin/index.php'); ?>">&laquo; Back to Admin</a>

        <div class = "actions">
            <a class = "action" href = "<?php echo url_for('/admin/' .$table_name .'/new.php'); ?>"><?php echo "Create New " .ucfirst($table_name); ?></a>
        </div>

        <table class = "list">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Target For:</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>

            <?php while ($record = mysqli_fetch_assoc($record_set)) { ?>
                <?php $fk_record = find_record_by_pk($fk_table_name, $fk, $record[$fk]); ?>
                <tr>
                    <td><?php echo h($record[$pk]); ?></td>
                    <td><?php echo h($record['tname']); ?></td>
                    <td><?php echo h($record['ttype']); ?></td>
                    <td><?php echo h($record[$fk]) ." " .h($fk_record['dename']); ?></td>
                    <td><a class = "action" href = "<?php echo url_for('/admin/' .$table_name .'/show.php?' .$pk .'=' .h(u($record[$pk]))); ?>">View</a></td>
                    <td><a class = "action" href = "<?php echo url_for('/admin/' .$table_name .'/edit.php?' .$pk .'=' .h(u($record[$pk]))); ?>">Edit</a></td>
                    <td><a class = "action" href = "<?php echo url_for('/admin/' .$table_name .'/delete.php?' .$pk .'=' .h(u($record[$pk]))); ?>">Delete</a></td>
                </tr>
            <?php } ?>
    </table>

        <?php mysqli_free_result($record_set); ?>
    </div>
</div>

<?php require(SHARED_PATH ."/footer.php"); ?>
<?php 
    require_once('../../../private/initialize.php');
    
    $table_name = "disease";
    $pk = "deid";
    $record_set = find_all($table_name, $pk);

    $page_title = ucfirst($table_name);
    require(SHARED_PATH ."/header.php");
?>

<div id = "content">
    <div class = <?php echo $page_title. " listing"; ?>>
        <h1><?php echo $page_title; ?></h1>

        <a class="back-link" href="<?php echo url_for('/admin/index.php'); ?>">&laquo; Back to Admin</a>

        <div class = "actions">
            <a class = "action" href = "<?php echo url_for('/admin/' .$table_name .'/new.php'); ?>"><?php echo "Create New " .$page_title; ?></a>
        </div>

        <table class = "list">
            <tr>
                <th><?php echo $page_title ." ID"; ?></th>
                <th><?php echo $page_title ." Name"; ?></th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>

            <?php while ($record = mysqli_fetch_assoc($record_set)) { ?>
                <tr>
                    <td><?php echo h($record[$pk]); ?></td>
                    <td><?php echo h($record['dename']); ?></td>
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
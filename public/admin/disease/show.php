<?php 
    require_once('../../../private/initialize.php');
    
    $table_name = "disease";
    $pk = "deid";
    $table_name_fk = "treatment";

    if (!isset($_GET[$pk])){
        redirect_to(url_for('/admin/' .$table_name .'/index.php'));
    }
    $pk_val = $_GET[$pk];

    $record = find_record_by_pk($table_name, $pk, $pk_val);
    $record_fk_set = find_records($table_name_fk, $pk, $pk_val);

    $page_title = ucfirst($table_name) ." Details";
    require(SHARED_PATH ."/header.php");
?>

<div id = "content">
    <div class = "<?php echo $table_name ." listing"; ?>">
        <h1><?php echo ucfirst($table_name) ." Details"; ?></h1>
        
        <a class="back-link" href="<?php echo url_for('/admin/' .$table_name .'/index.php'); ?>">&laquo; Back to List</a>

        <table class = "list">
            <tr>
                <th>ID</th>
                <th>Name</th>
            </tr>

            <tr>
                <td><?php echo h($record[$pk]); ?></td>
                <td><?php echo h($record['dename']); ?></td>
            </tr>

            <tr>
                <th>Treatment ID</th>
                <th>Name</th>
                <th>Type</th>
            </tr>

            <?php while ($record_fk = mysqli_fetch_assoc($record_fk_set)) { ?>
                <tr>
                    <td><?php echo h($record_fk['tid']); ?></td>
                    <td><?php echo h($record_fk['tname']); ?></td>
                    <td><?php echo h($record_fk['ttype']); ?></td>
                </tr>
            <?php } ?>
        </table>

        <?php mysqli_free_result($record_fk_set); ?>
    </div>
</div>

<?php require(SHARED_PATH ."/footer.php"); ?>
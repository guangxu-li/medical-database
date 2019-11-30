<?php 
    require_once('../../../private/initialize.php');
    
    $table_name = "department";
    $pk = "did";
    $fk_table_name = "hospital";
    $fk = "hid";
    $table_name_fk = "users";

    if (!isset($_GET[$pk])){
        redirect_to(url_for('/admin/' .$table_name .'/index.php'));
    }
    $pk_val = $_GET[$pk];

    $record = find_record_by_pk($table_name, $pk, $pk_val);
    $fk_record = find_record_by_pk($fk_table_name, $fk, $record[$fk]);
    $record_fk_set = find_records($table_name_fk, $pk, $pk_val);

    $page_title = ucfirst($table_name) ." Details";
    require(SHARED_PATH ."/header.php");
?>

<div id = "content">
    <div class = "<?php echo $table_name ." listing"; ?>">
        <h1><?php echo ucfirst($table_name) ." Details"; ?></h1>
        
        <a class="back-link" href="<?php echo url_for('/admin/' .$table_name .'index.php'); ?>">&laquo; Back to List</a>

        <table class = "list">
            <tr>
                <th>Department ID</th>
                <th>Name</th>
                <th>Tel.</th>
                <th>Hospital</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>

            <tr>
                <td><?php echo h($record[$pk]); ?></td>
                <td><?php echo h($record['dname']); ?></td>
                <td><?php echo h($record['dtel']); ?></td>
                <td><?php echo h($record[$fk]) ." " .h($fk_record['hname']); ?></td>
            </tr>

            <tr>
                <th>UID</th>
                <th>Name</th>
                <th>Role</th>
            </tr>

            <?php while ($record_fk = mysqli_fetch_assoc($record_fk_set)) { ?>
                <tr>
                    <td><?php echo h($record_fk['UID']); ?></td>
                    <td><?php echo h($record_fk['ufname']) ." " .h($record_fk['ulname']); ?></td>
                    <td><?php echo h($record_fk['urole']); ?></td>
                </tr>
            <?php } ?>
        </table>

        <?php mysqli_free_result($record_fk_set); ?>
    </div>
</div>

<?php require(SHARED_PATH ."/footer.php"); ?>
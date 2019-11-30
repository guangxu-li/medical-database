<?php 
    require_once('../../../private/initialize.php');
    
    $table_name = "patient";
    $pk = "pid";
    $table_name_fk = "patient_treatment";

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
        
        <a class="back-link" href="<?php echo url_for('/admin/' .$table_name .'index.php'); ?>">&laquo; Back to List</a>

        <table class = "list">
        <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Birthday</th>
                <th>Race</th>
                <th>Status</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>

            <tr>
                <td><?php echo h($record[$pk]); ?></td>
                <td><?php echo h($record['pfname']); ?></td>
                <td><?php echo h($record['plname']); ?></td>
                <td><?php echo h($record['pgender']); ?></td>
                <td><?php echo h(substr($record['pbd'], 0, 10)); ?></td> 
                <td><?php echo h($record['prace']); ?></td>
                <td><?php echo h($record['pstatus']); ?></td>
            </tr>

            <tr>
                <th>Date</th>
                <th>Frequency</th>
                <th>Status</th>
                <th>Treatment</th>
                <th>Physician</th>
            </tr>

            <?php while ($record_fk = mysqli_fetch_assoc($record_fk_set)) { ?>
                <tr>
                    <?php 
                        $treatment_record = find_record_by_pk("treatment", "tid", $record_fk['tid']);
                        $physician_record = find_record_by_pk("physician", "phid", $record_fk['phid']);
                    ?>
                    <td><?php echo h($record_fk['tdate']); ?></td>
                    <td><?php echo h($record_fk['tfreq']); ?></td>
                    <td><?php echo h($record_fk['tstatus']); ?></td>
                    <td><?php echo h($treatment_record['tid']) ." " .h($treatment_record['tname']) ." " .h($treatment_record['ttype']); ?></td>
                    <td><?php echo h($physician_record['phid']) ." " .h($physician_record['phfname']); ?></td> 
                </tr>
            <?php } ?>
    </table>

        <?php mysqli_free_result($record_fk_set); ?>
    </div>
</div>

<?php require(SHARED_PATH ."/footer.php"); ?>
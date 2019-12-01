<?php 
    require_once('../../../private/initialize.php');
    
    $table_name = "physician";
    $pk = "phid";
    $fk_table_name = "hospital";
    $fk = "hid";
    $table_name_fk = "patient_treatment";

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
        
        <a class="back-link" href="<?php echo url_for('/admin/' .$table_name .'/index.php'); ?>">&laquo; Back to List</a>

        <table class = "list">
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Tel.</th>
                <th>Field</th>
                <th>Hospital</th>
            </tr>

            <tr>
                <td><?php echo h($record[$pk]); ?></td>
                <td><?php echo h($record['phfname']); ?></td>
                <td><?php echo h($record['phtel']); ?></td>
                <td><?php echo h($record['phspl']); ?></td>
                <td><?php echo h($record[$fk]) ." " .h($fk_record['hname']); ?></td>
            </tr>

            <tr>
                <th>Date</th>
                <th>Frequency (/day)</th>
                <th>Status</th>
                <th>Patient</th>
                <th>Treatment</th>
            </tr>

            <?php while ($record_fk = mysqli_fetch_assoc($record_fk_set)) { ?>
                <tr>
                    <?php 
                        $patient_record = find_record_by_pk("patient", "pid", $record_fk['pid']);
                        $treatment_record = find_record_by_pk("treatment", "tid", $record_fk['tid']);
                    ?>
                    <td><?php echo h($record_fk['tdate']); ?></td>
                    <td><?php echo h($record_fk['tfreq']); ?></td>
                    <td><?php echo h($record_fk['tstatus']); ?></td>
                    <td><?php echo h($patient_record['pid']) ." " .h($patient_record['pfname']) ." " .h($patient_record['plname']); ?></td>
                    <td><?php echo h($treatment_record['tid']) ." " .h($treatment_record['tname']); ?></td> 
                </tr>
            <?php } ?>
    </table>

        <?php mysqli_free_result($record_fk_set); ?>
    </div>
</div>

<?php require(SHARED_PATH ."/footer.php"); ?>
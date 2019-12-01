<?php 
    require_once('../../../private/initialize.php');
    
    $table_name = "treatment";
    $pk = "tid";
    $fk_table_name = "disease";
    $fk = "deid";
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
                <th>Name</th>
                <th>Type</th>
                <th>Target For:</th>
            </tr>

            <tr>
                <td><?php echo h($record[$pk]); ?></td>
                <td><?php echo h($record['tname']); ?></td>
                <td><?php echo h($record['ttype']); ?></td>
                <td><?php echo h($record[$fk]) ." " .h($fk_record['dename']); ?></td>
            </tr>

            <tr>
                <th>Date</th>
                <th>Frequency (/day)</th>
                <th>Status</th>
                <th>Patient</th>
                <th>Physician</th>
            </tr>

            <?php while ($record_fk = mysqli_fetch_assoc($record_fk_set)) { ?>
                <tr>
                    <?php 
                        $patient_record = find_record_by_pk("patient", "pid", $record_fk['pid']);
                        $physician_record = find_record_by_pk("physician", "phid", $record_fk['phid']);
                    ?>
                    <td><?php echo h($record_fk['tdate']); ?></td>
                    <td><?php echo h($record_fk['tfreq']); ?></td>
                    <td><?php echo h($record_fk['tstatus']); ?></td>
                    <td><?php echo h($patient_record['pid']) ." " .h($patient_record['pfname']) ." " .h($patient_record['plname']); ?></td>
                    <td><?php echo h($physician_record['phid']) ." " .h($physician_record['phfname']); ?></td> 
                </tr>
            <?php } ?>
    </table>

        <?php mysqli_free_result($record_fk_set); ?>
    </div>
</div>

<?php require(SHARED_PATH ."/footer.php"); ?>
<?php 
    require_once('../../../private/initialize.php');

    $table_name = "patient_treatment";
    $pk = [];
    $pk['tdate'] = "0000-00-00";
    $pk['tfreq'] = 0;
    $pk['pid'] = "pid";
    $pk['tid'] = "tid";
    $pk['phid'] = "phid";

    if(!isset($_GET['pid']) || !isset($_GET['tid']) || !isset($_GET['phid'])) {
        redirect_to(url_for('/admin/' .$table_name .'/index.php'));
    }
    $pk_val = [];
    $pk_val['tdate'] = "0000-00-00";
    $pk_val['tfreq'] = 0;
    $pk_val['pid'] = $_GET['pid'];
    $pk_val['tid'] = $_GET['tid'];
    $pk_val['phid'] = $_GET['phid'];

    $record_set = find_records_by_id($table_name, $pk, $pk_val);
    $page_title = ucfirst($table_name) ." Details";
    require(SHARED_PATH ."/header.php");
?>

<div id = "content">
    <div class = "<?php echo $table_name ." listing"; ?>">
        <h1><?php echo ucfirst($table_name) ." Details"; ?></h1>
        
        <a class="back-link" href="<?php echo url_for('/admin/' .$table_name .'/index.php'); ?>">&laquo; Back to List</a>

        <table class = "list">
            <tr>
                <th>Date</th>
                <th>Frequency (/day)</th>
                <th>Status</th>
                <th>Patient</th>
                <th>Treatment</th>
                <th>Physician</th>
            </tr>
            <?php while ($record = mysqli_fetch_assoc($record_set)) {; ?>
                
                <?php 
                    $p_record = find_record_by_pk("patient", "pid", $record['pid']);
                    $t_record = find_record_by_pk("treatment", "tid", $record['tid']);
                    $ph_record = find_record_by_pk("physician", "phid", $record['phid']);
                ?>
                <tr>
                    <td><?php echo h(substr($record['tdate'], 0, 10)); ?></td>
                    <td><?php echo h($record['tfreq']); ?></td>
                    <td><?php echo h($record['tstatus']); ?></td>
                    <td><?php echo h($p_record['pfname']) ." " .h($p_record['plname']); ?></td>
                    <td><?php echo h($t_record['tname']); ?></td>
                    <td><?php echo h($ph_record['phfname']); ?></td>
                </tr>
            <?php };?>
    </table>

    </div>
</div>

<?php require(SHARED_PATH ."/footer.php"); ?>
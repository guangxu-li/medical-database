<?php 
    require_once('../../../private/initialize.php');
    
    $table_name = "patient_treatment";
    $pk = "pid";

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
                <th>Date</th>
                <th>Frequency (/day)</th>
                <th>Status</th>
                <th>Patient</th>
                <th>Treatment</th>
                <th>Physician</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>

            <?php while ($record = mysqli_fetch_assoc($record_set)) { ?>
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
                    <td><a class = "action" href = "<?php echo url_for('/admin/' .$table_name .'/show.php?pid=' .h(u($record['pid'])) 
                                                                                                        .'&tid=' .h(u($record['tid'])) 
                                                                                                        .'&phid=' .h(u($record['phid']))); ?>">View</a></td>
                    <td><a class = "action" href = "<?php echo url_for('/admin/' .$table_name .'/edit.php?tdate=' .h(u(substr($record['tdate'], 0, 10))) 
                                                                                                        .'&tfreq=' .h(u($record['tfreq'])) 
                                                                                                        .'&pid=' .h(u($record['pid'])) 
                                                                                                        .'&tid=' .h(u($record['tid'])) 
                                                                                                        .'&phid=' .h(u($record['phid']))); ?>">Edit</a></td>
                    <td><a class = "action" href = "<?php echo url_for('/admin/' .$table_name .'/delete.php?tdate=' .h(u(substr($record['tdate'], 0, 10))) 
                                                                                                        .'&tfreq=' .h(u($record['tfreq'])) 
                                                                                                        .'&pid=' .h(u($record['pid']))
                                                                                                        .'&tid=' .h(u($record['tid'])) 
                                                                                                        .'&phid=' .h(u($record['phid']))); ?>">Delete</a></td>
                </tr>
            <?php } ?>
    </table>

        <?php mysqli_free_result($record_set); ?>
    </div>
</div>

<?php require(SHARED_PATH ."/footer.php"); ?>
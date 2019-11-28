<?php

    $table_name = "patient_treatment";
    $pk = [];
    $pk['tdate'] = "tdate";
    $pk['tfreq'] = "tfreq";
    $pk['pid'] = "pid";
    $pk['tid'] = "tid";
    $pk['phid'] = "phid";
    
    require_once('../../../private/initialize.php');

    if(!isset($_GET['tdate']) || !isset($_GET['tfreq']) || !isset($_GET['pid']) || !isset($_GET['tid']) || !isset($_GET['phid'])) {
        redirect_to(url_for('/admin/' .$table_name .'/index.php'));
    }
    $pk_val = [];
    $pk_val['tdate'] = $_GET['tdate'];
    $pk_val['tfreq'] = $_GET['tfreq'];
    $pk_val['pid'] = $_GET['pid'];
    $pk_val['tid'] = $_GET['tid'];
    $pk_val['phid'] = $_GET['phid'];

    if(is_post_request()) {
        $result = delete_record($table_name, $pk, $pk_val);
        redirect_to(url_for('/admin/' .$table_name .'/index.php'));
    } else {
        $record = find_record_by_pk($table_name, $pk, $pk_val);
        $t_record = find_record_by_pk("treatment", "tid", $pk_val['tid']);
        $ph_record = find_record_by_pk("physician", "phid", $pk_val['phid']);
        $p_record = find_record_by_pk("patient", "pid", $pk_val['pid']);
    }

    $page_title = "Delete " .ucfirst($table_name);
    require(SHARED_PATH ."/header.php");
?>

<div id = "content">
    <a class = "back-link" href = "<?php echo url_for('/admin/' .$table_name .'/index.php'); ?>">&laquo; Back to List</a>

    <div class = "<?php echo $table_name ."delete"; ?>">

        <h1><?php echo "Delete " .ucfirst($table_name); ?></h1>
        <p><?php echo "Are you sure you want to delete this " .$table_name ."?"; ?></p>
        <p class = "item"><?php echo h(substr($record['tdate'], 0, 10)) ." " .h($record['tfreq']) ." times/day " .h($p_record['pfname']) ." " .h($p_record['plname']) ." " .h($t_record['tname'] ." " .h($ph_record['phfname'])); ?></p>

        <form action = "<?php echo url_for('/admin/' .$table_name .'/delete.php?tdate=' .h(u(substr($record['tdate'], 0, 10))) 
                                                                            .'&tfreq=' .h(u($record['tfreq'])) 
                                                                            .'&pid=' .h(u($record['pid'])) 
                                                                            .'&tid=' .h(u($record['tid'])) 
                                                                            .'&phid=' .h(u($record['phid']))); ?>" method = "post">
            <div id = "operations">
                <input type = "submit" name = "commit" value = "<?php echo "Delete " .ucfirst($table_name); ?>" />
            </div>
        </form>
    </div>
</div>

<?php require(SHARED_PATH . '/footer.php'); ?>
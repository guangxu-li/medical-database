<?php 
    require_once('../../../private/initialize.php');
    
    $table_name = "users";
    $pk = "UID";
    $fk_table_name = "department";
    $fk = "did";

    if (!isset($_GET[$pk])){
        redirect_to(url_for('/admin/' .$table_name .'/index.php'));
    }
    $pk_val = $_GET[$pk];

    $record = find_record_by_pk($table_name, $pk, $pk_val);
    $fk_record = find_record_by_pk($fk_table_name, $fk, $record[$fk]);

    $page_title = ucfirst($table_name) ." Details";
    require(SHARED_PATH ."/header.php");
?>

<div id = "content">
    <div class = "<?php echo $table_name ." listing"; ?>">
        <h1><?php echo ucfirst($table_name) ." Details"; ?></h1>
        
        <a class="back-link" href="<?php echo url_for('/admin/' .$table_name .'/index.php'); ?>">&laquo; Back to List</a>

        <table class = "list">
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Role</th>
            </tr>

            <tr>
                <td><?php echo h($record[$pk]); ?></td>
                <td><?php echo h($record['ufname']) ." " .h($record['ulname']); ?></td>
                <td><?php echo h($record['urole']); ?></td>
            </tr>

            <tr>
                <th>Department</th>
                <th>Hospital</th>
            </tr>

            <?php $h_record = find_record_by_pk("hospital", "hid", $fk_record['hid']); ?>
            <tr>
                <td><?php echo h($fk_record['did']) ." " .h($fk_record['dname']); ?></td>
                <td><?php echo h($h_record['hid']) ." " .h($h_record['hname']); ?></td>
            </tr>
        </table>

    </div>
</div>

<?php require(SHARED_PATH ."/footer.php"); ?>
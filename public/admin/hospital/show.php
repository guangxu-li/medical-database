<?php 
    require_once('../../../private/initialize.php');
    
    $table_name = "hospital";
    $pk = "hid";
    $table_name_fk_d = "department";
    $table_name_fk_ph = "physician";

    if (!isset($_GET[$pk])){
        redirect_to(url_for('/admin/' .$table_name .'/index.php'));
    }
    $pk_val = $_GET[$pk];

    $record = find_record_by_pk($table_name, $pk, $pk_val);
    $record_fk_d_set = find_records($table_name_fk_d, $pk, $pk_val);
    $record_fk_ph_set = find_records($table_name_fk_ph, $pk, $pk_val);

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
                <th>Address</th>
                <th>City</th>
                <th>State</th>
                <th>Zipcode</th>
            </tr>

            <tr>
                <td><?php echo h($record[$pk]); ?></td>
                <td><?php echo h($record['hname']); ?></td>
                <td><?php echo h($record['hst_address']); ?></td>
                <td><?php echo h($record['hst_city']); ?></td>
                <td><?php echo h($record['hstate']); ?></td>
                <td><?php echo h($record['hzip']); ?></td>
            </tr>

            <tr>
                <th>Department ID</th>
                <th>Name</th>
                <th>Tel.</th>
            </tr>

            <?php while ($record_fk_d = mysqli_fetch_assoc($record_fk_d_set)) { ?>
                <tr>
                    <td><?php echo h($record_fk_d['did']); ?></td>
                    <td><?php echo h($record_fk_d['dname']); ?></td>
                    <td><?php echo h($record_fk_d['dtel']); ?></td>
                </tr>
            <?php } ?>

            <tr>
                <th>Physician ID</th>
                <th>Name</th>
                <th>Tel.</th>
                <th>Field</th>
            </tr>

            <?php while ($record_fk_ph = mysqli_fetch_assoc($record_fk_ph_set)) { ?>
                <tr>
                    <td><?php echo h($record_fk_ph['phid']); ?></td>
                    <td><?php echo h($record_fk_ph['phfname']); ?></td>
                    <td><?php echo h($record_fk_ph['phtel']); ?></td>
                    <td><?php echo h($record_fk_ph['phspl']); ?></td>
                </tr>
            <?php } ?>
        </table>

        <?php mysqli_free_result($record_fk_d_set); mysqli_free_result($record_fk_ph_set); ?>
    </div>
</div>

<?php require(SHARED_PATH ."/footer.php"); ?>
<?php
    require_once('../../../private/initialize.php');

    $table_name = "department";
    $pk = "did";
    $fk_table_name = "hospital";
    $fk = "hid";

    if (!isset($_GET[$pk])){
        redirect_to(url_for('/admin/' .$table_name .'/index.php'));
    }
    $pk_val = $_GET[$pk];
 
    if (is_post_request()) {

        $record = [];
        $record[$pk] = $pk_val;
        $record['dname'] = $_POST['dname']??"";
        $record['dtel'] = $_POST['dtel']??"";
        $record['dtel'] = substr($dtel, 0, 3) .$hyphen .substr($dtel, 4, 3) .$hyphen .substr($dtel, 8, 4);
        $record[$fk] = $_POST[$fk]??"";
        
        $result = update_record($record, $table_name, $pk, $pk_val);
        if ($result === true) {
            redirect_to(url_for('/admin/' .$table_name .'/show.php?' .$pk .'=' .$pk_val));
        } else {
            $errors = $result;
        }
    } else {
        $record = find_record_by_pk($table_name, $pk, $pk_val);
    }
 
    $page_title = "Edit " .ucfirst($table_name);
    require(SHARED_PATH ."/header.php");
?>

<div id = "content">
    <a class = "back-link" href="<?php echo url_for('/admin/' .$table_name .'/index.php'); ?>">&laquo; Back to List</a>

    <div class = "<?php echo $table_name ." edit"; ?>">
        <h1><?php echo "Edit " .ucfirst($table_name); ?></h1>
        <?php echo display_errors($errors); ?>

        <form action = "<?php echo url_for('/admin/' .$table_name .'/edit.php?' .$pk .'=' . h(u($pk_val))); ?>" method = "post">
            <dl>
                <dt>Department</dt>
                <dd>
                    <input type = "text" name = "dname" value = "<?php echo h($record['dname']); ?>" />
                </dd>
            </dl>
            <dl>
                <dt>Tel. 123-456-7890</dt>
                <dd>
                    <input type = "tel" name = "dtel" pattern = "[0-9]{3}-[0-9]{3}-[0-9]{4}" value = "<?php echo h(u($record['dtel'])); ?>" />
                </dd>
            </dl>
            <dl>
                <dt>Hospital</dt>
                <dd>
                    <select name = "hid">
                    <?php   
                        $fk_record_set = find_all($fk_table_name, $fk);
                        while ($fk_record = mysqli_fetch_assoc($fk_record_set)) {
                            echo "<option value = \"" . h($fk_record[$fk]) . "\"";
                            if($record[$fk] == $fk_record[$fk]) {
                                echo " selected";
                            }
                            echo ">" .h($fk_record[$fk]) ." " .h($fk_record['hname']) . "</option>";
                        }
                        mysqli_free_result($fk_record_set);
                    ?>
                    </select>
                </dd>
            </dl>
            <div id = "operations">
                <input type = "submit" value = "<?php echo "Edit " .ucfirst($table_name); ?>"/>
            </div>
        </form>
    </div>
</div>

<?php require(SHARED_PATH . "/footer.php"); ?>
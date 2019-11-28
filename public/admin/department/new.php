<?php 

    require_once("../../../private/initialize.php");

    $table_name = "department";
    $pk = "did";
    $fk_table_name = "hospital";
    $fk = "hid";

    if(is_post_request()) {

        $record = [];
        $record['dname'] = $_POST['dname'] ?? "";
        $record['dtel'] = $_POST['dtel'] ?? "";
        $record[$fk] = $_POST[$fk] ?? "";

        $result = insert_record($record, $table_name);
        if($result === true) {
            $new_pk_val = mysqli_insert_id($db);
            redirect_to(url_for('/admin/' .$table_name .'/show.php?' .$pk .'=' . $new_pk_val));
        } else {
            $errors = $result;
        }
    } else {
        $record = [];
        $record['dname'] = "";
        $record['dtel'] = "";
        $record[$fk] = "";
    }

    $page_title = "Create " .ucfirst($table_name);
    require(SHARED_PATH .'/header.php');
?>

<div id="content">

    <a class="back-link" href="<?php echo url_for('/admin/' .$table_name .'/index.php'); ?>">&laquo; Back to List</a>

    <div class="<?php echo $table_name ." new"; ?>">
        <h1><?php echo "Create " .$table_name; ?></h1>

        <?php echo display_errors($errors); ?>

        <form action = "<?php echo url_for('/admin/' .$table_name .'/new.php'); ?>" method = "post">
            <dl>
                <dt>Department</dt>
                <dd>
                    <input type = "text" name = "dname" value = "<?php echo h($record['dname']); ?>" />
                </dd>
            </dl>
            <dl>
                <dt>Tel.</dt>
                <dd>
                    <input type = "text" name = "dtel" value = "<?php echo h($record['dtel']); ?>" />
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
                            echo ">" .h($fk_record[$fk]) ." " .h($fk_record['hname']) . "</option>";
                        }
                        mysqli_free_result($fk_record_set);
                    ?>
                    </select>
                </dd>
            </dl>
            <div id = "operations">
                <input type = "submit" value = "<?php echo "Create " .ucfirst($table_name); ?>"/>
            </div>
        </form>
    </div>
</div>

<?php require(SHARED_PATH .'/footer.php'); ?>
<?php 
    require_once("../../../private/initialize.php");

    $table_name = "treatment";
    $pk = "tid";
    $fk_table_name = "disease";
    $fk = "deid";

    if(is_post_request()) {

        $record = [];
        $record['tname'] = $_POST['tname'] ?? "";
        $record['ttype'] = $_POST['ttype'] ?? "";
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
        $record['tname'] = "";
        $record['ttype'] = "";
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
                <dt>Name</dt>
                <dd>
                    <input type = "text" name = "tname" value = "<?php echo h($record['tname']); ?>" />
                </dd>
            </dl>
            <dl>
                <dt>Type</dt>
                <dd>
                    <select name = "ttype">
                        <?php echo "<option value = \"PHARMA\"" .((h($record['ttype'])=="PHARMA")?"selected":"") .">PHARMA</option>"; ?>
                        <?php echo "<option value = \"PROCEDURE\"" .((h($record['ttype'])=="PROCEDURE")?"selected":"") .">PROCEDURE</option>"; ?>
                        <?php echo "<option value = \"SURGERY\"" .((h($record['ttype'])=="SURGERY")?"selected":"") .">SURGERY</option>"; ?>
                    </select>
                </dd>
            </dl>
            <dl>
                <dt>Target For:</dt>
                <dd>
                    <select name = "deid">
                    <?php
                        $fk_record_set = find_all($fk_table_name, $fk);
                        while ($fk_record = mysqli_fetch_assoc($fk_record_set)) {
                            echo "<option value = \"" . h($fk_record[$fk]) . "\"";
                            echo ">" .h($fk_record[$fk]) ." " .h($fk_record['dename']) . "</option>";
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
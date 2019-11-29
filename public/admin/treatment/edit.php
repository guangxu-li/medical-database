<?php
    require_once('../../../private/initialize.php');

    $table_name = "treatment";
    $pk = "tid";
    $fk_table_name = "disease";
    $fk = "deid";

    if (!isset($_GET[$pk])){
        redirect_to(url_for('/admin/' .$table_name .'/index.php'));
    }
    $pk_val = $_GET[$pk];
 
    if (is_post_request()) {

        $record = [];
        $record[$pk] = $pk_val;
        $record['tname'] = $_POST['tname']??"";
        $record['ttype'] = $_POST['ttype']??"";
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
                            if($record[$fk] == $fk_record[$fk]) {
                                echo " selected";
                            }
                            echo ">" .h($fk_record[$fk]) ." " .h($fk_record['dename']) . "</option>";
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
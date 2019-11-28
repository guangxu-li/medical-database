<?php 

    require_once("../../../private/initialize.php");

    $table_name = "patient_treatment";
    $pk = [];
    $pk['tdate'] = "tdate";
    $pk['tfreq'] = "tfreq";
    $pk['pid'] = "pid";
    $pk['tid'] = "tid";
    $pk['phid'] = "phid";

    if(is_post_request()) {

        $record = [];
        $record['tdate'] = $_POST['tdate'] ?? "";
        $record['tfreq'] = $_POST['tfreq'] ?? "";
        $record['tstatus'] = $_POST['tstatus'] ?? "";
        $record['pid'] = $_POST['pid'] ?? "";
        $record['tid'] = $_POST['tid'] ?? "";
        $record['phid'] = $_POST['phid'] ?? "";

        $result = insert_record($record, $table_name);
        if($result === true) {
            redirect_to(url_for('/admin/' .$table_name .'/show.php?tdate=' .h(u(substr($record['tdate'], 0, 10))) 
                                                                .'&tfreq=' .h(u($record['tfreq'])) 
                                                                .'&pid=' .h(u($record['pid'])) 
                                                                .'&tid=' .h(u($record['tid'])) 
                                                                .'&phid=' .h(u($record['phid']))));
        } else {
            $errors = $result;
        }
    } else {
        $record = [];
        $record['tdate'] = "";
        $record['tfreq'] = "";
        $record['tstatus'] = "";
        $record['pid'] = "";
        $record['tid'] = "";
        $record['phid'] = "";
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
                <dt>Date</dt>
                <dd>
                    <input type = "date" name = "tdate" value = "<?php echo h(substr($record['tdate'], 0, 10)); ?>" />
                </dd>
            </dl>
            <dl>
                <dt>Frequency (/day)</dt>
                <dd>
                    <input type = "number" name = "tfreq" value = "<?php echo h($record['tfreq']); ?>" />
                </dd>
            </dl>
            <dl>
                <dt>Status</dt>
                <select name = "tstatus">
                    <?php echo "<option value = \"\"" .((h($record['tstatus'])=="")?"selected":"") ."></option>"; ?>
                    <?php echo "<option value = \"S\"" .((h($record['tstatus'])=="S")?"selected":"") .">S</option>"; ?>
                    <?php echo "<option value = \"F\"" .((h($record['tstatus'])=="F")?"selected":"") .">F</option>"; ?>
                    <?php echo "<option value = \"R\"" .((h($record['tstatus'])=="R")?"selected":"") .">R</option>"; ?>
                </select>
            </dl>
            <dl>
                <dt>Patient</dt>
                <dd>
                    <select name = "pid">
                    <?php
                        $p_record_set = find_all("patient", "pid");
                        while ($p_record = mysqli_fetch_assoc($p_record_set)) {
                            echo "<option value = \"" . h($p_record['pid']) . "\"";
                            echo ">" .h($p_record['pid']) ." " .h($p_record['pfname']) ." " .h($p_record['plname']) ."</option>";
                        }
                        mysqli_free_result($p_record_set);
                    ?>
                    </select>
                </dd>
            </dl>
            <dl>
                <dt>Treatment</dt>
                <dd>
                    <select name = "tid">
                    <?php
                        $t_record_set = find_all("treatment", "tid");
                        while ($t_record = mysqli_fetch_assoc($t_record_set)) {
                            echo "<option value = \"" . h($t_record['tid']) . "\"";
                            echo ">" .h($t_record['tid']) ." " .h($t_record['tname']) ."</option>";
                        }
                        mysqli_free_result($t_record_set);
                    ?>
                    </select>
                </dd>
            </dl>
            <dl>
                <dt>Physician</dt>
                <dd>
                    <select name = "phid">
                    <?php
                        $ph_record_set = find_all("physician", "phid");
                        while ($ph_record = mysqli_fetch_assoc($ph_record_set)) {
                            echo "<option value = \"" . h($ph_record['phid']) . "\"";
                            echo ">" .h($ph_record['phid']) ." " .h($ph_record['phfname']) ."</option>";
                        }
                        mysqli_free_result($ph_record_set);
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
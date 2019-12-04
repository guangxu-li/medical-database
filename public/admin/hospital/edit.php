<?php
    require_once('../../../private/initialize.php');

    $table_name = "hospital";
    $pk = "hid";

    if (!isset($_GET[$pk])){
        redirect_to(url_for('/admin/' .$table_name .'/index.php'));
    }
    $pk_val = $_GET[$pk];
 
    if (is_post_request()) {

        $record = [];
        $record[$pk] = $pk_val;
        $record['hname'] = $_POST['hname']??"";
        $record['hst_address'] = $_POST['hst_address']??"";
        $record['hst_city'] = $_POST['hst_city']??"";
        $record['hstate'] = $_POST['hstate']??"";
        $record['hzip'] = $_POST['hzip']??"";
        
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
                    <input type = "text" name = "hname" value = "<?php echo h($record['hname']); ?>" />
                </dd>
            </dl>
            <dl>
                <dt>Address</dt>
                <dd>
                    <input type = "text" name = "hst_address" value = "<?php echo h($record['hst_address']); ?>" />
                </dd>
            </dl>
            <dl>
                <dt>State</dt>
                <dd>
                    <select name = "hstate", id = "hstate">
                    <option value = "$record['hstate']"><?php echo h($record['hstate']); ?></option>
                    <?php   
                        $state_record_set = find_all("states", "state_code");
                        while ($state_record = mysqli_fetch_assoc($state_record_set)) {
                            echo "<option value = \"" . h($state_record['state_code']) . "\">" .h($state_record['state_code']) ."</option>";
                        }
                        mysqli_free_result($state_record_set);
                    ?>
                    </select>
                </dd>
            </dl>
            <dl>
                <dt>City</dt>
                <dd>
                    <select name = "hst_city" id = "hst_city">
                        <option value = "$record['hst_city']"><?php echo h($record['hst_city']); ?></option>
                        <option value = "0">Please Select State</option>
                    </select>
                </dd>
            </dl>
            <dl>
                <dt>Zipcode</dt>
                <dd>
                    <select name = "hzip" id = "hzip">
                        <option value = "$record['hzip']"><?php echo h($record['hzip']); ?></option>
                        <option value = "0">Please Select State</option>
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
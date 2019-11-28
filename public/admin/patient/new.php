<?php 

    require_once("../../../private/initialize.php");

    $table_name = "patient";
    $pk = "pid";

    if(is_post_request()) {

        $record = [];
        $record['pfname'] = $_POST['pfname'] ?? "";
        $record['plname'] = $_POST['plname'] ?? "";
        $record['pgender'] = $_POST['pgender'] ?? "";
        $record['pbd'] = $_POST['pbd'] ?? "";
        $record['prace'] = $_POST['prace'] ?? "";
        $record['pstatus'] = $_POST['pstatus'] ?? "";

        $result = insert_record($record, $table_name);
        if($result === true) {
            $new_pk_val = mysqli_insert_id($db);
            redirect_to(url_for('/admin/' .$table_name .'/show.php?' .$pk .'=' . $new_pk_val));
        } else {
            $errors = $result;
        }
    } else {
        $record = [];
        $record['pfname'] = "";
        $record['plname'] = "";
        $record['pgender'] = "";
        $record['pbd'] =  "";
        $record['prace'] = "";
        $record['pstatus'] =  "";
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
                <dt>First Name</dt>
                <dd>
                    <input type = "text" name = "pfname" value = "<?php echo h($record['pfname']); ?>" />
                </dd>
            </dl>
            <dl>
                <dt>Last Name</dt>
                <dd>
                    <input type = "text" name = "plname" value = "<?php echo h($record['plname']); ?>" />
                </dd>
            </dl>
            <dl>
                <dt>Gender</dt>
                <dd>
                    <select name = "pgender">
                        <?php echo "<option value = \"M\"" .((h($record['pgender'])=="M")?"selected":"") .">M</option>"; ?>
                        <?php echo "<option value = \"F\"" .((h($record['pgender'])=="F")?"selected":"") .">F</option>"; ?>
                        <?php echo "<option value = \"U\"" .((h($record['pgender'])=="U")?"selected":"") .">U</option>"; ?>
                    </select>
                </dd>
            </dl>
            <dl>
                <dt>Birthday</dt>
                <dd>
                    <input type = "date" name = "pbd" value = "<?php echo h(substr($record['pbd'], 0, 10)); ?>" />
                </dd>
            </dl>
            <dl>
                <dt>Race</dt>
                <dd>
                    <select name = "prace">
                        <?php echo "<option value = \"ASIAN\"" .((h($record['prace'])=="ASIAN")?"selected":"") .">ASIAN</option>"; ?>
                        <?php echo "<option value = \"AFRICAN\"" .((h($record['prace'])=="AFRICAN")?"selected":"") .">AFRICAN</option>"; ?>
                        <?php echo "<option value = \"LATINO\"" .((h($record['prace'])=="LATINO")?"selected":"") .">LATINO</option>"; ?>
                        <?Php echo "<option value = \"WHITE\"" .((h($record['prace'])=="WHITE")?"selected":"") .">WHITE</option>"; ?>
                    </select>
                </dd>
            </dl>
            <dl>
                <dt>Status</dt>
                <dd>
                    <select name = "pstatus">
                        <?php echo "<option value = \"M\"" .((h($record['pstatus'])=="M")?"selected":"") .">M</option>"; ?>
                        <?php echo "<option value = \"S\"" .((h($record['pstatus'])=="S")?"selected":"") .">S</option>"; ?>
                        <?php echo "<option value = \"D\"" .((h($record['pstatus'])=="D")?"selected":"") .">D</option>"; ?>
                        <?php echo "<option value = \"W\"" .((h($record['pstatus'])=="W")?"selected":"") .">W</option>"; ?>
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
<?php 

    require_once("../../../private/initialize.php");

    $table_name = "disease";
    $pk = "deid";

    if(is_post_request()) {

        $record = [];
        $record['dename'] = $_POST['dename'] ?? "";

        $result = insert_record($record, $table_name);
        if($result === true) {
            $new_pk = mysqli_insert_id($db);
            redirect_to(url_for('/admin/' .$table_name .'/show.php?' .$pk .'=' .$new_pk));
        } else {
            $errors = $result;
        }
    } else {
        $record = [];
        $record['dename'] = "";
    }

    $page_title = "Create " .ucfirst($table_name);
    require(SHARED_PATH .'/header.php');
?>

<div id="content">

    <a class="back-link" href="<?php echo url_for('/admin/' .$table_name .'/index.php'); ?>">&laquo; Back to List</a>

    <div class="<?php echo $table_name ." new"; ?>">
    <h1><?php echo "Create " .ucfirst($table_name); ?></h1>

    <?php echo display_errors($errors); ?>

    <form action = "<?php echo url_for('/admin/' .$table_name .'/new.php'); ?>" method = "post">
            <dl>
                <dt><?php echo ucfirst($table_name) ." Name"; ?></dt>
                <dd>
                    <input type = "text" name = "dename" value = "<?php echo h($record['dename']); ?>"/>
                </dd>
            </dl>
            <div id = "operations">
                <input type = "submit" value = "<?php echo "Create " .ucfirst($table_name); ?>"/>
            </div>
        </form>
    </div>
</dvi>

<?php require(SHARED_PATH .'/footer.php'); ?>
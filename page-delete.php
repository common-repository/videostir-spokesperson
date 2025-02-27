<?php
global $wpdb;

if (isset($_POST['yes'])) {

    $sql = $wpdb->prepare('
    DELETE FROM
        `'.VideoStir::getTableName().'`
    WHERE
        `id` = %d
    LIMIT 1
    '
    ,   $_GET['id']
    );

    $wpdb->query($sql);
    
    ?>
    <div style="margin-bottom: 15px;" class="updated">
        <div class="spacer-05">&nbsp;</div>
        Deleting...
        <div class="spacer-05">&nbsp;</div>
    </div>
    <script type="text/javascript">
        <!--
        window.location = "<?php echo get_bloginfo('url') . '/wp-admin/admin.php?page=videostir_options&info=1'; ?> ";
        //-->
    </script>
    <?php
}
?>

<?php include 'css-script.php'; ?>

<div class="wrap">

    <h2><img class="logo" src="<?php echo $this->logo; ?>" alt="VideoStir" />Delete video</h2>
    <div id="poststuff" class="metabox-holder">
        <div style="width: 60%;float: left;">
            <div id="formdiv" class="postbox " >
                <div class="inside">
                    <form method="post" action="">
                        <div class="spacer-10">&nbsp;</div>
                        <label title="Description" for="name">Are you sure want to delete this video?</label><br/><br/>
                        <input type="submit" name="yes" class="nbutton" value="YES" /> <input onclick="window.location = '<?php echo get_bloginfo('url') . '/wp-admin/admin.php?page=videostir_options' ?>'" type="button" class="nbutton" name="no" value="NO" />
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div style="width: 3%;float: left;">&nbsp;</div>
    <div style="width: 37%;float: left;">

        <?php include 'rigth-bar.php'; ?>

    </div>
</div>
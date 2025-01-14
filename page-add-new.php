<?php

global $wpdb;

$info = '';

$videoName = (isset($_POST['name'])) ? $_POST['name'] : 'VideoStir clip';
$embed = (isset($_POST['embed'])) ? stripslashes($_POST['embed']) : '';

function generateParamsForEmbedLine($hash,&$errorMessages)
{
    $allData = array();
    $params = array();
    $position = array();
    $position['bottom']='0';
    $position['right']='350';
    $allData['position'] = $position;
    $allData['width'] = '448';
    $allData['height'] = '252';
    $allData['url'] = $hash;

    if (!ctype_alnum($allData['url']) || strlen($allData['url']) !== 32) {
        $errorMessages[] = 'Clip ID is not valid.';
    }

    $params['auto-play']='true';
    $params['auto-play-limit']='10';
    $params['playback-delay']='0';
    $params['on-finish']='play-button';
    $params['on-click-open-url']='';
    $params['extrab']='2';
    $allData['settings'] = $params;
    return $allData;
}

if (isset($_POST['apply'])) {
    
    $errorMessages = array();
    $matches = array();

    if (strlen($embed) < 16) {
        $errorMessages[] = 'Code is empty.';
    } else {
        preg_match('/\<script\>\s*VS\.Player\.show\((.+)\);\s*\<\/script\>/s', $embed, $matches);
    }
    $embedHash=false;
    $newEmbedHash = false;
    if (!count($matches) ) // if it's not regular embed code
    {
        $pos=strstr($embed,'vsembed.js');
        if ($pos)
        {
            $embedHash = substr($embed,strlen($embed)-41,32);

        }
    }

    if (!count($matches) ) // if it's not regular embed code
    {
        $pos=strstr($embed,'videostir.start');
        if ($pos)
        {
            $pos = strrpos($embed,'videoHash=');            
            $newEmbedHash = substr($embed,$pos+11,32);
        }
    }

    //var_dump($matches);
    //exit();
    $playerParams = array();
    if (count($matches)) {
        $settings = $matches[1];

        preg_match('/(".+"|{.+})\s*,\s*([0-9]+)\s*,\s*([0-9]+)\s*,\s*"(\w+)"\s*,\s*({.+})/s', $settings, $matches);

        if (count($matches) != 6) {
            $errorMessages[] = 'Unknown format for "VS.Player".';
        }
		
		
        $playerParams['position'] = $matches[1];
        if ($playerParams['position'][0] != '"') {
            $playerParams['position'] = json_decode($playerParams['position'], true);
            if ($playerParams['position'] == null) {
                $errorMessages[] = 'Error parsing position object.';
            }
        }
        
        $playerParams['width']  = $matches[2];
        $playerParams['height'] = $matches[3];
        
        $playerParams['url']    = $matches[4];
        if (!ctype_alnum($playerParams['url']) || strlen($playerParams['url']) !== 32) {
            $errorMessages[] = 'Clip ID is not valid.';
        }
        $playerParams['settings'] = json_decode($matches[5], true);
        if ($playerParams['settings'] == null) {
            $errorMessages[] = 'Error parsing special parameters.';
        }
    }
    else if ($embedHash)
    {
        // $params = array();
        // $position = array();
        // $position['bottom']='0';
        // $position['right']='350';
        // $playerParams['position'] = $position;
        // $playerParams['width'] = '448';
        // $playerParams['height'] = '252';
        // $playerParams['url'] = $embedHash;

        // if (!ctype_alnum($playerParams['url']) || strlen($playerParams['url']) !== 32) {
        //     $errorMessages[] = 'Clip ID is not valid.';
        // }

        // $params['auto-play']='true';
        // $params['auto-play-limit']='10';
        // $params['playback-delay']='0';
        // $params['on-finish']='play-button';
        // $params['on-click-open-url']='';
        // $params['extrab']='2';
        // $playerParams['settings'] = $params;

        $playerParams = generateParamsForEmbedLine($embedHash,$errorMessages);
    }
    else if ($newEmbedHash)
    {
        $playerParams = generateParamsForEmbedLine($newEmbedHash,$errorMessages);
        //var_dump($playerParams);
    }
    if (!count($errorMessages)) {
        
        

        $sql = $wpdb->prepare('
        INSERT INTO `'.VideoStir::getTableName().'`
        (
            `name`
        ,   `pages`
        ,   `active`
        
        ,   `position`
        ,   `width`
        ,   `height`
        ,   `url`
        ,   `settings`
        ) VALUES (
            %s
        ,   %s
        ,   %d
        
        ,   %s
        ,   %d
        ,   %d
        ,   %s
        ,   %s
        )', 
                
            $videoName
        ,   ''
        ,   1
                
        ,   ''
        ,   $playerParams['width']
        ,   $playerParams['height']
        ,   $playerParams['url']
        ,   ''
        );

        $wpdb->query($sql);
        
        ?>
        <div style="margin-bottom: 15px;" class="updated">
            <div class="spacer-05">&nbsp;</div>
            Has added a new video.<br/>
            Redirect to edit.
            <div class="spacer-05">&nbsp;</div>
        </div>
        <script type="text/javascript">
        <!--
        window.location = "<?php echo get_bloginfo('url').'/wp-admin/admin.php?page=videostir_options_sub&action=edit&id='.$wpdb->insert_id; ?> ";
        //-->
        </script>
        <?php
    } else {
        $info['type'] = 'Error';
        $info['text'] = 'Please paste the correct code.<br/>'.implode('<br/>', $errorMessages);
    }
}
?>

<?php include 'css-script.php'; ?>

<div class="wrap">

    <h2>Add new video</h2>
    <!--<h2><img class="logo" src="<?php echo $this->logo; ?>" alt="VideoStir" /> Add new video</h2>-->

    <?php if ($info != '') { ?>
        <div style="margin-bottom: 15px; color: #c00;" class="messages <?php echo $info['type']; ?>">
            <div class="spacer-05">&nbsp;</div>
            <?php echo $info['text']; ?>
            <div class="spacer-05">&nbsp;</div>
        </div>
    <?php } ?>

    <div id="poststuff" class="metabox-holder">
        <div style="width: 60%;float: left;">

<!--            <div id="formdiv" class="postbox " style=" box-shadow: 0 5px 15px rgba(0,0,0,0.15);border: 1px solid rgba(0,0,0,0.25);padding: 20px" >
                <h2 style="margin: 10px 0 0px;">INSTRUCTIONS  (You can also watch the tutorial video on this page)</h2>
                <ol>
                    <li>In the green textbox below, paste the embed line you got from <a href="http://videostir.com/?page=wp-instructions">videostir.com</a> after transforming your video into a floating clip (or use one from our <a target="_blank" href="http://videostir.com/clips-stock/try-a-free-clip?page=wp-market">clip library</a>).</li>
                    <li>Click "Next".</li>
                    <li>You can now give your clip a name, adjust its customization parameters to suit your preferences, and choose in which pages/posts your clip will appear.</li>
                    <li>Click "Apply".</li>
                </ol>
            </div>-->

            <div id="formdiv" class="postbox " style=" box-shadow: 0 5px 15px rgba(0,0,0,0.15);border: 1px solid rgba(0,0,0,0.25);" >

                <div class="inside">
                    <form method="post" action="" onsubmit="return videostirValidateNewVideo();">
                        <h2 style="margin: 10px 0 0px;">ADD A NEW CLIP TO YOUR WORDPRESS SITE</h2>
                        
                        <p>In the green textbox below, paste your clip's embed line you got either from your own <a href="http://videostir.com/account/my-videos/?page=wp-instructions">Video List</a>, after transforming your video into a floating clip or from our <a target="_blank" href="http://videostir.com/clips-stock/try-a-free-clip?page=wp-market">pre-made clip library</a> that you can use (just add one to your account for free). You can also watch the tutorial video on this page to learn more.</p>
                   
                        <div class="spacer-5">&nbsp;</div>
                        
                        <label><b>Paste embed code below (and click next):</b><br/><textarea style="width: 100%;border-color: #719ECE;background-color: #A6FF9C;" rows="4" id="embed" name="embed"><?php echo stripslashes($embed); ?></textarea></label>
                        <label>Name (optional)<br/><input id="name" name="name" value="<?php echo $videoName; ?>" /></label>
                        <p style="text-align: right;">
<!--                            <button type="button" class="nbutton" onclick="window.open('http://videostir.com/video/download/1')">HELP</button>-->
                            <button type="button" class="nbutton effect3"  onclick="window.location='<?php echo get_bloginfo('url').'/wp-admin/admin.php?page=videostir_options' ?>'">CANCEL</button>
                            <button type="submit" class="nbutton" ><strong>NEXT</strong></button>
                            <input type="hidden" name="apply" />
                        </p>
                    </form>
                </div>
                
            </div> 

             <div id="formdiv" class="postbox" style=" box-shadow: 0 5px 15px rgba(0,0,0,0.15);border: 1px solid rgba(0,0,0,0.25);">
                <h3 style="cursor: default;">Tutorial &mdash; How to use this plugin</h3>
                <iframe title="YouTube video player" class="youtube-player" type="text/html" width="100%" height="550" src="http://www.youtube.com/embed/_jmNZoMLFlc?theme=light&color=white&showinfo=0&controls=1&wmode=transparent&rel=0" frameborder="0" allowFullScreen></iframe>
            </div> 

        </div>

        <div style="width: 3%; float: left;">&nbsp;</div>
        <div style="width: 37%;float: left;">
            <?php include 'rigth-bar.php'; ?>
        </div>
        
    </div>

    <br class="clear">
</div>
      

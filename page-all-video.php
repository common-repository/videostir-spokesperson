<?php
global $wpdb;

$data = $wpdb->get_results('SELECT * FROM `'.VideoStir::getTableName().'`', ARRAY_A);
?>

<?php include 'css-script.php'; ?>

<div class="wrap">

    <h2>My videos <input onclick="window.location = 'admin.php?page=videostir_options_sub'" type="button" class="nbutton" name="no" value="ADD NEW VIDEO" /> </h2>
    <!--<h2><img class="logo" src="<?php echo $this->logo; ?>" alt="VideoStir" />My videos <input onclick="window.location = 'admin.php?page=videostir_options_sub'" type="button" class="nbutton" name="no" value="ADD NEW VIDEO" /> </h2>-->
    <?php if (isset($_GET['info'])) { ?>
        <div style="margin-bottom: 15px;" class="updated">
            <div class="spacer-05">&nbsp;</div>
            <?php
            switch ($_GET['info']) {
                case 1:
                    echo 'Video deleted.';
                    break;
                case 2:
                    echo 'Video enabled.';
                    break;
                case 3:
                    echo 'Video disabled.';
                    break;
            }
            ?>
            <div class="spacer-05">&nbsp;</div>
        </div>
    <?php } ?>

    
    
    <div id="poststuff" class="metabox-holder">
        <div style="width: 58%;float: left;border: 1px solid rgba(0,0,0,0.25); box-shadow: 0 5px 15px rgba(0,0,0,0.15);">

             <?php if (!count($data)): ?>
                    <div style="padding:20px;">
                        <h1 style="color:#0093c7">THANK YOU FOR INSTALLING THIS PLUGIN!</h1>
                    </div>
                    <div id="formdiv" class="postbox" style="padding:25px;">
                        <div class="inside">
                            <center>
                                
                                <button class="big-green-button make-clip" onclick="window.open('http://videostir.com/?page=wp-demo-btn&test-on-site=<?php echo get_site_url(); ?>')">SEE A DEMO ON YOUR SITE</button>
                               <p>-- AND THEN --</p>
                                <!-- <input onclick="window.location = 'admin.php?page=videostir_options_sub'" type="button" class="nbutton" name="no" value="ADD NEW" /> -->
                                <button class="big-green-button make-clip" onclick="window.open('http://videostir.com/?page=wp-side-start-here&start-step=1')">MAKE YOUR OWN CLIP</button>
                                <p>-- OR --</p>
                                <button class="big-blue-button use-premade" onclick="window.open('http://videostir.com/clips-stock/categories/?page=wp-stock-button')">USE A PRE-MADE CLIP</button>
                                  <!-- <iframe src="https://videostir.com/demo/start-on-outside/?page=wp-side-start-here" width="370" height="100" style="padding:5px;margin-left:-25px;" align="center"></iframe> -->
                                  <!-- <h3 style="color:red">Don't have your own video to use yet?<br>Get a professionally made <a href="http://videostir.com/clips-stock/try-a-free-clip" target="blank">PRE-MADE CLIP</a> from our library</h3> -->
                                  <br><br>
                                  <table>
                                      <tr>
                                        <td>
                                            <div class="pre-made-image">
                                                <a class="text-uppercase" onclick="window.open('http://videostir.com/clips-stock/selected/7a2852f3c11432fb8da89da4b57dd0c3?page=wp-market-pre1');">
                                                  <img width="200px" src="http://d11wbxl9l7koq0.cloudfront.net/stock-thumbnails/get-the-deal-thumb.png" />
                                                </a>                                        
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pre-made-image" >
                                                <a class="text-uppercase" onclick="window.open('http://videostir.com/clips-stock/selected/46e9dd86a91830a10810eb08e78aa0bd?page=wp-market-pre1');">
                                                  <img width="200px" src="http://d11wbxl9l7koq0.cloudfront.net/stock-thumbnails/signup-now-thumb.png" />
                                                </a>
                                            </div>        
                                        </td>

                                        <td>
                                            <div class="pre-made-image">
                                                <a class="text-uppercase" onclick="window.open('http://videostir.com/clips-stock/selected/b70d2750ecd64e6f0dab865f6074c4bc?page=wp-market-pre1');">
                                                  <img width="200px" src="http://d11wbxl9l7koq0.cloudfront.net/stock-thumbnails/call-now-thumb.png" />
                                                </a>
                                            </div>  
       
                                        </td>
                                        
                                      </tr>
                                  </table>
                                <p>-- OR --</p>
                                <button class="big-blue-button use-premade" onclick="window.open('http://videostir.com/spokespersons/?page=wp-side-actor')">CHOOSE AN ACTOR</button> 
                                    
                                    

                              </center>
                        </div>
                    </div>


                    <div style="padding:20px;">
                        <h1 style="color:#0093c7">ABOUT VIDEOSTIR'S INTERACTIVE VIDEO TECHNOLOGY</h1>
                    </div>    
                    <br>
                    <div id="formdiv" class="postbox" style=" box-shadow: 0 5px 15px rgba(0,0,0,0.15);border: 1px solid rgba(0,0,0,0.25);">
                        <div class="inside">
                            <iframe title="YouTube video player" style="padding-top:10px" class="youtube-player" type="text/html" width="100%" height="300" src="http://www.youtube.com/embed/BjL-8vIp9-s?theme=light&color=white&showinfo=0&controls=1&wmode=transparent&rel=0" frameborder="0" allowFullScreen></iframe>
                        </div>
                    </div>
                    
<!--                    <div style="padding:20px;">
                        <h1 style="color:#0093c7">WANT TO SEE A FLOATING CLIP IN ACTION?</h1>
                    </div>
                     <div id="formdiv" class="postbox " style=" box-shadow: 0 5px 15px rgba(0,0,0,0.15);border: 1px solid rgba(0,0,0,0.25);" >
                        <div class="inside">
                            <iframe src="https://videostir.com/demo/test-on-outside?page=wp-side-test-on-site" width="370" height="110" style="padding:0px;" align="center"></iframe>
                        </div>
                    </div>-->



      

                    <!-- <div id="formdiv" class="postbox">

                        <h3 style="cursor: default;">Tutorial &mdash; How to use this plugin</h3>
                        <iframe title="YouTube video player" class="youtube-player" type="text/html" width="100%" height="550" src="http://www.youtube.com/embed/_jmNZoMLFlc?theme=light&color=white&showinfo=0&controls=1&wmode=transparent&rel=0" frameborder="0" allowFullScreen></iframe>
                    </div> -->
            
              <?php endif; ?>
            <br><br>  
            <table class="wp-list-table widefat fixed posts" cellspacing="0">
                <thead>
                    <tr>
                        <th style="width: 20px;">#</th>
						<th>Video id</th>
                        <th>Video name</th>
                        <th>Pages / Posts</th>
                        <th style="width: 120px;">Actions</th>
                    </tr>
                </thead>

                <?php if (count($data) > 5): ?>
                <tfoot>
                    <tr>
                        <th style="width: 20px;">ID</th>
						<th>Video hash</th>
                        <th>Video name</th>
                        <th>Pages / Post</th>
                        <th style="width: 120px;">Actions</th>
                    </tr>    
                </tfoot>
                <?php endif; ?>

                <tbody id="the-list" class="list:post">
                    <?php
                    if (!empty($data)) {
                        foreach ($data as $video) {
                            ?>
                            <tr>
                                <td style="border-bottom-width: 0;">#<?php echo $video['id'] ?></td>
								<td style="border-bottom-width: 0;"><?php echo substr($video['url'], 0,5) ?></td>
                                <td style="border-bottom-width: 0;"><?php echo $video['name'] ?></td>
								<td>
									<?php
										$ids = (strlen($video['pages'])) ? explode(',', $video['pages']) : array();
										if (count($ids)) {
											foreach ($ids as $id) {
												if (intval($id) === 0) {
													echo '(Page) Home<br/>';
												} else {
													$p = get_post($id);
													echo '('.ucfirst($p->post_type).') ';
													echo $p->post_title.'<br/>';
												}
											}
										}
									?>
								</td>
                                <td style="border-bottom-width: 0;">
                                    <?php echo '<a href="' . get_bloginfo('url') . '/wp-admin/admin.php?page=videostir_options_sub&action=edit&id=' . $video['id'] . '">edit</a>'; ?> 
                                    - 
                                    <?php echo '<a href="' . get_bloginfo('url') . '/wp-admin/admin.php?page=videostir_options_sub&action=delete&id=' . $video['id'] . '">delete</a>'; ?>
                                    -
                                    <?php
                                    if ($video['active'] == 0) {
                                        echo '<a href="' . get_bloginfo('url') . '/wp-admin/admin.php?page=videostir_options_sub&action=active&active=1&id=' . $video['id'] . '">enable</a>';
                                    } else {
                                        echo '<a href="' . get_bloginfo('url') . '/wp-admin/admin.php?page=videostir_options_sub&action=active&active=0&id=' . $video['id'] . '">disable</a>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                            /*
                            $ids = (strlen($video['pages'])) ? explode(',', $video['pages']) : array();
                            
                            if (count($ids)) {
                                echo '<tr>';
                                echo '<td>&nbsp;</td>';
                                echo '<td colspan="3">';
                                foreach ($ids as $id) {
                                    if (intval($id) === 0) {
                                        echo '(Page) Home<br/>';
                                    } else {
                                        $p = get_post($id);
                                        echo '('.ucfirst($p->post_type).') ';
                                        echo $p->post_title.'<br/>';
                                    }
                                }
                                echo '</td>';
                                echo '</tr>';
                            }
							*/
                        }
                    } else {
                        ?>
                            
                        <tr>
                            <td colspan="4" style="color: #c00;">No videos yet</td>
                        </tr>
                            
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <?php if (count($data)): ?>
            
                    <div style="padding:20px;">
                        <h1 style="color:#0093c7">USE ONE OF OUR PREMADE CLIPS</h1>
						<h4 style="color:#0093c7">(Easily change the text on the clip and its behaviour to fit your needs)</h4>
                    </div>
                    <div id="formdiv" class="postbox" style="padding:25px;">
                        <div class="inside">
                            <center>
                                  <br><br>
                                <a href="http://videostir.com/clips-stock/categories/?page=wp-stock-image" onclick="window.open(this.href); return false;" ><img src="<?php bloginfo('url'); ?>/wp-content/plugins/videostir-spokesperson/screenshot-1.png" width="90%" alt="VideoStir" /></a>                                    
                                    
                              </center>
                        </div>
                    </div>
            <?php endif; ?>
        </div>
        
        
        
        
    </div>
    <div style="width: 3%;
         float: left;
         ">&nbsp;</div>
    <div style="width: 37%;
         float: left;
         ">

        <?php include 'rigth-bar.php'; ?>

    </div>
    <script src='https://30598eaa91b21f1b10c2-f494899fb95a015999144f5a55caa77b.ssl.cf1.rackcdn.com/videostir.start.min.js' videoHash='c84e3e5fd04203388a2a3eb77c21f94d' ></script>
</div>
<?php

defined('ABSPATH') OR exit;

/*
  Plugin Name: VideoStir Spokesperson
  Plugin URI: http://wordpress.org/extend/plugins/videostir-spokesperson/
  Description: With this plugin you can easily add interactive videos of a new kind to your site's pages and posts, to engage/convert your traffic in 2 minutes - Video calls to action with buttons, forms and emails.
  Version: 2.1.68
  Author: VideoStir team
  Author URI: http://videostir.com/?utm_source=wp-plugin&utm_medium=plugin&utm_campaign=wp-plugin
 */

/**
 * @see http://codex.wordpress.org/Function_Reference/register_activation_hook
 * @see http://codex.wordpress.org/Function_Reference/register_deactivation_hook
 * @see http://codex.wordpress.org/Function_Reference/register_uninstall_hook
 */
register_activation_hook(   __FILE__, array('VideoStir', 'on_activation'));
register_deactivation_hook( __FILE__, array('VideoStir', 'on_deactivation'));
register_uninstall_hook(    __FILE__, array('VideoStir', 'on_uninstall'));

add_action('wp_enqueue_scripts',      array('VideoStir', 'init_resources'));
add_action('admin_enqueue_scripts',   array('VideoStir', 'init_resources'));
//add_action('wp_print_styles', 'add_my_stylesheet');
require_once(ABSPATH.'wp-admin/includes/plugin.php');

class VideoStir
{
    var $icon;
    var $logo;
    
    /**
     * Plugin version.
     * @var sting
     */
    const VERSION = '2.1.68';
    
    /**
     * WP option name where plugin's version is saved.
     * @var sting
     */
    const WP_OPTION_NAME = 'videostir_plugin_version';
    
    /**
     * Table name in DB.
     * @var string
     */
    const TABLE_NAME = 'videostir_videos';

    function __construct()
    {
        $this->icon = get_bloginfo('url').'/wp-content/plugins/videostir-spokesperson/img/icon.png';
        $this->logo = get_bloginfo('url').'/wp-content/plugins/videostir-spokesperson/img/logo.png';

        add_action('admin_menu', array($this, 'config_page'));
        add_action('wp_footer',  array($this, 'vs_wp_footer'));

         

    }
    
    public static function getTableName()
    {
        global $wpdb;
        return $wpdb->prefix.self::TABLE_NAME;
    }
    
    public static function init_resources()
    {
        wp_enqueue_script('jquery');
        wp_enqueue_script('swfobject');
        wp_enqueue_script('videostir-spokesperson.plugin', plugins_url('/js/videostir.wp.plugin.js', __FILE__), array('jquery', 'swfobject'));
        wp_enqueue_script('videostir-spokesperson.player', plugins_url('/js/2.20/vs.player.min.js', __FILE__), array('videostir-spokesperson.plugin'));
        wp_enqueue_script('videostir-spokesperson.h5.lib', plugins_url('/js/2.20/html5.videostir.full.lib.js', __FILE__), array('videostir-spokesperson.player'));
        wp_enqueue_script('videostir-spokesperson.h5.player', plugins_url('/js/2.20/html5.videostir.cross.min.js', __FILE__), array('videostir-spokesperson.h5.lib'));
        wp_enqueue_script('videostir-spokesperson.data', plugins_url('/js/2.20/vs.player.embed.js', __FILE__), array('videostir-spokesperson.h5.player'));
    }

    public static function add_my_stylesheet() {
            $myStyleUrl = WP_PLUGIN_URL . '/videostir-spokesperson.plugin/style.css';
            $myStyleFile = WP_PLUGIN_DIR . '/videostir-spokesperson/style.css';
            if ( file_exists($myStyleFile) ) {
                wp_register_style('myStyleSheets', $myStyleUrl);
                wp_enqueue_style( 'myStyleSheets');
            }
        }

    function vs_wp_footer()
    {
        global $wpdb, $wp_query;

        $videos = $wpdb->get_results('SELECT * FROM `'.self::getTableName().'` WHERE `active` = 1;', ARRAY_A);

        $page = $wp_query->get_queried_object();
        $pageid = $page->ID;
        $home = '';

        if ($pageid == '') {
            $home = '0';
        }

        if (is_home() || is_front_page()) {
            $home = '0';
        }

        foreach ($videos as $video) {
            $pages = explode(',', $video['pages']);

            $print = false;
            if ($pages[0] != '') {
                if ($home != '') {
                    if (in_array(0, $pages)) {
                        echo VideoStir::createPlayerJs($video);
                        $print = true;
                    }
                }

                if (!$print) {
                    if (in_array($pageid, $pages)) {
                        echo VideoStir::createPlayerJs($video);
                    }
                }
            }
        }
    }
    
    /**
     * Makes JavaScript for embedding video clip by DB row record.
     * 
     * @param array $videoRow
     * @return string
     */

    function get_active_plugin_version($plugin_path_file, $sitewide = false)
    {
        return get_active_plugin_attribute($plugin_path_file,'Version');
    }

    static function createPlayerJs(array $videoRow)
    {
        $js = '';
        
        
        if (!empty($videoRow)) {
            if ($videoRow['position'])
            {
                $js.= '<script>VS.Player.show(';
                $js.= (is_array(unserialize($videoRow['position']))) ? json_encode(unserialize($videoRow['position'])) : unserialize($videoRow['position']);
                $js.= ', '.$videoRow['width'];
                $js.= ', '.$videoRow['height'];
                $js.= ', "'.$videoRow['url'].'"';
                
                $customJs = false;
                $settings = unserialize($videoRow['settings']);
                if (isset($settings['on-click-event'])) {
                    $customJs = stripslashes($settings['on-click-event']);
                    $settings['on-click-event'] = true;
                }
                $js.= ', '.json_encode($settings);
                
                $js.= ');';
                $js=str_replace(',"quiet":false','',$js);
                if ($customJs !== false) {
                    $js.= PHP_EOL;
                    $js.= 'VS.jQuery(document).bind("onclick.vs-player", function() {';
                    $js.= 'VS.Player.Api.pause();';
                    $js.= $customJs;
                    $js.= '});';
                }
                
                $js.= '</script>'.PHP_EOL;    
            }
            else
            {
                $js.='<script>getVsParams("'.$videoRow['url'].'")</script>'.PHP_EOL;
            }

            $plugin_data = get_plugin_data( __FILE__ );
            $plugin_version = $plugin_data['Version'];


            $js.='<script>console.log("videostir-spokesperson plugin version:'.$plugin_version.'")</script>';
            
        }
        
        return $js;
    }

    /**
     * @see http://wordpress.stackexchange.com/questions/25910/uninstall-activate-deactivate-a-plugin-typical-features-how-to/25979#25979
     * @see http://codex.wordpress.org/Creating_Tables_with_Plugins
     */
    function on_activation()
    {
        if (!current_user_can('activate_plugins')) {
            return;
        }
        
        $installedVersion = get_option(self::WP_OPTION_NAME);
        
        if ($installedVersion != self::VERSION) {
            // custom actions for upgrades if required
        }
        
        $sql = '
        CREATE TABLE IF NOT EXISTS `'.self::getTableName().'`
        (
            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT
        ,   `name` VARCHAR(64) COLLATE utf8_unicode_ci NOT NULL
        ,   `pages` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL
        ,   `active` TINYINT UNSIGNED NOT NULL
        
        ,   `position` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL
        ,   `width` INT UNSIGNED NOT NULL
        ,   `height` INT UNSIGNED NOT NULL
        ,   `url` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL
        ,   `settings` TEXT COLLATE utf8_unicode_ci NOT NULL

        
        ,   PRIMARY KEY (`id`)
        )
        ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;
        ';

//        require_once(ABSPATH.'wp-admin/includes/upgrade.php');
//        dbDelta($sql);
        
        global $wpdb;

        $wpdb->query($sql);
        
        if (empty($installedVersion)) {
            add_option(self::WP_OPTION_NAME, self::VERSION);
        } else {
            update_option(self::WP_OPTION_NAME, self::VERSION);
        }
    }

    function on_deactivation()
    {
        if (!current_user_can('activate_plugins')) {
            return;
        }
    }
    
    function on_uninstall()
    {
        if (!current_user_can('activate_plugins')) {
            return;
        }
        
        global $wpdb;

        $sql = 'DROP TABLE `'.self::getTableName().'`';
        $wpdb->query($sql);
        
        delete_option(self::WP_OPTION_NAME);
    }

    function config_page()
    {
        add_menu_page('VideoStir', 'VideoStir', 8, 'videostir_options', array(&$this, 'cf_all_video'), $this->icon);
        
        add_submenu_page('videostir_options', 'My Videos', 'My videos', 8, 'videostir_options', array(&$this, 'cf_all_video'));
        add_submenu_page('videostir_options', 'Add New Video', 'Add new', 8, 'videostir_options_sub', array(&$this, 'cf_actions'));
        add_submenu_page('videostir_options', 'Additional features', 'Additional features', 8, 'videostir_coming_features', array(&$this, 'cf_coming_features'));
//	add_submenu_page('videostir_options', 'Testimonials', 'Testimonials', 8, 'videostir_customers_testimonials', array(&$this, 'cf_testimonials'));
	add_submenu_page('videostir_options', 'Affiliate plan', 'Affiliate plan', 8, 'videostir_affiliate_program', array(&$this, 'cf_affiliates'));

	}
	
    function cf_all_video()
    {
        include 'page-all-video.php';
    }

    function cf_actions()
    {
        if (!isset($_GET['action'])) {
            include 'page-add-new.php';
        } else {
            if ($_GET['action'] == 'delete') {
                include 'page-delete.php';
            } else {
                if($_GET['action'] == 'active') {
                    include 'page-active.php';
                } else {
                    include 'page-edit.php';
                }
            }
        }
    }
	
    function cf_coming_features()
    {
	   include 'page-coming-features.php';
	}
	
	function cf_testimonials()
    {
	   include 'page-testimonials.php';
	}
	
	function cf_affiliates()
    {
	   include 'page-affiliates.php';
	}
	
}

new VideoStir();

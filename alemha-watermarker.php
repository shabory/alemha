<?php
/*
  Plugin Name: Alemha Watermarker
  Plugin URI: http://alemha.mnbaa.com/
  Description: Allow you to add your watermark or signature to your website images both of text and image watermark are enabled.
  Author: Mnbaa CO
  Author URI: http://www.mnbaa.com
  Version: 1.4
  Text Domian: mnbaa_watermark
  Domain Path: /languages/
 */

$dir_name=plugin_dir_path(__FILE__);

//load arrays
include (plugin_dir_path(__FILE__) . 'helpers/arrays.php');

//load helper
include (plugin_dir_path(__FILE__) . 'helpers/mnbaa_functions.php');
include (plugin_dir_path(__FILE__) . 'helpers/wp_functions.php');

include_once (plugin_dir_path(__FILE__) . '/libraries/I18N/Arabic.php');

//load text domain file for translating
load_plugin_textdomain('mnbaa_watermark', false, dirname(plugin_basename(__FILE__)) . '/languages/');

//script file for upload image
//wp_enqueue_script('image-js', plugins_url( '', __FILE__ ).'/views/js/image-js.js');

// //load  contoller file which called by ajax
include (plugin_dir_path(__FILE__) . 'controllers/ajax_functions.php');

function add_x_scroll_style() {
//    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {
        //load ajax files
        wp_register_script("watermark_ajax", plugins_url( '', __FILE__ ) . '/views/js/watermark_ajax.js', array('jquery'));
        wp_localize_script('watermark_ajax', 'ajax', array('ajaxurl' => admin_url('admin-ajax.php')));
        wp_enqueue_script('watermark_ajax');

        wp_register_script("image-js", plugins_url( '', __FILE__ ) . '/views/js/image-js.js', array('jquery'));
        wp_localize_script('image-js', 'myAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
        wp_enqueue_script('image-js');
        
        wp_register_script("preview-js", plugins_url( '', __FILE__ ) . '/views/js/preview-js.js', array('jquery'));
        wp_localize_script('preview-js', 'myAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
        wp_enqueue_script('preview-js');
        
       // wp_enqueue_script("jquery-1.10.2",'//code.jquery.com/jquery-1.10.2.js', array('jquery'));
        wp_enqueue_script("jquery-ui",'//code.jquery.com/ui/1.11.4/jquery-ui.js', array('jquery'));
        wp_enqueue_style( 'jquery-ui-css', "//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css");
        wp_enqueue_style( 'style',"/resources/demos/style.css");

    }

add_action('admin_enqueue_scripts', 'add_x_scroll_style');



$watermark_prefix="mnbaa_watermark_";

//load  contoller file which called by ajax
//include (plugin_dir_path(__FILE__) . 'controllers/ajax_functions.php');

//call action on initialization
Mnbaa_Watermark_RunPlugin();
?>
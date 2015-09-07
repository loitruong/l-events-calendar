<?php
/*
Plugin Name: L Events Calendar
Description: A beautiful responsive calendar. Manage events with ease and simplicity.
Version: 1.0.1
Author: Loi Truong
Author URI: http://loitruong.us
*/
if (!class_exists('LEC_Plugin'))
{
  class LEC_Plugin
  {

    public function __construct()
    {
      /*
        Option Page of the Plugin
      */
      include_once('core/option-page.php');
      $OptionPage = new OptionPage();
      /*
        initinal Post type
      */
      if(!post_type_exists("l-event")){
        include_once('core/initial-post-type.php');
      }
      /*
       Custom fields
      */
      include_once('core/l-events-custom-fields.php');

      /*
        Add Script to admin panel
      */
      add_action( 'admin_enqueue_scripts', array($this, 'lec_admin_scripts' ) );

      /*
        Add Shortcode
      */
      include_once('core/shortcode.php');

      /*
        Add Script to the site
      */
      add_action( 'wp_enqueue_scripts', array($this, 'lec_wp_scripts' ) );

      /*
        Calendar API
      */
      include_once('core/calendar-api.php');

      /*
        Custom Button for TinyMCE
      */
      include_once('core/custom-media-button.php');

    }
    /**
      * @desc put scripts and styles in admin page
    */
    function lec_admin_scripts() {
      wp_enqueue_style('style', plugins_url( 'css/admin/admin-main-style.css', __FILE__ ), array(), null);
      wp_enqueue_style('jquery-style', plugins_url( 'css/admin/jquery-ui.min.css', __FILE__ ), array(), null);
      wp_enqueue_style('thickbox');
      wp_enqueue_script('jquery');
      if ( ! did_action( 'wp_enqueue_media' ) )
            wp_enqueue_media();
      wp_enqueue_script('media-upload');
      wp_enqueue_script('media_button', plugins_url( '../js/admin/wp-media-screen.js', __FILE__ ), '1.0', true);
      wp_enqueue_script('jquery-ui-core');
      wp_enqueue_script('jquery-ui-sortable');
      wp_enqueue_script('iris');
      wp_enqueue_script('jquery-ui-datepicker');
      wp_enqueue_script( 'post-type-script', plugins_url( 'js/admin/post-type.js', __FILE__ ), array(), null);
      wp_enqueue_script('thickbox');
    }
    /*
      * @desc put scripts and styles in front end
    */
    function lec_wp_scripts() {
      wp_enqueue_style('style', plugins_url( 'css/calendar.css', __FILE__ ), array(), null);
      wp_enqueue_script('jquery');
      wp_enqueue_script( 'calendar-script', plugins_url( 'js/calendar.js', __FILE__ ), array(), null);
    }
  }// class end

}
$LEC_Plugin = new LEC_Plugin();
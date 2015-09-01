<?php
  class OptionPage
  {

    public function __construct()
    {
      add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
      //add_action( 'admin_init', array( $this, 'page_init' ) );
    }
    /**
    * Add options page
    */
    public function add_plugin_page()
    {
         // This page will be under "Settings"
         add_menu_page(
             'LEC Setting', 
             'LEC Setting', 
             'manage_options', 
             'lec-setting',
             array($this, 'create_admin_page')
             //icon
             //position
         );
    }
     
     /**
      * Options page callback
      */
     public function create_admin_page()
     {
      // Set class property
      $this->options = get_option( 'lec_options' );
      ?>
      <div class="wrap">
          <h2>L Events Calendar</h2>
          <p>
           there's no settings at the momment. However, it will be available upon on request.
          </p>
          <h2>Plugin Instruction</h2>
          <div>
            1) put this shortcode in any page
            <xmp style="color: white; max-width: 100%; background: black; width: 100%; max-width: 500px">
  [l-events-calendar]
            </xmp>
            2) add event inside l-event
            3) enjoy your coolest event calendar
          </div>
      <?php

     }

  }// class end




  ?>
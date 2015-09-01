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
        <p>There are no settings at the momment. Please <a href="https://github.com/loitruong/l-events-calendar/issues/new" target="_blank">open a new issue</a> for feature requests.</p>
        <h2>Plugin Instructions</h2>
        <ol>
          <li>Use the shortcode <code>[l-event-calendar]</code> on any page</li>
          <li>Add an event inside l-event</li>
          <li>Enjoy the coolest event calendar ever.</li>
        </ol>
      </div>
      <?php

     }

  }// class end




  ?>
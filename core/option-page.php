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
        add_submenu_page('edit.php?post_type=l-event',
             'Settings',
             'Settings',
             'manage_options',
             'lec-settings',
             array($this, 'create_admin_page'));
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
          <li>Add an event inside l-events</li>
          <li>Click on l-events button right above visual text editor to add the shortcode</li>
          <li>Enjoy the coolest event calendar ever.</li>
        </ol>
      </div>
      <?php

     }

  }// class end




  ?>
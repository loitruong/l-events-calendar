<?php
  class OptionPage
  {

    public function __construct()
    {

      add_action( 'admin_menu', array( $this, 'lec_add_plugin_page' ) );
      add_action( 'admin_init', array( $this, 'lec_option_page_init' ) );
      add_action( 'admin_enqueue_scripts', array( $this, 'lec_only_for_this_page'));
    }
    /**
    * Add options page
    */
    public function lec_add_plugin_page()
    {
        add_submenu_page('edit.php?post_type=l-event',
             'Settings',
             'Settings',
             'manage_options',
             'lec-settings',
             array($this, 'lec_create_admin_page'));
    }

     /**
      * Options page callback
      */
     public function lec_create_admin_page()
     {
      // Set class property
      $this->options = get_option( 'lec_name_option' );
      $images = explode(" ",$this->options['calendar_gallery']);
      ?>
      <div class="wrap">
        <h2>L Events Calendar</h2>
        <p>Please <a href="https://github.com/loitruong/l-events-calendar/issues/new" target="_blank">open a new issue</a> for feature requests or report bugs.</p>
        <h2>Plugin Instructions</h2>
        <ol>
          <li>Add an event inside l-events</li>
          <li>Click on l-events button right above visual text editor to add the shortcode</li>
          <li>Enjoy the coolest event calendar ever.</li>
        </ol>
        <div class="option-1">
            <h4>Upload Your Own Calendar Images?</h4>
            <p>(Maximum is 12 images. Order from left to right, top to bottom)</p>
            <div class="calendar-image-option <?php if($this->options['calendar_image_option'] == "true"):  echo 'yes-please'; endif; ?>">
              <span>No</span>
              <span>Yes</span>
              <div class="round-block"></div>
            </div>
            <br>
            <div class="gallery-cover <?php if($this->options['calendar_image_option'] == "true"):  echo 'active'; endif; ?>">
              <div class="stag-metabox-table-button button">
                  Add Image
              </div>
              <div class="gallery-sortable">
                  <?php foreach ($images as $image) {
                    if ($image != null) { ?>
                      <?php $image_src = wp_get_attachment_image_src( $image, "medium" ) ; ?>
                      <div class="gallery-image" attachmentId="<?= $image ?>" style="background-image: url('<?= $image_src[0] ?>')"><div class="close">x</div></div>
                        
                   <?php   }  
                   } ?>
              </div>
            </div>
        </div>



        <form method="post" action="options.php">
            <?php settings_fields( 'lec_group_option' );  ?>
            <?php do_settings_sections( 'lec-settings' ); ?>
            <div class="hidden-fields"> 
                <?php printf(
                    '<input type="text" id="calendar_image_option" name="lec_name_option[calendar_image_option]" value="%s" />',
                    isset( $this->options['calendar_image_option'] ) ? esc_attr( $this->options['calendar_image_option']) : ''
                ); ?>
                <?php printf(
                    '<input type="text" id="calendar_gallery" name="lec_name_option[calendar_gallery]" value="%s" />',
                    isset( $this->options['calendar_gallery'] ) ? esc_attr( $this->options['calendar_gallery']) : ''
                ); ?>
            </div>
            
            <?php submit_button(); ?>
        </form>
      <?php
     }
     /*
        this function is only for the option page
     */
     function lec_only_for_this_page(){
        $screen = get_current_screen();
        if($screen->base == 'l-event_page_lec-settings'){
         add_filter( 'media_view_strings', array( $this, 'lec_my_view_strings') );
         wp_enqueue_script('media-upload');
         wp_enqueue_script('media_button', plugins_url( '../js/admin/wp-media-screen.js', __FILE__ ), '1.0', true);
        }
     }

     //disable buttons on media
     function lec_my_view_strings( $strings) {
       // disable some views
       $disabled = array(  'createNewGallery', 'insertFromUrlTitle', 'createGalleryTitle' );
       foreach( $disabled as $string )
         $strings[$string] = '';
       return $strings;
     }


     function lec_option_page_init(){
        register_setting(
                  'lec_group_option', // Option group
                  'lec_name_option' // Option name
                //  array( $this, 'sanitize' ) // Sanitize
              );
     }
  }// class end




  ?>
<?php
/*
	Custom Button for Tinymce
*/
 add_action( 'admin_init', 'my_tinymce_button' );

 function my_tinymce_button() {
      if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
           add_filter( 'mce_buttons', 'my_register_tinymce_button' );
           add_filter( 'mce_external_plugins', 'my_add_tinymce_button' );
      }
 }

 function my_register_tinymce_button( $buttons ) {
      array_push( $buttons, "button_shortcode" );
      return $buttons;
 }

 function my_add_tinymce_button( $plugin_array ) {
      $plugin_array['my_button_script'] = plugins_url( '../js/admin/tinymce-plugin.js', __FILE__ );
      return $plugin_array;
 }
?>
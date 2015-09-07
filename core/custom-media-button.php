<?php
/*
	Custom Button for Tinymce
*/
// add media button

    add_action('media_buttons', 'lec_add_my_media_button');
    add_action('wp_enqueue_media', 'lec_include_media_button_js_file');
function lec_add_my_media_button() {
    $screen = get_current_screen();
    if($screen->post_type == "l-event") return;

	$args = array(
		'show_option_all'   => 'All Events',
		'taxonomy'           => 'event-category',
		'selected'	=> 1,
		'id'		=> 'category_option',
		'value_field'	=> 'slug',
        'show_option_none' => "All Events"
	);
	    
    echo '
    	<a href="#TB_inline&inlineId=hiddenModalContent" title="L-events Calendar" class="button thickbox"><span class="dashicons dashicons-calendar-alt" style="position: relative; top: 2px;"></span> L-events</a> 
    	<div id="hiddenModalContent" style="display: none"> 
            <div>
            	<h2> Please select category for the calendar </h2>
            ';
            wp_dropdown_categories( $args );
     echo ' <h2> Display Calendar Image?</h2>
     		<select id="dispalyImage">
     			<option value="true">Yes</option>
     			<option value="false">No</option>
     		</select>
            <h2> Calendar Color</h2>
            <input type="color" id="mycalendarcolor" style="width: 50px; height: 50px; padding: 0; cursor: pointer;" value="#FF3D00" />
     		<br><br>
     		<input type="submit" class="button" id="submitcustommedia" value="Submit"/> 
     		</div>
    	 </div>';
}
function lec_include_media_button_js_file() {
    wp_enqueue_script('media_button', plugins_url( '../js/admin/custom-media-button-plugin.js', __FILE__ ), array('jquery'), '1.0', true);
}

?>
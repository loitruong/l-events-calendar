<?php

/**
 * Adds a box to the main column on the l-event edit screens.
 */
function lec_add_meta_box() {

    $screens = array( 'l-event' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'lec_sectionid',
            __( 'L-Event Information', 'lec_textdomain' ),
            'lec_meta_box_callback',
            $screen
        );
    }
}
add_action( 'add_meta_boxes', 'lec_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current l-event
 */
function lec_meta_box_callback( $post ) {

    // Add a nonce field so we can check for it later.
    wp_nonce_field( 'lec_save_meta_box_data', 'lec_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $start_date = get_post_meta( $post->ID, 'start_date', true );
    $end_date = get_post_meta( $post->ID, 'end_date', true );
    $start_time = get_post_meta( $post->ID, 'start_time', true );
    if ($start_time >= 1200) {
        $start_time_hour = floor(($start_time - 1200)/100);
        if($start_time_hour == 0){
            $start_time_hour = 12;
        }
    }else{
        $start_time_hour = floor($start_time/100);
    }
    $end_time = get_post_meta( $post->ID, 'end_time', true );
    if ($end_time >= 1200) {
        $end_time_hour = floor(($end_time - 1200)/100);
        if($end_time_hour == 0){
            $end_time_hour = 12;
        }
    }else{
        $end_time_hour = floor($end_time/100);
    }
    $location = get_post_meta( $post->ID, 'location', true );
    //get_post_meta( $post->ID, 'start_time', true );
    //$start_time_minute = 0;//get_post_meta( $post->ID, 'end_time', true );
    ?>
    <div class="meta-box-container">
        <div class="l-row">
            <div class="full-col">
                <?php
                echo '<label for="location">';
                _e( 'Location', 'lec_textdomain' );
                echo '</label> ';
                echo '<input type="text" id="location" name="location" value="' . esc_attr($location) . '" />';
                ?>
            </div>
        </div>
        <div class="l-row">
            <div class="half-col">
                <?php
                echo '<label for="start_date">';
                _e( 'Start Date', 'lec_textdomain' );
                echo '</label> ';
                echo '<input type="text" id="start_date" class="jquery-datepicker" name="start_date" value="' . esc_attr( $start_date ) . '" size="25" />';
                ?>
            </div>
            <div class="half-col">
                <?php
                echo '<label for="end_date">';
                _e( 'End Date', 'lec_textdomain' );
                echo '</label> ';
                echo '<input type="text" id="end_date" class="jquery-datepicker" name="end_date" value="' . esc_attr( $end_date ) . '" size="25" />';
                ?>
            </div>
        </div>
        <div class="l-row">
            <div class="half-col">
                <?php
                echo '<label for="start_time">';
                _e( 'Start Time', 'lec_textdomain' );
                echo '</label> ';
                echo '<input type="number" id="start_time_hour" min="0" max="12" name="start_time_hour" value="' . esc_attr( $start_time_hour ) . '"/> : ';      
                echo '<input type="number" id="start_time_minute" min="0" max="59" name="start_time_minute" value="' . esc_attr( $start_time%100 ) . '"/>';
                ?>
                <select id="start_time_am" name="start_time_am">
                    <option value="am">AM</option>
                    <?php if($start_time >= 1200){ ?>
                        <option selected value="pm">PM</option>
                    <?php } else{ ?>
                        <option value="pm">PM</option>
                    <?php } ?>
                </select>
            </div>
            <div class="half-col">
                <?php
                echo '<label for="end_time">';
                _e( 'End Time', 'lec_textdomain' );
                echo '</label> ';
                echo '<input type="number" id="end_time_hour" min="0" max="12" name="end_time_hour" value="' . esc_attr( $end_time_hour ) . '"/> : ';      
                echo '<input type="number" id="end_time_minute" min="0" max="59" name="end_time_minute" value="' . esc_attr( $end_time%100 ) . '"/>';
                ?>
                <select id="end_time_am" name="end_time_am">
                    <option value="am">AM</option>
                    <?php if($end_time >= 1200){ ?>
                        <option selected value="pm">PM</option>
                    <?php } else{ ?>
                        <option value="pm">PM</option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
    <?php
}   

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function lec_save_meta_box_data( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['lec_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['lec_meta_box_nonce'], 'lec_save_meta_box_data' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */
    
    // Make sure that it is set.
    if ( !isset($_POST['start_date']) || !isset($_POST['end_date'])) {
        return;
    }

    // Update the meta field in the database.
    update_post_meta( $post_id, 'start_date' , sanitize_text_field( $_POST['start_date'] ) );
    update_post_meta( $post_id, 'end_date' , sanitize_text_field( $_POST['end_date'] ) );
    //update start time
    if($_POST['start_time_am'] == 'am'){
        $start_time = ((int)($_POST['start_time_hour']) * 100) + (int)$_POST['start_time_minute'];
    }else{
        $start_time = ((int)($_POST['start_time_hour']) * 100) + (int)$_POST['start_time_minute'] + 1200;
    }
    update_post_meta( $post_id, 'start_time' , $start_time );
    //update end time
    if($_POST['end_time_am'] == 'am'){
        $end_time = ((int)($_POST['end_time_hour']) * 100) + (int)$_POST['end_time_minute'];
    }else{
        $end_time = ((int)($_POST['end_time_hour']) * 100) + (int)$_POST['end_time_minute'] + 1200;
    }
    update_post_meta( $post_id, 'end_time' , $end_time );

    //event location
    update_post_meta( $post_id, 'location' , sanitize_text_field( $_POST['location'] ) );

}
add_action( 'save_post', 'lec_save_meta_box_data' );
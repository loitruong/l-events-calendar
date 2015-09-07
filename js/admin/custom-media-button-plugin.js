/*

This script is for custom media button

*/
jQuery(function($) {
    $('#upload_image_button').click(function() {
         tb_show();
         return false;
     });
    $("#submitcustommedia").on("click", function(){
    	var $shortcode = "[l-events-calendar";
    	var $category = "";
        $shortcode += " calendarcolor='" + $("#mycalendarcolor").val() + "'";
        $shortcode += " displayimage='" + $("#dispalyImage").val() + "'";
    	if($("#category_option").val() != "0" && $("#category_option").val() != "-1"){
    		$category =  " category='" + $("#category_option").val() + "'";
    	}
		$shortcode += $category + "]";
    	window.send_to_editor($shortcode);
    	tb_remove();
    });

});
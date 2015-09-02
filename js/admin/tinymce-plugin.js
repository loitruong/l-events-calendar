/*

This script is for l-event post type

*/
$j = jQuery;
(function() {
     /* Register the buttons */
     tinymce.create('tinymce.plugins.MyButtons', {
          init : function(ed, url) {
               /**
               * Inserts shortcode content
               */
               ed.addButton( 'button_shortcode', {
                    title : 'l-events calendar',
                    image : '/wp-content/plugins/l-events-calendar/js/admin/calendar.gif',
                    onclick : function() {
                         ed.selection.setContent('[l-events-calendar]');
                    }
               });
          },
          createControl : function(n, cm) {
               return null;
          },
     });
     /* Start the buttons */
     tinymce.PluginManager.add( 'my_button_script', tinymce.plugins.MyButtons );
})();
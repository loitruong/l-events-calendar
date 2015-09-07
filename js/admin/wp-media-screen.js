/*
	wp-media-screen
	Add Media Screen javascript
*/
$j = jQuery;
$j(document).ready(function(){
	var _custom_media = true,
	_orig_send_attachment = wp.media.editor.send.attachment;
	$j('.stag-metabox-table-button').click(function(e) {
		$j(".media-frame-menu").hide();
		var send_attachment_bkp = wp.media.editor.send.attachment;
		var button = $j(this);
		_custom_media = true;
		wp.media.editor.send.attachment = function(props, attachment){
			if ( _custom_media  && attachment.type == "image") {
				if($j(".gallery-sortable >div").length > 11 ) return;
				$j(".gallery-sortable").append('<div class="gallery-image" attachmentId="'+ attachment.id +'" style="background-image: url('+ attachment.sizes.medium.url +')"><div class="close">x</div></div>');
			}
		}
		wp.media.editor.insert = function(){
			initialGalleryField();
		};
		wp.media.editor.open(button);
		//return false;
	});

	$j('.add_media').on('click', function(){
		_custom_media = false;
	});
	$j(".gallery-sortable").on('click','.gallery-image .close', function(){
		$j(this).parent().hide(300).remove();
		initialGalleryField();
	});
	$j('.calendar-image-option').on('click', function(){
		if($j(this).hasClass("yes-please")){
			$j(this).find(".round-block").animate({"left":"50%"},200);
			$j(".gallery-cover").removeClass("active").hide(500);
			$j(this).removeClass("yes-please");
			$j("#calendar_image_option").val(false);
		}else{
			$j(this).find(".round-block").animate({"left":"0"},200);
			$j(".gallery-cover").addClass("active").show(500);
			$j(this).addClass("yes-please");
			$j("#calendar_image_option").val(true);
		}
	});
	function initialGalleryField(){
		//insert into option calendar_gallery
		$j(".gallery-sortable .gallery-image").each(function(i){
			if (i == 0) {
				$j("#calendar_gallery").val($j(this).attr("attachmentId"));
			}else{
				$j("#calendar_gallery").val($j("#calendar_gallery").val() +" " + $j(this).attr("attachmentId"));
			};
		});
	}
});
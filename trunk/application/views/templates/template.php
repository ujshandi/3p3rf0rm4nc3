<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php echo $title_page; ?></title>
<?php if(count($css) > 0) load_css($css);?>
<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery-1.6.3.min.js" ></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/drupal.js" ></script>
<?php if(count($js) > 0) load_js($js);?>

<script type="text/javascript">var  base_url = "<?php echo base_url(); ?>"</script>
<script type="text/javascript">
<!--//--><![CDATA[//><!--
jQuery.extend(Drupal.settings, { "basePath": "/", "dhtmlMenu": { "slide": "slide", "clone": "clone", "siblings": 0, "relativity": 0, "children": 0, "doubleclick": 0 }, "googleanalytics": { "trackOutgoing": 1, "trackMailto": 1, "trackDownload": 1, "trackDownloadExtensions": "7z|aac|avi|csv|doc|exe|flv|gif|gz|jpe?g|js|mp(3|4|e?g)|mov|pdf|phps|png|ppt|rar|sit|tar|torrent|txt|wma|wmv|xls|xml|zip" }, "lightbox2": { "rtl": "0", "file_path": "/(\\w\\w/)sites/default/files", "default_image": "brokenimage.jpg", "border_size": "10", "font_color": "000", "box_color": "fff", "top_position": "", "overlay_opacity": "0.8", "overlay_color": "000", "disable_close_click": 1, "resize_sequence": "0", "resize_speed": 400, "fade_in_speed": 400, "slide_down_speed": 600, "use_alt_layout": 0, "disable_resize": 0, "disable_zoom": 0, "force_show_nav": 0, "loop_items": 0, "node_link_text": "View Image Details", "node_link_target": 0, "image_count": "Image !current of !total", "video_count": "Video !current of !total", "page_count": "Page !current of !total", "lite_press_x_close": "press \x3ca href=\"#\" onclick=\"hideLightbox(); return FALSE;\"\x3e\x3ckbd\x3ex\x3c/kbd\x3e\x3c/a\x3e to close", "download_link_text": "", "enable_login": false, "enable_contact": false, "keys_close": "c x 27", "keys_previous": "p 37", "keys_next": "n 39", "keys_zoom": "z", "keys_play_pause": "32", "display_image_size": "", "image_node_sizes": "()", "trigger_lightbox_classes": "", "trigger_lightbox_group_classes": "", "trigger_slideshow_classes": "", "trigger_lightframe_classes": "", "trigger_lightframe_group_classes": "", "custom_class_handler": 0, "custom_trigger_classes": "", "disable_for_gallery_lists": true, "disable_for_acidfree_gallery_lists": true, "enable_acidfree_videos": true, "slideshow_interval": 5000, "slideshow_automatic_start": true, "slideshow_automatic_exit": true, "show_play_pause": true, "pause_on_next_click": false, "pause_on_previous_click": true, "loop_slides": false, "iframe_width": 600, "iframe_height": 400, "iframe_border": 1, "enable_video": 0 }, "user_relationships_ui": { "loadingimage": "loadingAnimation.gif", "savingimage": "savingimage.gif", "position": { "position": "absolute", "left": "0", "top": "0" } }, "views_showcase": { "easing": "", "cycle": "fade", "sync": "true", "timeout": "6000", "listPause": "false", "pause": "false" } });
//--><!]]>
</script>
<script  type="text/javascript">
	$("div#user-login-form").css('visibility' , 'hidden');
</script>
<script src="<?php echo base_url()?>public/js/jcarousellite_1.0.1c4.js"  type="text/javascript"></script>
<script  type="text/javascript">
	/*var cssObjAgg = {
      'margin' : '0',
      'padding' : '0',
	  'height': '30px',
	  'width':'50%',
	  'text-align':'center',
	  'border': '1px solid #315e94'
    }
	var cssObjAggLi = {
      'margin-left': '5px', 
	  'float':'left'
    }*/

	$(document).ready(function() {
		$("div#user-login-form div:last-child").html("");
		$("div#user-login-form").css('visibility' , 'visible');
		$("#quickfacts").find('div.item-list').jCarouselLite({  
         vertical: true,  
         visible: 2,
		 circular: true,
         auto: 800,  
         speed:2000,
         hoverPause:true
	});
	 //$('#aggregator-feed').css(cssObjAgg);
	 //$('#aggregator-feed').find('li').css(cssObjAggLi);
	 $("#aggregator-feed").find('div.item-list').jCarouselLite({  
         vertical: false,  
         visible: 1,
		 circular: true,
         auto:800,  
         speed:4000,
         hoverPause:true
	});
	if($('.views-showcase-mini-list li').length > 0)
		$('.views-showcase-mini-list').append('<a href="#" class="pauseButton"></a>');
	$('.pauseButton').toggle(
		function() {
			$('ul.views-showcase-big-panel').cycle('pause')
			$(this).css('background-position', 'right top')
		},
		function() {
			$('ul.views-showcase-big-panel').cycle('resume', true)
			$(this).css('background-position', 'left top')
		}
	);
	$('.views-showcase').css('display', 'block');
    $('div.views-showcase-big-box-field_image_showcase_fid img').css('float', 'left');
	$('div.views-showcase-big-panel').css('text-align', 'left');

	});
	</script>
<!--<script src="<?php //echo base_url()?>public/js/AC_RunActiveContent.js" type="text/javascript"></script>-->
</head>
<body>
<div id="all">
  <div id="spessore"> </div>
  <div id="header"><? echo $header?></div>
  <!--<div id="distance" class="clear"></div>-->
  <div id="wrapper" class="clear">
		<?echo $wrapper;?>
  </div>
  <!-- /#wrapper -->
  <div id="footer" class="clear">
    <div class="left">
      <p>Partner senatorindonesia.org :</p>
      <!-- /#footer -->
      <div id="menubar" class="clear" ></div>
      <br/>
    </div>
    <div class="right">
      <p><a href="#top">Return to top</a></p>
    </div>
  </div>
  <div id="menubar" class="clear"></div>
  <div id="footer">
	<table width='100%' border='0'>
	<?php if(isset($partner_top)) : ?>
	<tr>
		<td align='center'>
			<?php foreach($partner_top as $row) : ?>
				<a href="<?php echo 'http://'.$row->link; ?>" target='_blank' title="<?php echo $row->title; ?>" ><img src="<?php echo base_url().LINK_PARTNER.$row->img; ?>"></a>
			<?php endforeach; ?>
		</td>
	</tr>
	<?php endif; ?>
	<?php if(isset($partner_center)) : ?>
	<tr>
		<td align='center'>
			<?php foreach($partner_center as $row) : ?>
				<a href="<?php echo 'http://'.$row->link; ?>" title="<?php echo $row->title; ?>" target='_blank' ><img src="<?php echo base_url().LINK_PARTNER.$row->img; ?>" ></a>
			<?php endforeach; ?>
		</td>
	</tr>
	<?php endif; ?>
	<?php if(isset($partner_bottom)) : ?>
	<tr>
		<td align='center'>
			<?php foreach($partner_bottom as $row) : ?>
				<a href="<?php echo 'http://'.$row->link; ?>" title="<?php echo $row->title; ?>" target='_blank'><img src="<?php echo base_url().LINK_PARTNER.$row->img; ?>" ></a>
			<?php endforeach; ?>
		</td>
	</tr>
	<?php endif; ?>
</table>
  </div>
  <!--<div class="browser"> This portal is best viewed with: IE 8, Firefox 3, Safari 4, Chrome 4 </div>-->
  <br/>
</div>
</body>

<script type="text/javascript" src="<?php echo base_url()?>public/js/dhtml_menu.js" ></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery.cycle.min.js" ></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/views_showcase.js" ></script>
</html>

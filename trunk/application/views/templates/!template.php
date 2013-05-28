<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title><?php echo $title_page; ?></title>
  <link rel="stylesheet" href="<?php echo base_url()?>public/css/style.css" type="text/css" media="screen" />
  <?php if(count($css) > 0) load_css($css);?>
  <script type="text/javascript" src="<?php echo base_url()?>public/js/jquery-1.6.3.min.js"></script>
  <script type="text/javascript">var  base_url = "<?php echo base_url(); ?>"</script>
  <script type="text/javascript">
	$(document).ready(function(){
	
	})
  </script>
</head>
<body>
<table border="0" cellpadding="0" cellspacing="0" width="796px" height="100%" align="center">
<tr>
  <td colspan="2" height="59px"><?php echo $header;?></td>
</tr>
<tr bgcolor="#fafafa">
  <td valign="top">
	<div id="sidebar"><?php echo $sidebar;?></div>
  </td>
  <td valign="top">
	<div id="content">
	  <?php echo $content; ?>
	</div>
  </td>
</tr>
<tr height="10px">
  <td colspan="2" align="center">
	<div class="titForm" style="/* border:1px solid blue; */width:786px;height:20px;background: #fafafa;-moz-border-radius: 0px 0px 5px 5px;border-radius:0px 0px 5px 5px;"></div>
  </td>
</tr>
<tr bgcolor="#3881bd">
  <td colspan="2" align="center">
	<div style="width:100%;border-top:2px solid #3881bd;font-weight:normal;">Copyright (c) 2011, all right reserved</div>
  </td>
</tr>
</table>
</body>
<?php if(count($js) > 0) load_js($js);?>
<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery.periodicalupdater.js"></script>
</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	
<?php if(count($css) > 0) load_css($css);?>    
    <!-- JQuery UI CSS Framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>public/admin/css/ui-lightness/jquery-ui-1.8.4.custom.css"  />
    <!-- End JQuery UI CSS Framework -->
	
    <!-- Styles specific for current page -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>public/admin/js/markitup/skins/markitup/style.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>public/admin/js/markitup/sets/html/style.css" />
    
     <!-- END Specific Styles -->
    
    <!-- General Styles common for all pages -->
    
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>public/admin/css/commons.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>public/admin/css/plugins.css" />
    <!-- END General Styles -->
    
    <!-- Current Theme styles. These are changed via theme switcher -->	
    
	<link rel="stylesheet" id="active-theme-commons" type="text/css" href="<?php echo base_url()?>public/admin/themes/sleek-wood/css/commons.css" />
	<link rel="stylesheet" id="active-theme-plugins" type="text/css" href="<?php echo base_url()?>public/admin/themes/sleek-wood/css/plugins.css" /> 
    <!-- END Current Theme styles -->
	<script type="text/javascript">var  base_url = "<?php echo base_url(); ?>"</script>
		<!--[if lte IE 6]><script src="js/ie6/warning.js"></script><script>window.onload=function(){e("js/ie6/")}</script><![endif]-->
    <script type="text/javascript" src="<?php echo base_url()?>public/admin/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/admin/js/jquery-ui-1.8.4.custom.min.js"></script>
    
	 <!-- Custom Written scripts file -->
	<script type="text/javascript" src="<?php echo base_url()?>public/admin/js/custom.js"></script>
    
	<script type="text/javascript" src="<?php echo base_url()?>public/admin/js/markitup/jquery.markitup.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/admin/js/markitup/sets/html/set.js"></script>
	
	
	
	 <?php if(count($js) > 0) load_js($js);?>
</head>

<body >	
	<!-- Container -->
	<div id="container">    	
        <!-- Content -->
 		<div id="content"><?php echo $content;?>
        	
           
            
        </div>
   		<!-- END Content -->
 	</div>
  	<!-- END Container -->


 		
  

</body>
</html>


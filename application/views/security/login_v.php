<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Biroren Kemenhub - Login</title>

    <style type="text/css">
		html {
			background-image: none;
		}

		#versionBar {
			background-color:#ffffff;
			position:fixed;
			width:100%;
			height:35px;
			bottom:0;
			left:0;
			text-align:center;
			line-height:35px;
			z-index:11;
		}

		.copyright{
			text-align:center; font-size:10px; color:#A31F1A;
		}
		.copyright a{
			color:#A31F1A; text-decoration:none
		}
	</style>

    <!-- JQuery UI CSS Framework -->
    
    <!-- End JQuery UI CSS Framework -->
	
    <!-- General Styles common for all pages -->

    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>public/admin/css/default.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>public/admin/css/button.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>public/admin/css/login.css" />
    <!-- END General Styles -->
	
	<script type="text/javascript">var  base_url = "<?php echo base_url(); ?>"</script>
	<script>
	function runScript(e) {
		if (e.keyCode == 13) {
			document.getElementById('formLogin').submit();
		}
	}
	</script>
</head>

<body>	
	<div id="alertMessage" class="error"/><?=$err_msg;?>
	<br>
	<h2 align="center"><font color="#FF7F00">Sistem dan Aplikasi Pengukuran Data Kinerja</font></h2>
	<h3 align="center"><font color="#FF7F00">Kementerian Perhubungan</font></h3>
    <div id="login">
		<div class="ribbon"/>
    	<div class="inner">                
			<div  class="logo">
            	<!--<image src="logo_login.png" alt="logo_login.png"/>        -->
			</div> 		
			<div class="formLogin">
				<form id="formLogin" method="post" action="<?=base_url();?>security/login/login_usr">
					<input name="username" type="text"  id="username_id" title="Username"/>
			 		<input name="password" type="password" id="password" title="Password" onkeypress="runScript(event)"/>

					<div class="loginButton">
						<div style="float:right; padding:3px 0; margin-right:-12px;">
							<div>
								<ul class="uibutton-group">
								<li><a class="uibutton normal" href="javascript:document.getElementById('formLogin').submit();" id="but_login" >Login</a></li>				   
								</ul>
							</div>
						</div>
						<div class="clear"></div>
					</div>
				</form>
			</div> 	        
		</div>
		<div class="clear"/>
		<div class="shadow"/>
	</div>
		
	<!--Login div-->
	<div class="clear"></div>
	<div id="versionBar">
		<div class="copyright" > Copyright 2012  All Rights Reserved <span class="tip"><a href="#" style="color:#A31F1A" title="Kemenhub">Kementerian Perhubungan</a></span></div>
  <!-- // copyright-->
	</div>
	
</body>

</html>

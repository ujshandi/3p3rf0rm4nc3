<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title><?=$title_page?></title>
	<link type="image/x-icon" href="favicon.ico" rel="shortcut icon">
	<?php if(count($css) > 0) load_css($css);?>    
	<?php if(count($js) > 0) load_js($js);?>    

	<!-- tambahan dari TS -->
    <style type="text/css">
		html {
			background-image: none;
			font-family: Arial;
		}
		
		textarea{
			font-family: Arial;
			font-size: 12px;
		}

		#versionBar {
			background: url(<?=base_url();?>public/images/footer-bg.jpg) repeat-x;
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
			text-align:center; font-size:10px; color:#000;
			font-weight: bold;
		}
		.copyright a{
			color:#000;
			text-decoration:none
		}
	</style>
	<!--	
		background-color:#212121;
		color:#A31F1A;
	-->
	<!-- tambahan dari TS -->
	
	
	
	<!-- Dari Stef  dan yanto -->
	<style type="text/css">
		
		.textdown{
			color: #000;
			height: 53px;
			font-size: 10pt;
			width: 450px;
			background: #ffffff;
			border: 1px solid #a0a0a0;
			font-family: arial;
			padding: 0 3px;
		}
		
		ul.dropdown{
			display: none;
			position: fixed;
			width: 548px;
			padding: 0px;
			border: 1px solid #a0a0a0;
			list-style: none;
			font-size: 10pt;
			margin-top: 2px;
			overflow: scroll;
			overflow-x: hidden;
			max-height: 200px;
		}
		
		ul.dropdown li{
			background: #ffffff;
			padding: 5px;
			border-bottom: 1px solid #a0a0a0;
			text-transform:none;
			font-weight:normal;
			color:#000000;
		}
		
		ul.dropdown li:hover{
			background: #fafafa;
			cursor: pointer;
		}
		
		#tcContainer{
			display:inline-block;
			z-index: 999;
			clear: both;
			margin: 0;
			padding: 0;
			border: none;
		}
		
		.popdesc {
			background: #bbfcf0;
			text-align:left;
			box-shadow: 0 0 12px rgba( 0, 0, 0, .3 );
			border: 1px solid #888;
			display: none;
			position: absolute;
			top: 0; left: 0;
			list-style: none;
			margin: 0;
			padding: 3px 4px 3px 4px;
			min-width: 100px;
			max-width: 400px;
		}
		
		#user-container{
			position:absolute;
			top:8px;
			right:0px;
			margin-right: -3px;
			padding: 0 20px;
			width:auto;
			font-size:10pt;
			font-weight:bold;
			color:#FF7F00;
			line-height:40px;
			border: 3px #FF6000 solid;
			background: #fafafa;
			opacity: 0.7;
			filter:alpha(opacity=70);
			font-weight: bold;
			border-radius: 8px 0px 0px 8px;
			-o-border-radius: 8px 0px 0px 8px;
			-moz-border-radius: 8px 0px 0px 8px;
			-webkit-border-radius: 8px 0px 0px 8px;
		}
		
		#user-container a{
			color: #FF6000;
			text-decoration: none;
		}
		
		#user-container a:hover{
			color: #FF7F00;
			text-decoration: underline;
		}
	</style>
	
	
	<style type="text/css">
		#fm{
			margin:0;
			padding:10px 30px;
		}
		.ftitle{
			font-size:14px;
			font-weight:bold;
			color:#666;
			padding:5px 0;
			margin-bottom:10px;
			border-bottom:1px solid #ccc;
		}
		.fitem{
			margin-bottom:5px;
		}
		.fitem label{
			display:inline-block;
			width:80px;
			float: left;
		}
	  .fsearch{
		background:#fafafa;
		border-radius:5px;
		-moz-border-radius:0px;
		-webkit-border-radius: 5px;
		-moz-box-shadow: 2px 2px 3px rgba(0, 0, 0, 0.2);
		-webkit-box-shadow: 2px 2px 3px rgba(0, 0, 0, 0.2);
		filter: progid:DXImageTransform.Microsoft.Blur(pixelRadius=2,MakeShadow=false,ShadowOpacity=0.2);
		margin-bottom:10px;
		border: 1px solid #99BBE8;
	    color: #15428B;
	    font-size: 11px;
	    font-weight: bold;
	    position: relative;
	  }
	  .fsearch div{
		background:url('<?=base_url();?>public/css/themes/gray/images/panel_title.gif') repeat-x;
		height:200%;
		border-bottom: 1px solid #99BBE8;
		color:#15428B;
		font-size:10pt;
		text-transform:uppercase;
	    font-weight: bold;
	    padding: 5px;
	    position: relative;
	  }
	  .fsearch table{
	    padding: 15px;
	  }
	  .fsearch label{
		display:inline-block;
		width:60px;
	  }
		.fitemArea{
			margin-bottom:5px;
			text-align:left;
			/* border:1px solid blue; */
		}
		.fitemArea label{
			display:inline-block;
			width:84px;
			margin-bottom:5px;
		}
	</style>

	<script  type="text/javascript" >
		//<![CDATA[
		base_url = '<?= base_url();?>';
		//]]>
		$(document).ready(function(){
			jQuery(document).ajaxStart(function(){
				$.ajax({
							  url: base_url+"home/getLoginStatus",
							  data: { },
							  success : function(data, textStatus){
								//alert(data);
								if (data==""){
									
									window.location.replace(base_url+"security/login");
								}
							  },
							  complete: function(xmlHttp) {
								// xmlHttp is a XMLHttpRquest object
								
								//if (xmlHttp.status==200) window.location.replace(base_url+"security/login");
							  }
							});
			})
		
			var p = $('body').layout('panel','west').panel({
				onCollapse:function(){
					//alert('collapse');
				}
			});

			setTimeout(function(){
				//$('body').layout('collapse','east');
			},0);

			$('#tt').tabs({
				fit : true
				/*,
				 
				tools:[{
					iconCls:'icon-add',
					handler: function(){
						alert('add');
					}
				}],{
					iconCls:'icon-save',
					handler: function(){
						alert('save');
					}
				}]
			} */});

			openTab = function(aHref){
				var tmp = $('<div></div>');//.html(data);

				//data = tmp.find('#content').html();		
				$(tmp).load(aHref);
				//tmp.remove();
				return tmp; 
			}

			//create left menu from json
			$('#leftMenu').tree({
				checkbox: false,
				url: base_url+'home/loadMenu',
				//url: base_url+'public/js/menu<?=$sess_apptype;?>.json',
				onBeforeLoad : function(node,param){
					//	alert(node);
					},
					onLoadError : function (xhr, ajaxOptions, thrownError) {
      //  alert(xhr.status);
      //  alert(thrownError);
      },
				onClick:function(node){					
					
					$(this).tree('toggle', node.target);
					
					var b = $('#tt2').tree('isLeaf', node.target);
					if (b){
						setTimeout(function(){
							addTab(node.text,node.attributes.url);},100);
					}
					//alert('you dbclick '+node.attributes.url);
				}/* ,

				onContextMenu: function(e, node){
					e.preventDefault();
					$('#leftMenu').tree('select', node.target);
					$('#mm').menu('show', {
						left: e.pageX,
						top: e.pageY
					});
				} */
			});
			
			editData = function (){
				$('#fm').form('clear');
				$('#nama').val('<?=$sess_fullname;?>');
				$('#dglChangePasswd').dialog('open').dialog('setTitle','Edit Data Pribadi');
				url = base_url+'admin/user/changePasswd/';//+row.id;//'update_user.php?id='+row.id;
			}
			//end editData
			
			
			saveNewPasswd=function(){
				$('#fm').form('submit',{
					url: url,
					onSubmit: function(){
						return $(this).form('validate');
					},
					success: function(result){
						//alert(result);
						var result = eval('('+result+')');
						if (result.success){
							 $.messager.show({
								title: 'Sukses',
								msg: 'Ubah pasword berhasil'
							}); 
							$('#dglChangePasswd').dialog('close');		// close the dialog
						
						} else {
							$.messager.show({
								title: 'Error',
								msg: result.msg
							});
						}
					}
				});
			}
			//end saveData
		});

		var index = 0;
		function addTab(aTitle,aHref){
			index++;
			if ($('#tt').tabs('exists',aTitle)){
				$('#tt').tabs('select', aTitle);
			} else {
				var content = '<iframe scrolling="auto" frameborder="0"  src="'+base_url+aHref+'" style="width:100%;height:100%;"></iframe>'; 
				$('#tt').tabs('add',{
					title:aTitle,
					//	content:content,//'Tab Body ' + index,
					//cache:false,
					//iconCls:'icon-save',
					href :base_url+aHref,
						onLoad : function(){
						//	alert('on Load');
						},
						onBeforeClose : function(){
							//alert('ga bisa ditutup');
							//return false;
						},
						onClose : function(){
							//alert('on Close');
							//setTimeout(function(){},10000);
							//return true;
						},
						onAdd: function(){
							alert('on Add');
							//return false;
						},
						onUpdate: function(){
							alert('onUpdate');
							//	return false;
						},
						onSelect: function(){
							//alert('onSelect');
							//return false;
						},
						onBeforeOpen: function(){
							//alert("<?=$this->session->userdata('logged_in')?>");
							$.ajax({
							  url: base_url+"home/getLoginStatus",
							  data: { },
							  success : function(data, textStatus){
								//alert(data);
								if (data==""){
									
									window.location.replace(base_url+"security/login");
								}
							  },
							  complete: function(xmlHttp) {
								// xmlHttp is a XMLHttpRquest object
								
								//if (xmlHttp.status==200) window.location.replace(base_url+"security/login");
							  }
							});
							<? 
							//if ($this->session->userdata('logged_in') != TRUE) {
							// if ($this->getLoginStatus() != TRUE) {
							
							?>
								//top.location.href = base_url+"security/login"; 
							//	alert("here");
							//	window.location.replace(base_url+"security/login");
								//window.location.reload();
								//return;
							<? //} else {?>
							//	alert("kadie");
							<? //}?>
							
							
						
							//alert('onBeforeOpen'+data);
							//return false;
						},
						closable:true,/* 
						 
						extractor:function(data){
							 alert(data.redirect);
							 var tmp = $('<div></div>').html(data);
							data = tmp.find('#content').html();
							$(data).load(aHref);
							tmp.remove();
							return data;  
						}   */
				});	
			}
		}
		
		// yanto
		// ------------- untuk popup deskripsi di grid ----------------------
		var pX;
		var pY;
		
		$(document).mousemove(function(e){
			//$('#status').html(e.pageX +', '+ e.pageY);
			pX = e.pageX;
			pY = e.pageY;
		});
		
		// show popup
		function showPopup(selector, value){
			
			$(selector).html(value);
			$(selector).css('top', (pY-75)+'px');
			$(selector).css('display', 'block');
			
			var SelectorWidth = $(selector).width();
			var DocumentWidth = $(document).width();
			var offset;
			
			// cek offset
			if((pX + SelectorWidth) >= DocumentWidth){
				offset = pX - SelectorWidth;
				$(selector).css('left', (offset-215)+'px');
			}else{
				$(selector).css('left', (pX-187)+'px');
			}
			
		}
		
		function closePopup(selector){
			$(selector).css('display', 'none');
		}
		
		// ------------- end popup -----------------------------------------------
		
		//New New
		$(document).ready(function() {
			$('body').click(function(event) {
				if (!$(event.target).closest('.textdown').length) {
					$('.dropdown').slideUp("slow");
				};
			});
			
			$('body').keypress(function(e){
				if(e.which == 0){
					$('.dropdown').slideUp("slow");
				}
			});
		});
		
	</script>
</head>

<body class="easyui-layout" id="homeBody" >
	<div region="north" border="false">
		<!--<div style="background: fixed url(<?=base_url();?>public/images/header_newer.png) no-repeat top left;height:70px;margin: 0px;width:100%; padding: 0px;border:1px"></div>
		<div id="user-container">
			<div style="text-align:center;">
				<a href="#" onclick="editData();"><?=(strlen($sess_fullname)<18)?$sess_fullname:substr($sess_fullname,0,18).'..';?></a>&nbsp;|&nbsp;<a href="<?=base_url()?>security/login/logout_user">Logout</a>
			</div>
		</div>-->
		<div id="topheader">
		<div class="bg">
		  
			<div class="logo"><a href="index.html">home</a></div>
			<div class="title"><h1>e-Perfomance</h1><h2>Sistem Aplikasi Pengukuran Kinerja Kementerian Perhubungan</h2><!--<h2>Sistem Informasi Pengukuran Kinerja Kementerian Perhubungan</h2>--></div>
			
			<div class="rpanel">
				<div class="left">
					<h4>Welcome :</h4>
					<p><a href="#"><?=(strlen($sess_fullname)<18)?$sess_fullname:substr($sess_fullname,0,18).'..';?></a></p>
					<hr/>
					<a href="#" onclick="editData();" class="inlink">Setting dan Ubah Password</a>
				</div>
				<div class="right"><a href="<?=base_url()?>security/login/logout_user" class="logout">LOGOUT</a></div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>

		</div>
		</div><!-- End of Header-->
	</div>

	<div region="west" split="true" title="Daftar Menu" style="width:200px;padding:10px;">
		<ul id="leftMenu" ></ul>
		<hr>
	</div>
	
	<div region="center" title="">
		<div id="tt" class="easyui-tabs" style="width:500px;height:250px;">
		</div>
	</div>

	<div region="south" border="false" style="height:30px;background:#000000;padding:5px;"></div>

	<div id="footer">
		<div class="footer_content">
	        <div class="footer_bottom">
	            <div class="copyright" style="align:center">&copy; e-Perfomance 2013 - <a href="#" target="_blank">Sistem Aplikasi Pengukuran Kinerja Kementerian Perhubungan RI</a></div>
	            <!-- modif by chan 
	            <div class="footer_right_links">
	                <ul>
	                    <li class="selected"><a href="<?=base_url();?>">HOME</a></li>
	                    <li><a href="#">KONTAK</a></li>
	                    <li><a href="#">WEB MAIL</a></li>
	                    <li><a href="#">LOGIN</a></li>
	                </ul>
	            </div>-->
	        </div>
	     <div class="clear"></div>   
		</div><!--end footer content-->
	</div><!--end all footer-->
	
	<!-- <div id="versionBar">
		<div class="copyright"> Copyright 2012  All Rights Reserved <span class="tip"><a href="#" title="Kemenhub">Sistem Aplikasi Pengukuran Kinerja Kementerian Perhubungan</a></span></div>
	</div> -->

	<!-- AREA untuk Form Add/EDIT >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>  -->
	
	<div id="dglChangePasswd" class="easyui-dialog" style="width:440px;height:320px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<div class="ftitle">Edit Data Pribadi</div>
		<form id="fm" method="post">
			<div class="fitem">
				<label style="width:120px">Nama :</label>
				<input name="nama" id="nama" class="easyui-validatebox" required="true" size="30" value="<?=$sess_fullname;?>" readonly>
			</div>	
			<div class="fitem">
				<label style="width:120px">Password Lama :</label>
				<input name="opass" id="opass" class="easyui-validatebox" size="30" required="true" type="password">
			</div>	
			<div class="fitem">
				<label style="width:120px">Password Baru :</label>
				<input name="npass" id="npass" class="easyui-validatebox" size="30" required="true" type="password">
			</div>	
			<div class="fitem">
				<label style="width:120px">Ulangi Password :</label>
				<input name="cpass" id="cpass" class="easyui-validatebox" size="30" required="true" type="password">
			</div>	
		</form>
		<div id="dlg-buttons">
			<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveNewPasswd()">Save</a>
			<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dglChangePasswd').dialog('close')">Cancel</a>
		</div>
	</div>
	
	<script type="text/javascript">
		setTimeout(function(){
						//	addTab('Dashboard','dashboard');
						},100);
	</script>
</body>

</html>

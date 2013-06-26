	<script  type="text/javascript" >		
		$(function(){
			var url = base_url+'portal/save/7/edit/3';
		 	saveData<?=$objectId;?>=function(){
				$('#fmedit<?=$objectId;?>').form('submit',{
					url: url,
					onSubmit: function(){
						return $(this).form('validate');
					},
					success: function(result){
						//alert(result);
						var result = eval('('+result+')');
						if (result.success){
							$.messager.show({
								title: 'Success',
								msg: 'Data berhasil disimpan'
							});
						} else {
							$.messager.show({
								title: 'Error',
								msg: result.msg
							});
						}
					}
				});
			}
			});
			//end saveData
	</script>

	<style type="text/css">
		
	 #fmedit<?=$objectId;?>{margin:0;padding:5px}
	  .ftitle{font-size:14px;font-weight:bold;color:#666;padding:5px 0;margin-bottom:10px;border-bottom:1px solid #ccc;}
	  .fitem{margin-bottom:3px;border:0px solid none;}
	  .fitem label{display:inline-block;/* border:1px solid gray; */width:65px; float:left;}
	  .fitemL{margin-bottom:5px;border:0px solid none;}
	  .fitemL label{display:inline-block;/* border:1px solid gray; */width:75px;}
	  .fitemLn{margin-bottom:5px;border:0px solid none;}
	  .fitemLn label{display:inline-block;/* border:1px solid gray; */width:55px;}
	  .fitemG{margin-bottom:5px;border:0px solid none;}
	  .fitemG label{display:inline-block;/* border:1px solid gray; */width:76px;}
	  .fitemleft{margin-bottom:5px;border:0px solid none;float:left;width:215px;}
	  .fitemleft label{display:inline-block;/* border:1px solid gray; */width:75px;}
	  .fitemTl{margin-bottom:5px;border:0px solid none;float:left;width:446px;}
	  .fitemTl label{display:inline-block;/* border:1px solid gray; */width:75px;}
	  .regT{padding:5px;line-height:15px;color:#15428b;font-weight:bold;font-size:12px;background:url('<?=base_url();?>public/css/themes/gray/images/panel_title.gif') repeat-x;position:relative;border:1px solid #99BBE8;width:100%;}
	  .regT-grid{padding:5px;line-height:15px;font-size:12px;position:relative;/* border:1px solid #99BBE8;background-color:#EFEFEF; */width:100%;height:100%;}
	  .fitemArea{margin-bottom:5px;text-align:left;border:0px solid none;}
	  .fitemArea label{display:inline-block;width:79px;margin-bottom:5px;}
	  .tabIDP {height:100%;width:615px;/* border:1px solid red; */float:left;}
	  .tabBound{height:100%;width:10px;/* border:1px solid red; */float:left;}
	  .tabPend{height:100%;width:200px;/* border:1px solid red; */float:left;}
	  .tabDP{height:100%;width:200px;/* border:1px solid red; */float:left;}
	  legend {font-size:10pt;color:gray;text-transform:uppercase;font-weight:bold;padding:8px;}
	  .displayReg {/*width:98.9%;height:600px;border:1px solid red;*/}
	  	  
	  /* 2ndstyle */	  
	  .table {padding:2px;}
	  .top {background-color:#cfddcc;}
	  .subTop {background-color:#f1f1f1;}
	  .gridHead {color:#fff;background-color:#333;border:1px solid #f1f1f1;text-align:center;}
	  .grid {background-color:#fff;border:1px solid #f1f1f1;padding:0 0 0 2px;}
	  .td1 {text-align:right;padding:1px;}
	  .td2 {text-align:center;padding:1px;width:10px;}
	  .td3 {text-align:left;width:10px;}
	  
	</style>
			
	<div id="cc<?=$objectId;?>" class="easyui-layout" fit="true">  
			<div class="easyui-layout" fit="true">  				
				<!------------Edit View-->
				<div region="center" border="true" title=" Tentang e-Performance">
					<form id="fmedit<?=$objectId;?>" method="post" style="margin:10px 5px 5px 10px;">
						
						<input type="hidden" name="content_id" value="<?=$about->content_id;?>">
						
						<div class="fitem">							
						    <label style="width:150px">Judul Halaman Kontak :</label><br/>
						    <input style="margin:10px 0" id="content_title<?=$objectId?>" name="content_title" class="easyui-validatebox" required="true" size="40" value="<?=$about->content_title;?>">
						</div>
						<div class="fitem">							
						    <label style="width:150px">Isi Halaman Kontak :</label><br/>
							<div style="width:700px;  margin:10px 0"><textarea name="content" cols="70" class="easyui-validatebox" style="resize:none" id="content<?=$objectId;?>"><?=$about->content;?></textarea></div>
							<?php echo display_ckeditor($ckeditor); ?>
						</div>
						<br>
						<!------------Edit View-->
						<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveData<?=$objectId;?>()">Simpan</a>
					</form>
				</div>
			</div>	
	</div>

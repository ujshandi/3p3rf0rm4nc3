	<script  type="text/javascript" >
		$(function(){
			var url;
			
			restore<?=$objectId;?>=function(){
				$('#fm<?=$objectId;?>').form('submit',{
					url: base_url+'utility/backup_restore/restoreProccess',
					onSubmit: function(){
						return $(this).form('validate');
					},
					success: function(result){
						//alert(result);
						var result = eval('('+result+')');
						if (result.success){
							$.messager.show({
								title: 'Sucsees',
								msg: 'Data berhasil disimpan'
							});
							$('#dlg<?=$objectId;?>').dialog('close');	// close the dialog
							$('#dg<?=$objectId;?>').datagrid('reload');	// reload the user data
						} else {
							$.messager.show({
								title: 'Error',
								msg: result.msg
							});
						}
					}
				});
			}
			//end backup
			
		 });
	</script>
	
	<style type="text/css">
		#fm<?=$objectId;?>{
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

	<div id="tb<?=$objectId;?>" style="height:auto">
		<?php 
			$attributes = array('id' => 'fm'.$objectId);
			echo form_open_multipart('', $attributes);
		?>
		<table border="0" cellpadding="1" cellspacing="1" width="100%">
		<tr>
			<td>
			<div class="fsearch">
				<table border="0" cellpadding="1" cellspacing="1">
				<tr>
					<td>File Name&nbsp;(.sql)&nbsp;&nbsp;:&nbsp;&nbsp;</td>
					<td>
						<input type="file" name="datafile" size="20" />
					</td>
				</tr>
				<tr>
					<td align="right" colspan="2" valign="top">
						<br>
						<a href="#" class="easyui-linkbutton" onclick="restore<?=$objectId;?>();" iconCls="icon-reset">Restore</a>
					</td>
				</tr>
				</table>
			</div>
			</td>
		</tr>
		</table>
		</form>
	</div>
	
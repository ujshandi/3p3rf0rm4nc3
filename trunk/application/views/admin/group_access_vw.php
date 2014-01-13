<script type="text/javascript">
    var jmlAuto = 0;
	selectModul = function(policy,modulName){
		var compId = "chk"+policy+modulName;
		alert($(this).attr("checked"));
		if ($(this).is(":checked")){
				alert("check");
		}
		
	}
	$("input[class='chkAutoTab']").on("click",function(){
		var b = $('.chkAutoTab');
						//alert($b.filter(':checked').length);
						var jmlCheck = b.filter(':checked').length;
						if (jmlCheck>3){
							$(this).prop("checked", false);
							alert("Maaf, jumlah auto Tab tidak boleh melebih 3 menu");
						//	$(this).removeAttr("checked");
							
						//	return false;
							}
						//else return true;
		
		/*if ($(this).is(":checked")){
			jmlAuto--;
		}else if($(this).is(":not(:checked)")){
			jmlAuto++;
		}
		alert(jmlAuto);*/
	});
	
	saveData<?=$objectId;?>=function(){
				$('#fm<?=$objectId;?>').form('submit',{
					url: base_url+'admin/group_access/save',
					
					onSubmit: function(){
						
						//var $b = $('input[type=checkbox]');
						var b = $('.chkAutoTab');
						//alert($b.filter(':checked').length);
						var jmlCheck = b.filter(':checked').length;
						if (jmlCheck>3){
							alert("Maaf, jumlah auto Tab tidak boleh melebih 3 menu");
							return false;
							}
						else return true;
						//return (jmlCheck<3);///$(this).form('validate');
					},
					success: function(result){
						//alert(result);
						var result = eval('('+result+')');
						if (result.success){
							$.messager.show({
								title: 'Pesan',
								msg: 'Data berhasil disimpan'
							});
							$('#dlg<?=$objectId;?>').dialog('close');		// close the dialog
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
			//end saveData
			
	
	
	searchData<?=$objectId?> = function(){
		var filapptype = $("#filter_apptype<?=$objectId;?>").val();
		var fillevel = $("#filter_level_id<?=$objectId;?>").val();
		if(filapptype==null) filapptype ="-1";				
		if(fillevel==null) fillevel ="-1";				
		
		$.ajax({
		  type: "POST",
		  url: "admin/group_access/get_data/"+fillevel+"/"+filapptype+"/<?=$objectId;?>",
		  beforeSend: function ( xhr ) {		
		  }
		}).done(function( msg ) {
		  
			$("#content<?=$objectId?>").html(msg);
		}).fail(function(jq,msg) { 			
			$("#content<?=$objectId?>").html(msg);
		}).always(function() { 
			 
		});
	}
	
	setTimeout(function(){
		//searchData<?=$objectId?>();
		},100);
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
		
		
		#tbl<?=$objectId;?> {
			width: 100%;
			padding: 0;
			margin: 0;
		}
		
		#tbl<?=$objectId;?> th{
			font: normal 11px;
			color: #4f6b72;
			border-right: 1px solid #C1DAD7;
			border-bottom: 1px solid #C1DAD7;
			border-top: 1px solid #C1DAD7;
			border-left: 1px solid #C1DAD7;
			text-align: left;
			padding: 2px 2px 3px 4px;
			margin:0;
			background: #CAE8EA url(<?=base_url();?>public/images/th.png) repeat-x;
		}
		
		#tbl<?=$objectId;?> td{
			border-right: 1px solid #C1DAD7;
			border-left: 1px solid #C1DAD7;
			border-top: 1px solid #C1DAD7;
			border-bottom: 1px solid #C1DAD7;
			background: #fff;
			padding: 0px 3px 0px 3px;
			margin:0;
			color: #4f6b72;
		}
		
		#tbl<?=$objectId;?> tr{
			margin:0;
		}
	</style>
	
<div id="loading" style="display:none">Loading...</div>

	
	<div class="easyui-layout" fit="true" >  
	
		<div region="west" split="true" title="Filter" style="width:250px;">  
			<div id="tb<?=$objectId;?>" style="height:auto">
					  <table border="0" cellpadding="1" cellspacing="1" width="100%">
					  <tr>
						<td>
						  <div class="fsearch" >
							
							<table border="0" cellpadding="1" cellspacing="1">
							<tr>
							 
							  <td>Level&nbsp;</td>
									
								<td>
								  <?$this->group_level_model->getListLevelFilter($objectId,$this->session->userdata('level'),true,false,true)?>
							  </td>
							</tr>
							<tr>				
						 	<td>Grup:</td>				
							  <td><?$this->user_model->getListGrupFilter($objectId,$this->session->userdata('app_type'),$this->session->userdata('level'),true,false,true)?>
						  </td>
						</tr>
						<tr height='4px'>
							<td colspan="4"></td>
						</tr>
							<tr>
							  <td align="right" valign="top" colspan="4">
								<!--<a href="#" class="easyui-linkbutton" onclick="clearFilter<=$objectId;?>();" iconCls="icon-reset">Reset</a> -->
								<a href="#" class="easyui-linkbutton" onclick="searchData<?=$objectId;?>();" iconCls="icon-search">Search</a>
							  </td>
							</tr>			
							</table>
						  </div>
						</td>
					  </tr>
					  </table>
					  
					</div>
		</div>	
	   
		<div region="center" title="Data Hak Pengguna" style="padding:5px;">
			<div id="tb<?=$objectId;?>" style="height:auto">
				
				<div style="margin-bottom:5px" class="fsearch">  
					<? if ($this->sys_menu_model->cekAkses("EDIT;",303,$this->session->userdata('group_id'),$this->session->userdata('level_id'))) {?>
					<a href="#" onclick="saveData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-save" plain="true">Save</a>
					<?}?>
					<!--
					<a href="#" onclick="printData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
					<a href="#" onclick="toExcel<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-excel" plain="true">Excel</a>
					-->
				</div>
			</div>
				<form id="fm<?=$objectId;?>" method="post">
			<div class="fitem" id="content<?=$objectId?>" >
				<table id="tbl<?=$objectId;?>" width="100%">
								
				<!-- <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CBC7B8">-->
				<tr >
				  <td bgcolor="#F4F4F4" width="10px">&nbsp;No&nbsp;</td>			  
				  <td bgcolor="#F4F4F4" width="50px">&nbsp;Menu&nbsp;</td>
				  <td bgcolor="#F4F4F4" width="10px">&nbsp;View&nbsp;</td>
				  <td bgcolor="#F4F4F4" width="10px">&nbsp;Tambah&nbsp;</td>
				  <td bgcolor="#F4F4F4" width="10px">&nbsp;Edit&nbsp;</td>
				  <td bgcolor="#F4F4F4" width="10px">&nbsp;Hapus&nbsp;</td>
				  <td bgcolor="#F4F4F4" width="10px">&nbsp;Print&nbsp;</td>
				  <td bgcolor="#F4F4F4" width="10px">&nbsp;Excel&nbsp;</td>
				  <td bgcolor="#F4F4F4" width="10px">&nbsp;Import&nbsp;</td>
				  <td bgcolor="#F4F4F4" width="10px">&nbsp;Proses&nbsp;</td>			  			  
				  <td bgcolor="#F4F4F4" width="10px">&nbsp;Copy&nbsp;</td>			  			  
				  <td bgcolor="#F4F4F4" width="10px">&nbsp;Auto Tab&nbsp;</td>			  			  
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  
				</tr>
				</table>
			</div>  
				<?php echo form_close()?>
				<div id="tb<?=$objectId;?>" style="height:auto">
				
				<div style="margin-bottom:5px" class="fsearch">  
					
					<? if ($this->sys_menu_model->cekAkses("EDIT;",303,$this->session->userdata('group_id'),$this->session->userdata('level_id'))) {?>
						<a href="#" onclick="saveData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-save" plain="true">Save</a>
					<?}?>
					<!--
					<a href="#" onclick="printData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
					<a href="#" onclick="toExcel<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-excel" plain="true">Excel</a>
					-->
				</div>
			</div>
	</div>  
	
	



</div>

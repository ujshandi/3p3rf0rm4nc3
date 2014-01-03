	<script  type="text/javascript" >
		$(function(){
			var url;
			newData<?=$objectId;?> = function (){  
				$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','New Grup Pengguna');  
				$('#fm<?=$objectId;?>').form('clear');  
				url = base_url+'admin/group_user/save/add';  
			}
			//end newData 
			
			
			clearFilter<?=$objectId;?> = function (){
				//ambil nilai-nilai filter
				$("#filter_nip").val('');
				$("#filter_nama").val('');
				$("#filter_alamat").val('');
				
				
				//$('#dg<?=$objectId;?>').datagrid({url:"<?=base_url()?>admin/group_user/grid/"+filnip+"/"+filnama+"/"+filalamat});
			}
			
			searchData<?=$objectId;?> = function (){
				//ambil nilai-nilai filter
				var filnip = $("#filter_nip").val();
				var filnama = $("#filter_nama").val();
				var filalamat = $("#filter_alamat").val();
				
				//encode parameter
				if(filnip.length==0) filnip ="6E756C6C";
				else filnip = DoAsciiHex(filnip,"A2H");
								
				if(filnama.length==0) filnama ="6E756C6C";
				else filnama = DoAsciiHex(filnama,"A2H");
				if(filalamat.length==0) filalamat ="6E756C6C";
				else filalamat = DoAsciiHex(filalamat,"A2H");

				
				$('#dg<?=$objectId;?>').datagrid({url:"<?=base_url()?>admin/group_user/grid/"+filnip+"/"+filnama+"/"+filalamat});
			}
			//end searhData 
			
			editData<?=$objectId;?> = function (){
				var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
				$('#fm<?=$objectId;?>').form('clear');  
				//alert(row.dokter_kode);
				if (row){
					$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Edit Grup Pengguna');
					$('#fm<?=$objectId;?>').form('load',row);
					url = base_url+'admin/group_user/save/edit/'+row.group_id;//+row.id;//'update_user.php?id='+row.id;
				}
			}
			//end editData
		
			printData<?=$objectId;?>=function(){
				var data = $('#dg<?=$objectId;?>').datagrid('getRows');	// reload the user data
				for (i=0;i<data.length;i++){
					alert(data[i].nama_kl);
				
				}
			}
			
			saveData<?=$objectId;?>=function(){
				$('#fm<?=$objectId;?>').form('submit',{
					url: url,
					onSubmit: function(){
						return $(this).form('validate');
					},
					success: function(result){
						//alert(result);
						var result = eval('('+result+')');
						if (result.success){
							/* $.messager.show({
								title: 'Sucsees',
								msg: result.msg
							}); */
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
			
			setTimeout(function(){
			$('#dg<?=$objectId;?>').datagrid({url:"<?=base_url()?>admin/group_user/grid"});
			},0);
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
	  <table border="0" cellpadding="1" cellspacing="1" width="100%">
	  <tr>
		<td>
		  <div class="fsearch" style="display:none">
			
			<table border="0" cellpadding="1" cellspacing="1">
			<tr>
			  <td width="250px">
				<label>NIP:</label>
				<input class="easyui-textbox" id="filter_nip">
			  </td>
			  <td width="250px" rowspan="2" valign="top">
				<label>Alamat:</label>
				<input class="easyui-textbox" id="filter_alamat">
			  </td>
			  <td align="right" rowspan="2" valign="top">
				<a href="#" class="easyui-linkbutton" onclick="clearFilter<?=$objectId;?>();" iconCls="icon-reset">Reset</a>
				<a href="#" class="easyui-linkbutton" onclick="searchData<?=$objectId;?>();" iconCls="icon-search">Search</a>
			  </td>
			</tr>
			<tr>
			  <td>
				<label>Nama:</label>
				<input class="easyui-textbox" id="filter_nama">
			  </td>
			</tr>
			</table>
		  </div>
		</td>
	  </tr>
	  </table>
	  <div style="margin-bottom:5px">  
		<a href="#" onclick="newData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-add" plain="true">Add</a>  
		<a href="#" onclick="editData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Edit</a>
		<a href="#" onclick="printData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
	  </div>
	</div>
	
	<table id="dg<?=$objectId;?>" class="easyui-datagrid" style="height:auto;width:auto" title="Grup Pengguna" toolbar="#tb<?=$objectId;?>" fitColumns="true" singleSelect="true" rownumbers="true" pagination="true">
	  <thead>
	  <tr>
		
		<th field="group_id" sortable="true" width="30">Kode Grup Pengguna</th>
		<th field="group_name" sortable="true" width="100">Nama grup Pengguna</th>
	  </tr>
	  </thead>  
	</table>

	 <!-- AREA untuk Form Add/EDIT >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>  -->
	
	<div id="dlg<?=$objectId;?>" class="easyui-dialog" style="width:450px;height:320px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
	  <div class="ftitle">Add/Edit Grup Pengguna</div>
	  <form id="fm<?=$objectId;?>" method="post">
		
		<input name="group_id" type="hidden">
		
		<div class="fitem">
		  <label style="width:120px;vertical-align:top">Nama Grup Pengguna:</label>
		  <textarea name="group_name" class="easyui-validatebox" ></textarea>
		</div>
		<div class="fitem">
		<label style="width:120px;vertical-align:top">Tipe Aplikasi:</label>
		  <select name="app_type">
		  <option value="KL">Kementrian Lembaga</option>
		  <option value="E1">Eselon I</option>
		  <option value="E2">Eselon II</option>
		  </select>
		</div>
		
	  </form>
    </div>
    <div id="dlg-buttons">
	  <a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveData<?=$objectId;?>()">Save</a>
	  <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg<?=$objectId;?>').dialog('close')">Cancel</a>
    </div>
	<script  type="text/javascript" >
		$(function(){
			var url;
			newData<?=$objectId;?> = function (){  
				$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Add Eselon I');  
				$('#fm<?=$objectId;?>').form('clear');  
				url = base_url+'rujukan/eselon1/save/add';  
			}
			//end newData 
			
			
			clearFilter<?=$objectId;?> = function (){
				//ambil nilai-nilai filter
				$("#filter_nip").val('');
				$("#filter_nama").val('');
				$("#filter_alamat").val('');
				
				
				//$('#dg<?=$objectId;?>').datagrid({url:"<?=base_url()?>rujukan/kl/grid/"+filnip+"/"+filnama+"/"+filalamat});
			}
			
			
			//tipe 1=grid, 2=pdf, 3=excel
			getUrl<?=$objectId;?> = function (tipe){
				//kalo ada filter silahkan tambahkan disini
				
				if (tipe==1){
					return "<?=base_url()?>rujukan/eselon1/grid/";
				}
				else if (tipe==2){
					return "<?=base_url()?>rujukan/eselon1/pdf/";
				}else if (tipe==3){
					return "<?=base_url()?>rujukan/eselon1/excel/";
				}
			}
			
			
			searchData<?=$objectId;?> = function (){
				
				
				$('#dg<?=$objectId;?>').datagrid({url:getUrl<?=$objectId;?>(1)});
			}
			//end searhData 
			
			editData<?=$objectId;?> = function (){
				var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
				$('#fm<?=$objectId;?>').form('clear');  
				//alert(row.dokter_kode);
				if (row){
					$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Edit Eselon I');
					$('#fm<?=$objectId;?>').form('load',row);
					url = base_url+'rujukan/eselon1/save/edit/'+row.kode_e1;//+row.id;//'update_user.php?id='+row.id;
				}
			}
			//end editData
		
			printData<?=$objectId;?>=function(){
				window.open(getUrl<?=$objectId;?>(2));;
			}
			
			toExcel<?=$objectId;?>=function(){
				window.open(getUrl<?=$objectId;?>(3));
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
				$('#dg<?=$objectId;?>').datagrid({url:"<?=base_url()?>rujukan/eselon1/grid"});
			},0);
			
			// yanto
			$('#dg<?=$objectId;?>').datagrid({
				onClickCell: function(rowIndex, field, value){
					$('#dg<?=$objectId;?>').datagrid('selectRow', rowIndex);
					var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
					
					switch(field){
						case "kode_kl":
							showPopup('#popdesc<?=$objectId?>', row.nama_kl);
							break;
						default:
							closePopup('#popdesc<?=$objectId?>');
							break;
					}
				}
			});
			
			$("#popdesc<?=$objectId?>").click(function(){
				closePopup('#popdesc<?=$objectId?>');
			});
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
	  <div style="margin-bottom:5px">  
		<? if($this->sys_menu_model->cekAkses('ADD;',3,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="newData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-add" plain="true">Add</a>  
		<?}?>
		<? if($this->sys_menu_model->cekAkses('EDIT;',3,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="editData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Edit</a>
		<?}?>
		<? if($this->sys_menu_model->cekAkses('PRINT;',3,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="printData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
		<?}?>
		<? if($this->sys_menu_model->cekAkses('EXCEL;',3,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="toExcel<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-excel" plain="true">Excel</a>
		<?}?>
	  </div>
	</div>
	
	<table id="dg<?=$objectId;?>" class="easyui-datagrid" style="height:auto;width:auto" title="Data Unit Kerja Eselon I" toolbar="#tb<?=$objectId;?>" fitColumns="true" singleSelect="true" rownumbers="true" pagination="true" nowrap="false">
	  <thead>
	  <tr>
		<th field="kode_kl" sortable="true" width="30">Kode Kementerian</th>
		<th field="nama_kl" hidden="true">Kode Kementerian</th>
		<th field="kode_e1" sortable="true" width="30">Kode Unit Kerja</th>		
		<th field="nama_e1" sortable="true" width="90">Nama Unit Kerja</th>
		<th field="singkatan" sortable="true" width="35">Singkatan</th>
		<th field="nama_dirjen" sortable="true" width="40">Nama Pimpinan</th>
		<th field="nip" sortable="true" width="40">N I P</th>
		<th field="pangkat" sortable="true" width="30">Pangkat</th>
		<th field="gol" sortable="true" width="20">Golongan</th>
	  </tr>
	  </thead>  
	</table>

	<div class="popdesc" id="popdesc<?=$objectId?>">indriyanto</div>
	
	 <!-- AREA untuk Form Add/EDIT >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>  -->
	
	<div id="dlg<?=$objectId;?>" class="easyui-dialog" style="width:720px;height:400px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<div class="ftitle">Tambah/Edit Data Unit Kerja Eselon I</div>
		<form id="fm<?=$objectId;?>" method="post">
			<div class="fitem" >
				<label style="width:120px">Kementerian :</label>
				<?=$this->kl_model->getListKL()?>
			</div>
			<div class="fitem">
				<label style="width:120px;vertical-align:top">Kode Unit Kerja :</label>
				<input name="kode_e1" class="easyui-validatebox" size="10" required="true">
			</div>
			<div class="fitem">
				<label style="width:120px;vertical-align:top">Nama Unit Kerja :</label>
				<input name="nama_e1" class="easyui-validatebox" size="50" required="true">
			</div>
			<div class="fitem">
				<label style="width:120px;vertical-align:top">Singkatan :</label>
				<input name="singkatan" class="easyui-validatebox" size="20" required="false">
			</div>
			<div class="fitem">
				<label style="width:120px;vertical-align:top">Nama Pimpinan :</label>
				<input name="nama_dirjen" class="easyui-validatebox" size="50" required="false">
			</div>
			<div class="fitem">
				<label style="width:120px;vertical-align:top">N I P :</label>
				<input name="nip" class="easyui-validatebox" size="20" required="false">
			</div>
			<div class="fitem">
				<label style="width:120px;vertical-align:top">Pangkat :</label>
				<input name="pangkat" class="easyui-validatebox" size="30" required="false">
			</div>
			<div class="fitem">
				<label style="width:120px;vertical-align:top">Golongan :</label>
				<input name="gol" class="easyui-validatebox" size="10" required="true">
			</div>
		</form>
	</div>

	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveData<?=$objectId;?>()">Save</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg<?=$objectId;?>').dialog('close')">Cancel</a>
	</div>

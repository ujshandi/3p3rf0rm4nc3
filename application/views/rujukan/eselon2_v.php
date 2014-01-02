	<script  type="text/javascript" >
		$(function(){
			var url;
			newData<?=$objectId;?> = function (){  
				$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Add Eselon II');  
				$('#fm<?=$objectId;?>').form('clear');  
				url = base_url+'rujukan/eselon2/save/add';  
			}
			//end newData 
			
			clearFilter<?=$objectId;?> = function (){
				$("#filter_e1<?=$objectId;?>").val('');	
				$("#filter_e2<?=$objectId;?>").val('');	
				searchData<?=$objectId;?>();	
			}
			
			//tipe 1=grid, 2=pdf, 3=excel
			getUrl<?=$objectId;?> = function (tipe){
				<? if (($this->session->userdata('unit_kerja_e1')!=null)&&($this->session->userdata('unit_kerja_e1')!=-1)) {?>	
					var file1 = '<?=$this->session->userdata('unit_kerja_e1')?>'
				<?} else {?>	
					var file1 = $("#filter_e1<?=$objectId;?>").val();
				<? }?>	
					var file2 = $("#filter_e2<?=$objectId;?>").val();
				
				if (file1 == null) file1 = "-1";
				if (file2 == null) file2 = "-1";
			
				if (tipe==1){
					return "<?=base_url()?>rujukan/eselon2/grid/"+file1+"/"+file2;
				}
				else if (tipe==2){
					return "<?=base_url()?>rujukan/eselon2/pdf/"+file1+"/"+file2;
				}else if (tipe==3){
					return "<?=base_url()?>rujukan/eselon2/excel/"+file1+"/"+file2;
				}
			}
			
			searchData<?=$objectId;?> = function (){
				$('#dg<?=$objectId;?>').datagrid({
					url:getUrl<?=$objectId;?>(1),
					queryParams:{lastNo:'0'},	
					pageNumber : 1,
					onLoadSuccess:function(data){	
						$('#dg<?=$objectId;?>').datagrid('options').queryParams.lastNo = data.lastNo;
						//prepareMerge<?=$objectId;?>(data);
				}});
			}
			//end searhData 
			
			editData<?=$objectId;?> = function (){
				var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
				$('#fm<?=$objectId;?>').form('clear');  
				//alert(row.dokter_kode);
				if (row){
					$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Edit Eselon II');
					$('#fm<?=$objectId;?>').form('load',row);
					url = base_url+'rujukan/eselon2/save/edit/'+row.kode_e2;//+row.id;//'update_user.php?id='+row.id;
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

			$("#filter_e1<?=$objectId;?>").change(function(){
				$("#divUnitKerja<?=$objectId;?>").load(base_url+"rujukan/eselon2/loadFilterE2/"+$(this).val()+"/<?=$objectId;?>");
			});

			setTimeout(function(){
				$('#dg<?=$objectId;?>').datagrid({url:"<?=base_url()?>rujukan/eselon2/grid"});
			},50);
			
			
			// yanto
			$('#dg<?=$objectId;?>').datagrid({
				onClickCell: function(rowIndex, field, value){
					$('#dg<?=$objectId;?>').datagrid('selectRow', rowIndex);
					var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
					
					switch(field){
						case "kode_e1":
							showPopup('#popdesc<?=$objectId?>', row.nama_e1);
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
	<table border="0" cellpadding="1" cellspacing="1" width="100%">
	  <tr>
		<td>
		  <div class="fsearch" <?//=(($this->session->userdata('unit_kerja_e2')=='-1')||($this->session->userdata('unit_kerja_e2')=='')?'':'style="display:none"')?>>
			
			<table border="0" cellpadding="1" cellspacing="1">
			<?// if ($this->session->userdata('unit_kerja_e1')==-1){?>
			<tr>
				<td>Unit Kerja Eselon I&nbsp;</td>
				<td>
					<?=$this->eselon1_model->getListFilterEselon1($objectId,$this->session->userdata('unit_kerja_e1'))?>				
				</td>
			</tr>
			<?//}?>
			<tr>
				<td>Unit Kerja Eselon II&nbsp</td>
				<td><span class="fitem" id="divUnitKerja<?=$objectId;?>">
					<?=$this->eselon2_model->getListFilterEselon2($objectId,$this->session->userdata('unit_kerja_e1'),$this->session->userdata('unit_kerja_e2'))?>
					</span>
				</td>
			</tr>
			<tr>
			  
			  <td align="right" colspan="2" valign="top">
				<a href="#" class="easyui-linkbutton" onclick="clearFilter<?=$objectId;?>();" iconCls="icon-reset">Reset</a>
				<a href="#" class="easyui-linkbutton" onclick="searchData<?=$objectId;?>();" iconCls="icon-search">Search</a>
			  </td>
			</tr>
			
			</table>
		  </div>
		</td>
	  </tr>
	  </table>
		<div style="margin-bottom:5px">  
		<? if ($this->session->userdata('unit_kerja_e2')=='-1') {?>
			<? if($this->sys_menu_model->cekAkses('ADD;',4,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="newData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-add" plain="true">Add</a>  
			<?}?>
		<?}?>
			<? if($this->sys_menu_model->cekAkses('EDIT;',4,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="editData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Edit</a>
			<?}?>
			<? if($this->sys_menu_model->cekAkses('PRINT;',4,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="printData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
			<?}?>
			<? if($this->sys_menu_model->cekAkses('EXCEL;',4,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="toExcel<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-excel" plain="true">Excel</a>
			<?}?>
	  	</div>
	</div>
	
	<table id="dg<?=$objectId;?>" class="easyui-datagrid" style="height:auto;width:auto" title="Data Unit Kerja Eselon II" toolbar="#tb<?=$objectId;?>" fitColumns="true" singleSelect="true" rownumbers="true" pagination="true" nowrap="false">
	<thead>
		<tr>
			<th field="kode_e1" sortable="true" width="30">Kode Eselon I</th>
			<th field="kode_e2" sortable="true" width="30">Kode Unit Kerja</th>		
			<th field="nama_e1" hidden="true">Nama Eselon I</th>
			<th field="nama_e2" sortable="true" width="90">Nama Unit Kerja</th>
			<th field="singkatan" sortable="true" width="35">Singkatan</th>
			<th field="nama_direktur" sortable="true" width="60">Nama Pimpinan</th>
			<th field="nip" sortable="true" width="40">N I P</th>
			<th field="pangkat" sortable="true" width="30">Pangkat</th>
			<th field="gol" sortable="true" width="20">Golongan</th>
		</tr>
	</thead>  
	</table>

	<div class="popdesc" id="popdesc<?=$objectId?>">indriyanto</div>
	 <!-- AREA untuk Form Add/EDIT >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>  -->
	
	<div id="dlg<?=$objectId;?>" class="easyui-dialog" style="width:750px;height:400px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<div class="ftitle">Tambah/Edit Data Unit Kerja Eselon II</div>
		<form id="fm<?=$objectId;?>" method="post">
		
			<div class="fitem" >
				<label style="width:120px">Unit Kerja Eselon I :</label>
				<?=$this->eselon1_model->getListEselon1()?>
			</div>
			<div class="fitem">
				<label style="width:120px;vertical-align:top">Kode Unit Kerja :</label>
				<input name="kode_e2" class="easyui-validatebox" size="10" required="true">
			</div>
			<div class="fitem">
				<label style="width:120px;vertical-align:top">Nama Unit Kerja :</label>
				<input name="nama_e2" class="easyui-validatebox" size="50" required="true">
			</div>
			<div class="fitem">
				<label style="width:120px;vertical-align:top">Singkatan :</label>
				<input name="singkatan" class="easyui-validatebox" size="20" required="false">
			</div>
			<div class="fitem">
				<label style="width:120px;vertical-align:top">Nama Pimpinan :</label>
				<input name="nama_direktur" class="easyui-validatebox" size="50" required="false">
			</div>
			<div class="fitem">
				<label style="width:120px;vertical-align:top">N I P :</label>
				<input name="nip" class="easyui-validatebox" size="20" maxlength="25" required="false">
			</div>
			<div class="fitem">
				<label style="width:120px;vertical-align:top">Pangkat :</label>
				<input name="pangkat" class="easyui-validatebox" size="30" required="false">
			</div>
			<div class="fitem">
				<label style="width:120px;vertical-align:top">Golongan :</label>
				<input name="gol" class="easyui-validatebox" size="10" required="false">
			</div>
		</form>
	</div>

	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveData<?=$objectId;?>()">Save</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg<?=$objectId;?>').dialog('close')">Cancel</a>
	</div>
	

	<script  type="text/javascript" >
		$(function(){
			var url;
			newData<?=$objectId;?> = function (){  
				$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Add Sasaran Eselon II');  
				$('#fm<?=$objectId;?>').form('clear');  
				initCombo();
				url = base_url+'pengaturan/sasaran_program/save/add'; 
			}
			//end newData 
						
			clearFilter<?=$objectId;?> = function (){
				//ambil nilai-nilai filter
				$("#filter_e1<?=$objectId;?>").val('');	
				$("#filter_e2<?=$objectId;?>").val('');	
				searchData<?=$objectId;?>();
			}
			
			searchData<?=$objectId;?> = function (){
				//ambil nilai-nilai filter
				var file2 = $("#filter_e2<?=$objectId;?>").val();
				$('#dg<?=$objectId;?>').datagrid({url:"<?=base_url()?>pengaturan/sasaran_program/grid/"+file2});
			}
			//end searhData 
			
			editData<?=$objectId;?> = function (){
				var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
				$('#fm<?=$objectId;?>').form('clear');  
				initCombo();
				var kdSasaranE1 = row.kode_sasaran_e1;
				var kdKegiatan = row.kode_kegiatan;
				document.getElementById('kode_sasaran_e1<?=$objectId;?>').value = kdSasaranE1;
				document.getElementById('kode_kegiatan<?=$objectId;?>').value = kdKegiatan;
				//alert(row.dokter_kode);
				if (row){
					$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Edit Sasaran Eselon II');
					$('#fm<?=$objectId;?>').form('load',row);
					url = base_url+'pengaturan/sasaran_program/save/edit/'+row.kode_sasaran_e2;//+row.id;//'update_user.php?id='+row.id;
				}
			}
			//end editData
		
			printData<?=$objectId;?>=function(){
				var data = $('#dg<?=$objectId;?>').datagrid('getRows');	// reload the user data
				for (i=0;i<data.length;i++){
					alert(data[i].kode_sasaran_e2);
				
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
							$.messager.show({
								title: 'Sucsees',
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
			
			$("#filter_e1<?=$objectId;?>").change(function(){
				$("#divUnitKerja<?=$objectId;?>").load(base_url+"rujukan/eselon2/loadFilterE2/"+$(this).val()+"/<?=$objectId;?>");
			
			});
			setTimeout(function(){
				$('#dg<?=$objectId;?>').datagrid({url:"<?=base_url()?>pengaturan/sasaran_program/grid"});
			},50);
		 });
		 
	</script>
	
	<!-- Dari Stef -->
	
	<script type="text/javascript">
		$(document).ready(function() {
			// yjs modified
			initCombo = function(){
				//sasaran
				if($("#drop<?=$objectId;?>").is(":visible")){
					$("#drop<?=$objectId;?>").slideUp("slow");
				}
			
				$("#txtkode_sasaran_e1<?=$objectId;?>").click(function(){
					$("#drop<?=$objectId;?>").slideDown("slow");
				});
				
				$("#drop<?=$objectId;?> li").click(function(e){
					var chose = $(this).text();
					$("#txtkode_sasaran_e1<?=$objectId;?>").val(chose);
					$("#drop<?=$objectId;?>").slideUp("slow");
				});
				
				//kegiatan
				if($("#dropkegiatan<?=$objectId;?>").is(":visible")){
					$("#dropkegiatan<?=$objectId;?>").slideUp("slow");
				}
			
				$("#txtkode_kegiatan<?=$objectId;?>").click(function(){
					$("#dropkegiatan<?=$objectId;?>").slideDown("slow");
				});
				
				$("#dropkegiatan<?=$objectId;?> li").click(function(e){
					var chose = $(this).text();
					$("#txtkode_kegiatan<?=$objectId;?>").val(chose);
					$("#dropkegiatan<?=$objectId;?>").slideUp("slow");
				});
			}

		});
		
		function setSasaran<?=$objectId;?>(valu){
			document.getElementById('kode_sasaran_e1<?=$objectId;?>').value = valu;
			//alert(document.getElementById('kode_sasaran_e1<?=$objectId;?>').value);
		}
		
		
		function setKegiatan<?=$objectId;?>(valu){
			document.getElementById('kode_kegiatan<?=$objectId;?>').value = valu;
			//alert(document.getElementById('kode_sasaran_e1<?=$objectId;?>').value);
		}
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
		  <div class="fsearch" <?=($this->session->userdata('unit_kerja_e1')=='-1'?'':'style="display:none"')?>>
			
			<table border="0" cellpadding="1" cellspacing="1">
			<tr>
				<td>Unit Kerja Eselon I</td>
				<td>
					<?=$this->eselon1_model->getListFilterEselon1($objectId,$this->session->userdata('unit_kerja_e1'))?>
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
		<a href="#" onclick="newData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-add" plain="true">Add</a>  
		<a href="#" onclick="editData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Edit</a>
		<a href="#" onclick="printData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
	  </div>
	</div>
	
	<table id="dg<?=$objectId;?>" class="easyui-datagrid" style="height:auto;width:auto" title="Sasaran Program" toolbar="#tb<?=$objectId;?>" fitColumns="true" singleSelect="true" rownumbers="true" pagination="true">
	  <thead>
	  <tr>
		<th field="tahun" sortable="true" width="20">Tahun</th>
		<th field="kode_e1" sortable="true" width="30" <?=($this->session->userdata('unit_kerja_e1')=='-1'?'':'hidden="true"')?>>Kode Eselon I </th>
		<th field="kode_sasaran_e1" sortable="true" width="30">Kode Sasaran Eselon I</th>
		<th field="kode_program" sortable="true" width="30">Kode Program</th>
		<th field="kode_kegiatan" sortable="true" width="30">Kode Kegiatan</th>		
	  </tr>
	  </thead>  
	</table>

	 <!-- AREA untuk Form Add/EDIT >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>  -->
	
	<div id="dlg<?=$objectId;?>" class="easyui-dialog" style="width:1150px;height:400px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<div class="ftitle">Add/Edit Sasaran Program</div>
		<form id="fm<?=$objectId;?>" method="post">
			<input name="kode_sasaran_e1" type="hidden">
			<div class="fitem" >
				<label style="width:120px">Unit Kerja Eselon I</label>
				<?=$this->eselon1_model->getListEselon1()?>
			</div>
			<div class="fitem">
				<label style="width:120px;vertical-align:top">Tahun</label>
				<input name="tahun" class="easyui-validatebox" size="20" required="true">
			</div>
			<div class="fitem" >
				<label style="width:120px">Sasaran Eselon I</label>
				<?=$this->sasaran_eselon1_model->getListSasaranE1($objectId)?>
			</div>
			<div class="fitem" >
				<label style="width:120px">Program</label>
				<?=$this->programkl_model->getListProgramKL()?>
			</div>
			<div class="fitem" >
				<label style="width:120px">Kegiatan</label>
				<?=$this->kegiatankl_model->getListKegiatanKL($objectId)?>
			</div>
		</form>
		<div id="dlg-buttons">
			<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveData<?=$objectId;?>()">Save</a>
			<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg<?=$objectId;?>').dialog('close')">Cancel</a>
		</div>
    </div>
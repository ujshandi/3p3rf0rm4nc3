	<script  type="text/javascript" >
		$(function(){
			var url;
			
			
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
			//end saveData

			newData<?=$objectId;?> = function (){  
				$('#ftitle<?=$objectId;?>').html("Add Data "+"<?=$title?>");
				$('#saveBtn<?=$objectId;?>').css("display","");
				$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Add Sasaran Kementerian');
				$('#fm<?=$objectId;?>').form('clear');  

				url = base_url+'pengaturan/sasaran_kl/save/add'; 

				$("#kode_sasaran_kl<?=$objectId?>").removeAttr('readonly');
			}
			//end newData 
			
			editData<?=$objectId;?> = function (editmode){
				//----------------Edit title
				$('#ftitle<?=$objectId;?>').html((editmode?"Edit Data ":"View Data ")+"<?=$title?>");
				$('#saveBtn<?=$objectId;?>').css("display",(editmode)?"":"none");
				var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
				$('#fm<?=$objectId;?>').form('clear');  
				//alert(row.dokter_kode);
				if (row){
					$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Edit Sasaran Kementerian');
					$('#fm<?=$objectId;?>').form('load',row);
					$("#kode_kl<?=$objectId?>").val(row.kode_kl);
					url = base_url+'pengaturan/sasaran_kl/save/edit/'+row.kode_sasaran_kl+"/"+row.tahun;//+row.id;//'update_user.php?id='+row.id;
				}
				
				//$("#kode_sasaran_kl<?=$objectId?>").attr("readonly","readonly");

			}
			//end editData
			
			deleteData<?=$objectId;?> = function (){
				var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
				if(row){
					if(confirm("Apakah yakin akan menghapus data '" + row.kode_sasaran_kl + "'?")){
						var response = '';
						$.ajax({ type: "GET",
								 url: base_url+'pengaturan/sasaran_kl/delete/' + row.tahun + '/' + row.kode_sasaran_kl,
								 async: false,
								 success : function(response)
								 {
									var response = eval('('+response+')');
									if (response.success){
										$.messager.show({
											title: 'Success',
											msg: 'Data Berhasil Dihapus'
										});
										
										// reload and close tab
										$('#dg<?=$objectId;?>').datagrid('reload');
									} else {
										$.messager.show({
											title: 'Error',
											msg: response.msg
										});
									}
								 }
						});
					}
				}
			}
			//end deleteData 
			
			printData<?=$objectId;?>=function(){			
				window.open(getUrl<?=$objectId;?>(2));;
			}
			//end printData

			toExcel<?=$objectId;?>=function(){
				window.open(getUrl<?=$objectId;?>(3));;
			}
			//end toExcel
			
			importData<?=$objectId;?>=function(){
				$('#fmimport<?=$objectId;?>').form('submit',{
					url: url,
					onSubmit: function(){
						//return $(this).form('validate');
					},
					success: function(result){
						//alert(result);
						var result = eval('('+result+')');
						if (result.success){
							 $.messager.show({
								title: 'Sukses',
								msg: result.msg
							}); 
							$('#dlgimport<?=$objectId;?>').dialog('close');	// close the dialog
							$('#dg<?=$objectId;?>').datagrid('reload');		// reload the user data
						} else {
							$.messager.show({
								title: 'Error',
								msg: result.msg
							});
						}
					}
				});
			}
			//end importData

			import<?=$objectId;?> = function (){  
				$('#dlgimport<?=$objectId;?>').dialog('open').dialog('setTitle','Import Data Sasaran Kementerian');
				$('#fmimport<?=$objectId;?>').form('clear');  
				url = base_url+'pengaturan/sasaran_kl/import'; 
			}
			//end import
			
			//tipe 1=grid, 2=pdf, 3=excel
			getUrl<?=$objectId;?> = function (tipe){
				var filtahun = $("#filter_tahun<?=$objectId;?>").val();
				var filkey = $("#key<?=$objectId;?>").val();
				if (tipe==1){
					return "<?=base_url()?>pengaturan/sasaran_kl/grid/"+filtahun+"/"+filkey;
				}
				else if (tipe==2){
					return "<?=base_url()?>pengaturan/sasaran_kl/pdf/"+filtahun+"/"+filkey;
				}else if (tipe==3){
					return "<?=base_url()?>pengaturan/sasaran_kl/excel/"+filtahun+"/"+filkey;
				}
			}
			//end getUrl
			
			
			setKodeOtomatis<?=$objectId?> = function(){
				var filkl ="-1";
				var filtahun = $("#tahun<?=$objectId;?>").val();
				
				
				if ((filtahun == null)||(filtahun == '')) filtahun = "-1";
				$.ajax({url:base_url+"pengaturan/sasaran_kl/getNewCode/"+filkl+"/"+filtahun,
					success : function(data){
					$("#kode_sasaran_kl<?=$objectId?>").val(data);
					}					
					})
				
			}
			
			$("#tahun<?=$objectId;?>").change(function(){				
				  setKodeOtomatis<?=$objectId?>();
			});
			
			$("#kode_kl<?=$objectId;?>").change(function(){				
				  setKodeOtomatis<?=$objectId?>();
			});
			

			clearFilter<?=$objectId;?> = function (){
				//ambil nilai-nilai filter
				// $("#filter_nip").val('');
				// $("#filter_nama").val('');
				// $("#filter_alamat").val('');
				$("#filter_tahun<?=$objectId;?>").val('');
				
				//$('#dg<?=$objectId;?>').datagrid({url:"<?=base_url()?>pengaturan/kl/grid/"+filnip+"/"+filnama+"/"+filalamat});
			}
			
			submitEnter<?=$objectId;?> =function (e){
				if (e.keyCode == 13) {
					searchData<?=$objectId;?>();
				}
			}
			
			searchData<?=$objectId;?> = function (){
				//ambil nilai-nilai filter
				// var filnip = $("#filter_nip").val();
				// var filnama = $("#filter_nama").val();
				// var filalamat = $("#filter_alamat").val();
				
				// //encode parameter
				// if(filnip.length==0) filnip ="6E756C6C";
				// else filnip = DoAsciiHex(filnip,"A2H");
								
				// if(filnama.length==0) filnama ="6E756C6C";
				// else filnama = DoAsciiHex(filnama,"A2H");
				// if(filalamat.length==0) filalamat ="6E756C6C";
				// else filalamat = DoAsciiHex(filalamat,"A2H");
				//encode parameter

				$('#dg<?=$objectId;?>').datagrid({url:getUrl<?=$objectId;?>(1)});
			}
			//end searchData 
			
			setTimeout(function(){
				searchData<?=$objectId;?> ();//$('#dg<?=$objectId;?>').datagrid({url:"<?=base_url()?>pengaturan/sasaran_kl/grid"});
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
				<div class="fsearch">
					<table border="0" cellpadding="1" cellspacing="1">
					<tr>
						<td width="90px">Tahun :</td>
						<td><?=$this->sasaran_kl_model->getListFilterTahun($objectId);?></span></td>
					</tr>
					<tr>
						<td>Kata Kunci :</td>
						<td><input id="key<?=$objectId;?>" name="key<?=$objectId;?>" type="text" onkeypress="submitEnter<?=$objectId;?>(event)"/></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
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
			<? if($this->sys_menu_model->cekAkses('ADD;',31,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="newData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-add" plain="true">Add</a>  
			<?}?>
			<? if($this->sys_menu_model->cekAkses('EDIT;',31,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="editData<?=$objectId;?>(true);" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Edit</a>
			<?}?>
			<? if($this->sys_menu_model->cekAkses('VIEW;',31,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="editData<?=$objectId;?>(false);" class="easyui-linkbutton" iconCls="icon-view" plain="true">View</a>
			<?}?>
			<? if($this->sys_menu_model->cekAkses('DELETE;',31,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="deleteData<?=$objectId;?>(false);" class="easyui-linkbutton" iconCls="icon-remove" plain="true">Delete</a>
			<?}?>
			<? if($this->sys_menu_model->cekAkses('PRINT;',31,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="printData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
			<?}?>
			<? if($this->sys_menu_model->cekAkses('EXCEL;',31,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="toExcel<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-excel" plain="true">Excel</a>
			<?}?>
			<? if($this->sys_menu_model->cekAkses('IMPORT;',31,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="import<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-import" plain="true">Import</a>
			<?}?>
			
		</div>
	</div>
	
	<table id="dg<?=$objectId;?>" style="height:auto;width:auto" title="Data Sasaran Kementerian" toolbar="#tb<?=$objectId;?>" fitColumns="true" singleSelect="true" rownumbers="true" pagination="true" nowrap="false">
		<thead>
			<tr>
				<th field="kode_kl" sortable="true" width="15" hidden="true">Kode KL</th>
				<th field="tahun" sortable="true" width="10">Tahun</th>
				<th field="kode_sasaran_kl" sortable="true" width="15">Kode Sasaran</th>
				<th field="deskripsi" sortable="true" width="110">Deskripsi</th>
			</tr>
		</thead>  
	</table>

	 <!-- AREA untuk Form Add/Edit >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>  -->
	<div id="dlg<?=$objectId;?>" class="easyui-dialog" style="width:800px;height:280px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<!----------------Edit title-->
		<div id="ftitle<?=$objectId?>" class="ftitle">Add/Edit/View Data Sasaran Kementerian</div>
		<form id="fm<?=$objectId;?>" method="post">		
			<div class="fitem">
				<label style="width:150px;vertical-align:top">Tahun</label>
				<input name="tahun" id="tahun<?=$objectId?>" class="easyui-validatebox" size="4" required="true">
			</div>		
			<div class="fitem">
				<label style="width:150px;vertical-align:top">Nama Kementerian</label>
				<?=$this->kl_model->getListKL($objectId)?>
			</div>
			<div class="fitem">
				<label style="width:150px;vertical-align:top">Kode Sasaran</label>
				<input name="kode_sasaran_kl" class="easyui-validatebox" size="10" required="true" id="kode_sasaran_kl<?=$objectId;?>">
			</div>
			<div class="fitem">
				<label style="width:150px;vertical-align:top">Deskripsi</label>
				<textarea name="deskripsi" cols="80" class="easyui-validatebox" ></textarea>
			</div>
		</form>
    	<div id="dlg-buttons">
			<!----------------Edit title-->
			<a href="#" id="saveBtn<?=$objectId;?>" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveData<?=$objectId;?>()">Save</a>
			<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg<?=$objectId;?>').dialog('close')">Cancel</a>
    	</div>
	</div>
	
	<!-- Form Import -->
	<div id="dlgimport<?=$objectId;?>" class="easyui-dialog" style="width:500px;height:200px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<div class="ftitle">Import Data Sasaran dari Excel</div>
		<?php 
			$attributes = array('id' => 'fmimport'.$objectId);
			echo form_open_multipart('', $attributes);
		?>	
			<div class="fitem">
				<label style="width:80px;vertical-align:top">Nama File</label>
				<input type="file" name="datafile"/>
			</div>
		</form>
    	<div id="dlg-buttons">
			<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="importData<?=$objectId;?>()">Import</a>
			<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgimport<?=$objectId;?>').dialog('close')">Cancel</a>
    	</div>
	</div>

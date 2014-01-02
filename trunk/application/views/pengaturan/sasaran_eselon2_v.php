	<script  type="text/javascript" >
		$(function(){
			$('textarea').autosize();   
			var url;
			//chan=============================================
			function setListE2<?=$objectId?>(e2){
				$("#divEselon2<?=$objectId?>").load(
					base_url+"rujukan/eselon2/loadE2/"+$("#kode_e1<?=$objectId?>").val()+"/<?=$objectId;?>",
					//on complete
					function (){
						//setSasaranE1<?=$objectId?>($("#kode_e1<?=$objectId?>").val());
						$("#kode_e1<?=$objectId?>").change(function(){
						//	setSasaranE1<?=$objectId?>($(this).val());
						});	
						//setSasaranE1<?=$objectId?>($("#kode_e1<?=$objectId?>").val());
						if($("#drop<?=$objectId;?>").is(":visible")){
							$("#drop<?=$objectId;?>").slideUp("slow");
						}
						//$('#kode_e2<?=$objectId;?>').val('<?=$this->session->userdata('unit_kerja_e2');?>');
						
						$("#kode_e2<?=$objectId?>").change(function(){
							setKodeOtomatis<?=$objectId?>();
							
						 });
						 
						$('#kode_e2<?=$objectId;?>').val(e2);
						 setKodeOtomatis<?=$objectId?>();
						//setSasaranE1<?=$objectId?>($("#kode_e1<?=$objectId?>").val());
					}
				);
				
			//	setSasaranE1<?=$objectId;?>($("#kode_e1<?=$objectId?>").val());
			}
			
			setKodeOtomatis<?=$objectId?> = function(){
				<? if ($this->session->userdata('unit_kerja_e2')==-1){?>
					var file2 = $("#kode_e2<?=$objectId;?>").val();
				<?} else {?>
					var file2 = "<?=$this->session->userdata('unit_kerja_e2');?>";
				<?}?>
				var filtahun = $("#tahun<?=$objectId;?>").val();
				
				if (file2 == null) file2 = "-1";
				if ((filtahun == null)||(filtahun == '')) filtahun = "-1";
				$.ajax({url:base_url+"pengaturan/sasaran_eselon2/getNewCode/"+file2+"/"+filtahun,
					success : function(data){
					$("#kode_sasaran_e2<?=$objectId?>").val(data);
					}					
					})
				
			}
			 
			$("#kode_e1<?=$objectId?>").change(function(){
				setListE2<?=$objectId?>();
				setSasaranE1<?=$objectId?>($("#tahun").val(),$(this).val(),"","");
			});
			
			 $("#tahun<?=$objectId;?>").change(function(){
			
				// setIKUE1<?=$objectId;?>($(this).val(),$("#kode_e1<?=$objectId?>").val(),"","");
				setSasaranE1<?=$objectId?>($(this).val(),$("#kode_e1<?=$objectId?>").val(),"","");
				 setKodeOtomatis<?=$objectId?>();
			});
			  
			function setSasaranE1<?=$objectId;?>(tahun,e1,key,val){
				<? if ($this->session->userdata('unit_kerja_e1')!='-1') {?>
				 e1 = '<?=$this->session->userdata('unit_kerja_e1');?>';
				 $("#kode_e1<?=$objectId;?>").val(e1);
				<?}?>
				if (tahun=="") tahun = "-1";
				 $("#divSasaranE1<?=$objectId?>").load(
					base_url+"pengaturan/sasaran_eselon2/getListSasaranE1/"+"<?=$objectId;?>"+"/"+e1+"/"+tahun,
					function(){
						$('textarea').autosize();   
						
						$("#txtkode_sasaran_e1<?=$objectId;?>").click(function(){
							$("#drop<?=$objectId;?>").slideDown("slow");
						});
						
						$("#drop<?=$objectId;?> li").click(function(e){
							var chose = $(this).text();
							$("#txtkode_sasaran_e1<?=$objectId;?>").val(chose);
							$("#drop<?=$objectId;?>").slideUp("slow");
						});
						
						if (key!=null)
							$('#kode_sasaran_e1<?=$objectId;?>').val(key);
						if (val!=null)
							$('#txtkode_sasaran_e1<?=$objectId;?>').val(val);
					}
				); 
				//alert("here");
				
			}
			
			//inisilaisasi;
			function initCombo(){
				setListE2<?=$objectId?>();
				setSasaranE1<?=$objectId?>($("#tahun<?=$objectId?>").val(),$("#kode_e1<?=$objectId?>").val());
				//setSasaranE1<?=$objectId;?>($("#kode_e1<?=$objectId?>").val());
			}
			
			//--------------------
			newData<?=$objectId;?> = function (){  
				//----------------Edit title
				$('#ftitle<?=$objectId;?>').html("Add Data "+"<?=$title?>");
				$('#saveBtn<?=$objectId;?>').css("display","");
				$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Add Sasaran Eselon II');  
				$('#fm<?=$objectId;?>').form('clear');  
				$('#kode_e1<?=$objectId;?>').val('<?=$this->session->userdata('unit_kerja_e1');?>');
				initCombo();
				  
				url = base_url+'pengaturan/sasaran_eselon2/save/add'; 
				
				$("#kode_sasaran_e2<?=$objectId?>").removeAttr('readonly');
			}
			//end newData
			download<?=$objectId;?>=function(){
				window.location=base_url+"download/format_excel_import/sasaran_e2.xls"
			}
			
			import<?=$objectId;?> = function (){  
				$('#dlgimport<?=$objectId;?>').dialog('open').dialog('setTitle','Import Sasaran Eselon 2');
				$('#fmimport<?=$objectId;?>').form('clear');  
				url = base_url+'pengaturan/sasaran_eselon2/import'; 
			}
			
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
								title: 'Sucsees',
								msg: result.msg
							}); 
							$('#dlgimport<?=$objectId;?>').dialog('close');		// close the dialog
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
						
			clearFilter<?=$objectId;?> = function (){
				//ambil nilai-nilai filter
				$("#filter_e1<?=$objectId;?>").val('');	
				$("#filter_e2<?=$objectId;?>").val('');	

				searchData<?=$objectId;?>();
			}
			//tipe 1=grid, 2=pdf, 3=excel
			getUrl<?=$objectId;?> = function (tipe){
				<? if ($this->session->userdata('unit_kerja_e1')==-1){?>
					var file1 = $("#filter_e1<?=$objectId;?>").val();
				<?} else {?>
					var file1 = "<?=$this->session->userdata('unit_kerja_e1');?>";
				<?}?>
				<? if ($this->session->userdata('unit_kerja_e2')==-1){?>
					var file2 = $("#filter_e2<?=$objectId;?>").val();
				<?} else {?>
					var file2 = "<?=$this->session->userdata('unit_kerja_e2');?>";
				<?}?>
				var filtahun = $("#filter_tahun<?=$objectId;?>").val();
				var filkey = $("#key<?=$objectId;?>").val();
				if (filtahun == null) filtahun = "-1";
				if (filkey == null) filkey = "-1";
				if (file1 == null) file1 = "-1";
				if (file2 == null) file2 = "-1";
			
				if (tipe==1){
					return "<?=base_url()?>pengaturan/sasaran_eselon2/grid/"+file1+"/"+file2+"/"+filtahun+"/"+filkey;
				}
				else if (tipe==2){
					return "<?=base_url()?>pengaturan/sasaran_eselon2/pdf/"+file1+"/"+file2+"/"+filtahun+"/"+filkey;
				}else if (tipe==3){
					return "<?=base_url()?>pengaturan/sasaran_eselon2/excel/"+file1+"/"+file2+"/"+filtahun+"/"+filkey;
				}
			}
			
			searchData<?=$objectId;?> = function (){
				//ambil nilai-nilai filter
				$('#dg<?=$objectId;?>').datagrid({
					url:getUrl<?=$objectId;?>(1),
					queryParams:{lastNo:'0'},	
					pageNumber : 1,
					onClickCell: function(rowIndex, field, value){
						$('#dg<?=$objectId;?>').datagrid('selectRow', rowIndex);
						var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
						
						switch(field){
							case "kode_e2":
								showPopup('#popdesc<?=$objectId?>', row.nama_e2);
								break;
							case "kode_sasaran_e1":
								showPopup('#popdesc<?=$objectId?>', row.e1_deskripsi);
								break;
							default:
								closePopup('#popdesc<?=$objectId?>');
								break;
						}
					},
					onLoadSuccess:function(data){	
						$('#dg<?=$objectId;?>').datagrid('options').queryParams.lastNo = data.lastNo;
						//prepareMerge<?=$objectId;?>(data);
				}});
			}
			//end searhData 
			
			printData<?=$objectId;?>=function(){
				window.open(getUrl<?=$objectId;?>(2));;
			}
			
			toExcel<?=$objectId;?>=function(){
				window.open(getUrl<?=$objectId;?>(3));;
			}
			
			editData<?=$objectId;?> = function (editmode){
				//----------------Edit title
				$('#ftitle<?=$objectId;?>').html((editmode?"Edit Data ":"View Data ")+"<?=$title?>");
				$('#saveBtn<?=$objectId;?>').css("display",(editmode)?"":"none");
				var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
				$('#fm<?=$objectId;?>').form('clear');  
				//alert(row.dokter_kode);
				if (row){
					$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Edit Sasaran Eselon II');
					$('#fm<?=$objectId;?>').form('load',row);
					setListE2<?=$objectId?>(row.kode_e2);
					setSasaranE1<?=$objectId?>($("#tahun<?=$objectId?>").val(),$("#kode_e1<?=$objectId?>").val(),row.kode_sasaran_e1,row.deskripsi_e1);
					//initCombo();
					//alert(row.kode_sasaran_e1);
					// ajax
					/* var response = '';
					$.ajax({ type: "GET",   
							 url: base_url+'pengaturan/sasaran_eselon2/getDeskripsiSasaran/' + row.kode_sasaran_e1,   
							 async: false,
							 success : function(text)
							 {
								 response = text;
							 }
					}); */
					
					$('#kode_e1<?=$objectId;?>').val(row.kode_e1);
					$('#kode_e2<?=$objectId;?>').val(row.kode_e2);
					//$('#txtkode_sasaran_e1<?=$objectId;?>').val(row.kode_sasaran_e1);
					/* 
					setTimeout(function(){
						$('#txtkode_sasaran_e1<?=$objectId;?>').val(row.deskripsi_e1);
					},150); */
			
					url = base_url+'pengaturan/sasaran_eselon2/save/edit/'+row.kode_sasaran_e2;//+row.id;//'update_user.php?id='+row.id;
					
					//$("#kode_sasaran_e2<?=$objectId?>").attr("readonly","readonly");
					
				}
			}
			//end editData
		
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
			
			deleteData<?=$objectId;?> = function (){
				var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
				if(row){
					if(confirm("Apakah yakin akan menghapus data '" + row.kode_sasaran_e2 + "'?")){
						var response = '';
						$.ajax({ type: "GET",
								 url: base_url+'pengaturan/sasaran_eselon2/delete/' + row.tahun + '/' + row.kode_sasaran_e2,
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
			
			$("#filter_e1<?=$objectId;?>").change(function(){
				$("#divUnitKerja<?=$objectId;?>").load(base_url+"rujukan/eselon2/loadFilterE2/"+$(this).val()+"/<?=$objectId;?>");
			
			});
			setTimeout(function(){
				//$('#dg<?=$objectId;?>').datagrid({url:"<?=base_url()?>pengaturan/sasaran_eselon2/grid"});
				searchData<?=$objectId;?> ();
			},50);
			
			submitEnter<?=$objectId;?> = function(e) {
			if (e.keyCode == 13) {
				searchData<?=$objectId;?>();
			}
		}
			
			$("#popdesc<?=$objectId?>").click(function(){
				closePopup('#popdesc<?=$objectId?>');
			});
			
		 });
	</script>
	
	<!-- Dari Stef -->
	<script type="text/javascript">
		$(document).ready(function() {
			/*chan-----------
			if($("#drop<?=$objectId;?>").is(":visible")){
				$("#drop<?=$objectId;?>").slideToggle("slow");
			}
			
			$("#txtkode_sasaran_e1<?=$objectId;?>").click(function(){
				$("#drop<?=$objectId;?>").slideToggle("slow");
			});
			
			$("#drop<?=$objectId;?> li").click(function(e){
				var chose = $(this).text();
				$("#txtkode_sasaran_e1<?=$objectId;?>").text(chose);
				$("#drop<?=$objectId;?>").slideToggle("slow");
			});*/
		});
		
		function setSasaran<?=$objectId;?>(valu){
			document.getElementById('kode_sasaran_e1<?=$objectId;?>').value = valu;
			getDetail();
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
		  <div class="fsearch">
			
			<table border="0" cellpadding="1" cellspacing="1">			
			<tr>
				<td>Tahun :</td>
				<td><?=$this->sasaran_eselon2_model->getListFilterTahun($objectId);?></span></td>
			</tr>
			<?// if ($this->session->userdata('unit_kerja_e1')==-1){?>
			<tr>
				<td>Unit Kerja Eselon I&nbsp;</td>
				<td>
					<?=$this->eselon1_model->getListFilterEselon1($objectId,$this->session->userdata('unit_kerja_e1'))?>				
				</td>
			</tr>
			<?//}
		//	var_dump($this->session->userdata('unit_kerja_e2'));
			?>
			<tr>
				<td>Unit Kerja Eselon II&nbsp;</td>
				<td><span class="fitem" id="divUnitKerja<?=$objectId;?>">
					<?=$this->eselon2_model->getListFilterEselon2($objectId,$this->session->userdata('unit_kerja_e1'),$this->session->userdata('unit_kerja_e2'))?>
					</span>
				</td>
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
		<? if($this->sys_menu_model->cekAkses('ADD;',33,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="newData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-add" plain="true">Add</a>  
		<?}?>
		<!----------------Edit title-->
		<? if($this->sys_menu_model->cekAkses('EDIT;',33,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="editData<?=$objectId;?>(true);" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Edit</a>
		<?}?>
		<? if($this->sys_menu_model->cekAkses('VIEW;',33,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="editData<?=$objectId;?>(false);" class="easyui-linkbutton" iconCls="icon-view" plain="true">View</a>
		<?}?>
		<? if($this->sys_menu_model->cekAkses('DELETE;',33,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="deleteData<?=$objectId;?>(false);" class="easyui-linkbutton" iconCls="icon-remove" plain="true">Delete</a>
		<?}?>
		<? if($this->sys_menu_model->cekAkses('PRINT;',33,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="printData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
		<?}?>
		<? if($this->sys_menu_model->cekAkses('EXCEL;',33,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="toExcel<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-excel" plain="true">Excel</a>
		<?}?>
		<? if($this->sys_menu_model->cekAkses('IMPORT;',33,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="import<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-import" plain="true">Import</a>
		<?}?>
		<a href="#" onclick="download<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-download" plain="true">Download Format Excel</a>
	  </div>
	</div>
	
	<table id="dg<?=$objectId;?>" style="height:auto;width:auto" title="Data Sasaran Unit Kerja Eselon II" toolbar="#tb<?=$objectId;?>" fitColumns="true" singleSelect="true" rownumbers="true" pagination="true" nowrap="false">
	  <thead>
	  <tr>
		<th field="kode_e1" sortable="true" hidden="true" width="30" <?=($this->session->userdata('unit_kerja_e2')=='-1'?'':'hidden="true"')?>>Kode Eselon II </th>
		<th field="kode_e2" sortable="true" width="30" <?=($this->session->userdata('unit_kerja_e2')=='-1'?'':'hidden="true"')?>>Kode Eselon II </th>
		<th field="nama_e2" sortable="true" hidden="true">Nama</th>
		<th field="tahun" sortable="true" width="10">Tahun</th>
		<th field="kode_sasaran_e2" sortable="true" width="20">Kode Sasaran</th>
		<th field="deskripsi" sortable="true" width="120">Deskripsi Sasaran</th>
		<th field="kode_sasaran_e1" sortable="true" width="30">Kode Sasaran Eselon I</th>		
		<th field="e1_deskripsi" sortable="true" hidden="true">e1_deskripsi</th>				
	  </tr>
	  </thead>  
	</table>

	 <!-- AREA untuk Form Add/EDIT >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>  -->
	
	<div id="dlg<?=$objectId;?>" class="easyui-dialog" 
	style="width:800px;height:400px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<!----------------Edit title-->
		<div id="ftitle<?=$objectId?>" class="ftitle">Add/Edit/View Data Sasaran Unit Kerja Eselon II</div>
		
		<form id="fm<?=$objectId;?>" method="post">
			<!-- chan : Jika login superadmin maka tampilkan combo E1 utk nge filter list E2 -->
			<?// if ($this->session->userdata('unit_kerja_e1')=='-1'){?>
			<div class="fitem">
				<label style="width:150px;vertical-align:top">Tahun :</label>
				<input name="tahun" id="tahun<?=$objectId?>" class="easyui-validatebox year" size="4" required="true">
			</div>		
			<div class="fitem">							
				<label style="width:150px">Unit Kerja Eselon I :</label>
				<?
				//if ($this->session->userdata('unit_kerja_e1')=='-1'){
					$this->eselon1_model->getListEselon1($objectId);
				//} else { 
					//echo $this->eselon1_model->getNamaE1($this->session->userdata('unit_kerja_e1'));								
				 //} ?>
			</div>					
			<?//}?>
			<div class="fitem">							
				<label style="width:150px">Unit Kerja Eselon II :</label>
				<span id="divEselon2<?=$objectId?>">
				<?
				/* CHAN 
				if ($this->session->userdata('unit_kerja_e2')=='-1'){
					$this->eselon2_model->getListEselon2($objectId);
				} else { 
					echo $this->eselon2_model->getNamaE2($this->session->userdata('unit_kerja_e2'));
					
				 } */?>
				 </span>
			</div>
			<div class="fitem">
				<label style="width:150px;vertical-align:top">Kode Sasaran Eselon II :</label>
				<input name="kode_sasaran_e2" class="easyui-validatebox" size="25" required="true" id="kode_sasaran_e2<?=$objectId;?>">
			</div>
			<div class="fitem">
				<label style="width:150px;vertical-align:top">Sasaran Eselon I :</label>
				<span id="divSasaranE1<?=$objectId?>">
				<?="";//chan $this->sasaran_eselon1_model->getListSasaranE1($objectId)?>
				</span>
			</div>
			<div class="fitem">
				<label style="width:150px;vertical-align:top">Deskripsi Sasaran :</label>
				<textarea name="deskripsi" cols="70" class="easyui-validatebox" ></textarea>
			</div>
		</form>
    	<div id="dlg-buttons">
			<!----------------Edit title-->
			<a href="#" id="saveBtn<?=$objectId;?>" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveData<?=$objectId;?>()">Save</a>
			<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg<?=$objectId;?>').dialog('close')">Cancel</a>
		</div>
	</div>
	
	
	<!-- FORM IMPORT -->
	<div id="dlgimport<?=$objectId;?>" class="easyui-dialog" style="width:500px;height:200px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<div class="ftitle">Import Data Sasaran dari Excel</div>
		<?php 
			$attributes = array('id' => 'fmimport'.$objectId);
			echo form_open_multipart('', $attributes);
		?>	
			<div class="fitem">
				<label style="width:60px;vertical-align:top">File :</label>
				<input type="file" name="datafile"/>
			</div>
		</form>
    	<div id="dlg-buttons">
			<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="importData<?=$objectId;?>()">Save</a>
			<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgimport<?=$objectId;?>').dialog('close')">Cancel</a>
    	</div>
	</div>
	
	<div class="popdesc" id="popdesc<?=$objectId?>">&nbsp;</div>

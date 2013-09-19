	<script  type="text/javascript" >
		$(function(){
			var url;
			loadTahun<?=$objectId;?> = function (){
				$('#divTahun<?=$objectId;?>').load(
					base_url+"pengaturan/iku_kl/getListTahun/"+"<?=$objectId;?>"
				);
			}
			
			loadTahun<?=$objectId;?>();
			
			setKodeOtomatis<?=$objectId?> = function(){
				var filkl ="-1";
				var filtahun = $("#tahun<?=$objectId;?>").val();
				var kodesasaran = $("#kode_sasaran_kl<?=$objectId;?>").val();				
				if ((kodesasaran == null)||(kodesasaran == '')) kodesasaran = "-1";
				if ((filtahun == null)||(filtahun == '')) filtahun = "-1";
				$.ajax({url:base_url+"pengaturan/iku_kl/getNewCode/"+filkl+"/"+filtahun+"/"+kodesasaran,
					success : function(data){
					$("#kode_iku_kl<?=$objectId?>").val(data);
					}					
					})
				
			}
			
			$("#tahun<?=$objectId;?>").change(function(){				
				  setSasaranKL<?=$objectId;?>($(this).val(),"","");
				  setKodeOtomatis<?=$objectId?>();
			});
			
			$("#kode_kl<?=$objectId;?>").change(function(){				
				  setKodeOtomatis<?=$objectId?>();
			});
			
			
			newData<?=$objectId;?> = function (){  
				//----------------Edit title
				$('#ftitle<?=$objectId;?>').html("Add Data "+"<?=$title?>");
				$('#saveBtn<?=$objectId;?>').css("display","");
				$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Add IKU Kementerian');  
				$('#fm<?=$objectId;?>').form('clear');  
				url = base_url+'pengaturan/iku_kl/save/add';  
				
				$("#kode_iku_kl<?=$objectId?>").removeAttr('readonly');
			}
			//end newData
			
			download<?=$objectId;?>=function(){
				window.location=base_url+"download/format_excel_import/iku_kl.xls"
			}
			
			import<?=$objectId;?> = function (){  
				$('#dlgimport<?=$objectId;?>').dialog('open').dialog('setTitle','Import Indikator Kinerja Utama Kementerian');
				$('#fmimport<?=$objectId;?>').form('clear');  
				url = base_url+'pengaturan/iku_kl/import'; 
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
								title: 'Sukses',
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
				$("#filter_tahun<?=$objectId;?>").val('');	
				searchData<?=$objectId;?>();
			}
			//tipe 1=grid, 2=pdf, 3=excel
			getUrl<?=$objectId;?> = function (tipe){
				var file1 = $("#filter_e1<?=$objectId;?>").val();
				var filtahun = $("#filter_tahun<?=$objectId;?>").val();
				var filkey = $("#key<?=$objectId;?>").val();
				
				if (file1 == null) file1 = "-1";
				if (filtahun == null) filtahun = "-1";
				if (filkey == null) filkey = "-1";
				
				if (tipe==1){
					return "<?=base_url()?>pengaturan/iku_kl/grid/"+file1+"/"+filtahun+"/"+filkey;
				}
				else if (tipe==2){
					return "<?=base_url()?>pengaturan/iku_kl/pdf/"+file1+"/"+filtahun+"/"+filkey;
				}else if (tipe==3){
					return "<?=base_url()?>pengaturan/iku_kl/excel/"+file1+"/"+filtahun+"/"+filkey;
				}
				
			}

			searchData<?=$objectId;?> = function (){
				//ambil nilai-nilai filter
				$('#dg<?=$objectId;?>').datagrid({
					url:getUrl<?=$objectId;?>(1),
					queryParams:{lastNo:'0'},	
					pageNumber : 1,
					onLoadSuccess:function(data){	
						$('#dg<?=$objectId;?>').datagrid('options').queryParams.lastNo = data.lastNo;
						//prepareMerge<?=$objectId;?>(data);
				}});
			}
			//end searchData 
			
			printData<?=$objectId;?>=function(){			
				//$.jqURL.loc(getUrl<?=$objectId;?>(2),{w:800,h:600,wintype:"_blank"});
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
				
				if (row){
					$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Edit IKU Kementerian');
					$('#fm<?=$objectId;?>').form('load',row);
					url = base_url+'pengaturan/iku_kl/save/edit/'+row.kode_iku_kl+"/"+row.tahun;//+row.id;//'update_user.php?id='+row.id;
					$("#kode_kl<?=$objectId?>").val(row.kode_kl);
					//$("#kode_iku_kl<?=$objectId?>").attr("readonly","readonly");
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
							/* $.messager.show({
								title: 'Sucsees',
								msg: 'Data berhasil disimpan'
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
			
			deleteData<?=$objectId;?> = function (){
				var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
				if(row){
					if(confirm("Apakah yakin akan menghapus data '" + row.kode_iku_kl + "'?")){
						var response = '';
						$.ajax({ type: "GET",
								 url: base_url+'pengaturan/iku_kl/delete/' + row.tahun + '/' + row.kode_iku_kl,
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
			
			setTimeout(function(){
				searchData<?=$objectId;?> ();
				//$('#dg<?=$objectId;?>').datagrid({url:"<?=base_url()?>pengaturan/iku_kl/grid"});
			},0);
			
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
			
			//chan
			function setSasaranKL<?=$objectId;?>(tahun,key,val){
				if ((tahun==null)||(tahun=="")) tahun = "-1";
				$("#divSasaranKL<?=$objectId?>").load(
					base_url+"pengaturan/sasaran_eselon1/getListSasaranKL/"+"<?=$objectId;?>"+"/"+tahun,
					function(){
						$("textarea").autogrow();
						if($("#drop<?=$objectId;?>").is(":visible")){
							$("#drop<?=$objectId;?>").slideUp("slow");
						}
						
						$("#txtkode_sasaran_kl<?=$objectId;?>").click(function(){
							$("#drop<?=$objectId;?>").slideDown("slow");
						});
						
						$("#drop<?=$objectId;?> li").click(function(e){
							var chose = $(this).text();
							$("#txtkode_sasaran_kl<?=$objectId;?>").text(chose);
						//	alert($("#txtkode_sasaran_kl<?=$objectId;?>").text());
							$("#drop<?=$objectId;?>").slideUp("slow");
						});
						
						
						if (key!=null)
							$('#kode_sasaran_kl<?=$objectId;?>').val(key);
						
						if ((val!=null)&&(val!=""))
							$('#txtkode_sasaran_kl<?=$objectId;?>').val(val);
					}
				);
				//alert("here");
				
			}
			
			
			
			// inisialisasi 
			setSasaranKL<?=$objectId;?>($("#tahun<?=$objectId?>").val(),"","")
			
		 });
		 
		 function setSasaran<?=$objectId;?>(valu){
			//alert("here");
				document.getElementById('kode_sasaran_kl<?=$objectId;?>').value = valu;
				 setKodeOtomatis<?=$objectId?>();
			}
	</script>
	
	<script>
		<!--Enter-->
		function submitEnter<?=$objectId;?>(e) {
			if (e.keyCode == 13) {
				searchData<?=$objectId;?>();
			}
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
						<td><span id="divTahun<?=$objectId?>"></span></td>
				</tr>
				<!--request bos toto 2013.05.30
				<tr <=($this->session->userdata('unit_kerja_e1')=='-1'?'':'style="display:none"')?>>
					<td>Subsektor &nbsp</td>
					<td>
						<=$this->eselon1_model->getListFilterEselon1($objectId,$this->session->userdata('unit_kerja_e1'))?>
					</td>
				</tr> -->
				<tr>
					<td>Kata Kunci :</td>
					<td><input id="key<?=$objectId;?>" name="key<?=$objectId;?>" type="text" onkeypress="submitEnter<?=$objectId;?>(event)"/></td>
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
			<? if($this->sys_menu_model->cekAkses('ADD;',34,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="newData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-add" plain="true">Add</a>  
			<?}?>
			<!----------------Edit title-->
			<? if($this->sys_menu_model->cekAkses('EDIT;',34,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="editData<?=$objectId;?>(true);" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Edit</a>
			<?}?>
			<? if($this->sys_menu_model->cekAkses('VIEW;',34,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="editData<?=$objectId;?>(false);" class="easyui-linkbutton" iconCls="icon-view" plain="true">View</a>
			<?}?>
			<? if($this->sys_menu_model->cekAkses('DELETE;',34,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="deleteData<?=$objectId;?>(false);" class="easyui-linkbutton" iconCls="icon-remove" plain="true">Delete</a>
			<?}?>
			<? if($this->sys_menu_model->cekAkses('PRINT;',34,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="printData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
			<?}?>
			<? if($this->sys_menu_model->cekAkses('EXCEL;',34,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="toExcel<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-excel" plain="true">Excel</a>
			<?}?>
			<? if($this->sys_menu_model->cekAkses('IMPORT;',34,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="import<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-import" plain="true">Import</a>
			<?}?>
			<a href="#" onclick="download<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-download" plain="true">Download Format Excel</a>
		</div>
	</div>
	
	<table id="dg<?=$objectId;?>" class="easyui-datagrid" style="height:auto;width:auto" title="Data Indikator Kinerja Utama (IKU) Kementerian" toolbar="#tb<?=$objectId;?>" fitColumns="true" singleSelect="true" rownumbers="true" pagination="true"  nowrap="false">
		<thead>
		<tr>
			<th field="tahun" sortable="true" width="15px">Tahun</th>
			<!--<th field="kode_kl" sortable="true" width="20">Kode Kementerian</th>-->
			<th field="kode_kl" sortable="true" width="15" hidden="true">Kode KL</th>
			<th field="kode_iku_kl" sortable="true" width="30">Kode</th>
			<th field="deskripsi" sortable="true" width="140">Deskripsi IKU</th>
			<th field="satuan" sortable="true" width="35">Satuan</th>
			<th field="kode_e1" sortable="true" width="20" <?=($this->session->userdata('unit_kerja_e1')=='-1'?'hidden="true"':'hidden="true"')?>>Subsektor</th>
			<th field="nama_e1" sortable="true" hidden="true" >nama</th>
	  	</tr>
		</thead>  
	</table>

	<!-- Area untuk Form Add/Edit >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>  -->
	
	<div id="dlg<?=$objectId;?>" class="easyui-dialog" style="width:800px;height:400px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<!----------------Edit title-->
		<div id="ftitle<?=$objectId?>" class="ftitle">Add/Edit/View Data Indikator Kerja Unit (IKU) Kementerian</div>
		<form id="fm<?=$objectId;?>" method="post">
			<div class="fitem">
				<label style="width:120px">Tahun :</label>
				<input name="tahun" id="tahun<?=$objectId?>" class="easyui-validatebox" required="true" size="5" >
			</div>	
			<div class="fitem">
				<label style="width:120px;vertical-align:top">Kementerian :</label>
				<?=$this->kl_model->getListKL($objectId)?>
			</div>
			<div class="fitem">
				<label style="width:120px">Sasaran :</label>					
					<span id="divSasaranKL<?=$objectId?>">
				</span>
			</div>
			<div class="fitem">
				<label style="width:120px;vertical-align:top">Kode IKU :</label>
				<input name="kode_iku_kl" class="easyui-validatebox" size="20" required="true" id="kode_iku_kl<?=$objectId;?>">
			</div>
			<div class="fitem">
				<label style="width:120px;vertical-align:top">Deskripsi IKU :</label>
				<textarea name="deskripsi" cols="70" class="easyui-validatebox" ></textarea>
			</div>
			<div class="fitem">
				<label style="width:120px;vertical-align:top">Satuan :</label>
				<input name="satuan" size="60" class="easyui-validatebox">
			</div>
			<!-- request bos toto 2013.05.30
			<div class="fitem">
				<label style="width:120px;vertical-align:top">Subsektor :</label>
				
				<php
				$this->eselon1_model->getListEselon1($objectId,'','false');
				?>
				
			</div> -->
		</form>
		<div id="dlg-buttons">
			<!----------------Edit title-->
			<a href="#" id="saveBtn<?=$objectId;?>" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveData<?=$objectId;?>()">Save</a>
			<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg<?=$objectId;?>').dialog('close')">Cancel</a>
		</div>
	</div>

	
	<!-- FORM IMPORT -->
	<div id="dlgimport<?=$objectId;?>" class="easyui-dialog" style="width:500px;height:200px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<div class="ftitle">Import Data IKU dari Excel</div>
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
	
	<div class="popdesc" id="popdesc<?=$objectId?>">indriyanto</div>

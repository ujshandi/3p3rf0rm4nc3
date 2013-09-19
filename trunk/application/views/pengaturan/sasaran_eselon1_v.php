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
							$.messager.show({
								title: 'Success',
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
			//end saveData
			
			newData<?=$objectId;?> = function (){  
				//----------------Edit title
				$('#ftitle<?=$objectId;?>').html("Add Data "+"<?=$title?>");
				$('#saveBtn<?=$objectId;?>').css("display","");
				$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Add Sasaran Eselon I');
				$('#fm<?=$objectId;?>').form('clear');  
				initCombo<?=$objectId?>();
				url = base_url+'pengaturan/sasaran_eselon1/save/add'; 
				
				$("#kode_sasaran_e1<?=$objectId?>").removeAttr('readonly');
			}
			//end newData 
			
			editData<?=$objectId;?> = function (editmode){
				//----------------Edit title
				$('#ftitle<?=$objectId;?>').html((editmode?"Edit Data ":"View Data ")+"<?=$title?>");
				$('#saveBtn<?=$objectId;?>').css("display",(editmode)?"":"none");
				var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
				$('#fm<?=$objectId;?>').form('clear');  
				//initCombo();
				if (row){
					$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Edit Sasaran Eselon I');
					$('#fm<?=$objectId;?>').form('load',row);
					
					setSasaranKL<?=$objectId;?>($("#tahun<?=$objectId?>").val(),row.kode_sasaran_kl,row.deskripsi_sasaran_kl);
				
					/*  chan
					var response = '';
					$.ajax({ type: "GET",   
							 url: base_url+'pengaturan/sasaran_eselon1/getDeskripsiSasaran/' + row.kode_sasaran_e1,   
							 async: false,
							 success : function(text)
							 {
								 response = text;
								 initCombo();
							 }
					});
					
					$('#txtkode_sasaran_kl<?=$objectId;?>').val(response); */
					
					url = base_url+'pengaturan/sasaran_eselon1/save/edit/'+row.kode_sasaran_e1+"/"+row.tahun;//+row.id;//'update_user.php?id='+row.id;
					
					// $('#fm<?=$objectId;?> input').each(function(idx,elem) {
						// $(elem).attr({readonly:!editmode});
					// });
					
					//$("#kode_sasaran_e1<?=$objectId?>").attr("readonly","readonly");
				}
			}
			//end editData
			
			deleteData<?=$objectId;?> = function (){
				var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
				if(row){
					if(confirm("Apakah yakin akan menghapus data '" + row.kode_sasaran_e1 + "'?")){
						var response = '';
						$.ajax({ type: "GET",
								 url: base_url+'pengaturan/sasaran_eselon1/delete/' + row.tahun + '/' + row.kode_sasaran_e1,
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
		
		download<?=$objectId;?>=function(){
				window.location=base_url+"download/format_excel_import/sasaran_e1.xls"
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
								title: 'Success',
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
			
			import<?=$objectId;?> = function (){  
				$('#dlgimport<?=$objectId;?>').dialog('open').dialog('setTitle','Import Data Sasaran Eselon I');
				$('#fmimport<?=$objectId;?>').form('clear');  
				url = base_url+'pengaturan/sasaran_eselon1/import'; 
			}
			
			//tipe 1=grid, 2=pdf, 3=excel
			getUrl<?=$objectId;?> = function (tipe){
				<? if ($this->session->userdata('unit_kerja_e1')==-1){?>
					var file1 = $("#filter_e1<?=$objectId;?>").val();
				<?} else {?>
					var file1 = "<?=$this->session->userdata('unit_kerja_e1');?>";
				<?}?>
				var filtahun = $("#filter_tahun<?=$objectId;?>").val();
				var filkey = $("#key<?=$objectId;?>").val();
				if (filtahun == null) filtahun = "-1";
				if (filkey == null) filkey = "-1";
				if (file1 == null) file1 = "-1";
			
				if (tipe==1){
					return "<?=base_url()?>pengaturan/sasaran_eselon1/grid/"+file1+"/"+filtahun+"/"+filkey;
				}
				else if (tipe==2){
					return "<?=base_url()?>pengaturan/sasaran_eselon1/pdf/"+file1+"/"+filtahun+"/"+filkey;
				}else if (tipe==3){
					return "<?=base_url()?>pengaturan/sasaran_eselon1/excel/"+file1+"/"+filtahun+"/"+filkey;
				}
			}
			
			setKodeOtomatis<?=$objectId?> = function(){
				<? if ($this->session->userdata('unit_kerja_e1')==-1){?>
					var file1 = $("#kode_e1<?=$objectId;?>").val();
				<?} else {?>
					var file1 = "<?=$this->session->userdata('unit_kerja_e1');?>";
				<?}?>
				var filtahun = $("#tahun<?=$objectId;?>").val();
				
				if (file1 == null) file1 = "-1";
				if ((filtahun == null)||(filtahun == '')) filtahun = "-1";
				
				
				$.ajax({url:base_url+"pengaturan/sasaran_eselon1/getNewCode/"+file1+"/"+filtahun,
					success : function(data){
					$("#kode_sasaran_e1<?=$objectId?>").val(data);
					}					
					})
			}
			
			clearFilter<?=$objectId;?> = function (){
				//ambil nilai-nilai filter
				$("#filter_e1<?=$objectId;?>").val('');
				searchData<?=$objectId;?>();
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
			$("#kode_e1<?=$objectId?>").change(function(){
				//setSasaran<?=$objectId;?>($(this).val());
				 setKodeOtomatis<?=$objectId?>();
			});
			
			$("#tahun<?=$objectId;?>").change(function(){
				 setSasaranKL<?=$objectId;?>($(this).val(),"","");
				// setIKUKL<?=$objectId;?>($(this).val(),"","");
				  setKodeOtomatis<?=$objectId?>();
			});
			
			//inisilaisasi;
			//setSasaran<?=$objectId;?>($("#kode_e1<?=$objectId?>").val());
			  //inisialisasi
			 function initCombo<?=$objectId?>(){
				// setListE2<?=$objectId?>();
				 setSasaranKL<?=$objectId;?>($("#tahun<?=$objectId?>").val());
			 }
			
			//--------------------
			
			setTimeout(function(){
				searchData<?=$objectId;?> ();
				//$('#dg<?=$objectId;?>').datagrid({url:"<?=base_url()?>pengaturan/sasaran_eselon1/grid"});
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
						case "kode_sasaran_kl":
							showPopup('#popdesc<?=$objectId?>', row.deskripsi_sasaran_kl);
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
	
	<script>
		<!--Enter-->
		function submitEnter<?=$objectId;?>(e) {
			if (e.keyCode == 13) {
				searchData<?=$objectId;?>();
			}
		}
	</script>
	
	<!-- Dari Stef -->
	<script type="text/javascript">
		$(document).ready(function() {
		/* 	chan
		
		initCombo<?=$objectId?> = function(){
				if($("#drop<?=$objectId;?>").is(":visible")){
					$("#drop<?=$objectId;?>").slideUp("slow");
				}
			} 
			
			$("#txtkode_sasaran_kl<?=$objectId;?>").click(function(){
					$("#drop<?=$objectId;?>").slideDown("slow");
				});
				
				$("#drop<?=$objectId;?> li").click(function(e){
					var chose = $(this).text();
					$("#txtkode_sasaran_kl<?=$objectId;?>").val(chose);
				//	$("#drop<?=$objectId;?>").slideToggle("slow");
					$("#drop<?=$objectId;?>").slideUp("slow");
				});
			*/
		});
		
		function setSasaran<?=$objectId;?>(valu){
			//alert("here");
			document.getElementById('kode_sasaran_kl<?=$objectId;?>').value = valu;
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
					<td>Tahun</td>
					<td><?=$this->sasaran_eselon1_model->getListFilterTahun($objectId);?></span></td>
				</tr>
				<tr  <?=($this->session->userdata('unit_kerja_e1')=='-1'?'':'style="display:none"')?>>
					<td>Unit Kerja Eselon I&nbsp</td>
					<td>
						<?=$this->eselon1_model->getListFilterEselon1($objectId,$this->session->userdata('unit_kerja_e1'))?>
					</td>
				</tr>
				<tr>
					<td>Kata Kunci</td>
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
			<? if($this->sys_menu_model->cekAkses('ADD;',32,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="newData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-add" plain="true">Add</a>  
			<?}?>
			<!----------------Edit title-->
			<? if($this->sys_menu_model->cekAkses('EDIT;',32,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="editData<?=$objectId;?>(true);" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Edit</a>
			<?}?>
			<? if($this->sys_menu_model->cekAkses('VIEW;',32,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="editData<?=$objectId;?>(false);" class="easyui-linkbutton" iconCls="icon-view" plain="true">View</a>
			<?}?>
			<? if($this->sys_menu_model->cekAkses('DELETE;',32,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="deleteData<?=$objectId;?>(false);" class="easyui-linkbutton" iconCls="icon-remove" plain="true">Delete</a>
			<?}?>
			<? if($this->sys_menu_model->cekAkses('PRINT;',32,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a 	href="#" onclick="printData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
			<?}?>
			<? if($this->sys_menu_model->cekAkses('EXCEL;',32,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="toExcel<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-excel" plain="true">Excel</a>
			<?}?>
			
			<? if($this->sys_menu_model->cekAkses('IMPORT;',32,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="import<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-import" plain="true">Import</a>
			<?}?>
			<a href="#" onclick="download<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-download" plain="true">Download Format Excel</a>
		</div>
	</div>
	
	<table id="dg<?=$objectId;?>" class="easyui-datagrid" style="height:auto;width:auto" title="Data Sasaran Unit Kerja Eselon I" toolbar="#tb<?=$objectId;?>" fitColumns="true" singleSelect="true" rownumbers="true" pagination="true"  nowrap="false">
		<thead>
		<tr>
			<th field="kode_e1" sortable="true" width="20" <?=($this->session->userdata('unit_kerja_e1')=='-1'?'':'hidden="true"')?>>Kode Eselon I </th>
			<th field="nama_e1" sortable="true" hidden="true">nama Eselon I </th>
			<th field="tahun" sortable="true" width="15">Tahun</th>
			<th field="kode_sasaran_e1" sortable="true" width="25">Kode Sasaran</th>
			<th field="deskripsi" sortable="true" width="125">Deskripsi</th>
			<th field="kode_sasaran_kl" sortable="true" width="25">Kode Sasaran KL</th>		
			<th field="deskripsi_sasaran_kl" hidden="true"></th>		
		</tr>
		</thead>  
	</table>

	<!-- Area untuk Form Add/Edit >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>  -->
	
	<div id="dlg<?=$objectId;?>" class="easyui-dialog" style="width:800px;height:350px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<!----------------Edit title-->
		<div id="ftitle<?=$objectId?>" class="ftitle">Add/Edit/View Data Sasaran Unit Kerja Eselon I</div>
		<form id="fm<?=$objectId;?>" method="post">
			<div class="fitem">
				<label style="width:150px;vertical-align:top">Tahun</label>
				<input name="tahun" id="tahun<?=$objectId?>" class="easyui-validatebox" size="4" required="true">
			</div>		
			<div class="fitem" >
				<label style="width:150px">Unit Kerja Eselon I</label>
				<? //if ($this->session->userdata('unit_kerja_e1')=='-1'){
					$this->eselon1_model->getListEselon1($objectId);
				//} else { 
					//echo $this->eselon1_model->getNamaE1($this->session->userdata('unit_kerja_e1'));
					/* echo $this->session->userdata('unit_kerja_e1');
					$tmp ='tes';$this->session->userdata('unit_kerja_e1');
					echo '<input class="easyui-validatebox" type="text" id="kode_e1" name="kode_e1" size="10" required="true" value="tes">'; */
				 //} ?>
			</div>
			<div class="fitem">
				<label style="width:150px;vertical-align:top">Kode Sasaran :</label>
				<input name="kode_sasaran_e1" class="easyui-validatebox" size="10" required="true" id="kode_sasaran_e1<?=$objectId;?>">
			</div>
			<div class="fitem">
				<label style="width:150px;vertical-align:top">Deskripsi :</label>
				<textarea name="deskripsi" cols="70" class="easyui-validatebox" ></textarea>
			</div>
			<div class="fitem" >
				<label style="width:150px;vertical-align:top">Sasaran Kementerian :</label>
				<?//chan =$this->sasaran_kl_model->getListSasaranKL($objectId,"",false)?>
				<span id="divSasaranKL<?=$objectId?>">
				</span>
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
	
	<div class="popdesc" id="popdesc<?=$objectId?>">indriyanto</div>

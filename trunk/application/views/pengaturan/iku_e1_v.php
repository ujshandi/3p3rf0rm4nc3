	<script  type="text/javascript" >
		$(function(){
			var _changekode = false;
			$('textarea').autosize();   
			loadTahun<?=$objectId;?> = function (){
				$('#divTahun<?=$objectId;?>').load(
					base_url+"pengaturan/iku_e1/getListTahun/"+"<?=$objectId;?>"
				);
			}
			
			loadTahun<?=$objectId;?>();
			
			setKodeOtomatis<?=$objectId?> = function(){
				if (!_changekode) return;
				<? if ($this->session->userdata('unit_kerja_e1')==-1){?>
					var file1 = $("#kode_e1<?=$objectId;?>").val();
				<?} else {?>
					var file1 = "<?=$this->session->userdata('unit_kerja_e1');?>";
				<?}?>
				var filtahun = $("#tahun<?=$objectId;?>").val();
				var kodesasaran = $("#kode_sasaran_e1ListSasaran<?=$objectId;?>").val();				
				if ((kodesasaran == null)||(kodesasaran == '')) kodesasaran = "-1";
				if (file1 == null) file1 = "-1";
				if ((filtahun == null)||(filtahun == '')) filtahun = "-1";
				$.ajax({url:base_url+"pengaturan/iku_e1/getNewCode/"+file1+"/"+filtahun+"/"+kodesasaran,
					success : function(data){
					$("#kode_iku_e1<?=$objectId?>").val(data);
					}					
					})
				
			}
						
			function setIKUKL<?=$objectId;?>(tahun,key,val){
				if ((tahun==null)||(tahun=="")) tahun = "-1";
				$("#divIKUKL<?=$objectId?>").load(
					base_url+"pengaturan/iku_e1/getListIKU_KL/"+"<?=$objectId;?>"+"/"+tahun,
					//on complete
					function(){
						$('textarea').autosize();   
						if($("#drop<?=$objectId;?>").is(":visible")){
							$("#drop<?=$objectId;?>").slideUp("slow");
						}
						
						$("#txtkode_iku_kl<?=$objectId;?>").click(function(){
							$("#drop<?=$objectId;?>").slideDown("slow");
						});
						
						$("#drop<?=$objectId;?> li").click(function(e){
							var chose = $(this).text();
							$("#txtkode_iku_kl<?=$objectId;?>").val(chose);
							$("#drop<?=$objectId;?>").slideUp("slow");
						});
						
						if (key!=null)
							$('#kode_iku_kl<?=$objectId;?>').val(key);
						if ((val!=null) &&  (key!=null))
							$('#txtkode_iku_kl<?=$objectId;?>').val('['+key+'] '+val);
					}
				);
			}  
			
			$("#tahun<?=$objectId;?>").change(function(){
				//alert($(this).val());
				setSasaranE1<?=$objectId;?>($(this).val(),$("#kode_e1<?=$objectId?>").val(),'','')
				 setIKUKL<?=$objectId;?>($(this).val(),"","");
				  setKodeOtomatis<?=$objectId?>();
			});
			
			function setListE2<?=$objectId?>(value){
				$("#divEselon2<?=$objectId?>").load(
					base_url+"rujukan/eselon2/loadE2/"+$("#kode_e1<?=$objectId?>").val()+"/<?=$objectId;?>",
					//on complete
					function (){
						
						//$('#kode_e2<?=$objectId;?>').val(value);
						//setSasaranE2<?=$objectId?>($("#kode_e2<?=$objectId?>").val());
						// $("#kode_e2<?=$objectId?>").change(function(){
							// filterSasaranE2<?=$objectId?>($(this).val());
						// });	
						// filterSasaranE2<?=$objectId?>($("#kode_e2<?=$objectId?>").val());
					}
				);
			}
			
			function kodeE1Change<?=$objectId?>(editmode){
				setListE2<?=$objectId?>();
				setSasaranE1<?=$objectId;?>($("#tahun<?=$objectId?>").val(),$("#kode_e1<?=$objectId?>").val(),"");
				setIKUKL<?=$objectId;?>($("#tahun<?=$objectId?>").val(),"","");
				if (!editmode)
				 setKodeOtomatis<?=$objectId?>();
			}
			
			$("#kode_e1<?=$objectId?>").change(function(){
				kodeE1Change<?=$objectId?>(true);
			});
			
			
			  //inisialisasi
			 function initCombo<?=$objectId?>(){
				 setListE2<?=$objectId?>();
				 setSasaranE1<?=$objectId;?>($("#tahun<?=$objectId?>").val(),"","");
				 setIKUKL<?=$objectId;?>($("#tahun<?=$objectId?>").val(),"","");
			 }
			
			
			var url;
			newData<?=$objectId;?> = function (){  
				_changekode = true;
				//----------------Edit title
				$('#ftitle<?=$objectId;?>').html("Add Data "+"<?=$title?>");
				$('#saveBtn<?=$objectId;?>').css("display","");
				$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Add IKU Eselon I');  
				$('#fm<?=$objectId;?>').form('clear');  
				initCombo<?=$objectId?>();
				url = base_url+'pengaturan/iku_e1/save/add';  
				
				$("#kode_iku_e1<?=$objectId?>").removeAttr('readonly');
			}
			//end newData 

			download<?=$objectId;?>=function(){
				window.location=base_url+"download/format_excel_import/iku_e1.xls"
			}
				
			import<?=$objectId;?> = function (){  
				$('#dlgimport<?=$objectId;?>').dialog('open').dialog('setTitle','Import Indikator Kinerja Utama Eselon I');
				$('#fmimport<?=$objectId;?>').form('clear');  
				url = base_url+'pengaturan/iku_e1/import'; 
			}
			
			copyData<?=$objectId;?> = function (){
				addTab("Copy IKU Eselon I", "pengaturan/iku_e1/copy");
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
				
				//$('#dg<?=$objectId;?>').datagrid({url:"<?=base_url()?>pengaturan/iku/grid/"+filnip+"/"+filnama+"/"+filalamat});
			}
			//tipe 1=grid, 2=pdf, 3=excel
			getUrl<?=$objectId;?> = function (tipe){
				<? if ($this->session->userdata('unit_kerja_e1')==-1){?>
					var file1 = $("#filter_e1<?=$objectId;?>").val();
				<?} else {?>
					var file1 = "<?=$this->session->userdata('unit_kerja_e1');?>";
				<?}?>
				var filtahun = $("#filter_tahun<?=$objectId;?>").val();
				var filkey = '-1';//$("#key<?=$objectId;?>").val();
				
				if (file1 == null) file1 = "-1";
				if (filtahun == null) filtahun = "-1";
				if (filkey == null) filkey = "-1";
				
				if (tipe==1){
					return "<?=base_url()?>pengaturan/iku_e1/grid/"+file1+"/"+filtahun+"/"+filkey;
				}
				else if (tipe==2){
					return "<?=base_url()?>pengaturan/iku_e1/pdf/"+file1+"/"+filtahun+"/"+filkey;
				}else if (tipe==3){
					return "<?=base_url()?>pengaturan/iku_e1/excel/"+file1+"/"+filtahun+"/"+filkey;
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
						if (row==null) return;	
						switch(field){
							case "kode_e1":
								showPopup('#popdesc<?=$objectId?>', row.nama_e1);
								break;
							case "kode_iku_kl":
								showPopup('#popdesc<?=$objectId?>', row.kl_deskripsi);
								break;
							case "kode_sasaran_e1":
								showPopup('#popdesc<?=$objectId?>', row.deskripsi_sasaran_e1);
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
				//$.jqURL.loc(getUrl<?=$objectId;?>(2),{w:800,h:600,wintype:"_blank"});
				window.open(getUrl<?=$objectId;?>(2));;
			}
			toExcel<?=$objectId;?>=function(){
				
				window.open(getUrl<?=$objectId;?>(3));;
			}
			
			editData<?=$objectId;?> = function (editmode){
				_changekode = false;
				//----------------Edit title
				$('#ftitle<?=$objectId;?>').html((editmode?"Edit Data ":"View Data ")+"<?=$title?>");
				$('#saveBtn<?=$objectId;?>').css("display",(editmode)?"":"none");
				var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
				$('#fm<?=$objectId;?>').form('clear');  

				if (row){
					$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Edit IKU Eselon I');
					$('#fm<?=$objectId;?>').form('load',row);
					//initCombo<?=$objectId?>();
					setTimeout(function(){
						setSasaranE1<?=$objectId?>($("#tahun<?=$objectId?>").val(),$("#kode_e1<?=$objectId?>").val(),row.kode_sasaran_e1,row.deskripsi_sasaran_e1);
						setIKUKL<?=$objectId;?>($("#tahun<?=$objectId?>").val(),row.kode_iku_kl,row.deskripsi_ikukl);
						//setListE2<?=$objectId?>(row.kode_e2);
						//kodeE1Change<?=$objectId?>(true);
					},1000);
				//	
					/* // ajax
					var response = '';
					$.ajax({ type: "GET",   
							 url: base_url+'pengaturan/iku_e1/getDeskripsiIKU/' + row.kode_iku_kl,   
							 async: false,
							 success : function(text)
							 {
								 response = text;
							 }
					});
					
					$('#txtkode_iku_kl<?=$objectId;?>').val(response); */
					
					url = base_url+'pengaturan/iku_e1/save/edit/'+row.kode_iku_e1+"/"+row.tahun;//+row.id;//'update_user.php?id='+row.id;
					//alert(row.kode_e2);
					
					//$("#kode_iku_e1<?=$objectId?>").attr("readonly","readonly");
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
			
			deleteData<?=$objectId;?> = function (){
				var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
				if(row){
					if(confirm("Apakah yakin akan menghapus data '" + row.kode_iku_e1 + "'?")){
						var response = '';
						$.ajax({ type: "GET",
								 url: base_url+'pengaturan/iku_e1/delete/' + row.tahun + '/' + row.kode_iku_e1,
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
				//$('#dg<?=$objectId;?>').datagrid({url:"<?=base_url()?>pengaturan/iku_e1/grid"});
			},50);
			
		
			
			$("#popdesc<?=$objectId?>").click(function(){
				closePopup('#popdesc<?=$objectId?>');
			});
			
			submitEnter<?=$objectId;?> = function (e) {
				if (e.keyCode == 13) {
					searchData<?=$objectId;?>();
				}
			}			
			//chan
			function setSasaranE1<?=$objectId;?>(tahun,e1,key,val){
				<? if ($this->session->userdata('unit_kerja_e1')!='-1') {?>
				 e1 = '<?=$this->session->userdata('unit_kerja_e1');?>';
				 $("#kode_e1<?=$objectId;?>").val(e1);
				<?}?>
				if (tahun=="") tahun = "-1";
				 $("#divSasaranE1<?=$objectId?>").load(
					base_url+"pengaturan/sasaran_eselon2/getListSasaranE1/ListSasaran"+"<?=$objectId;?>"+"/"+e1+"/"+tahun,
					function(){
						$('textarea').autosize();   
						
						$("#txtkode_sasaran_e1ListSasaran<?=$objectId;?>").click(function(){
							$("#dropListSasaran<?=$objectId;?>").slideDown("slow");
						});
						
						$("#dropListSasaran<?=$objectId;?> li").click(function(e){
							var chose = $(this).text();
							$("#txtkode_sasaran_e1ListSasaran<?=$objectId;?>").val(chose);
							$("#dropListSasaran<?=$objectId;?>").slideUp("slow");
						});
						
						if (key!=null)
							$('#kode_sasaran_e1ListSasaran<?=$objectId;?>').val(key);
						if ((val!=null) &&  (key!=null))
							$('#txtkode_sasaran_e1ListSasaran<?=$objectId;?>').val('['+key+'] '+val);
					}
				); 
				//alert("here");
				
			}
			
		 });
	</script>
	
	
	<!-- Dari Stef -->
	<script type="text/javascript">
		$(document).ready(function() {
			/* initCombo = function(){
				if($("#drop<?=$objectId;?>").is(":visible")){
					$("#drop<?=$objectId;?>").slideUp("slow");
				}
				
				$("#txtkode_iku_kl<?=$objectId;?>").click(function(){
					$("#drop<?=$objectId;?>").slideDown("slow");
				});
				
				$("#drop<?=$objectId;?> li").click(function(e){
					var chose = $(this).text();
					$("#txtkode_iku_kl<?=$objectId;?>").val(chose);
					//$("#drop<?=$objectId;?>").slideToggle("slow");
					$("#drop<?=$objectId;?>").slideUp("slow");
				});
			} */
			
		});
		
		function setIku<?=$objectId;?>(valu){
			document.getElementById('kode_iku_kl<?=$objectId;?>').value = valu;
		}
		
		 function setSasaranListSasaran<?=$objectId;?>(valu){
			//alert("here");
				document.getElementById('kode_sasaran_e1ListSasaran<?=$objectId;?>').value = valu;
				 setKodeOtomatis<?=$objectId?>();
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
		  <div class="fsearch" >
			
			<table border="0" cellpadding="1" cellspacing="1">
			<tr>
					<td>Tahun :&nbsp;</td>
					<td><span id="divTahun<?=$objectId?>"></span></td>
				</tr>
			<tr <?=($this->session->userdata('unit_kerja_e1')=='-1'?'':'style="display:none"')?>>
				<td>Unit Kerja Eselon I :&nbsp;</td>
				<td>
					<?=$this->eselon1_model->getListFilterEselon1($objectId,$this->session->userdata('unit_kerja_e1'))?>
				</td>
			</tr>
			<!--<tr>
				<td>Kata Kunci :</td>
				<td><input id="key<?=$objectId;?>" name="key<?=$objectId;?>" type="text" onkeypress="submitEnter<?=$objectId;?>(event)"/></td>
			</tr>-->
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
		<? if($this->sys_menu_model->cekAkses('ADD;',35,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="newData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-add" plain="true">Add</a>  
		<?}?>
		<!----------------Edit title-->
		<? if($this->sys_menu_model->cekAkses('EDIT;',35,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="editData<?=$objectId;?>(true);" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Edit</a>
		<?}?>
		<!--<? if($this->sys_menu_model->cekAkses('VIEW;',35,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="editData<?=$objectId;?>(false);" class="easyui-linkbutton" iconCls="icon-view" plain="true">View</a>
		<?}?> -->
		<? if($this->sys_menu_model->cekAkses('DELETE;',35,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="deleteData<?=$objectId;?>(false);" class="easyui-linkbutton" iconCls="icon-remove" plain="true">Delete</a>
		<?}?>
		<? if($this->sys_menu_model->cekAkses('PRINT;',35,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="printData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
		<?}?>
		<? if($this->sys_menu_model->cekAkses('EXCEL;',35,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="toExcel<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-excel" plain="true">Excel</a>
		<?}?>
		<? if($this->sys_menu_model->cekAkses('IMPORT;',35,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="import<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-import" plain="true">Import</a>
		<?}?>
		<? if($this->sys_menu_model->cekAkses('COPY;',35,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="copyData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-copy" plain="true">Copy</a>
		<?}?>
		<!--<a href="#" onclick="download<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-download" plain="true">Download Format Excel</a> -->
	  </div>
	</div>
	
	<table id="dg<?=$objectId;?>" style="height:auto;width:auto" title="Data Indikator Kinerja Utama (IKU) Eselon I" toolbar="#tb<?=$objectId;?>" fitColumns="true" singleSelect="true" rownumbers="true" pagination="true"  nowrap="false">
	  <thead>
	  <tr>
		<th field="tahun" sortable="true" width="15px">Tahun</th>
		<th field="kode_e1" sortable="true" width="30"  <?=($this->session->userdata('unit_kerja_e1')=='-1'?'':'hidden="true"')?>>Kode Eselon I</th>
		<th field="nama_e1" sortable="true" hidden="true" >Nama</th>
		<th field="kode_sasaran_e1" sortable="true" width="35">Sasaran Eselon I</th>	
		<!--<th field="kode_e2" sortable="true" width="30"  hidden="true">Kode Eselon II</th> -->
		<th field="kode_iku_e1" sortable="true" width="35">Kode IKU</th>
		<th field="deskripsi" sortable="true" width="125">Deskripsi IKU</th>
		<th field="satuan" sortable="true" width="20">Satuan</th>	
		<th field="kode_iku_kl" sortable="true" width="20">Kode IKU KL</th>	
		<th field="kl_deskripsi" sortable="true" hidden="true">Kode IKU KL</th>	
		
		<th field="deskripsi_sasaran_e1" sortable="true" hidden="true">kode sasaran e1</th>	
		
	  </tr>
	  </thead>  
	</table>

	 <!-- AREA untuk Form Add/EDIT >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>  -->
	
	<div id="dlg<?=$objectId;?>" class="easyui-dialog" style="width:800px;height:500px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<!----------------Edit title-->
		<div id="ftitle<?=$objectId?>" class="ftitle">Add/Edit/View Data Indikator Kinerja Utama (IKU) Eselon I</div>
		<form id="fm<?=$objectId;?>" method="post">
			<div class="fitem">
				<label style="width:120px">Tahun :</label>
				<input name="tahun" id="tahun<?=$objectId;?>" class="easyui-validatebox year" required="true" size="5" >
			</div>	
			<div class="fitem">
				<label style="width:120px;vertical-align:top">Unit Kerja Eselon I :</label>
				<?// if ($this->session->userdata('unit_kerja_e1')=='-1'){
					$this->eselon1_model->getListEselon1($objectId);
				//} else {
					//echo $this->eselon1_model->getNamaE1($this->session->userdata('unit_kerja_e1'));
				//} ?>
			</div>
			
			<div class="fitem">
				<label style="width:120px">Sasaran Eselon I:</label>					
					<span id="divSasaranE1<?=$objectId?>">
				</span>
			</div>
			<div class="fitem">
				<label style="width:120px;vertical-align:top">Kode IKU :</label>
				<input name="kode_iku_e1" class="easyui-validatebox" size="20" required="true" id="kode_iku_e1<?=$objectId;?>">
			</div>
			<div class="fitem">
				<label style="width:120px;vertical-align:top">Deskripsi IKU :</label>
				<textarea name="deskripsi" cols="70" class="easyui-validatebox" ></textarea>
			</div>
			<div class="fitem">
				<label style="width:120px;vertical-align:top">Satuan :</label>
				<input name="satuan" size="60" class="easyui-validatebox">
			</div>
			
			<div class="fitem">
				<label style="width:120px;vertical-align:top">IKU Kementerian :</label>
				<?//=$this->iku_kl_model->getListIKU_KL($objectId,"",false)?>
				<span id="divIKUKL<?=$objectId?>">
				</span>
			</div>
			<!--request bos toto 2013.05.30
			<div class="fitem">							
				<label style="width:120px;vertical-align:top">Bidang :</label>
				<span id="divEselon2<=$objectId?>"></span>
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
	
	<div class="popdesc" id="popdesc<?=$objectId?>">&nbsp;</div>

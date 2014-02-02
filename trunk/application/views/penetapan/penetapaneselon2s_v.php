	<script  type="text/javascript" >
		$(function(){
			var url;
			newData<?=$objectId;?> = function (){  
				//$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','New Penetapan Kinerja Eselon 2');  
				//$('#fm<?=$objectId;?>').form('clear');  
				//url = base_url+'penetapan/kegiatankl/save';  
				addTab("Add PK Eselon II","penetapan/penetapaneselon2/add");
			}
			//end newData 
			
			
			clearFilter<?=$objectId;?> = function (){
				//ambil nilai-nilai filter
				$("#filter_tahun<?=$objectId;?>").val('');
				$("#filter_e1<?=$objectId;?>").val('');	
				$("#filter_e2<?=$objectId;?>").val('');	
				searchData<?=$objectId;?>();
			}
			
			//tipe 1=grid, 2=pdf, 3=excel
			getUrl<?=$objectId;?> = function (tipe){
				var filtahun = $("#filter_tahun<?=$objectId;?>").val();
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
				if (filtahun == null) filtahun = "-1";
				if (file1 == null) file1 = "-1";
				if (file2 == null) file2 = "-1";
			
				if (tipe==1){
					return "<?=base_url()?>penetapan/penetapaneselon2/grid/"+filtahun+"/"+file1+"/"+file2;
				}
				else if (tipe==2){
					return "<?=base_url()?>penetapan/penetapaneselon2/pdf/"+filtahun+"/"+file1+"/"+file2;
				}else if (tipe==3){
					return "<?=base_url()?>penetapan/penetapaneselon2/excel/"+filtahun+"/"+file1+"/"+file2;
				}
			}
			
			searchData<?=$objectId;?> = function (){
				//ambil nilai-nilai filter
				
				
				$('#dg<?=$objectId;?>').datagrid({
					url:getUrl<?=$objectId;?>(1),
					onClickCell: function(rowIndex, field, value){
							$('#dg<?=$objectId;?>').datagrid('selectRow', rowIndex);
							var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
							if (row==null) return;
							//alert(row.deskripsi_iku_kl);
							switch(field){
								case "kode_e2":
									showPopup('#popdesc<?=$objectId?>', row.nama_e2);
									break;
								case "kode_sasaran_e2":
									showPopup('#popdesc<?=$objectId?>', row.deskripsi_sasaran_e2);
									break;
								case "kode_ikk":
									showPopup('#popdesc<?=$objectId?>', row.deskripsi_iku_e2);
									break;
								 case "kode_e2":
									showPopup('#popdesc<?=$objectId?>', row.nama_e2);
									break; 
								default:
									closePopup('#popdesc<?=$objectId?>');
									break;
							}
						}
					});
			}
			//end searhData 
			
			editData<?=$objectId;?> = function (editmode){
				var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
				
				if (row){
					addTab((editmode?"Edit":"View")+" PK Eselon II", "penetapan/penetapaneselon2/edit/"+row.id_pk_e2+ "/" + editmode);
				}
			}
			//end editData
			
			deleteData<?=$objectId;?> = function (){
				<? if ($this->session->userdata('unit_kerja_e1')=='-1'){?>				
					var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
					if(row){
						if(confirm("Apakah yakin akan menghapus data '" + row.kode_ikk + "'?")){
							var response = '';
							$.ajax({ type: "GET",
									 url: base_url+'penetapan/penetapaneselon2/delete/' + row.id_pk_e2,
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
				<?} else { ?>	
					alert("Silahkan Login sebagai Superadmin");
				<?} ?>
			}
			//end deleteData 
		
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
								title: 'Success',
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
			
			formatPrice=function(val,row){
				return val;
				/* ($.fn.autoNumeric.Format("txtAmount"+idx,total,{aSep:".",aDec:",",mDec:2}));
				if (val < 20){
					return '<span style="color:red;">('+val+')</span>';
				}else {
					return val;
				} */
			}
			
			$("#filter_e1<?=$objectId;?>").change(function(){
				$("#divUnitKerja<?=$objectId;?>").load(base_url+"rujukan/eselon2/loadFilterE2/"+$(this).val()+"/<?=$objectId;?>");
			
			});
			setTimeout(function(){
				searchData<?=$objectId;?>();
				//$('#dg<?=$objectId;?>').datagrid({url:"<?=base_url()?>penetapan/penetapaneselon2/grid"});
			},50);
			
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
			<div class="fsearch" >
				<table border="0" cellpadding="1" cellspacing="1">
					<tr>
						<td>Tahun :</td>
						<td>
						<?=$this->penetapaneselon2_model->getListFilterTahun($objectId)?>
						</td>
					</tr>
					<? //if ($this->session->userdata('unit_kerja_e1')==-1){?>
					<tr>
						<td>Unit Kerja Eselon I :&nbsp;</td>
						<td>
							<?=$this->eselon1_model->getListFilterEselon1($objectId,$this->session->userdata('unit_kerja_e1'))?>
						</td>
					</tr>
					<?//}?>
					<tr>
						<td>Unit Kerja Eselon II :&nbsp;</td>
						<td><span class="fitem" id="divUnitKerja<?=$objectId;?>">
							<?=$this->eselon2_model->getListFilterEselon2($objectId,$this->session->userdata('unit_kerja_e1'),$this->session->userdata('unit_kerja_e2'))?>
						</span></td>
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
			<? if($this->sys_menu_model->cekAkses('ADD;',110,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="newData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-add" plain="true">Add</a>  
			<?}?>
			<!------------Edit View-->
			<? if($this->sys_menu_model->cekAkses('EDIT;',110,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="editData<?=$objectId;?>(true);" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Edit</a>
			<?}?>
			<? if($this->sys_menu_model->cekAkses('VIEW;',110,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="editData<?=$objectId;?>(false);" class="easyui-linkbutton" iconCls="icon-view" plain="true">View</a>
			<?}?>
			<? if($this->sys_menu_model->cekAkses('DELETE;',110,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="deleteData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-remove" plain="true">Delete</a>
			<?}?>
			<!--
			<a href="#" onclick="printData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
			<a href="#" onclick="toExcel<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-excel" plain="true">Excel</a>
			-->
		</div>
	</div>
	
	<table id="dg<?=$objectId;?>" class="easyui-datagrid" style="height:auto;width:auto" title="Data Penetapan Kinerja (PK) Eselon II" toolbar="#tb<?=$objectId;?>" fitColumns="true" singleSelect="true" rownumbers="true" pagination="true">
		<thead>
		<tr>
			<th field="id_pk_e2" sortable="true" hidden="true" width="30">id_pk_e2</th>		
			<th field="tahun" sortable="true" width="30">Tahun</th>
			<th field="kode_e2" sortable="true" width="50px" <?=($this->session->userdata('unit_kerja_e2')=='-1'?'':'hidden="true"')?>>Kode Unit Kerja</th>
			<th field="nama_e2" hidden="true" ></th>
			<th field="kode_sasaran_e2" sortable="true" width="50px">Kode Sasaran</th>
			<th field="kode_ikk" sortable="true" width="50px">Kode IKK</th>
			<th field="target" sortable="true" width="50px" align="right" formatter="formatPrice">Target (RKT)</th>
			<th field="penetapan" sortable="true" width="50px" align="right" formatter="formatPrice">Target (PK)</th>
			<th field="satuan" sortable="true" width="50px">Satuan</th>
		</tr>
		</thead>  
	</table>
	<div class="popdesc" id="popdesc<?=$objectId?>">pops</div>
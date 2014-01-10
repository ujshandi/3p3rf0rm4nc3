	<script  type="text/javascript" >
		$(function(){
			var url;
			newData<?=$objectId;?> = function (){  
				//$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','New rskl');  
				//$('#fm<?=$objectId;?>').form('clear');  
				//url = base_url+'realisasi/rskl/save';  
				
				addTab("Add Capaian Kinerja Kementerian", "realisasi/rskl/add");
			}
			//end newData 
			
			editData<?=$objectId;?> = function (editmode){
				<? //chan if ($this->session->userdata('unit_kerja_e1')=='-1'){?>				
					var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
					if (row==null) return;
					addTab((editmode?"Edit":"View")+" Capaian Kinerja Kementerian", "realisasi/rskl/edit/"+ row.id_kinerja_kl + "/" + editmode);
				<?//} else { ?>	
					//alert("Silahkan Login sebagai Superadmin");
				<?//} ?>
			}
			//end editData
			
			deleteData<?=$objectId;?> = function (){
				<? if ($this->session->userdata('unit_kerja_e1')=='-1'){?>				
					var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
					if(row){
						if(confirm("Apakah yakin akan menghapus data '" + row.kode_iku_kl + "'?")){
							var response = '';
							$.ajax({ type: "GET",
									 url: base_url+'realisasi/rskl/delete/' + row.id_kinerja_kl,
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
			
			clearFilter<?=$objectId;?> = function (){
				//ambil nilai-nilai filter
				$("#filter_nip").val('');
				$("#filter_nama").val('');
				$("#filter_alamat").val('');
				$("#filter_tahun<?=$objectId;?>").val('-1');
				searchData<?=$objectId;?>();
				
				
				//$('#dg<?=$objectId;?>').datagrid({url:"<?=base_url()?>realisasi/rskl/grid/"+filnip+"/"+filnama+"/"+filalamat});
			}
			
			//tipe 1=grid, 2=pdf, 3=excel
			getUrl<?=$objectId;?> = function (tipe){
				if (tipe==1){
					return "<?=base_url()?>realisasi/rskl/grid/";
				}
				else if (tipe==2){
					return "<?=base_url()?>realisasi/rskl/pdf/";
				}else if (tipe==3){
					return "<?=base_url()?>realisasi/rskl/excel/";
				}
				
			}
			
			searchData<?=$objectId;?> = function (){
				//ambil nilai-nilai filter
				var filtahun = $("#filter_tahun<?=$objectId;?>").val();
				var filbulan = $("#filbulan<?=$objectId;?>").val();
				
				/*var filnip = $("#filter_nip").val();
				var filnama = $("#filter_nama").val();
				var filalamat = $("#filter_alamat").val();
				
				//encode parameter
				if(filnip.length==0) filnip ="6E756C6C";
				else filnip = DoAsciiHex(filnip,"A2H");
								
				if(filnama.length==0) filnama ="6E756C6C";
				else filnama = DoAsciiHex(filnama,"A2H");
				if(filalamat.length==0) filalamat ="6E756C6C";
				else filalamat = DoAsciiHex(filalamat,"A2H");
				*/
				
				$('#dg<?=$objectId;?>').datagrid({
					url:"<?=base_url()?>realisasi/rskl/grid/"+filtahun+"/"+filbulan,
					onClickCell: function(rowIndex, field, value){
						$('#dg<?=$objectId;?>').datagrid('selectRow', rowIndex);
						var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
						if (row==null) return;
						//alert(row.deskripsi_iku_kl);
						switch(field){
							case "kode_kl":
								showPopup('#popdesc<?=$objectId?>', row.nama_kl);
								break;
							case "kode_sasaran_kl":
								showPopup('#popdesc<?=$objectId?>', row.deskripsi_sasaran_kl);
								break;
							case "kode_iku_kl":
								showPopup('#popdesc<?=$objectId?>', row.deskripsi_iku_kl);
								break;
							/* case "kode_kl":
								showPopup('#popdesc<?=$objectId?>', row.nama_kl);
								break; */
							default:
								closePopup('#popdesc<?=$objectId?>');
								break;
						}
					}
				});
			}
			//end searhData 
			
			printData<?=$objectId;?>=function(){			
				//$.jqURL.loc(getUrl<?=$objectId;?>(2),{w:800,h:600,wintype:"_blank"});
			//window.open(getUrl<?=$objectId;?>(2));;
			alert("Sedang dalam pengerjaan");
		}
			toExcel<?=$objectId;?>=function(){
				alert("Sedang dalam pengerjaan");	
				//window.open(getUrl<?=$objectId;?>(3));;
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
			
			formatPrice=function (val,row){
				return val;//($.fn.autoNumeric.Format("txtAmount"+idx,total,{aSep:".",aDec:",",mDec:2}));
				/* if (val < 20){
					return '<span style="color:red;">('+val+')</span>';
				} else {
					return val;
				} */
			}

			
			setTimeout(function(){
				searchData<?=$objectId;?>();
				//$('#dg<?=$objectId;?>').datagrid({url:"<?=base_url()?>realisasi/rskl/grid"});
			},50);
			
			// chan
			$('#dg<?=$objectId;?>').datagrid({
				
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
		  <div class="fsearch">
			<table border="0" cellpadding="1" cellspacing="1">
			<tr style="margin-bottom: 10px;">
				<td width="70px">Tahun :</td>
				<td align="left">
					<?=$this->rskl_model->getListFilterTahun($objectId)?>
				</td>
			</tr>
			<tr style="margin-bottom: 10px;">
				<td width="70px">Bulan :</td>
				<td align="left">
			  <?= $this->utility->getBulan("","filbulan",true,$objectId)?>
				</td>
			</tr>
			<tr style="height:10px">
				  <td style="">
				  </td>
			</tr>
			<tr>
				<td align="right" colspan="2" valign="top">
					<a href="#" class="easyui-linkbutton" onclick="clearFilter<?=$objectId;?>();" iconCls="icon-reset">Reset</a>
					<a href="#" class="easyui-linkbutton" onclick="searchData<?=$objectId;?>();" iconCls="icon-search">Search</a>
				</td>
			</tr>
			</table>
			<table border="0" cellpadding="1" cellspacing="1" style="display:none">
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
		<? if($this->sys_menu_model->cekAkses('ADD;',151,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="newData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-add" plain="true">Add</a>  
		<?}?>
		<!------------Edit View-->
		<? if($this->sys_menu_model->cekAkses('EDIT;',151,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="editData<?=$objectId;?>(true);" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Edit</a>
		<?}?>
		<? if($this->sys_menu_model->cekAkses('VIEW;',151,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="editData<?=$objectId;?>(false);" class="easyui-linkbutton" iconCls="icon-view" plain="true">View</a>
		<?}?>
		<? if($this->sys_menu_model->cekAkses('DELETE;',151,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="deleteData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-remove" plain="true">Delete</a>
		<?}?>
		<!--
		<a href="#" onclick="printData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
		<a href="#" onclick="toExcel<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-excel" plain="true">Excel</a>
		-->
	  </div>
	</div>
	
	<table id="dg<?=$objectId;?>" style="height:auto;width:auto" title="Data Capaian Kinerja Kementerian" toolbar="#tb<?=$objectId;?>" fitColumns="true"  nowrap="false" singleSelect="true" rownumbers="true" pagination="true">
	  <thead>
	  <tr>
		<th field="id_kinerja_kl" sortable="true" hidden="true" width="30px">id_kinerja_kl</th>
		<th field="tahun" sortable="true" width="23px">Tahun</th>
		<th field="triwulan" sortable="true" width="37px">Bulan</th>
		<th field="kode_kl" sortable="true" width="65px">Kode Kementerian</th>
		<th field="nama_kl" hidden="true">Nama Kementerian</th>
		<th field="kode_sasaran_kl" sortable="true" width="50px">Kode Sasaran</th>
		<th field="deskripsi_sasaran_kl" hidden="true">Des Sasaran</th>
		<th field="kode_iku_kl" sortable="true" width="50px">Kode IKU</th>
		<th field="deskripsi_iku_kl" hidden="true">Des IKU</th>
		<th field="target" sortable="true" width="40px" align="right" formatter="formatPrice">Target</th>
		<th field="satuan" sortable="true" width="60px">Satuan</th>
		<th field="realisasi" sortable="true" width="50px" align="right" formatter="formatPrice">Capaian</th>
		<th field="realisasi_persen" sortable="true" width="35px" align="right" formatter="formatPrice">Capaian <br>(%)</th>
			<th field="keterangan" sortable="true" width="80px">Keterangan</th>
			<th field="action_plan" sortable="true" width="80px">Rencana Aksi</th>
	  </tr>
	  </thead>
	</table>
	
	<div class="popdesc" id="popdesc<?=$objectId?>">&nbsp;</div>
	

<script  type="text/javascript" >
	$(function(){
		var url;
		
		loadTahun<?=$objectId;?> = function (){
			$('#divTahun<?=$objectId;?>').load(
				base_url+"rujukan/programkl/getListTahun/"+"<?=$objectId;?>"
			);
		}
		
		loadTahun<?=$objectId;?>();
		
		newData<?=$objectId;?> = function (){  
			//$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Add Data Program');
			//$('#fm<?=$objectId;?>').form('clear');  
			//url = base_url+'rujukan/programkl/save';  
			addTab("Add Program", "rujukan/programkl/add");
		}
		//end newData 
		
		editData<?=$objectId;?> = function (){
			var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
			if (row){
				addTab("Edit Program", "rujukan/programkl/edit/"+row.id_program_kl);
			}
		}
		//end editData
			
		printData<?=$objectId;?>=function(){
			window.open(getUrl<?=$objectId;?>(2));;
		}
		
		toExcel<?=$objectId;?>=function(){
			window.open(getUrl<?=$objectId;?>(3));;
		}
			
		clearFilter<?=$objectId;?> = function (){
			$("#filter_e1<?=$objectId;?>").val('');	
			$("#filter_tahun<?=$objectId;?>").val('');	
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
		//end searhData		
		
		/*
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
		}*/
		//end saveData

		getUrl<?=$objectId;?> = function (tipe){
			var file1 = $("#filter_e1<?=$objectId;?>").val();
			var filtahun = $("#filter_tahun<?=$objectId;?>").val();
			if (file1 == null) file1 = "-1";
			if (filtahun == null) filtahun = "-1";
		
			if (tipe==1){
				return "<?=base_url()?>rujukan/programkl/grid/"+file1+"/"+filtahun;
			}
			else if (tipe==2){
				return "<?=base_url()?>rujukan/programkl/pdf/"+file1+"/"+filtahun;
			}else if (tipe==3){
				return "<?=base_url()?>rujukan/programkl/excel/"+file1+"/"+filtahun;
			}
		}

		formatPrice=function (val,row){
			return val;//($.fn.autoNumeric.Format("txtAmount"+idx,total,{aSep:".",aDec:",",mDec:2}));
			/* if (val < 20){
				return '<span style="color:red;">('+val+')</span>';
			} else {
				return val;
			} */
		}
			
		setTimeout(function(){
			$('#dg<?=$objectId;?>').datagrid({url:"<?=base_url()?>rujukan/programkl/grid"});
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
			<div class="fsearch" <?=($this->session->userdata('unit_kerja_e1')=='-1'?'':'style="display:none"')?>>
				<table border="0" cellpadding="1" cellspacing="1">
				<tr>
					<td>Tahun :</td>
					<td><span id="divTahun<?=$objectId?>"></span></td>
				</tr>		
				<tr>
					<td>Unit Kerja Eselon I&nbsp</td>
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
		<? if($this->sys_menu_model->cekAkses('ADD;',6,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="newData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-add" plain="true">Add</a>  
		<?}?>
		<? if($this->sys_menu_model->cekAkses('EDIT;',6,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="editData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Edit</a>
		<?}?>
		<? if($this->sys_menu_model->cekAkses('PRINT;',6,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="printData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
		<?}?>
		<? if($this->sys_menu_model->cekAkses('EXCEL;',6,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="toExcel<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-excel" plain="true">Excel</a>
		<?}?>
	</div>
</div>
	
<table id="dg<?=$objectId;?>" class="easyui-datagrid" style="height:auto;width:auto" title="Data Program" toolbar="#tb<?=$objectId;?>" fitColumns="true" singleSelect="true" rownumbers="true" pagination="true">
	<thead>
	<tr>
		<!-- <th field="id_program_kl" sortable="true" width="5px">No.</th> -->
		<th field="tahun" sortable="true" width="15px">Tahun</th>
		<th field="kode_program" sortable="true" width="15px">Kode Program</th>
		<th field="nama_program" sortable="true" width="75px">Nama Program</th>
		<th field="total" sortable="true" width="30px" align="right" formatter="formatPrice">Total Anggaran (Rp)</th>
		<th field="kode_e1" sortable="true" width="15px" <?=($this->session->userdata('unit_kerja_e1')=='-1'?'':'hidden="true"')?>>Kode Subsektor</th>
		<th field="nama_e1" hidden="true">Kode Subsektor</th>
	</tr>
	</thead>  
</table>

<div class="popdesc" id="popdesc<?=$objectId?>">indriyanto</div>
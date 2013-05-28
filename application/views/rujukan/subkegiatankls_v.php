	<script  type="text/javascript" >
		$(function(){
			var url;
			newData<?=$objectId;?> = function (){  
				//$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','New kegiatankl');  
				//$('#fm<?=$objectId;?>').form('clear');  
				//url = base_url+'penetapan/kegiatankl/save';  
				
				addTab("Tambah Sub Kegiatan Kementerian", "rujukan/subkegiatankl/add");
			}
			//end newData 
			
			
			clearFilter<?=$objectId;?> = function (){
				$("#filter_e1<?=$objectId;?>").val('-1');
				<? if ($this->session->userdata('unit_kerja_e1')==-1) {?>
				$("#filter_e2<?=$objectId;?>").empty().append('<option value="-1">Semua</option>');		
				<?} else if (($this->session->userdata('unit_kerja_e1')!=null)&&($this->session->userdata('unit_kerja_e1')!=-1)) {?>
				$("#filter_e2<?=$objectId;?>").val('-1');
				<?}?>
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
				return "<?=base_url()?>rujukan/subkegiatankl/grid/"+file1+"/"+file2;
			}
			else if (tipe==2){
				return "<?=base_url()?>rujukan/subkegiatankl/pdf/"+file1+"/"+file2;
			}else if (tipe==3){
				return "<?=base_url()?>rujukan/subkegiatankl/excel/"+file1+"/"+file2;
			}
		}
			
			searchData<?=$objectId;?> = function (){
			//ambil nilai-nilai filter
			/*$('#dg<?=$objectId;?>').datagrid({
				url:getUrl<?=$objectId;?>(1),
				queryParams:{lastNo:'0'},	
				pageNumber : 1,
				onLoadSuccess:function(data){	
					$('#dg<?=$objectId;?>').datagrid('options').queryParams.lastNo = data.lastNo;
					//prepareMerge<?=$objectId;?>(data);
				}});
			*/

				//ambil nilai-nilai filter
				var filnip = $("#filter_nip").val();
				var filnama = $("#filter_nama").val();
				var filalamat = $("#filter_alamat").val();
				
				//encode parameter
				if(filnip.length==0) filnip ="6E756C6C";
				else filnip = DoAsciiHex(filnip,"A2H");
								
				if(filnama.length==0) filnama ="6E756C6C";
				else filnama = DoAsciiHex(filnama,"A2H");
				if(filalamat.length==0) filalamat ="6E756C6C";
				else filalamat = DoAsciiHex(filalamat,"A2H");

				
				$('#dg<?=$objectId;?>').datagrid({url:"<?=base_url()?>rujukan/subkegiatankl/grid/"+filnip+"/"+filnama+"/"+filalamat});
			}
			//end searhData 
			
			printData<?=$objectId;?>=function(){
				window.open(getUrl<?=$objectId;?>(2));;
			}
			
			toExcel<?=$objectId;?>=function(){
				window.open(getUrl<?=$objectId;?>(3));;
			}
			
			editData<?=$objectId;?> = function (){
			var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
			if (row){
				addTab("Edit Data Sub Kegiatan", "rujukan/subkegiatankl/edit/"+row.id_subkegiatan_kl);
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
			
			formatPrice=function (val,row){
				return val;//($.fn.autoNumeric.Format("txtAmount"+idx,total,{aSep:".",aDec:",",mDec:2}));
				/* if (val < 20){
					return '<span style="color:red;">('+val+')</span>';
				} else {
					return val;
				} */
			}

			$("#filter_e1<?=$objectId;?>").change(function(){
				$("#divUnitKerja<?=$objectId;?>").load(base_url+"rujukan/subkegiatan/loadFilterSubKegiatan/"+$(this).val()+"/<?=$objectId;?>");
			
			});
			
			setTimeout(function(){
				$('#dg<?=$objectId;?>').datagrid({url:"<?=base_url()?>rujukan/subkegiatankl/grid"});
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
	  <!--<table border="0" cellpadding="1" cellspacing="1" width="100%">
		<tr>
			<td>
			<div class="fsearch" <?=($this->session->userdata('unit_kerja_e1')=='-1'?'':'style="display:none"')?>>
				<table border="0" cellpadding="1" cellspacing="1">
					<? if (($this->session->userdata('unit_kerja_e1')==-1)||($this->session->userdata('unit_kerja_e1')!=null)){?>
			<tr>
				<td>Unit Kerja Eselon I</td>
				<td>
					<?=$this->eselon1_model->getListFilterEselon1($objectId,$this->session->userdata('unit_kerja_e1'))?>				
				</td>
			</tr>
			<?}?>
			<tr>
				<td>Unit Kerja Eselon II</td>
				<td><span class="fitem" id="divUnitKerja<?=$objectId;?>">
					<?=$this->eselon2_model->getListFilterEselon2($objectId,$this->session->userdata('unit_kerja_e2'),$this->session->userdata('unit_kerja_e1'))?>
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
		  </div>
		</td>
	  </tr>
	  </table>-->
	  <div style="margin-bottom:5px">  
		<a href="#" onclick="newData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-add" plain="true">Add</a>  
		<a href="#" onclick="editData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Edit</a>
		<!--
		<a href="#" onclick="printData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
		-->
	  </div>
	</div>
	
	<table id="dg<?=$objectId;?>" class="easyui-datagrid" style="height:auto;width:auto" title="Sub Kegiatan Kementerian" toolbar="#tb<?=$objectId;?>" fitColumns="true" singleSelect="true" rownumbers="true" pagination="true">
	  <thead>
	  <tr>
		<th field="id_subkegiatan_kl" hidden="true" sortable="true" width="15px">No</th>
		<th field="tahun" sortable="true" width="10px">Tahun</th>
		<th field="kode_satker" sortable="true" hidden="true" width="15px">Kode Satker</th>
		<th field="kode_kegiatan" sortable="true" hidden="true" width="20px">kode Kegiatan</th>
		<th field="kode_subkegiatan" sortable="true" width="30px">Kode Sub Kegiatan</th>
		<th field="nama_subkegiatan" sortable="true" width="75px">Nama Sub Kegiatan</th>
		<th field="lokasi" sortable="true" width="25px">Lokasi</th>
		<th field="volume" sortable="true" width="15px">Volume</th>
		<th field="satuan" sortable="true" width="15px">Satuan</th>
		<th field="total" sortable="true" width="20px" align="right" formatter="formatPrice">Total</th>		
	  </tr>
	  </thead>  
	</table>

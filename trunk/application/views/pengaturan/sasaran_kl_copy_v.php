	<script  type="text/javascript" >
		$(function(){
			
			var url;
			
			cancel<?=$objectId?> = function(){
				$('#tt').tabs('close', 'Copy SasaranKementerian');	
			}
			
			
			copyData<?=$objectId;?> = function (){
				addTab("Copy SasaranKementerian", "pengaturan/sasaran_kl/copy");
			}
			
			
			$("#filter_tahun_tujuan<?=$objectId?>").change(function(){
			//	searchDataCopy<?=$objectId;?>();		
			});	
						
			clearFilter<?=$objectId;?> = function (){
				//ambil nilai-nilai filter
				$("#filter_e1<?=$objectId;?>").val('');	
				

				searchData<?=$objectId;?>();
			}
			//tipe 1=grid, 2=pdf, 3=excel
			getUrl<?=$objectId;?> = function (tipe){
				<? if ($this->session->userdata('unit_kerja_e1')==-1){?>
					var file1 = $("#filter_e1<?=$objectId;?>").val();
				<?} else {?>
					var file1 = "<?=$this->session->userdata('unit_kerja_e1');?>";
				<?}?>
				
				if (tipe==4)
					var filtahun = $("#filter_tahun_tujuan<?=$objectId;?>").val();
				else	
					var filtahun = $("#filter_tahun<?=$objectId;?>").val();
				var filkey = "-1";
				if ((filtahun == null)||(filtahun == "")) filtahun = "-2";
				
				if (file1 == "-1") file1 = "-2";
				
			
				if (tipe==1){
					return "<?=base_url()?>pengaturan/sasaran_kl/grid/"+file1+"/"+filtahun+"/"+filkey;
				}
				else if (tipe==2){
					return "<?=base_url()?>pengaturan/sasaran_kl/pdf/"+file1+"/"+filtahun+"/"+filkey;
				}else if (tipe==3){
					return "<?=base_url()?>pengaturan/sasaran_kl/excel/"+file1+"/"+filtahun+"/"+filkey;
				}else if (tipe==4){ //copy
					return "<?=base_url()?>pengaturan/sasaran_kl/grid/"+file1+"/"+filtahun+"/"+filkey;
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
							case "kode_sasaran_kl":
								showPopup('#popdesc<?=$objectId?>', row.deskripsi_sasaran_kl);
								break;
							default:
								closePopup('#popdesc<?=$objectId?>');
								break;
						}
					},
					onLoadSuccess:function(data){	
						//$('#dg<?=$objectId;?>').datagrid('options').queryParams.lastNo = data.lastNo;
						//prepareMerge<?=$objectId;?>(data);
				}});
			}
			//end searhData 
			
			searchDataCopy<?=$objectId;?> = function (){
				//ambil nilai-nilai filter
				$('#dgCopy<?=$objectId;?>').datagrid({
					url:getUrl<?=$objectId;?>(4),
					queryParams:{lastNo:'0'},	
					pageNumber : 1,
					onClickCell: function(rowIndex, field, value){
						
						$('#dgCopy<?=$objectId;?>').datagrid('selectRow', rowIndex);
						var row = $('#dgCopy<?=$objectId;?>').datagrid('getSelected');
						
						if (row==null) return;
						switch(field){
							case "kode_e1":
								
								showPopup('#popdesc2<?=$objectId?>', row.nama_e1);
								break;
							case "kode_sasaran_kl":
								showPopup('#popdesc2<?=$objectId?>', row.deskripsi_sasaran_kl);
								break;
							default:
								closePopup('#popdesc2<?=$objectId?>');
								break;
						}
					},
					onLoadSuccess:function(data){	
						//$('#dg<?=$objectId;?>').datagrid('options').queryParams.lastNo = data.lastNo;
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
			
			
		
			saveCopy<?=$objectId;?>=function(){
				<? if ($this->session->userdata('unit_kerja_e1')==-1){?>
					var file1 = $("#filter_e1<?=$objectId;?>").val();
				<?} else {?>
					var file1 = "<?=$this->session->userdata('unit_kerja_e1');?>";
				<?}?>
				
				var filtahun = $("#filter_tahun<?=$objectId;?>").val();				
				var filtahuntujuan = $("#filter_tahun_tujuan<?=$objectId;?>").val();				
				if (filtahun == null) filtahun = "-1";				
				if ((filtahuntujuan == null)||(filtahuntujuan == "")) filtahuntujuan = "-1";				
				if (file1 == null) file1 = "-1";
				
				
				var result = false;
				var pesan = '';
				if (filtahun=="-1"){
					pesan = 'Tahun sumber data belum ditentukan.';
					$("#filter_tahun<?=$objectId?>").focus();
				}
				else if (filtahuntujuan=="-1"){
					pesan = 'Tahun tujuan data belum ditentukan.';
					$("#filter_tahun_tujuan<?=$objectId?>").focus();
				}
				else if (filtahun==filtahuntujuan){
					pesan = 'Tahun sumber tidak boleh sama dengan tahun tujuan.';
					$("#filter_tahun_tujuan<?=$objectId?>").val('');
					$("#filter_tahun_tujuan<?=$objectId?>").focus();
				}
				else if (file1=="-1")
					pesan = 'Unit kerjaKementerian belum ditentukan.';				
				else
				  result = true;
				
				if (!result){
					$.messager.show({
								title: 'Error',
								msg: pesan
							});
							return;
				}
				$('#fm<?=$objectId;?>').form('submit',{
					url: base_url+'pengaturan/sasaran_kl/saveCopy/'+filtahun+'/'+file1+'/'+filtahuntujuan,
					onSubmit: function(){
						return $(this).form('validate');
					},
					success: function(result){
				//	alert(result);
						var result = eval('('+result+')');
						if (result.success){
							$.messager.show({
								title: 'Sucsees',
								msg: result.msg
							});
						//	$('#dlg<?=$objectId;?>').dialog('close');		// close the dialog
							searchData<?=$objectId?>();
							searchDataCopy<?=$objectId?>();
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
		
			
			setTimeout(function(){			
				searchData<?=$objectId;?>();
				searchDataCopy<?=$objectId;?>();
			},150);
			
			
			$("#popdesc<?=$objectId?>").click(function(){
				closePopup('#popdesc<?=$objectId?>');
			});
			$("#popdesc2<?=$objectId?>").click(function(){
				closePopup('#popdesc2<?=$objectId?>');
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
			border-radius:0px;
			-moz-border-radius:0px;
			-webkit-border-radius: 5px;
			-moz-box-shadow: 0px 0px 0px rgba(0, 0, 0, 0.2);
			-webkit-box-shadow: 2px 2px 3px rgba(0, 0, 0, 0.2);
			filter: progid:DXImageTransform.Microsoft.Blur(pixelRadius=2,MakeShadow=false,ShadowOpacity=0.2);
			margin-bottom:0px;
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
			padding: 0px;
			position: relative;
		}
		.fsearch table{
			padding: 0px;
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
	
	<div  style="height:auto">
	
	  
		  <div class="fsearch">
			<form id="fm<?=$objectId;?>" method="post">
			<table border="0" cellpadding="1" cellspacing="5">			
			<tr>
				<td>Tahun :</td>
				<td><?=$this->sasaran_eselon1_model->getListFilterTahun($objectId,false);?></td>
			</tr>
			<tr>
				<td>Tahun Tujuan :</td>
				<td><input name="filter_tahun_tujuan" id="filter_tahun_tujuan<?=$objectId?>"  class="easyui-validatebox year" required="true" size="5" maxlength="4"></td>
			</tr>
			
			<tr>
			  
			  <td align="right" colspan="2" valign="top">
				<a href="#" class="easyui-linkbutton" onclick="clearFilter<?=$objectId;?>();" iconCls="icon-reset">Reset</a>
				<a href="#" class="easyui-linkbutton" onclick="searchData<?=$objectId;?>();searchDataCopy<?=$objectId;?>();" iconCls="icon-search">Search</a>
			  </td>
			</tr>
			
			</table>
			</form>
		  </div>
		
	 <div id="tab<?=$objectId?>" class="easyui-tabs" style="width:auto;height:auto;">
		<div title="Data Sasaran Kementerian" style="padding:10px;">
		   <div id="tb<?=$objectId;?>" style="margin-bottom:5px">  
				<? if($this->sys_menu_model->cekAkses('COPY;',31,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
						<a href="#" onclick="saveCopy<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-copy" plain="true">Copy</a>
					<?}?>
				<a href="#" onclick="cancel<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-cancel" plain="true">Cancel</a>
			  
			</div>	
			<table id="dg<?=$objectId;?>" style="height:auto;width:auto" title="" toolbar="#tb<?=$objectId;?>" fitColumns="true" singleSelect="true" rownumbers="true" pagination="true" nowrap="false">
			  <thead>
			  <tr>
				<th field="kode_e1" sortable="true" width="20" <?=($this->session->userdata('unit_kerja_e1')=='-1'?'':'hidden="true"')?>>KodeKementerian </th>
				<th field="nama_e1" sortable="true" hidden="true">namaKementerian </th>
				<th field="tahun" sortable="true" width="15">Tahun</th>
				<th field="kode_sasaran_e1" sortable="true" width="25">Kode Sasaran</th>
				<th field="deskripsi" sortable="true" width="125">Deskripsi</th>
				<th field="kode_sasaran_kl" sortable="true" width="25">Kode Sasaran KL</th>		
				<th field="deskripsi_sasaran_kl" hidden="true"></th>					
			  </tr>
			  </thead>  
			</table>
			<div class="popdesc" id="popdesc<?=$objectId?>">&nbsp;</div>
		</div>
		<div title="Data Sasaran Kementerian Hasil Copy atau Data Tahun Tujuan" style="padding:10px;">
			<table id="dgCopy<?=$objectId;?>" style="height:auto;width:auto" title="" fitColumns="true" singleSelect="true" rownumbers="true" pagination="true" nowrap="false">
			  <thead>
			  <tr>
				<th field="kode_e1" sortable="true" width="20" <?=($this->session->userdata('unit_kerja_e1')=='-1'?'':'hidden="true"')?>>KodeKementerian </th>
				<th field="nama_e1" sortable="true" hidden="true">namaKementerian </th>
				<th field="tahun" sortable="true" width="15">Tahun</th>
				<th field="kode_sasaran_e1" sortable="true" width="25">Kode Sasaran</th>
				<th field="deskripsi" sortable="true" width="125">Deskripsi</th>
				<th field="kode_sasaran_kl" sortable="true" width="25">Kode Sasaran KL</th>		
				<th field="deskripsi_sasaran_kl" hidden="true"></th>					
			  </tr>
			  </thead>  
			</table>
			<div class="popdesc" id="popdesc2<?=$objectId?>">&nbsp;</div>
		</div>
		
	</div>

	 
	  

	 
	

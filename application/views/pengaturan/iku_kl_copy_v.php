	<script  type="text/javascript" >
		$(function(){
			var url;
			$('textarea').autosize();   
			loadTahun<?=$objectId;?> = function (){
				$('#divTahun<?=$objectId;?>').load(
					base_url+"pengaturan/iku_kl/getListTahun/<?=$objectId;?>"+"/false"
				);
			}
			
			loadTahun<?=$objectId;?>();
			
			
			 
			 
			 $("#tahun<?=$objectId;?>").change(function(){
				 	
			});
			  
			cancel<?=$objectId?> = function(){
				$('#tt').tabs('close', 'Copy IKU Kementerian');	
			}
			
			
			copyData<?=$objectId;?> = function (){
				addTab("Copy IKU Kementerian", "pengaturan/iku_kl/copy");
			}
			
			
			
			
			clearFilter<?=$objectId;?> = function (){
				
				$("#filter_tahun<?=$objectId;?>").val('');	
				searchData<?=$objectId;?>();
			}
			
			getUrl<?=$objectId;?> = function (tipe){
			
				if (tipe==4)
					var filtahun = $("#filter_tahun_tujuan<?=$objectId;?>").val();
				else	
					var filtahun = $("#filter_tahun<?=$objectId;?>").val();
				var filkey = '-1';//$("#key<?=$objectId;?>").val();
				
				var file1 = "-1";
				
				if ((filtahun == null)||(filtahun == "")) filtahun = "-2";
				
				if (filkey == null) filkey = "-1";
				
				if (tipe==1){
					return "<?=base_url()?>pengaturan/iku_kl/grid/"+file1+"/"+filtahun+"/"+filkey;
				}
				else if (tipe==2){
					return "<?=base_url()?>pengaturan/iku_kl/pdf/"+file1+"/"+filtahun+"/"+filkey;
				}else if (tipe==3){
					return "<?=base_url()?>pengaturan/iku_kl/excel/"+file1+"/"+filtahun+"/"+filkey;
				}else if (tipe==4){
					return "<?=base_url()?>pengaturan/iku_kl/grid/"+file1+"/"+filtahun+"/"+filkey;
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
							case "kode_kl":
								showPopup('#popdesc<?=$objectId?>', row.nama_kl);
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
						$('#dg<?=$objectId;?>').datagrid('options').queryParams.lastNo = data.lastNo;
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
							case "kode_kl":
								showPopup('#popdesc2<?=$objectId?>', row.nama_kl);
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
						$('#dgCopy<?=$objectId;?>').datagrid('options').queryParams.lastNo = data.lastNo;
						//prepareMerge<?=$objectId;?>(data);
				}});
			}
			//end searhData 
			
			saveCopy<?=$objectId;?>=function(){
				
				var kode_kl = $("#kode_kl<?=$objectId;?>").val();				
				var filtahun = $("#filter_tahun<?=$objectId;?>").val();				
				var filtahuntujuan = $("#filter_tahun_tujuan<?=$objectId;?>").val();				
				if (filtahun == null) filtahun = "-1";				
				if ((filtahuntujuan == null)||(filtahuntujuan == "")) filtahuntujuan = "-1";				
				
				if (kode_kl == null) kode_kl = "-1";				
				
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
				else if (kode_kl=="-1")		
					pesan = 'Data Kementerian belum dipilih';				
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
					url: base_url+'pengaturan/iku_kl/saveCopy/'+filtahun+'/'+filtahuntujuan+'/'+kode_kl,
					onSubmit: function(){
						return $(this).form('validate');
					},
					success: function(result){
					//alert(result);
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
			
			printData<?=$objectId;?>=function(){
				window.open(getUrl<?=$objectId;?>(2));;
			}
			
			
			
			setTimeout(function(){
			
				searchData<?=$objectId;?> ();
				searchDataCopy<?=$objectId;?> ();
				//$('#dg<?=$objectId;?>').datagrid({url:"<?=base_url()?>pengaturan/iku_kl/grid"});
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
			float: left;
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

	<div style="height:auto">
		<table border="0" cellpadding="1" cellspacing="1" width="100%">
		<tr>
			<td>
				<div class="fsearch">
				<form id="fm<?=$objectId;?>" method="post">
					<table border="0" cellpadding="1" cellspacing="5">
					<tr>
						<td>Tahun :</td>
						<td><span id="divTahun<?=$objectId?>"></span></td>
					</tr>
					<tr>
						<td>Tahun Tujuan :</td>
						<td><input name="filter_tahun_tujuan" id="filter_tahun_tujuan<?=$objectId?>"  class="easyui-validatebox year" required="true" size="5" maxlength="4"></td>
					</tr>
					
					<tr>
						<td>Nama Kementerian :</td>
						<td><?=$this->kl_model->getListKL($objectId)?>
					</td>
					
				
					<tr>
						<td align="right" colspan="2" valign="top">
							<a href="#" class="easyui-linkbutton" onclick="clearFilter<?=$objectId;?>();" iconCls="icon-reset">Reset</a>
							<a href="#" class="easyui-linkbutton" onclick="searchData<?=$objectId;?>();" iconCls="icon-search">Search</a>
						</td>
					</tr>
					</table>
					</form>
				</div>
			</td>
		</tr>
		</table>

		
	</div>
	
	
	<div id="tab<?=$objectId?>" class="easyui-tabs" style="width:auto;height:auto;">
		<div title="Data IKU Kementerian" style="padding:10px;">
			<div id="tb<?=$objectId;?>" style="margin-bottom:5px">  
			
				<? if($this->sys_menu_model->cekAkses('COPY;',34,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="saveCopy<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-copy" plain="true">Copy</a>
				<a href="#" onclick="cancel<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-cancel" plain="true">Cancel</a>
			<?}?>
			<!--<a href="#" onclick="download<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-download" plain="true">Download Format Excel</a>-->
			</div>
			<table id="dg<?=$objectId;?>" style="height:auto;width:auto" toolbar="#tb<?=$objectId;?>" fitColumns="true" singleSelect="true" rownumbers="true" pagination="true"  nowrap="false">
			<thead>
				<tr>
					<th field="tahun" sortable="true" width="15px">Tahun</th>					
					<th field="kode_kl" sortable="true" width="15" hidden="true">Kode KL</th>
					<th field="kode_sasaran_kl" sortable="true" width="35" >Sasaran Strategis</th>
					<th field="kode_iku_kl" sortable="true" width="30">Kode</th>
					<th field="deskripsi" sortable="true" width="140">Deskripsi IKU</th>
					<th field="satuan" sortable="true" width="35">Satuan</th>
					
					
					<th field="deskripsi_sasaran_kl" sortable="true" hidden="true" >sasaran kl</th>
				</tr>
			</thead>  
			</table>
			<div class="popdesc" id="popdesc<?=$objectId?>">&nbsp;</div>
		</div>
		<div title="Data IKU Kementerian Hasil Copy atau Data Tahun Tujuan" style="padding:10px;">
			<table id="dgCopy<?=$objectId;?>" style="height:auto;width:auto"  fitColumns="true" singleSelect="true" rownumbers="true" pagination="true"  nowrap="false">
			<thead>
				<tr>
					<th field="tahun" sortable="true" width="15px">Tahun</th>
					<!--<th field="kode_kl" sortable="true" width="20">Kode Kementerian</th>-->
					<th field="kode_kl" sortable="true" width="15" hidden="true">Kode KL</th>
					<th field="kode_sasaran_kl" sortable="true" width="35" >Sasaran Strategis</th>
					<th field="kode_iku_kl" sortable="true" width="30">Kode</th>
					<th field="deskripsi" sortable="true" width="140">Deskripsi IKU</th>
					<th field="satuan" sortable="true" width="35">Satuan</th>
					
					<th field="deskripsi_sasaran_kl" sortable="true" hidden="true" >sasaran kl</th>	
				</tr>
			</thead>  
			</table>
			<div class="popdesc" id="popdesc2<?=$objectId?>">&nbsp;</div>
		</div>
		
	</div>

	

	
	

	

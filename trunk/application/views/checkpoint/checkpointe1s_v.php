	<script  type="text/javascript" >
				var idCheckpoint;

		$(function(){
			var url;
			newData<?=$objectId;?> = function (){  
				var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
				if (row){
					$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Add <?=$purpose?> Checkpoint Eselon I');  
					$('#fm<?=$objectId;?>').form('clear');  
					url = base_url+'checkpoint/checkpointe1/save';  
					$("#deskripsi_iku_e1<?=$objectId?>").val(row.deskripsi_iku_e1);
					$("#deskripsi_sasaran_e1<?=$objectId?>").val(row.deskripsi_sasaran_e1);
					$("#id_pk_e1<?=$objectId?>").val(row.id_pk_e1);
					$("#penanggungjawab<?=$objectId?>").val(row.nama_e1);
				}	
				//addTab("Add PK Eselon I", "checkpoint/checkpointe1/add");
			}
			//end newData 
			
			editData<?=$objectId;?> = function (editmode){
				var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
				var tr = jQuery('#dg<?=$objectId;?>').closest('tr.datagrid-row');
				//alert('row index parent'+tr.attr('datagrid-row-index'));
				alert(idCheckpoint+"KA") ;
				alert($.url().param()+"Parent");
				if (row){
					$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Add <?=$purpose?> Checkpoint Eselon I');  
					$('#fm<?=$objectId;?>').form('clear');  
					url = base_url+'checkpoint/checkpointe1/save';  
					$("#deskripsi_iku_e1<?=$objectId?>").val(row.deskripsi_iku_e1);
					$("#deskripsi_sasaran_e1<?=$objectId?>").val(row.deskripsi_sasaran_e1);
					$("#id_pk_e1<?=$objectId?>").val(row.id_pk_e1);
					$("#penanggungjawab<?=$objectId?>").val(row.nama_e1);
					$("#target<?=$objectId?>").val(row.target);
					$("#capaian<?=$objectId?>").val(row.capaian);
				}	
			}
			//end editData
			
			deleteData<?=$objectId;?> = function (){
				<? if ($this->session->userdata('unit_kerja_e1')=='-1'){?>				
					var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
					if(row){
						if(confirm("Apakah yakin akan menghapus data '" + row.kode_iku_e1 + "'?")){
							var response = '';
							$.ajax({ type: "GET",
									 url: base_url+'checkpoint/checkpointe1/delete/' + row.id_pk_e1,
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
				$("#filter_tahun<?=$objectId;?>").val('');
				searchData<?=$objectId;?>();
			}
			
			//tipe 1=grid, 2=pdf, 3=excel
			getUrl<?=$objectId;?> = function (tipe){
				var filtahun = $("#filter_tahun<?=$objectId;?>").val();
				
				if(filtahun.length==0) filtahun ="-1";
				
				if (tipe==1){
					return "<?=base_url()?>checkpoint/checkpointe1/grid/"+filtahun;
				}
				else if (tipe==2){
					return "<?=base_url()?>checkpoint/checkpointe1/pdf/"+filtahun;
				}else if (tipe==3){
					return "<?=base_url()?>checkpoint/checkpointe1/excel/"+filtahun;
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
				//$('#dg<?=$objectId;?>').datagrid({url:"<?=base_url()?>checkpoint/checkpointe1/grid"});
			},0);
			
			
			
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
					<td>
					<?=$this->checkpointe1_model->getListFilterTahun($objectId)?>
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
			</div>
			</td>
		</tr>
		</table>
	  <div style="margin-bottom:5px">
		<? if($this->sys_menu_model->cekAkses('ADD;',125,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="newData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-add" plain="true">Add</a>  
		<?}?>
		<!------------Edit View-->
		<? if($this->sys_menu_model->cekAkses('EDIT;',125,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="editData<?=$objectId;?>(true);" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Edit</a>
		<?}?>
		<? if($this->sys_menu_model->cekAkses('VIEW;',125,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="editData<?=$objectId;?>(false);" class="easyui-linkbutton" iconCls="icon-view" plain="true">View</a>
		<?}?>
		<? if($this->sys_menu_model->cekAkses('DELETE;',125,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="deleteData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-remove" plain="true">Delete</a>
		<?}?>
		<!--
		<a href="#" onclick="printData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
		<a href="#" onclick="toExcel<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-excel" plain="true">Excel</a>
		-->
	  </div>
	</div>
	
	<table id="dg<?=$objectId;?>" class="easyui-datagrid" style="height:auto;width:auto"
	 title="Data Checkpoint Eselon I" toolbar="#tb<?=$objectId;?>" fitColumns="true" singleSelect="true" rownumbers="true" pagination="true">
	  <thead>
	  <tr>
		<th field="id_pk_e1" hidden="true" sortable="true" width="50px">Kode</th>
		<th field="tahun" sortable="true" width="30px">Tahun</th>		
		<th field="kode_e1" sortable="true" width="50px">Kode Eselon I</th>
		<th field="nama_e1" hidden="true">nama_e1</th>
		<th field="kode_sasaran_e1" sortable="true" width="50px">Kode Sasaran</th>
		<th field="kode_iku_e1" sortable="true" width="50px">Kode IKU</th>
		<th field="target" sortable="true" width="50px" align="right" formatter="formatPrice">Target (RKT)</th>
		<th field="penetapan" sortable="true" width="50px" align="right" formatter="formatPrice">Target (PK)</th>
		<th field="satuan" sortable="true" width="50px">Satuan</th>
		<th field="deskripsi_iku_e1" hidden="true">deskripsi_iku_e1</th>
		<th field="deskripsi_sasaran_e1" hidden="true">deskripsi_sasaran_e1</th>
	  </tr>
	  </thead>  
	</table>
	
	<!-- Area untuk Form Add/Edit >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>  -->
	
	<div id="dlg<?=$objectId;?>" class="easyui-dialog" style="width:800px;height:450px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<!----------------Edit title-->
		<div id="ftitle<?=$objectId?>" class="ftitle">Add/Edit/View Rencana Checkpoint Eselon I</div>
		<form id="fm<?=$objectId;?>" method="post">
			
			<div class="fitem">
				<label style="width:130px">Sasaran Strategis:</label>					
					<textarea readonly name="deskripsi_sasaran_e1" id="deskripsi_sasaran_e1<?=$objectId?>" cols="70" class="easyui-validatebox" ></textarea>
				<input type="hidden" id="id_pk_e1<?=$objectId?>" name="id_pk_e1"/>
				<input type="hidden" id="id_checkpoint_kl<?=$objectId?>" name="id_checkpoint_kl"/>
			</div>
			
			<div class="fitem">
				<label style="width:130px;vertical-align:top">IKU :</label>
				<textarea readonly name="deskripsi_iku_e1" id="deskripsi_iku_e1<?=$objectId?>" cols="70" class="easyui-validatebox" ></textarea>
			</div>
			<div class="fitem">
				<label style="width:130px;vertical-align:top">Penanggung Jawab :</label>
				<input readonly name="penanggungjawab"  id="penanggungjawab<?=$objectId?>" size="60" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label style="width:130px;vertical-align:top">Unit Kerja Terkait :</label>
				<input name="unitkerja" size="60" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label style="width:130px;vertical-align:top">Kriteria Keberhasilan :</label>
				<input name="kriteria" size="60" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label style="width:130px;vertical-align:top">Ukuran Keberhasilan :</label>
				<input name="ukuran" size="60" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label style="width:130px;vertical-align:top">Periode :</label>
				<? echo $listPeriode;?>
			</div>
			<? if ($purpose=='Rencana') {?>
			<div class="fitem">
				<label style="width:130px;vertical-align:top">Target (%):</label>
				<input name="target" size="5" class="easyui-validatebox">
			</div>
			<?} ?>
			<? if ($purpose=='Capaian') {?>
			<div class="fitem">
				<label style="width:130px;vertical-align:top">Target (%):</label>
				<input name="target" size="5" readonly class="easyui-validatebox">
				&nbsp;&nbsp;Capaian (%):
				<input name="target" size="5" class="easyui-validatebox">
			</div>
			<?} ?>
		</form>
		<div id="dlg-buttons">
			<!----------------Edit title-->
			<a href="#" id="saveBtn<?=$objectId;?>" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveData<?=$objectId;?>()">Save</a>
			<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg<?=$objectId;?>').dialog('close')">Cancel</a>
		</div>
	</div>
	
	<script type="text/javascript">
        $(function(){
			var parentId;
			// chan
			$('#dg<?=$objectId;?>').datagrid({
				view: detailview,
				 detailFormatter:function(index,row){
                    return '<div style="padding:2px"><table id="ddv<?=$objectId;?>-' + index + '"></table></div>';
                //  return "tes";
                },
                onExpandRow: function(index,row){
				//	alert(row.id_pk_e1);

                    $('#ddv<?=$objectId;?>-'+index).datagrid({
                        url:'<?=base_url()?>checkpoint/checkpointe1/griddetail/'+row.id_pk_e1+'/?parentIndex='+index,
                        fitColumns:true,
                        singleSelect:true,
                        rownumbers:true,
                        loadMsg:'',
                        height:'auto',
                        columns:[[
                            {field:'id_checkpoint_kl',title:'id',width:200,hidden:true},
                            {field:'unit_kerja',title:'Unit Kerja',width:200},
                            {field:'periode',title:'Periode',width:200},
                            {field:'kriteria',title:'Kriteria Capaian',width:200},
                            {field:'ukuran',title:'Ukuran Capaian',width:200},
                            {field:'target',title:'Target',width:100,align:'right'},
                            
                            
                            <? if ($purpose=='Capaian') {?>
								{field:'capaian',title:'Capaian',width:100,align:'right'},
                            <? }?>
                            {field:'keterangan',title:'Keterangan',width:200}
                            
                        ]],
                        onResize:function(){
                            $('#dg<?=$objectId;?>').datagrid('fixDetailRowHeight',index);
                        },
                       onClickCell:function(rowIndex, field, value){
							 $('#ddv<?=$objectId;?>-'+index).datagrid('selectRow', rowIndex);
							var row = $('#ddv<?=$objectId;?>-'+index).datagrid('getSelected');
							idCheckpoint = row.id_checkpoint_kl;
							alert(idCheckpoint);
					   },
                        onLoadSuccess:function(){
                            setTimeout(function(){
                                $('#dg<?=$objectId;?>').datagrid('fixDetailRowHeight',index);
                            },0);
                        }
                    });
                    $('#dg<?=$objectId;?>').datagrid('fixDetailRowHeight',index);

	
                },
				onClickCell: function(rowIndex, field, value){
					$('#dg<?=$objectId;?>').datagrid('selectRow', rowIndex);
					var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
					//alert(row.deskripsi_iku_e1);
					switch(field){
						case "kode_e1":
							showPopup('#popdesc<?=$objectId?>', row.nama_e1);
							break;
						case "kode_sasaran_e1":
							showPopup('#popdesc<?=$objectId?>', row.deskripsi_sasaran_e1);
							break;
						case "kode_iku_e1":
							showPopup('#popdesc<?=$objectId?>', row.deskripsi_iku_e1);
							break;
						/* case "kode_e1":
							showPopup('#popdesc<?=$objectId?>', row.nama_e1);
							break; */
						default:
							closePopup('#popdesc<?=$objectId?>');
							break;
					}
				}
			});
			
			
            ;
        });
    </script>
    
	<div class="popdesc" id="popdesc<?=$objectId?>">pops</div>

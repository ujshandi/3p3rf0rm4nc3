	<script  type="text/javascript" >
		$(function(){
			var url;
			newData<?=$objectId;?> = function (){  
				$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','New Prefix');  
				$('#fm<?=$objectId;?>').form('clear');  
				url = base_url+'admin/prefix/save/add';  
			}
			//end newData 
			
			
			setE2<?=$objectId?> = function(valueE2){
				$("#divUnitKerja<?=$objectId;?>").load(base_url+"admin/prefix/loadE2/"+$('#unit_kerja_E1').val(),function(){
					$('#unit_kerja_E2').val(valueE2);
					changeE2<?=$objectId?>();
				});
			}
			
			loadPrefix<?=$objectId?> = function(){
				var kode_e1 = $("#unit_kerja_E1").val();
				var kode_e2 = $("#unit_kerja_E2").val();
				if (kode_e1==null) kode_e1 = '-1';
				if (kode_e2==null) kode_e2 = '-1';
				var response = '';
				$.ajax({ type: "GET",   
						 url: base_url+'admin/prefix/getprefix/' + kode_e1+'/'+kode_e2,   
						 async: false,
						 success : function(text)
						 {
							var result = eval('('+text+')');
							if (result){
								 $('#prefix<?=$objectId?>').val(result.prefix);
								 $('#prefix_iku<?=$objectId?>').val(result.prefix_iku);
							} 
						 }
				});
				
				
				
			}
			
			$("#unit_kerja_E1").change(function(){
				//$("#divUnitKerja<?=$objectId;?>").load(base_url+"admin/prefix/loadE2/"+$(this).val());
				setE2<?=$objectId?>("-1");
				loadPrefix<?=$objectId?>();
			
			});
			
			changeE2<?=$objectId?> = function(){				
				$("#unit_kerja_E2").change(function(){
					loadPrefix<?=$objectId?>();	
				});		
			};
			
			setE2Filter<?=$objectId?> = function(){
				$("#divUnitKerjaFilter<?=$objectId;?>").load(base_url+"rujukan/eselon2/loadFilterE2/"+$("#filter_e1<?=$objectId?>").val()+"/<?=$objectId;?>",function(){
				//	$('#unit_kerja_E2').val(valueE2);
					
				});
			}
			
			$("#filter_e1<?=$objectId?>").change(function(){
				//$("#divUnitKerja<?=$objectId;?>").load(base_url+"admin/prefix/loadE2/"+$(this).val());
				setE2Filter<?=$objectId?>("-1");
				
			
			});
			
			clearFilter<?=$objectId;?> = function (){
				$("#filter_tahun<?=$objectId;?>").val('');
				$("#filter_e1<?=$objectId;?>").val('');	
				$("#filter_e2<?=$objectId;?>").val('');	
				searchData<?=$objectId;?>();
			}
			
			getUrl<?=$objectId;?> = function (tipe){
				//jika tipe pdf&excel kirim jg paging datanya agar sesuai dengan grid				
				var paging="";
				if ((tipe==2)||(tipe==3)){
					var page =  $('#dg<?=$objectId;?>').datagrid('options').pageNumber;
					var rows = $('#dg<?=$objectId;?>').datagrid('options').pageSize;
				//	alert(page);
					if (rows==null) rows = "-1";
					if (page==null) page = "-1";
					paging = "/"+page+"/"+rows;						
				}
			
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
				
				//ambil nilai-nilai filter
			//	var file1 = $("#filter_e1<?=$objectId;?>").val();
			//	var file2 = $("#filter_e2<?=$objectId;?>").val();
				var filapptype = $("#filter_apptype<?=$objectId;?>").val();
				var fillevel = $("#filter_level_id<?=$objectId;?>").val();
			
				 if(file1==null) file1 ="-1";
				 if(file2==null) file2 ="-1";				
				 if(filapptype==null) filapptype ="-1";				
				 if(fillevel==null) fillevel ="-1";				
				
				if (tipe==1){
					return "<?=base_url()?>admin/prefix/grid/"+file1+"/"+file2+"/"+filapptype+"/"+fillevel;
				}
				else if (tipe==2){
					return "<?=base_url()?>admin/prefix/pdf/"+file1+"/"+file2+"/"+filapptype+"/"+fillevel+paging;
				}else if (tipe==3){
					return "<?=base_url()?>admin/prefix/excel/"+file1+"/"+file2+"/"+filapptype+"/"+fillevel+paging;
				}
				
			}
			
			searchData<?=$objectId;?> = function (){
				
				$('#dg<?=$objectId;?>').datagrid({
					url:getUrl<?=$objectId;?>(1),
					queryParams:{lastNo:'0'},	
					pageNumber : 1,					
					onClickCell: function(rowIndex, field, value){
						$('#dg<?=$objectId;?>').datagrid('selectRow', rowIndex);
						var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
						if (row==null) return;
						switch(field){
							case "unit_kerja_E1":
								showPopup('#popdesc<?=$objectId?>', row.nama_e1);
								break;
							case "unit_kerja_E2":
								showPopup('#popdesc<?=$objectId?>', row.nama_e2);
							break;
							
							default:
								closePopup('#popdesc<?=$objectId?>');
								break;
						}
					},
					onLoadSuccess:function(data){
						$('#dg<?=$objectId;?>').datagrid('options').queryParams.lastNo = data.lastNo;
						
					}
				});
			}			
			//end searhData 
			
			editData<?=$objectId;?> = function (){
				var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
				$('#fm<?=$objectId;?>').form('clear');  
				//alert(row.dokter_kode);
				
				if (row){
					$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Edit Prefix');
					$('#fm<?=$objectId;?>').form('load',row);
					$('#prefix_old<?=$objectId?>').val($('#prefix<?=$objectId?>').val());
					setE2<?=$objectId?>(row.unit_kerja_E2);
					//alert(row.unit_kerja_E2);
					//setTimeout(function(){
					//},100);
					url = base_url+'admin/prefix/save/edit/'+row.unit_kerja_E1+'/'+row.unit_kerja_E2;//+row.id;//'update_user.php?id='+row.id;
				}
			}
			//end editData
		
			printData<?=$objectId;?>=function(){
				window.open(getUrl<?=$objectId;?>(2));
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
			
			setTimeout(function(){
				searchData<?=$objectId?>();
			},100);
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
			<!--<tr>
						<td>Grup :</td>				
				  <td><?//$this->user_model->getListGrupFilter($objectId,$this->session->userdata('app_type'),$this->session->userdata('level'),true)?>
			  </td>
						 
			</tr> -->
			<tr>
			 
			  <td>Unit Kerja Eselon I :&nbsp;</td>
						<td>
							<?=$this->eselon1_model->getListFilterEselon1($objectId,$this->session->userdata('unit_kerja_e1'))?>
						</td>
						 
			</tr>
			<tr>				
			  <td>Unit Kerja Eselon II :&nbsp;</td>
						<td><span class="fitem" id="divUnitKerjaFilter<?=$objectId;?>">
							<?=$this->eselon2_model->getListFilterEselon2($objectId,$this->session->userdata('unit_kerja_e2'))?>
						</span></td>
			
			</tr>
			<tr>
			  <td align="right" valign="top" colspan="4">
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
		<? if ($this->sys_menu_model->cekAkses("ADD;",304,$this->session->userdata('group_id'),$this->session->userdata('level_id'))) {?>
			<a href="#" onclick="newData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-add" plain="true">Add</a>  
		<?}?>
		<? if ($this->sys_menu_model->cekAkses("EDIT;",304,$this->session->userdata('group_id'),$this->session->userdata('level_id'))) {?>
			<a href="#" onclick="editData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Edit</a>
		<?}?>
		<? if ($this->sys_menu_model->cekAkses("PRINT;",304,$this->session->userdata('group_id'),$this->session->userdata('level_id'))) {?>
			<!--<a href="#" onclick="printData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a> -->
		<?}?>
	  </div>
	</div>
	
	<table id="dg<?=$objectId;?>" style="height:auto;width:auto" title="Data Pengaturan Prefix" toolbar="#tb<?=$objectId;?>" fitColumns="true" singleSelect="true" rownumbers="true" pagination="true">
	  <thead>
	  <tr>
		<th field="unit_kerja_E1" sortable="true" width="50">Unit Kerja Eselon I</th>
		<th field="unit_kerja_E2" sortable="true" width="50">Unit Kerja Eselon II</th>
		<th field="deskripsi" sortable="true" width="200">Deskripsi</th>
		<th field="prefix" sortable="true" width="50">Prefix Sasaran</th>
		<th field="prefix_iku" sortable="true" width="50">Prefix IKU/IKK</th>		
		<th field="nama_e1" hidden="true" width="50">Prefix IKU/IKK</th>		
		<th field="nama_e2" hidden="true" width="50">Prefix IKU/IKK</th>		
	  </tr>
	  </thead>  
	</table>

	 <!-- AREA untuk Form Add/EDIT >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>  -->
	
	<div id="dlg<?=$objectId;?>" class="easyui-dialog" style="width:750px;height:250px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
	  <div class="ftitle">Add/Edit Prefix</div>
	  <form id="fm<?=$objectId;?>" method="post">
		
		
		<div class="fitem" >
		  <label style="width:120px;vertical-align:top">Unit Kerja Eselon I :</label>
		  
		  <?=$this->user_model->getListUnitKerja("E1")?>
		  
		</div>
		<div class="fitem" id="divUnitKerja<?=$objectId;?>">
		  <label style="width:120px;vertical-align:top">Unit Kerja Eselon II :</label>
		  
		  <?=$this->user_model->getListUnitKerja("E2")?>		  
		</div>				
		<div class="fitem">
		  <label style="width:120px;vertical-align:top">Prefix Sasaran:</label>
		  <input name="prefix_old" id="prefix_old<?=$objectId?>"  type="hidden"/>
		  <input name="prefix" id="prefix<?=$objectId?>" class="easyui-validatebox" required="true" size="20">
		</div>
		<div class="fitem">
		  <label style="width:120px;vertical-align:top">Prefix IKU/IKK:</label>
		  <input name="prefix_iku" id="prefix_iku<?=$objectId?>" class="easyui-validatebox" required="true" size="20">
		</div>		
		
	  </form>
    </div>
    <div id="dlg-buttons">
	  <a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveData<?=$objectId;?>()">Save</a>
	  <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg<?=$objectId;?>').dialog('close')">Cancel</a>
    </div>

	<div class="popdesc" id="popdesc<?=$objectId?>">&nbsp;</div>
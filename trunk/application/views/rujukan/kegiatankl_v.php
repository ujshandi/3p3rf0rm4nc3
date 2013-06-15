	<script  type="text/javascript" >
			
			onchangeKodeE1<?=$objectId;?> = function(){
					$("#divUnitKerjaAdd<?=$objectId;?>").load(base_url+"rujukan/eselon2/loadE2/"+$("#kode_e1<?=$objectId;?>").val()+"/<?=$objectId;?>");
					//alert($("#kode_e1<?=$objectId;?>").val());
					//$("#divUnitKerja<?=$objectId;?>").html('tes');
			}
			
		$(function(){
			
			
			$("#kode_e1<?=$objectId;?>").change(function(){
				onchangeKodeE1<?=$objectId;?>();
			//	alert('tes');
				
			});
			
			saveData<?=$objectId;?>=function(){
				$('#fm<?=$objectId;?>').form('submit',{
					url: base_url+'rujukan/kegiatankl/save',
					onSubmit: function(){
						return $(this).form('validate');
					},
					success: function(result){
						//alert(result);
						var result = eval('('+result+')');
						if (result.success){
							$.messager.show({
								title: 'Sucsees',
								msg: 'Data Berhasil Disimpan'
							});
							//$('#dlg<?=$objectId;?>').dialog('close');		// close the dialog
							$('#dg<?=$objectId;?>').datagrid('reload');	// reload the user data
							loadTahun<?=$objectId;?>();
							$('#tt').tabs('close', 'Add Kegiatan');
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
			
			onchangeKodeE1<?=$objectId;?>();
		});

	</script>
	
	<script language="javascript">
        function addRow(tableID) {
 
            var table = document.getElementById(tableID);
 
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
 
            var colCount = table.rows[1].cells.length;
			
			var newcell_1 = row.insertCell(0);
			newcell_1.innerHTML = table.rows[1].cells[0].innerHTML;
			//newcell_1.childNodes[1].selectedIndex = 0;
			//newcell_1.childNodes[1].id = rowCount;
			newcell_1.childNodes[1].value = "";
			newcell_1.childNodes[1].name = "detail[" + rowCount + "][kode_kegiatan]";
			
			var newcell_2 = row.insertCell(1);
			newcell_2.innerHTML = table.rows[1].cells[1].innerHTML;
			newcell_2.childNodes[1].value = "";
			newcell_2.childNodes[1].name = "detail[" + rowCount + "][nama_kegiatan]";
			
			var newcell_3 = row.insertCell(2);
			newcell_3.innerHTML = table.rows[1].cells[2].innerHTML;
			//newcell_3.childNodes[1].id = "satuan" + rowCount;
			newcell_3.childNodes[1].value = "";
			newcell_3.childNodes[1].name = "detail[" + rowCount + "][total]";
			//newcell_3.childNodes[1].readOnly = "true";
        }
 
        function deleteRow(tableID) {
            try {
				var table = document.getElementById(tableID);
				var rowCount = table.rows.length;
				
				if(rowCount <= 2) {
					alert("Cannot delete all the rows.");
				}else{
					table.deleteRow(rowCount-1);
				}
				
            }catch(e) {
                alert(e);
            }
        }
		
		
    </script>
	
	<style type="text/css">
		
	 #fm<?=$objectId;?>{margin:0;padding:5px}
	  .ftitle{font-size:14px;font-weight:bold;color:#666;padding:5px 0;margin-bottom:10px;border-bottom:1px solid #ccc;}
	  .fitem{margin-bottom:3px;border:0px solid none;}
	  .fitem label{display:inline-block;/* border:1px solid gray; */width:65px;}
	  .fitemL{margin-bottom:5px;border:0px solid none;}
	  .fitemL label{display:inline-block;/* border:1px solid gray; */width:75px;}
	  .fitemLn{margin-bottom:5px;border:0px solid none;}
	  .fitemLn label{display:inline-block;/* border:1px solid gray; */width:55px;}
	  .fitemG{margin-bottom:5px;border:0px solid none;}
	  .fitemG label{display:inline-block;/* border:1px solid gray; */width:76px;}
	  .fitemleft{margin-bottom:5px;border:0px solid none;float:left;width:215px;}
	  .fitemleft label{display:inline-block;/* border:1px solid gray; */width:75px;}
	  .fitemTl{margin-bottom:5px;border:0px solid none;float:left;width:446px;}
	  .fitemTl label{display:inline-block;/* border:1px solid gray; */width:75px;}
	  .regT{padding:5px;line-height:15px;color:#15428b;font-weight:bold;font-size:12px;background:url('<?=base_url();?>public/css/themes/gray/images/panel_title.gif') repeat-x;position:relative;border:1px solid #99BBE8;width:100%;}
	  .regT-grid{padding:5px;line-height:15px;font-size:12px;position:relative;/* border:1px solid #99BBE8;background-color:#EFEFEF; */width:100%;height:100%;}
	  .fitemArea{margin-bottom:5px;text-align:left;border:0px solid none;}
	  .fitemArea label{display:inline-block;width:79px;margin-bottom:5px;}
	  .tabIDP {height:100%;width:615px;/* border:1px solid red; */float:left;}
	  .tabBound{height:100%;width:10px;/* border:1px solid red; */float:left;}
	  .tabPend{height:100%;width:200px;/* border:1px solid red; */float:left;}
	  .tabDP{height:100%;width:200px;/* border:1px solid red; */float:left;}
	  legend {font-size:10pt;color:gray;text-transform:uppercase;font-weight:bold;padding:8px;}
	  .displayReg {/*width:98.9%;height:600px;border:1px solid red;*/}
	  	  
	  /* 2ndstyle */	  
	  .table {padding:2px;}
	  .top {background-color:#cfddcc;}
	  .subTop {background-color:#f1f1f1;}
	  .gridHead {color:#fff;background-color:#333;border:1px solid #f1f1f1;text-align:center;}
	  .grid {background-color:#fff;border:1px solid #f1f1f1;padding:0 0 0 2px;}
	  .td1 {text-align:right;padding:1px;}
	  .td2 {text-align:center;padding:1px;width:10px;}
	  .td3 {text-align:left;width:10px;}
	  
	</style>
			
	

		<div region="north" split="true" title="Tambah Data Kegiatan" style="height:450px;">
			
				<div region="center" border="true" title="">	
					<form id="fm<?=$objectId;?>" method="post">		
						<div class="fitem">
							<label style="width:120px">Tahun :</label>
							<input name="tahun" size="5" class="easyui-validatebox" required="true">
						</div>					
						<div class="fitem" >
							<label style="width:120px">Unit Kerja Eselon I :</label>
							<?=$this->eselon1_model->getListEselon1($objectId)?>
						</div>
						<div class="fitem">
							<label style="width:120px">Unit Kerja Eselon II :</label>
							<span id="divUnitKerjaAdd<?=$objectId;?>">
							<?="";//$this->eselon2_model->getListEselon2($objectId,$this->session->userdata('unit_kerja_e2'),$this->session->userdata('unit_kerja_e1'))?>
							</span>
						</div>
						<div class="fitem">
							<label style="width:120px">Nama Program :</label>
							<?=$this->programkl_model->getListProgramKL()?>
						</div>
						<div class="fitem">
							<br>
							<table id="tbl<?=$objectId;?>" border="1" width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC">
								<tr>
									<td width="18px" bgcolor="#F4F4F4">Kode Kegiatan</td>
									<td width="120px" bgcolor="#F4F4F4">Nama Kegiatan</td>
									<td width="20px" bgcolor="#F4F4F4">Total Anggaran (Rp)</td>
								</tr>
								<tr>
									<td>
										<input name="detail[1][kode_kegiatan]" size="18">
									</td>
									<td>
										<!--<input name="detail[1][nama_kegiatan]" size="120">-->
										<textarea name="detail[1][nama_kegiatan]" cols="80" rows="0"></textarea>
									</td>
									<td>
										<input name="detail[1][total]" size="20">
									</td>
								</tr>
							</table>
							<br>
							<a href="#" class="easyui-linkbutton" iconCls="icon-add" onclick="addRow('tbl<?=$objectId;?>')">Tambah Kegiatan</a>
							<a href="#" class="easyui-linkbutton" iconCls="icon-remove" onclick="deleteRow('tbl<?=$objectId;?>')">Hapus Kegiatan</a>
							&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveData<?=$objectId;?>()">Simpan</a>
						</div>
					</form>
				</div>
			</div>	
		

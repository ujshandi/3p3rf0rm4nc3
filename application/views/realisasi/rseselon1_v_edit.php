	
	<script  type="text/javascript" >
		
		$(function(){
		
			saveDataEdit<?=$objectId;?>=function(){
				$('#fmedit<?=$objectId;?>').form('submit',{
					url: base_url+'realisasi/rseselon1/save_edit',
					onSubmit: function(){
						return $(this).form('validate');
					},
					success: function(result){
						//alert(result);
						var result = eval('('+result+')');
						if (result.success){
							$.messager.show({
								title: 'Success',
								msg: 'Data Berhasil Disimpan'
							});
							
							// reload and close tab
							$('#dg<?=$objectId;?>').datagrid('reload');
							$('#tt').tabs('close', 'Edit Realisasi Kinerja Eselon I');
						} else {
							$.messager.show({
								title: 'Error',
								msg: result.msg
							});
						}
					}
				});
			}
			
			//------------Edit View
			closeView<?=$objectId;?>=function(){
				// reload and close tab
				$('#dg<?=$objectId;?>').datagrid('reload');
				$('#tt').tabs('close', 'View Realisasi Kinerja Eselon I');
			}
		});
			//end saveData
			
	</script>
	<style type="text/css">
		
	 #fmedit<?=$objectId;?>{margin:0;padding:5px}
	  .ftitle{font-size:14px;font-weight:bold;color:#666;padding:5px 0;margin-bottom:10px;border-bottom:1px solid #ccc;}
	  .fitem{margin-bottom:3px;border:0px solid none;}
	  .fitem label{display:inline-block;/* border:1px solid gray; */width:65px; float:left;}
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
			
	<div id="cc<?=$objectId;?>" class="easyui-layout" fit="true">  
				<!------------Edit View-->
				<div region="center" border="true" title="<?=($editMode=="true")?"Edit":"View"?>  Data Realisasi Kinerja Eselon I">	
					<form id="fmedit<?=$objectId;?>" method="post" style="margin:10px 5px 5px 10px;">
						<input type="hidden" name="id_kinerja_e1" value="<?=$result->id_kinerja_e1?>">
						<div class="fitem">
						  <label style="width:150px" >Tahun :</label>
						  <?=$result->tahun?>
						</div>
						<div class="fitem">
						  <label style="width:150px">Bulan :</label>
						  <?=$result->triwulan?>
						</div>
						<div class="fitem">							
						    <label style="width:150px">Unit Kerja Eselon I:</label>
							<?=$result->nama_e1?>
						</div>	
						<div class="fitem">
							<label style="width:150px">Sasaran :</label>
							<span style="display:block;margin-left: 150px;"><?=$result->sasaran?></span>
						</div>
						<div class="fitem">
							<label style="width:150px">Indikator Kinerja Utama :</label>
							<span style="display:block;margin-left: 150px;"><?=$result->iku_e1?></span>
						</div>
						<div class="fitem">
							<label style="width:150px">Target :</label>
							<?=$this->utility->cekNumericFmt($result->penetapan)?>
							&nbsp;&nbsp;&nbsp;
							<?=$result->satuan?>
						</div>
						<div class="fitem">
							<label style="width:150px">Realisasi :</label>
							<input name="realisasi" class="easyui-validatebox" required="true" size="10" maxlength="10" value="<?=$result->realisasi?>">
							&nbsp;&nbsp;&nbsp;
							<?=$result->satuan?>
						</div>
						<br>
						<!------------Edit View-->
						<?if($editMode=="true"){?>
							<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveDataEdit<?=$objectId;?>()">Simpan</a>
						<?}else{?>
							<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="closeView<?=$objectId;?>()">Close</a>
						<?}?>
					</form>
				</div>
		
	</div>
	

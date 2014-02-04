	<script  type="text/javascript" src="<?=base_url()?>public/js/autoNumeric.js"></script>
	<script  type="text/javascript" >
				
		$(function(){
			$('.year').autoNumeric('init',{aSep: '', aDec: ',',vMin:'0',aPad:"false",vMax:"9999"});
			$('.money').autoNumeric('init',{aSep: '.', aDec: ',',vMin:'0',aPad:"false",vMax:"999999999999999"});
			onchangeKodeE1<?=$objectId;?> = function(){
					$("#divUnitKerjaEdit<?=$objectId;?>").load(base_url+"rujukan/eselon2/loadE2/"+$("#kode_e1<?=$objectId;?>").val()+"/<?=$objectId;?>");
					//alert($("#kode_e1<?=$objectId;?>").val());
					//$("#divUnitKerja<?=$objectId;?>").html('tes');
					$("#divProgram<?=$objectId;?>").load(base_url+"rujukan/programkl/loadProgram/"+$("#kode_e1<?=$objectId;?>").val()+"/"+$("#tahun<?=$objectId;?>").val()+"/<?=$objectId;?>");
			}
			
			$("#tahun<?=$objectId;?>").change(function(){
				onchangeKodeE1<?=$objectId;?>();
				
			});
			$("#kode_e1<?=$objectId;?>").change(function(){
				onchangeKodeE1<?=$objectId;?>();
				
			});
			
			saveDataEdit<?=$objectId;?>=function(){
				$('#fm<?=$objectId;?>').form('submit',{
					url: base_url+'rujukan/kegiatankl/save_edit',
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
							
							$('#dg<?=$objectId;?>').datagrid('reload');	// reload the user data
							loadTahun<?=$objectId;?>();
							$('#tt').tabs('close', '<?=($editMode?'Edit':'Add')?> Kegiatan');
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
			cancel<?=$objectId;?>=function(){
				// reload and close tab
				$('#dg<?=$objectId;?>').datagrid('reload');
				$('#tt').tabs('close', '<?=($editMode?'Edit':'Add')?> Kegiatan');					
			}
			<?if (!$editMode) {?>
				onchangeKodeE1<?=$objectId;?>();
			<?}?>
		});

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
			

		<div region="north" split="true" title="Edit Data Kegiatan" style="height:450px;">
				<div region="center" border="true" title="">	
					<form id="fm<?=$objectId;?>" method="post">
						<input type="hidden" name="tahun_old" value="<?=$result->tahun?>"/>
						<input type="hidden" name="kegiatan_old" value="<?=$result->kode_kegiatan?>"/>
						<div class="fitem">
							<label style="width:120px">Tahun :</label>
							<input name="tahun" id="tahun<?=$objectId?>" class="easyui-validatebox year" required="true" value="<?=$result->tahun?>" size="5">
						</div>					
						<div class="fitem" >
							<label style="width:120px">Unit Kerja Eselon I :</label>
							<?=$this->eselon1_model->getListEselon1($objectId, array('value'=>$result->kode_e1))?>
						</div>
						<div class="fitem" >
							<label style="width:120px">Unit Kerja Eselon II :</label>
							<span class="fitem" id="divUnitKerjaEdit<?=$objectId;?>">
							<?=$this->eselon2_model->getListEselon2($objectId, array('e1'=>$result->kode_e1, 'value'=>$result->kode_e2))?>
							</span>
						</div> 
						<div class="fitem">
							<label style="width:120px">Nama Program :</label>
							<? if (!$editMode){?>
							<span id="divProgram<?=$objectId;?>">
							</span>
							
							<? }
							else {
							 echo $this->programkl_model->getListProgramKL($objectId, array('value'=>$result->kode_program,'tahun'=>$result->tahun,'kode_e1'=>$result->kode_e1));
							 
							 }?>
						</div>
						<div class="fitem">
							<label style="width:120px">Kode Kegiatan :</label>
							<input name="kode_kegiatan" class="easyui-validatebox" required="true" value="<?=$result->kode_kegiatan?>">
						</div>
						<div class="fitem">
							<label style="width:120px; vertical-align:top">Nama Kegiatan :</label>
							<textarea name="nama_kegiatan" class="easyui-validatebox" required="true" cols="100"><?=$result->nama_kegiatan?></textarea>
						</div>
						<div class="fitem" >
							<label style="width:120px">Total Anggaran (Rp) :</label>
							<input name="total" class="easyui-validatebox money" required="true" value="<?=$result->total?>" >
						</div>
						<br>
						<div class="fitem">
							<label style="width:120px"></label>
							<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveDataEdit<?=$objectId;?>()">Save</a>
							<label style="width:120px"></label>
							<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="cancel<?=$objectId;?>()">Cancel</a>
						</div>
					</form>
				</div>
			</div>	

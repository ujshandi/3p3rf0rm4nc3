	<script  type="text/javascript" >
				
		$(function(){
		
			cancel<?=$objectId;?>=function(){
				$('#tt').tabs('close', '<?=($editmode==TRUE?'Edit':'View')?> RKT Kementerian');
			}
			
		 	saveDataEdit<?=$objectId;?>=function(){
				$('#fm<?=$objectId;?>').form('submit',{
					url: base_url+'rencana/rktkl/save_edit',
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
							$('#tt').tabs('close', 'Edit RKT Kementerian');
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
			
			
		});

	</script>
	
	<script language="javascript">
        
		// function getSatuanEdit<?=$objectId;?>(kode, idText){
			// var response = '';
			// $.ajax({ type: "GET",   
					 // url: base_url+'rencana/rktkl/getSatuan/' + kode,   
					 // async: false,
					 // success : function(text)
					 // {
						 // response = text;
					 // }
			// });
			
			// document.getElementById('satuanEdit<?=$objectId;?>').innerHTML = response;
		// }
    </script>
	
	<!-- Dari Stef -->
	<script type="text/javascript">
		// $(document).ready(function() {
			
			// if($("#drop<?=$objectId;?>").is(":visible")){
				// $("#drop<?=$objectId;?>").slideToggle("slow");
			// }
			
			// $("#txtkode_sasaran_kl<?=$objectId;?>").click(function(){
				// $("#drop<?=$objectId;?>").slideToggle("slow");
			// });
			
			// $("#drop<?=$objectId;?> li").click(function(e){
				// var chose = $(this).text();
				// $("#txtkode_sasaran_kl<?=$objectId;?>").text(chose);
				// $("#drop<?=$objectId;?>").slideToggle("slow");
			// });

		// });
		
		// function setSasaran<?=$objectId;?>(valu){
			// document.getElementById('kode_sasaran_kl<?=$objectId;?>').value = valu;
			// //getDetail();
		// }
	</script>
	
	<style type="text/css">
		
	 #fm<?=$objectId;?>{margin:0;padding:5px}
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
	
			<div class="easyui-layout" fit="true">  
								
				<div region="center" border="true" title="<?=($editmode==TRUE?'Edit':'View')?> Data Rencana Kinerja Tahunan (RKT) Kementerian">	
					<form id="fm<?=$objectId;?>" method="post" style="margin:10px 5px 5px 10px;">
						<input name="id_rkt_kl" class="" type="hidden" value="<?=$result->id_rkt_kl?>">
						<div class="fitem">
							<label style="width:150px">Tahun :</label>
							<?=$result->tahun?>
							<input type="hidden" name="tahun" value="<?=$result->tahun?>">
						</div>
						<div class="fitem">
							<label style="width:150px">Kementerian :</label>
							<?=$result->nama_kl?>
							<input type="hidden" name="kode_kl" value="<?=$result->kode_kl?>">
						</div>
						<div class="fitem">
							<label style="width:150px">Sasaran :</label>
							<span style="display:block;margin-left: 150px;"><?=$result->sasaran?></span>
							<input type="hidden" name="kode_sasaran_kl" value="<?=$result->kode_sasaran_kl?>">
						</div>
						<div class="fitem">
							<label style="width:150px">Indikator Kerja Utama :</label>
							<span style="display:block;margin-left: 150px;">
							<?=$result->iku_kl
							//$this->rktkl_model->getListIKU_KL($objectId, array('kode_iku'=>$result->kode_iku_kl, 'tahun' => $result->tahun , 'name'=>'kode_iku_kl'))//$result->iku_kl?>
							</span>
							<input type="hidden" name="old_kode_iku_kl" value="<?=$result->kode_iku_kl?>">
						</div>
						<div class="fitem">
							<label style="width:150px">Target :</label>
							<input name="target" class="easyui-validatebox" required="true" size="10" value="<?=($editmode==FALSE?$this->utility->cekNumericFmt($result->target):$result->target)?>">
							<span id="satuanEdit<?=$objectId?>" style="margin-left:10px;"><?=$result->satuan?></span>
						</div>
						<br>
						
						
						<?php if($editmode==TRUE){?>
							<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveDataEdit<?=$objectId;?>()">Save</a>&nbsp;
							<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="cancel<?=$objectId;?>()">Cancel</a>
						<?php } else {?>
							<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="cancel<?=$objectId;?>()">Close</a>
						<?}?>
					</form>
				</div>
			</div>	
		

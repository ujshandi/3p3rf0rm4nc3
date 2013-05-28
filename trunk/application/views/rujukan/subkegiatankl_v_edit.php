	<script  type="text/javascript" >
				
		$(function(){
		//chan=============================================
			 function setListE2<?=$objectId?>(){
				$("#divEselon2<?=$objectId?>").load(
					base_url+"rujukan/eselon2/loadE2/"+$("#kode_e1<?=$objectId?>").val()+"/<?=$objectId;?>",
					//on complete
					function (){
						//setKegiatan<?=$objectId?>($("#kode_e2<?=$objectId?>").val());
						$("#kode_e2<?=$objectId?>").change(function(){
							setKegiatan<?=$objectId?>($("#kode_e2<?=$objectId?>").val(), "<?=$result->id_kegiatan_kl;?>");
						});	
						setKegiatan<?=$objectId;?>($("#kode_e2<?=$objectId?>").val(), "<?=$result->id_kegiatan_kl;?>");
					}
				);
			 }
			 
			 $("#kode_e1<?=$objectId?>").change(function(){
				setListE2<?=$objectId?>();
			  });
			  
			function setKegiatan<?=$objectId;?>(e2,kode){
				$("#divKegiatan<?=$objectId?>").load(
					base_url+"rujukan/subkegiatankl/getListKegiatan/"+"<?=$objectId;?>"+"/"+e2+"/"+kode,
					//on complete
					function(){
						$("textarea").autogrow();
								
						if($("#drop<?=$objectId;?>").is(":visible")){
							$("#drop<?=$objectId;?>").slideUp("slow");
						}
						
						$("#txtkode_kegiatan<?=$objectId;?>").click(function(){
							$("#drop<?=$objectId;?>").slideDown("slow");
						});
						
						$("#drop<?=$objectId;?> li").click(function(e){
							var chose = $(this).text();
							$("#txtkode_kegiatan<?=$objectId;?>").text(chose);
							$("#drop<?=$objectId;?>").slideUp("slow");
						});
					}
				);
			}  
			
			  //inisialisasi
			$("#kode_e1<?=$objectId?>").val('<?=$result->kode_e1;?>');
			setListE2<?=$objectId?>();
			 
			//end-------------------------------------
			
			saveDataEdit<?=$objectId;?>=function(){
				$('#fm<?=$objectId;?>').form('submit',{
					url: base_url+'rujukan/subkegiatankl/save_edit',
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
							$('#tt').tabs('close', 'Edit Data Sub Kegiatan');
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
			
			//onchangeKodeE1<?=$objectId;?>();
		});

	</script>
	
	<!-- Dari Stef -->
	<script type="text/javascript">
		$(document).ready(function() {
			/* CHAN
			if($("#drop<?=$objectId;?>").is(":visible")){
				$("#drop<?=$objectId;?>").slideToggle("slow");
			}
			
			$("#txtkode_sasaran_e2<?=$objectId;?>").click(function(){
				$("#drop<?=$objectId;?>").slideToggle("slow");
			});
			
			$("#drop<?=$objectId;?> li").click(function(e){
				var chose = $(this).text();
				$("#txtkode_sasaran_e2<?=$objectId;?>").text(chose);
				$("#drop<?=$objectId;?>").slideToggle("slow");
			}); */

		});
		
		function setIKK<?=$objectId;?>(valu){
			document.getElementById('kode_kegiatan<?=$objectId;?>').value = valu;
			
			// set IKU E1 berdasarkan unit kerja eselon 1
			var kode_e2 = $('#kode_e2<?=$objectId;?>').val();
			$("#tbodyikk<?=$objectId;?>").load(
					base_url+"rujukan/subkegiatan/getKegiatan/"+kode_e2
			);
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
			
	<div id="cc<?=$objectId;?>" class="easyui-layout" fit="true">  

		<div region="north" split="true" title="Edit Data Sub Kegiatan" style="height:450px;">
			<div class="easyui-layout" fit="true">  
				<div region="center" border="true" title="">	
					<form id="fm<?=$objectId;?>" method="post">
						<input name="id_subkegiatan_kl" type="hidden" value="<?=$result->id_subkegiatan_kl?>">
						<div class="fitem">
							<label style="width:120px">Tahun :</label>
							<input name="tahun" class="easyui-validatebox" required="true" value="<?=$result->tahun?>" size="5">
						</div>					
						<? if ($this->session->userdata('unit_kerja_e1')=='-1'){?>
							<div class="fitem">							
								<label style="width:120px">Unit Kerja Eselon I :</label>
								<? if ($this->session->userdata('unit_kerja_e1')=='-1'){
									$this->eselon1_model->getListEselon1($objectId);
								} else { 
									echo $this->eselon1_model->getNamaE1($this->session->userdata('unit_kerja_e1'));
								 } ?>
							</div>
						<?}?>
						<div class="fitem">
							<label style="width:120px">Unit Kerja Eselon II :</label>
							<span id="divEselon2<?=$objectId?>">
								<?
								/* CHAN 
								if ($this->session->userdata('unit_kerja_e2')=='-1'){
									$this->eselon2_model->getListEselon2($objectId);
								} else { 
									echo $this->eselon2_model->getNamaE2($this->session->userdata('unit_kerja_e2'));
								 } */?>
							 </span>
						</div>
						<div class="fitem">
							<label style="width:120px">Nama Kegiatan :</label>
							<span id="divKegiatan<?=$objectId?>">
							<?="";//
							//CHAN $this->sasaran_eselon2_model->getListSasaranE2($objectId)?>
							</span>
						</div>
						<div class="fitem">							
								<label style="width:120px">Satuan Kerja :</label>
								<? 	$this->satker_model->getListSatker($objectId); ?>
						</div>
						<div class="fitem">
							<label style="width:120px">Kode Sub Kegiatan :</label>
							<input name="kode_subkegiatan" class="easyui-validatebox" required="true" value="<?=$result->kode_subkegiatan?>" >
						</div>
						<div class="fitem">
							<label style="width:120px; vertical-align:top">Nama Sub Kegiatan :</label>
							<textarea name="nama_subkegiatan" class="easyui-validatebox" required="true" cols="50"><?=$result->nama_subkegiatan?></textarea>
						</div>
						<div class="fitem">
							<label style="width:120px; vertical-align:top">Lokasi :</label>
							<input name="lokasi" class="easyui-validatebox" required="true" value="<?=$result->lokasi?>" >
						</div>
						<div class="fitem">
							<label style="width:120px; vertical-align:top">Volume :</label>
							<input name="volume" class="easyui-validatebox" required="true" value="<?=$result->volume?>" >
						</div>
						<div class="fitem">
							<label style="width:120px; vertical-align:top">Satuan :</label>
							<input name="satuan" class="easyui-validatebox" required="true" value="<?=$result->satuan?>" >
						</div>
						<div class="fitem" >
							<label style="width:120px">Total Anggaran (Rp) :</label>
							<input name="total" class="easyui-validatebox" required="true" value="<?=$result->total?>" >
						</div>
						<br>
						<div class="fitem">
							<label style="width:120px"></label>
							<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveDataEdit<?=$objectId;?>()">Simpan</a>
						</div>
					</form>
				</div>
			</div>	
		</div>

		<div region="center" title="" style="width:100%;padding:5px;background:#eee;">
		</div>

	</div>

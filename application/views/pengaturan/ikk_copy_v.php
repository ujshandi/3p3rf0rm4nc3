	<script  type="text/javascript" >
				
		$(function(){
			//chan=============================================
			cancel<?=$objectId?> = function(){
				$('#tt').tabs('close', 'Copy Data IKK');	
			}
			
			 function setListE2<?=$objectId?>(){
				$("#divEselon2<?=$objectId?>").load(
					base_url+"rujukan/eselon2/loadE2/"+$("#kode_e1<?=$objectId?>").val()+"/<?=$objectId;?>",
					//on complete
					function (){
						//setSasaranE2<?=$objectId?>($("#kode_e2<?=$objectId?>").val());
						$("#kode_e2<?=$objectId?>").change(function(){
							
						});	
						
					}
				);
			 }
			 
			 $("#kode_e1<?=$objectId?>").change(function(){
				setListE2<?=$objectId?>();
			  });
			  
			 $("#tahun<?=$objectId;?>").change(function(){
				var e2 = $("#kode_e2<?=$objectId;?>").val();			
			
			});
			  
			
			  //inisialisasi
			 setListE2<?=$objectId?>();
	//		 setSasaranE2<?=$objectId;?>($("#kode_e2<?=$objectId?>").val());
			 
			//end-------------------------------------
			
		 	saveData<?=$objectId;?>=function(){
				$('#fm<?=$objectId;?>').form('submit',{
					url: base_url+'rencana/rkteselon2/save',
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
							
							// reload and close tab
							$('#dg<?=$objectId;?>').datagrid('reload');
							$('#tt').tabs('close', 'Add RKT Eselon II');
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
	
	
	<style type="text/css">
		
		#tbl<?=$objectId;?> {
			width: 100%;
			padding: 0;
			margin: 0;
		}
		
		#tbl<?=$objectId;?> th{
			font: normal 11px;
			color: #4f6b72;
			border-right: 1px solid #C1DAD7;
			border-bottom: 1px solid #C1DAD7;
			border-top: 1px solid #C1DAD7;
			border-left: 1px solid #C1DAD7;
			text-align: left;
			padding: 2px 2px 3px 4px;
			margin:0;
			background: #CAE8EA url(<?=base_url();?>public/images/th.png) repeat-x;
		}
		
		#tbl<?=$objectId;?> td{
			border-right: 1px solid #C1DAD7;
			border-left: 1px solid #C1DAD7;
			border-top: 1px solid #C1DAD7;
			border-bottom: 1px solid #C1DAD7;
			background: #fff;
			padding: 0px 3px 0px 3px;
			margin:0;
			color: #4f6b72;
		}
		
		#tbl<?=$objectId;?> tr{
			margin:0;
		}
		
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

				<div region="center" border="true" title="Copy Data IKK Eselon II">
				<form id="fm<?=$objectId;?>" method="post" style="margin:10px 5px 5px 10px;">
				<!-- chan : Jika login superadmin maka tampilkan combo E1 utk nge filter list E2 -->
					<div class="fitem">
						<label style="width:120px;vertical-align:top">Tahun Asal :</label>
						<?=$this->ikk_model->getListTahun($objectId,false);?>
					</div>					
					<div class="fitem">
						<label style="width:120px;vertical-align:top">Tahun Tujuan :</label>
						<input id="tahun<?=$objectId?>" name="tahun"  class="easyui-validatebox year" required="true" size="5" maxlength="4">
					</div>					
					<div class="fitem">							
				<label style="width:120px">Unit Kerja Eselon I :</label>
				<? //if ($this->session->userdata('unit_kerja_e1')=='-1'){
					$this->eselon1_model->getListEselon1($objectId);
				//} else { 
					//echo $this->eselon1_model->getNamaE1($this->session->userdata('unit_kerja_e1'));
				//} ?>
			</div>					
			<?//}?>
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
				<label style="width:120px">Sasaran Eselon II :</label>					
					<span id="divSasaranE2<?=$objectId?>">
				</span>
			</div>		
					<br>
					<div class="fitem">
						<table id="tbl<?=$objectId;?>">
							<thead>
							<tr>
								<th></th>
								<th width="20px" bgcolor="#F4F4F4">No.</th>
								<tH width="100%" bgcolor="#F4F4F4">IKK</th>
								<th bgcolor="#F4F4F4">Target</th>
								<th bgcolor="#F4F4F4">Satuan</th>
							</tr>
							</thead>
							<tbody id="tbodyikk<?=$objectId;?>">
							</tbody>
						</table>
						<br>
						
						<a href="#" class="easyui-linkbutton" iconCls="icon-copy" onclick="copyData<?=$objectId;?>()">Copy</a>&nbsp;
						<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="cancel<?=$objectId;?>()">Cancel</a>
					</div>
				</form>
				</div>
			</div>	
		

	<script  type="text/javascript" >
				
		$(function(){
			$('textarea').autosize();   
			
			
			cancel<?=$objectId;?>=function(){
				$('#tt').tabs('close', 'Add PK Eselon II');
			}
			
			//chan=============================================
			 function setListE2<?=$objectId?>(){
				$("#divEselon2<?=$objectId?>").load(
					base_url+"rujukan/eselon2/loadE2/"+$("#kode_e1<?=$objectId?>").val()+"/<?=$objectId;?>",
					//on complete
					function (){
						//setSasaranE2<?=$objectId?>($("#kode_e2<?=$objectId?>").val());
						$("#kode_e2<?=$objectId?>").change(function(){
							setSasaranE2<?=$objectId?>($(this).val(), $('#tahun<?=$objectId;?>').val());
						});	
						setSasaranE2<?=$objectId?>($("#kode_e2<?=$objectId?>").val(), $('#tahun<?=$objectId;?>').val());
					}
				);
			 }
			 
			 $("#kode_e1<?=$objectId?>").change(function(){
				setListE2<?=$objectId?>();
			  });
			  
			function setSasaranE2<?=$objectId;?>(e2, tahun){
				$("#divSasaranE2<?=$objectId?>").load(
					base_url+"rencana/rkteselon2/getListSasaranE2/"+"<?=$objectId;?>"+"/"+e2+"/"+tahun,
					//on complete
					function(){
						$('textarea').autosize();   
								
						
						if($("#drop<?=$objectId;?>").is(":visible")){
							$("#drop<?=$objectId;?>").slideUp("slow");
						}
						
						$("#txtkode_sasaran_e2<?=$objectId;?>").click(function(){
							$("#drop<?=$objectId;?>").slideDown("slow");
						});
						
						$("#drop<?=$objectId;?> li").click(function(e){
							var chose = $(this).text();
							$("#txtkode_sasaran_e2<?=$objectId;?>").text(chose);
							$("#drop<?=$objectId;?>").slideUp("slow");
						});
					}
				);
			}  
			
			$("#tahun<?=$objectId?>").change(function(){
				getDetail<?=$objectId;?>();
			});
			
			  //inisialisasi
			 setListE2<?=$objectId?>();
			// setSasaranE2<?=$objectId;?>($("#kode_e2<?=$objectId?>").val());
			 
			//end-------------------------------------
			
		 	saveData<?=$objectId;?>=function(){
				$('#fm<?=$objectId;?>').form('submit',{
					url: base_url+'penetapan/penetapaneselon2/save',
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
							
							// delete all row
							try {
								var table = document.getElementById('tbl<?=$objectId;?>');
								var rowCount = table.rows.length;
								var i=0;
								
								for(i=rowCount-1; i>0; i--){
									table.deleteRow(i);
								}
								
							}catch(e) {
								alert(e);
							}
							document.getElementById('kode_sasaran_e2<?=$objectId;?>').selectedIndex = 0;
							
							// reload and close tab
							$('#dg<?=$objectId;?>').datagrid('reload');
							$('#tt').tabs('close', 'Add PK Eselon II');
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
		
        function addRow(tableID) {
 
            var table = document.getElementById(tableID);
 
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
 
            var colCount = table.rows[1].cells.length;
			
			var newcell_1 = row.insertCell(0);
			newcell_1.innerHTML = table.rows[1].cells[0].innerHTML;
			newcell_1.childNodes[1].selectedIndex = 0;
			newcell_1.childNodes[1].id = rowCount;
			newcell_1.childNodes[1].name = "detail[" + rowCount + "][kode_ikk]";
			
			var newcell_2 = row.insertCell(1);
			newcell_2.innerHTML = table.rows[1].cells[1].innerHTML;
			newcell_2.childNodes[1].value = "";
			newcell_2.childNodes[1].name = "detail[" + rowCount + "][target]";
			
			var newcell_3 = row.insertCell(2);
			newcell_3.innerHTML = table.rows[1].cells[2].innerHTML;
			newcell_3.childNodes[1].id = "satuan" + rowCount;
			newcell_3.childNodes[1].value = "";
			newcell_3.childNodes[1].name = "detail[" + rowCount + "][satuan]";
			newcell_3.childNodes[1].readOnly = "true";
			
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
		
		function getSatuan(kode, idText){
			var response = '';
			$.ajax({ type: "GET",   
					 url: base_url+'penetapan/penetapaneselon2/getSatuan/' + kode,   
					 async: false,
					 success : function(text)
					 {
						 response = text;
					 }
			});
			
			document.getElementById('satuan'+idText).value = response;
		}
		
		function getDetail<?=$objectId;?>(){
			var tahun 			= $('#tahun<?=$objectId;?>').val();
			//chan
			<? if ($this->session->userdata('unit_kerja_e2')=='-1') {?>
			var kode_e2 		= $('#kode_e2<?=$objectId;?>').val();
			<?} else {?>
			var kode_e2 		= "<?=$this->session->userdata('unit_kerja_e2')?>";
			<? }?>
			var kode_sasaran_e2 = $('#kode_sasaran_e2<?=$objectId;?>').val();
			var response = '';
			
			$.ajax({ type: "GET",   
					 url: base_url+'penetapan/penetapaneselon2/getDetail/' + tahun + '/' + kode_e2 + '/' + kode_sasaran_e2,
					 async: false,
					 success : function(text)
					 {
						 response = text;
					 }
			});
			
			document.getElementById('tbl<?=$objectId;?>').innerHTML = response;
		    
		}
		
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
		
		function setSasaran<?=$objectId;?>(valu){
			document.getElementById('kode_sasaran_e2<?=$objectId;?>').value = valu;
			getDetail<?=$objectId;?>();
		}
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

				<div region="center" border="true" title="Tambah Data Penetapan Kinerja (PK) Eselon II">
					<form id="fm<?=$objectId;?>" method="post" style="margin:10px 5px 5px 10px;">	
					<!-- chan : Jika login superadmin maka tampilkan combo E1 utk nge filter list E2 -->
						<div class="fitem">
							<label style="width:120px">Tahun:</label>
							<?=$this->rkteselon2_model->getListTahun($objectId)?>
						</div>	
						<? //if ($this->session->userdata('unit_kerja_e1')=='-1'){?>
						<div class="fitem">							
							<label style="width:120px">Unit Kerja Eselon I:</label>
							<?// if ($this->session->userdata('unit_kerja_e1')=='-1'){
								$this->eselon1_model->getListEselon1($objectId);
							/* } else { 
								echo $this->eselon1_model->getNamaE1($this->session->userdata('unit_kerja_e1'));
							} */ ?>
						</div>					
						<?//}?>
						<div class="fitem">							
							<label style="width:120px">Unit Kerja Eselon II:</label>
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
							<label style="width:120px">Sasaran :</label>
							<span id="divSasaranE2<?=$objectId?>">
							<?="";//
							//CHAN $this->sasaran_eselon2_model->getListSasaranE2($objectId)?>
							</span>
						</div>						
						<div class="fitem">
							<br>
							<table id="tbl<?=$objectId;?>">
								
							</table>
							<br>
							<!--
							<a href="#" class="easyui-linkbutton" iconCls="icon-add" onclick="addRow('tbl<?=$objectId;?>')">Tambah IKK</a>
							<a href="#" class="easyui-linkbutton" iconCls="icon-remove" onclick="deleteRow('tbl<?=$objectId;?>')">Hapus IKK</a>
							&nbsp;&nbsp;&nbsp;&nbsp;
							-->
							<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveData<?=$objectId;?>()">Save</a>&nbsp;<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="cancel<?=$objectId;?>()">Cancel</a>
						</div>
					</form>
				</div>

			</div>	
		


	<script  type="text/javascript" >
		$('.year').autoNumeric('init',{aSep: '', aDec: ',',vMin:'0',aPad:"false",vMax:"9999"});
			$('.money').autoNumeric('init',{aSep: '.', aDec: ',',vMin:'0',aPad:"false",vMax:"999999999999999"});		
		$(function(){
		//chan=============================================
			 function setListE2<?=$objectId?>(){
				$("#divEselon2<?=$objectId?>").load(
					base_url+"rujukan/eselon2/loadE2/"+$("#kode_e1<?=$objectId?>").val()+"/<?=$objectId;?>",
					//on complete
					function (){
						//setKegiatan<?=$objectId?>($("#kode_e2<?=$objectId?>").val());
						$("#kode_e2<?=$objectId?>").change(function(){
							setKegiatan<?=$objectId?>($(this).val());
						});	
						setKegiatan<?=$objectId?>($("#kode_e2<?=$objectId?>").val());
					}
				);
			 }
			 
			 $("#kode_e1<?=$objectId?>").change(function(){
				setListE2<?=$objectId?>();
			  });
			  
			function setKegiatan<?=$objectId;?>(e2){
				var tahun = $('#tahun<?=$objectId?>').val();
				if ((tahun==null)||(tahun=='')) tahun = '-1';
				$("#divKegiatan<?=$objectId?>").load(
					base_url+"rujukan/subkegiatankl/getListKegiatan/"+"<?=$objectId;?>"+"/"+e2+"/-1/"+tahun,
					//on complete
					function(){
						$('textarea').autosize();   
								
						
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
			 setListE2<?=$objectId?>();
			 setKegiatan<?=$objectId;?>($("#kode_e2<?=$objectId?>").val());
			 
			//end-------------------------------------
			
			saveData<?=$objectId;?>=function(){
				$('#fm<?=$objectId;?>').form('submit',{
					url: base_url+'rujukan/subkegiatankl/save',
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
							$('#tt').tabs('close', 'Tambah Sub Kegiatan Kementerian');
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
			newcell_1.childNodes[1].name = "detail[" + rowCount + "][kode_subkegiatan]";
			
			var newcell_2 = row.insertCell(1);
			newcell_2.innerHTML = table.rows[1].cells[1].innerHTML;
			newcell_2.childNodes[1].value = "";
			newcell_2.childNodes[1].name = "detail[" + rowCount + "][nama_subkegiatan]";
			
			var newcell_3 = row.insertCell(2);
			newcell_3.innerHTML = table.rows[1].cells[2].innerHTML;
			newcell_3.childNodes[1].value = "";
			newcell_3.childNodes[1].name = "detail[" + rowCount + "][lokasi]";
			
			var newcell_4 = row.insertCell(3);
			newcell_4.innerHTML = table.rows[1].cells[3].innerHTML;
			newcell_4.childNodes[1].value = "";
			newcell_4.childNodes[1].name = "detail[" + rowCount + "][volume]";
			
			var newcell_5 = row.insertCell(4);
			newcell_5.innerHTML = table.rows[1].cells[4].innerHTML;
			newcell_5.childNodes[1].value = "";
			newcell_5.childNodes[1].name = "detail[" + rowCount + "][satuan]";
			
			var newcell_6 = row.insertCell(5);
			newcell_6.innerHTML = table.rows[1].cells[5].innerHTML;
			//newcell_3.childNodes[1].id = "satuan" + rowCount;
			newcell_6.childNodes[1].value = "";
			newcell_6.childNodes[1].name = "detail[" + rowCount + "][total]";
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
			
	<div id="cc<?=$objectId;?>" class="easyui-layout" fit="true">  

		<div region="north" split="true" title="Tambah Data Sub Kegiatan" style="height:450px;">
			<div class="easyui-layout" fit="true">  
				<div region="center" border="true" title="">	
					<form id="fm<?=$objectId;?>" method="post">		
						<div class="fitem">
							<label style="width:120px">Tahun :</label>
							<input name="tahun" size="5" class="easyui-validatebox year" id="tahun<?=$objectId?>" required="true">
						</div>					
						<div class="fitem" >
							<label style="width:120px">Unit Kerja Eselon I :</label>
							<?=$this->eselon1_model->getListEselon1($objectId)?>
						</div>
						<div class="fitem">
							<label style="width:120px">Unit Kerja Eselon II :</label>
							<span id="divEselon2<?=$objectId;?>">
							<?="";//$this->eselon2_model->getListEselon2($objectId,$this->session->userdata('unit_kerja_e2'),$this->session->userdata('unit_kerja_e1'))?>
							</span>
						</div>
						<div class="fitem">
							<label style="width:120px">Nama Kegiatan :</label>
							<span id="divKegiatan<?=$objectId?>">
							<?="";//
							//CHAN $this->sasaran_eselon2_model->getListSasaranE2($objectId)?>
							</span>
						</div>
					<!--	<div class="fitem">							
							<label style="width:120px">Satuan Kerja :</label>
							<? 	$this->satker_model->getListSatker($objectId); ?>
						</div> -->
						<div class="fitem">
							<br>
							<table id="tbl<?=$objectId;?>" border="1" width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC">
								<tr>
									<td width="18px" bgcolor="#F4F4F4">Kode Sub Kegiatan</td>
									<td width="60px" bgcolor="#F4F4F4">Nama Sub Kegiatan</td>
								<!--	<td width="20px" bgcolor="#F4F4F4">Lokasi</td>
									<td width="20px" bgcolor="#F4F4F4">Volume</td>
									<td width="20px" bgcolor="#F4F4F4">Satuan</td> -->
									<td width="20px" bgcolor="#F4F4F4">Total Anggaran (Rp)</td>
								</tr>
								<tr>
									<td>
										<input name="detail[1][kode_subkegiatan]" size="18">
									</td>
									<td>
										<input name="detail[1][nama_subkegiatan]" size="60">
									</td>
									<!--<td>
										<input name="detail[1][lokasi]" size="20">
									</td><td>
										<input name="detail[1][volume]" size="20">
									</td><td>
										<input name="detail[1][satuan]" size="20">
									</td> -->
									<td>
										<input name="detail[1][total]" class="money" style="text-align:right" size="20">
									</td>
								</tr>
							</table>
							<br>
							<a href="#" class="easyui-linkbutton" iconCls="icon-add" onclick="addRow('tbl<?=$objectId;?>')">Tambah Sub Kegiatan</a>
							<a href="#" class="easyui-linkbutton" iconCls="icon-remove" onclick="deleteRow('tbl<?=$objectId;?>')">Hapus Sub Kegiatan</a>
							&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveData<?=$objectId;?>()">Simpan</a>
						</div>
					</form>
				</div>
			</div>	
		</div>

		<div region="center" title="" style="width:100%;padding:5px;background:#eee;">
		</div>

	</div>

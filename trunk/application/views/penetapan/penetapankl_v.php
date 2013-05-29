	<script  type="text/javascript" >
				
		$(function(){
		
		 	saveData<?=$objectId;?>=function(){
				$('#fm<?=$objectId;?>').form('submit',{
					url: base_url+'penetapan/penetapankl/save',
					onSubmit: function(){
						return $(this).form('validate');
					},
					success: function(result){
					//	alert(result);
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
							document.getElementById('kode_sasaran_kl<?=$objectId;?>').selectedIndex = 0;
							
							// reload and close tab
							$('#dg<?=$objectId;?>').datagrid('reload');
							$('#tt').tabs('close', 'Add PK Kementerian');
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
			
			$("#tahun<?=$objectId?>").change(function(){
				loadSasaran<?=$objectId;?>();
				getDetail<?=$objectId;?>();
			});
			
		});

	</script>
	
	<script language="javascript">
		
        function addRow<?=$objectId;?>(tableID) {
 
            var table = document.getElementById(tableID);
 
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
 
            var colCount = table.rows[1].cells.length;
			
			var newcell_1 = row.insertCell(0);
			newcell_1.innerHTML = table.rows[1].cells[0].innerHTML;
			newcell_1.childNodes[1].selectedIndex = 0;
			newcell_1.childNodes[1].id = rowCount;
			newcell_1.childNodes[1].name = "detail[" + rowCount + "][kode_iku]";
			
			var newcell_2 = row.insertCell(1);
			newcell_2.innerHTML = table.rows[1].cells[1].innerHTML;
			newcell_2.childNodes[1].value = "";
			newcell_2.childNodes[1].name = "detail[" + rowCount + "][target]";
			
			var newcell_2 = row.insertCell(2);
			newcell_2.innerHTML = table.rows[1].cells[2].innerHTML;
			newcell_2.childNodes[1].value = "";
			newcell_2.childNodes[1].name = "detail[" + rowCount + "][penetapan]";
			
			var newcell_3 = row.insertCell(3);
			newcell_3.innerHTML = table.rows[1].cells[3].innerHTML;
			newcell_3.childNodes[1].id = "satuan" + rowCount;
			newcell_3.childNodes[1].value = "";
			newcell_3.childNodes[1].name = "detail[" + rowCount + "][satuan]";
			newcell_3.childNodes[1].readOnly = "true";
			
        }
 
        function deleteRow<?=$objectId;?>(tableID) {
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
		
		function getSatuan<?=$objectId;?>(kode, idText){
			var response = '';
			$.ajax({ type: "GET",   
					 url: base_url+'penetapan/penetapankl/getSatuan/' + kode,   
					 async: false,
					 success : function(text)
					 {
						 response = text;
					 }
			});
			
			document.getElementById('satuan'+idText).value = response;
		}
		
		function getDetail<?=$objectId;?>(){
			var tahun 			= document.getElementById('tahun<?=$objectId;?>').value;
			var kode_kl 		= document.getElementById('kode_kl<?=$objectId;?>').value;
			var kode_sasaran_kl = document.getElementById('kode_sasaran_kl<?=$objectId;?>').value;
			var response = '';
			
			$.ajax({ type: "GET",   
					 url: base_url+'penetapan/penetapankl/getDetail/' + tahun + '/' + kode_kl + '/' + kode_sasaran_kl,
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
			if($("#drop<?=$objectId;?>").is(":visible")){
				$("#drop<?=$objectId;?>").slideUp("slow");
			}
			
			$("#txtkode_sasaran_kl<?=$objectId;?>").click(function(){
				$("#drop<?=$objectId;?>").slideDown("slow");
			});
			
			$("#drop<?=$objectId;?> li").click(function(e){
				var chose = $(this).text();
				$("#txtkode_sasaran_kl<?=$objectId;?>").text(chose);
				$("#drop<?=$objectId;?>").slideUp("slow");
			});
			
			
			// inisialisasi
			loadSasaran<?=$objectId;?>()

		});
		
		function setSasaran<?=$objectId;?>(valu){
			document.getElementById('kode_sasaran_kl<?=$objectId;?>').value = valu;
			getDetail<?=$objectId;?>();
		}
		
		function loadSasaran<?=$objectId;?>(){
			$("#divSasaran<?=$objectId?>").load(
				base_url+"pengaturan/sasaran_eselon1/getListSasaranKL/"+"<?=$objectId;?>"+"/"+$('#tahun<?=$objectId;?>').val(),
				function(){
					$("textarea").autogrow();
					if($("#drop<?=$objectId;?>").is(":visible")){
						$("#drop<?=$objectId;?>").slideUp("slow");
					}
					
					$("#txtkode_sasaran_kl<?=$objectId;?>").click(function(){
						$("#drop<?=$objectId;?>").slideDown("slow");
					});
					
					$("#drop<?=$objectId;?> li").click(function(e){
						var chose = $(this).text();
						$("#txtkode_sasaran_kl<?=$objectId;?>").text(chose);
					//	alert($("#txtkode_sasaran_kl<?=$objectId;?>").text());
						$("#drop<?=$objectId;?>").slideUp("slow");
					});
					if (key!=null)
						$('#kode_sasaran_kl<?=$objectId;?>').val(key);
					
					if ((val!=null)&&(val!=""))
						$('#txtkode_sasaran_kl<?=$objectId;?>').val(val);
				}
			);
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
	  
	</style>
			
	
			<div class="easyui-layout" fit="true">  
								
				<div region="center" border="true" title="Tambah Data Penetapan Kinerja (PK) Kementerian">
					<form id="fm<?=$objectId;?>" method="post" style="margin:10px 5px 5px 10px;">		
						<div class="fitem">
						  <label style="width:120px">Tahun :</label>
						  <?=$this->rktkl_model->getListTahun($objectId)?>
						</div>					
						<div class="fitem">
						    <label style="width:120px">Kementerian :</label>
							<?=$this->kl_model->getListKL($objectId)?>
						</div>
						<div class="fitem">
							<label style="width:120px">Sasaran :</label>
							<?//$this->sasaran_kl_model->getListSasaranKl($objectId)?>
							<span id="divSasaran<?=$objectId?>">
							</span>
						</div>						
						<div class="fitem">
							<br>
							<table id="tbl<?=$objectId;?>" width="100%">
								
							</table>
								<br>
								<!--
								<a href="#" class="easyui-linkbutton" iconCls="icon-add" onclick="addRow<?=$objectId;?>('tbl<?=$objectId;?>')">Tambah IKU</a>
								<a href="#" class="easyui-linkbutton" iconCls="icon-remove" onclick="deleteRow<?=$objectId;?>('tbl<?=$objectId;?>')">Hapus IKU</a>
								&nbsp;&nbsp;&nbsp;&nbsp;
								-->
								<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveData<?=$objectId;?>()">Simpan</a>
						</div>
					</form>
				</div>
			</div>	
		
		

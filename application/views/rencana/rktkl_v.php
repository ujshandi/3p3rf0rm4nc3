	<script  type="text/javascript" >
				
		$(function(){
			$('textarea').autosize();   	
		 	saveData<?=$objectId;?>=function(){
				$('#fm<?=$objectId;?>').form('submit',{
					url: base_url+'rencana/rktkl/save',
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
							// try {
								// var table = document.getElementById('tbl<?=$objectId;?>');
								// var rowCount = table.rows.length;
								// var i=0;
								
								// for(i=rowCount-1; i>1; i--){
									// table.deleteRow(i);
								// }
								
							// }catch(e) {
								// alert(e);
							// }
							
							// reload and close tab
							$('#dg<?=$objectId;?>').datagrid('reload');
							$('#tt').tabs('close', 'Add RKT Kementerian');
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
        function addRow<?=$objectId;?>(tableID) {
 
            var table = document.getElementById(tableID);
 
            //var rowCountTable = table.rows.length;
			//alert(table.rows[rowCountTable-1].cells[2].childNodes[1].id);
			//var rowCount = parseInt(table.rows[rowCountTable-1].cells[2].childNodes[1].id) + 1;
            var rowCount = table.rows.length;
			var row = table.insertRow(rowCount);
 
            var colCount = table.rows[1].cells.length;
			
			var newcell = row.insertCell(0);
			newcell.innerHTML = table.rows[1].cells[0].innerHTML;
			
			newcell = row.insertCell(1);
			newcell.innerHTML = rowCount;
			
			newcell = row.insertCell(2);
			newcell.innerHTML = table.rows[1].cells[2].innerHTML;
			
			newcell.childNodes[0].selectedIndex = 0;
			newcell.childNodes[0].id = "divIKUKL<?=$objectId?>_"+ rowCount;
			$(newcell.childNodes[0].id).html("");
			var tahun = $("#tahun<?=$objectId;?>").val();
			var kode_sasaran_kl = $("#kode_sasaran_kl<?=$objectId;?>").val();
			
			if (kode_sasaran_kl==null) kode_sasaran_kl = "-1";
			setIKUKL<?=$objectId;?>(rowCount,tahun,kode_sasaran_kl,"","");
			//newcell.childNodes[0].name = "detail[" + rowCount + "][kode_iku_kl]";
			//alert(newcell.childNodes[1].id);
			/* newcell.childNodes[1].selectedIndex = 0;
			newcell.childNodes[1].id = rowCount;
			newcell.childNodes[1].name = "detail[" + rowCount + "][kode_iku_kl]"; */
			
			newcell = row.insertCell(3);
			newcell.innerHTML = table.rows[1].cells[3].innerHTML;
			newcell.childNodes[1].value = "";
			newcell.childNodes[1].name = "detail[" + rowCount + "][target]";
			
			newcell = row.insertCell(4);
			newcell.innerHTML = table.rows[1].cells[4].innerHTML;
			newcell.childNodes[1].id = "satuan" + rowCount + '<?=$objectId;?>';
			newcell.childNodes[1].value = "";
			newcell.childNodes[1].name = "detail[" + rowCount + "][satuan]";
			newcell.childNodes[1].readOnly = "true";
			
        }
 
        function deleteRow<?=$objectId;?>(tableID) {
            try {
				var table = document.getElementById(tableID);
				var rowCount = table.rows.length;
				
				if(rowCount <= 2) {
					alert("Cannot delete all the rows.");
				}else{
					//table.deleteRow(rowCount-1);
					for(var i=0; i<rowCount; i++) {
						if(rowCount <= 2){
							//alert("Cannot delete all the rows.");
							break;
						}
						var row = table.rows[i];
						var chkbox = row.cells[0].childNodes[0];
						if(null != chkbox && true == chkbox.checked) {
							table.deleteRow(i);
							rowCount--;
							i--;
						}
					}
					
					for(var i=1; i<rowCount; i++) {
						var row = table.rows[i];
						row.cells[1].innerHTML = (i);
						
						row.cells[2].childNodes[1].id = i;
						row.cells[2].childNodes[1].name = "detail[" + i + "][kode_iku_kl]";;
						
						row.cells[3].childNodes[1].name = "detail[" + i + "][target]";
						
						row.cells[4].childNodes[1].id = "satuan" + i + '<?=$objectId;?>';
						row.cells[4].childNodes[1].name = "detail[" + i + "][satuan]";
					}
				}
				
            }catch(e) {
                alert(e);
            }
        }
		
		function getSatuan<?=$objectId;?>(kode, idText){
			var response = '';
			$.ajax({ type: "GET",   
					 url: base_url+'rencana/rktkl/getSatuan/' + kode,   
					 async: false,
					 success : function(text)
					 {
						 response = text;
					 }
			});
			
			document.getElementById('satuan'+idText+'<?=$objectId;?>').value = response;
		}
		
		$("#tahun<?=$objectId;?>").change(function(){
				 setSasaranKL<?=$objectId;?>($(this).val(),"","");
				getListIkuKL<?=$objectId?>();
				/*var tahun = $(this).val();
				if(tahun.length < 4){
					$("#tbodyiku<?=$objectId;?>").html('<tr><td colspan="5">Isi Tahun dengan benar</td></tr>');
				}else{
					$("#tbodyiku<?=$objectId;?>").load(
						base_url+"rencana/rktkl/getIKU_kl/"+tahun
					);
				}*/
			
			});
			
		getListIkuKL<?=$objectId;?> = function(){
			var tahun = $("#tahun<?=$objectId;?>").val();
			var kode_kl = $("#kode_kl<?=$objectId;?>").val();
			var kode_sasaran_kl = $("#kode_sasaran_kl<?=$objectId;?>").val();
			
			if (kode_kl==null) kode_kl = "-1";
			if (kode_sasaran_kl==null) kode_sasaran_kl = "-1";
				if(tahun.length < 4){
					$("#tbodyiku<?=$objectId;?>").html('<tr><td colspan="5">Isi Tahun dengan benar</td></tr>');
				}else{
					$("#tbodyiku<?=$objectId;?>").load(
						base_url+"rencana/rktkl/getIKU_kl/"+kode_kl+"/"+tahun+"/"+kode_sasaran_kl,function(){
						//	setIKUKL<?=$objectId;?>(1,tahun,kode_sasaran_kl,"","");
						}
					);
			}
		}	
			
			
			
			function setIKUKL<?=$objectId;?>(idx,tahun,sasaran,key,val){
				if ((tahun==null)||(tahun=="")) tahun = "-1";
				if ((sasaran==null)||(sasaran=="")) sasaran = "-1";
				var name='kode_iku_kl';
				$("#divIKUKL<?=$objectId?>_"+idx).load(
					base_url+"rencana/rktkl/getListIKU_KL/"+idx+"/"+tahun+'/'+sasaran,
					//on complete
					function(){
						$('textarea').autosize();   
						if($("#drop<?=$objectId;?>"+idx).is(":visible")){
							$("#drop<?=$objectId;?>"+idx).slideUp("slow");
						}
						
						$("#txtkode_iku_kl<?=$objectId;?>"+idx).click(function(){
							$("#drop<?=$objectId;?>"+idx).slideDown("slow");
						});
						
						$("#drop<?=$objectId;?>"+idx+" li").click(function(e){
							var chose = $(this).text();
							$("#txtkode_iku_kl<?=$objectId;?>"+idx).val(chose);
							$("#drop<?=$objectId;?>"+idx).slideUp("slow");
						});
						
						if (key!=null)
							$('#kode_iku_kl<?=$objectId;?>'+idx).val(key);
						if (val!=null)
							$('#txtkode_iku_kl<?=$objectId;?>'+idx).val(val);
					}
				);
			}  
			
			
			function setSasaranKL<?=$objectId;?>(tahun,key,val){
				if ((tahun==null)||(tahun=="")) tahun = "-1";
				$("#divSasaranKL<?=$objectId?>").load(
					base_url+"pengaturan/sasaran_eselon1/getListSasaranKL/"+"<?=$objectId;?>"+"/"+tahun,
					function(){
						$('textarea').autosize();   
						if($("#drop<?=$objectId;?>").is(":visible")){
							$("#drop<?=$objectId;?>").slideUp("slow");
						}
						
						$("#txtkode_sasaran_kl<?=$objectId;?>").click(function(){
							$("#drop<?=$objectId;?>").slideDown("slow");
						});
						
						$("#drop<?=$objectId;?> li").click(function(e){
							var chose = $(this).text();
							$("#txtkode_sasaran_kl<?=$objectId;?>").text(chose);
							//getListIkuKL<?=$objectId;?>();
							//alert(val);
							$("#drop<?=$objectId;?>").slideUp("slow");
						});
						if (key!=null)
							$('#kode_sasaran_kl<?=$objectId;?>').val(key);
						
						if ((val!=null)&&(val!=""))
							$('#txtkode_sasaran_kl<?=$objectId;?>').val(val);
					}
				);
				//alert("here");
				
			}
			
			function setSasaran<?=$objectId;?>(valu){
			//alert("here");
				document.getElementById('kode_sasaran_kl<?=$objectId;?>').value = valu;
				getListIkuKL<?=$objectId;?>();
			}
			
			function setIku<?=$objectId;?>(idx,name,valu){
			//alert("here");
				$('#kode_iku_kl<?=$objectId;?>'+idx).val(valu);
				//getListIkuKL<?=$objectId;?>();
			}
			
			// inisialisasi 
			setSasaranKL<?=$objectId;?>($("#tahun<?=$objectId?>").val(),"","")
			cancel<?=$objectId?> = function(){
				$('#tt').tabs('close', 'Add RKT Kementerian');
			}
    </script>
	
	<!-- Dari Stef -->
	<script type="text/javascript">

		/*
			chan
		function setSasaran<?=$objectId;?>(valu){
			//alert("here");
			document.getElementById('kode_sasaran_kl<?=$objectId;?>').value = valu;
		}
		
		function setSasaranKL<?=$objectId;?>(valu){
			
			
			var tahun = $('#tahun<?=$objectId;?>').val();
			if(tahun.length < 4){
				$("#tbodyiku<?=$objectId;?>").html('<tr><td colspan="5">Isi Tahun dengan benar</td></tr>');
			}else{
				$("#tbodyiku<?=$objectId;?>").load(
					base_url+"rencana/rktkl/getIKU_kl/"+tahun
				);
				
			}
			
			if(valu != null){
				document.getElementById('kode_sasaran_kl<?=$objectId;?>').value = valu;
			} 
		} */
		
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
								
				<div region="center" border="true" title="Tambah Data Rencana Kinerja Tahunan (RKT) Kementerian">	
					<form id="fm<?=$objectId;?>" method="post" style="margin:10px 5px 5px 10px;">		
						<div class="fitem">
							<label style="width:120px">Tahun :</label>
							<input name="kl_id" class="" type="hidden">
							<input id="tahun<?=$objectId?>" name="tahun"  class="easyui-validatebox year" required="true" size="5" maxlength="4">
						</div>					
						<div class="fitem">
							<label style="width:120px">Kementerian :</label>
							<?=$this->kl_model->getListKL($objectId)?>
						</div>
						<div class="fitem">
							<label style="width:120px">Sasaran :</label>
							<?//chan =$this->sasaran_kl_model->getListSasaranKL($objectId)?>
								<span id="divSasaranKL<?=$objectId?>">
								</span>
						</div>
						<div class="fitem">
							<br>
							<table id="tbl<?=$objectId;?>">
								<thead>
									<tr>
										<!--<th></th> -->
										<th width="20px" bgcolor="#F4F4F4">No.</th>
										<th width="100%" bgcolor="#F4F4F4">Indikator Kerja Utama</th>
										<th bgcolor="#F4F4F4">Target</th>
										<th bgcolor="#F4F4F4">Satuan</th>
									</tr>
								</thead>
								<tbody id="tbodyiku<?=$objectId;?>">
									
								</tbody>
							</table>
							<br>
						<!--	<a href="#" class="easyui-linkbutton" iconCls="icon-add" onclick="addRow<?=$objectId;?>('tbl<?=$objectId;?>')">Tambah IKU</a>
							<a href="#" class="easyui-linkbutton" iconCls="icon-remove" onclick="deleteRow<?=$objectId;?>('tbl<?=$objectId;?>')">Hapus IKU</a>
							&nbsp;&nbsp;&nbsp;&nbsp;-->
							<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveData<?=$objectId;?>()">Save</a>&nbsp;<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="cancel<?=$objectId;?>()">Cancel</a>
						</div>
					</form>
				</div>
			</div>	
		
		

	<script  type="text/javascript" >
		$(function(){
			var url;

			saveData<?=$objectId;?>=function(){
				$('#fm<?=$objectId;?>').form('submit',{
					url: url,
					onSubmit: function(){
						return $(this).form('validate');
					},
					success: function(result){
						//alert(result);
						var result = eval('('+result+')');
						if (result.success){
							$.messager.show({
								title: 'Success',
								msg: 'Data berhasil disimpan'
							});
							$('#dlg<?=$objectId;?>').dialog('close');	// close the dialog
							$('#dg<?=$objectId;?>').datagrid('reload');	// reload the user data
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
			
			newData<?=$objectId;?> = function (){  
				//----------------Edit title
				$('#ftitle<?=$objectId;?>').html("Add Data "+"<?=$title?>");
				$('#saveBtn<?=$objectId;?>').css("display","");
				$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Add Sasaran Eselon I');
				$('#fm<?=$objectId;?>').form('clear');  
				//initCombo<?=$objectId?>();
				url = base_url+'portal/save/6/add'; 
				
				$("#content_title<?=$objectId?>").removeAttr('readonly');
				$("#content<?=$objectId?>").removeAttr('readonly');
				$("#summary<?=$objectId?>").removeAttr('readonly');
				$("#url<?=$objectId?>").removeAttr('readonly');
			}
			//end newData 
			
			editData<?=$objectId;?> = function (editmode){
				//----------------Edit title
				$('#ftitle<?=$objectId;?>').html((editmode?"Edit Data ":"View Data ")+"<?=$title?>");
				$('#saveBtn<?=$objectId;?>').css("display",(editmode)?"":"none");
				var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
				$('#fm<?=$objectId;?>').form('clear');  
				//initCombo();
				if (row){
					$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Edit Sasaran Eselon I');
					$('#fm<?=$objectId;?>').form('load',row);
										
					url = base_url+'portal/save/6/edit/'+row.content_id;
				}
				if(editmode){
					$("#content_title<?=$objectId?>").removeAttr('readonly');
					$("#content<?=$objectId?>").removeAttr('readonly');
					$("#summary<?=$objectId?>").removeAttr('readonly');
					$("#url<?=$objectId?>").removeAttr('readonly');
				}else{
					$("#content_title<?=$objectId?>").attr('readonly');
					$("#content<?=$objectId?>").attr('readonly');
					$("#summary<?=$objectId?>").attr('readonly');
					$("#url<?=$objectId?>").attr('readonly');
				}
			}
			//end editData
			
			deleteData<?=$objectId;?> = function (){
				var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
				if(row){
					if(confirm("Apakah yakin akan menghapus data '" + row.content_title + "'?")){
						var response = '';
						$.ajax({ type: "GET",
								 url: base_url+'portal/delete/6/' + row.content_id,
								 async: false,
								 success : function(response)
								 {
									var response = eval('('+response+')');
									if (response.success){
										$.messager.show({
											title: 'Success',
											msg: 'Data Berhasil Dihapus'
										});
										
										// reload and close tab
										$('#dg<?=$objectId;?>').datagrid('reload');
									} else {
										$.messager.show({
											title: 'Error',
											msg: response.msg
										});
									}
								 }
						});
					}
				}
			}
			//end deleteData 

			//tipe 1=grid, 2=pdf, 3=excel
			getUrl<?=$objectId;?> = function (tipe){
				return "<?=base_url()?>portal/grid/6";
			}
			
			searchData<?=$objectId;?> = function (){
				//ambil nilai-nilai filter
				$('#dg<?=$objectId;?>').datagrid({
					url:getUrl<?=$objectId;?>(1),
					queryParams:{lastNo:'0'},	
					pageNumber : 1,
					onLoadSuccess:function(data){	
						$('#dg<?=$objectId;?>').datagrid('options').queryParams.lastNo = data.lastNo;
						//prepareMerge<?=$objectId;?>(data);
				}});
			}
			//end searchData 
			
			setTimeout(function(){
				searchData<?=$objectId;?> ();
				//$('#dg<?=$objectId;?>').datagrid({url:"<?=base_url()?>pengaturan/sasaran_eselon1/grid"});
			},50);
			
			// yanto
			$('#dg<?=$objectId;?>').datagrid({
				onClickCell: function(rowIndex, field, value){
					$('#dg<?=$objectId;?>').datagrid('selectRow', rowIndex);
					var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
					
					switch(field){
						case "kode_e1":
							showPopup('#popdesc<?=$objectId?>', row.nama_e1);
							break;
						case "kode_sasaran_kl":
							showPopup('#popdesc<?=$objectId?>', row.deskripsi_sasaran_kl);
							break;
						default:
							closePopup('#popdesc<?=$objectId?>');
							break;
					}
				}
			});
			
			$("#popdesc<?=$objectId?>").click(function(){
				closePopup('#popdesc<?=$objectId?>');
			});
			
		 });
	</script>
	
	<script>
		<!--Enter-->
		function submitEnter<?=$objectId;?>(e) {
			if (e.keyCode == 13) {
				searchData<?=$objectId;?>();
			}
		}
	</script>
	
	<!-- Dari Stef -->
	<script type="text/javascript">
		$(document).ready(function() {
		/* 	chan
		
		initCombo<?=$objectId?> = function(){
				if($("#drop<?=$objectId;?>").is(":visible")){
					$("#drop<?=$objectId;?>").slideUp("slow");
				}
			} 
			
			$("#txtkode_sasaran_kl<?=$objectId;?>").click(function(){
					$("#drop<?=$objectId;?>").slideDown("slow");
				});
				
				$("#drop<?=$objectId;?> li").click(function(e){
					var chose = $(this).text();
					$("#txtkode_sasaran_kl<?=$objectId;?>").val(chose);
				//	$("#drop<?=$objectId;?>").slideToggle("slow");
					$("#drop<?=$objectId;?>").slideUp("slow");
				});
			*/
		});
		
		function setSasaran<?=$objectId;?>(valu){
			//alert("here");
			document.getElementById('kode_sasaran_kl<?=$objectId;?>').value = valu;
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

	<div id="tb<?=$objectId;?>" style="height:auto">
		<div style="margin-bottom:5px">  
			<? if($this->sys_menu_model->cekAkses('ADD;',32,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="newData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-add" plain="true">Add</a>  
			<?}?>
			<!----------------Edit title-->
			<? if($this->sys_menu_model->cekAkses('EDIT;',32,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="editData<?=$objectId;?>(true);" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Edit</a>
			<?}?>
			<? if($this->sys_menu_model->cekAkses('VIEW;',32,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="editData<?=$objectId;?>(false);" class="easyui-linkbutton" iconCls="icon-view" plain="true">View</a>
			<?}?>
			<? if($this->sys_menu_model->cekAkses('DELETE;',32,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="deleteData<?=$objectId;?>(false);" class="easyui-linkbutton" iconCls="icon-remove" plain="true">Delete</a>
			<?}?>
		</div>
	</div>
	
	<table id="dg<?=$objectId;?>" class="easyui-datagrid" style="height:auto;width:auto" title="Data Berita Portal" toolbar="#tb<?=$objectId;?>" fitColumns="true" singleSelect="true" rownumbers="true" pagination="true"  nowrap="false">
		<thead>
		<tr>
			<th field="content_id" sortable="true" hidden="true">Kode Konten</th>
			<th field="content_title" sortable="true" width="15">Judul FAQ</th>
			<th field="content" sortable="true" width="25">Pertanyaan</th>
			<th field="summary" sortable="true" width="125">Jawaban</th>
			<th field="url" sortable="true" width="25">Tautan</th>		
		</tr>
		</thead>  
	</table>

	<!-- Area untuk Form Add/Edit >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>  -->
	
	<div id="dlg<?=$objectId;?>" class="easyui-dialog" style="width:800px;height:350px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<!----------------Edit title-->
		<div id="ftitle<?=$objectId?>" class="ftitle">Add/Edit/View Data Berita Portal</div>
		<form id="fm<?=$objectId;?>" method="post">
			<div class="fitem">
				<label style="width:150px;vertical-align:top">Judul FAQ :</label>
				<input name="content_title" class="easyui-validatebox" size="50" required="true" id="content_title<?=$objectId;?>">
			</div>
			<div class="fitem">
				<label style="width:150px;vertical-align:top">Pertanyaan :</label>
				<textarea name="content" cols="70" class="easyui-validatebox" style="resize:none"></textarea>
			</div>
			<div class="fitem">
				<label style="width:150px;vertical-align:top">Jawaban :</label>
				<textarea name="summary" cols="70" class="easyui-validatebox" style="resize:none"></textarea>
			</div>
			<div class="fitem">
				<label style="width:150px;vertical-align:top">Tautan :</label>
				<input name="url" class="easyui-validatebox" size="40" id="url<?=$objectId;?>">
			</div>
		</form>
		<div id="dlg-buttons">
			<!----------------Edit title-->
			<a href="#" id="saveBtn<?=$objectId;?>" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveData<?=$objectId;?>()">Save</a>
			<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg<?=$objectId;?>').dialog('close')">Cancel</a>
		</div>
    </div>
	
	<div class="popdesc" id="popdesc<?=$objectId?>">indriyanto</div>
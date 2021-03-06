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
				$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Add Regulasi');
				$('#fm<?=$objectId;?>').form('clear');  
				$("#published<?=$objectId;?>").val("0");
				CKEDITOR.instances.content<?=$objectId;?>.setData('');
				//initCombo<?=$objectId?>();
				url = base_url+'portal/save/5/add'; 
				
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
					$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Edit Regulasi');
					$('#fm<?=$objectId;?>').form('load',row);
					CKEDITOR.instances.content<?=$objectId;?>.setData(row.content);
										
					url = base_url+'portal/save/5/edit/'+row.content_id;
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
								 url: base_url+'portal/delete/5/' + row.content_id,
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
				return "<?=base_url()?>portal/grid/5";
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
		 });
	</script>
	
	<script>
		<!--Enter-->
		function submitEnter<?=$objectId;?>(e) {
			if (e.keyCode == 13) {
				searchData<?=$objectId;?>();
			}
		}

		function openKCFinder(field) {
		    window.KCFinder = {
		        callBack: function(url) {
		            field.value = url;
		            window.KCFinder = null;
		        }
		    };
		    window.open('<?=base_url()?>public/js/kcfinder/browse.php?type=files&dir=files/public', 'kcfinder_textbox',
		        'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
		        'resizable=1, scrollbars=0, width=800, height=600'
		    );
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
			var wWidth = $(window).width();
			var wHeight = $(window).height();
			$("#dlg<?=$objectId;?>").css('width',wWidth);
			$("#dlg<?=$objectId;?>").css('height',wHeight);
		});
		
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
	
	<table id="dg<?=$objectId;?>" class="easyui-datagrid" style="height:auto;width:auto" title="Data Regulasi Portal" toolbar="#tb<?=$objectId;?>" fitColumns="true" singleSelect="true" rownumbers="true" pagination="true"  nowrap="false">
		<thead>
		<tr>
			<th field="content_id" sortable="true" hidden="true">Kode Konten</th>
			<th field="content_title" sortable="true" width="15">Nomor Regulasi</th>
			<th field="content" sortable="true" width="100">Deskripsi</th>
			<!-- <th field="summary" sortable="true" width="100">Ringkas Regulasi</th> -->
			<th field="url" sortable="true" width="50">Link Download</th>		
			<!-- <th field="date_post" sortable="true" width="30">Tanggal Posting</th>		 -->
			<th field="published" sortable="true" hidden="true">Publikasikan</th>		
			<th field="published_label" sortable="true" width="25">Publikasikan</th>		
		</tr>
		</thead>  
	</table>

	<!-- Area untuk Form Add/Edit >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>  -->
	
	<div id="dlg<?=$objectId;?>" class="easyui-dialog" style="padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<!----------------Edit title-->
		<div id="ftitle<?=$objectId?>" class="ftitle">Add/Edit/View Data Regulasi Portal</div>
		<form id="fm<?=$objectId;?>" method="post">
			<div class="fitem">
				<label style="width:150px;vertical-align:top">Nomor Regulasi :</label>
				<input name="content_title" class="easyui-validatebox" size="50" required="true" id="content_title<?=$objectId;?>">
			</div>
			<div class="fitem">
				<label style="width:150px;vertical-align:top">Deskripsi :</label><br/>
				<div style="width:100%;  margin:10px 0"><textarea name="content" cols="70" class="easyui-validatebox" style="resize:none" id="content<?=$objectId;?>"></textarea></div>
				<?php echo display_ckeditor($ckeditor); ?>
			</div>
			<div class="fitem">
				<label style="width:150px;vertical-align:top">Link Download :</label>
				<input name="url" class="easyui-validatebox" size="40" id="url<?=$objectId;?>" readonly="readonly" onclick="openKCFinder(this)"
    tyle="width:600px;cursor:pointer">
    			<a href="#" id="browse<?=$objectId;?>" class="easyui-linkbutton" iconCls="icon-import" onclick='openKCFinder(document.getElementById("url<?=$objectId;?>"))'>Browse/Upload</a>
			</div>
			<div class="fitem">
				<label style="width:150px;vertical-align:top">Publikasikan :</label>
				<select name="published" id="published<?=$objectId;?>">
					<option value='1'>Ya</option>
					<option value='0'>Tidak</option>
				</select>
			</div>
		</form>
		<div id="dlg-buttons">
			<!----------------Edit title-->
			<a href="#" id="saveBtn<?=$objectId;?>" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveData<?=$objectId;?>()">Save</a>
			<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg<?=$objectId;?>').dialog('close')">Cancel</a>
		</div>
    </div>
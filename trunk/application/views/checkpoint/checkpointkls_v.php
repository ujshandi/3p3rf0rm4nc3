    
 <link rel="stylesheet" type="text/css" href="<?=base_url()?>/public/js/jQuery-File-Upload-8.6.0/css/jquery.fileupload-ui.css" />     
<script  type="text/javascript" src="<?=base_url()?>public/js/jQuery-File-Upload-8.6.0/js/jquery.fileupload.js" ></script>
<script type="text/javascript"  src="<?=base_url()?>public/js/jQuery-File-Upload-8.6.0/js/jquery.iframe-transport.js"></script>
<script  type="text/javascript" src="<?=base_url()?>public/js/jQuery-File-Upload-8.6.0/js/jquery.fileupload-ui.js" ></script>

        
	<script  type="text/javascript" >
				var idCheckpoint;
				var rowIndexDetail;

		$(function(){
			var wWidth = $(window).width();
			var wHeight = $(window).height();
			$("#dlg<?=$objectId;?>").css('width',wWidth);
			$("#dlg<?=$objectId;?>").css('height',wHeight);
			
			
			
			var url;
			newData<?=$objectId;?> = function (){  
				var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
				if (row){
					$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Add <?=$purpose?> Checkpoint Kementerian');  
					$('#fm<?=$objectId;?>').form('clear');  
					url = base_url+'checkpoint/checkpointkl/save';  
					$("#deskripsi_iku_kl<?=$objectId?>").val(row.deskripsi_iku_kl);
					$("#deskripsi_sasaran_kl<?=$objectId?>").val(row.deskripsi_sasaran_kl);
					$("#id_pk_kl<?=$objectId?>").val(row.id_pk_kl);
					$("#penanggungjawab<?=$objectId?>").val(row.nama_kl);
					$("#purpose<?=$objectId?>").val('<?=$purpose?>');
				}	
				//addTab("Add PK Kementerian", "checkpoint/checkpointkl/add");
			}
			//end newData 
			
			editData<?=$objectId;?> = function (editmode){
				var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
				var tr = jQuery('#dg<?=$objectId;?>').closest('tr.datagrid-row');
				$('#saveBtn<?=$objectId;?>').css("display",(editmode)?"":"none");
				//alert('row index parent'+tr.attr('datagrid-row-index'));
				//alert(idCheckpoint+"=idcheckpoint") ;
				if ((idCheckpoint ==null)||(idCheckpoint =='undefined')) return false;
			//	$('#dg<?=$objectId;?>').datagrid('options').queryParams.
				//alert($.url().param("parentIndex")+"Parent");
				//if (row){
					$.ajax({
					url:'<?=base_url()?>checkpoint/checkpointkl/getDataEdit/'+idCheckpoint,
					success:function(data){
						//alert(data);
						var data = eval('('+data+')');
							$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Edit <?=$purpose?> Checkpoint Kementerian');  
						$('#fm<?=$objectId;?>').form('clear');  
						url = base_url+'checkpoint/checkpointkl/save';  
						$("#deskripsi_iku_kl<?=$objectId?>").val(data.deskripsi_iku_kl);
						$("#deskripsi_sasaran_kl<?=$objectId?>").val(data.deskripsi_sasaran_kl);
						$("#id_pk_kl<?=$objectId?>").val(data.id_pk_kl);
						$("#id_checkpoint_kl<?=$objectId?>").val(data.id_checkpoint_kl);
						$("#penanggungjawab<?=$objectId?>").val(data.nama_kl);
						$("#kriteria<?=$objectId?>").val(data.kriteria);
						$("#unitkerja<?=$objectId?>").val(data.unit_kerja);
						$("#ukuran<?=$objectId?>").val(data.ukuran);
						$("#target<?=$objectId?>").val(data.target);
						$("#keterangan<?=$objectId?>").val(data.keterangan);
						$("#capaian<?=$objectId?>").val(data.capaian);
						$("#cmbPeriode<?=$objectId?>").val(data.periode);
						$("#purpose<?=$objectId?>").val('<?=$purpose?>');
					}});
					
				//}	
			}
			//end editData
			
			deleteData<?=$objectId;?> = function (){
				<? if ($this->session->userdata('unit_kerja_e1')=='-1'){?>				
					var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
					if ((idCheckpoint ==null)||(idCheckpoint =='undefined')) return false;
					$.ajax({
					url:'<?=base_url()?>checkpoint/checkpointkl/getDataEdit/'+idCheckpoint,
					success:function(data){
						var data = eval('('+data+')');
						if(confirm("Apakah yakin akan menghapus data " + '' + "?")){
							var response = '';
							$.ajax({ type: "GET",
									 url: base_url+'checkpoint/checkpointkl/delete/' + data.id_checkpoint_kl,
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
										//	$('#dg<?=$objectId;?>').datagrid('reload');
										$('#ddv<?=$objectId;?>-'+rowIndexDetail).datagrid('reload');
										} else {
											$.messager.show({
												title: 'Error',
												msg: response.msg
											});
										}
									 }
							});
						}
					}});
						
					
				<?} else { ?>	
					alert("Silahkan Login sebagai Superadmin");
				<?} ?>
			}
			//end deleteData 
			
			clearFilter<?=$objectId;?> = function (){
				$("#filter_tahun<?=$objectId;?>").val('');
				searchData<?=$objectId;?>();
			}
			
			//tipe 1=grid, 2=pdf, 3=excel
			getUrl<?=$objectId;?> = function (tipe){
				var filtahun = $("#filter_tahun<?=$objectId;?>").val();
				
				if(filtahun.length==0) filtahun ="-1";
				
				if (tipe==1){
					return "<?=base_url()?>checkpoint/checkpointkl/grid/"+filtahun;
				}
				else if (tipe==2){
					return "<?=base_url()?>checkpoint/checkpointkl/pdf/"+filtahun;
				}else if (tipe==3){
					return "<?=base_url()?>checkpoint/checkpointkl/excel/"+filtahun;
				}
				
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
		
			printData<?=$objectId;?>=function(){			
				//$.jqURL.loc(getUrl<?=$objectId;?>(2),{w:800,h:600,wintype:"_blank"});
			//window.open(getUrl<?=$objectId;?>(2));;
			alert("Sedang dalam pengerjaan");
		}
			toExcel<?=$objectId;?>=function(){
				alert("Sedang dalam pengerjaan");	
				//window.open(getUrl<?=$objectId;?>(3));;
			}
			
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
							/* $.messager.show({
								title: 'Success',
								msg: result.msg
							}); */
							$('#dlg<?=$objectId;?>').dialog('close');		// close the dialog
							//$('#dg<?=$objectId;?>').datagrid('reload');	// reload the user data
							$('#ddv<?=$objectId;?>-'+rowIndexDetail).datagrid('reload');
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
			
			formatPrice=function (val,row){
				return val;//($.fn.autoNumeric.Format("txtAmount"+idx,total,{aSep:".",aDec:",",mDec:2}));
				/* if (val < 20){
					return '<span style="color:red;">('+val+')</span>';
				} else {
					return val;
				} */
			}

			
			setTimeout(function(){
				searchData<?=$objectId;?>();
				//$('#dg<?=$objectId;?>').datagrid({url:"<?=base_url()?>checkpoint/checkpointkl/grid"});
			},0);
			
			
			
			$("#popdesc<?=$objectId?>").click(function(){
				closePopup('#popdesc<?=$objectId?>');
			});
			
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
		
		.btn-success {
		  background-color: #5BB75B;
		  background-image: linear-gradient(to bottom, #62C462, #51A351);
		  background-repeat: repeat-x;
		  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
		  color: #FFFFFF;
		  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
		}

		.btn {
		  -moz-border-bottom-colors: none;
		  -moz-border-left-colors: none;
		  -moz-border-right-colors: none;
		  -moz-border-top-colors: none;
		  border-image: none;
		  border-radius: 4px 4px 4px 4px;
		  border-style: solid;
		  border-width: 1px;
		  box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px rgba(0, 0, 0, 0.05);
		  cursor: pointer;
		  display: inline-block;
		  font-size: 14px;
		  line-height: 20px;
		  padding: 4px 12px;
		  text-align: center;
		  vertical-align: middle;
		}
	</style>
	
	<div id="tb<?=$objectId;?>" style="height:auto">
	   <table border="0" cellpadding="1" cellspacing="1" width="100%">
		<tr>
			<td>
			<div class="fsearch" <?=($this->session->userdata('unit_kerja_e1')=='-1'?'':'style="display:none"')?>>
				<table border="0" cellpadding="1" cellspacing="1">
				<tr>
					<td>Tahun :</td>
					<td>
					<?=$this->checkpointkl_model->getListFilterTahun($objectId)?>
					</td>
				</tr>
				<tr style="height:10px">
					  <td style="">
					  </td>
				</tr>
				<tr>
					<td align="right" colspan="2" valign="top">
						<a href="#" class="easyui-linkbutton" onclick="clearFilter<?=$objectId;?>();" iconCls="icon-reset">Reset</a>
						<a href="#" class="easyui-linkbutton" onclick="searchData<?=$objectId;?>();" iconCls="icon-search">Search</a>
					</td>
				</tr>
				</table>
			</div>
			</td>
		</tr>
		</table>
	  <div style="margin-bottom:5px">
	  <? if ($purpose=='Rencana') {?>
		<? if($this->sys_menu_model->cekAkses('ADD;',125,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="newData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-add" plain="true">Add</a>  
		<?}?>
	<?}?>
		<!------------Edit View-->
		<? if($this->sys_menu_model->cekAkses('EDIT;',125,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="editData<?=$objectId;?>(true);" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Edit</a>
		<?}?>
		<? if($this->sys_menu_model->cekAkses('VIEW;',125,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="editData<?=$objectId;?>(false);" class="easyui-linkbutton" iconCls="icon-view" plain="true">View</a>
		<?}?>
		<? if($this->sys_menu_model->cekAkses('DELETE;',125,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="deleteData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-remove" plain="true">Delete</a>
		<?}?>
		<!--
		<a href="#" onclick="printData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
		<a href="#" onclick="toExcel<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-excel" plain="true">Excel</a>
		-->
	  </div>
	</div>
	
	<table id="dg<?=$objectId;?>" class="easyui-datagrid" style="height:auto;width:auto"
	 title="Data Checkpoint Kementerian" toolbar="#tb<?=$objectId;?>" fitColumns="true" singleSelect="true" rownumbers="true" pagination="true">
	  <thead>
	  <tr>
		<th field="id_pk_kl" hidden="true" sortable="true" width="50px">Kode</th>
		<th field="tahun" sortable="true" width="30px">Tahun</th>		
		<th field="kode_kl" sortable="true" width="50px">Kode Kementerian</th>
		<th field="nama_kl" hidden="true">nama_kl</th>
		<th field="kode_sasaran_kl" sortable="true" width="50px">Kode Sasaran</th>
		<th field="kode_iku_kl" sortable="true" width="50px">Kode IKU</th>
		<th field="target" sortable="true" width="50px" align="right" formatter="formatPrice">Target (RKT)</th>
		<th field="penetapan" sortable="true" width="50px" align="right" formatter="formatPrice">Target (PK)</th>
		<th field="satuan" sortable="true" width="50px">Satuan</th>
		<th field="deskripsi_iku_kl" hidden="true">deskripsi_iku_kl</th>
		<th field="deskripsi_sasaran_kl" hidden="true">deskripsi_sasaran_kl</th>
	  </tr>
	  </thead>  
	</table>
	
	<!-- Area untuk Form Add/Edit >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>  -->
	
	<div id="dlg<?=$objectId;?>" class="easyui-dialog" style="padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<!----------------Edit title-->
		<!--<div id="ftitle<?=$objectId?>" class="ftitle">Add/Edit/View Rencana Checkpoint Kementerian</div> -->
		<form id="fm<?=$objectId;?>" method="post" enctype="multipart/form-data">
			
			<div class="fitem">
				<label style="width:130px">Sasaran Strategis:</label>					
					<textarea readonly name="deskripsi_sasaran_kl" id="deskripsi_sasaran_kl<?=$objectId?>" cols="70" class="easyui-validatebox" ></textarea>
				<input type="hidden" id="id_pk_kl<?=$objectId?>" name="id_pk_kl"/>
				<input type="hidden" id="id_checkpoint_kl<?=$objectId?>" name="id_checkpoint_kl"/>
				<input type="hidden" id="purpose<?=$objectId?>" name="purpose" value="<?=$purpose?>"/>
			</div>
			
			<div class="fitem">
				<label style="width:130px;vertical-align:top">IKU :</label>
				<textarea readonly name="deskripsi_iku_kl" id="deskripsi_iku_kl<?=$objectId?>" cols="70" class="easyui-validatebox" ></textarea>
			</div>
			<div class="fitem">
				<label style="width:130px;vertical-align:top">Penanggung Jawab :</label>
				<input readonly name="penanggungjawab"  id="penanggungjawab<?=$objectId?>" size="60" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label style="width:130px;vertical-align:top">Unit Kerja Terkait :</label>
				<input name="unitkerja" size="60" id="unitkerja<?=$objectId?>" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label style="width:130px;vertical-align:top">Kriteria Keberhasilan :</label>
				<input name="kriteria" size="60" id="kriteria<?=$objectId?>" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label style="width:130px;vertical-align:top">Ukuran Keberhasilan :</label>
				<input name="ukuran" size="60" id="ukuran<?=$objectId?>" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label style="width:130px;vertical-align:top">Periode :</label>
				<? echo $listPeriode;?>
			</div>
			<? if ($purpose=='Rencana') {?>
			<div class="fitem">
				<label style="width:130px;vertical-align:top">Target (%):</label>
				<input name="target" size="5" id="target<?=$objectId?>" class="easyui-validatebox">
			</div>
			<?} ?>
			<? if ($purpose=='Capaian') {?>
			<div class="fitem">
				<label style="width:130px;vertical-align:top">Target (%):</label>
				<input name="target" size="5" id="target<?=$objectId?>" readonly class="easyui-validatebox">
				&nbsp;&nbsp;Capaian (%):
				<input name="capaian" id="capaian<?=$objectId?>" size="5" class="easyui-validatebox">
			</div>
			<?} ?>
			<div class="fitem">
				<label style="width:130px;vertical-align:top">Keterangan :</label>
				<input name="keterangan" size="60" id="keterangan<?=$objectId?>" class="easyui-validatebox">
			</div>
			<!-- upload data pendukung -->
			<div class="fitem">
				<label style="width:130px;vertical-align:top">Data Pendukung :</label>
				  <!-- The fileinput-button span is used to style the file input field as button -->
					<span class="btn btn-success fileinput-button">
						<i class="icon-plus icon-white"></i>
						<span>Tambah file...</span>
						<!-- The file input field used as target for the file upload widget -->
						<input id="fileupload" type="file" name="files[]" multiple>
					</span>
					<br>
					<br>
					<!-- The global progress bar -->
					<div id="progress" class="progress progress-success progress-striped">
						<div class="bar"></div>
					</div>
					<!-- The container for the uploaded files -->
					<div id="files" class="files"></div>
					<br>
			</div>
			<!-- end upload data pendukung -->
			
		</form>
		<div id="dlg-buttons">
			<!----------------Edit title-->
			<a href="#" id="saveBtn<?=$objectId;?>" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveData<?=$objectId;?>()">Save</a>
			<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg<?=$objectId;?>').dialog('close')">Cancel</a>
		</div>
	</div>
	
	<script type="text/javascript">
        $(function(){
			var parentId;
			// chan
			$('#dg<?=$objectId;?>').datagrid({
				view: detailview,
				queryParams:{rowIdx:'0'},	
				 detailFormatter:function(index,row){
                    return '<div style="padding:2px"><table id="ddv<?=$objectId;?>-' + index + '"></table></div>';
                //  return "tes";
                },
                onExpandRow: function(index,row){
				//	alert(row.id_pk_kl);
						
                    $('#ddv<?=$objectId;?>-'+index).datagrid({
                        url:'<?=base_url()?>checkpoint/checkpointkl/griddetail/'+row.id_pk_kl+'/?parentIndex='+index,
                        fitColumns:true,
                        singleSelect:true,
                        rownumbers:true,
                        loadMsg:'',
                        height:'auto',
                        columns:[[
                            {field:'id_checkpoint_kl',title:'id',width:200,hidden:true},
                            {field:'unit_kerja',title:'Unit Kerja',width:200},
                            {field:'periode',title:'Periode',width:200},
                            {field:'kriteria',title:'Kriteria Capaian',width:200},
                            {field:'ukuran',title:'Ukuran Capaian',width:200},
                            {field:'target',title:'Target',width:100,align:'right'},
                            
                            
                            <? if ($purpose=='Capaian') {?>
								{field:'capaian',title:'Capaian',width:100,align:'right'},
                            <? }?>
                            {field:'keterangan',title:'Keterangan',width:200}
                            
                        ]],
                        onResize:function(){
                            $('#dg<?=$objectId;?>').datagrid('fixDetailRowHeight',index);
                        },
                       onClickCell:function(rowIndex, field, value){
							 $('#ddv<?=$objectId;?>-'+index).datagrid('selectRow', rowIndex);
							var row = $('#ddv<?=$objectId;?>-'+index).datagrid('getSelected');
							///alert(row);
							idCheckpoint = row.id_checkpoint_kl;
							rowIndexDetail = index;
							//alert("idcheckpoint"+idCheckpoint);
					   },
                        onLoadSuccess:function(){
                            setTimeout(function(){
                                $('#dg<?=$objectId;?>').datagrid('fixDetailRowHeight',index);
                            },0);
                        }
                    });
                    $('#dg<?=$objectId;?>').datagrid('fixDetailRowHeight',index);

	
                },
				onClickCell: function(rowIndex, field, value){
					$('#dg<?=$objectId;?>').datagrid('selectRow', rowIndex);
					
					var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
					idCheckpoint = null;
					//alert(row.deskripsi_iku_kl);
					switch(field){
						case "kode_kl":
							showPopup('#popdesc<?=$objectId?>', row.nama_kl);
							break;
						case "kode_sasaran_kl":
							showPopup('#popdesc<?=$objectId?>', row.deskripsi_sasaran_kl);
							break;
						case "kode_iku_kl":
							showPopup('#popdesc<?=$objectId?>', row.deskripsi_iku_kl);
							break;
						/* case "kode_kl":
							showPopup('#popdesc<?=$objectId?>', row.nama_kl);
							break; */
						default:
							closePopup('#popdesc<?=$objectId?>');
							break;
					}
				}
			});
			
			
            ;
        });
    </script>
    
     
 
	<div class="popdesc" id="popdesc<?=$objectId?>">pops</div>

 	
<script type="text/javascript" >
/*jslint unparam: true */
/*global window, $ */

$(function () {
    'use strict';

    // Change this to the location of your server-side upload handler:
    var url = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : 'server/php/';
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').text(file.name).appendTo('#files');
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script>

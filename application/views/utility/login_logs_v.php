	<script  type="text/javascript" >
		$(function(){
			var url;
			
			clearFilter<?=$objectId;?> = function (){
				$("#filter_tahun<?=$objectId;?>").val('');
				$("#unit<?=$objectId;?>").val('');
				$("#filter_e1<?=$objectId;?>").val('');
				$("#filter_e2<?=$objectId;?>").val('');
				searchData<?=$objectId;?>();
			}
			
			
			//tipe 1=grid, 2=pdf, 3=excel
			getUrl<?=$objectId;?> = function (tipe){
				var filawal =  $('#periode_awal<?=$objectId;?>').datebox('getValue');	
				var filakhir = $("#periode_akhir<?=$objectId;?>").datebox('getValue');	
				var file1 = $("#filter_e1<?=$objectId;?>").val();
				var file2 = $("#filter_e2<?=$objectId;?>").val();
				var unit = $("#unit<?=$objectId;?>").val();
				
				file1 = ((file1=="undefined")||(file1=="")||(file1==null))?"-1":file1;
				file2 = ((file2=="undefined")||(file2=="")||(file1==null))?"-1":file2;
				
				if (tipe==1){
					return "<?=base_url()?>utility/login_log/grid/"+filawal+"/"+filakhir+"/"+file1+"/"+file2;
				}
				else if (tipe==2){
					return "<?=base_url()?>utility/login_log/pdf/"+filawal+"/"+filakhir+"/"+file1+"/"+file2;
				}else if (tipe==3){
					return "<?=base_url()?>utility/login_log/excel/"+filawal+"/"+filakhir+"/"+file1+"/"+file2;
				}
			}
			
			
			searchData<?=$objectId;?> = function (){
				url = getUrl<?=$objectId;?>(1);
				
				
				$('#dg<?=$objectId;?>').datagrid({
					url:url					
				});
			}
			//end searhData 
			
			printData<?=$objectId;?>=function(){	
				//$.jqURL.loc(getUrl<?=$objectId;?>(2),{w:800,h:600,wintype:"_blank"});
				window.open(getUrl<?=$objectId;?>(2));;
			}
			toExcel<?=$objectId;?>=function(){
				window.open(getUrl<?=$objectId;?>(3));;
			}

			//initialize

			
			$("#filter_e1<?=$objectId;?>").change(function(){
				var unit = $("#unit<?=$objectId;?>").val();
				//if(unit=="E2"){
					$("#divUnitKerja<?=$objectId;?>").load(base_url+"rujukan/eselon2/loadFilterE2/"+$(this).val()+"/<?=$objectId;?>");
				//}
			});
			
			setTimeout(function(){
				url = getUrl<?=$objectId;?>(1);
				
				searchData<?=$objectId;?>();
				/* $('#dg<?=$objectId;?>').datagrid({
					url:url
					
				}); */
			},0);
			
			
			$("#popdesc<?=$objectId?>").click(function(){
				closePopup('#popdesc<?=$objectId?>');
			});
			
			
			$.fn.datebox.defaults.formatter = function(date){
					var y = date.getFullYear();
					var m = date.getMonth()+1;
					var d = date.getDate();
					return d+'-'+m+'-'+y;
			}
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
		<table border="0" cellpadding="1" cellspacing="1" width="100%">
			<tr>
				<td>
				<div class="fsearch">
					<table border="0" cellpadding="1" cellspacing="4"  width="100%">
					<tr>
						<td width="60px">Periode :</td>
						<td width="300px">
							<input name="periode_awal" value="<?=date('d-m-Y');?>" id="periode_awal<?=$objectId;?>" type="text" size="13" class="easyui-datebox" required="required"> &nbsp;&nbsp;s/d&nbsp;&nbsp;
							<input id="periode_akhir<?=$objectId;?>" name="periode_akhir" value="<?=date('d-m-Y');?>" type="text" size="13" class="easyui-datebox" required="required">
						</td>
						<td width="130px">Unit Kerja Eselon I :</td>
						<td>
							<?=$this->eselon1_model->getListFilterEselon1($objectId,$this->session->userdata('unit_kerja_e1'))?>
						</td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
						
						<td width="130px";>Unit Kerja Eselon II : </td>
						<td><span class="fitem" id="divUnitKerja<?=$objectId;?>">
							<?=$this->eselon2_model->getListFilterEselon2($objectId,$this->session->userdata('unit_kerja_e1'),$this->session->userdata('unit_kerja_e2'),true)?>
							</span>
						</td>
					</tr>
					
					<tr>
						<td align="left" colspan="4" valign="top">
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
			<!--<? if($this->sys_menu_model->cekAkses('PRINT;',556,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			
			<?}?>
			<? if($this->sys_menu_model->cekAkses('EXCEL;',556,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="toExcel<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-excel" plain="true">Excel</a>
			<?}?> -->
		</div>
	</div>
	
	<table id="dg<?=$objectId;?>" style="height:auto;width:auto" title="Data Login Log" toolbar="#tb<?=$objectId;?>" fitColumns="true" singleSelect="true" rownumbers="true" pagination="true">
	  <thead>
	  <tr>
		<th field="login_time" sortable="true" width="15">Login Time</th>
		<th field="ip" sortable="true" width="15">Ip Address</th>
		<th field="user_info" sortable="true" width="15" hidden="true">User Info</th>
		<th field="log_user_name" sortable="false" width="15">User Name</th>
		<th field="log_e1" sortable="false" width="15">Eselon I</th>
		<th field="log_e2" sortable="false" width="15">Eselon II</th>
	  </tr>
	  </thead>  
	</table>
	<div class="popdesc" id="popdesc<?=$objectId?>">indriyanto</div>

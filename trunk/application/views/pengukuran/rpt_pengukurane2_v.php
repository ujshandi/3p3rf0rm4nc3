	<script  type="text/javascript" >
		$(function(){
			var url;
			setIKK<?=$objectId;?>=function (valu){
				document.getElementById('kode_sasaran_e2<?=$objectId;?>').value = valu;

			}			
			clearFilter<?=$objectId;?> = function (){
				//ambil nilai-nilai filter
				$("#filter_tahun<?=$objectId;?>").val('');	
				$("#filter_e1<?=$objectId;?>").val('');	
				<? if ($this->session->userdata('unit_kerja_e1')!="-1") {?>
					setListE2<?=$objectId?>();
					
				<?} else {?>	
					$("#filter_e2<?=$objectId;?>").empty().append('<option value="-1">Semua</option>');			
				<? }?>
				$("#filter_sasaran<?=$objectId;?>").val('');			
				$("#kode_sasaran_e2<?=$objectId;?>").val('');			
				$("#filter_iku<?=$objectId;?>").val('');			
				filterSasaranE2<?=$objectId;?>($("#filter_e2<?=$objectId;?>").val());
			}
			function filterSasaranE2<?=$objectId;?>(e2){
				<? if ($this->session->userdata('unit_kerja_e2')!="-1") {?>
					e2 = "<?=$this->session->userdata('unit_kerja_e2');?>"
					
				<?}?>
				if(e2==null) e2="-1";
				var filtahun = $("#filter_tahun<?=$objectId;?>").val();
					if (filtahun == null) filtahun = "-1";
				$("#divSasaranE2<?=$objectId;?>").load(
					base_url+"pengaturan/sasaran_eselon2/getListSasaranE2/"+"<?=$objectId;?>"+"/"+e2+"/"+filtahun,
					//on complete
					function (){
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
			 $("#filter_e1<?=$objectId?>").change(function(){
				setListE2<?=$objectId?>();
			  });
			$("#filter_e2<?=$objectId;?>").change( function(){
				filterSasaranE2<?=$objectId;?>($(this).val());
			});
			
			
			function setListE2<?=$objectId?>(){
				<? if ($this->session->userdata('unit_kerja_e1')==-1){?>
					var file1 = $("#filter_e1<?=$objectId;?>").val();
				<?} else {?>
					var file1 = "<?=$this->session->userdata('unit_kerja_e1');?>";
				<?}?>
				$("#divEselon2<?=$objectId?>").load(
					base_url+"rujukan/eselon2/loadFilterE2/"+file1+"/<?=$objectId;?>",
					//on complete
					function (){
						//setSasaranE2<?=$objectId?>($("#kode_e2<?=$objectId?>").val());
						$("#filter_e2<?=$objectId?>").change(function(){
							filterSasaranE2<?=$objectId?>($(this).val());
						});	
						filterSasaranE2<?=$objectId?>($("#filter_e2<?=$objectId?>").val());
					}
				);
			 }
			//inisialisasi
			<? if ($this->session->userdata('unit_kerja_e2')!="-1") {?>
				filterSasaranE2<?=$objectId;?>('<?=$this->session->userdata('unit_kerja_e2');?>');
			<?} else {?>
				setListE2<?=$objectId?>();
				filterSasaranE2<?=$objectId;?>($("#filter_e2<?=$objectId;?>").val());
			<?}?>
			
			
				//tipe 1=grid, 2=pdf, 3=excel
			getUrl<?=$objectId;?> = function (tipe){
				//jika tipe pdf&excel kirim jg paging datanya agar sesuai dengan grid				
				var paging="";
				if ((tipe==2)||(tipe==3)){
					var page =  $('#dg<?=$objectId;?>').datagrid('options').pageNumber;
					var rows = $('#dg<?=$objectId;?>').datagrid('options').pageSize;
				//	alert(page);
					if (rows==null) rows = "-1";
					if (page==null) page = "-1";
					paging = "/"+page+"/"+rows;						
				}
			
					//ambil nilai-nilai filter
				var filtahun = $("#filter_tahun<?=$objectId;?>").val();
				var file1 = $("#filter_e1<?=$objectId;?>").val();
				<? if ($this->session->userdata('unit_kerja_e1')!="-1") {?>
					file1 = "<?=$this->session->userdata('unit_kerja_e1');?>"
					
				<?}?>
				var file2 = $("#filter_e2<?=$objectId;?>").val();
				
				<? if ($this->session->userdata('unit_kerja_e2')!="-1") {?>
					file2 = "<?=$this->session->userdata('unit_kerja_e2');?>"
					
				<?}?>
				var filsasaran = $("#kode_sasaran_e2<?=$objectId;?>").val();
				var filiku = $("#filter_iku<?=$objectId;?>").val();
				//encode parameter
				if ((filsasaran==null)||(filsasaran=="")) filsasaran = "-1";
				if(filtahun==null) filtahun ="-1";
				if (file2==null) file2 = "-1";
				if (file1==null) file1 = "-1";
				if (filiku==null) filiku = "-1";
				if (tipe==1){
					return "<?=base_url()?>pengukuran/rpt_pengukurane2/grid/"+filtahun+"/"+filsasaran+"/"+filiku+"/"+file1+"/"+file2;
				}
				else if (tipe==2){
					return "<?=base_url()?>pengukuran/rpt_pengukurane2/pdf/"+filtahun+"/"+filsasaran+"/"+filiku+"/"+file1+"/"+file2+paging;
				}else if (tipe==3){
					return "<?=base_url()?>pengukuran/rpt_pengukurane2/excel/"+filtahun+"/"+filsasaran+"/"+filiku+"/"+file1+"/"+file2+paging;
				}
				
			}
			
			searchData<?=$objectId;?> = function (){
			
				$('#dg<?=$objectId;?>').datagrid({
					url:getUrl<?=$objectId;?>(1),
					queryParams:{lastNo:'0'},	
					pageNumber : 1,
					onLoadSuccess:function(data){	
						$('#dg<?=$objectId;?>').datagrid('options').queryParams.lastNo = data.lastNo;
						var filtahun2="";
						var filtahun = $("#filter_tahun<?=$objectId;?>").val();
						if (filtahun==null)
						  filtahun="";
						  else{
							filtahun2 = filtahun - 1;
						  }
						$("#spanNow<?=$objectId?>").html("Tahun "+filtahun);
						$("#spanPast<?=$objectId?>").html("Tahun "+filtahun2);
						//prepareMerge<?=$objectId;?>(data);
					}});
			}
			//end searhData 
		
		
			printData<?=$objectId;?>=function(){			
				//$.jqURL.loc(getUrl<?=$objectId;?>(2),{w:800,h:600,wintype:"_blank"});
				window.open(getUrl<?=$objectId;?>(2));;
			}
			toExcel<?=$objectId;?>=function(){
				
				window.open(getUrl<?=$objectId;?>(3));;
			}
			
			
			
			formatPrice=function (val,row){
				return val;//($.fn.autoNumeric.Format("txtAmount"+idx,total,{aSep:".",aDec:",",mDec:2}));
				/* if (val < 20){
					return '<span style="color:red;">('+val+')</span>';
				} else {
					return val;
				} */
			}
			
		 setSasaran<?=$objectId;?> = function(valu){
				document.getElementById('kode_sasaran_e2<?=$objectId;?>').value = valu;
				getDetail<?=$objectId;?>();
			}
			
			prepareMerge<?=$objectId;?> = function(data){
				var  rows = data.rows;//$('#dg<?=$objectId;?>').datagrid('getRows');
				var merges = new Array();
				var sasaran = "";
				var idx=0;
				var rowSpan = 0;
				//alert(rows.length);
				for (var i=0;i<rows.length;i++){
					
					if (sasaran!=rows[i].sasaran_strategis){
						sasaran =rows[i].sasaran_strategis;
					//	alert(sasaran);
						if (i>0){
					//	alert("kadieu og gening");
							merges[idx] = new Array();
							merges[idx][0] =i-rowSpan-1;//index
							merges[idx][1] =rowSpan+1;//rowspan
							idx++;
							rowSpan =0;
						}
						else {
							//rowSpan++;
						}
						//alert(sasaran);
					}
					else{
						if (i==rows.length-1){
							//alert("kadieu tes");
							merges[idx] = new Array();
							merges[idx][0] =i-rowSpan-1;//index
							merges[idx][1] =rowSpan+2;//rowspan
							idx++;
							rowSpan =0;
						}	  
						rowSpan++;
					}
					/*  if (i==rows.length-1){
						//alert("kadieu tes");
						merges[idx] = new Array();
						merges[idx][0] =idx;//index
						merges[idx][1] =rowSpan;//rowspan
						idx++;
						rowSpan =0;
					}	  */
					
				}
				
				
				
				//alert(merges.length);
				for(var i=0; i<merges.length; i++){
						$('#dg<?=$objectId;?>').datagrid('mergeCells',{
							index:merges[i][0],
							field:'sasaran_strategis',
							rowspan:merges[i][1]
						});
						$('#dg<?=$objectId;?>').datagrid('mergeCells',{
							index:merges[i][0],
							field:'no',
							rowspan:merges[i][1]
						});
				}
				
				$('#dg<?=$objectId;?>').datagrid('mergeCells',{
							index:0,
							field:'program',
							rowspan:rows.length
				});
				
				
						
				/* $('#dg<?=$objectId;?>').datagrid('mergeCells',{
					index:1,
					field:'sasaran_strategis',
					rowspan:2
				}); */
			}
			

			
			setTimeout(function(){
				/* $('#dg<?=$objectId;?>').datagrid({
					url:"<?=base_url()?>pengukuran/rpt_pengukurane2/grid",
					queryParams:{lastNo:'0'},	
					onLoadSuccess:function(data){
						$('#dg<?=$objectId;?>').datagrid('options').queryParams.lastNo = data.lastNo;
						var filtahun = $("#filter_tahun<?=$objectId;?>").val();
						var filtahun2="";
						if (filtahun==null)
						  filtahun="";
						  else{
							filtahun2 = filtahun - 1;
						  }
						$("#spanNow<?=$objectId?>").html("Tahun "+filtahun);
						$("#spanPast<?=$objectId?>").html("Tahun "+filtahun2);
						//prepareMerge<?=$objectId;?>(data);
					}
				}
				); */
				searchData<?=$objectId;?>();
			},50);
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
		  <div class="fsearch" style="">
			<table border="0" cellpadding="1" cellspacing="1">
			<tr>
				<td>Tahun :</td>
				<td><?=$this->rpt_pengukurane2_model->getListTahun($objectId)?></td>
			</tr>	
			<tr>
				<td>Eselon I :</td>
				<td>
					<?=$this->eselon1_model->getListFilterEselon1($objectId,$this->session->userdata('unit_kerja_e1'))?>
				</td>
			</tr>
			<tr>
				<td>Eselon II :</td>
				<td><span class="fitem" id="divEselon2<?=$objectId;?>">
					<?=$this->eselon2_model->getListFilterEselon2($objectId,$this->session->userdata('unit_kerja_e1'),$this->session->userdata('unit_kerja_e2'))?>
					</span>
				</td>
			</tr>	
			<tr>
				<td>Sasaran :</td>
				<td>	<span id="divSasaranE2<?=$objectId;?>">
								<?= "";//chan,$this->rseselon1_model->getListSasaranE1($objectId)?>
							</span></td>
			</tr>
		<!--	
			<tr>
				<td>Kode IKU :</td>
				<td><input class="easyui-textbox" id="filter_iku<?=$objectId;?>"></td>
			</tr>-->
			<tr style="height:10px">
			  <td style="">
			  </td>
			</tr>
			<tr>			  
			  <td colspan="2" align="right">
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
			<? if($this->sys_menu_model->cekAkses('PRINT;',273,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a 	href="#" onclick="printData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
			<?}?>
			<? if($this->sys_menu_model->cekAkses('EXCEL;',273,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="toExcel<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-excel" plain="true">Excel</a>
			<?}?>
	  </div>
	</div>
	
	<table id="dg<?=$objectId;?>" class="easyui-datagrid" style="height:auto;width:auto" title="<?=$title?>" toolbar="#tb<?=$objectId;?>" fitColumns="true" singleSelect="true" rownumbers="false" pagination="true" nowrap="false" showFooter="true">
	  <thead>
	    <tr>
		
		<th field="no" sortable="false" rowspan="2" width="25px">No.</th>
		<th field="indikator_kinerja"  rowspan="2"  sortable="false" width="150px">Indikator Kinerja Utama</th>
		<th field="satuan" align="center" rowspan="2" sortable="false" width="80px">Satuan</th>
		<th align="center" colspan="3" sortable="false" ><span id="spanPast<?=$objectId?>">Tahun xxxx</span></th>
		<th align="center" colspan="3" sortable="false" ><span id="spanNow<?=$objectId?>">Tahun xxxx</span></th>
		<th field="keterangan" align="center" rowspan="2" sortable="false" width="80px">Keterangan</th>
		<th field="opini" align="center" rowspan="2" sortable="false" width="80px">Analisis</th>
		
	  </tr>
	  <tr>
			<th field="targetPast" align="right" rowspan="2" sortable="false" width="65px">Target</th>
			<th field="realisasiPast"  align="right" rowspan="2" sortable="false" width="65px">Realisasi</th>		
			<th field="persenPast"  align="right" rowspan="2" sortable="false" width="65px">%</th>	<th field="targetNow" align="right" rowspan="2" sortable="false" width="65px">Target</th>
			<th field="realisasiNow"  align="right" rowspan="2" sortable="false" width="65px">Realisasi</th>		
			<th field="persenNow"  align="right" rowspan="2" sortable="false" width="65px">%</th>		
	  </tr>
	  
	  </thead>  
	  
	</table>

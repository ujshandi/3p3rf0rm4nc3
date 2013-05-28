	<script  type="text/javascript" >
		$(function(){
			var url;
			setSasaran<?=$objectId;?>= function(valu){
				document.getElementById('kode_sasaran_kl<?=$objectId;?>').value = valu;				
			}
			
			clearFilter<?=$objectId;?> = function (){
				//ambil nilai-nilai filter
				$("#filter_tahun<?=$objectId;?>").val('');							
				$("#kode_sasaran_kl<?=$objectId;?>").val('');	
				$("#txtkode_sasaran_kl<?=$objectId;?>").val('-- Pilih --');						
				$("#filter_iku<?=$objectId;?>").val('');			
			}
			
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
				var filsasaran = $("#kode_sasaran_kl<?=$objectId;?>").val();
				var filiku = $("#filter_iku<?=$objectId;?>").val();
				var filstart = $("#cmbBulanStart<?=$objectId;?>").val();
				var filend = $("#cmbBulanEnd<?=$objectId;?>").val();
				
				if (filstart==null) filstart = "-1";
				if (filend==null) filend = "-1";
				//encode parameter
				
				if(filtahun==null) filtahun ="-1";
				if (filsasaran==null) filsasaran = "-1";
				if (filiku==null) filiku = "-1";
				
				if (tipe==1){
					return "<?=base_url()?>realisasi/rpt_capaian_kinerjakl/grid/"+filtahun+"/"+filsasaran+"/"+filiku+"/"+filstart+"/"+filend;
				}
				else if (tipe==2){
					return "<?=base_url()?>realisasi/rpt_capaian_kinerjakl/pdf/"+filtahun+"/"+filsasaran+"/"+filiku+"/"+filstart+"/"+filend+paging;
				}else if (tipe==3){
					return "<?=base_url()?>realisasi/rpt_capaian_kinerjakl/excel/"+filtahun+"/"+filsasaran+"/"+filiku+"/"+filstart+"/"+filend+paging;
				}
				
			}
			
			searchData<?=$objectId;?> = function (){
				var filstart = $("#cmbBulanStart<?=$objectId;?>").val();
				var filend = $("#cmbBulanEnd<?=$objectId;?>").val();				
				if (parseInt(filstart)>parseInt(filend)){
					alert("Periode Bulan tidak bisa diproses");
					return;
				}
				$('#dg<?=$objectId;?>').datagrid({
					url:getUrl<?=$objectId;?>(1),
					queryParams:{lastNo:'0'},	
					pageNumber : 1,
					onLoadSuccess:function(data){	
						$('#dg<?=$objectId;?>').datagrid('options').queryParams.lastNo = data.lastNo;
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
			setTimeout(function(){
			/* 	$('#dg<?=$objectId;?>').datagrid({
					url:"<?=base_url()?>realisasi/rpt_capaian_kinerjakl/grid",
					queryParams:{lastNo:'0'},	
					onLoadSuccess:function(data){
						$('#dg<?=$objectId;?>').datagrid('options').queryParams.lastNo = data.lastNo;
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
				<td><?=$this->rpt_capaian_kinerjakl_model->getListTahun($objectId)?></td>
			</tr>
			<tr>
				<td>Bulan dari :</td>
				<td><?=$this->utility->getBulan("","cmbBulanStart".$objectId)?></td>
				<td>Sampai dengan :</td>
				<td><?=$this->utility->getBulan((intval(date("m"))-1),"cmbBulanEnd".$objectId)?></td>
			</tr>	
			<!--<tr>
				<td>Sasaran :</td>
				<td><=$this->sasaran_kl_model->getListSasaranKL($objectId);?></td>
			</tr>			-->
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
			<? if($this->sys_menu_model->cekAkses('PRINT;',266,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a 	href="#" onclick="printData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
			<?}?>
			<? if($this->sys_menu_model->cekAkses('EXCEL;',266,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="toExcel<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-excel" plain="true">Excel</a>
			<?}?>
	  </div>
	</div>
	
	<table id="dg<?=$objectId;?>" class="easyui-datagrid" style="height:auto;width:auto" title="<?=$title?>" toolbar="#tb<?=$objectId;?>" fitColumns="true" singleSelect="true" rownumbers="false" pagination="true" nowrap="fa	lse" showFooter="true">
	  <thead>
	  <tr>
		
		<th field="no" sortable="false" rowspan="2" width="25px">No.</th>
		<th field="indikator_kinerja"  rowspan="2"  sortable="false" width="400px">Indikator Kinerja Utama</th>
		<th field="satuan" align="center" rowspan="2" sortable="false" width="100px">Satuan</th>
		<th field="target" align="right" rowspan="2" sortable="false" width="70px">Target</th>	
		<th   align="center" colspan="13" sortable="false" >Realisasi</th>		
	  </tr>
	  <tr>
		<th field="bulan1"  align="right"  sortable="false" width="90px">Jan</th>		
		<th field="bulan2"  align="right"  sortable="false" width="90px">Feb</th>		
		<th field="bulan3"  align="right"  sortable="false" width="90px">Mar</th>		
		<th field="bulan4"  align="right"  sortable="false" width="90px">Apr</th>		
		<th field="bulan5"  align="right"  sortable="false" width="90px">Mei</th>		
		<th field="bulan6"  align="right"  sortable="false" width="90px">Jun</th>		
		<th field="bulan7"  align="right"  sortable="false" width="90px">Jul</th>		
		<th field="bulan8"  align="right"  sortable="false" width="90px">Ags</th>		
		<th field="bulan9"  align="right"  sortable="false" width="90px">Sep</th>		
		<th field="bulan10"  align="right"  sortable="false" width="90px">Okt</th>		
		<th field="bulan11"  align="right"  sortable="false" width="90px">Nov</th>		
		<th field="bulan12"  align="right"  sortable="false" width="90px">Des</th>		
		<th field="persen"  align="right"  sortable="false" width="90px">%</th>		
	  </tr>
	  </thead>  
	  
	</table>

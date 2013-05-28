	<script  type="text/javascript" >
		$(function(){
			var url;
			setIKU<?=$objectId;?>=function (valu){
				document.getElementById('kode_sasaran_e1<?=$objectId;?>').value = valu;

			}
						
			function filterSasaranE1<?=$objectId;?>(e1){
				<? if ($this->session->userdata('unit_kerja_e1')!="-1") {?>
					e1 = "<?=$this->session->userdata('unit_kerja_e1');?>"
					
				<?}?>
				if (e1==null) e1="-1";
				$("#divSasaranE1<?=$objectId;?>").load(
					base_url+"pengaturan/sasaran_eselon1/getListSasaranE1/"+"<?=$objectId;?>"+"/"+e1,
					//on complete
					function (){
					
						if($("#drop<?=$objectId;?>").is(":visible")){
							$("#drop<?=$objectId;?>").slideUp("slow");
						}
						
						$("#txtkode_sasaran_e1<?=$objectId;?>").click(function(){
							$("#drop<?=$objectId;?>").slideDown("slow");
						});
						
						$("#drop<?=$objectId;?> li").click(function(e){
							var chose = $(this).text();
							$("#txtkode_sasaran_e1<?=$objectId;?>").text(chose);
							$("#drop<?=$objectId;?>").slideUp("slow");
						});
					}
					);
			}
			$("#filter_e1<?=$objectId;?>").change( function(){
				filterSasaranE1<?=$objectId;?>($(this).val());
			});
			
			//inisialisasi
			filterSasaranE1<?=$objectId;?>($("#kode_e1<?=$objectId;?>").val());
			
			clearFilter<?=$objectId;?> = function (){
				//ambil nilai-nilai filter
				$("#filter_tahun<?=$objectId;?>").val('');	
				//$("#filter_e1<?=$objectId;?>").val('');							
				$("#filter_apptype<?=$objectId;?>").val('');			
				//filterSasaranE1<?=$objectId;?>($("#kode_e1<?=$objectId;?>").val());
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
				var filapptype = $("#filter_apptype<?=$objectId;?>").val();
				var file1 = null;//$("#filter_e1<?=$objectId;?>").val();
				var file2 = null;//$("#filter_e1<?=$objectId;?>").val();
				var filstart = $("#cmbBulanStart<?=$objectId;?>").val();
				var filend = $("#cmbBulanEnd<?=$objectId;?>").val();
				
				if (filstart==null) filstart = "-1";
				if (filend==null) filend = "-1";
				
				<?// if ($this->session->userdata('unit_kerja_e1')!="-1") {?>
				//	file1 = "<?=$this->session->userdata('unit_kerja_e1');?>"
					
				<?//}?>
				
				//encode parameter
				
				
				if(filtahun==null) filtahun ="-1";
				
				if (file1==null) file1 = "-1";
				if (file2==null) file2 = "-1";
				
				
				if (tipe==1){
					return "<?=base_url()?>pengukuran/rpt_status_pengumpulan/grid/"+filtahun+"/"+filapptype+"/"+file1+"/"+file2+"/"+filstart+"/"+filend;
				}
				else if (tipe==2){
					return "<?=base_url()?>pengukuran/rpt_status_pengumpulan/pdf/"+filtahun+"/"+filapptype+"/"+file1+"/"+file2+"/"+filstart+"/"+filend+paging;
				}else if (tipe==3){
					return "<?=base_url()?>pengukuran/rpt_status_pengumpulan/excel/"+filtahun+"/"+filapptype+"/"+file1+"/"+file2+"/"+filstart+"/"+filend+paging;
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
					columns:[[
						{field:'deskripsi',title:'Unit Kerja', width:150, align:'left',
							styler: function(value,row,index){
								if (value =='K'){
									return 'background-color:red;';
								}else if (value =='L'){
									return 'background-color:green;';
								}else if (value =='TL'){
									return 'background-color:yellow;';
								}
							}
						},
						{field:'bulan1',title:'Jan', width:20, align:'center',
							styler: function(value,row,index){
								if (value =='K'){
									return 'background-color:red;';
								}else if (value =='L'){
									return 'background-color:green;';
								}else if (value =='TL'){
									return 'background-color:yellow;';
								}
							}
						},
						{field:'bulan2',title:'Feb', width:20, align:'center',
							styler: function(value,row,index){
								if (value =='K'){
									return 'background-color:red;';
								}else if (value =='L'){
									return 'background-color:green;';
								}else if (value =='TL'){
									return 'background-color:yellow;';
								}
							}
						}
						,
						{field:'bulan3',title:'Mar', width:20, align:'center',
							styler: function(value,row,index){
								if (value =='K'){
									return 'background-color:red;';
								}else if (value =='L'){
									return 'background-color:green;';
								}else if (value =='TL'){
									return 'background-color:yellow;';
								}
							}
						}
						,
						{field:'bulan4',title:'Apr', width:20, align:'center',
							styler: function(value,row,index){
								if (value =='K'){
									return 'background-color:red;';
								}else if (value =='L'){
									return 'background-color:green;';
								}else if (value =='TL'){
									return 'background-color:yellow;';
								}
							}
						}
						,
						{field:'bulan5',title:'Mei', width:20, align:'center',
							styler: function(value,row,index){
								if (value =='K'){
									return 'background-color:red;';
								}else if (value =='L'){
									return 'background-color:green;';
								}else if (value =='TL'){
									return 'background-color:yellow;';
								}
							}
						}
						,
						{field:'bulan6',title:'Jun', width:20, align:'center',
							styler: function(value,row,index){
								if (value =='K'){
									return 'background-color:red;';
								}else if (value =='L'){
									return 'background-color:green;';
								}else if (value =='TL'){
									return 'background-color:yellow;';
								}
							}
						}
						,
						{field:'bulan7',title:'Jul', width:20, align:'center',
							styler: function(value,row,index){
								if (value =='K'){
									return 'background-color:red;';
								}else if (value =='L'){
									return 'background-color:green;';
								}else if (value =='TL'){
									return 'background-color:yellow;';
								}
							}
						}
						,
						{field:'bulan8',title:'Ags', width:20, align:'center',
							styler: function(value,row,index){
								if (value =='K'){
									return 'background-color:red;';
								}else if (value =='L'){
									return 'background-color:green;';
								}else if (value =='TL'){
									return 'background-color:yellow;';
								}
							}
						}
						,
						{field:'bulan9',title:'Sept', width:20, align:'center',
							styler: function(value,row,index){
								if (value =='K'){
									return 'background-color:red;';
								}else if (value =='L'){
									return 'background-color:green;';
								}else if (value =='TL'){
									return 'background-color:yellow;';
								}
							}
						}
						,
						{field:'bulan10',title:'Okt', width:20, align:'center',
							styler: function(value,row,index){
								if (value =='K'){
									return 'background-color:red;';
								}else if (value =='L'){
									return 'background-color:green;';
								}else if (value =='TL'){
									return 'background-color:yellow;';
								}
							}
						}
						,
						{field:'bulan11',title:'Nov', width:20, align:'center',
							styler: function(value,row,index){
								if (value =='K'){
									return 'background-color:red;';
								}else if (value =='L'){
									return 'background-color:green;';
								}else if (value =='TL'){
									return 'background-color:yellow;';
								}
							}
						}
						,
						{field:'bulan12',title:'Des', width:20, align:'center',
							styler: function(value,row,index){
								if (value =='K'){
									return 'background-color:red;';
								}else if (value =='L'){
									return 'background-color:green;';
								}else if (value =='TL'){
									return 'background-color:yellow;';
								}
							}
						}
					]],
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
				// $('#dg<?=$objectId;?>').datagrid({
					// url:"<?=base_url()?>pengukuran/rpt_status_pengumpulan/grid",
					// queryParams:{lastNo:'0'},	
					// onLoadSuccess:function(data){
						// $('#dg<?=$objectId;?>').datagrid('options').queryParams.lastNo = data.lastNo;
						// var filtahun = $("#filter_tahun<?=$objectId;?>").val();
						// var filtahun2="";
						// if (filtahun==null)
						  // filtahun="";
						  // else{
							// filtahun2 = filtahun - 1;
						  // }
						// $("#spanNow<?=$objectId?>").html("Tahun "+filtahun);
						// $("#spanPast<?=$objectId?>").html("Tahun "+filtahun2);
						//prepareMerge<?=$objectId;?>(data);
					// }
				// }
				// );
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
				<td colspan="3"> <?=$this->rpt_status_pengumpulan_model->getListTahun($objectId)?></td>
			</tr>
			<tr>
				<td>Bulan dari :</td>
				<td><?=$this->utility->getBulan("","cmbBulanStart".$objectId)?></td>
				<td>Sampai dengan :</td>
				<td><?=$this->utility->getBulan((intval(date("m"))-1),"cmbBulanEnd".$objectId)?></td>
			</tr>			
			<tr>
				<td>Unit Kerja :</td>
				<td colspan="3"><?$this->user_model->getListGrupFilter($objectId,null,$this->session->userdata('level'),true,false)?></td>
			</tr>			
		<!--	
		  
		  
		
			<tr>
				<td>Unit Kerja Eselon I :</td>
				<td>
					<=$this->eselon1_model->getListFilterEselon1($objectId,$this->session->userdata('unit_kerja_e1'))?>
				</td>
			</tr>
			-->
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
		<td align="left" valign="top" width="150px">
			<fieldset>
				<legend>Legend :</legend>
				<table border="0" cellpadding="1" cellspacing="1">
					<tr>
						<td style="background-color:red">K&nbsp;&nbsp;= Kosong</td>
					</tr>	
					<tr>	
						<td style="background-color:yellow">TL&nbsp;= Tidak Lengkap
						</td>
					</tr>	
					<tr>	
						<td style="background-color:green">L&nbsp;&nbsp;= Lengkap
						</td>
					</tr>	
					
				</table>
				
			</fieldset>
		</td>
	  </tr>
	  </table>
	   <div style="margin-bottom:5px">  
			<? if($this->sys_menu_model->cekAkses('PRINT;',274,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a 	href="#" onclick="printData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
			<?}?>
			<? if($this->sys_menu_model->cekAkses('EXCEL;',274,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
				<a href="#" onclick="toExcel<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-excel" plain="true">Excel</a>
			<?}?>
	  </div>
	</div>
	
	<table id="dg<?=$objectId;?>" class="easyui-datagrid" style="height:auto;width:auto" title="<?=$title?>" toolbar="#tb<?=$objectId;?>" fitColumns="true" singleSelect="true" rownumbers="false" pagination="true" nowrap="fa	lse" showFooter="false">
	  <thead>
	   <tr>
		
		<th field="no" sortable="false" rowspan="2" width="25px">No.</th>
		<th field="deskripsi"  rowspan="2"  sortable="false" width="150px">Unit Kerja</th>
		
		<th align="center" colspan="12" sortable="false" ><span id="spanNow<?=$objectId?>">Tahun xxxx</span></th>
		
	  </tr>
	  <tr>
			
			<th field="bulan1" align="center" rowspan="2" sortable="false" width="65px">Januari</th>
			<th field="bulan2" align="center" rowspan="2" sortable="false" width="65px">Februari</th>
			<th field="bulan3" align="center" rowspan="2" sortable="false" width="65px">Maret</th>
			<th field="bulan4" align="center" rowspan="2" sortable="false" width="65px">April</th>
			<th field="bulan5" align="center" rowspan="2" sortable="false" width="65px">Mei</th>
			<th field="bulan6" align="center" rowspan="2" sortable="false" width="65px">Juni</th>
			<th field="bulan7" align="center" rowspan="2" sortable="false" width="65px">Juli</th>
			<th field="bulan8" align="center" rowspan="2" sortable="false" width="65px">Agustus</th>
			<th field="bulan9" align="center" rowspan="2" sortable="false" width="65px">September</th>
			<th field="bulan10" align="center" rowspan="2" sortable="false" width="65px">Oktober</th>
			<th field="bulan11" align="center" rowspan="2" sortable="false" width="65px">November</th>
			<th field="bulan12" align="center" rowspan="2" sortable="false" width="65px">Desember</th>
			
	  </tr>
	  
	  </thead>  
	  
	</table>

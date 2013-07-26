 <!--[if IE]><script language="javascript" type="text/javascript" src="<?=base_url()?>/public/admin/js/jqplot/excanvas.js"></script><![endif]-->
 
 <script language="javascript" type="text/javascript" src="<?=base_url()?>/public/admin/js/jqplot.1.0.8/jquery.jqplot.min.js"></script>
 <script language="javascript" type="text/javascript" src="<?=base_url()?>/public/admin/js/jqplot.1.0.8/plugins/jqplot.barRenderer.min.js"></script>
 <script language="javascript" type="text/javascript" src="<?=base_url()?>/public/admin/js/jqplot.1.0.8/plugins/jqplot.categoryAxisRenderer.min.js"></script>
 
  <script language="javascript" type="text/javascript" src="<?=base_url()?>/public/admin/js/jqplot.1.0.8/plugins/jqplot.canvasTextRenderer.min.js"></script>
 <script language="javascript" type="text/javascript" src="<?=base_url()?>/public/admin/js/jqplot.1.0.8/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
 <script language="javascript" type="text/javascript" src="<?=base_url()?>/public/admin/js/jqplot.1.0.8/plugins/jqplot.canvasOverlay.min.js"></script>

 <link rel="stylesheet" type="text/css" href="<?=base_url()?>/public/admin/js/jqplot.1.0.8/jquery.jqplot.css" />
	
<div id="tb<?=$objectId;?>" style="height:auto">
	  <table border="0" cellpadding="1" cellspacing="1" width="100%">
	  <tr>
		<td>
		  <div class="fsearch" style="">
			<table border="0" cellpadding="1" cellspacing="1">
			<tr>
				<td>Tahun :</td>
				<td><?=$this->sasaran_eselon1_model->getListFilterTahun($objectId,false)?></td>
			</tr>
				<tr  <?=($this->session->userdata('unit_kerja_e1')=='-1'?'':'style="display:none"')?>>
					<td>Unit Kerja Eselon I&nbsp</td>
					<td>
						<?=$this->eselon1_model->getListFilterEselon1($objectId,$this->session->userdata('unit_kerja_e1'),false)?>
					</td>
				</tr>
			<tr>
				<td>Sasaran :</td>
				<td><div id="divSasaranKL<?=$objectId?>"></div></td>
			</tr>
			
			<!--<tr>
				<td>Bulan dari :</td>
				<td><?=$this->utility->getBulan("","cmbBulanStart".$objectId)?></td>
				<td>Sampai dengan :</td>
				<td><?=$this->utility->getBulan((intval(date("m"))-1),"cmbBulanEnd".$objectId)?></td>
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
	  </tr>
	  </table>
	  
	
<div id="chartCapaianKL<?=$objectId?>" style="height:350px;width:350px;float:left"></div> 
<div  style="width:10px;float:left">&nbsp;</div> 
<table id="dg<?=$objectId;?>" class="easyui-datagrid" style="height:auto;width:auto" title="Data Capaian IKU Kementerian"  fitColumns="true" singleSelect="true" nowrap="false" rownumbers="true" pagination="true">
	  <thead>
	  <tr>
		<th field="deskripsi"   sortable="false" width="250">Deskripsi</th>
		<th field="satuan" align="left" sortable="false" width="100">Satuan</th>
		<th field="target" align="right"  sortable="false" width="70">Target</th>	
		<th field="realisasi" align="right"  sortable="false" width="70">Realisasi</th>	
		<th field="persen" align="right"  sortable="false" width="70">Persen</th>	
		
	  </tr>
	  </thead> 
	</table>
	<br/>

<script type="text/javascript">
//$.jqplot('chartdiv',  [[[1, 2],[3,5.12],[5,13.1],[7,33.6],[9,85.9],[11,219.9]]]);

$(document).ready(function(){
	
	$("#filter_tahun<?=$objectId;?>").change(function(){	
					<? if ($this->session->userdata('unit_kerja_e1')!='-1') {?>
				 e1 = '<?=$this->session->userdata('unit_kerja_e1');?>';
				 $("#filter_e1<?=$objectId;?>").val(e1);
				<?}?>		
				  getListSasaran<?=$objectId;?>($(this).val(),e1);
				
			});
	$("#filter_e1<?=$objectId;?>").change(function(){				
				  getListSasaran<?=$objectId;?>($("#filter_tahun<?=$objectId;?>").val(),$(this).val());
				
			});
			
	getListSasaran<?=$objectId?> = function (tahun,e1){
			<? if ($this->session->userdata('unit_kerja_e1')!='-1') {?>
				 e1 = '<?=$this->session->userdata('unit_kerja_e1');?>';
				 $("#filter_e1<?=$objectId;?>").val(e1);
				<?}?>
				
			if ((tahun==null)||(tahun=="")) tahun = "-1";
				$("#divSasaranKL<?=$objectId?>").load(
					base_url+"pengaturan/sasaran_eselon1/getListSasaranE1/"+"<?=$objectId;?>"+"/"+e1+"/"+tahun,
					function(){
						$("textarea").autogrow();
						if($("#drop<?=$objectId;?>").is(":visible")){
							$("#drop<?=$objectId;?>").slideUp("slow");
						}
						
						$("#txtkode_sasaran_e1<?=$objectId;?>").click(function(){
							$("#drop<?=$objectId;?>").slideDown("slow");
						});
						
						$("#drop<?=$objectId;?> li").click(function(e){
							var chose = $(this).text();
							$("#txtkode_sasaran_e1<?=$objectId;?>").text(chose);
						//	alert($("#txtkode_sasaran_e1<?=$objectId;?>").text());
							$("#drop<?=$objectId;?>").slideUp("slow");
						});
						
							
				
				
						
					}
				);
	};


	getListSasaran<?=$objectId;?>($("#filter_tahun<?=$objectId;?>").val(),$("#filter_e1<?=$objectId;?>").val());
	
	setSasaran<?=$objectId?> = function(kode){
		//do nothing
		$('#kode_sasaran_e1<?=$objectId;?>').val(kode);
		searchData<?=$objectId?>();
	}
	
	searchData<?=$objectId;?> = function (){
				var filstart = $("#cmbBulanStart<?=$objectId;?>").val();
				var filend = $("#cmbBulanEnd<?=$objectId;?>").val();				
				var filtahun = $("#filter_tahun<?=$objectId;?>").val();
				var sasaran = $("#kode_sasaran_e1<?=$objectId;?>").val();
				if(filtahun==null) filtahun ="-1";
				if(sasaran==null) sasaran ="-1";
				if (parseInt(filstart)>parseInt(filend)){
					alert("Periode Bulan tidak bisa diproses");
					return;
				}
				$('#chartCapaianKL<?=$objectId?>').empty();
				$('#dg<?=$objectId;?>').datagrid({
					url:"<?=base_url()?>dashboard/dsb_capaian_e1/grid/"+filtahun+"/"+sasaran,
					//queryParams:{lastNo:'0'},	
					pageNumber : 1,
					onLoadSuccess:function(data){	
				//		alert(data.pies);
				
				//start plot
//						alert(data.rows.length);
						var objArrayData=[];
						var objArrayData2=[];
						var ticks = [];    
						var obj = data.pies;
						var rata_rata = parseFloat(data.rata_rata);
						for (i=0;i<data.rows.length;i++){
								//alert(data.rows[i].deskripsi);
								objArrayData.push(parseFloat(data.rows[i].persen));
								objArrayData2.push(parseFloat(data.rows[i].persen100));
								ticks.push((i+1));
							}
						 $.each(obj, function(key, value) {
							//  alert(key + ' ' + value);
							  //objArrayData.push([key, parseFloat(value)]);
						//	  objArrayData.push(value);
						 });
						// alert(objArrayData);
						
						 var plotchartCapaianKL<?=$objectId?> = jQuery.jqplot ('chartCapaianKL<?=$objectId?>', [objArrayData],
							{
							  title: {
								text: '',   // title for the plot,
								show: true,
							},

//							   animate: !$.jqplot.use_excanvas,
							  gridPadding: {top:20, bottom:50, left:30, right:10},
								seriesDefaults:{
									renderer:$.jqplot.BarRenderer, 
									pointLabels: { show: true, location: 'e', edgeTolerance: -15 },
									rendererOptions: {
										dataLabels:'percent', 
										showDataLabels: true,
										barWidth: 10,
										 barDirection: 'horizontal'
										}
									
								},
								 canvasOverlay: {
								    show: true,
									objects: [{verticalLine: {
										name: 'barney',
										x: rata_rata,
										lineWidth: 6,
										color: 'orange',
										shadow: false
									}}]
								   },
								axes: { //model horizontal
									 yaxis: {
										renderer: $.jqplot.CategoryAxisRenderer
									}		
/*  kalo model vertival
									xaxis: {
										renderer: $.jqplot.CategoryAxisRenderer,
										ticks: ticks
									}
*/
								},
							 series:[
								{label:'Persentase Capaian'},{},
								{ 
										 disableStack : true,//otherwise it wil be added to values of previous series
								renderer: $.jqplot.LineRenderer,
								lineWidth: 2,
								pointLabels: {
									show: false
								},
								markerOptions: {
									size: 5
								}}
								
							//	{label:'Realisasi'},
								
							],	
							  legend:{
									show:false, 
									placement: 'outside', 
									rendererOptions: {
										numberRows: 2
									}, 
									location:'s',
									marginTop: '15px'
								},       
						//	seriesColors: [ "green","red"]	
							  //series:[{lineWidth:3, markerOptions:{style:'square'}}]		
							  					}); //end plot

						 
						 //jqplot-table-legend
						//$('#dg<?=$objectId;?>').datagrid('options').queryParams.lastNo = data.lastNo;
						//prepareMerge<?=$objectId;?>(data);
					}});
			}

/*
	$.jqplot.postDrawHooks.push(function() {   
			var labels = $('table.jqplot-table-legend tr td.jqplot-table-legend-label');
			 $(".jqplot-title").css('color',"#000000" );
			 labels.each(function(index) {
					$(this).css('color',"#000000" );
			 });      
	});
*/
  
  setTimeout(function(){
			searchData<?=$objectId;?>();
			},50);
});


</script>



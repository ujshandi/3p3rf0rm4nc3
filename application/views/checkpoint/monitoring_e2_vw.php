 <!--[if IE]><script language="javascript" type="text/javascript" src="<?=base_url()?>/public/admin/js/jqplot/excanvas.js"></script><![endif]-->
 
 <script language="javascript" type="text/javascript" src="<?=base_url()?>/public/admin/js/jqplot.1.0.8/jquery.jqplot.min.js"></script>
 <script language="javascript" type="text/javascript" src="<?=base_url()?>/public/admin/js/jqplot.1.0.8/plugins/jqplot.pieRenderer.min.js"></script>
 <!--<script language="javascript" type="text/javascript" src="<?=base_url()?>/public/admin/js/jqplot/plugins/jqplot.donutRenderer.min.js"></script>-->
 <link rel="stylesheet" type="text/css" href="<?=base_url()?>/public/admin/js/jqplot.1.0.8/jquery.jqplot.css" />
	
<div id="tb<?=$objectId;?>" style="height:auto">
	  <table border="0" cellpadding="1" cellspacing="1" width="100%">
	  <tr>
		<td>
		  <div class="fsearch" style="">
			<table border="0" cellpadding="1" cellspacing="1">
			<tr>
				<td>Tahun :</td>
				<td><?=$this->monitoring_e2_model->getListTahun($objectId)?></td>
			</tr>
			 	
			<tr>
				<td>Periode :</td>
				<td><?=$this->utility->getListCheckpoint("","cmbPeriode".$objectId)?></td>
			</tr>
			<tr style="height:10px">
			  <td style="">
			  </td>
			</tr>
			<tr>			  
			  <td colspan="2" align="right">
				
				<a href="#" class="easyui-linkbutton" onclick="searchData<?=$objectId;?>();" iconCls="icon-reload">Refresh</a>
			  </td>
			</tr>
			</table>
		  </div>
		</td>
	  </tr>
	  </table>
	  
	
<div>
<div id="chart1<?=$objectId?>" style="height:350px;width:350px;float:left;color:#FFFFFF"> </div> 
<div  style="width:10px;float:left">&nbsp;</div>

<table id="dg<?=$objectId;?>" class="easyui-datagrid" style="height:auto;width:auto" title="Data Monitoring Checkpoint Eselon I"  fitColumns="false" singleSelect="true" nowrap="false" rownumbers="true" pagination="true">
	  <thead>
	  <tr>
		<th field="tahun" sortable="false" width="45">Tahun</th>
		<th field="kode_e2"   sortable="false" width="50">Kode</th>
		<th field="nama_e2" align="left" sortable="false" width="200">Nama Unit Kerja</th>
		<th field="jml_iku" align="right"  sortable="false" width="50">Jml.Iku</th>	
		<th field="sangat_puas" align="center"  sortable="false" width="75">Sangat <br> Memuaskan</th>	
		<th field="puas" align="center"  sortable="false" width="75">Memuaskan</th>	
		<th field="kurang_puas" align="center"  sortable="false" width="75">Kurang <br>Memuaskan</th>	
		<th field="kecewa" align="center"  sortable="false" width="90">Mengecewakan</th>	
	  </tr>
	  
	  </thead> 
	</table>
</div>	

<script type="text/javascript">
//$.jqplot('chartdiv',  [[[1, 2],[3,5.12],[5,13.1],[7,33.6],[9,85.9],[11,219.9]]]);

$(document).ready(function(){
	

	searchData<?=$objectId;?> = function (){
		
				//inisialisasi jqplot
						
						 var objArrayData=[];
						  objArrayData.push(["Sangat Memuaskan", parseFloat(0)]);
						  objArrayData.push(["Memuaskan", parseFloat(0)]);
						  objArrayData.push(["Kurang Memuaskan", parseFloat(0)]);
						  objArrayData.push(["Mengecewakan", parseFloat(0)]);
						  var plot1 = jQuery.jqplot ('chart1<?=$objectId?>', [objArrayData],
							{
							  gridPadding: {top:0, bottom:38, left:10, right:0},
							seriesDefaults:{
								renderer:$.jqplot.PieRenderer, 
								trendline:{ show:false }, 
								rendererOptions: { padding: 8, dataLabels:"percent",showDataLabels: true,dataLabelFormatString:'%.2f%' }
							},
							  legend:{
									show:true, 
									placement: 'outside', 
									rendererOptions: {
										numberRows: 1
									}, 
									location:'s',
									marginTop: '15px'
								},    
								seriesColors: [ "blue","green","orange","red"],   
							  series:[{lineWidth:3, markerOptions:{style:'square'}}]
							}); //end inisialisasijqplot
							
							
				var filstart = $("#cmbBulanStart<?=$objectId;?>").val();
				var filend = $("#cmbBulanEnd<?=$objectId;?>").val();				
				var filtahun = $("#filter_tahun<?=$objectId;?>").val();
				var filperiode = $("#cmbPeriode<?=$objectId;?>").val();
				if(filtahun==null) filtahun ="-1";
				if(filperiode==null) filperiode ="-1";
				if (parseInt(filstart)>parseInt(filend)){
					alert("Periode Bulan tidak bisa diproses");
					return;
				}
				$('#dg<?=$objectId;?>').datagrid({
					url:"<?=base_url()?>checkpoint/monitoring_e2/grid/"+filtahun+"/"+filperiode,
					//queryParams:{lastNo:'0'},	
					pageNumber : 1,
					onClickRow:function(rowIndex, rowData){
						var row = rowData;//$('#dg<?=$objectId;?>').datagrid('getSelected');
						//start jqplot
						
						 var objArrayData=[];
						  objArrayData.push(["Sangat Memuaskan", parseFloat(row.sangat_puas)]);
						  objArrayData.push(["Memuaskan", parseFloat(row.puas)]);
						  objArrayData.push(["Kurang Memuaskan", parseFloat(row.kurang_puas)]);
						  objArrayData.push(["Mengecewakan", parseFloat(row.kecewa)]);
						  var plot1 = jQuery.jqplot ('chart1<?=$objectId?>', [objArrayData],
							{
							  gridPadding: {top:0, bottom:38, left:10, right:0},
							seriesDefaults:{
								renderer:$.jqplot.PieRenderer, 
								trendline:{ show:false }, 
								rendererOptions: { padding: 8, dataLabels:"percent",showDataLabels: true,dataLabelFormatString:'%.2f%' }
							},
							  legend:{
									show:true, 
									placement: 'outside', 
									rendererOptions: {
										numberRows: 1
									}, 
									location:'s',
									marginTop: '15px'
								},    
								seriesColors: [ "blue","green","orange","red"],      
							  series:[{lineWidth:3, markerOptions:{style:'square'}}]
							}); //end jqplot
							
						  
					},//end onclickRow
					onLoadSuccess:function(data){	
						 var objArrayData=[];
						 var objArrayData2=[];
						var objArray = [];    
/*
								var obj = data.pies.tercapai;
								var obj2 = data.pies.tdk_tercapai;
								
								 $.each(obj, function(key, value) {								
									  objArrayData.push([key, parseFloat(value)]);
								 });
								 $.each(obj2, function(key, value) {
									  objArrayData2.push([key, parseFloat(value)]);
								 });
*/
								 
/*
								 var plot1 = jQuery.jqplot ('chart1<?=$objectId?>', [objArrayData,objArrayData2],
									{
									  gridPadding: {top:0, bottom:38, left:0, right:0},
					seriesDefaults:{
						renderer:$.jqplot.DonutRenderer, 
						//trendline:{ show:false }, 
						rendererOptions: { sliceMargin:3, showDataLabels: true,startAngle:-90,dataLabels:value }
					},
									  legend:{
											show:true, 
											placement: 'outside', 
											rendererOptions: {
												numberRows: 1
											}, 
											location:'s',
											marginTop: '15px'
										},       
									  //series:[{lineWidth:3, markerOptions:{style:'square'}}]
									}    
								  );//end plot
*/
					}});
			}

			$.jqplot.postDrawHooks.push(function() {   
			var labels = $('table.jqplot-table-legend tr td.jqplot-table-legend-label');
			 //alert(labels);
			 //$(labels)..css('color',"#000000" );
			 labels.each(function(index) {
					//turn the label's text color to the swatch's color
					//var color = $(swatches[index]).find("div div").css('background-color');
					$(this).css('color',"#000000" );
				//	alert('here');
			 });      
	});
	
	
  setTimeout(function(){
			searchData<?=$objectId;?>();
				

			},50);
});


</script>



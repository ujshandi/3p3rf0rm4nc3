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
				<td><?=$this->dsb_capaian_e1_model->getListTahun($objectId)?></td>
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

<table id="dg<?=$objectId;?>" class="easyui-datagrid" style="height:auto;width:auto" title="Data Kinerja Eselon I"  fitColumns="true" singleSelect="true" rownumbers="true" pagination="true">
	  <thead>
	  <tr>
		<th field="tahun" sortable="false" width="60">Tahun</th>
		<th field="kode_e1"   sortable="false" width="50">Kode E1</th>
		<th field="nama_e1" align="left" sortable="false" width="200">Nama Eselon 1</th>
		<th field="jml_iku" align="right"  sortable="false" width="70">Jml.Iku</th>	
		<th field="tercapai" align="right"  sortable="false" width="70">Tercapai</th>	
		<th field="tdk_tercapai" align="right"  sortable="false" width="70">Tdk. Tercapai</th>	
	  </tr>
	  </thead> 
	</table>
</div>	
<div   style="width:10px;float:left;display:none"><input type="button" value="View Image"/></div>
<script type="text/javascript">
//$.jqplot('chartdiv',  [[[1, 2],[3,5.12],[5,13.1],[7,33.6],[9,85.9],[11,219.9]]]);

$(document).ready(function(){
	

	searchData<?=$objectId;?> = function (){
				var filstart = $("#cmbBulanStart<?=$objectId;?>").val();
				var filend = $("#cmbBulanEnd<?=$objectId;?>").val();				
				var filtahun = $("#filter_tahun<?=$objectId;?>").val();
				if(filtahun==null) filtahun ="-1";
				if (parseInt(filstart)>parseInt(filend)){
					alert("Periode Bulan tidak bisa diproses");
					return;
				}
				$('#dg<?=$objectId;?>').datagrid({
					url:"<?=base_url()?>dashboard/dsb_capaian_e1/grid/"+filtahun,
					//queryParams:{lastNo:'0'},	
					pageNumber : 1,
					onClickRow:function(rowIndex, rowData){
						var row = rowData;//$('#dg<?=$objectId;?>').datagrid('getSelected');
						 var objArrayData=[];
						  objArrayData.push(["Tercapai", parseFloat(row.tercapai)]);
						  objArrayData.push(["Tidak Tercapai", parseFloat(row.tdk_tercapai)]);
						  var plot1 = jQuery.jqplot ('chart1<?=$objectId?>', [objArrayData],
							{
							  	seriesColors: [ "green","red"]	,
							  gridPadding: {top:0, bottom:38, left:0, right:0},
							seriesDefaults:{
								renderer:$.jqplot.PieRenderer, 
								trendline:{ show:false }, 
								rendererOptions: { padding: 8, showDataLabels: true }
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
											
										//	  series:[{lineWidth:3, markerOptions:{style:'square'}}]
											}    
										  );
							
						  
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



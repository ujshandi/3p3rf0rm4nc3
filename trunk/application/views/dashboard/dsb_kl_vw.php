 <!--[if IE]><script language="javascript" type="text/javascript" src="<?=base_url()?>/public/admin/js/jqplot/excanvas.js"></script><![endif]-->
 
 <script language="javascript" type="text/javascript" src="<?=base_url()?>/public/admin/js/jqplot.1.0.8/jquery.jqplot.min.js"></script>
 <script language="javascript" type="text/javascript" src="<?=base_url()?>/public/admin/js/jqplot.1.0.8/plugins/jqplot.pieRenderer.min.js"></script>
 <link rel="stylesheet" type="text/css" href="<?=base_url()?>/public/admin/js/jqplot.1.0.8/jquery.jqplot.css" />
	
<div id="tb<?=$objectId;?>" style="height:auto">
	  <table border="0" cellpadding="1" cellspacing="1" width="100%">
	  <tr>
		<td>
		  <div class="fsearch" style="">
			<table border="0" cellpadding="1" cellspacing="1">
			<tr>
				<td>Tahun :</td>
				<td><?=$this->dsb_kl_model->getListTahun($objectId)?></td>
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
	  
	
<div id="chartKinerjaKl<?=$objectId?>" style="height:350px;width:350px;float:left;color:#FFFFFF"></div> 
<div  style="width:10px;float:left">&nbsp;</div> 
<table id="dg<?=$objectId;?>" class="easyui-datagrid" style="height:auto;width:auto" title="Data Capaian IKU Kementerian"  fitColumns="true" singleSelect="true" rownumbers="true" pagination="true">
	  <thead>
	  <tr>

		<th field="deskripsi"   sortable="false" width="250">Deskripsi</th>
		<th field="satuan" align="left" sortable="false" width="100">Satuan</th>
		<th field="persen" align="right"  sortable="false" width="70">% Capaian</th>	
		<th field="status" align="right"  sortable="false" width="70" styler='cellStyler'>Status</th>	
		
	  </tr>
	  </thead> 
	</table>

<script type="text/javascript">
//$.jqplot('chartdiv',  [[[1, 2],[3,5.12],[5,13.1],[7,33.6],[9,85.9],[11,219.9]]]);
 function cellStyler(value,row,index){
            if (value >= 100){
                return 'background-color:green;color:green;';
            }
            else
				return 'background-color:red;color:red;';
        }
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
					url:"<?=base_url()?>dashboard/dsb_kl/grid/"+filtahun,
					//queryParams:{lastNo:'0'},	
					pageNumber : 1,
					onLoadSuccess:function(data){	
				//		alert(data.pies);
						 var objArrayData=[];
                var objArray = [];    
						var obj = data.pies;
						 $.each(obj, function(key, value) {
							//   alert(key + ' ' + value);
							  objArrayData.push([key, parseFloat(value)]);
						 });
						// alert(objArrayData);
						 var plot1 = jQuery.jqplot ('chartKinerjaKl<?=$objectId?>', [objArrayData],
							{
							  gridPadding: {top:0, bottom:38, left:10, right:0},
							  animate: !$.jqplot.use_excanvas,
								seriesDefaults:{
									renderer:$.jqplot.PieRenderer, 
									//trendline:{ show:false }, 
									rendererOptions: {
										dataLabels:'percent', 
										showDataLabels: true,
										//dataLabelCenterOn:true,
										//dataLabelPositionFactor:0.5 
										}
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
								seriesColors: [ "green","red"]	
							  //series:[{lineWidth:3, markerOptions:{style:'square'}}]
							}    
						  );
						 
						 
						//$('#dg<?=$objectId;?>').datagrid('options').queryParams.lastNo = data.lastNo;
						//prepareMerge<?=$objectId;?>(data);
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



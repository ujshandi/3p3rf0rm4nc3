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
				<td><?=$this->dsb_e1_model->getListTahun($objectId)?></td>
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
<div id="chartKinerjaE1<?=$objectId?>" style="height:350px;width:350px;float:left;color:#FFFFFF"> </div> 
<div  style="width:10px;float:left">&nbsp;</div>

<table id="dg<?=$objectId;?>" class="easyui-datagrid" style="height:auto;width:auto" title="Data Capaian IKU Eselon I"  fitColumns="true" singleSelect="true" rownumbers="true" pagination="true">
	  <thead>
	  <tr>
		<th field="kode_e1" sortable="true" width="20">Kode Unit Kerja</th>		
		<th field="nama_e1" sortable="true" width="90">Nama Unit Kerja</th>
		<!--<th field="deskripsi"   sortable="false" width="250">Deskripsi</th>
		<th field="satuan" align="left" sortable="false" width="100">Satuan</th>
		<th field="persen" align="right"  sortable="false" width="70">% Capaian</th>	
		<th field="status" align="right"  sortable="false" width="70" styler='cellStyler'>Status</th>	
		-->
	  </tr>
	  </thead> 
	</table>
</div>	
<div   style="width:10px;float:left;display:none"><input type="button" value="View Image"/></div>
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
			//inisialiasi jqplot
			$('#chartKinerjaE1<?=$objectId?>').empty();
			  var objArrayData=[];
						  // alert(row.tercapai);
						//start jqplot
						  objArrayData.push(["Jumlah Memenuhi", 0]);
						  objArrayData.push(["Jumlah Tidak Memenuhi", 0]);
			jQuery.jqplot ('chartKinerjaE1<?=$objectId?>', [objArrayData],{
							  	seriesColors: [ "green","red"]	,
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
							
										
						});
			
			//end inisialisasi jqplot
				var filstart = $("#cmbBulanStart<?=$objectId;?>").val();
				var filend = $("#cmbBulanEnd<?=$objectId;?>").val();				
				var filtahun = $("#filter_tahun<?=$objectId;?>").val();
				if(filtahun==null) filtahun ="-1";
				if (parseInt(filstart)>parseInt(filend)){
					alert("Periode Bulan tidak bisa diproses");
					return;
				}
				$('#dg<?=$objectId;?>').datagrid({
					
					url:"<?=base_url()?>dashboard/dsb_e1/gride1/"+filtahun,
					//queryParams:{lastNo:'0'},	
					pageNumber : 1,
						view: detailview,
					 detailFormatter:function(index,row){
                    return '<div style="padding:2px"><table id="ddv<?=$objectId;?>-' + index + '"></table></div>';
                //  return "tes";
                },
					 onExpandRow: function(index,row){
				//	alert(row.id_pk_e1);
						//var row = rowData;
						 
						
                    $('#ddv<?=$objectId;?>-'+index).datagrid({
                        url:'<?=base_url()?>dashboard/dsb_e1/grid/'+filtahun+'/'+row.kode_e1+'/?parentIndex='+index,
                        fitColumns:true,
                        singleSelect:true,
                        rownumbers:true,
                        loadMsg:'',
                        height:'auto',
                        columns:[[
                            
                            {field:'deskripsi',title:'Deskripsi',width:200},
                            {field:'satuan',title:'Satuan',width:100},
                            {field:'persen',title:'% Capaian',width:70,align:'right'},
                            {field:'status',title:'Status',width:70,styler:cellStyler},
                            
                        ]],
                        onResize:function(){
                            $('#dg<?=$objectId;?>').datagrid('fixDetailRowHeight',index);
                        },
                       onClickCell:function(rowIndex, field, value){
							
							//alert(idCheckpoint);
					   },
                        onLoadSuccess:function(){
                            setTimeout(function(){
                                $('#dg<?=$objectId;?>').datagrid('fixDetailRowHeight',index);
                            },0);
                        }
                    });
                    $('#dg<?=$objectId;?>').datagrid('fixDetailRowHeight',index);

	
                },
					onClickRow:function(rowIndex, rowData){
						var row = rowData;//$('#dg<?=$objectId;?>').datagrid('getSelected');
						 var objArrayData=[];
						  var objArrayData=[];
						  // alert(row.tercapai);
						//start jqplot
						  objArrayData.push(["Jumlah Memenuhi", parseFloat(row.tercapai)]);
						  objArrayData.push(["Jumlah Tidak Memenuhi", parseFloat(row.tdk_tercapai)]);
						  var plot1 = jQuery.jqplot ('chartKinerjaE1<?=$objectId?>', [objArrayData],
							{
							  	seriesColors: [ "green","red"]	,
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
							
										
						}); //end jqplot

						  
					},//end onclickRow
					onLoadSuccess:function(data){	
						 var objArrayData=[];
						 var objArrayData2=[];
						var objArray = [];   
/*
						
*/
						 
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



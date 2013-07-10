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
				<td><?=$this->sasaran_kl_model->getListFilterTahun($objectId,false)?></td>
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
	  
	
<div id="chart1<?=$objectId?>" style="height:350px;width:350px;float:left;color:#FFFFFF"></div> 
<div  style="width:10px;float:left">&nbsp;</div> 
<table id="dg<?=$objectId;?>" class="easyui-datagrid" style="height:auto;width:auto" title="Data Kinerja Kementerian"  fitColumns="true" singleSelect="true" rownumbers="true" pagination="true">
	  <thead>
	  <tr>
		<th field="tahun" sortable="false" width="60">Tahun</th>
		<th field="kode_kl"   sortable="false" width="50">Kode KL</th>
		<th field="nama_kl" align="left" sortable="false" width="200">Nama KL</th>
		<th field="jml_iku" align="right"  sortable="false" width="70">Jml.Iku</th>	
		<th field="tercapai" align="right"  sortable="false" width="70">Memenuhi</th>	
		<th field="tdk_tercapai" align="right"  sortable="false" width="70">Tdk. Memenuhi</th>	
	  </tr>
	  </thead> 
	</table>
	<br/>

<script type="text/javascript">
//$.jqplot('chartdiv',  [[[1, 2],[3,5.12],[5,13.1],[7,33.6],[9,85.9],[11,219.9]]]);

$(document).ready(function(){
	
	$("#filter_tahun<?=$objectId;?>").change(function(){				
				  getListSasaran<?=$objectId;?>($(this).val());
				
			});
			
	getListSasaran<?=$objectId?> = function (tahun){
		if ((tahun==null)||(tahun=="")) tahun = "-1";
				$("#divSasaranKL<?=$objectId?>").load(
					base_url+"pengaturan/sasaran_eselon1/getListSasaranKL/"+"<?=$objectId;?>"+"/"+tahun,
					function(){
						$("textarea").autogrow();
						if($("#drop<?=$objectId;?>").is(":visible")){
							$("#drop<?=$objectId;?>").slideUp("slow");
						}
						
						$("#txtkode_sasaran_kl<?=$objectId;?>").click(function(){
							$("#drop<?=$objectId;?>").slideDown("slow");
						});
						
						$("#drop<?=$objectId;?> li").click(function(e){
							var chose = $(this).text();
							$("#txtkode_sasaran_kl<?=$objectId;?>").text(chose);
						//	alert($("#txtkode_sasaran_kl<?=$objectId;?>").text());
							$("#drop<?=$objectId;?>").slideUp("slow");
						});
						
							
				
				
						
					}
				);
	};


	getListSasaran<?=$objectId;?>($("#filter_tahun<?=$objectId;?>").val());
	
	setSasaran<?=$objectId?> = function(kode){
		//do nothing
		$('#kode_sasaran_kl<?=$objectId;?>').val(kode);
		searchData<?=$objectId?>();
	}
	
	searchData<?=$objectId;?> = function (){
				var filstart = $("#cmbBulanStart<?=$objectId;?>").val();
				var filend = $("#cmbBulanEnd<?=$objectId;?>").val();				
				var filtahun = $("#filter_tahun<?=$objectId;?>").val();
				var sasaran = $("#kode_sasaran_kl<?=$objectId;?>").val();
				if(filtahun==null) filtahun ="-1";
				if(sasaran==null) sasaran ="-1";
				if (parseInt(filstart)>parseInt(filend)){
					alert("Periode Bulan tidak bisa diproses");
					return;
				}
				$('#dg<?=$objectId;?>').datagrid({
					url:"<?=base_url()?>dashboard/dsb_capaian_kl/grid/"+filtahun+"/"+sasaran,
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
						 var plot1 = jQuery.jqplot ('chart1<?=$objectId?>', [objArrayData],
							{
							  title: {
								text: 'Analisis Per Sasaran',   // title for the plot,
								show: true,
							},

							  
							  gridPadding: {top:20, bottom:38, left:5, right:0},
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
						 
						 //jqplot-table-legend
						//$('#dg<?=$objectId;?>').datagrid('options').queryParams.lastNo = data.lastNo;
						//prepareMerge<?=$objectId;?>(data);
					}});
			}

	$.jqplot.postDrawHooks.push(function() {   
			var labels = $('table.jqplot-table-legend tr td.jqplot-table-legend-label');
			 //alert(labels);
			 $(".jqplot-title").css('color',"#000000" );
			 //$(labels)..css('color',"#000000" );
			 labels.each(function(index) {
					//turn the label's text color to the swatch's color
					//var color = $(swatches[index]).find("div div").css('background-color');
					$(this).css('color',"#000000" );
				//	alert('here');
			 });      
	});
			//jqplot-table-legend jqplot-table-legend-label
	 

  
  setTimeout(function(){
			searchData<?=$objectId;?>();
			},50);
});


</script>



 <!--[if IE]><script language="javascript" type="text/javascript" src="<?=base_url()?>/public/admin/js/jqplot/excanvas.js"></script><![endif]-->
 
 <script language="javascript" type="text/javascript" src="<?=base_url()?>/public/admin/js/jqplot/jquery.jqplot.min.js"></script>
 <script language="javascript" type="text/javascript" src="<?=base_url()?>/public/admin/js/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
 <link rel="stylesheet" type="text/css" href="<?=base_url()?>/public/admin/js/jqplot/jquery.jqplot.css" />
	

<div id="chart1" style="height:400px;width:300px;float:left; "></div> 
<div id="chart2" style="height:400px;width:300px;float:left; "></div> 
<div id="chart3" style="height:400px;width:300px;float:left; "></div> 


<script type="text/javascript">
//$.jqplot('chartdiv',  [[[1, 2],[3,5.12],[5,13.1],[7,33.6],[9,85.9],[11,219.9]]]);

$(document).ready(function(){
  var data = [
    ['Heavy Industry', 12],['Retail', 9], ['Light Industry', 14],
    ['Out of home', 16],['Commuting', 7], ['Orientation', 9]
  ];
  var plot1 = jQuery.jqplot ('chart1', [data],
    {
      seriesDefaults: {
        // Make this a pie chart.
        renderer: jQuery.jqplot.PieRenderer,
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      },
      legend: { show:true, location: 'e' }
    }    
  );
  
  var plot2 = jQuery.jqplot ('chart2', [data],
    {
      seriesDefaults: {
        // Make this a pie chart.
        renderer: jQuery.jqplot.PieRenderer,
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      },
      legend: { show:true, location: 'e' }
    }    
  );
  
  var plot3 = jQuery.jqplot ('chart3', [data],
    {
      seriesDefaults: {
        // Make this a pie chart.
        renderer: jQuery.jqplot.PieRenderer,
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      },
      legend: { show:true, location: 'e' }
    }    
  );
  
  
});
</script>


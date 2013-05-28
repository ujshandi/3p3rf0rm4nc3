	<script  type="text/javascript" >
		$(function(){
			var url;
			
			importData<?=$objectId;?>=function(){
				var checked = $('#importDestination').tree('getChecked');
				
				if (checked.length==0) {alert('Data yang akan diimport belum dipilih!');return;}
				// var checkArr = checked.split(',');
				var tahun = $("#txtTahun<?=$objectId;?>").val();
				if ((tahun==null) ||(tahun==""))
					tahun = '0000';
				$("#content<?=$objectId?>").html("No Result.");
				var msgAll="";
				var replace = confirm("Apakah data lama akan ditimpah dengan data baru?");
				//	  alert(timpa);
				for (i = 0; i < checked.length; i++)
					{
					if (checked[i].attributes==null) continue;
					 //  alert(checked[i].text+" "+checked[i].id);
					
					  $.ajax({
							  type: "POST",
							  url: "utility/import/doImport/"+checked[i].id+"/"+checked[i].text+"/"+replace+"/"+tahun,
							  beforeSend: function ( xhr ) {
								/* msgAll += checked[i].text+" "+"<br>";
								msgAll += "------------------------------------------------------- "+"<br>";
								$("#content<?=$objectId?>").html(msgAll); */
							  }
							}).done(function( msg ) {
							  //alert( "Data Saved: " + msg );
							  if (msg!=null)
								msgAll = msgAll+msg;
								$("#content<?=$objectId?>").html(msgAll);
							}).fail(function(jq,msg) { msgAll += "Error.<br>";
								alert(msg);
							
								$("#content<?=$objectId?>").html(msgAll);
							}).always(function() { 
								 
							});
						//	alert(msgAll);
					} 
				
			}
			
			
			$('#importDestination').tree({
				checkbox: true,
				url: base_url+'utility/import/loadMenu',
				
				onClick:function(node){					
					$(this).tree('toggle', node.target);
					
					var b = $('#tt2').tree('isLeaf', node.target);
					if (b){
						setTimeout(function(){
							addTab(node.text,node.attributes.url);},100);
					}
					//alert('you dbclick '+node.attributes.url);
				}
			}); 
			
		//	$('#cc<?=$objectId?>').layout();  
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
		
		<div style="margin-bottom:5px" >  
			
			<a href="#" onclick="importData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-reload" plain="true">Import</a>
			<!--
			<a href="#" onclick="printData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
			<a href="#" onclick="toExcel<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-excel" plain="true">Excel</a>
			-->
	  	</div>
	</div>
	
	<div class="easyui-layout" fit="true" >  
   <div region="north" border="true" style="height:auto">
   
   </div>
	<div region="west" split="true" title="Data yang akan diimport" style="width:250px;">  
		<div class="fsearch">
		<label for="txtTahun<?=$objectId?>">Tahun : </label><input type="text" name="txtTahun" value="0000" size="5" maxlength="4" id="txtTahun<?=$objectId?>"/>
	</div>
        <ul id="importDestination" ></ul>
    </div>  
    <div id="content<?=$objectId?>" region="center" title="Hasil" style="padding:5px;">
		No Result.
    </div>  
</div>  
	
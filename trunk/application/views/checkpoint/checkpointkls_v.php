 
        
	<script  type="text/javascript" >
				var idCheckpoint;
				var rowIndexDetail;

		$(function(){
			var wWidth = $(window).width();
			var wHeight = $(window).height();
			$("#dlg<?=$objectId;?>").css('width',wWidth);
			$("#dlg<?=$objectId;?>").css('height',wHeight);
			
			
			
			var url;
			newData<?=$objectId;?> = function (){  
				var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
				if (row){
					$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Add <?=$purpose?> Checkpoint Kementerian');  
					$('#fm<?=$objectId;?>').form('clear');  
					$("#cmbPeriode<?=$objectId?>").prop('disabled', false);
					url = base_url+'checkpoint/checkpointkl/save';  
					$("#deskripsi_iku_kl<?=$objectId?>").val(row.deskripsi_iku_kl);
					$("#deskripsi_sasaran_kl<?=$objectId?>").val(row.deskripsi_sasaran_kl);
					$("#id_pk_kl<?=$objectId?>").val(row.id_pk_kl);
					$("#penanggungjawab<?=$objectId?>").val(row.nama_kl);
					$("#purpose<?=$objectId?>").val('<?=$purpose?>');
					$("#kd_kl<?=$objectId?>").val(row.kode_kl);
					$("#cmbPeriode<?=$objectId?>").val(<?=date("n")?>);
					$('#files').empty();
					//$("#nama_folder_pendukung<?=$objectId?>").val(row.nama_folder_pendukung);
					getFolderName<?=$objectId?>();
					prepareUpload<?=$objectId?>();
				}	
				//addTab("Add PK Kementerian", "checkpoint/checkpointkl/add");
			}
			//end newData 
			
			editData<?=$objectId;?> = function (editmode){
				var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
				var tr = jQuery('#dg<?=$objectId;?>').closest('tr.datagrid-row');
				$('#saveBtn<?=$objectId;?>').css("display",(editmode)?"":"none");
				//alert('row index parent'+tr.attr('datagrid-row-index'));
				//alert(idCheckpoint+"=idcheckpoint") ;
				if ((idCheckpoint ==null)||(idCheckpoint =='undefined')) return false;
			//	$('#dg<?=$objectId;?>').datagrid('options').queryParams.
				//alert($.url().param("parentIndex")+"Parent");
				//if (row){
					$.ajax({
					url:'<?=base_url()?>checkpoint/checkpointkl/getDataEdit/'+idCheckpoint,
					success:function(data){
						//alert(data);
						var data = eval('('+data+')');
							$('#dlg<?=$objectId;?>').dialog('open').dialog('setTitle','Edit <?=$purpose?> Checkpoint Kementerian');  
						$('#fm<?=$objectId;?>').form('clear');  
						$('#files').empty();
						url = base_url+'checkpoint/checkpointkl/save';  
						$("#cmbPeriode<?=$objectId?>").prop('disabled', 'disabled');
						$("#deskripsi_iku_kl<?=$objectId?>").val(data.deskripsi_iku_kl);
						$("#deskripsi_sasaran_kl<?=$objectId?>").val(data.deskripsi_sasaran_kl);
						$("#id_pk_kl<?=$objectId?>").val(data.id_pk_kl);
						$("#id_checkpoint_kl<?=$objectId?>").val(data.id_checkpoint_kl);
						$("#penanggungjawab<?=$objectId?>").val(data.nama_kl);
						$("#kriteria<?=$objectId?>").val(data.kriteria);
						$("#unitkerja<?=$objectId?>").val(data.unit_kerja);
						$("#ukuran<?=$objectId?>").val(data.ukuran);
						$("#target<?=$objectId?>").val(data.target);
						$("#keterangan<?=$objectId?>").val(data.keterangan);
						$("#capaian<?=$objectId?>").val(data.capaian);
						$("#cmbPeriode<?=$objectId?>").val(data.periode);
						$("#kd_kl<?=$objectId?>").val(row.kode_kl);
						$("#nama_folder_pendukung<?=$objectId?>").val(row.nama_folder_pendukung);
						$("#purpose<?=$objectId?>").val('<?=$purpose?>');
						getListFilePendukung(data.kode_kl,data.id_pk_kl,data.periode);
						prepareUpload<?=$objectId?>();
					}});
					
				//}	
			}
			//end editData
			
			deleteData<?=$objectId;?> = function (){
				<? if ($this->session->userdata('unit_kerja_e1')=='-1'){?>				
					var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
					if ((idCheckpoint ==null)||(idCheckpoint =='undefined')) return false;
					$.ajax({
					url:'<?=base_url()?>checkpoint/checkpointkl/getDataEdit/'+idCheckpoint,
					success:function(data){
						var data = eval('('+data+')');
						if(confirm("Apakah yakin akan menghapus data " + '' + "?")){
							var response = '';
							$.ajax({ type: "GET",
									 url: base_url+'checkpoint/checkpointkl/delete/' + data.id_checkpoint_kl,
									 async: false,
									 success : function(response)
									 {
										var response = eval('('+response+')');
										if (response.success){
											$.messager.show({
												title: 'Success',
												msg: 'Data Berhasil Dihapus'
											});
											
											// reload and close tab
										//	$('#dg<?=$objectId;?>').datagrid('reload');
										$('#ddv<?=$objectId;?>-'+rowIndexDetail).datagrid('reload');
										} else {
											$.messager.show({
												title: 'Error',
												msg: response.msg
											});
										}
									 }
							});
						}
					}});
						
					
				<?} else { ?>	
					alert("Silahkan Login sebagai Superadmin");
				<?} ?>
			}
			//end deleteData 
			
			clearFilter<?=$objectId;?> = function (){
				$("#filter_tahun<?=$objectId;?>").val('');
				searchData<?=$objectId;?>();
			}
			
			//tipe 1=grid, 2=pdf, 3=excel
			getUrl<?=$objectId;?> = function (tipe){
				var filtahun = $("#filter_tahun<?=$objectId;?>").val();
				
				if(filtahun.length==0) filtahun ="-1";
				
				if (tipe==1){
					return "<?=base_url()?>checkpoint/checkpointkl/grid/"+filtahun;
				}
				else if (tipe==2){
					return "<?=base_url()?>checkpoint/checkpointkl/pdf/"+filtahun;
				}else if (tipe==3){
					return "<?=base_url()?>checkpoint/checkpointkl/excel/"+filtahun;
				}
				
			}
			
			searchData<?=$objectId;?> = function (){
				//ambil nilai-nilai filter
				$('#dg<?=$objectId;?>').datagrid({
					url:getUrl<?=$objectId;?>(1),
					queryParams:{lastNo:'0'},	
					pageNumber : 1,
					onLoadSuccess:function(data){	
				//		$('#dg<?=$objectId;?>').datagrid('options').queryParams.lastNo = data.lastNo;
						//prepareMerge<?=$objectId;?>(data);
				}});
			}
			//end searchData 		
		
			printData<?=$objectId;?>=function(){			
				//$.jqURL.loc(getUrl<?=$objectId;?>(2),{w:800,h:600,wintype:"_blank"});
			//window.open(getUrl<?=$objectId;?>(2));;
			alert("Sedang dalam pengerjaan");
		}
			toExcel<?=$objectId;?>=function(){
				alert("Sedang dalam pengerjaan");	
				//window.open(getUrl<?=$objectId;?>(3));;
			}
			
			saveData<?=$objectId;?>=function(){
				$('#fm<?=$objectId;?>').form('submit',{
					url: url,
					onSubmit: function(){
						return $(this).form('validate');
					},
					success: function(result){
						//alert(result);
						var result = eval('('+result+')');
						if (result.success){
							/* $.messager.show({
								title: 'Success',
								msg: result.msg
							}); */
							$('#dlg<?=$objectId;?>').dialog('close');		// close the dialog
							//$('#dg<?=$objectId;?>').datagrid('reload');	// reload the user data
							$('#ddv<?=$objectId;?>-'+rowIndexDetail).datagrid('reload');
						} else {
							$.messager.show({
								title: 'Error',
								msg: result.msg
							});
						}
					}
				});
			}
			//end saveData
			
			formatPrice=function (val,row){
				return val;//($.fn.autoNumeric.Format("txtAmount"+idx,total,{aSep:".",aDec:",",mDec:2}));
				/* if (val < 20){
					return '<span style="color:red;">('+val+')</span>';
				} else {
					return val;
				} */
			}

			
			setTimeout(function(){
				//searchData<?=$objectId;?>();
				//$('#dg<?=$objectId;?>').datagrid({url:"<?=base_url()?>checkpoint/checkpointkl/grid"});
			},0);
			
			
			
			$("#popdesc<?=$objectId?>").click(function(){
				closePopup('#popdesc<?=$objectId?>');
			});
			
			getFolderName<?=$objectId?> = function(){
					var rs = base_url+"upload/pendukung/kl/";
					rs = rs + $("#kd_kl<?=$objectId?>").val()+'/'+$("#id_pk_kl<?=$objectId?>").val()+'/'+$("#cmbPeriode<?=$objectId?>").val();
					$("#nama_folder_pendukung<?=$objectId?>").val(rs);
			}
			
			$("#cmbPeriode<?=$objectId?>").change(function(){
					getFolderName<?=$objectId?>();
			})
			
			deleteFilePendukung = function(kode_kl,id_pk_kl, periode,file){
				jQuery.ajax({
					url:base_url+'checkpoint/checkpointkl/deleteFile/'+kode_kl+'/'+id_pk_kl+'/'+periode+'/'+file,
					success: function(data, textStatus,jqXHR){
						$('#files').empty();
						getListFilePendukung(kode_kl,id_pk_kl, periode);
					},
					error: function(jqXHR, textStatus, error){
							alert(error);
							return false;
					}
				});
			}
			
			getListFilePendukung = function(kode_kl,id_pk_kl, periode){
				jQuery.ajax({
					url:base_url+'checkpoint/checkpointkl/getListFile/'+kode_kl+'/'+id_pk_kl+'/'+periode,
					success: function(data, textStatus,jqXHR){
						if (data==null) return false;
						var row = $(data);
						row.appendTo('#files');

					}//end success
				});
			}
			
			
			
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
		
		.btn-primary.active,
			.btn-warning.active,
			.btn-danger.active,
			.btn-success.active,
			.btn-info.active,
			.btn-inverse.active {
			  color: rgba(255, 255, 255, 0.75);
			}
		.btn-primary:active,
		.btn-primary.active {
		  background-color: #003399 \9;
		}

		.btn-warning {
		  color: #ffffff;
		  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
		  background-color: #faa732;
		  *background-color: #f89406;
		  background-image: -moz-linear-gradient(top, #fbb450, #f89406);
		  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#fbb450), to(#f89406));
		  background-image: -webkit-linear-gradient(top, #fbb450, #f89406);
		  background-image: -o-linear-gradient(top, #fbb450, #f89406);
		  background-image: linear-gradient(to bottom, #fbb450, #f89406);
		  background-repeat: repeat-x;
		  border-color: #f89406 #f89406 #ad6704;
		  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
		  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fffbb450', endColorstr='#fff89406', GradientType=0);
		  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
		}

		.btn-warning:hover,
		.btn-warning:focus,
		.btn-warning:active,
		.btn-warning.active,
		.btn-warning.disabled,
		.btn-warning[disabled] {
		  color: #ffffff;
		  background-color: #f89406;
		  *background-color: #df8505;
		}

		.btn-warning:active,
		.btn-warning.active {
		  background-color: #c67605 \9;
		}

		.btn-danger {
		  color: #ffffff;
		  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
		  background-color: #da4f49;
		  *background-color: #bd362f;
		  background-image: -moz-linear-gradient(top, #ee5f5b, #bd362f);
		  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ee5f5b), to(#bd362f));
		  background-image: -webkit-linear-gradient(top, #ee5f5b, #bd362f);
		  background-image: -o-linear-gradient(top, #ee5f5b, #bd362f);
		  background-image: linear-gradient(to bottom, #ee5f5b, #bd362f);
		  background-repeat: repeat-x;
		  border-color: #bd362f #bd362f #802420;
		  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
		  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffee5f5b', endColorstr='#ffbd362f', GradientType=0);
		  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
		}

		.btn-danger:hover,
		.btn-danger:focus,
		.btn-danger:active,
		.btn-danger.active,
		.btn-danger.disabled,
		.btn-danger[disabled] {
		  color: #ffffff;
		  background-color: #bd362f;
		  *background-color: #a9302a;
		}

		.btn-danger:active,
		.btn-danger.active {
		  background-color: #942a25 \9;
		}

		.btn-success {
		  color: #ffffff;
		  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
		  background-color: #5bb75b;
		  *background-color: #51a351;
		  background-image: -moz-linear-gradient(top, #62c462, #51a351);
		  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#62c462), to(#51a351));
		  background-image: -webkit-linear-gradient(top, #62c462, #51a351);
		  background-image: -o-linear-gradient(top, #62c462, #51a351);
		  background-image: linear-gradient(to bottom, #62c462, #51a351);
		  background-repeat: repeat-x;
		  border-color: #51a351 #51a351 #387038;
		  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
		  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff62c462', endColorstr='#ff51a351', GradientType=0);
		  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
		}

		.btn-success:hover,
		.btn-success:focus,
		.btn-success:active,
		.btn-success.active,
		.btn-success.disabled,
		.btn-success[disabled] {
		  color: #ffffff;
		  background-color: #51a351;
		  *background-color: #499249;
		}

		.btn-success:active,
		.btn-success.active {
		  background-color: #408140 \9;
		}

		.btn-info {
		  color: #ffffff;
		  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
		  background-color: #49afcd;
		  *background-color: #2f96b4;
		  background-image: -moz-linear-gradient(top, #5bc0de, #2f96b4);
		  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#5bc0de), to(#2f96b4));
		  background-image: -webkit-linear-gradient(top, #5bc0de, #2f96b4);
		  background-image: -o-linear-gradient(top, #5bc0de, #2f96b4);
		  background-image: linear-gradient(to bottom, #5bc0de, #2f96b4);
		  background-repeat: repeat-x;
		  border-color: #2f96b4 #2f96b4 #1f6377;
		  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
		  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff5bc0de', endColorstr='#ff2f96b4', GradientType=0);
		  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
		}

		.btn-info:hover,
		.btn-info:focus,
		.btn-info:active,
		.btn-info.active,
		.btn-info.disabled,
		.btn-info[disabled] {
		  color: #ffffff;
		  background-color: #2f96b4;
		  *background-color: #2a85a0;
		}

		.btn-info:active,
		.btn-info.active {
		  background-color: #24748c \9;
		}

		.btn-inverse {
		  color: #ffffff;
		  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
		  background-color: #363636;
		  *background-color: #222222;
		  background-image: -moz-linear-gradient(top, #444444, #222222);
		  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#444444), to(#222222));
		  background-image: -webkit-linear-gradient(top, #444444, #222222);
		  background-image: -o-linear-gradient(top, #444444, #222222);
		  background-image: linear-gradient(to bottom, #444444, #222222);
		  background-repeat: repeat-x;
		  border-color: #222222 #222222 #000000;
		  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
		  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff444444', endColorstr='#ff222222', GradientType=0);
		  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
		}

		.btn-inverse:hover,
		.btn-inverse:focus,
		.btn-inverse:active,
		.btn-inverse.active,
		.btn-inverse.disabled,
		.btn-inverse[disabled] {
		  color: #ffffff;
		  background-color: #222222;
		  *background-color: #151515;
		}

		.btn-inverse:active,
		.btn-inverse.active {
		  background-color: #080808 \9;
		}
	
		.btn-primary {
		  background-color: #006DCC;
		  background-image: linear-gradient(to bottom, #0088CC, #0044CC);
		  background-repeat: repeat-x;
		  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
		  color: #FFFFFF;
		  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
		}

		.btn-success {
		  background-color: #5BB75B;
		  background-image: linear-gradient(to bottom, #62C462, #51A351);
		  background-repeat: repeat-x;
		  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
		  color: #FFFFFF;
		  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
		}

		.btn {
		  -moz-border-bottom-colors: none;
		  -moz-border-left-colors: none;
		  -moz-border-right-colors: none;
		  -moz-border-top-colors: none;
		  border-image: none;
		  border-radius: 4px 4px 4px 4px;
		  border-style: solid;
		  border-width: 1px;
		  box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px rgba(0, 0, 0, 0.05);
		  cursor: pointer;
		  display: inline-block;
		  font-size: 12px;
		  line-height: 20px;
		  padding: 4px 12px;
		  text-align: center;
		  vertical-align: middle;
		}
		
		.progress {
		  background-color: #F7F7F7;
		  background-image: linear-gradient(to bottom, #F5F5F5, #F9F9F9);
		  background-repeat: repeat-x;
		  border-radius: 4px 4px 4px 4px;
		  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1) inset;
		  height: 20px;
		  margin-bottom: 20px;
		  overflow: hidden;
		}
		
		.progress-striped .bar {
			background-color: #149BDF;
			background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
			background-size: 40px 40px;
		}
		.progress-success .bar, .progress .bar-success {
			background-color: #5EB95E;
			background-image: linear-gradient(to bottom, #62C462, #57A957);
			background-repeat: repeat-x;
		}

		.progress-success.progress-striped .bar, .progress-striped .bar-success {
			background-color: #62C462;
			background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
		}
		
		.icon-bootstrap-upload {
		  background-position: -144px -24px;
		}
		
		[class^="icon-bootstrap"],
		[class*=" icon-bootstrap-"] {
		  display: inline-block;
		  width: 14px;
		  height: 14px;
		  margin-top: 1px;
		  *margin-right: .3em;
		  line-height: 14px;
		  vertical-align: text-top;
		  background-image: url("<?=base_url();?>public/images/glyphicons-halflings.png");
		  background-position: 14px 14px;
		  background-repeat: no-repeat;
		}

		.icon-bootstrap-white, .nav-pills > .active > a > [class^="icon-bootstrap-"], .nav-pills > .active > a > [class*=" icon-bootstrap-"], .nav-list > .active > a > [class^="icon-bootstrap-"], .nav-list > .active > a > [class*=" icon-bootstrap-"], .navbar-inverse .nav > .active > a > [class^="icon-bootstrap-"], .navbar-inverse .nav > .active > a > [class*=" icon-bootstrap-"], .dropdown-menu > li > a:hover > [class^="icon-bootstrap-"], .dropdown-menu > li > a:focus > [class^="icon-bootstrap-"], .dropdown-menu > li > a:hover > [class*=" icon-bootstrap-"], .dropdown-menu > li > a:focus > [class*=" icon-bootstrap-"], .dropdown-menu > .active > a > [class^="icon-bootstrap-"], .dropdown-menu > .active > a > [class*=" icon-bootstrap-"], .dropdown-submenu:hover > a > [class^="icon-bootstrap-"], .dropdown-submenu:focus > a > [class^="icon-bootstrap-"], .dropdown-submenu:hover > a > [class*=" icon-bootstrap-"], .dropdown-submenu:focus > a > [class*=" icon-bootstrap-"] {
		  background-image: url("<?=base_url();?>public/images/glyphicons-halflings-white.png");
		}
		.icon-bootstrap-trash {
		  background-position: -456px 0;
		}
		.icon-bootstrap-ban-circle {
			background-position: -216px -96px;	
		}
		.icon-bootstrap-upload {
		  background-position: -144px -24px;
		}
		.icon-bootstrap-plus {
		  background-position: -408px -96px;
		}
		
		.table-striped tbody > tr:nth-child(odd) > td,
		.table-striped tbody > tr:nth-child(odd) > th {
		  background-color: #f9f9f9;
		}




	</style>
	
	<div id="tb<?=$objectId;?>" style="height:auto">
	   <table border="0" cellpadding="1" cellspacing="1" width="100%">
		<tr>
			<td>
			<div class="fsearch" <?=($this->session->userdata('unit_kerja_e1')=='-1'?'':'style="display:none"')?>>
				<table border="0" cellpadding="1" cellspacing="1">
				<tr>
					<td>Tahun :</td>
					<td>
					<?=$this->checkpointkl_model->getListFilterTahun($objectId)?>
					</td>
				</tr>
				<tr style="height:10px">
					  <td style="">
					  </td>
				</tr>
				<tr>
					<td align="right" colspan="2" valign="top">
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
	  <? if ($purpose=='Rencana') {?>
		<? if($this->sys_menu_model->cekAkses('ADD;',125,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="newData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-add" plain="true">Add</a>  
		<?}?>
	<?}?>
		<!------------Edit View-->
		<? if($this->sys_menu_model->cekAkses('EDIT;',125,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="editData<?=$objectId;?>(true);" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Edit</a>
		<?}?>
		<? if($this->sys_menu_model->cekAkses('VIEW;',125,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="editData<?=$objectId;?>(false);" class="easyui-linkbutton" iconCls="icon-view" plain="true">View</a>
		<?}?>
		<? if($this->sys_menu_model->cekAkses('DELETE;',125,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="deleteData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-remove" plain="true">Delete</a>
		<?}?>
		<!--
		<a href="#" onclick="printData<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-print" plain="true">Print</a>
		<a href="#" onclick="toExcel<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-excel" plain="true">Excel</a>
		-->
	  </div>
	</div>
	<!-- class="easyui-datagrid" -->
	<table id="dg<?=$objectId;?>"  style="height:auto;width:auto"
	 title="Data Checkpoint Kementerian" toolbar="#tb<?=$objectId;?>" fitColumns="true" singleSelect="true" rownumbers="true" pagination="true">
	  <thead>
	  <tr>
		<th field="id_pk_kl" hidden="true" sortable="true" width="50px">Kode</th>
		<th field="tahun" sortable="true" width="30px">Tahun</th>		
		<th field="kode_kl" sortable="true" width="50px">Kode Kementerian</th>
		<th field="nama_kl" hidden="true">nama_kl</th>
		<th field="nama_folder_pendukung" hidden="true">nama_folder_pendukung</th>
		<th field="kode_sasaran_kl" sortable="true" width="50px">Kode Sasaran</th>
		<th field="kode_iku_kl" sortable="true" width="50px">Kode IKU</th>
		<th field="target" sortable="true" width="50px" align="right" formatter="formatPrice">Target (RKT)</th>
		<th field="penetapan" sortable="true" width="50px" align="right" formatter="formatPrice">Target (PK)</th>
		<th field="satuan" sortable="true" width="50px">Satuan</th>
		<th field="deskripsi_iku_kl" hidden="true">deskripsi_iku_kl</th>
		<th field="deskripsi_sasaran_kl" hidden="true">deskripsi_sasaran_kl</th>
	  </tr>
	  </thead>  
	</table>
	
	<!-- Area untuk Form Add/Edit >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>  -->
	
	<div id="dlg<?=$objectId;?>" class="easyui-dialog" style="padding:10px 20px" closed="true"  buttons="#dlg-buttons">
		<!----------------Edit title-->
		<!--<div id="ftitle<?=$objectId?>" class="ftitle">Add/Edit/View Rencana Checkpoint Kementerian</div> -->
		<form id="fm<?=$objectId;?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="kd_kl<?=$objectId?>" id="kd_kl<?=$objectId?>" value=""/>
			<div class="fitem">
				<label style="width:130px">Sasaran Strategis:</label>					
					<textarea readonly name="deskripsi_sasaran_kl" id="deskripsi_sasaran_kl<?=$objectId?>" cols="70" class="easyui-validatebox" ></textarea>
				<input type="hidden" id="id_pk_kl<?=$objectId?>" name="id_pk_kl"/>
				<input type="hidden" id="id_checkpoint_kl<?=$objectId?>" name="id_checkpoint_kl"/>
				<input type="hidden" id="purpose<?=$objectId?>" name="purpose" value="<?=$purpose?>"/>
				<input type="hidden" id="nama_folder_pendukung<?=$objectId?>" name="nama_folder_pendukung" value=""/>
			</div>
			
			<div class="fitem">
				<label style="width:130px;vertical-align:top">IKU :</label>
				<textarea readonly name="deskripsi_iku_kl" id="deskripsi_iku_kl<?=$objectId?>" cols="70" class="easyui-validatebox" ></textarea>
			</div>
			<div class="fitem">
				<label style="width:130px;vertical-align:top">Penanggung Jawab :</label>
				<input readonly name="penanggungjawab"  id="penanggungjawab<?=$objectId?>" size="60" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label style="width:130px;vertical-align:top">Unit Kerja Terkait :</label>
				<input name="unitkerja" size="60" id="unitkerja<?=$objectId?>" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label style="width:130px;vertical-align:top">Kriteria Keberhasilan :</label>
				<input name="kriteria" size="60" id="kriteria<?=$objectId?>" class="easyui-validatebox" value="<?=$nama_folder?>">
			</div>
			<div class="fitem">
				<label style="width:130px;vertical-align:top">Ukuran Keberhasilan :</label>
				<input name="ukuran" size="60" id="ukuran<?=$objectId?>" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label style="width:130px;vertical-align:top">Periode :</label>
				<? echo $listPeriode;?>
			</div>
			<? if ($purpose=='Rencana') {?>
			<div class="fitem">
				<label style="width:130px;vertical-align:top">Target (%):</label>
				<input name="target" size="5" id="target<?=$objectId?>" class="easyui-validatebox">
			</div>
			<?} ?>
			<? if ($purpose=='Capaian') {?>
			<div class="fitem">
				<label style="width:130px;vertical-align:top">Target (%):</label>
				<input name="target" size="5" id="target<?=$objectId?>" readonly class="easyui-validatebox">
				&nbsp;&nbsp;Capaian (%):
				<input name="capaian" id="capaian<?=$objectId?>" size="5" class="easyui-validatebox">
			</div>
			<?} ?>
			<div class="fitem">
				<label style="width:130px;vertical-align:top">Keterangan :</label>
				<input name="keterangan" size="60" id="keterangan<?=$objectId?>" class="easyui-validatebox">
			</div>
			<!-- upload data pendukung -->
		
			<div class="fitem">
				<label style="width:130px;vertical-align:top">Data Pendukung :</label>
					<div class="row fileupload-buttonbar">
					<div class="span7">
						<!-- The fileinput-button span is used to style the file input field as button -->
						<span class="btn btn-success fileinput-button">
							<i class="icon-bootstrap-plus icon-bootstrap-white"></i>
							<span>Tambah file...</span>  <!-- files[] -->
							<input id="fileupload<?=$objectId?>" type="file" name="files[]" >
						</span>
						<!--<button type="submit" class="btn btn-primary start">
							<i class="icon-bootstrap-upload icon-bootstrap-white"></i>
							<span>Start upload</span>
						</button>
						<button type="reset" class="btn btn-warning cancel">
							<i class="icon-bootstrap-ban-circle icon-bootstrap-white"></i>
							<span>Cancel upload</span>
						</button> 
						<button type="button" class="btn btn-danger delete">
							<i class="icon-bootstrap-trash icon-bootstrap-white"></i>
							<span>Hapus</span>
						</button>
						<input type="checkbox" class="toggle">-->
						<!-- The loading indicator is shown during file processing -->
						<span class="fileupload-loading"></span>
					</div>
					<!-- The global progress information 
					<div class="span5 fileupload-progress fade">
						<!-- The global progress bar 
						<div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
							<div class="bar" style="width:0%;"></div>
						</div>
						<!-- The extended global progress information 
						<div class="progress-extended">&nbsp;</div>
					</div> 
					-->
				</div>
				<!-- The table listing the files available for upload/download -->
				 <!--<div id="files" class="files"></div> -->
				
			</div>
					<!-- end upload data pendukung -->
			<div class="fitem">
				<label style="width:130px;vertical-align:top">&nbsp;</label>
				<table role="presentation" class="table table-striped">
					<tbody id="files" class="files"></tbody>
				</table>			
			</div>
		</form>
		<div id="dlg-buttons">
			<!----------------Edit title-->
			<a href="#" id="saveBtn<?=$objectId;?>" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveData<?=$objectId;?>()">Save</a>
			<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg<?=$objectId;?>').dialog('close')">Cancel</a>
		</div>
	</div>
	
	<script type="text/javascript">
        $(function(){
			var parentId;
			// chan
			$('#dg<?=$objectId;?>').datagrid({
				url:getUrl<?=$objectId;?>(1),	
				view: detailview,
				queryParams:{rowIdx:'0'},	
				 detailFormatter:function(index,row){
                    return '<div style="padding:2px"><table id="ddv<?=$objectId;?>-' + index + '"></table></div>';
                //  return "tes";
                },
                onExpandRow: function(index,row){
				//	alert(row.id_pk_kl);
						
                    $('#ddv<?=$objectId;?>-'+index).datagrid({
                        url:'<?=base_url()?>checkpoint/checkpointkl/griddetail/'+row.id_pk_kl+'/?parentIndex='+index,
                        fitColumns:true,
                        singleSelect:true,
                        rownumbers:true,
                        loadMsg:'',
                        height:'auto',
                        columns:[[
                            {field:'id_checkpoint_kl',title:'id',width:200,hidden:true},
                            {field:'unit_kerja',title:'Unit Kerja',width:200},
                            {field:'periode',title:'Periode',width:200},
                            {field:'kriteria',title:'Kriteria Capaian',width:200},
                            {field:'ukuran',title:'Ukuran Capaian',width:200},
                            {field:'target',title:'Target',width:100,align:'right'},
                            
                            
                            <? if ($purpose=='Capaian') {?>
								{field:'capaian',title:'Capaian',width:100,align:'right'},
                            <? }?>
                            {field:'keterangan',title:'Keterangan',width:200}
                            
                        ]],
                        onResize:function(){
                            $('#dg<?=$objectId;?>').datagrid('fixDetailRowHeight',index);
                        },
                       onClickCell:function(rowIndex, field, value){
							 $('#ddv<?=$objectId;?>-'+index).datagrid('selectRow', rowIndex);
							var row = $('#ddv<?=$objectId;?>-'+index).datagrid('getSelected');
							///alert(row);
							idCheckpoint = row.id_checkpoint_kl;
							rowIndexDetail = index;
							//alert("idcheckpoint"+idCheckpoint);
					   },
                        onLoadSuccess:function(){
                            setTimeout(function(){
                                $('#dg<?=$objectId;?>').datagrid('fixDetailRowHeight',index);
                            },0);
                        }
                    });
                    $('#dg<?=$objectId;?>').datagrid('fixDetailRowHeight',index);

	
                },
				onClickCell: function(rowIndex, field, value){
					$('#dg<?=$objectId;?>').datagrid('selectRow', rowIndex);
					
					var row = $('#dg<?=$objectId;?>').datagrid('getSelected');
					idCheckpoint = null;
					//alert(row.deskripsi_iku_kl);
					switch(field){
						case "kode_kl":
							showPopup('#popdesc<?=$objectId?>', row.nama_kl);
							break;
						case "kode_sasaran_kl":
							showPopup('#popdesc<?=$objectId?>', row.deskripsi_sasaran_kl);
							break;
						case "kode_iku_kl":
							showPopup('#popdesc<?=$objectId?>', row.deskripsi_iku_kl);
							break;
						/* case "kode_kl":
							showPopup('#popdesc<?=$objectId?>', row.nama_kl);
							break; */
						default:
							closePopup('#popdesc<?=$objectId?>');
							break;
					}
				}
			});
			
			
            //searchData<?=$objectId;?>();
        });
    </script>
    
     
 
	<div class="popdesc" id="popdesc<?=$objectId?>">pops</div>




 	   
 <link rel="stylesheet" type="text/css" href="<?=base_url()?>/public/js/jQuery-File-Upload-8.6.0/css/jquery.fileupload-ui.css" />     

<script type="text/javascript"  src="<?=base_url()?>public/js/jQuery-File-Upload-8.6.0/js/vendor/jquery.ui.widget.js"></script>
<script type="text/javascript"  src="<?=base_url()?>public/js/jQuery-File-Upload-8.6.0/js/vendor/load-image.min.js"></script>
<script type="text/javascript"  src="<?=base_url()?>public/js/jQuery-File-Upload-8.6.0/js/vendor/tmpl.min.js"></script>
<script type="text/javascript"  src="<?=base_url()?>public/js/jQuery-File-Upload-8.6.0/js/jquery.iframe-transport.js"></script>

<script  type="text/javascript" src="<?=base_url()?>public/js/jQuery-File-Upload-8.6.0/js/jquery.fileupload.js" ></script>

<script src="<?=base_url()?>public/js/jQuery-File-Upload-8.6.0/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?=base_url()?>public/js/jQuery-File-Upload-8.6.0/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin 
<script src="<?=base_url()?>public/js/jQuery-File-Upload-8.6.0/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin
<script src="<?=base_url()?>public/js/jQuery-File-Upload-8.6.0/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="<?=base_url()?>public/js/jQuery-File-Upload-8.6.0/js/jquery.fileupload-validate.js"></script>


<script type="text/javascript" >
/*jslint unparam: true */
/*global window, $ */
	//prepare upload
	prepareUpload<?=$objectId?> = function(){

	      url =  base_url+'checkpoint/checkpointkl/upload';

			jQuery('#fileupload<?=$objectId?>').unbind('fileupload').fileupload({
				url: base_url+'checkpoint/checkpointkl/upload/'+$("#kd_kl<?=$objectId?>").val()+'/'+$("#id_pk_kl<?=$objectId?>").val()+'/'+$("#cmbPeriode<?=$objectId?>").val(),
				dataType: 'json',
				maxFileSize: 5000000, // 5 MB
				autoUpload: true,
				replaceFileInput: false,
				//singleFileUploads: false

				done: function (e, data) {
					var rows = $();
					//alert(o);
					
				
					
					$.each(data.result.files, function (index, file) {
						var row = $('<tr class="template-download fade">' +
							(file.error ? '<td></td><td class="name"></td>' +
								'<td class="size"></td><td class="error" colspan="2"></td>' :
								//	'<td class="preview"></td>' +
										'<td class="name"><a></a></td>' +
										'<td class="size">&nbsp;</td><td colspan="2"></td>'
							) + '<td><button class="btn btn-danger delete" ><i class="icon-bootstrap-trash icon-bootstrap-white"></i><span>Delete</span></button> ' +
								'</td></tr>');
								//'<input type="checkbox" name="delete" value="1" class="toggle">
						//row.find('.size').text("&nbsp;");//file.size);
						if (file.error) {
							row.find('.name').text(file.name);
							row.find('.error').text(
								locale.fileupload.errors[file.error] || file.error
							);
						} else {
							row.find('.name a').text(file.name);
							if (file.thumbnailUrl) {
								row.find('.preview').append('<a><img></a>')
									.find('img').prop('src', file.thumbnailUrl);
								row.find('a').prop('rel', 'gallery');
							}
							row.find('a').prop('href', file.url);
						//	var deleteUrl = base_url+"checkpoint_kl/upload/"+$("#kd_kl<?=$objectId?>").val()+'/'+$("#id_pk_kl<?=$objectId?>").val()+'/'+$("#cmbPeriode<?=$objectId?>").val();
							var deleteUrl = base_url+"checkpoint/chekcpointkl/upload/"+$("#kd_kl<?=$objectId?>").val()+'/'+$("#id_pk_kl<?=$objectId?>").val()+'/'+$("#cmbPeriode<?=$objectId?>").val()+"/?file="+file.name;
							row.find('.delete')
								.attr('data-type', file.deleteType)
								.attr('data-url', file.deleteUrl);//file.deleteUrl);
						}
						//rows = rows.add(row);
						row.appendTo('#files');
					});	
/*
					//	alert("done");
					$.each(data.result.files, function (index, file) {
						alert(file.name);
						$('<p/>').text(file.name).appendTo('#files');
					});
*/

				},
				fail: function (e, data) {
					//data.errorThrown
    // data.textStatus;
    // data.jqXHR;
					//	alert("fail : "+data.errorThrown);//data.error
				},
				always: function (e, data) {
						//alert("always");
				},
				start: function (e) {
					
					
				},
				send: function (e) {
					
					if (($("#cmbPeriode<?=$objectId?>").val()=="")||($("#cmbPeriode<?=$objectId?>").val()==null)){
							alert("Periode belum dipilih");
							$("#cmbPeriode<?=$objectId?>").focus();
							return false;
					}
					
				},
				progressall: function (e, data) {

					var progress = parseInt(data.loaded / data.total * 100, 10);
					$('#progress .bar').css(
						'width',
						progress + '%'
					);

				},
				 filesContainer: $('#files'),
				uploadTemplateId: null,
				downloadTemplateId: null,
				uploadTemplate: function (o) {
					alert(o);
					var rows = $();
					$.each(o.files, function (index, file) {
						var row = $('<tr class="template-upload fade">' +
							'<td class="preview"><span class="fade"></span></td>' +
							'<td class="name"></td>' +
							'<td class="size"></td>' +
							(file.error ? '<td class="error" colspan="2"></td>' :
									'<td><div class="progress">' +
										'<div class="bar" style="width:0%;"></div></div></td>' +
										'<td class="start"><button>Start</button></td>'
							) + '<td class="cancel"><button>Cancel</button></td></tr>');
						row.find('.name').text(file.name);
						row.find('.size').text(o.formatFileSize(file.size));
						if (file.error) {
							row.find('.error').text(
								locale.fileupload.errors[file.error] || file.error
							);
						}
						rows = rows.add(row);
					});
					return rows;
				},
				downloadTemplate: function (o) {
					var rows = $();
					alert(o);
					$.each(o.files, function (index, file) {
						var row = $('<tr class="template-download fade">' +
							(file.error ? '<td></td><td class="name"></td>' +
								'<td class="size"></td><td class="error" colspan="2"></td>' :
									'<td class="preview"></td>' +
										'<td class="name"><a></a></td>' +
										'<td class="size"></td><td colspan="2"></td>'
							) + '<td class="delete"><button>Delete</button> ' +
								'<input type="checkbox" name="delete" value="1" class="toggle"></td></tr>');
						row.find('.size').text(o.formatFileSize(file.size));
						if (file.error) {
							row.find('.name').text(file.name);
							row.find('.error').text(
								locale.fileupload.errors[file.error] || file.error
							);
						} else {
							row.find('.name a').text(file.name);
							if (file.thumbnail_url) {
								row.find('.preview').append('<a><img></a>')
									.find('img').prop('src', file.thumbnail_url);
								row.find('a').prop('rel', 'gallery');
							}
							row.find('a').prop('href', file.url);
							row.find('.delete')
								.attr('data-type', file.delete_type)
								.attr('data-url', file.delete_url);
						}
						rows = rows.add(row);
					});
					return rows;
				}

			}).prop('disabled', !$.support.fileInput)
				.parent().addClass($.support.fileInput ? undefined : 'disabled');
				
	}
	//end prepare upload




</script>

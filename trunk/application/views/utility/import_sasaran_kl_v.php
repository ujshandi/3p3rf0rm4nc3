<script type="text/javascript">
		$(function(){
			$.ajax({
			    url:"<?=API_RUJUKAN_HREF?>eselon2_list/format/json",
			    type: "GET",
			    
			    contentType: "application/json; charset=utf-8",
			    dataType: "json",
			    cache: false,
			    success: function (data) {
			       //You can further use jTemplate to output the data.
				   $('#dg<?=$objectId;?>').datagrid({
				//url:"<?=API_RUJUKAN_HREF?>eselon2_list/format/json",
					data:data,
					 /* loadFilter: function(data){
						alert(data);
						if (data.d){
							return data.d;
						} else {
							return data;
						}
					} */ 
					});		
			    },
			    error: function (data) {
					alert("error "+data);
			    }
			});
			
			
		});
	

</script>

<div id="tb<?=$objectId;?>" style="height:auto">
	  <div style="margin-bottom:5px">  
		
		<? if($this->sys_menu_model->cekAkses('IMPORT;',3,$this->session->userdata('group_id'),$this->session->userdata('level_id'))){?>
			<a href="#" onclick="toExcel<?=$objectId;?>();" class="easyui-linkbutton" iconCls="icon-import" plain="true">Import</a>
		<?}?>
	  </div>
	</div>
	
	<table id="dg<?=$objectId;?>" class="easyui-datagrid" style="height:auto;width:auto" title="Data Kementerian" toolbar="#tb<?=$objectId;?>" fitColumns="true" singleSelect="true" rownumbers="true" pagination="true">
	  <thead>
	  <tr>
		<th field="kode_kl" sortable="true" width="30">Kode</th>
		<th field="nama_kl" sortable="true" width="100">Nama Kementerian</th>
		<th field="singkatan" sortable="true" width="75">Singkatan</th>
		<th field="nama_menteri" sortable="true" width="125">Nama Menteri</th>
	  </tr>
	  </thead> 
	</table>

	<div class="popdesc" id="popdesc<?=$objectId?>">&nbsp;</div>
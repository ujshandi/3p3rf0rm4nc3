<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Rpt_status_pengumpulan_model extends CI_Model
{	
	/**
	* constructor
	*/
	public function __construct()
    {
        parent::__construct();
		//$this->CI =& get_instance();
    }
	// purpose : 1=buat grid, 2=buat pdf, 3=buat excel
	public function easyGrid($filtahun=null,$filAppType=null,$file1=null,$file2=null,$filstart=null,$filend=null,$purpose=1){
		$lastNo = isset($_POST['lastNo']) ? intval($_POST['lastNo']) : 0;  
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		//jika utk pdf & excel maka paging ambil dari parameter
		if (($purpose==2)||($purpose==3)){
			$page = isset($pageNumber) ? intval($pageNumber) : 1;  
			$limit = isset($pageSize) ? intval($pageSize) : 10;  
			
		}
		$count = $this->GetRecordCount($filtahun,$filAppType,$file1,$file2,$filstart,$filend);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'pk.tahun';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		$where1 ='';
		$where2 ='';
		$rataPast =0;
		$rataNow =0;
		$pdfdata = array();
		if ($count>0){
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$where1.=" and pk.tahun='$filtahun'";
				$where2.=" and pk.tahun='".($filtahun-1)."'";
			}	
			
			if($file1 != '' && $file1 != '-1' && $file1 != null) {
				$where1.=" and pk.kode_e1='$file1'";
				$where2.=" and pk.kode_e1='$file1'";
			}	
			
			if($file2 != '' && $file2 != '-1' && $file2 != null) {
				$where1.=" and pk.kode_e2='$file2'";
				$where2.=" and pk.kode_e2='$file2'";
			}		
			
			
			
			//$this->db->order_by($sort." ".$order );
			//hanya utk grid saja
			if ($purpose==1) $this->db->limit($limit,$offset);
			if ($where1!='') $where1 = "where ".substr($where1,5,strlen($where1));
			if ($where2!='') $where2 = "where ".substr($where2,5,strlen($where2));
		
			//hanya utk grid saja
			switch ($filAppType){
				case 'KL' : 					
				//, pk.kode_iku_kl as kode_iku
					$sql = 'select distinct a.kode_kl as unit_kerja,a.nama_kl as deskripsi from tbl_kl a  ';
					//left join tbl_pk_kl pk on a.kode_kl=pk.kode_kl
				break;
				case 'E1' : 
				//, pk.kode_iku_e1 as kode_iku 
					$sql = 'select distinct a.kode_e1 as unit_kerja,a.nama_e1 as deskripsi from tbl_eselon1 a ';
					//left join tbl_pk_eselon1 pk on a.kode_e1=pk.kode_e1 
				break;
				case 'E2' : 
				//, pk.kode_iku_e2 as kode_iku 
					$sql = 'select distinct a.kode_e2 as unit_kerja,a.nama_e2 as deskripsi from tbl_eselon2 a  ';
					//left join tbl_pk_eselon2 pk on a.kode_e2=pk.kode_e2
				break;
			}
			$limitMode = '';
			if ($purpose==1) $limitMode = " limit $offset, $limit";
			$sql .= $limitMode;
			
			$query = $this->db->query($sql);
			
			$i=0;
			
			$no = ($page-1)*$limit;//$lastNo;
			$noIndikator =0;
			$jumlah =0;
			$sumRataPast = 0;
			$sumRataNow = 0;
			foreach ($query->result() as $row){
				$no++;			
				$response->rows[$i]['no']= $no;								
				$response->rows[$i]['deskripsi']=$row->deskripsi;				
				//$row->kode_iku
				$pk = $this->getPK($filAppType,$filtahun,$row->unit_kerja,'');	
				$bulan1 = 0;$bulan2 = 0;$bulan3 = 0;$bulan4 = 0;
				$bulan5 = 0;$bulan6 = 0;$bulan7 = 0;$bulan8 = 0;
				$bulan9 = 0;$bulan10 = 0;$bulan11 = 0;$bulan12 = 0;
				$response->rows[$i]['bulan1'] = "";
				$response->rows[$i]['bulan2'] = "";
				$response->rows[$i]['bulan3'] = "";
				$response->rows[$i]['bulan4'] = "";
				$response->rows[$i]['bulan5'] = "";
				$response->rows[$i]['bulan6'] = "";
				$response->rows[$i]['bulan7'] = "";
				$response->rows[$i]['bulan8'] = "";
				$response->rows[$i]['bulan9'] = "";
				$response->rows[$i]['bulan10'] = "";
				$response->rows[$i]['bulan11'] = "";
				$response->rows[$i]['bulan12'] = "";
				
				if ((1>=intval($filstart)+1)&&(1<=intval($filend)+1)){
					$bulan1 = $this->getRealisasi($filAppType,$filtahun,$row->unit_kerja,'',1);		
					$response->rows[$i]['bulan1']=$this->getStatus($pk,$bulan1);						
				}
				if ((2>=intval($filstart)+1)&&(2<=intval($filend)+1)){
					$bulan2 = $this->getRealisasi($filAppType,$filtahun,$row->unit_kerja,'',2);	
					$response->rows[$i]['bulan2']=$this->getStatus($pk,$bulan2);	
				}
				if ((3>=intval($filstart)+1)&&(3<=intval($filend)+1)){
					$bulan3 = $this->getRealisasi($filAppType,$filtahun,$row->unit_kerja,'',3);				
					$response->rows[$i]['bulan3']=$this->getStatus($pk,$bulan3);		
				}
				if ((4>=intval($filstart)+1)&&(4<=intval($filend)+1)){
					$bulan4 = $this->getRealisasi($filAppType,$filtahun,$row->unit_kerja,'',4);	
					$response->rows[$i]['bulan4']=$this->getStatus($pk,$bulan4);	
				}
				if ((5>=intval($filstart)+1)&&(5<=intval($filend)+1)){
					$bulan5 = $this->getRealisasi($filAppType,$filtahun,$row->unit_kerja,'',5);				
					$response->rows[$i]['bulan5']=$this->getStatus($pk,$bulan5);
				}
				if ((6>=intval($filstart)+1)&&(6<=intval($filend)+1)){
					$bulan6 = $this->getRealisasi($filAppType,$filtahun,$row->unit_kerja,'',6);				
					$response->rows[$i]['bulan6']=$this->getStatus($pk,$bulan6);
				}
				if ((7>=intval($filstart)+1)&&(7<=intval($filend)+1)){
					$bulan7 = $this->getRealisasi($filAppType,$filtahun,$row->unit_kerja,'',7);				
					$response->rows[$i]['bulan7']=$this->getStatus($pk,$bulan7);
				}
				if ((8>=intval($filstart)+1)&&(8<=intval($filend)+1)){
					$bulan8 = $this->getRealisasi($filAppType,$filtahun,$row->unit_kerja,'',8);				
					$response->rows[$i]['bulan8']=$this->getStatus($pk,$bulan8);	
				}
				if ((9>=intval($filstart)+1)&&(9<=intval($filend)+1)){
					$bulan9 = $this->getRealisasi($filAppType,$filtahun,$row->unit_kerja,'',9);				
					$response->rows[$i]['bulan9']=$this->getStatus($pk,$bulan9);	
				}				
				if ((10>=intval($filstart)+1)&&(10<=intval($filend)+1)){
					$bulan10 = $this->getRealisasi($filAppType,$filtahun,$row->unit_kerja,'',10);
					$response->rows[$i]['bulan10']=$this->getStatus($pk,$bulan10);
				}
				if ((11>=intval($filstart)+1)&&(11<=intval($filend)+1)){
					$bulan11 = $this->getRealisasi($filAppType,$filtahun,$row->unit_kerja,'',11);
					$response->rows[$i]['bulan11']=$this->getStatus($pk,$bulan11);
				}
				if ((12>=intval($filstart)+1)&&(12<=intval($filend)+1)){
					$bulan12= $this->getRealisasi($filAppType,$filtahun,$row->unit_kerja,'',12);	
					$response->rows[$i]['bulan12']=$this->getStatus($pk,$bulan12);
				}
								
				
				/* 
				//utk kepentingan export excel ==========================
				/* $row->targetPast = $response->rows[$i]['targetPast'];
				$row->realisasiPast=$response->rows[$i]['realisasiPast'];
				$row->persenPast=$response->rows[$i]['persenPast'];
				$row->targetNow=$response->rows[$i]['targetNow'];
				$row->realisasiNow=$response->rows[$i]['realisasiNow'];				
				$row->persenNow=$response->rows[$i]['persenNow'];*/
				$row->bulan1=$response->rows[$i]['bulan1'];
				$row->bulan2=$response->rows[$i]['bulan2'];
				$row->bulan3=$response->rows[$i]['bulan3'];
				$row->bulan4=$response->rows[$i]['bulan4'];
				$row->bulan5=$response->rows[$i]['bulan5'];
				$row->bulan6=$response->rows[$i]['bulan6'];
				$row->bulan7=$response->rows[$i]['bulan7'];
				$row->bulan8=$response->rows[$i]['bulan8'];
				$row->bulan9=$response->rows[$i]['bulan9'];
				$row->bulan10=$response->rows[$i]['bulan10'];
				$row->bulan11=$response->rows[$i]['bulan11'];
				$row->bulan12=$response->rows[$i]['bulan12'];
				unset($row->unit_kerja); 
				
			//============================================================
			//utk kepentingan export pdf===================
				$pdfdata[] = array($no,$response->rows[$i]['deskripsi'],$response->rows[$i]['bulan1'],$response->rows[$i]['bulan2'],$response->rows[$i]['bulan3'],$response->rows[$i]['bulan4'],$response->rows[$i]['bulan5'],$response->rows[$i]['bulan6'],$response->rows[$i]['bulan7'],$response->rows[$i]['bulan8'],$response->rows[$i]['bulan9'],$response->rows[$i]['bulan10'],$response->rows[$i]['bulan11'],$response->rows[$i]['bulan12']);
			//============================================================
			
				$i++;
			} 
			$response->lastNo = $no;
			
		}else {
				
				$response->rows[$count]['no']= "";
				$response->rows[$count]['deskripsi']= "";
				$response->rows[$count]['bulan1']= "";
				$response->rows[$count]['bulan2']='';
				$response->rows[$count]['bulan3']='';
				$response->rows[$count]['bulan4']='';
				$response->rows[$count]['bulan5']= "";
				$response->rows[$count]['bulan6']='';
				$response->rows[$count]['bulan7']='';
				$response->rows[$count]['bulan8']='';
				$response->rows[$count]['bulan9']= "";
				$response->rows[$count]['bulan10']='';
				$response->rows[$count]['bulan11']='';
				$response->rows[$count]['bulan12']='';
				
				$response->lastNo = 0;
		}
		
		//$response->footer[0]['sasaran_strategis']='<b>Rata </b>';
		
	//utk footer pdf ================
		//$pdfdata[] = array("",'Rata-rata capaian sasaran','','','',$this->utility->cekNumericFmt($rataPast),'','',$this->utility->cekNumericFmt($rataNow));
	//-----------------------------------
	if ($purpose==1) //grid normal
			return json_encode($response);
		else if($purpose==2){//pdf
			return $pdfdata;
		}
		else if($purpose==3){//to excel
			//tambahkan header kolom
			$colHeaders = array("Unit Kerja","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktorber","November","Desember");		
			to_excel($query,"statusPengumpulanDataKinerja",$colHeaders);
		}
		
	}
	
	public function GetRecordCount($filtahun=null,$filAppType=null,$file1=null,$file2=null,$filStart=null,$filEnd=null){
		$where1 = '';
		$where2 = '';
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$where1.=" and pk.tahun='$filtahun'";
				$where2.=" and pk.tahun='".($filtahun-1)."'";
			}		
		if($file1 != '' && $file1 != '-1' && $file1 != null) {
				$where1.=" and pk.kode_e1='$file1'";
				$where2.=" and pk.kode_e1='$file1'";
			}		
			
		if ($where1!="") $where1 = " where ".substr($where1,5,strlen($where1));
		if ($where2!="") $where2 = " where ".substr($where2,5,strlen($where2));
	
		switch ($filAppType){
				case 'KL' : 					
					$sql = 'select count(*) as num_rows
							from tbl_kl a  ';
							//left join tbl_pk_kl pk on a.kode_kl=pk.kode_kl
				break;
				case 'E1' : 
					$sql = 'select count(*) as num_rows
							from tbl_eselon1 a ';
							//left join tbl_pk_eselon1 pk on a.kode_e1=pk.kode_e1 
				break;
				case 'E2' : 
					$sql = 'select count(*) as num_rows
							from tbl_eselon2 a ';
							//left join tbl_pk_eselon2 pk on a.kode_e2=pk.kode_e2 
				break;
			}
			
		 $sql2 = 'select count(*) as num_rows from (select iku.deskripsi as indikator_kinerja, iku.satuan,iku.kode_iku_e1
from tbl_iku_eselon1 iku  inner join tbl_pk_eselon1 pk on pk.kode_iku_e1=iku.kode_iku_e1  '.$where2.'
			union 
			select iku.deskripsi as indikator_kinerja,   iku.satuan,iku.kode_iku_e1 
from tbl_iku_eselon1 iku   inner join tbl_pk_eselon1 pk on pk.kode_iku_e1=iku.kode_iku_e1  '.$where1.'
  ) as t1';
  
		$q = $this->db->query($sql);
		return $q->row()->num_rows; 
		//return $this->db->count_all_results();
		//$this->db->free_result();
	}
	
	public function getListTahun($objectId){
		
		$this->db->flush_cache();
		//$this->db->select('distinct tahun',false);
		//$this->db->from('tbl_pk_eselon1');
		
		$sql = 'select distinct tahun from tbl_pk_kl 
				union  
				select distinct tahun from tbl_pk_eselon1
				union 
				select distinct tahun from tbl_pk_eselon2 
				order by tahun ';
		//$this->db->order_by('tahun');
		
		$que = $this->db->query($sql);
		
		$out = '<select name="filter_tahun'.$objectId.'" id="filter_tahun'.$objectId.'">';
	//	$out .= '<option value="">Semua</option>';
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->tahun.'">'.$r->tahun.'</option>';
		}
		
		$out .= '</select>';
		
		echo $out;
	}
	
	
	public function getPK($apptype,$tahun,$unit_kerja,$kode_iku){
		$this->db->flush_cache();
		switch ($apptype){
			case 'KL' : 
				$table_name = 'tbl_pk_kl';
				$field_unit_kerja = 'kode_kl';
				$field_iku = 'kode_iku_kl';
			break;
			case 'E1' : 
				$table_name = 'tbl_pk_eselon1';
				$field_unit_kerja = 'kode_e1';
				$field_iku = 'kode_iku_e1';
			break;
			case 'E2' : 
				$table_name = 'tbl_pk_eselon2';
				$field_unit_kerja = 'kode_e2';
				$field_iku = 'kode_iku_e2';
			break;
		}
		$this->db->select('count(*) as jumlah',false);
		$this->db->from($table_name);
		$this->db->where($field_unit_kerja, $unit_kerja);
	//	$this->db->where($field_iku, $kode_iku);
		$this->db->where('tahun', $tahun);
		$query = $this->db->get();
		if ($query->num_rows()>0)
			return $query->row()->jumlah;
		else return 0;
		
	}
	
	public function getRealisasi($apptype,$tahun,$unit_kerja,$kode_iku,$bulan){
		$this->db->flush_cache();
		switch ($apptype){
			case 'KL' : 
				$table_name = 'tbl_kinerja_kl';
				$field_unit_kerja = 'kode_kl';
				$field_iku = 'kode_iku_kl';
			break;
			case 'E1' : 
				$table_name = 'tbl_kinerja_eselon1';
				$field_unit_kerja = 'kode_e1';
				$field_iku = 'kode_iku_e1';
			break;
			case 'E2' : 
				$table_name = 'tbl_kinerja_eselon2';
				$field_unit_kerja = 'kode_e2';
				$field_iku = 'kode_iku_e2';
			break;
		}
		$this->db->select('count(*) as jumlah',false);
		$this->db->from($table_name);
		$this->db->where($field_unit_kerja, $unit_kerja);
		//$this->db->where($field_iku, $kode_iku);
		$this->db->where('tahun', $tahun);
		$this->db->where('triwulan', $bulan);
		$query = $this->db->get();
		if ($query->num_rows()>0)
			return $query->row()->jumlah;
		else return 0;
		
	}
	
	public function getStatus($countPk,$countRealisasi){
		if ($countRealisasi == 0)
			return "K";
		else if ($countPk<=$countRealisasi)
			return "L";
		else if($countPk>$countRealisasi)
		    return "TL";
	}
}
?>

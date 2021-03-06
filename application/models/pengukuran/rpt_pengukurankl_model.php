<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Rpt_pengukurankl_model extends CI_Model
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
	public function easyGrid($filtahun=null,$filsasaran=null,$filiku=null,$purpose=1,$pageNumber=null,$pageSize=null){
		$lastNo = isset($_POST['lastNo']) ? intval($_POST['lastNo']) : 0;  
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		//jika utk pdf & excel maka paging ambil dari parameter
		if (($purpose==2)||($purpose==3)){
			$page = isset($pageNumber) ? intval($pageNumber) : 1;  
			$limit = isset($pageSize) ? intval($pageSize) : 10;  
			//var_dump($pageNumber);
		//	var_dump($pageSize);
		}
		$count = $this->GetRecordCount($filtahun,$filsasaran,$filiku);
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
			
			if($filsasaran != '' && $filsasaran != '-1' && $filsasaran != '0' && $filsasaran != null) {
					$where1.=" and pk.kode_sasaran_kl='$filsasaran'";
					$where2.=" and pk.kode_sasaran_kl='$filsasaran'";
			}
			if($filiku != '' && $filiku != '-1' && $filiku != null) {
					$where1.=" and iku.kode_iku_kl='$filiku'";
					$where1.=" and iku.kode_iku_kl='$filiku'";
			}
			
			//$this->db->order_by($sort." ".$order );
			//hanya utk grid saja
			if ($purpose==1) $this->db->limit($limit,$offset);
			if ($where1!='') $where1 = "where ".substr($where1,5,strlen($where1));
			if ($where2!='') $where2 = "where ".substr($where2,5,strlen($where2));
		//hanya utk grid saja
			$limitMode = '';
			if ($purpose==1) $limitMode = " limit $offset, $limit";
			$sql = 'select * from (select iku.deskripsi as indikator_kinerja, iku.satuan,iku.kode_iku_kl
from tbl_iku_kl iku  left join tbl_pk_kl pk on pk.kode_iku_kl=iku.kode_iku_kl and pk.tahun=iku.tahun  '.$where2.'
			union 
			select iku.deskripsi as indikator_kinerja,   iku.satuan,iku.kode_iku_kl 
from tbl_iku_kl iku   left join tbl_pk_kl pk on pk.kode_iku_kl=iku.kode_iku_kl and pk.tahun=iku.tahun '.$where1.'
) as t1 order by kode_iku_kl '.$limitMode;
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
				$response->rows[$i]['indikator_kinerja']=$row->indikator_kinerja;				
				
				$response->rows[$i]['satuan']=$row->satuan;					
				$response->rows[$i]['persenPast']='';	
				$response->rows[$i]['persenNow']='';	
				$targetNow = $this->getTarget($filtahun,$row->kode_iku_kl);	
				$targetPast = $this->getTarget($filtahun-1,$row->kode_iku_kl);	
				$realisasiNow = $this->getRealisasi($filtahun,$row->kode_iku_kl);	
				$realisasiPast = $this->getRealisasi($filtahun-1,$row->kode_iku_kl);	
			
				
				$response->rows[$i]['targetNow']=$this->utility->cekNumericFmt($targetNow);
				$response->rows[$i]['targetPast']=$this->utility->cekNumericFmt($targetPast);
				$response->rows[$i]['realisasiNow']=$this->utility->cekNumericFmt($realisasiNow);
				$response->rows[$i]['realisasiPast']=$this->utility->cekNumericFmt($realisasiPast);
				$response->rows[$i]['opini']=$this->getOpini($filtahun,$row->kode_iku_kl);
				$keterangan ='';
				if ($realisasiNow==$realisasiPast)	$keterangan = 'Tetap';
				else if ($realisasiNow>$realisasiPast)	$keterangan = 'Naik';
				else if ($realisasiNow<$realisasiPast)	$keterangan = 'Turun';
				$response->rows[$i]['keterangan']=$keterangan;
				
				if ((is_numeric($targetPast))&&(is_numeric($realisasiPast))){
					$response->rows[$i]['persenPast']= ($targetPast!=0?$this->utility->cekNumericFmt($realisasiPast/$targetPast*100)." %":"-");
					if (($targetPast!=0)&&($targetPast!=null))   $sumRataPast += $realisasiPast/$targetPast*100;
				}	
				if ((is_numeric($targetNow))&&(is_numeric($realisasiNow))){
					$response->rows[$i]['persenNow']= ($targetNow!=0?$this->utility->cekNumericFmt($realisasiNow/$targetNow*100)." %":"-");
					if (($targetNow!=0)&&($targetNow!=null))  $sumRataNow += $realisasiNow/$targetNow*100;
				}	
				
				
				//utk kepentingan export excel ==========================
				$row->targetPast = $response->rows[$i]['targetPast'];
				$row->realisasiPast=$response->rows[$i]['realisasiPast'];
				$row->persenPast=$response->rows[$i]['persenPast'];
				$row->targetNow=$response->rows[$i]['targetNow'];
				$row->realisasiNow=$response->rows[$i]['realisasiNow'];				
				$row->persenNow=$response->rows[$i]['persenNow'];
				unset($row->kode_iku_kl);
				
			//============================================================
			//utk kepentingan export pdf===================
				$pdfdata[] = array($no,$response->rows[$i]['indikator_kinerja'],$response->rows[$i]['satuan'],$response->rows[$i]['targetPast'],$response->rows[$i]['realisasiPast'],$response->rows[$i]['persenPast'],$response->rows[$i]['targetNow'],$response->rows[$i]['realisasiNow'],$response->rows[$i]['persenNow']);
			//============================================================
			
			
				$i++;
			} 
			$i--;
			$response->lastNo = $no;
			if ($i==0) $i=1;//spy tidak div by zero
			$rataPast = $sumRataPast/$i;
			$rataNow = $sumRataNow/$i;
		//	$query->free_result();
		}else {
				
				$response->rows[$count]['no']= "";
				$response->rows[$count]['target']= "";
				$response->rows[$count]['satuan']= "";
				$response->rows[$count]['realisasi']='';
				$response->rows[$count]['indikator_kinerja']='';
				$response->rows[$count]['persenPast']='';	
				$response->rows[$count]['persenNow']='';
				$response->rows[$count]['opini']='';
				$response->rows[$count]['keterangan']='';
				$response->lastNo = 0;
		}
		
		//$response->footer[0]['sasaran_strategis']='<b>Rata </b>';
		$response->footer[0]['indikator_kinerja']='<b>Rata-rata capaian sasaran</b>';
		$response->footer[0]['no']='';
		$response->footer[0]['pejabat']='';		
		$response->footer[0]['no_indikator']='';
		$response->footer[0]['persenNow']='<b>'.$this->utility->cekNumericFmt($rataNow).' %</b>';
		$response->footer[0]['persenPast']='<b>'.$this->utility->cekNumericFmt($rataPast).' %</b>';
	//utk footer pdf ================
		$pdfdata[] = array("",'Rata-rata capaian sasaran','','','',$this->utility->cekNumericFmt($rataPast),'','',$this->utility->cekNumericFmt($rataNow));
	//-----------------------------------
	if ($purpose==1) //grid normal
			return json_encode($response);
		else if($purpose==2){//pdf
			return $pdfdata;
		}
		else if($purpose==3){//to excel
			//tambahkan header kolom
			$colHeaders = array("Indikator Kinerja Utama","Satuan","Target Tahun ".($filtahun-1),"Realisasi Tahun ".($filtahun-1),"% Tahun ".($filtahun-1),"Target Tahun ".($filtahun),"Realisasi Tahun ".($filtahun),"% Tahun ".($filtahun));		
			to_excel($query,"PengukuranKinerjaKl",$colHeaders);
		}
		
	}
	
	public function GetRecordCount($filtahun=null,$filsasaran=null,$filiku=null){
		$where1 = '';
		$where2 = '';
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$where1.=" and pk.tahun='$filtahun'";
				$where2.=" and pk.tahun='".($filtahun-1)."'";
			}		
			
			if($filsasaran != '' && $filsasaran != '-1' && $filsasaran != '0' && $filsasaran != null) {
					$where1.=" and pk.kode_sasaran_kl='$filsasaran'";
					$where2.=" and pk.kode_sasaran_kl='$filsasaran'";
			}
			if($filiku != '' && $filiku != '-1' && $filiku != null) {
					$where1.=" and iku.kode_iku_kl='$filiku'";
					$where1.=" and iku.kode_iku_kl='$filiku'";
			}
		if ($where1!="") $where1 = " where ".substr($where1,5,strlen($where1));
		if ($where2!="") $where2 = " where ".substr($where2,5,strlen($where2));
	
		 $sql = 'select count(*) as num_rows from (select iku.deskripsi as indikator_kinerja, iku.satuan,iku.kode_iku_kl
from tbl_iku_kl iku  left join tbl_pk_kl pk on pk.kode_iku_kl=iku.kode_iku_kl and pk.tahun=iku.tahun  '.$where2.'
			union 
			select iku.deskripsi as indikator_kinerja,   iku.satuan,iku.kode_iku_kl 
from tbl_iku_kl iku   left join tbl_pk_kl pk on pk.kode_iku_kl=iku.kode_iku_kl and pk.tahun=iku.tahun '.$where1.'
  ) as t1';
		$q = $this->db->query($sql);
		return $q->row()->num_rows; 
	}
	
	public function getListTahun($objectId){
		
		$this->db->flush_cache();
		$this->db->select('distinct tahun',false);
		$this->db->from('tbl_pk_kl');
		
		$this->db->order_by('tahun');
		
		$que = $this->db->get();
		
		$out = '<select name="filter_tahun'.$objectId.'" id="filter_tahun'.$objectId.'">';
		//$out .= '<option value="">Semua</option>';
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->tahun.'">'.$r->tahun.'</option>';
		}
		
		$out .= '</select>';
		//chan
		if ($que->num_rows()==0){
			$out = "Data Program PK belum tersedia.";
		}
		
		echo $out;
	}
	
	public function getRealisasi($tahun,$kode_iku){
		$this->db->flush_cache();
		$this->db->select('realisasi as jumlah',false);
		$this->db->from('tbl_pengukuran_kl');
		$this->db->where('kode_iku_kl', $kode_iku);
		$this->db->where('tahun', $tahun);
		$query = $this->db->get();
		if ($query->num_rows()>0)
			return $query->row()->jumlah;
		else return 0;
		
	}
	
	public function getOpini($tahun,$kode_iku){
		$this->db->flush_cache();
		$this->db->select('opini',false);
		$this->db->from('tbl_pengukuran_kl');
		$this->db->where('kode_iku_kl', $kode_iku);
		$this->db->where('tahun', $tahun);
		$query = $this->db->get();
		if ($query->num_rows()>0)
			return $query->row()->opini;
		else return "";
		
	}
	
	public function getTarget($tahun,$kode_iku){
		$this->db->flush_cache();
		$this->db->select('penetapan as jumlah',false);
		$this->db->from('tbl_pk_kl');
		$this->db->where('kode_iku_kl', $kode_iku);
		$this->db->where('tahun', $tahun);
		$query = $this->db->get();
		if ($query->num_rows()>0)
			return $query->row()->jumlah;
		else return 0;
		
	}
	
}
?>

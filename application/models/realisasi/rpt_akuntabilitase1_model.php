<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Rpt_akuntabilitase1_model extends CI_Model
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
	public function easyGrid($filtahun=null,$filsasaran=null,$filiku=null,$file1=null,$purpose=1,$pageNumber=null,$pageSize=null){
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
		$count = $this->GetRecordCount($filtahun,$filsasaran,$filiku,$file1);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'tahun';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		$jumlah =0;
		$pdfdata = array();
		if ($count>0){
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("rkt.tahun",$filtahun);
			}		
			
			if($filsasaran != '' && $filsasaran != '-1' && $filsasaran != null) {
					$this->db->where("rkt.kode_sasaran_kl",$filsasaran);
			}
			if($filiku != '' && $filiku != '-1' && $filiku != null) {
					$this->db->where("rkt.kode_iku_kl",$filiku);
			}
			if($file1 != '' && $file1 != '-1' && $file1 != null) {
					$this->db->where("rkt.kode_e1",$file1);
			}
			$this->db->group_by('sasaran.deskripsi, sasaran.kode_sasaran_e1');
			//$this->db->order_by($sort." ".$order );
			$this->db->order_by("sasaran.deskripsi");
			//hanya utk grid saja
			if ($purpose==1) $this->db->limit($limit,$offset);
			//$this->db->select("*",false);
			$this->db->select("sasaran.deskripsi as sasaran_strategis, count(iku.kode_iku_e1) as indikator_kinerja, sasaran.kode_sasaran_e1",false);
			//$this->db->from('tbl_rkt_kl');
			$this->db->from('tbl_kinerja_eselon1 rkt inner join tbl_iku_eselon1 iku on iku.kode_iku_e1 = rkt.kode_iku_e1
inner join tbl_sasaran_eselon1 sasaran on sasaran.kode_sasaran_e1 = rkt.kode_sasaran_e1',false);
			$query = $this->db->get();
			
			$i=0;
			$sasaran_strategis ="";
			$indikator_kinerja ="";
			$no = ($page-1)*$limit;//$lastNo;
			$noIndikator =0;
			
			foreach ($query->result() as $row)
			{
				//$response->rows[$i]['id_rkt_kl']=$row->id_rkt_kl;
				if ($sasaran_strategis!=$row->sasaran_strategis){
					$no++;
					$noIndikator =0;
					$response->rows[$i]['no']= $no;
					
					$response->rows[$i]['sasaran_strategis']=$row->sasaran_strategis;
					$sasaran_strategis=$row->sasaran_strategis;
				}
				else{
					$response->rows[$i]['sasaran_strategis']=$row->sasaran_strategis;//"";
					$response->rows[$i]['no']= "";
				}
				
				if ($indikator_kinerja!=$row->indikator_kinerja){	
					$noIndikator++;
					$response->rows[$i]['no_indikator']= $no.".".$noIndikator;
					$response->rows[$i]['indikator_kinerja']=$row->indikator_kinerja.' Indikator Kinerja';
					$indikator_kinerja=$row->indikator_kinerja;
				}else {	
					$response->rows[$i]['indikator_kinerja']=$row->indikator_kinerja.' Indikator Kinerja';
					$response->rows[$i]['no_indikator']="";
				}
				
				$jumlah += $row->indikator_kinerja;
				
				$response->rows[$i]['pejabat']=$this->getPejabatE2($row->kode_sasaran_e1,$filtahun);
			//utk kepentingan export excel ==========================
				$row->keterangan = str_replace("<br>",", ",$response->rows[$i]['pejabat']);
				$row->indikator_kinerja=$response->rows[$i]['indikator_kinerja'];
				unset($row->kode_sasaran_e1);
			//============================================================
				
			//utk kepentingan export pdf===================
				$pdfdata[] = array($no,$response->rows[$i]['sasaran_strategis'],$response->rows[$i]['indikator_kinerja'],str_replace("<br>","\n",$response->rows[$i]['pejabat']));
			//============================================================
				$i++;
			} 
			$response->lastNo = $no;
		
		//	$query->free_result();
		}else {
				
				$response->rows[$count]['no']= "";
				$response->rows[$count]['no_indikator']= "";
				$response->rows[$count]['sasaran_srategis']='';
				$response->rows[$count]['indikator_kinerja']='';
				$response->rows[$count]['pejabat']='';
				$response->lastNo = 0;
		}
		
		$response->footer[0]['sasaran_strategis']='<b>Jumlah </b>';
		$response->footer[0]['indikator_kinerja']='<b>'.$this->utility->cekNumericFmt($jumlah).' Indikator Kinerja</b>';
		$response->footer[0]['no']='';
		$response->footer[0]['pejabat']='';		
		$response->footer[0]['no_indikator']='';
			
		//utk footer pdf ================
			$pdfdata[] = array("",'Jumlah',$this->utility->cekNumericFmt($jumlah).'  Indikator Kinerja','');
	//-----------------------------------
		if ($purpose==1) //grid normal
			return json_encode($response);
		else if($purpose==2){//pdf
			return $pdfdata;
		}
		else if($purpose==3){//to excel
			//tambahkan header kolom
			$colHeaders = array("Sasaran Strategis","Jumlah Indikator Kinerja","Keterangan");		
		//	var_dump($query->result());die;
			to_excel($query,"SebaranIkuEselon1",$colHeaders);
		}
		
	}
	
	public function GetRecordCount($filtahun=null,$filsasaran=null,$filiku=null,$file1=null){
		$where = '';
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
			$where.= " and rkt.tahun='$filtahun'";
		}		
			
		if($filsasaran != '' && $filsasaran != '-1' && $filsasaran != null) {
			$where.=" and rkt.kode_sasaran_kl='$filsasaran'";
		}
		if($filiku != '' && $filiku != '-1' && $filiku != null) {
				$where.=" and rkt.kode_iku_kl='$filiku'";
		}	
		if($file1 != '' && $file1 != '-1' && $file1 != null) {
			$where.=" and rkt.kode_e1='$file1'";
		}
		if ($where!="")
			$where = " where ".substr($where,5,strlen($where));
		//$this->db->from('tbl_kinerja_klx rkt inner join tbl_iku_kl iku on iku.kode_iku_kl = rkt.kode_iku_kl inner join tbl_sasaran_kl sasaran on sasaran.kode_sasaran_kl = rkt.kode_sasaran_kl',false);
		//$this->db->from('select sasaran.deskripsi from tbl_kinerja_kl rkt inner join tbl_iku_kl iku on iku.kode_iku_kl = rkt.kode_iku_kl inner join tbl_sasaran_kl sasaran on sasaran.kode_sasaran_kl = rkt.kode_sasaran_kl '.$where.' GROUP BY sasaran.deskripsi, sasaran.kode_sasaran_kl ) as t1',false);
		//$this->db->group_by('sasaran.deskripsi, sasaran.kode_sasaran_kl');
		$sql = 'select count(*) as num_rows from (select sasaran.deskripsi from tbl_kinerja_eselon1 rkt inner join tbl_iku_eselon1 iku on iku.kode_iku_e1 = rkt.kode_iku_e1 inner join tbl_sasaran_eselon1 sasaran on sasaran.kode_sasaran_e1 = rkt.kode_sasaran_e1 '.$where.' GROUP BY sasaran.deskripsi, sasaran.kode_sasaran_e1 ) as t1';
		$q = $this->db->query($sql);
		return $q->row()->num_rows; 
		//return $this->db->count_all_results();
		//$this->db->free_result();
	}
	
	public function getListTahun($objectId){
		
		$this->db->flush_cache();
		$this->db->select('distinct tahun',false);
		$this->db->from('tbl_kinerja_eselon1');
		$e1 = $this->session->userdata('unit_kerja_e1');
		if (($e1!="-1")&&($e1!=null)){
			$this->db->where('kode_e1',$e1);
			//$value = $e1;
		}
		$this->db->order_by('tahun');
		
		$que = $this->db->get();
		
		$out = '<select name="filter_tahun'.$objectId.'" id="filter_tahun'.$objectId.'">';
	//	$out .= '<option value="">Semua</option>';
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->tahun.'">'.$r->tahun.'</option>';
		}
		
		$out .= '</select>';
		//chan
		if ($que->num_rows()==0){
			$out = "Data Kinerja belum tersedia.";
		}
		echo $out;
	}
	
	public function getPejabatE2($sasaranE1,$filtahun){
		$this->db->flush_cache();
		$this->db->select('e2.singkatan , concat(count(iku.kode_iku_e1), \' IKU\') as pejabat',false);
		$this->db->from('tbl_kinerja_eselon1 rkt inner join tbl_iku_eselon1 iku on iku.kode_iku_e1 = rkt.kode_iku_e1
inner join tbl_sasaran_eselon1 sasaran on sasaran.kode_sasaran_e1 = rkt.kode_sasaran_e1
inner join tbl_eselon2 e2 on e2.kode_e2=iku.kode_e2',false);
		$this->db->group_by('e2.singkatan');
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("rkt.tahun",$filtahun);
			}	
		$this->db->where('sasaran.kode_sasaran_e1',$sasaranE1);
		$query = $this->db->get();
		$out="";
		foreach($query->result() as $r){
			$out .= $r->singkatan.' '.$r->pejabat.'<br>';
			
		}
		
		if (strlen($out)>0){
			$out = substr($out,0,strlen($out)-4);
		}
		
		return $out;
		
	}
}
?>

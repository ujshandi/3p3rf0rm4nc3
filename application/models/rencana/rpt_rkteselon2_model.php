<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Rpt_rkteselon2_model extends CI_Model
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
	public function easyGrid($filtahun=null,$file2=null,$filsasaran=null,$filikk=null,$purpose=1,$pageNumber=null,$pageSize=null){
	//	var_dump($_POST['lastNo']);
		$lastNo = isset($_POST['lastNo']) ? intval($_POST['lastNo']) : 0;  
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->GetRecordCount($filtahun,$file2,$filsasaran,$filikk);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'sasaran_strategis';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		$pdfdata = array();
		if ($count>0){
			//filter
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("rkt.tahun",$filtahun);
			}		
			if($file2 != '' && $file2 != '-1' && $file2 != null) {
						$this->db->where("rkt.kode_e2",$file2);
			} else {
				$e1 = $this->session->userdata('unit_kerja_e1');
				if (($e1!="-1")&&($e1!=null)){
					$this->db->where('rkt.kode_e2 in (select kode_e2 from tbl_eselon2 where kode_e1 = \''.$e1.'\')');					
				}
			}
			if($filsasaran != '' && $filsasaran != '-1' && $filsasaran != null) {
					$this->db->where("rkt.kode_sasaran_e2",$filsasaran);
			}
			if($filikk != '' && $filikk != '-1' && $filikk != null) {
					$this->db->where("rkt.kode_ikk",$filikk);
			}
			//$this->db->order_by($sort." ".$order );
			$this->db->order_by("sasaran.kode_sasaran_e2,ikk.kode_ikk" );
			if ($purpose==1) $this->db->limit($limit,$offset);
			//$this->db->select("*",false);
			//$this->db->from('tbl_rkt_eselon2');
			$this->db->select("distinct sasaran.deskripsi as sasaran_strategis, ikk.deskripsi as indikator_kinerja, ikk.satuan,rkt.target ",false);
			$this->db->from('tbl_rkt_eselon2 rkt inner join tbl_ikk ikk on ikk.kode_ikk = rkt.kode_ikk
inner join tbl_sasaran_eselon2 sasaran on sasaran.kode_sasaran_e2 = rkt.kode_sasaran_e2',false);
			$query = $this->db->get();
			
			$i=0;
			$sasaran_strategis ="";
			$indikator_kinerja ="";
			$no =($page-1)*$limit;//$lastNo;
			$noIndikator =0;
			foreach ($query->result() as $row)
			{
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
					$response->rows[$i]['indikator_kinerja']=$row->indikator_kinerja;
					$indikator_kinerja=$row->indikator_kinerja;
				}else {	
					$response->rows[$i]['indikator_kinerja']="";
					$response->rows[$i]['no_indikator']="";
				}
				
				$response->rows[$i]['target']=$this->utility->cekNumericFmt($row->target);
				$response->rows[$i]['satuan']=$row->satuan;
//utk kepentingan export excel ==========================
				//$row->program = $program[0].", ".$program[1];
			//============================================================
			//utk kepentingan export pdf===================
				$pdfdata[] = array($no,$response->rows[$i]['sasaran_strategis'],$response->rows[$i]['no_indikator'],$response->rows[$i]['indikator_kinerja'],$response->rows[$i]['target'],$response->rows[$i]['satuan']);
			//============================================================
				$i++;
			} 
			$response->lastNo = $no;
			//$query->free_result();
		}else {
				//$response->rows[$count]['id_rkt_kl']=$row->id_rkt_kl;
				$response->rows[$count]['no']= "";
				$response->rows[$count]['no_indikator']= "";
				$response->rows[$count]['indikator_kinerja']='';
				$response->rows[$count]['sasaran_strategis']='';
				$response->rows[$count]['satuan']='';
				
				$response->rows[$count]['target']='';
				$response->lastNo = 0;
				
		}
		//$response->lastNo = $no;
		if ($purpose==1) //grid normal
			return json_encode($response);
		else if($purpose==2){//pdf
			return $pdfdata;
		}
		else if($purpose==3){//to excel
			//tambahkan header kolom
			$colHeaders = array("Sasaran Strategis","Deskripsi Indikator","Satuan","Target " );		
			to_excel($query,"RencanaKinerjaE2",$colHeaders);
		}
		
	}
	
	
	
	
		
	public function getListTahun($objectId){
		
		$this->db->flush_cache();
		$this->db->select('distinct tahun',false);
		$this->db->from('tbl_rkt_eselon2');
		$e2 = $this->session->userdata('unit_kerja_e2');
		if (($e2!="-1")&&($e2!=null)){
			$this->db->where('kode_e2',$e2);
			//$value = $e1;
		}
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
			$out = "Data RKT belum tersedia.";
		}
		
		echo $out;
	}
	
	public function GetRecordCount($filtahun=null,$file2=null,$filsasaran=null,$filikk=null){
				
		//filter
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
			$this->db->where("rkt.tahun",$filtahun);
		}		
		if($file2 != '' && $file2 != '-1' && $file2 != null) {
					$this->db->where("rkt.kode_e2",$file2);
		} else {
				$e1 = $this->session->userdata('unit_kerja_e1');
				if (($e1!="-1")&&($e1!=null)){
					$this->db->where('rkt.kode_e2 in (select kode_e2 from tbl_eselon2 where kode_e1 = \''.$e1.'\')');					
				}
			}
		if($filsasaran != '' && $filsasaran != '-1' && $filsasaran != null) {
				$this->db->where("rkt.kode_sasaran_e2",$filsasaran);
		}
		if($filikk != '' && $filikk != '-1' && $filikk != null) {
				$this->db->where("rkt.kode_ikk",$filikk);
		}		
		//$this->db->from('tbl_rkt_eselon2');
		$this->db->from('tbl_rkt_eselon2 rkt inner join tbl_ikk ikk on ikk.kode_ikk = rkt.kode_ikk
inner join tbl_sasaran_eselon2 sasaran on sasaran.kode_sasaran_e2 = rkt.kode_sasaran_e2',false);
		
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
		public function getSatuan($id){
		$this->db->flush_cache();
		$this->db->select('satuan');
		$this->db->from('tbl_ikk');
		$this->db->where('kode_ikk', $id);
		$query = $this->db->get();
		
		return $query->row()->satuan;
		
	}
	
}
?>

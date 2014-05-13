<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Rpt_penetapaneselon1_model extends CI_Model
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
	public function easyGrid($filtahun=null,$file1=null,$filsasaran=null,$filiku=null,$purpose=1,$pageNumber=null,$pageSize=null){
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
		$count = $this->GetRecordCount($filtahun,$file1,$filsasaran,$filiku);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'rkt.tahun';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		$pdfdata = array();
		$jumlah =0;
			$program = '';
			$tmpProgram='';
			$kodee1='';
		//	var_dump($count);
		if ($count>0){
			//filter
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("rkt.tahun",$filtahun);
			}		
			if($file1 != '' && $file1 != '-1' && $file1 != null) {
						$this->db->where("rkt.kode_e1",$file1);
			}
			if($filsasaran != '' && $filsasaran != '-1' && $filsasaran != null) {
					$this->db->where("rkt.kode_sasaran_e1",$filsasaran);
			}
			if($filiku != '' && $filiku != '-1' && $filiku != null) {
					$this->db->where("rkt.kode_iku_e1",$filiku);
			}
			
			//$this->db->order_by($sort." ".$order );
				//$this->db->order_by("sasaran_strategis,indikator_kinerja" );
				$this->db->order_by("rkt.kode_e1, rkt.kode_sasaran_e1, rkt.kode_iku_e1" );
			//hanya utk grid saja
			if ($purpose==1) $this->db->limit($limit,$offset);
			$this->db->select("distinct rkt.kode_e1, sasaran.deskripsi as sasaran_strategis, iku.deskripsi as indikator_kinerja, rkt.target, iku.satuan, p.nama_program",false);
			$this->db->from('tbl_pk_eselon1 rkt inner join tbl_iku_eselon1 iku on iku.kode_iku_e1 = rkt.kode_iku_e1 and iku.tahun=rkt.tahun inner join tbl_sasaran_eselon1 sasaran on sasaran.kode_sasaran_e1 = rkt.kode_sasaran_e1 and sasaran.tahun=rkt.tahun left join tbl_program_kl p on p.kode_e1 = rkt.kode_e1 and p.tahun=rkt.tahun', false);
			$query = $this->db->get();
			
			$i=0;
			$sasaran_strategis ="";
			$indikator_kinerja ="";
			$no =  $lastNo;
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
					$response->rows[$i]['sasaran_strategis']=$row->sasaran_strategis;//""
					$response->rows[$i]['no']= "";
				}
				
				//if ($indikator_kinerja!=$row->indikator_kinerja){	
					$noIndikator++;
					$response->rows[$i]['no_indikator']= $no.".".$noIndikator;
					$response->rows[$i]['indikator_kinerja']=$row->indikator_kinerja;
					$indikator_kinerja=$row->indikator_kinerja;
				/* }else {	
					$response->rows[$i]['indikator_kinerja']="";
					$response->rows[$i]['no_indikator']="";
				} */
				
				$response->rows[$i]['target']=$this->utility->cekNumericFmt($row->target);
				$response->rows[$i]['satuan']=$row->satuan;
				if ($kodee1!=$row->kode_e1){
					$jumlah += $this->getTotalProgram($row->kode_e1,$filtahun);
					$kodee1 = $row->kode_e1;
				}
				if ($tmpProgram!=$row->nama_program){
					$program .= $row->nama_program.", ";
					$tmpProgram = $row->nama_program;
				}
				//utk kepentingan export excel ==========================
				//$row->no_indikator = $noIndikator; -- di-hide dulu krn insert di kolom terakhir
				//unset($row->kode_e1);
				//unset($row->satuan);
				unset($row->nama_program);
				//============================================================
				//utk kepentingan export pdf===================
					$pdfdata[] = array($no,$response->rows[$i]['sasaran_strategis'],$response->rows[$i]['no_indikator'],$response->rows[$i]['indikator_kinerja'],$response->rows[$i]['target'],$response->rows[$i]['satuan']);
				//============================================================
				$i++;
			} 
			if ($program!='')
				$program = substr($program,0,strlen($program)-1);
				$response->lastNo = $no;
			//$query->free_result();
		}else {
				//$response->rows[$count]['id_rkt_kl']=$row->id_rkt_kl;
				$response->rows[$count]['no']= "";
				$response->rows[$count]['no_indikator']= "";
				$response->rows[$count]['indikator_kinerja']='';
				$response->rows[$count]['sasaran_strategis']='';
				$response->rows[$count]['target']='';
				$response->rows[$count]['satuan']='';
				$response->lastNo = 0;
				
		}
		
		$response->footer[0]['no']='';
		$response->footer[0]['no_indikator']='';
		$response->footer[0]['sasaran_strategis']='<b>Program : '.$program.'</b>';
		$response->footer[0]['indikator_kinerja']='<b>Jumlah Anggaran : Rp. '.$this->utility->cekNumericFmt($jumlah).'</b>';
		$response->footer[0]['target']='';
		
		//utk footer pdf ================
		$pdfdata[] = array("",'Program : '.$program,'','Jumlah Anggaran : Rp. '.$this->utility->cekNumericFmt($jumlah),'','','');
	//-----------------------------------
	if ($purpose==1) //grid normal
			return json_encode($response);
		else if($purpose==2){//pdf
			return $pdfdata;
		}
		else if($purpose==3){//to excel
			//tambahkan header kolom
			$colHeaders = array("Kode Eselon I", "Sasaran Strategis", "Deskripsi Indikator", "Target", "Satuan");
			to_excel($query,"PenetapanKinerjaE1",$colHeaders);
		}
	}
	
	
	
	public function GetRecordCount($filtahun=null,$file1=null,$file2=null,$filsasaran=null,$filiku=null){
		$where ='';
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
			$where.=" and rkt.tahun='$filtahun'";
		}		
		if($file1 != '' && $file1 != '-1' && $file1 != null) {
			$where.=" and rkt.kode_e1='$file1'";
		}
		if($filsasaran != '' && $filsasaran != '-1' && $filsasaran != null) {
			$where.=" and rkt.kode_sasaran_e1='$filsasaran'";
		}
		if($filiku != '' && $filiku != '-1' && $filiku != null) {
			$where.=" and rkt.kode_iku_e1='$filiku'";
		}
		
		//$this->db->from('tbl_pk_eselon1 rkt inner join tbl_iku_eselon1 iku on iku.kode_iku_e1 = rkt.kode_iku_e1 inner join tbl_sasaran_eselon1 sasaran on sasaran.kode_sasaran_e1 = rkt.kode_sasaran_e1', false);
		if ($where!="")
			$where = " where ".substr($where,5,strlen($where));
		//$this->db->from('tbl_kinerja_klx rkt inner join tbl_iku_kl iku on iku.kode_iku_kl = rkt.kode_iku_kl inner join tbl_sasaran_kl sasaran on sasaran.kode_sasaran_kl = rkt.kode_sasaran_kl',false);
		
		$sql = 'select count(*) as num_rows from (select distinct sasaran.deskripsi as sasaran_strategis, iku.deskripsi as indikator_kinerja, rkt.target,rkt.kode_e1,p.nama_program,iku.satuan from tbl_pk_eselon1 rkt inner join tbl_iku_eselon1 iku on iku.kode_iku_e1 = rkt.kode_iku_e1 and iku.tahun=rkt.tahun inner join tbl_sasaran_eselon1 sasaran on sasaran.kode_sasaran_e1 = rkt.kode_sasaran_e1 and sasaran.tahun=rkt.tahun left join tbl_program_kl p on p.kode_e1 = rkt.kode_e1 and p.tahun=rkt.tahun '.$where.') as t1';
		$q = $this->db->query($sql);
		return $q->row()->num_rows; 
		
		//return $this->db->count_all_results();
		//$this->db->free_result();
	}
	
	public function getListTahun($objectId){
		
		$this->db->flush_cache();
		$this->db->select('distinct tahun',false);
		$this->db->from('tbl_pk_eselon1');
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
			$out = "Data Program PK belum tersedia.";
		}
		
		echo $out;
	}
	
	public function getSatuan($id){
		$this->db->flush_cache();
		$this->db->select('satuan');
		$this->db->from('tbl_iku');
		$this->db->where('kode_iku', $id);
		$query = $this->db->get();
		
		return $query->row()->satuan;
		
	}
	
	public function getTotalProgram($e1,$tahun){
		$this->db->flush_cache();
		$this->db->select('sum(total) as jumlah',false);
		$this->db->from('tbl_program_kl');
		$this->db->where('kode_e1', $e1);
		$this->db->where('tahun', $tahun);
		$query = $this->db->get();
		
		return $query->row()->jumlah;
		
	}
	
}
?>

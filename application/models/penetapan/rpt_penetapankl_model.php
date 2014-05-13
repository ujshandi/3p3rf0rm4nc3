<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Rpt_penetapankl_model extends CI_Model
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
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'sasaran_strategis';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		$pdfdata = array();
		$totalProgram =0;
		$kodekl='';
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
			
			//$this->db->order_by($sort." ".$order );
			$this->db->order_by("rkt.kode_sasaran_kl, rkt.kode_iku_kl" );
			//hanya utk grid saja
			if ($purpose==1) $this->db->limit($limit,$offset);
			//$this->db->select("*",false);
			$this->db->select("distinct sasaran.deskripsi as sasaran_strategis, iku.deskripsi as indikator_kinerja, rkt.target, iku.satuan",false);
			//$this->db->from('tbl_rkt_kl');
			$this->db->from('tbl_pk_kl rkt inner join tbl_iku_kl iku on iku.kode_iku_kl = rkt.kode_iku_kl  and iku.tahun=rkt.tahun
inner join tbl_sasaran_kl sasaran on sasaran.kode_sasaran_kl = rkt.kode_sasaran_kl  and sasaran.tahun=rkt.tahun ',false);
			$query = $this->db->get();
			
			$i=0;
			$sasaran_strategis ="";
			$indikator_kinerja ="";
			$no =  $lastNo;
			$noIndikator =0;
			$jumlah =0;
			
			$rowMergeSasaran=1;
			foreach ($query->result() as $row)
			{
				//$response->rows[$i]['id_rkt_kl']=$row->id_rkt_kl;
				if ($sasaran_strategis!=$row->sasaran_strategis){
					$no++;
					$noIndikator =0;
					$response->rows[$i]['no']= $no;
					
					$response->rows[$i]['sasaran_strategis']=$row->sasaran_strategis;
					$sasaran_strategis=$row->sasaran_strategis;
					$rowMergeSasaran=1;
				}
				else{
					$response->rows[$i]['sasaran_strategis']=$row->sasaran_strategis;//"";
					$response->rows[$i]['no']= "";
					$rowMergeSasaran++;
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
				
				$jumlah += $row->target;
				//$response->rows[$i]['kode_sasaran_kl']=$row->kode_sasaran_kl;
				//$response->rows[$i]['kode_iku']=$row->kode_iku;
				$response->rows[$i]['target']=$this->utility->cekNumericFmt($row->target);
				$response->rows[$i]['satuan']=$row->satuan;
				//$response->rows[$i]['satuan']=$row->satuan;
				$program = $this->getProgram(false,$filtahun);
				$response->rows[$i]['program']=$program[0];
				$response->rows[$i]['anggaran']=$program[1];

				//utk kepentingan export excel ==========================
				//$row->program = $program[0].", ".$program[1];
				//============================================================

				//utk kepentingan export pdf===================
				$pdfdata[] = array($no,$response->rows[$i]['sasaran_strategis'],$response->rows[$i]['no_indikator'],$response->rows[$i]['indikator_kinerja'],$response->rows[$i]['target'],$response->rows[$i]['satuan'],$response->rows[$i]['program'],$rowMergeSasaran);
				//============================================================
				$i++;
			} 
			$response->lastNo = $no;
			$totalProgram =$this->getTotalProgram($filtahun);
			//$query->free_result();
		}else {
				//$response->rows[$count]['id_rkt_kl']=$row->id_rkt_kl;
				$response->rows[$count]['no']= "";
				$response->rows[$count]['no_indikator']= "";
				$response->rows[$count]['sasaran_srategis']='';
				$response->rows[$count]['indikator_kinerja']='';
				//$response->rows[$count]['kode_sasaran_kl']='';
				//$response->rows[$count]['kode_iku']='';
				$response->rows[$count]['target']='';
				//$response->rows[$count]['satuan']='';
				$response->rows[$count]['program']='';
				$response->rows[$count]['anggaran']='';
				$response->rows[$count]['satuan']='';
				$response->lastNo = 0;
		}
		
		$response->footer[0]['sasaran_strategis']='<b>Jumlah Total Anggaran Tahun '.$filtahun.'</b>';
		$response->footer[0]['indikator_kinerja']='<b>'.$this->utility->cekNumericFmt($totalProgram).'</b>';
		$response->footer[0]['no']='';
		$response->footer[0]['program']='';
		$response->footer[0]['anggaran']='';
		$response->footer[0]['no_indikator']='';
		$response->footer[0]['target']='';
		//utk footer pdf ================
		$pdfdata[] = array("",'Jumlah Total Anggaran Tahun '.$filtahun,'',$this->utility->cekNumericFmt($this->getTotalProgram($filtahun)),'','','',1);
	//-----------------------------------
	if ($purpose==1) //grid normal
			return json_encode($response);
		else if($purpose==2){//pdf
			return $pdfdata;
		}
		else if($purpose==3){//to excel
			//tambahkan header kolom
			$colHeaders = array("Sasaran Strategis","Indikator Kinerja Utama","Target","Satuan");		
			to_excel($query,"PenetapanKinerjaKl",$colHeaders);
		}
	}
	
	public function GetRecordCount($filtahun=null,$filsasaran=null,$filiku=null){
		$where = '';
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
			$where.=" and rkt.tahun='$filtahun'";
		}		
			
		if($filsasaran != '' && $filsasaran != '-1' && $filsasaran != null) {
			$where.=" and rkt.kode_sasaran_e1='$filsasaran'";
		}
		if($filiku != '' && $filiku != '-1' && $filiku != null) {
				$where.=" and rkt.kode_iku_e1='$filiku'";
		}	
		/* $this->db->from('tbl_pk_kl rkt inner join tbl_iku_kl iku on iku.kode_iku_kl = rkt.kode_iku_kl
inner join tbl_sasaran_kl sasaran on sasaran.kode_sasaran_kl = rkt.kode_sasaran_kl',false);
		
		return $this->db->count_all_results();
		$this->db->free_result(); */
		
		if ($where!="")
			$where = " where ".substr($where,5,strlen($where));
			
		$sql = 'select count(*) as num_rows from (select distinct sasaran.deskripsi as sasaran_strategis, iku.deskripsi as indikator_kinerja, rkt.target ,iku.satuan from tbl_pk_kl rkt inner join tbl_iku_kl iku on iku.kode_iku_kl = rkt.kode_iku_kl  and iku.tahun=rkt.tahun inner join tbl_sasaran_kl sasaran on sasaran.kode_sasaran_kl = rkt.kode_sasaran_kl  and sasaran.tahun=rkt.tahun '.$where.') as t1';
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
	
	
	public function getTotalProgram($filtahun){
		$this->db->flush_cache();
		$this->db->select('sum(total) as jumlah',false);
		$this->db->from('tbl_program_kl');
		$this->db->where('tahun', $filtahun);
		$query = $this->db->get();
		
		return $query->row()->jumlah;
		
	}
	
	public function getProgram($forPdf=false,$tahun){
		$this->db->flush_cache();
		$this->db->select('nama_program,total',false);
		$this->db->from('tbl_program_kl');
		$this->db->where('tahun', $tahun);
		$query = $this->db->get();
		$out = array();
		$out[0] = "";
		$out[1] = "";
		if ($forPdf){
			return $query;
		}
		else {
			foreach($query->result() as $r){
				$out[0] .= "Program : ".$r->nama_program.'<br>';
				$out[0] .= "Anggaran : Rp. ".number_format($r->total,0).'<br><br>';
				$out[1] .= "".number_format($r->total,0).'<br>';
			}
			
			if (strlen($out[0])>0){
				$out[0] = substr($out[0],0,strlen($out[0])-8);
			}
			if (strlen($out[1])>0){
				$out[1] = substr($out[1],0,strlen($out[1])-2);
			}
			
			return $out;
		}
	}
}
?>

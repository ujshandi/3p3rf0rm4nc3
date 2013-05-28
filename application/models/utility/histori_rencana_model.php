<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class histori_rencana_model extends CI_Model
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
	public function KL_grid($filtahun=null,$purpose=1){
		$lastNo = isset($_POST['lastNo']) ? intval($_POST['lastNo']) : 0;
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->KL_grid_count($filtahun);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id_rkt_kl';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		$pdfdata = array();
		if ($count>0){
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("tahun",$filtahun);
			}
			$this->db->order_by($sort." ".$order );
			if($purpose==1){$this->db->limit($limit,$offset);}
			$this->db->select("a.*, b.nama_kl, c.deskripsi as deskripsi_sasaran_kl, d.deskripsi as deskripsi_iku_kl",false);
			$this->db->from('tbl_rkt_kl_log a');
			$this->db->join('tbl_kl b', 'b.kode_kl = a.kode_kl');
			$this->db->join('tbl_sasaran_kl c', 'c.kode_sasaran_kl = a.kode_sasaran_kl','left' );
			$this->db->join('tbl_iku_kl d', 'd.kode_iku_kl = a.kode_iku_kl','left' );
			$this->db->order_by("a.id_rkt_kl ASC");
			$query = $this->db->get();
			
			$i=0;
			$no =$lastNo;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				$response->rows[$i]['tahun']=$row->tahun;
				$response->rows[$i]['kode_kl']=$row->kode_kl;
				$response->rows[$i]['nama_kl']=$row->nama_kl;
				$response->rows[$i]['kode_sasaran_kl']=$row->kode_sasaran_kl;
				$response->rows[$i]['deskripsi_sasaran_kl']=$row->deskripsi_sasaran_kl;
				$response->rows[$i]['kode_iku_kl']=$row->kode_iku_kl;
				$response->rows[$i]['deskripsi_iku_kl']=$row->deskripsi_iku_kl;
				$response->rows[$i]['target']=$row->target;
				
				$xlog = explode(';', $row->log);
				$response->rows[$i]['log_status']=$xlog[0];
				$response->rows[$i]['log_user']=$xlog[1];
				$response->rows[$i]['log_date']=$xlog[2];
			//utk kepentingan export excel ==========================
				// $row->keterangan = str_replace("<br>",", ",$response->rows[$i]['pejabat']);
				// $row->indikator_kinerja=$response->rows[$i]['indikator_kinerja'];
				unset($row->kode_kl);
				unset($row->nama_kl);
				unset($row->deskripsi_sasaran_kl);
				unset($row->deskripsi_iku_kl);
			//============================================================
				
			//utk kepentingan export pdf===================
				$pdfdata[] = array($no,$response->rows[$i]['kode_sasaran_kl'],$response->rows[$i]['kode_iku_kl'],$response->rows[$i]['target'], $response->rows[$i]['log_status'], $response->rows[$i]['log_user'], $response->rows[$i]['log_date']);
			//============================================================
				$i++;
			} 
			
			$response->lastNo = $no;
			// $query->free_result();
		}else {
				$response->rows[$count]['no']= '';
				$response->rows[$count]['tahun']='';
				$response->rows[$count]['kode_kl']='';
				$response->rows[$count]['nama_kl']='';
				$response->rows[$count]['kode_sasaran_kl']='';
				$response->rows[$count]['deskripsi_sasaran_kl']='';
				$response->rows[$count]['kode_iku_kl']='';
				$response->rows[$count]['deskripsi_iku_kl']='';
				$response->rows[$count]['target']='';
				$response->rows[$count]['log_status']='';
				$response->rows[$count]['log_user']='';
				$response->rows[$count]['log_date']='';
				$response->lastNo = 0;				
		}
		
		if ($purpose==1) //grid normal
			return json_encode($response);
		else if($purpose==2){//pdf
			return $pdfdata;
		}
		else if($purpose==3){//to excel
			//tambahkan header kolom
			$colHeaders = array("Tahun","Kode Sasaran","Kode IKU","Target","Log");		
			//var_dump($query->result());die;
			to_excel($query,"RKTKementerian",$colHeaders);
		}
	
	}
	
	public function KL_grid_count($filtahun=null){		
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
			$this->db->where("tahun",$filtahun);
		}
		$query=$this->db->from('tbl_rkt_kl_log');
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	
	// purpose : 1=buat grid, 2=buat pdf, 3=buat excel
	public function E1_grid($filtahun=null,$file1=null,$purpose=1){
		$lastNo = isset($_POST['lastNo']) ? intval($_POST['lastNo']) : 0;  
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->E1_grid_count($file1,$filtahun);
		
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'a.kode_e1';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		$pdfdata = array();
		if ($count>0){
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("a.tahun",$filtahun);
			}
			if($file1 != '' && $file1 != '-1' && $file1 != null) {
				$this->db->where("a.kode_e1",$file1);
			}
			$this->db->order_by($sort." ".$order );
			if($purpose==1){$this->db->limit($limit,$offset);}
			$this->db->select("a.tahun, a.kode_e1, b.nama_e1, a.kode_sasaran_e1, c.deskripsi AS deskripsi_sasaran_e1, a.kode_iku_e1, d.deskripsi AS deskripsi_iku_e1, a.target, a.log", false);
			$this->db->from('tbl_rkt_eselon1_log a');
			$this->db->join('tbl_eselon1 b', 'b.kode_e1 = a.kode_e1');
			$this->db->join('tbl_sasaran_eselon1 c', 'c.kode_sasaran_e1 = a.kode_sasaran_e1','left' );
			$this->db->join('tbl_iku_eselon1 d', 'd.kode_iku_e1 = a.kode_iku_e1','left' );
			$this->db->order_by("a.kode_e1 ASC, a.id_rkt_e1 ASC");
			$query = $this->db->get();
			
			$i=0;
			$no =$lastNo;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				$response->rows[$i]['tahun']=$row->tahun;
				$response->rows[$i]['kode_e1']=$row->kode_e1;
				$response->rows[$i]['nama_e1']=$row->nama_e1;
				$response->rows[$i]['kode_sasaran_e1']=$row->kode_sasaran_e1;
				$response->rows[$i]['deskripsi_sasaran_e1']=$row->deskripsi_sasaran_e1;
				$response->rows[$i]['kode_iku_e1']=$row->kode_iku_e1;	
				$response->rows[$i]['deskripsi_iku_e1']=$row->deskripsi_iku_e1;	
				$response->rows[$i]['target']=$row->target;	
				
				$xlog = explode(';', $row->log);
				$response->rows[$i]['log_status']=$xlog[0];
				$response->rows[$i]['log_user']=$xlog[1];
				$response->rows[$i]['log_date']=$xlog[2];
				
				//utk kepentingan export excel ==========================
				// $row->keterangan = str_replace("<br>",", ",$response->rows[$i]['pejabat']);
				// $row->indikator_kinerja=$response->rows[$i]['indikator_kinerja'];
				if($file1 != '' && $file1 != '-1' && $file1 != null)
					unset($row->kode_e1);
				unset($row->nama_e1);
				unset($row->deskripsi_sasaran_e1);
				unset($row->deskripsi_iku_e1);
				//============================================================
					
				//utk kepentingan export pdf===================
				if($file1 != '' && $file1 != '-1' && $file1 != null)
					$pdfdata[] = array($no,$response->rows[$i]['kode_sasaran_e1'],$response->rows[$i]['deskripsi_sasaran_e1'],$response->rows[$i]['kode_iku_e1'],$response->rows[$i]['deskripsi_iku_e1'],$response->rows[$i]['target'], $response->rows[$i]['log_status'], $response->rows[$i]['log_user'], $response->rows[$i]['log_date']);
				else
					$pdfdata[] = array($no,$response->rows[$i]['kode_e1'],$response->rows[$i]['kode_sasaran_e1'],$response->rows[$i]['deskripsi_sasaran_e1'],$response->rows[$i]['kode_iku_e1'],$response->rows[$i]['deskripsi_iku_e1'],$response->rows[$i]['target'], $response->rows[$i]['log_status'], $response->rows[$i]['log_user'], $response->rows[$i]['log_date']);
				//============================================================
				$i++;
			} 
			
			$response->lastNo = $no;
			// $query->free_result();
		}else {
				$response->rows[$count]['no']= "";
				$response->rows[$count]['tahun']='';
				$response->rows[$count]['kode_e1']='';
				$response->rows[$count]['nama_e1']='';
				$response->rows[$count]['kode_sasaran_e1']='';
				$response->rows[$count]['deskripsi_sasaran_e1']='';
				$response->rows[$count]['kode_iku_e1']='';
				$response->rows[$count]['deskripsi_iku_e1']='';
				$response->rows[$count]['target']='';
				$response->lastNo = 0;
		}
	
		if ($purpose==1) //grid normal
			return json_encode($response);
		else if($purpose==2){//pdf
			return $pdfdata;
		}
		else if($purpose==3){//to excel
			//tambahkan header kolom
			if($file1 != '' && $file1 != '-1' && $file1 != null)
				$colHeaders = array("Tahun", "Kode Sasaran", "Kode IKU", "Target");
			else
				$colHeaders = array("Tahun", "Kode Eselon I", "Kode Sasaran", "Kode IKU", "Target");		
		//	var_dump($query->result());die;
			to_excel($query,"RKTEselon1",$colHeaders);
		}
	}
	
	//jumlah data record buat paging
	public function E1_grid_count($file1,$filtahun){		
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
			$this->db->where("a.tahun",$filtahun);
		}
		if($file1 != '' && $file1 != '-1' && $file1 != null) {
			$this->db->where("a.kode_e1",$file1);
		}
		$this->db->from('tbl_rkt_eselon1_log a');
		$this->db->join('tbl_eselon1 b', 'b.kode_e1 = a.kode_e1');
		$this->db->join('tbl_sasaran_eselon1 c', 'c.kode_sasaran_e1 = a.kode_sasaran_e1','left' );
		$this->db->join('tbl_iku_eselon1 d', 'd.kode_iku_e1 = a.kode_iku_e1','left' );
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	// purpose : 1=buat grid, 2=buat pdf, 3=buat excel
	public function E2_grid($filtahun=null,$file1=null,$file2=null,$purpose=1){
		$lastNo = isset($_POST['lastNo']) ? intval($_POST['lastNo']) : 0;  
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->E2_grid_count($file1,$file2,$filtahun);
		
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'a.kode_e2';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		$pdfdata = array();
		if ($count>0){
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("a.tahun",$filtahun);
			}
			if($file1 != '' && $file1 != '-1' && $file1 != null) {
				$this->db->where("b.kode_e1",$file1);
			}
			if($file2 != '' && $file2 != '-1' && $file2 != null) {
				$this->db->where("a.kode_e2",$file2);
			}
			$this->db->order_by($sort." ".$order );
			if($purpose==1){$this->db->limit($limit,$offset);}
			$this->db->select("a.tahun, a.kode_e2, b.nama_e2, a.kode_sasaran_e2, c.deskripsi AS deskripsi_sasaran_e2, a.kode_ikk, d.deskripsi AS deskripsi_ikk, a.target, a.log", false);
			$this->db->from('tbl_rkt_eselon2_log a');
			$this->db->join('tbl_eselon2 b', 'b.kode_e2 = a.kode_e2');
			$this->db->join('tbl_sasaran_eselon2 c', 'c.kode_sasaran_e2 = a.kode_sasaran_e2','left' );
			$this->db->join('tbl_ikk d', 'd.kode_ikk = a.kode_ikk','left' );
			$this->db->order_by("a.kode_e2 ASC, a.id_rkt_e2 ASC");
			$query = $this->db->get();
			
			$i=0;
			$no =$lastNo;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				$response->rows[$i]['tahun']=$row->tahun;
				$response->rows[$i]['kode_e2']=$row->kode_e2;
				$response->rows[$i]['nama_e2']=$row->nama_e2;
				$response->rows[$i]['kode_sasaran_e2']=$row->kode_sasaran_e2;
				$response->rows[$i]['deskripsi_sasaran_e2']=$row->deskripsi_sasaran_e2;
				$response->rows[$i]['kode_ikk']=$row->kode_ikk;	
				$response->rows[$i]['deskripsi_ikk']=$row->deskripsi_ikk;	
				$response->rows[$i]['target']=$row->target;	
				
				$xlog = explode(';', $row->log);
				$response->rows[$i]['log_status']=$xlog[0];
				$response->rows[$i]['log_user']=$xlog[1];
				$response->rows[$i]['log_date']=$xlog[2];
				
				//utk kepentingan export excel ==========================
				// $row->keterangan = str_replace("<br>",", ",$response->rows[$i]['pejabat']);
				// $row->indikator_kinerja=$response->rows[$i]['indikator_kinerja'];
				if($file2 != '' && $file2 != '-1' && $file2 != null)
					unset($row->kode_e2);
				unset($row->nama_e2);
				unset($row->deskripsi_sasaran_e2);
				unset($row->deskripsi_ikk);
				//============================================================
					
				//utk kepentingan export pdf===================
				if($file2 != '' && $file2 != '-1' && $file2 != null)
					$pdfdata[] = array($no,$response->rows[$i]['kode_sasaran_e2'],$response->rows[$i]['deskripsi_sasaran_e2'],$response->rows[$i]['kode_ikk'],$response->rows[$i]['deskripsi_ikk'],$response->rows[$i]['target'], $response->rows[$i]['log_status'], $response->rows[$i]['log_user'], $response->rows[$i]['log_date']);
				else
					$pdfdata[] = array($no,$response->rows[$i]['kode_e2'],$response->rows[$i]['kode_sasaran_e2'],$response->rows[$i]['deskripsi_sasaran_e2'],$response->rows[$i]['kode_ikk'],$response->rows[$i]['deskripsi_ikk'],$response->rows[$i]['target'], $response->rows[$i]['log_status'], $response->rows[$i]['log_user'], $response->rows[$i]['log_date']);
				//============================================================
				$i++;
			} 
			
			$response->lastNo = $no;
			// $query->free_result();
		}else {
				$response->rows[$count]['no']= "";
				$response->rows[$count]['tahun']='';
				$response->rows[$count]['kode_e2']='';
				$response->rows[$count]['nama_e2']='';
				$response->rows[$count]['kode_sasaran_e2']='';
				$response->rows[$count]['deskripsi_sasaran_e2']='';
				$response->rows[$count]['kode_ikk']='';
				$response->rows[$count]['deskripsi_ikk']='';
				$response->rows[$count]['target']='';
				$response->lastNo = 0;
		}
	
		if ($purpose==1) //grid normal
			return json_encode($response);
		else if($purpose==2){//pdf
			return $pdfdata;
		}
		else if($purpose==3){//to excel
			//tambahkan header kolom
			if($file2 != '' && $file2 != '-1' && $file2 != null)
				$colHeaders = array("Tahun", "Kode Sasaran", "Kode IKK", "Target");
			else
				$colHeaders = array("Tahun", "Kode Eselon II", "Kode Sasaran", "Kode IKK", "Target");		
		//	var_dump($query->result());die;
			to_excel($query,"RKTEselon2",$colHeaders);
		}
	}
	
	//jumlah data record buat paging
	public function E2_grid_count($file1,$file2,$filtahun){		
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
			$this->db->where("a.tahun",$filtahun);
		}
		if($file1 != '' && $file1 != '-1' && $file1 != null) {
			$this->db->where("b.kode_e1",$file1);
		}
		if($file2 != '' && $file2 != '-1' && $file2 != null) {
			$this->db->where("a.kode_e2",$file2);
		}
		$this->db->from('tbl_rkt_eselon2_log a');
		$this->db->join('tbl_eselon2 b', 'b.kode_e2 = a.kode_e2');
		$this->db->join('tbl_sasaran_eselon2 c', 'c.kode_sasaran_e2 = a.kode_sasaran_e2','left' );
		$this->db->join('tbl_ikk d', 'd.kode_ikk = a.kode_ikk','left' );
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	
}
?>

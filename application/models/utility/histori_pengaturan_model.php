<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class histori_pengaturan_model extends CI_Model
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
	public function sasaranKL_grid($filtahun=null,$purpose=1){
		$lastNo = isset($_POST['lastNo']) ? intval($_POST['lastNo']) : 0;
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->sasaranKL_grid_count($filtahun);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'kode_sasaran_kl';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		$pdfdata = array();
		if ($count>0){
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("tahun",$filtahun);
			}
			$this->db->order_by($sort." ".$order );
			if($purpose==1){$this->db->limit($limit,$offset);}
			$this->db->select("*",false);
			$this->db->from('tbl_sasaran_kl_log a');
			$this->db->order_by("a.kode_sasaran_kl ASC");
			$query = $this->db->get();
			
			$i=0;
			$no =$lastNo;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				$response->rows[$i]['tahun']=$row->tahun;
				$response->rows[$i]['kode_sasaran_kl']=$row->kode_sasaran_kl;
				$response->rows[$i]['kode_kl']=$row->kode_kl;
				$response->rows[$i]['deskripsi']=$row->deskripsi;
				
				$xlog = explode(';', $row->log);
				$response->rows[$i]['log_status']=$xlog[0];
				$response->rows[$i]['log_user']=$xlog[1];
				$response->rows[$i]['log_date']=$xlog[2];
			//utk kepentingan export excel ==========================
				// $row->keterangan = str_replace("<br>",", ",$response->rows[$i]['pejabat']);
				// $row->indikator_kinerja=$response->rows[$i]['indikator_kinerja'];
				unset($row->kode_kl);
			//============================================================
				
			//utk kepentingan export pdf===================
				$pdfdata[] = array($no,$response->rows[$i]['kode_sasaran_kl'],$response->rows[$i]['deskripsi'], $response->rows[$i]['log_status'], $response->rows[$i]['log_user'], $response->rows[$i]['log_date']);
			//============================================================
				$i++;
			} 
			
			$response->lastNo = $no;
			// $query->free_result();
		}else {
				$response->rows[$count]['no']= '';
				$response->rows[$count]['tahun']='';
				$response->rows[$count]['kode_sasaran_kl']='';
				$response->rows[$count]['deskripsi']='';
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
			$colHeaders = array("Kode Sasaran","Deskripsi Sasaran");		
			//var_dump($query->result());die;
			to_excel($query,"SasaranKementerian",$colHeaders);
		}
	
	}
	
	public function sasaranKL_grid_count($filtahun=null){		
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
			$this->db->where("tahun",$filtahun);
		}
		$query=$this->db->from('tbl_sasaran_kl_log');
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	
	// purpose : 1=buat grid, 2=buat pdf, 3=buat excel
	public function sasaranE1_grid($file1=null,$filtahun=null,$purpose=1){
		$lastNo = isset($_POST['lastNo']) ? intval($_POST['lastNo']) : 0;  
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->sasaranE1_grid_count($file1,$filtahun);
		
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
				$this->db->where("b.kode_e1",$file1);
			}
			$this->db->order_by($sort." ".$order );
			if($purpose==1){$this->db->limit($limit,$offset);}
			$this->db->select("a.tahun, a.kode_e1, b.nama_e1, a.kode_sasaran_e1, a.deskripsi, a.kode_sasaran_kl, c.deskripsi AS deskripsi_sasaran_kl, a.log", false);
			$this->db->from('tbl_sasaran_eselon1_log a');
			$this->db->join('tbl_eselon1 b', 'b.kode_e1 = a.kode_e1');
			$this->db->join('tbl_sasaran_kl c', 'c.kode_sasaran_kl = a.kode_sasaran_kl','left' );
			$this->db->order_by("a.kode_e1 ASC, a.kode_sasaran_e1 ASC");
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
				$response->rows[$i]['deskripsi']=$row->deskripsi;
				$response->rows[$i]['deskripsi_sasaran_kl']=$row->deskripsi_sasaran_kl;	
				
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
					unset($row->deskripsi_sasaran_kl);
				//============================================================
					
				//utk kepentingan export pdf===================
				if($file1 != '' && $file1 != '-1' && $file1 != null)
					$pdfdata[] = array($no,$response->rows[$i]['kode_sasaran_e1'],$response->rows[$i]['deskripsi']);
				else
					$pdfdata[] = array($no,$response->rows[$i]['kode_e1'],$response->rows[$i]['kode_sasaran_e1'],$response->rows[$i]['deskripsi']);
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
				$response->rows[$count]['deskripsi']='';
				$response->rows[$count]['kode_sasaran_kl']='';
				$response->rows[$count]['deskripsi_sasaran_kl']='';
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
			if($file1 != '' && $file1 != '-1' && $file1 != null)
				$colHeaders = array("Tahun", "Kode Sasaran","Deskripsi Sasaran","Kode Sasaran Kementerian");
			else
				$colHeaders = array("Tahun", "Kode Eselon I","Kode Sasaran","Deskripsi Sasaran","Kode Sasaran Kementerian");		
		//	var_dump($query->result());die;
			to_excel($query,"SasaranEselon1",$colHeaders);
		}
	}
	
	//jumlah data record buat paging
	public function sasaranE1_grid_count($file1,$filtahun){		
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
			$this->db->where("a.tahun",$filtahun);
		}
		if($file1 != '' && $file1 != '-1' && $file1 != null) {
			$this->db->where("b.kode_e1",$file1);
		}
		$this->db->from('tbl_sasaran_eselon1_log a');
		$this->db->join('tbl_eselon1 b', 'b.kode_e1 = a.kode_e1');
		$this->db->join('tbl_sasaran_kl c', 'c.kode_sasaran_kl = a.kode_sasaran_kl','left' );
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	
	// purpose : 1=buat grid, 2=buat pdf, 3=buat excel
	public function sasaranE2_grid($file1=null,$filtahun=null,$file2=null,$purpose=1){
		$lastNo = isset($_POST['lastNo']) ? intval($_POST['lastNo']) : 0;  
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->sasaranE2_grid_count($filtahun,$file1,$file2);
		
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'a.kode_e2';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		$pdfdata = array();
		if ($count>0){
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("d.tahun",$filtahun);
			}
			if($file1 != '' && $file1 != '-1' && $file1 != null) {
				$this->db->where("b.kode_e1",$file1);
			}
			if($file2 != '' && $file2 != '-1' && $file2 != null) {
				$this->db->where("d.kode_e2",$file2);
			}		
			
			$this->db->order_by($sort." ".$order );
			if($purpose==1){$this->db->limit($limit,$offset);}
			$this->db->select("a.tahun, a.kode_e2, d.kode_sasaran_e2, d.deskripsi AS deskripsi_sasaran_e2,d.kode_sasaran_e1, a.log, b.kode_e1, c.deskripsi AS deskripsi_sasaran_e1", false);
			$this->db->from('tbl_sasaran_eselon2_log a');
			$this->db->join('tbl_eselon2 b', 'b.kode_e2 = a.kode_e2');
			$this->db->join('tbl_sasaran_eselon1 c', 'c.kode_sasaran_e1 = a.kode_sasaran_e1','left' );
			$this->db->join('tbl_sasaran_eselon2 d', 'd.kode_sasaran_e2 = a.kode_sasaran_e2','left' );
			$this->db->order_by("a.kode_e2 ASC, a.kode_sasaran_e2 ASC");
			$query = $this->db->get();
			
			$i=0;
			$no =$lastNo;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				$response->rows[$i]['tahun']=$row->tahun;
				$response->rows[$i]['kode_e2']=$row->kode_e2;
				$response->rows[$i]['kode_sasaran_e2']=$row->kode_sasaran_e2;
				$response->rows[$i]['kode_sasaran_e1']=$row->kode_sasaran_e1;
				$response->rows[$i]['deskripsi_sasaran_e1']=$row->deskripsi_sasaran_e1;
				$response->rows[$i]['deskripsi_sasaran_e2']=$row->deskripsi_sasaran_e2;					
				
				$xlog = explode(';', $row->log);
				$response->rows[$i]['log_status']=$xlog[0];
				$response->rows[$i]['log_user']=$xlog[1];
				$response->rows[$i]['log_date']=$xlog[2];
				
				//utk kepentingan export excel ==========================
				// $row->keterangan = str_replace("<br>",", ",$response->rows[$i]['pejabat']);
				// $row->indikator_kinerja=$response->rows[$i]['indikator_kinerja'];
				if($file1 != '' && $file1 != '-1' && $file1 != null)
					unset($row->kode_e2);
					unset($row->nama_e2);
					unset($row->deskripsi_sasaran_e1);
				//============================================================
					
				//utk kepentingan export pdf===================
				//if($file1 != '' && $file1 != '-1' && $file1 != null)
					//$pdfdata[] = array($no,$response->rows[$i]['kode_sasaran_e2'],$response->rows[$i]['deskripsi'],$response->rows[$i]['kode_sasaran_e1']);
				//else
					//$pdfdata[] = array($no,$response->rows[$i]['kode_e2'],$response->rows[$i]['kode_sasaran_e2'],$response->rows[$i]['deskripsi'],$response->rows[$i]['kode_sasaran_e1']);
				//============================================================
				$i++;
			} 
			
			$response->lastNo = $no;
			// $query->free_result();
		}else {
				$response->rows[$count]['no']= "";
				$response->rows[$count]['tahun']='';
				$response->rows[$count]['kode_e2']='';
				$response->rows[$count]['kode_sasaran_e2']='';
				$response->rows[$count]['kode_sasaran_e1']='';
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
			if($file1 != '' && $file1 != '-1' && $file1 != null)
				$colHeaders = array("Tahun", "Kode Sasaran","Deskripsi Sasaran","Kode Sasaran Kementerian");
			else
				$colHeaders = array("Tahun", "Kode Eselon II","Kode Sasaran","Deskripsi Sasaran","Kode Sasaran Kementerian");		
		//	var_dump($query->result());die;
			to_excel($query,"SasaranEselon2",$colHeaders);
		}
	}
	
	//jumlah data record buat paging
	public function sasaranE2_grid_count($file1,$filtahun,$file2){		
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
			$this->db->where("d.tahun",$filtahun);
		}
		if($file1 != '' && $file1 != '-1' && $file1 != null) {
			$this->db->where("b.kode_e1",$file1);
		}
		if($file2 != '' && $file2 != '-1' && $file2 != null) {
			$this->db->where("d.kode_e2",$file2);
		}		
		
		$this->db->from('tbl_sasaran_eselon2_log a');
		$this->db->join('tbl_eselon2 b', 'b.kode_e2 = a.kode_e2');
		$this->db->join('tbl_sasaran_eselon1 c', 'c.kode_sasaran_e1 = a.kode_sasaran_e1','left' );
		$this->db->join('tbl_sasaran_eselon2 d', 'd.kode_sasaran_e2 = a.kode_sasaran_e2','left' );
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	
	public function ikukl_grid($file1=null,$filtahun=null,$purpose=1){
		$lastNo = isset($_POST['lastNo']) ? intval($_POST['lastNo']) : 0;
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->ikukl_grid_Count($file1,$filtahun);
		
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'kode_kl';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		$pdfdata = array();
		if ($count>0){
			if($file1 != '' && $file1 != '-1' && $file1 != null) {
				$this->db->where("tbl_eselon1.kode_e1",$file1);
			}
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where(".tbl_iku_kl_log.tahun",$filtahun);
			}
			$this->db->order_by($sort." ".$order );
			if($purpose==1){$this->db->limit($limit,$offset);}
			$this->db->select("tbl_iku_kl_log.kode_kl, tbl_iku_kl_log.tahun, tbl_iku_kl_log.kode_iku_kl, tbl_iku_kl_log.deskripsi, tbl_iku_kl_log.satuan, tbl_iku_kl_log.kode_e1, tbl_iku_kl_log.log, tbl_iku_kl_log.kode_e1",false);			
			$this->db->from('tbl_iku_kl_log');
			$this->db->join('tbl_eselon1', 'tbl_eselon1.kode_e1 = tbl_iku_kl_log.kode_e1','left' );
			
			//chan 
			if ($purpose==2)  //buat pdf
				$this->db->order_by("tbl_iku_kl_log.kode_kl ASC,tbl_iku_kl_log.kode_iku_kl ASC");
			$query = $this->db->get();
			
			$i=0;
			$no =$lastNo;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				$response->rows[$i]['kode_kl']=$row->kode_kl;
				$response->rows[$i]['tahun']=$row->tahun;
				$response->rows[$i]['kode_iku_kl']=$row->kode_iku_kl;
				$response->rows[$i]['deskripsi']=$row->deskripsi;
				$response->rows[$i]['satuan']=$row->satuan;
				$response->rows[$i]['kode_e1']=$row->kode_e1;
				
				
				$xlog = explode(';', $row->log);
				$response->rows[$i]['log_status']=$xlog[0];
				$response->rows[$i]['log_user']=$xlog[1];
				$response->rows[$i]['log_date']=$xlog[2];
				
				//utk kepentingan export excel ==========================
				// $row->keterangan = str_replace("<br>",", ",$response->rows[$i]['pejabat']);
				// $row->indikator_kinerja=$response->rows[$i]['indikator_kinerja'];
				unset($row->kode_kl);
				unset($row->nama_e1);
				//============================================================
				
				//utk kepentingan export pdf===================
				if($file1 != '' && $file1 != '-1' && $file1 != null) 
					$pdfdata[] = array($no,$response->rows[$i]['tahun'],$response->rows[$i]['kode_iku_kl'],$response->rows[$i]['deskripsi'],$response->rows[$i]['satuan']);
				else
					$pdfdata[] = array($no,$response->rows[$i]['tahun'],$response->rows[$i]['kode_iku_kl'],$response->rows[$i]['deskripsi'],$response->rows[$i]['satuan'],$response->rows[$i]['kode_e1']);
					
				//============================================================
				$i++;
			} 
			
			$response->lastNo = $no;
			// $query->free_result();
		}else {
				$response->rows[$count]['no']= '';
				$response->rows[$count]['kode_kl']='';
				$response->rows[$count]['tahun']='';
				$response->rows[$count]['kode_iku_kl']='';
				$response->rows[$count]['deskripsi']='';
				$response->rows[$count]['satuan']='';
				$response->rows[$count]['kode_e1']='';
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
			$colHeaders = array("Tahun","Kode IKU","Deskripsi IKU","Satuan","Subsektor");		
			//var_dump($query->result());die;
			to_excel($query,"IKUKementerian",$colHeaders);
		}
	
	}
	
	//jumlah data record buat paging
	public function ikukl_grid_count($file1,$filtahun){	
		if($file1 != '' && $file1 != '-1' && $file1 != null) {
			$this->db->where("tbl_eselon1.kode_e1",$file1);
		}
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("tbl_iku_kl_log.tahun",$filtahun);
			}
		$this->db->from('tbl_iku_kl_log');
		$this->db->join('tbl_eselon1', 'tbl_eselon1.kode_e1 = tbl_iku_kl_log.kode_e1','left' );
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	
	public function ikue1_grid($filtahun=null,$file1=null,$purpose=1){
		$lastNo = isset($_POST['lastNo']) ? intval($_POST['lastNo']) : 0;
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->ikue1_grid_count($filtahun,$file1);
		
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'a.kode_e1';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		$pdfdata = array();
		if ($count>0){
			$this->db->order_by($sort." ".$order );
			if($purpose==1){$this->db->limit($limit,$offset);}
			if($file1 != '' && $file1 != '-1' && $file1 != null) {
				$this->db->where("c.kode_e1",$file1);
			}
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("a.tahun",$filtahun);
			}
			$this->db->select("a.tahun, c.kode_e1, a.kode_iku_e1, a.deskripsi, a.satuan, a.kode_iku_kl, a.kode_e2,b.deskripsi as deskripsi_ikukl, c.nama_e1, d.deskripsi AS kl_deskripsi",false);
			$this->db->from('tbl_iku_eselon1_log a',false);
			$this->db->join('tbl_eselon1 c', 'c.kode_e1 = a.kode_e1');
			$this->db->join('tbl_iku_kl d', 'd.kode_iku_kl = a.kode_iku_kl','left' );			
			$this->db->order_by("a.kode_e1 ASC, a.kode_iku_e1 ASC");
			$query = $this->db->get();
			
			$i=0;
			$no =$lastNo;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				$response->rows[$i]['kode_e1']=$row->kode_e1;
				$response->rows[$i]['tahun']=$row->tahun;
				$response->rows[$i]['kode_iku_e1']=$row->kode_iku_e1;
				$response->rows[$i]['deskripsi']=$row->deskripsi;
				$response->rows[$i]['satuan']=$row->satuan;
				$response->rows[$i]['kode_e2']=$row->kode_e2;
				
				$xlog = explode(';', $row->log);
				$response->rows[$i]['log_status']=$xlog[0];
				$response->rows[$i]['log_user']=$xlog[1];
				$response->rows[$i]['log_date']=$xlog[2];
				
				//utk kepentingan export excel ==========================
				// $row->keterangan = str_replace("<br>",", ",$response->rows[$i]['pejabat']);
				// $row->indikator_kinerja=$response->rows[$i]['indikator_kinerja'];
				unset($row->kode_e2);
				unset($row->deskripsi_ikukl);
				unset($row->nama_e1);
				unset($row->kl_deskripsi);
				//============================================================
				
				//utk kepentingan export pdf===================
				if($file1 != '' && $file1 != '-1' && $file1 != null) 
					$pdfdata[] = array($no,$response->rows[$i]['tahun'],$response->rows[$i]['kode_iku_e1'],$response->rows[$i]['deskripsi'],$response->rows[$i]['satuan'],$response->rows[$i]['kode_iku_kl']);
				else
					$pdfdata[] = array($no,$response->rows[$i]['tahun'],$response->rows[$i]['kode_e1'],$response->rows[$i]['kode_iku_e1'],$response->rows[$i]['deskripsi'],$response->rows[$i]['satuan'],$response->rows[$i]['kode_iku_kl']);
					
				//============================================================
				$i++;
			} 
			
			$response->lastNo = $no;
			// $query->free_result();
		}else {
				$response->rows[$count]['no']= '';
				$response->rows[$count]['kode_e1']='';
				$response->rows[$count]['tahun']='';
				$response->rows[$count]['kode_iku_e1']='';
				$response->rows[$count]['deskripsi']='';
				$response->rows[$count]['satuan']='';
				$response->rows[$count]['kode_e2']='';
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
			$colHeaders = array("Tahun","Kode Eselon 1","Kode IKU","Deskripsi IKU","Satuan","Kode IKU Kementerian Terkait");		
			//var_dump($query->result());die;
			to_excel($query,"IKUEselon1",$colHeaders);
		}
	
	}
	
	//jumlah data record buat paging
	public function ikue1_grid_count($file1=null,$filtahun=null){
		if($file1 != '' && $file1 != '-1' && $file1 != null) {
			$this->db->where("c.kode_e1",$file1);
		}
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("a.tahun",$filtahun);
			}
		$this->db->from('tbl_iku_eselon1_log a',false);
		$this->db->join('tbl_eselon1 c', 'c.kode_e1 = a.kode_e1');
		$this->db->join('tbl_iku_kl d', 'd.kode_iku_kl = a.kode_iku_kl','left' );			
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
		
	public function ikk_grid($file1=null, $file2=null,$filtahun=null, $purpose=1){
		$lastNo = isset($_POST['lastNo']) ? intval($_POST['lastNo']) : 0;  
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->ikk_grid_count($file1, $file2, $filtahun);
		
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'kode_e2';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		$pdfdata = array();
		if ($count>0){
			if($file2 != '-1' && $file2 != null){
			//$this->db->where("tbl_iku_eselon1.kode_iku_e1",$file1);
				$this->db->where("a.kode_e2",$file2);
			}
			if (($file1 != '-1')&&($file1 != null)){
				$this->db->where("c.kode_e1",$file1);
			}
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("a.tahun",$filtahun);
			}
			
			//$this->db->order_by($sort." ".$order );
			if($purpose==1){$this->db->limit($limit,$offset);}
			$this->db->select("a.tahun,a.kode_e2, a.kode_ikk, a.deskripsi, a.satuan, a.kode_iku_e1, c.kode_e1, b.nama_e2, d.deskripsi AS e1_deskripsi",false);
			$this->db->from('tbl_ikk_log a');
			$this->db->join('tbl_eselon2 b', 'b.kode_e2 = a.kode_e2');
			$this->db->join('tbl_eselon1 c', 'c.kode_e1 = b.kode_e1');
			$this->db->join('tbl_iku_eselon1 d', 'd.kode_iku_e1 = a.kode_iku_e1','left');
			$this->db->order_by("a.kode_e2 ASC, a.kode_ikk ASC");
			//$this->db->select("a.kode_e2, a.kode_ikk, b.kode_iku_e1, a.deskripsi, a.satuan",false);
			//$this->db->from('tbl_ikk a');
			//$this->db->join('tbl_iku_eselon1 b', 'b.kode_iku_e1 = a.kode_iku_e1');
			$query = $this->db->get();
			
			$i=0;
			$no =$lastNo;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				$response->rows[$i]['kode_e2']=$row->kode_e2;
				$response->rows[$i]['nama_e2']=$row->nama_e2;
				$response->rows[$i]['kode_e1']=$row->kode_e1;
				$response->rows[$i]['kode_ikk']=$row->kode_ikk;
				$response->rows[$i]['deskripsi']=$row->deskripsi;
				$response->rows[$i]['deskripsi_e1']=$this->getDeskripsiIKU($row->kode_iku_e1);
				$response->rows[$i]['satuan']=$row->satuan;
				$response->rows[$i]['kode_iku_e1']=$row->kode_iku_e1;
				$response->rows[$i]['e1_deskripsi']=$row->e1_deskripsi;
				$response->rows[$i]['tahun']=$row->tahun;
				
				//utk kepentingan export excel ==========================
				// $row->keterangan = str_replace("<br>",", ",$response->rows[$i]['pejabat']);
				// $row->indikator_kinerja=$response->rows[$i]['indikator_kinerja'];
				if($file1 != '' && $file1 != '-1' && $file1 != null)
					//unset($row->kode_e1);
				if($file2 != '' && $file2 != '-1' && $file2 != null)
					unset($row->kode_e2);
					unset($row->nama_e2);
					unset($row->e1_deskripsi);
					
				//============================================================
					
				//utk kepentingan export pdf===================
				if($file1 != '' && $file1 != '-1' && $file1 != null)
					if($file2 != '' && $file2 != '-1' && $file2 != null)
						$pdfdata[] = array($no,$response->rows[$i]['tahun'],$response->rows[$i]['kode_ikk'],$response->rows[$i]['deskripsi'],$response->rows[$i]['satuan'],$response->rows[$i]['kode_iku_e1']);
						//$pdfdata[] = array($no,$response->rows[$i]['kode_ikk'],$response->rows[$i]['kode_iku_e1'],$response->rows[$i]['deskripsi'],$response->rows[$i]['satuan']);
					else
						$pdfdata[] = array($no,$response->rows[$i]['tahun'],$response->rows[$i]['kode_e2'],$response->rows[$i]['kode_ikk'],$response->rows[$i]['deskripsi'],$response->rows[$i]['satuan'],$response->rows[$i]['kode_iku_e1']);
						//$pdfdata[] = array($no,$response->rows[$i]['kode_e2'],$response->rows[$i]['kode_ikk'],$response->rows[$i]['kode_iku_e1'],$response->rows[$i]['deskripsi'],$response->rows[$i]['satuan']);
				else
					$pdfdata[] = array($no,$response->rows[$i]['tahun'],$response->rows[$i]['kode_e2'],$response->rows[$i]['kode_ikk'],$response->rows[$i]['deskripsi'],$response->rows[$i]['satuan'],$response->rows[$i]['kode_iku_e1']);
					//$pdfdata[] = array($no,$response->rows[$i]['kode_e2'],$response->rows[$i]['kode_ikk'],$response->rows[$i]['kode_iku_e1'],$response->rows[$i]['deskripsi'],$response->rows[$i]['satuan']);
				//============================================================
				$i++;
			} 
			
			$response->lastNo = $no;
			// $query->free_result();
		}else {
				$response->rows[$count]['no']= "";
				$response->rows[$count]['kode_e1']='';
				$response->rows[$count]['kode_e2']='';
				$response->rows[$count]['kode_ikk']='';
				$response->rows[$count]['kode_iku_e1']='';
				$response->rows[$count]['deskripsi']='';
				$response->rows[$count]['deskripsi_e1']='';
				$response->rows[$count]['satuan']='';
				$response->rows[$count]['tahun']='';
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
				if($file2 != '' && $file2 != '-1' && $file2 != null)
					$colHeaders = array("Tahun","Kode IKK","Deskripsi","Satuan");
					//$colHeaders = array("Kode IKK","Kode IKU Eselon 1","Deskripsi IKK","Satuan");
				else
					$colHeaders = array("Tahun","Kode Eselon II","Kode IKK","Deskripsi","Satuan");
					//$colHeaders = array("Kode Eselon 2","Kode IKK","Kode IKU Eselon 1","Deskripsi IKK","Satuan");
			else
				$colHeaders = array("Tahun","Kode Eselon II","Kode IKK","Deskripsi","Satuan");
				//$colHeaders = array("Kode Eselon 2","Kode IKK","Kode IKU Eselon 1","Deskripsi IKK","Satuan");
					
		//	var_dump($query->result());die;
			to_excel($query,"IKK",$colHeaders);
		}
	
	}
	
	//jumlah data record buat paging
	public function ikk_grid_count($file1, $file2,$filtahun){
	
		if($file2 != '-1' && $file2 != null){
			//$this->db->where("tbl_iku_eselon1.kode_iku_e1",$file1);
			$this->db->where("a.kode_e2",$file2);
		}
		if (($file1 != '-1')&&($file1 != null)){
			$this->db->where("c.kode_e1",$file1);
		}
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("a.tahun",$filtahun);
			}
		
		$this->db->from('tbl_ikk_log a');
		$this->db->join('tbl_eselon2 b', 'b.kode_e2 = a.kode_e2');
		$this->db->join('tbl_eselon1 c', 'c.kode_e1 = b.kode_e1');
		$this->db->join('tbl_iku_eselon1 d', 'd.kode_iku_e1 = a.kode_iku_e1','left');

		//$this->db->select("*",false);
		//$this->db->from('tbl_ikk');
		//$this->db->join('tbl_iku_eselon1', 'tbl_iku_eselon1.kode_iku_e1 = tbl_ikk.kode_iku_e1');
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
}
?>

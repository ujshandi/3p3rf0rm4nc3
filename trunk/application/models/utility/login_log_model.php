<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class login_log_model extends CI_Model
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
	public function easyGrid($fileawal=null,$fileakhir=null,$file1=null,$file2=null,$purpose=1){
		$lastNo = isset($_POST['lastNo']) ? intval($_POST['lastNo']) : 0;
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->getrecord_count($fileawal,$fileakhir,$file1,$file2);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'login_time';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		$pdfdata = array();
		if ($count>0){
			if($fileawal != '' && $fileawal != '-1' && $fileawal != null) {
				$this->db->where("date(login_time) between '$fileawal' and '$fileakhir'");
			} 
			if($file1 != '' && $file1 != '-1' && $file1 != null) {
				$this->db->like("user_info",$file1);
			} 
			
			if($file2 != '' && $file2 != '-1' && $file2 != null) {
				$this->db->like("user_info",$file2);
			}  
			//$this->db->order_by($sort." ".$order );
			if($purpose==1){$this->db->limit($limit,$offset);}
			$this->db->select("l.*",false);
			$this->db->from('login_log l');			
			$this->db->order_by("l.login_time");
			$query = $this->db->get();
			
			$i=0;
			$no =$lastNo;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				$response->rows[$i]['login_time']=strftime("%d-%m-%Y %H:%M:%S",strtotime($row->login_time));
				$response->rows[$i]['ip']=$row->ip;
				$response->rows[$i]['user_info']=$row->user_info;
				
				
				$xlog = explode(';', $row->user_info);
				$response->rows[$i]['log_id_user']=str_replace("id=","",$xlog[0]);
				$response->rows[$i]['log_user_name']=str_replace("name=","",$xlog[1]);
				$response->rows[$i]['log_e1']=str_replace("e1=","",$xlog[2]);
				$response->rows[$i]['log_e2']=str_replace("e2=","",$xlog[3]);
				
				$response->rows[$i]['log_e1'] = ($response->rows[$i]['log_e1']=='-1'?'-':$response->rows[$i]['log_e1']);
				$response->rows[$i]['log_e2'] = ($response->rows[$i]['log_e2']=='-1'?'-':$response->rows[$i]['log_e2']);
			//utk kepentingan export excel ==========================
				
				
			//============================================================
				
			//utk kepentingan export pdf===================
				/* $pdfdata[] = array($no,$response->rows[$i]['kode_sasaran_kl'],$response->rows[$i]['kode_iku_kl'],$response->rows[$i]['target'], $response->rows[$i]['log_status'], $response->rows[$i]['log_user'], $response->rows[$i]['log_date']); */
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
	
	public function getrecord_count($fileawal=null,$fileakhir=null,$file1=null,$file2=null){		
		if($fileawal != '' && $fileawal != '-1' && $fileawal != null) {
				$this->db->where("date(login_time) between '$fileawal' and '$fileakhir'");
			} 
			if($file1 != '' && $file1 != '-1' && $file1 != null) {
				$this->db->like("user_info",$file1);
			} 
			
			if($file2 != '' && $file2 != '-1' && $file2 != null) {
				$this->db->like("user_info",$file2);
			} 
		$query=$this->db->from('login_log');
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
		
	
}
?>

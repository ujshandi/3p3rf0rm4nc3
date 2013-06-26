<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Portal_model extends CI_Model
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
	public function easyGrid($category_id){
		$lastNo = isset($_POST['lastNo']) ? intval($_POST['lastNo']) : 0;  
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->getRecordCount($category_id);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'a.content_id';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';  
		$offset = ($page-1)*$limit;  
		if ($count>0){
			$this->db->where('category_id',$category_id);
			$this->db->order_by($sort." ".$order );
			$this->db->limit($limit,$offset);
			$this->db->select("*", false);
			$this->db->from('portal_content a');
			$this->db->order_by("a.content_id DESC");
			$query = $this->db->get();
			
			$i=0;
			$no =$lastNo;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				$response->rows[$i]['content_id']=$row->content_id;
				$response->rows[$i]['category_id']=$row->category_id;
				$response->rows[$i]['content_title']=$row->content_title;
				$response->rows[$i]['content']=$row->content;
				$response->rows[$i]['summary']=$row->summary;
				$response->rows[$i]['url']=$row->url;	
				
				$i++;
			} 
			
			$response->lastNo = $no;
			// $query->free_result();
		}else {
				$response->rows[$count]['no']= "";
				$response->rows[$count]['content_id']='';
				$response->rows[$count]['category_id']='';
				$response->rows[$count]['content_title']='';
				$response->rows[$count]['content']='';
				$response->rows[$count]['summary']='';
				$response->rows[$count]['url']='';
				$response->lastNo = 0;
		}
	
		return json_encode($response);
	}
	
	//jumlah data record buat paging
	public function getRecordCount($category_id){		
		$this->db->select("*", false);
		$this->db->from('portal_content a');
		$this->db->where('category_id',$category_id);
		$this->db->order_by("a.content_id DESC");
		return $this->db->count_all_results();
		$this->db->free_result();
	}

	//insert data
	public function InsertOnDb($data,& $error) {
		//query insert data		
		$result = false;
		$this->db->set('category_id',$data['category_id']);
		$this->db->set('content_title',$data['content_title']);
		$this->db->set('content',$data['content']);
		$this->db->set('summary',$data['summary']);
		$this->db->set('url',$data['url']);
		//$this->db->set('log_insert', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		try {
			$result = $this->db->insert('portal_content');
			
		}
		catch(Exception $e){
			$errNo   = $this->db->_error_number();
			$errMess = $e->getMessage();//$this->db->_error_message();
			$error = $errMess;
			log_message("error", "Problem Inserting to : ".$errMess." (".$errNo.")"); 
		}
		
		//var_dump();die;
		//$result = $this->db->insert('tbl_sasaran_eselon1');
		
		//return
		if($result) {
			return TRUE;
		}else {
			return FALSE;
		}
	}

	//update data
	public function UpdateOnDb($data, $kode) {
		
		$this->db->where('content_id',$kode);
		$this->db->set('category_id',$data['category_id']);
		$this->db->set('content_title',$data['content_title']);
		$this->db->set('content',$data['content']);
		$this->db->set('summary',$data['summary']);
		$this->db->set('url',$data['url']);
		
		$result=$this->db->update('portal_content');
		
		$errNo   = $this->db->_error_number();
	    $errMess = $this->db->_error_message();
		//var_dump($errMess);die;
		//return
		if($result) {
			return TRUE;
		}else {
			return FALSE;
		}
	}
	
	//hapus data
	public function DeleteOnDb($kode){
		
		# insert to log
		// $this->db->flush_cache();
		// $this->db->select("*");
		// $this->db->from("tbl_pengukuran_eselon2");
		// $this->db->where('id_pengukuran_e2', $id);
		// $qt = $this->db->get();
		
		// $this->db->flush_cache();
		// $this->db->set('kode_sasaran_e1',	$qt->row()->kode_sasaran_e1);
		// $this->db->set('tahun',				$qt->row()->tahun);
		// $this->db->set('kode_e1',			$qt->row()->kode_e1);
		// $this->db->set('kode_sasaran_kl',	$qt->row()->kode_sasaran_kl);
		// $this->db->set('deskripsi',			$qt->row()->deskripsi);
		// $this->db->set('log',				'DELETE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		// $result = $this->db->insert('tbl_sasaran_eselon1_log');
		
		
		$this->db->flush_cache();
		$this->db->where('content_id', $kode);
		$result = $this->db->delete('portal_content'); 
		
		$errNo   = $this->db->_error_number();
	    $errMess = $this->db->_error_message();
		$error = $errMess;
		//var_dump($errMess);die;
	    log_message("error", "Problem Update to : ".$errMess." (".$errNo.")"); 
		//return
		
		if($result) {
			return TRUE;
		}else {
			return FALSE;
		}
	}
	
	public function getListSasaranE1($objectId="",$e1="-1", $data=""){
		
		$this->db->flush_cache();
		$this->db->select('kode_sasaran_e1,deskripsi');
		$this->db->from('tbl_sasaran_eselon1');
		$this->db->order_by('kode_sasaran_e1');
		$this->db->where('kode_e1',$e1);
		$tahun = "-1";
		if ($data!=""){
			$tahun = isset($data['tahun'])?$data['tahun']:'-1';
		}
			$this->db->where('tahun',$tahun);
		$que = $this->db->get();
		
		//chan 
		if ($data!=""){
			$kode = (isset($data['kode']))||($data['kode']=='')?$data['kode']:'0';
			$deskripsi = (isset($data['deskripsi'])||($data['deskripsi']==''))?$data['deskripsi']:'-- Pilih --';
		}
		else {
			$kode = '0';
			$deskripsi = '-- Pilih --';
		}
		$out = '<div id="tcContainer"><input id="kode_sasaran_e1'.$objectId.'" name="kode_sasaran_e1" type="hidden" class="h_code" value="'.$kode.'">';
		$out .= '<textarea name="txtkode_sasaran_e1'.$objectId.'" id="txtkode_sasaran_e1'.$objectId.'" class="easyui-validatebox textdown" required="true" readonly>'.$deskripsi.'</textarea>';
		$out .= '<ul id="drop'.$objectId.'" class="dropdown">';
		$out .= '<li value="0"  onclick="setSasaran'.$objectId.'(\'\')">-- Pilih --</li>';
		
		foreach($que->result() as $r){
			$out .= '<li onclick="setSasaran'.$objectId.'(\''.$r->kode_sasaran_e1.'\')">'.$r->deskripsi.'</li>';
		}
		$out .= '</ul></div>';
		//var_dump($que->num_rows());
		//chan
		if ($que->num_rows()==0){
			$out = "Data Sasaran Eselon 1 untuk tingkat Eselon ini belum tersedia.";
		}
		
		echo $out;
	}
	
	public function getDeskripsiSasaran($kode_sasaran_e1){
		$this->db->flush_cache();
		$this->db->select('b.deskripsi');
		$this->db->from('tbl_sasaran_eselon1 a');
		$this->db->join('tbl_sasaran_kl b', 'b.kode_sasaran_kl = a.kode_sasaran_kl');
		$this->db->where('kode_sasaran_e1', $kode_sasaran_e1);
		$result = $this->db->get();
		
		if(isset($result->row()->deskripsi)){
			return $result->row()->deskripsi;
		}else{
			return '';
		}
	}
	
	public function getDeskripsiSasaranE1($kode_sasaran_e1, $tahun){
		$this->db->flush_cache();
		$this->db->select('deskripsi');
		$this->db->from('tbl_sasaran_eselon1');
		$this->db->where('kode_sasaran_e1', $kode_sasaran_e1);
		$this->db->where('tahun',$tahun);
		
		$result = $this->db->get();
		
		if(isset($result->row()->deskripsi)){
			return $result->row()->deskripsi;
		}else{
			return '';
		}
	}
	
	public function importData($data){
		//query insert data
		$this->db->flush_cache();
		
		$this->db->set('tahun',				$data['tahun']);
		$this->db->set('kode_e1',			$data['kode_e1']);
		$this->db->set('kode_sasaran_e1',	$data['kode_sasaran_e1']);
		$this->db->set('deskripsi',			$data['deskripsi']);		
//chan		$this->db->set('kode_sasaran_kl',	$data['kode_sasaran_kl']);		
		
		$result = $this->db->insert('tbl_sasaran_eselon1');
		
		$errNo   = $this->db->_error_number();
	    $errMess = $this->db->_error_message();
		$error = $errMess;
		//var_dump($errMess);die;
	    log_message("error", "Problem import Inserting to : ".$errMess." (".$errNo.")"); 
		//return
		if($result) {
			return TRUE;
		}else {
			return FALSE;
		}
	}
	
	public function getListFilterTahun($objectId){
		
		$this->db->flush_cache();
		$this->db->select('distinct tahun',false);
		$this->db->from('tbl_sasaran_eselon1');
		$e1 = $this->session->userdata('unit_kerja_e1');
		if (($e1!="-1")&&($e1!=null)){
			$this->db->where('kode_e1',$e1);
			//$value = $e1;
		}
		$this->db->order_by('tahun');
		
		$que = $this->db->get();
		
		$out = '<select name="filter_tahun'.$objectId.'" id="filter_tahun'.$objectId.'">';
		$out .= '<option value="-1">Semua</option>';
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->tahun.'">'.$r->tahun.'</option>';
		}
		
		$out .= '</select>';
		
		echo $out;
	}
	
}
?>

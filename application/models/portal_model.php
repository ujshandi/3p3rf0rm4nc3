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
				$response->rows[$i]['date_post']=$row->date_post;
				$response->rows[$i]['published']=$row->published;	
				$response->rows[$i]['published_label']=($row->published==0)?'Tidak':'Ya';	
				
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
				$response->rows[$count]['date_post']='';
				$response->rows[$count]['published']='';	
				$response->rows[$count]['published_label']='';	
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
		$this->db->set('published',$data['published']);
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
		if($data['content_title']!=null)
			$this->db->set('content_title',$data['content_title']);
		if($data['content']!=null)
			$this->db->set('content',$data['content']);
		if($data['summary']!=null)
			$this->db->set('summary',$data['summary']);
		if($data['url']!=null)
			$this->db->set('url',$data['url']);
		if($data['published']!=null)
			$this->db->set('published',$data['published']);
		
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

	public function getSingleContent($id){
		$this->db->select("*", false);
		$this->db->from('portal_content a');
		$this->db->where('content_id',$id);

		$query = $this->db->get();
		return $query->row();
	}

	public function countContent($category_id){
		$this->db->select("*", false);
		$this->db->from('portal_content a');
		$this->db->where('category_id',$category_id);
		$this->db->where('published',1);

		$query = $this->db->get();
		return $query->num_rows();
	}

	public function getMuchContent($category_id, $limit=0, $offset=0){
		$this->db->select("*", false);
		$this->db->from('portal_content a');
		$this->db->where('category_id',$category_id);
		$this->db->where('published',1);
		if($limit!=0)
			$this->db->limit($limit,$offset);

		$query = $this->db->get();
		return $query;
	}

	public function getLastNews($much){
		$this->db->select("*", false);
		$this->db->from('portal_content a');
		$this->db->where('a.category_id',2);
		$this->db->limit($much, 0);
		$this->db->order_by('a.date_post DESC');

		$query = $this->db->get();
		return $query;
	}

	public function contentExist($category_id){
		$this->db->select("*", false);
		$this->db->from('portal_content a');
		$this->db->where('category_id',$category_id);

		$query = $this->db->get();
		
		if ($query->num_rows()>0){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function singleContentExist($content_id){
		$this->db->select("*", false);
		$this->db->from('portal_content a');
		$this->db->where('content_id',$content_id);

		$query = $this->db->get();
		
		if ($query->num_rows()>0){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function getContentID($category_id){
		$this->db->select("*", false);
		$this->db->from('portal_content a');
		$this->db->where('category_id',$category_id);

		$query = $this->db->get();
		return $query->row()->content_id;
	}
	
}
?>

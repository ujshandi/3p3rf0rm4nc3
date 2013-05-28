<?php

class backup_restore extends CI_Controller {

	function __construct()
	{
		parent::__construct();		

		//$this->output->enable_profiler(true);
					
		$this->load->model('/security/sys_menu_model');
		//$this->load->model('/utility/backup_restore_model');
		$this->load->library("utility");
		$this->load->helper('form');
		
	}
	
	function index(){
		
	}
	
	public function backupView(){
		$data['title'] = 'Backup Data Kinerja';	
		$data['objectId'] = 'backup';
	  	$this->load->view('utility/backup_v',$data);
		
	}
	
	public function backupProccess(){
		// get value
		$filename = $this->input->post('filename');
		$filetype = $this->input->post('filetype');
		
		// validation
		
		// Load the DB utility class
		$this->load->dbutil();
		
		$prefs = array(
						//'tables'      => array(),  		// Array of tables to backup.
						'ignore'      => array(),           // List of tables to omit from the backup
						'format'      => $filetype,         // gzip, zip, txt
						'filename'    => $filename.'.sql',  // File name - NEEDED ONLY WITH ZIP FILES
						'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
						'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
						'newline'     => "\n"               // Newline character used in backup file
					  );

		// Backup your entire database and assign it to a variable
		$backup =& $this->dbutil->backup($prefs);
		//$backup = str_replace('\n', 'yanto');
		// Load the file helper and write the file to your server
		//$this->load->helper('file');
		//write_file(base_url().'mybackup.gz', $backup);

		// Load the download helper and send the file to your desktop
		$this->load->helper('download');
		switch($filetype){
			case 'gzip': force_download($filename.'.gzip', $backup);
				break;
			case 'zip': force_download($filename.'.zip', $backup);
				break;
			case 'txt': force_download($filename.'.sql', $backup);
				break;
		}
		 
	}
	
	public function restoreView(){
		$data['title'] = 'Restore Data Kinerja';	
		$data['objectId'] = 'restore';
	  	$this->load->view('utility/restore_v',$data);
	}
	
	public function restoreProccess(){
		# --
		$error='';
		$result=true;
		
		# load
		$this->load->dbforge();
		$this->load->helper('file');
		
		# delete database dulu
		if($this->dbforge->drop_database($this->db->database)){

			# Create database
			if ($this->dbforge->create_database($this->db->database)){
				
				# upload filenya
				$fupload = $_FILES['datafile'];
				$nama = $_FILES['datafile']['name'];
				if(isset($fupload)){
					$lokasi_file 	= $fupload['tmp_name'];
					$direktori		="restore/$nama";
					if(move_uploaded_file($lokasi_file, $direktori)){ // proses upload
						
						# proses restore database
						$isi_file		= file_get_contents($direktori);
						$string_query	= rtrim($isi_file, "\n;" );
						$array_query	= explode(";\n", $string_query);
						
						$this->db->query('use '.$this->db->database);
						foreach($array_query as $query){
							$exc = trim($query);
							if($exc != '' || $exc != null){
								$this->db->query($query);
							}
						}
						
						delete_files('restore');
						
					}else{
						$result=false;
						$error = "Gagal upload";
					}
				}
			}else{
				$result=false;
				$error = "Database tidak bisa di buat";
			}
		}else{ // database tidak bisa di delete
			$result=false;
			$error = "Database tidak bisa di hapus";
		}
		
		if ($result){
			echo json_encode(array('success'=>true, 'status'=>'Database berhasil direstore'));
		} else {
			echo json_encode(array('msg'=>$error));
		}
	}
	
}
?>
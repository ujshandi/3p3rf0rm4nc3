<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/
header('Access-Control-Allow-Origin: *');  
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Rujukan_api extends REST_Controller
{
	
	
	function __construct()
	{	
		// header('Access-Control-Allow-Origin: *');  
		// header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method"); 
		// header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE"); 
		// $method = $_SERVER['REQUEST_METHOD']; 
		// if($method == "OPTIONS") { die(); }
		
		parent::__construct();
		 $this->output->set_header( 'Access-Control-Allow-Origin: *' );
			$this->output->set_header( "Access-Control-Allow-Methods:GET" );
			$this->output->set_header( 'Access-Control-Allow-Headers: content-type' );
			$this->output->set_content_type( 'application/json' );
			$this->output->set_output( "*" );
		// header("Access-Control-Allow-Methods: GET, OPTIONS");
		// header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		
		// if ( "OPTIONS" === $_SERVER['REQUEST_METHOD'] ) {
			// die();
		// }
	}	
	
	function kl1_list_get(){
		// header('Access-Control-Allow-Origin: *'); 
		// header('Access-Control-Allow-Headers: X-Requested-With'); 
		// header('Content-Type: application/json'); 
		// $this->load->model('/rujukan/kl_model');
		// $this->load->model('/rujukan/eselon1_model');
		// $this->load->library("utility");	
		// $rs= $this->kl_model->easyGrid(4);//$file1,$file2
		 // if($rs){
            // $this->response($rs, 200); // 200 being the HTTP response code
        // }else{
            // $this->response(array('error' => 'Data Kementerian tidak ditemukan!'), 404);
        // }	
	}
	
	function eselon1_list_get(){	
		 // $this->output->set_header( 'Access-Control-Allow-Origin: *' );
			// $this->output->set_header( "Access-Control-Allow-Methods:GET" );
			// $this->output->set_header( 'Access-Control-Allow-Headers: content-type' );
			// $this->output->set_content_type( 'application/json' );
			// $this->output->set_output( "*" );	
		 // $this->load->model('/rujukan/eselon2_model');
		 // $this->load->model('/rujukan/eselon1_model');
		 // $this->load->library("utility");	
		// $rs= $this->eselon1_model->easyGrid(4,$this->get('file1'));//$file1,$file2
		 // if($rs){
            // $this->response($rs, 200); // 200 being the HTTP response code
        // }else{
            // $this->response(array('error' => 'Data Eselon 1 tidak ditemukan!'), 404);
        // }	
	}
	function eselon2_list_get(){
		
		// $this->load->model('/rujukan/eselon2_model');
		// $this->load->model('/rujukan/eselon1_model');
		// $this->load->library("utility");	
		// $rs= $this->eselon2_model->easyGrid(null,null,4);//$file1,$file2
		 // if($rs){
            // $this->response($rs, 200); // 200 being the HTTP response code
        // }else{
            // $this->response(array('error' => 'Data Eselon 2 tidak ditemukan!'), 404);
        // }	
	}
	
	
	function program1_list_get(){
		
	}
	
	function sasarankl1_list_get(){
		
	}
	
	function sasaranke1_list_get(){
		
	}
	function sasaranke2_list_get(){
		
	}
	
	public function _remap( $param ) {
		$request = $_SERVER['REQUEST_METHOD'];
	//	var_dump($request);die;
		switch( strtoupper( $request ) ) {
			case 'GET':
				$method = 'read';
				break;
			case 'POST':
				$method = 'save';
				break;
			case 'PUT':
				$method = 'update';
				break;
			case 'DELETE':
				$method = 'remove';
				break;
			case 'OPTIONS':
				$method = '_options';
				break;
		}
		if ( preg_match( "/^(?=.*[a-zA-Z])(?=.*[0-9])/", $param ) ) {
			$id = $param;
		} else {
			$id = null;
		}
		$this->$method($id);
	}
	
	public function read($id)
	{
		//var_dump($id);
		
		switch ($id){
			case 'kl1_list':
				$this->load->model('/rujukan/kl_model');
				$this->load->model('/rujukan/eselon1_model');
				$this->load->library("utility");	
				$rs= $this->kl_model->easyGrid(4);//$file1,$file2
				 if($rs){
					$this->response($rs, 200); // 200 being the HTTP response code
				}else{
					$this->response(array('error' => 'Data Kementerian tidak ditemukan!'), 404);
				}	
			break;
			case 'eselon1_list' :
				$this->load->model('/rujukan/eselon2_model');
				$this->load->model('/rujukan/eselon1_model');
				$this->load->library("utility");	
				$rs= $this->eselon1_model->easyGrid(4,$this->get('file1'));//$file1,$file2
				 if($rs){
					$this->response($rs, 200); // 200 being the HTTP response code
				}else{
					$this->response(array('error' => 'Data Eselon I tidak ditemukan!'), 404);
				}	
			break;
			case 'eselon2_list':
				$this->load->model('/rujukan/eselon2_model');
				$this->load->model('/rujukan/eselon1_model');
				$this->load->library("utility");	
				$rs= $this->eselon2_model->easyGrid(null,null,4);//$file1,$file2
				 if($rs){
					$this->response($rs, 200); // 200 being the HTTP response code
				}else{
					$this->response(array('error' => 'Data Eselon II tidak ditemukan!'), 404);
				}	
			break;
			case 'program1_list':
				$this->load->model('/rujukan/programkl_model');
				$params = null;
				$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
				 
				$rs= $this->programkl_model->easyGrid(null,$tahun,4);//$file1,$file2
				 if($rs){
					$this->response($rs, 200); // 200 being the HTTP response code
				}else{
					$this->response(array('error' => 'Data Program Eselon I tidak ditemukan!'), 404);
				}	
			break;
			case 'kegiatan1_list':
				$this->load->model('/rujukan/kegiatankl_model');
				$params = null;
				$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
				 
				$rs= $this->kegiatankl_model->easyGrid(null,null,$tahun,4);//$file1,$file2
				 if($rs){
					$this->response($rs, 200); // 200 being the HTTP response code
				}else{
					$this->response(array('error' => 'Data Kegiatan Eselon II tidak ditemukan!'), 404);
				}	
			break;
			case 'sasarankl1_list':
				$this->load->model('/pengaturan/sasaran_kl_model');
				$params = null;
				$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
				 
				$rs= $this->sasaran_kl_model->easyGrid($tahun,null,4);//$file1,$file2
				 if($rs){
					$this->response($rs, 200); // 200 being the HTTP response code
				}else{
					$this->response(array('error' => 'Data Sasaran Strategis tidak ditemukan!'), 404);
				}	
			break;
			case 'sasarane1_list':
				$this->load->model('/pengaturan/sasaran_eselon1_model');
				$params = null;
				$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
				 
				$rs= $this->sasaran_eselon1_model->easyGrid(null,$tahun,null,4);//$file1,$file2
				 if($rs){
					$this->response($rs, 200); // 200 being the HTTP response code
				}else{
					$this->response(array('error' => 'Data Sasaran Program tidak ditemukan!'), 404);
				}	
			break;
			case 'sasarane2_list':
				$this->load->model('/pengaturan/sasaran_eselon2_model');
				$params = null;
				$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
				 
				$rs= $this->sasaran_eselon2_model->easyGrid(null,null,$tahun,null,4);//$file1,$file2
				 if($rs){
					$this->response($rs, 200); // 200 being the HTTP response code
				}else{
					$this->response(array('error' => 'Data Sasaran Kegiatan tidak ditemukan!'), 404);
				}	
			break;
			case 'ikukl1_list':
				$this->load->model('/pengaturan/iku_kl_model');
				$params = null;
				$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
				 
				$rs= $this->iku_kl_model->easyGrid(null,$tahun,null,4);//$file1,$file2
				 if($rs){
					$this->response($rs, 200); // 200 being the HTTP response code
				}else{
					$this->response(array('error' => 'Data IKU Kementerian tidak ditemukan!'), 404);
				}	
			break;
			case 'ikue1_list':
				$this->load->model('/pengaturan/iku_e1_model');
				$params = null;
				$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
				 
				$rs= $this->iku_e1_model->easyGrid(null,$tahun,null,4);//$file1,$file2
				 if($rs){
					$this->response($rs, 200); // 200 being the HTTP response code
				}else{
					$this->response(array('error' => 'Data IKU Eselon I tidak ditemukan!'), 404);
				}	
			break;
			case 'ikue2_list':
				$this->load->model('/pengaturan/ikk_model');
				$params = null;
				$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
				 
				$rs= $this->ikk_model->easyGrid(null,null,$tahun,null,4);//$file1,$file2
				 if($rs){
					$this->response($rs, 200); // 200 being the HTTP response code
				}else{
					$this->response(array('error' => 'Data IKK tidak ditemukan!'), 404);
				}	
			break;
			default :
			$this->response(array('error' => 'tidak ada data!'), 404);
		}
		
	}

	function user_get()
    {
        if(!$this->get('id'))
        {
        	$this->response(NULL, 400);
        }

        // $user = $this->some_model->getSomething( $this->get('id') );
    	$users = array(
			1 => array('id' => 1, 'name' => 'Some Guy', 'email' => 'example1@example.com', 'fact' => 'Loves swimming'),
			2 => array('id' => 2, 'name' => 'Person Face', 'email' => 'example2@example.com', 'fact' => 'Has a huge face'),
			3 => array('id' => 3, 'name' => 'Scotty', 'email' => 'example3@example.com', 'fact' => 'Is a Scott!', array('hobbies' => array('fartings', 'bikes'))),
		);
		
    	$user = @$users[$this->get('id')];
    	
        if($user)
        {
            $this->response($user, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }
    
    function user_post()
    {
        //$this->some_model->updateUser( $this->get('id') );
        $message = array('id' => $this->get('id'), 'name' => $this->post('name'), 'email' => $this->post('email'), 'message' => 'ADDED!');
        
        $this->response($message, 200); // 200 being the HTTP response code
    }
    
    function user_delete()
    {
    	//$this->some_model->deletesomething( $this->get('id') );
        $message = array('id' => $this->get('id'), 'message' => 'DELETED!');
        
        $this->response($message, 200); // 200 being the HTTP response code
    }
    
    function users_get()
    {
        //$users = $this->some_model->getSomething( $this->get('limit') );
        $users = array(
			array('id' => 1, 'name' => 'Some Guy', 'email' => 'example1@example.com'),
			array('id' => 2, 'name' => 'Person Face', 'email' => 'example2@example.com'),
			3 => array('id' => 3, 'name' => 'Scotty', 'email' => 'example3@example.com', 'fact' => array('hobbies' => array('fartings', 'bikes'))),
		);
        
        if($users)
        {
            $this->response($users, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'Couldn\'t find any users!'), 404);
        }
    }


	public function send_post()
	{
		var_dump($this->request->body);
	}


	public function send_put()
	{
		var_dump($this->put('foo'));
	}
}

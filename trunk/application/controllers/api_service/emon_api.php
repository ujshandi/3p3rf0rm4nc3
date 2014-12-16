<?php defined('BASEPATH') OR exit('No direct script access allowed');
 header("Access-Control-Allow-Origin: *");
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

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Emon_api extends REST_Controller
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
	
	function program_list_get(){
		$this->load->model('/emon/emon_program_model');
		$params = null;
		$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
		//var_dump($tahun);
		if ($tahun!='')
			$params['tahun']	= $tahun;
		$rs= $this->emon_program_model->getdata($params);//$file1,$file2
		 if($rs){
            $this->response($rs, 200); // 200 being the HTTP response code
        }else{
            $this->response(array('error' => 'Data Program Eselon I tidak ditemukan!'), 404);
        }	
	}
	
	
	function kegiatan_list_get(){
		$this->load->model('/emon/emon_kegiatan_model');
		$params = null;
		$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
		//var_dump($tahun);
		if ($tahun!='')
			$params['tahun']	= $tahun;
		$rs= $this->emon_kegiatan_model->getdata($params);//$file1,$file2
		 if($rs){
            $this->response($rs, 200); // 200 being the HTTP response code
        }else{
            $this->response(array('error' => 'Data Kegiatan Eselon II tidak ditemukan!'), 404);
        }	
	}
	
	
	function lokasi_list_get(){
		// $this->load->model('/emon/emon_lokasi_model');
		// $params = null;
		
		// $rs= $this->emon_lokasi_model->getdata();//$file1,$file2
		 // if($rs){
            // $this->response($rs, 200); // 200 being the HTTP response code
        // }else{
            // $this->response(array('error' => 'Data Lokasi tidak ditemukan!'), 404);
        // }	
	}
	
	function kabkota_list_get(){
		// $this->load->model('/emon/emon_kabkota_model');
		// $params = null;
		
		// $rs= $this->emon_kabkota_model->getdata();//$file1,$file2
		 // if($rs){
            // $this->response($rs, 200); // 200 being the HTTP response code
        // }else{
            // $this->response(array('error' => 'Data Kabupaten/Kota tidak ditemukan!'), 404);
        // }	
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
			
			case 'lokasi1_list':
				$this->load->model('/emon/emon_lokasi_model');
				$params = null;
				$rs= $this->emon_lokasi_model->getdata();//$file1,$file2
				 if($rs){
					$this->response($rs, 200); // 200 being the HTTP response code
				}else{
					$this->response(array('error' => 'Data Lokasi tidak ditemukan!'), 404);
				}	
			break;
			case 'kabkota1_list':
				$this->load->model('/emon/emon_kabkot_model');
				$params = null;
				
				$rs= $this->emon_kabkot_model->getdata();//$file1,$file2
				 if($rs){
					$this->response($rs, 200); // 200 being the HTTP response code
				}else{
					$this->response(array('error' => 'Data Kabupaten/Kota tidak ditemukan!'), 404);
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

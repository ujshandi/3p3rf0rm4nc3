<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 header("Access-Control-Allow-Origin: *");

class Login_anev extends CI_Controller {

	private static $brokers = array(
        '4N3V' => array('secret'=>"kosongkan"));
		
	public function __construct() {
		parent::__construct();
	//	$this->load->library("utility");
		$this->load->model('security/sys_login_anev_model','login');
	}
	
	
 // BUAT convert URI
// convert an ascii string to its hex representation
   private static function AsciiToHex($ascii)
   {
      $hex = '';

      for($i = 0; $i < strlen($ascii); $i++)
         $hex .= str_pad(base_convert(ord($ascii[$i]), 10, 16), 2, '0', STR_PAD_LEFT);

      return $hex;
   }

   // convert a hex string to ascii, prepend with '0' if input is not an even number
   // of characters in length   
   private static function HexToAscii($hex)
   {
      $ascii = '';
   
      if (strlen($hex) % 2 == 1)
         $hex = '0'.$hex;
   
      for($i = 0; $i < strlen($hex); $i += 2)
         $ascii .= chr(base_convert(substr($hex, $i, 2), 16, 10));
   
      return $ascii;
   }
   
	
	public function login_usr($username,$password) {
		//if (!isset(self::$brokers[$broker])) return null;
		$user = $this->HexToAscii($username);
		$pass = $this->HexToAscii($password);
		$response = $this->login->cek_login($user,$pass);
		//var_dump($response);die;
		if(is_string($response) && $response == 'REQUIRED') {
			echo 'Username and Password required';
		}else if($response == true) {
			echo 'http://localhost/e-anev/home'; //redirect('http://localhost/e-anev/home');			
		}else {
			echo 'Invalid Username and Password';			
		}
	}
	
	public function get_session_info($username,$password) {
		//if (!isset(self::$brokers[$broker])) return null;
		$user = $this->HexToAscii($username);
		$pass = $this->HexToAscii($password);
		$response = $this->login->getInfoSession($user,$pass);
		//var_dump($response);die;
		echo $response;
		
	}
	
	public function logout_user() {
		$response = $this->login->logout();
		if($response) 
			//redirect(base_url().'security/login');
			redirect(base_url());
	}
	
	
	
	private function chan63_pa55() {
		$response = $this->change_password();
	}
}

/* End of file widget.php */
/* Location: ./application/controllers/widget.php */

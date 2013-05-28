<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function load_js($list_file) {
	foreach($list_file as $file) {
		echo '<script type="text/javascript" src="'.base_url().'public/'.$file.'"></script>'."\n";
	}
}

function load_css($list_file) {
	foreach($list_file as $file) {
		echo '<link href="'.base_url().'public/'.$file.'" rel="stylesheet" type="text/css" />'."\n";
	}
}

function send_response($code, $data = null, $message = null) {
	if($code == '500') {
		die(json_encode(array(
							'code'=>(string)$code,
							'data'=>null,
							'message'=>'Internal Server Error, Please contact Administrator'
						)
			)
		);
	}else {
		die(json_encode(array(
							'code'=>(string)$code,
							'data'=>$data,
							'message'=>$message
						)
			)
		);
	}
}

function format_form_error($msg) {
	$source = array('<p>','</p>');
	$destination = array(' *',"");
	return str_replace($source,$destination,$msg);
}

function format_hp($hp) {
	//$required_format = '';
	//if(substr($hp,0,1) == '0') $required_format = str_replace('0','62',$hp);
}

function generate_id() {
	date_default_timezone_set("Asia/Jakarta");
	$t = microtime(true);
	$micro = sprintf("%06d",($t - floor($t)) * 1000000);
	$d = new DateTime( date('Y-m-d H:i:s.'.$micro,$t) );
	return substr($d->format("YmdHisu"),0,-2);
}

/*
base_helper.php
*/
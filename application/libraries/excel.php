<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
require_once APPPATH."/third_party/excel_reader2.php"; 
 
class excel extends Spreadsheet_Excel_Reader { 
    public function __construct() { 
        parent::__construct(); 
    } 
}
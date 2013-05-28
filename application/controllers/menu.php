<?php
class Menu extends CI_Controller {

	function __construct()
	{
		parent::__construct();			
		//if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');
	}
	
	function getMenu() {
		//get from sys_menu_model
		$response->page = 1;
		$response->total = 1;
		$response->records = 1;
		
		//adjacency
		//id,menu,url,level,parent,isleaf,expanded
		
		//nested
		//id,menu,url,level,left,right,isleaf,expanded
		/* $response->rows[0]['cell']=array(1,'Setup Data','',0,1,8,"false","false");
			$response->rows[1]['cell']=array(2,'Data Umum','',1,2,5,"false","false");
				$response->rows[2]['cell']=array(3,'Pekerjaan','setup/master/master_umum/3/10',2,3,4,"true","false"); */
		
		
		/*  $response->rows[0]['cell']=array(1,'Setup Data','',0,null,"false","false");
			$response->rows[1]['cell']=array(2,'Data Umum','',1,1,"false","false");
				$response->rows[2]['cell']=array(3,'Pekerjaan','setup/master/index/3/10',2,2,"true","false");
				$response->rows[3]['cell']=array(4,'Pendidikan','setup/master/index/4/11',2,2,"true","false");
				$response->rows[4]['cell']=array(5,'Golongan Darah','setup/master/index/5/5',2,2,"true","false");
				$response->rows[5]['cell']=array(6,'Agama','setup/master/index/6/4',2,2,"true","false");
				$response->rows[6]['cell']=array(7,'Hubungan Keluarga','setup/master/index/7/14',2,2,"true","false");
				$response->rows[7]['cell']=array(8,'Marga','setup/master/index/8/15',2,2,"true","false");
			$response->rows[8]['cell']=array(9,'Wilayah','setup/wilayah/index/9',1,1,"true","false");
			$response->rows[9]['cell']=array(10,'Dokter','',1,1,"false","false");
				$response->rows[10]['cell']=array(11,'Daftar Dokter','setup/dokter/index/11',2,10,"true","false");
				$response->rows[11]['cell']=array(12,'Dokter Unit','setup/dokter_unit/index/12',2,10,"true","false");
			$response->rows[12]['cell']=array(13,'Departement','',1,1,"false","false");
				$response->rows[13]['cell']=array(14,'Unit Rumah Sakit','setup/unit_rumkit/index/14/0',2,13,"true","false");
				$response->rows[14]['cell']=array(15,'Daftar Kamar','setup/master/index/15/9',2,13,"true","false");
				$response->rows[15]['cell']=array(16,'Kamar Unit','setup/kamar_unit/index/16',2,13,"true","false");
			$response->rows[16]['cell']=array(17,'Tindakan','',1,1,"false","false");
				$response->rows[17]['cell']=array(18,'Kelas Tindakan','setup/unit_rumkit/index/18/1',2,17,"true","false");
				$response->rows[18]['cell']=array(19,'Master Tindakan','setup/tindakan/index/19',2,17,"true","false");
				$response->rows[19]['cell']=array(20,'Tindakan Kelas','setup/tindakan_klas/index/20',2,17,"true","false");
				$response->rows[20]['cell']=array(21,'Tindakan Unit','setup/tindakan_unit/index/21',2,17,"true","false");
				$response->rows[21]['cell']=array(22,'Auto Charge','setup/auto_charge/index/22',2,17,"true","false");
			$response->rows[22]['cell']=array(23,'Tarif','',1,1,"false","false");
				$response->rows[23]['cell']=array(24,'Komponen Tarif','setup/master/index/24/3',2,23,"true","false");
				$response->rows[24]['cell']=array(25,'Kelompok Tarif','setup/master/index/25/2',2,23,"true","false");
				$response->rows[25]['cell']=array(26,'Periode','setup/periode/index/26',2,23,"true","false");
				$response->rows[26]['cell']=array(27,'Customer','setup/customer/index/27',2,23,"true","false");
				$response->rows[27]['cell']=array(28,'Tarif Tindakan','setup/tarif_tindakan/index/28',2,23,"true","false");
			$response->rows[28]['cell']=array(29,'Diagnosa','',1,1,"false","false");
				$response->rows[29]['cell']=array(30,'Data DTD','setup/data_dtd/index/30',2,29,"true","false");
				$response->rows[30]['cell']=array(31,'Data ICD X','setup/data_icd/index/31',2,29,"true","false");
				$response->rows[31]['cell']=array(32,'Tarif ICD X','setup/tarif_icd/index/32',2,29,"true","false");
			$response->rows[32]['cell']=array(33,'Farmasi','setup/farmasi/index/33/4',1,1,"true","false");
			$response->rows[33]['cell']=array(34,'Obat','',1,1,"false","false");
				$response->rows[34]['cell']=array(35,'Jenis Obat','setup/jenis_obat/index/35',2,34,"true","false");
				$response->rows[35]['cell']=array(36,'Golongan','setup/kategori_obat/index/36',2,34,"true","false");
				$response->rows[36]['cell']=array(37,'Satuan Obat','setup/satuan_obat/index/37',2,34,"true","false");
				$response->rows[37]['cell']=array(38,'Kemasan','setup/kemasan/index/38',2,34,"true","false");
			//Investor zone...
			$response->rows[38]['cell']=array(39,'Kepegawaian (Investor Zone)','',1,1,"false","false");
				$response->rows[39]['cell']=array(40,'Data Shift','setup/shift/index/40',2,39,"true","false");
				$response->rows[40]['cell']=array(41,'Data Jabatan','setup/jabatan/index/41',2,39,"true","false");
				$response->rows[41]['cell']=array(42,'Data Golongan','setup/master/index/42/24',2,39,"true","false");
				$response->rows[42]['cell']=array(43,'Data Jurusan','setup/master/index/43/25',2,39,"true","false"); */
			
				//$response->rows[31]['cell']=array(32,'Tarif ICD X','setup/tarif_icd/index/31',2,29,"true","false");		
				
				
		$response->rows[0]['cell']=array(1,'Administrasi Sistem','',0,null,"false","false");
			$response->rows[1]['cell']=array(2,'Data','',1,2,5,"false","false");
			$response->rows[2]['cell']=array(3,'Rumah Sakit','setup/master/index/3/10',2,2,"true","false");
			$response->rows[3]['cell']=array(4,'Pendidikan','setup/master/index/4/11',2,2,"true","false");
			$response->rows[4]['cell']=array(5,'Golongan Darah','setup/master/index/5/5',2,2,"true","false");
			$response->rows[5]['cell']=array(6,'Agama','setup/master/index/6/4',2,2,"true","false");
			$response->rows[6]['cell']=array(7,'Hubungan Keluarga','setup/master/index/7/14',2,2,"true","false");
			$response->rows[7]['cell']=array(8,'Marga','setup/master/index/8/15',2,2,"true","false");
			$response->rows[8]['cell']=array(9,'Wilayah','setup/wilayah/index/9',1,1,"true","false");
		
		echo json_encode($response);
	}
}
?>

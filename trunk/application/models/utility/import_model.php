<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class import_model extends CI_Model
{	
	/**
	* constructor
	*/
	
	var $overwrite="false";
	
	public function __construct()
    {
        parent::__construct();
		
    }
	
	public function doImport($menuId,$menuTitle,$replace,$tahun){
	    $this->overwrite = $replace;
		$srcTable =$this->getTableName($menuId,'src');
	//	var_dump($srcTable);die;
		if ($srcTable=='') return '';
		$dbDesti =  $this->load->database(strtolower("default"),true);
		$dbSrc =  $this->load->database(strtolower("import"),true);
		$destTable =$this->getTableName($menuId,'dest');
		$srcData = $this->getSrcData($dbSrc,$srcTable);
		
	//	var_dump($this->CI->model);
		//var_dump($srcData->result());die;
		$msg=$menuTitle.": <br>";
		$gagal = 0;
		$berhasil = 0;
		$ignore = 0;
		$rs=" diimport";
		foreach ($srcData->result() as $row){
			$result = false;
			/* $data = $this->setData($menuId,$row);
			if ($data==null) continue;
			$result = $this->CI->model->InsertOnDb($data,$error,$dbSrc); */
			try{
				$result = $this->insertData($dbDesti,$menuId,$row,$destTable,$tahun,$rs); 
				//var_dump($result);
				if ($result==true)
					$berhasil++;
				else if($result==false)
					$gagal++;
				else
				   $ignore++;
			}catch (Exception $e)
			{
				$result=false;
			}
			
			
				
		}
		if ($berhasil>0)
			$msg .= $berhasil.' data berhasil '.$rs.'.<br>';
		if ($gagal>0)
			$msg .= $gagal.' data gagal '.$rs.'.<br>';
		if ($ignore>0)
			$msg .= $ignore.' data '.$rs.'.<br>';
		if (($berhasil==0)&&($gagal==0))	{
			$msg .= 'Tidak ada data yang dimport.<br>';
		}
		$msg.='----------------------------------<br>';
		return $msg;
	}
	
	public function isExist($dbDesti,$destTable){
	//	$dbDesti->flush_cache();
		$dbDesti->select('*');
		$dbDesti->from($destTable);
		
		$que = $dbDesti->get();
		//var_dump($que);die;
		if ($que==null)
			return false;
		else if ($que->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}
	
	public function insertData($dbDesti,$menuId,$row,$destTable,$tahun,&$msg){
		$result = null;
		$existData = false;	
		switch ($menuId){
			case '2' : //KL
				return; // coz belum ada sumber nya
				$dbDesti->where('kode_kl', $row->kode_kl);
				$existData = $this->isExist($dbDesti,$destTable);
				$dbDesti->flush_cache();
				if ($existData){
					$dbDesti->where('kode_kl', $row->kode_kl);
				}
			//	var_dump($existData);die;
				$dbDesti->set('kode_kl',$row->kode_kl);
				$dbDesti->set('nama_kl',$row->nama_kl);
				$dbDesti->set('singkatan',$row->singkatan);
				$dbDesti->set('nama_menteri',$row->nama_menteri);				
			break;
			case '3'; //eselon 1
				$dbDesti->where('kode_e1', $row->kddept.'.'.$row->kdunit);
				$existData = $this->isExist($dbDesti,$destTable);
				$dbDesti->flush_cache();
				if ($existData){
					$dbDesti->where('kode_e1', $row->kddept.'.'.$row->kdunit);
				}
				$dbDesti->set('kode_e1',$row->kddept.'.'.$row->kdunit);
				$dbDesti->set('kode_kl',$row->kddept);
				$dbDesti->set('nama_e1',$row->nmunit);
			/* 	$dbDesti->set('singkatan',$row->singkatan);
				$dbDesti->set('nama_dirjen',$row->nama_dirjen);
				$dbDesti->set('nip',$row->nip);
				$dbDesti->set('pangkat',$row->pangkat);
				$dbDesti->set('gol',$row->gol); */
			break;
			case '4'; //eselon 2
				return; // coz belum ada sumber nya
				$dbDesti->where('kode_e2', $row->kode_e2);
				$existData = $this->isExist($dbDesti,$destTable);
				$dbDesti->flush_cache();
				if ($existData){
					$dbDesti->where('kode_e2', $row->kode_e2);
				}
				$dbDesti->set('kode_e2',$row->kode_e2);
				$dbDesti->set('kode_e1',$row->kode_e1);
				$dbDesti->set('nama_e2',$row->nama_e2);
				$dbDesti->set('singkatan',$row->singkatan);
				$dbDesti->set('nama_direktur',$row->nama_direktur);
				$dbDesti->set('nip',$row->nip);
				$dbDesti->set('pangkat',$row->pangkat);
				$dbDesti->set('gol',$row->gol);
				
			break;
			case '5'; //Satker
				return; // coz belum ada sumber nya
				$dbDesti->where('kode_satker', $row->kode_satker);
				$existData = $this->isExist($dbDesti,$destTable);
				$dbDesti->flush_cache();
				if ($existData){
					$dbDesti->where('kode_satker', $row->kode_satker);
				}
				$dbDesti->set('kode_satker',$row->kode_satker);
				$dbDesti->set('kode_e1',$row->kode_e1);
				$dbDesti->set('nama_satker',$row->nama_satker);
				$dbDesti->set('singkatan',$row->singkatan);
				$dbDesti->set('nama_kasatker',$row->nama_kasatker);
			break;
			case '6'; //program kl
				$dbDesti->where('tahun', $tahun);
				$dbDesti->where('kddept ', '022');
				$dbDesti->where('kode_program', $row->KDDEPT.'.'.$row->KDUNIT.'.'.$row->KDPROGRAM);
				$existData = $this->isExist($dbDesti,$destTable);
				$dbDesti->flush_cache();
				if ($existData){
					$dbDesti->where('tahun', $tahun);
					$dbDesti->where('kddept ', '022');
					$dbDesti->where('kode_program',  $row->KDDEPT.'.'.$row->KDUNIT.'.'.$row->KDPROGRAM);
				}
				$dbDesti->set('tahun', $tahun);
				$dbDesti->set('kode_program', $row->KDDEPT.'.'.$row->KDUNIT.'.'.$row->KDPROGRAM);
				$dbDesti->set('nama_program',$row->NMPROGRAM);
				//$dbDesti->set('total',$row->total);
				$dbDesti->set('kode_e1', $row->KDDEPT.'.'.$row->KDUNIT);
			break;
			case '7'; //kegiatan kl
				$dbDesti->where('kode_kegiatan', $row->KDDEPT.'.'.$row->KDUNIT.'.'.$row->KDPROGRAM.'.'.$row->KDGIAT);
				$dbDesti->where('tahun',$tahun);
				$existData = $this->isExist($dbDesti,$destTable);
				$dbDesti->flush_cache();
				if ($existData){
					$dbDesti->where('kode_kegiatan', $row->KDDEPT.'.'.$row->KDUNIT.'.'.$row->KDPROGRAM.'.'.$row->KDGIAT);
					$dbDesti->where('tahun', $tahun);
				}
				$dbDesti->set('tahun', $tahun);
				$dbDesti->set('kode_program',$row->KDDEPT.'.'.$row->KDUNIT.'.'.$row->KDPROGRAM);
				$dbDesti->set('kode_kegiatan',$row->KDDEPT.'.'.$row->KDUNIT.'.'.$row->KDPROGRAM.'.'.$row->KDGIAT);
				$dbDesti->set('nama_kegiatan',$row->NMGIAT);
			//	$dbDesti->set('total',$row->total);				
//				$dbDesti->set('kode_e2',$row->kode_e2);
			break;
			default : return; // coz belum ada sumber nya
			/* case '8'; //subkegiatan kl
				$dbDesti->where('tahun', $row->tahun);
				$dbDesti->where('kode_subkegiatan', $row->kode_subkegiatan);
				$existData = $this->isExist($dbDesti,$destTable);
				$dbDesti->flush_cache();
				if ($existData){
					$dbDesti->where('kode_subkegiatan', $row->kode_subkegiatan);
					$dbDesti->where('tahun', $row->tahun);
				}
				$dbDesti->set('tahun', 			$row->tahun);
				$dbDesti->set('kode_kegiatan',		$row->kode_kegiatan);
				$dbDesti->set('kode_satker',		$row->kode_satker);
				
				$dbDesti->set('kode_subkegiatan',	$row->kode_subkegiatan);
				$dbDesti->set('nama_subkegiatan',	$row->nama_subkegiatan);
				$dbDesti->set('lokasi',			$row->lokasi);
				$dbDesti->set('volume',			$row->volume);
				$dbDesti->set('satuan',			$row->satuan);
				$dbDesti->set('total',				$row->total);
			break;
			
			case '31'; //Sasaran Kementerian
				$dbDesti->where('kode_sasaran_kl', $row->kode_sasaran_kl);				
				$existData = $this->isExist($dbDesti,$destTable);
				$dbDesti->flush_cache();
				if ($existData){
					$dbDesti->where('kode_sasaran_kl', $row->kode_sasaran_kl);					
				}
				$dbDesti->set('kode_sasaran_kl',$row->kode_sasaran_kl);
				$dbDesti->set('deskripsi',$row->deskripsi);		
			break;
			case '32'; //Sasaran Eselon 1
				$dbDesti->where('kode_sasaran_e1', $row->kode_sasaran_e1);				
				$existData = $this->isExist($dbDesti,$destTable);
				$dbDesti->flush_cache();
				if ($existData){
					$dbDesti->where('kode_sasaran_e1', $row->kode_sasaran_e1);					
				}
				$dbDesti->set('kode_e1',$row->kode_e1);
				$dbDesti->set('kode_sasaran_e1',$row->kode_sasaran_e1);
				$dbDesti->set('kode_sasaran_kl',(($row->kode_sasaran_kl=="")||($row->kode_sasaran_kl==null)||($row->kode_sasaran_kl=="-1")?null:$row->kode_sasaran_kl));
				$dbDesti->set('deskripsi',$row->deskripsi);
			break;
			case '33'; //Sasaran Eselon 2
				$dbDesti->where('kode_sasaran_e2', $row->kode_sasaran_e2);				
				$existData = $this->isExist($dbDesti,$destTable);
				$dbDesti->flush_cache();
				if ($existData){
					$dbDesti->where('kode_sasaran_e2', $row->kode_sasaran_e2);					
				}
				$dbDesti->set('kode_e2',$row->kode_e2);
				$dbDesti->set('kode_sasaran_e2',$row->kode_sasaran_e2);
				$dbDesti->set('kode_sasaran_e1',(($row->kode_sasaran_e1=="")||($row->kode_sasaran_e1==null)||($row->kode_sasaran_e1=="-1")?null:$row->kode_sasaran_e1));
				$dbDesti->set('deskripsi',$row->deskripsi);
			break;
			case '34'; //IKU KL
				$dbDesti->where('kode_iku_kl', $row->kode_iku_kl);	
				$dbDesti->where('tahun', $row->tahun);	
				$existData = $this->isExist($dbDesti,$destTable);
				$dbDesti->flush_cache();
				if ($existData){
					$dbDesti->where('kode_iku_kl', $row->kode_iku_kl);					
					$dbDesti->where('tahun', $row->tahun);
				}
				$dbDesti->set('tahun',$row->tahun);
				$dbDesti->set('kode_iku_kl',$row->kode_iku_kl);
				$dbDesti->set('kode_kl',$row->kode_kl);
				$dbDesti->set('deskripsi',$row->deskripsi);
				$dbDesti->set('satuan',$row->satuan);
				$dbDesti->set('kode_e1',$row->kode_e1);
				
			break;
			case '35'; //IKU Eselon 1
				$dbDesti->where('kode_iku_e1', $row->kode_iku_e1);				
				$dbDesti->where('tahun', $row->tahun);
				$existData = $this->isExist($dbDesti,$destTable);
				$dbDesti->flush_cache();
				if ($existData){
					$dbDesti->where('kode_iku_e1', $row->kode_iku_e1);					
					$dbDesti->where('tahun', $row->tahun);
				}
				$dbDesti->set('kode_e1',$row->kode_e1);
				$dbDesti->set('kode_e2',$row->kode_e2);
				$dbDesti->set('tahun',$row->tahun);
				$dbDesti->set('kode_iku_kl',(($row->kode_iku_kl=="")||($row->kode_iku_kl==null)||($row->kode_iku_kl=="-1")?null:$row->kode_iku_kl));
				$dbDesti->set('kode_iku_e1',$row->kode_iku_e1);
				$dbDesti->set('deskripsi',$row->deskripsi);
				$dbDesti->set('satuan',$row->satuan);
			break;
			case '36'; //IKU Eselon 2 /IKK
				$dbDesti->where('kode_ikk', $row->kode_ikk);				
				$dbDesti->where('tahun', $row->tahun);
				$existData = $this->isExist($dbDesti,$destTable);
				$dbDesti->flush_cache();
				if ($existData){
					$dbDesti->where('kode_ikk', $row->kode_ikk);					
					$dbDesti->where('tahun', $row->tahun);
				}
				$dbDesti->set('kode_ikk',$row->kode_ikk);
				$dbDesti->set('deskripsi',$row->deskripsi);
				$dbDesti->set('satuan',$row->satuan);
				$dbDesti->set('tahun',$row->tahun);
				//$dbDesti->set('kode_iku_e1',$row->kode_iku_e1);
				$dbDesti->set('kode_iku_e1',(($row->kode_iku_e1=="")||($row->kode_iku_e1==null)||($row->kode_iku_e1=="-1")?null:$row->kode_iku_e1));
				$dbDesti->set('kode_e2',$row->kode_e2);
			break;
			
			case '51'; //RKT KL
				$dbDesti->where('kode_iku_kl', $row->kode_iku_kl);	
				$dbDesti->where('kode_kl', $row->kode_kl);	
				$dbDesti->where('kode_sasaran_kl', $row->kode_sasaran_kl);	
				$dbDesti->where('tahun', $row->tahun);	
				$existData = $this->isExist($dbDesti,$destTable);
				$dbDesti->flush_cache();
				if ($existData){
					$dbDesti->where('kode_iku_kl', $row->kode_iku_kl);					
					$dbDesti->where('tahun', $row->tahun);
					$dbDesti->where('kode_kl', $row->kode_kl);	
					$dbDesti->where('kode_sasaran_kl', $row->kode_sasaran_kl);	
				}
				$dbDesti->set('tahun',				$row->tahun);
				$dbDesti->set('kode_kl',			$row->kode_kl);
				$dbDesti->set('kode_sasaran_kl',	$row->kode_sasaran_kl);
				$dbDesti->set('kode_iku_kl',		$row->kode_iku_kl);
				$dbDesti->set('target',			$row->target);
				$dbDesti->set('status',			'0');
				
			break;
			case '52'; //RKT Eselon 1
				$dbDesti->where('kode_iku_e1', $row->kode_iku_e1);				
				$dbDesti->where('tahun', $row->tahun);
				$dbDesti->where('kode_e1', $row->kode_e1);	
				$dbDesti->where('kode_sasaran_e1', $row->kode_sasaran_e1);	
				$existData = $this->isExist($dbDesti,$destTable);
				$dbDesti->flush_cache();
				if ($existData){
					$dbDesti->where('kode_iku_e1', $row->kode_iku_e1);					
					$dbDesti->where('tahun', $row->tahun);
					$dbDesti->where('kode_e1', $row->kode_e1);	
					$dbDesti->where('kode_sasaran_e1', $row->kode_sasaran_e1);	
				}
				$dbDesti->set('tahun',				$row->tahun);
				$dbDesti->set('kode_e1',			$row->kode_e1);
				$dbDesti->set('kode_sasaran_e1',	$row->kode_sasaran_e1);
				$dbDesti->set('kode_iku_e1',		$row->kode_iku_e1);
				$dbDesti->set('target',			$row->target);
				//$dbDesti->set('satuan',			$row->satuan);
				$dbDesti->set('status',			'0');
			break;
			case '53'; //RKT Eselon 2 
				$dbDesti->where('kode_ikk', $row->kode_ikk);				
				$dbDesti->where('tahun', $row->tahun);
				$dbDesti->where('kode_e2', $row->kode_e2);	
				$dbDesti->where('kode_sasaran_e2', $row->kode_sasaran_e2);	
				$existData = $this->isExist($dbDesti,$destTable);
				$dbDesti->flush_cache();
				if ($existData){
					$dbDesti->where('kode_ikk', $row->kode_ikk);					
					$dbDesti->where('tahun', $row->tahun);
					$dbDesti->where('kode_e2', $row->kode_e2);	
					$dbDesti->where('kode_sasaran_e2', $row->kode_sasaran_e2);	
				}
				$dbDesti->set('tahun',$row->tahun);
				$dbDesti->set('kode_e2',$row->kode_e2);
				$dbDesti->set('kode_sasaran_e2',$row->kode_sasaran_e2);
				$dbDesti->set('kode_ikk',$row->kode_ikk);
				$dbDesti->set('target',$row->target);
				//$dbDesti->set('satuan',$row->satuan);
				$dbDesti->set('status', '0');
			break;
			
			case '101'; //PK KL
				$dbDesti->where('kode_iku_kl', $row->kode_iku_kl);	
				$dbDesti->where('kode_kl', $row->kode_kl);	
				$dbDesti->where('kode_sasaran_kl', $row->kode_sasaran_kl);	
				$dbDesti->where('tahun', $row->tahun);	
				$existData = $this->isExist($dbDesti,$destTable);
				$dbDesti->flush_cache();
				if ($existData){
					$dbDesti->where('kode_iku_kl', $row->kode_iku_kl);					
					$dbDesti->where('tahun', $row->tahun);
					$dbDesti->where('kode_kl', $row->kode_kl);	
					$dbDesti->where('kode_sasaran_kl', $row->kode_sasaran_kl);	
				}
				$dbDesti->set('tahun',$row->tahun);
				$dbDesti->set('kode_kl',$row->kode_kl);
				$dbDesti->set('kode_sasaran_kl',$row->kode_sasaran_kl);
				
				$dbDesti->set('kode_iku_kl',$row->kode_iku_kl);
				$dbDesti->set('target',$row->target);
				//$dbDesti->set('satuan',$row->satuan);
				$dbDesti->set('penetapan',$row->penetapan);
				// update status tabel RKT
				
				
			break;
			case '102'; //PK Eselon 1
				$dbDesti->where('kode_iku_e1', $row->kode_iku_e1);				
				$dbDesti->where('tahun', $row->tahun);
				$dbDesti->where('kode_e1', $row->kode_e1);	
				$dbDesti->where('kode_sasaran_e1', $row->kode_sasaran_e1);	
				$existData = $this->isExist($dbDesti,$destTable);
				$dbDesti->flush_cache();
				if ($existData){
					$dbDesti->where('kode_iku_e1', $row->kode_iku_e1);					
					$dbDesti->where('tahun', $row->tahun);
					$dbDesti->where('kode_e1', $row->kode_e1);	
					$dbDesti->where('kode_sasaran_e1', $row->kode_sasaran_e1);	
				}
				//query insert data
				$dbDesti->flush_cache();
				$dbDesti->set('tahun',$row->tahun);
				$dbDesti->set('kode_e1',$row->kode_e1);
				$dbDesti->set('kode_sasaran_e1',$row->kode_sasaran_e1);
				$dbDesti->set('kode_iku_e1',$row->kode_iku_e1);
				$dbDesti->set('target',$row->target);
				//$dbDesti->set('satuan',$row->satuan);
				$dbDesti->set('penetapan',$row->penetapan);
				//$result = $dbDesti->insert('tbl_pk_eselon1');
				
			
			break;
			case '103'; //PK Eselon 2 
				$dbDesti->where('kode_ikk', $row->kode_ikk);				
				$dbDesti->where('tahun', $row->tahun);
				$dbDesti->where('kode_e2', $row->kode_e2);	
				$dbDesti->where('kode_sasaran_e2', $row->kode_sasaran_e2);	
				$existData = $this->isExist($dbDesti,$destTable);
				$dbDesti->flush_cache();
				if ($existData){
					$dbDesti->where('kode_ikk', $row->kode_ikk);					
					$dbDesti->where('tahun', $row->tahun);
					$dbDesti->where('kode_e2', $row->kode_e2);	
					$dbDesti->where('kode_sasaran_e2', $row->kode_sasaran_e2);	
				}
				$dbDesti->set('tahun',$row->tahun);
				$dbDesti->set('kode_e2',$row->kode_e2);
				$dbDesti->set('kode_sasaran_e2',$row->kode_sasaran_e2);
				$dbDesti->set('kode_ikk',$row->kode_ikk);
				$dbDesti->set('target',$row->target);
				//$dbDesti->set('satuan',$row->satuan);
				$dbDesti->set('penetapan',$row->penetapan);
				//$result = $dbDesti->insert('tbl_pk_eselon2');
				
				// update status tabel RKT
				
			break;
			
			case '151'; //Realisasi KL
				$dbDesti->where('kode_iku_kl', $row->kode_iku_kl);	
				$dbDesti->where('kode_kl', $row->kode_kl);	
				$dbDesti->where('kode_sasaran_kl', $row->kode_sasaran_kl);	
				$dbDesti->where('tahun', $row->tahun);	
				$dbDesti->where('triwulan', $row->triwulan);	
				$existData = $this->isExist($dbDesti,$destTable);
				$dbDesti->flush_cache();
				if ($existData){
					$dbDesti->where('kode_iku_kl', $row->kode_iku_kl);					
					$dbDesti->where('tahun', $row->tahun);
					$dbDesti->where('kode_kl', $row->kode_kl);	
					$dbDesti->where('kode_sasaran_kl', $row->kode_sasaran_kl);	
					$dbDesti->where('triwulan', $row->triwulan);	
				}
				$dbDesti->set('tahun',$row->tahun);
				$dbDesti->set('triwulan',$row->triwulan);
				$dbDesti->set('kode_kl',$row->kode_kl);
				$dbDesti->set('kode_sasaran_kl',$row->kode_sasaran_kl);
				
				$dbDesti->set('kode_iku_kl',$row->kode_iku_kl);
				// $dbDesti->set('target',$row->target);
				// $dbDesti->set('satuan',$row->satuan);
				$dbDesti->set('realisasi',$row->realisasi);
				
				
			break;
			case '152'; //Realisasi Eselon 1
				$dbDesti->where('kode_iku_e1', $row->kode_iku_e1);				
				$dbDesti->where('tahun', $row->tahun);
				$dbDesti->where('kode_e1', $row->kode_e1);	
				$dbDesti->where('kode_sasaran_e1', $row->kode_sasaran_e1);	
				$dbDesti->where('triwulan', $row->triwulan);	
				$existData = $this->isExist($dbDesti,$destTable);
				$dbDesti->flush_cache();
				if ($existData){
					$dbDesti->where('kode_iku_e1', $row->kode_iku_e1);					
					$dbDesti->where('tahun', $row->tahun);
					$dbDesti->where('kode_e1', $row->kode_e1);	
					$dbDesti->where('kode_sasaran_e1', $row->kode_sasaran_e1);	
					$dbDesti->where('triwulan', $row->triwulan);	
				}
				//query insert data
				$dbDesti->flush_cache();
				$dbDesti->set('tahun',$row->tahun);
				$dbDesti->set('triwulan',$row->triwulan);
				$dbDesti->set('kode_e1',$row->kode_e1);
				$dbDesti->set('kode_sasaran_e1',$row->kode_sasaran_e1);
				
				$dbDesti->set('kode_iku_e1',$row->kode_iku_e1);
				// $dbDesti->set('target',$row->target);
				// $dbDesti->set('satuan',$row->satuan);
				$dbDesti->set('realisasi',$row->realisasi);
				
				
			break;
			case '153'; //Realisasi Eselon 2 
				$dbDesti->where('kode_ikk', $row->kode_ikk);				
				$dbDesti->where('tahun', $row->tahun);
				$dbDesti->where('kode_e2', $row->kode_e2);	
				$dbDesti->where('kode_sasaran_e2', $row->kode_sasaran_e2);	
				$dbDesti->where('triwulan', $row->triwulan);	
				$existData = $this->isExist($dbDesti,$destTable);
				$dbDesti->flush_cache();
				if ($existData){
					$dbDesti->where('kode_ikk', $row->kode_ikk);					
					$dbDesti->where('tahun', $row->tahun);
					$dbDesti->where('kode_e2', $row->kode_e2);	
					$dbDesti->where('kode_sasaran_e2', $row->kode_sasaran_e2);	
					$dbDesti->where('triwulan', $row->triwulan);	
				}
				$dbDesti->set('tahun',$row->tahun);
				$dbDesti->set('triwulan',$row->triwulan);
				$dbDesti->set('kode_e2',$row->kode_e2);
				$dbDesti->set('kode_sasaran_e2',$row->kode_sasaran_e2);
				
				$dbDesti->set('kode_ikk',$row->kode_ikk);
				// $dbDesti->set('target',$row->target);
				// $dbDesti->set('satuan',$row->satuan);
				$dbDesti->set('realisasi',$row->realisasi);
					
				
				
			break; */
		
		}
		//var_dump($existData);
		
		if ($existData==true){
			//var_dump($this->overwrite);
			if ($this->overwrite=="true"){
				$result = $dbDesti->update($destTable);
				$msg = ' diubah ';
			}
			else {
				$result=null;
				$msg = ' diabaikan';
			}
		}
		else if ($existData==false){
				//var_dump("kadieu");
			$result = $dbDesti->insert($destTable);
			$msg = ' ditambahkan';
		}
		else {
				$result=null;
				$msg = ' diabaikan';
			}
		return $result;
	}
	
	public function getSrcData($db,$tableName){
		$db->select("*",false);
		$db->from($tableName);
		return $db->get();
	}
	
	//$purpose = dest/src
	public function getTableName($menuId,$purpose){
		$rs = '';
		if ($purpose=='src'){
			switch ($menuId){
			//	case '2' : $rs = 'tbl_kl';break;
				case '3' : $rs = 'tbl_unit' ;break;//'tbl_eselon1'
			//	case '4' : $rs = 'tbl_eselon2';break;
			//	case '5' : $rs = 'tbl_satker';break;
				case '6' : $rs = 't_program';break;//'tbl_program_kl'
				case '7' : $rs = 't_giat';break;//tbl_kegiatan_kl
				/* case '8' : $rs = 'tbl_subkegiatan_kl';break;
				case '31' : $rs = 'tbl_sasaran_kl';break;
				case '32' : $rs = 'tbl_sasaran_eselon1';break;
				case '33' : $rs = 'tbl_sasaran_eselon2';break;
				case '34' : $rs = 'tbl_iku_kl';break;
				case '35' : $rs = 'tbl_iku_eselon1';break;
				case '36' : $rs = 'tbl_ikk';break;
				case '51' : $rs = 'tbl_rkt_kl';break;
				case '52' : $rs = 'tbl_rkt_eselon1';break;
				case '53' : $rs = 'tbl_rkt_eselon2';break;
				case '101' : $rs = 'tbl_pk_kl';break;
				case '102' : $rs = 'tbl_pk_eselon1';break;
				case '103' : $rs = 'tbl_pk_eselon2';break;
				case '151' : $rs = 'tbl_kinerja_kl';break;
				case '152' : $rs = 'tbl_kinerja_eselon1';break;
				case '153' : $rs = 'tbl_kinerja_eselon2';break; */
			}
		} else if ($purpose=='dest'){
			switch ($menuId){
				case '2' : $rs = 'tbl_kl';break;
				case '3' : $rs = 'tbl_eselon1';break;
				case '4' : $rs = 'tbl_eselon2';break;
				case '5' : $rs = 'tbl_satker';break;
				case '6' : $rs = 'tbl_program_kl';break;
				case '7' : $rs = 'tbl_kegiatan_kl';break;
				case '8' : $rs = 'tbl_subkegiatan_kl';break;
				case '31' : $rs = 'tbl_sasaran_kl';break;
				case '32' : $rs = 'tbl_sasaran_eselon1';break;
				case '33' : $rs = 'tbl_sasaran_eselon2';break;
				case '34' : $rs = 'tbl_iku_kl';break;
				case '35' : $rs = 'tbl_iku_eselon1';break;
				case '36' : $rs = 'tbl_ikk';break;
				case '51' : $rs = 'tbl_rkt_kl';break;
				case '52' : $rs = 'tbl_rkt_eselon1';break;
				case '53' : $rs = 'tbl_rkt_eselon2';break;
				case '101' : $rs = 'tbl_pk_kl';break;
				case '102' : $rs = 'tbl_pk_eselon1';break;
				case '103' : $rs = 'tbl_pk_eselon2';break;
				case '151' : $rs = 'tbl_kinerja_kl';break;
				case '152' : $rs = 'tbl_kinerja_eselon1';break;
				case '153' : $rs = 'tbl_kinerja_eselon2';break;
			}
		}
		
		return $rs;
	}
	
	
	
}
?>
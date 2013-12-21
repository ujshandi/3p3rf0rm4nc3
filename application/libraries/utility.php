<?php
class Utility{
	var $model ;
	
	function Utility(){
		$this->model = new CI_Model();
	
	}
	
function getKelas($name='cmbFilterKelas'){
	return '<select name="'.$name.'" id="'.$name.'">
				<option value="1">Non Kelas</option>
				<option value="2">Kelas III</option>
				<option value="3">Kelas II</option>
				<option value="4">Kelas I</option>
			</select>';
}
	
function cutString($aValue,$search,$count=0,$index=0){  //for MSISDN
	//$search=string yang akan dicari
	//$count=jumlah yang akan dipotong
	//$index=index mulai ambil minus ambil dari belakang / plus ambil dari depan
	if ($search=='0'){
		if ($aValue[0]===$search)
			$aValue = substr($aValue,$index,strlen($aValue)-$count);
	}else if ($search=='62'){
		if ($aValue[0]===$search[0] && $aValue[1]===$search[1])
			$aValue = substr($aValue,$index,strlen($aValue)-$count);
	}
	return $aValue;	
}

function closeWindow(){
	 echo '<script language="javascript" >window.close();</script>';  
}
function ourDatePicker($aName='',$event=''){
   // echo '<script language="javascript" src="./style/js/popcalendar.js"></script>';   
		if (!empty($aName)) {		
			echo "<IMG style=\"CURSOR: hand\" valign=\"middle\" onclick=\" popUpCalendar(this,'$aName','dd-mm-yyyy'); return false\" alt=\"View Callendar\" src=\"./images/calendar/callendar.gif\">";							 
		}else {
			echo "<IMG alt=\"View Callendar\" src=\"./images/calendar/callendar.gif\">";
		}
   }
   
   
function trimAll($value){
	return (str_replace(" ","",$value));
}

function isValidPhoneNumber($value){
 //cek digit hanya boleh bernilai 0 sampai 9
   $arr = array('0','1','2','3','4','5','6','7','8','9');
   $rs = true;
   for ($i=0;$i<strlen($value);$i++)
	if (!in_array($value[$i],$arr)){
	    $rs = false;
		break;
	}
	
	return $rs;
}


function uploadFile($dir="", $compName=""){
		//directory
	$upload["dir"]= $dir;
		//temporary file ke webserver
	$upload["fileTemp"]= $_FILES[$compName]["tmp_name"];
		//nama file
	$upload["fileName"]=trim($_FILES[$compName]["name"]);
		//nama directory + file
	$upload["dirFile"] = $upload["dir"].$upload["fileName"];	
	return $upload;
}

function getCariLike($name='cmbFilterLike'){
	return '<select name="'.$name.'" id="'.$name.'">
				<option value="0">Seluruh Kata</option>
				<option value="1">Berawalan Kata ini</option>
				<option value="2">Berakhiran Kata ini</option>
				<option value="3">Kata ini saja</option>
			</select>';
}

function getAgama($value="",$compName="",$event=""){
	if (empty($compName))
	$name ="cmbAgama";
  else 
    $name =$compName;
   return '<select name="'.$name.'" '.$event.'>
			  <option value="Islam" '.getSelected("Islam",$value).'>Islam</option>
			  <option value="Protestan" '.getSelected("Protestan",$value).'>Kristen Protestan</option>
			  <option value="Katholik" '.getSelected("Katholik",$value).'>Katholik</option>
			  <option value"Hindu" '.getSelected("Hindu",$value).'>Hindu</option>
			  <option value="Budha" '.getSelected("Budha",$value).'>Budha</option>
			  <option value="Lain" '.getSelected("Lain",$value).'>Lain-Lain</option>
	       </select>';
}

//diganti dari database aja
function getListAgamaOld($getNama=FALSE){
	$rs  = array ("-1"=>"Pilih","Islam"=>"Islam","Protestan"=>"Protestan","Katolik"=>"Katolik","Hindu"=>"Hindu","Budha"=>"Budha","Lain"=>"Lain");
	if($getNama)
		return $rs[$getNama];
	else
		return $rs;
}

function getListSex($getSex=FALSE){	
	$rs  = array ("-1"=>"Pilih","Pria"=>"Pria","Wanita"=>"Wanita");
	if ($getSex)
		return $rs[$getSex];
	else
		return $rs;
}

function getListStatusKawin($getStatus=FALSE){	
	$rs  = array ("-1"=>"Pilih","Kawin"=>"Kawin","Belum Kawin"=>"Belum Kawin","Janda"=>"Janda","Duda"=>"Duda","Lain"=>"Lain");
	if ($getStatus)
		return $rs[$getStatus];
	else
		return $rs;
}

function getListTipePendidikanFormal($getStatus=FALSE){	
	$rs  = array ("-1"=>"Pilih","SD"=>"SD","SLTP"=>"SLTP","SLTA"=>"SLTA","UNIVERSITAS"=>"UNIVERSITAS","Lain"=>"Lain");
	if ($getStatus)
		return $rs[$getStatus];
	else
		return $rs;
}


function getListStatusPart($withApkir=true){
	if ($withApkir)
		$rs  = array ("-1"=>"Pilih",PART_BARU=>"Baru",PART_BEKAS=>"Bekas",PART_REPAIRABLE=>"Repairable",PART_APKIR=>"APKIR");
	else
		$rs  = array ("-1"=>"Pilih",PART_BARU=>"Baru",PART_BEKAS=>"Bekas",PART_REPAIRABLE=>"Repairable");
	return $rs;
}

function getListStatusPart2($value=NULL,$withApkir=true){
	$tmp = "<select name='cmbStatusPart' id='cmbStatusPart'>";
	$tmp.= "<option value='-1' ".(($value=='-1')?'selected':''	)." >Pilih</option>";
	$tmp.= "<option value='".PART_BARU."' ".(($value==PART_BARU)?'selected':''	)." >Baru</option>";
	$tmp.= "<option value='".PART_BEKAS."' ".(($value==PART_BEKAS)?'selected':''	).">Bekas</option>";
	$tmp.= "<option value='".PART_REPAIRABLE."' ".(($value==PART_REPAIRABLE)?'selected':''	).">Repairable</option>";
	if ($withApkir)
		$tmp.= "<option value='".PART_APKIR."' ".(($value==PART_APKIR)?'selected':''	).">Apkir</option>";
	$tmp.= "</select>";
	return $tmp;
}

function getListJenisStok(){
	$rs  = array ("-1"=>"Pilih",STOK_NORMAL=>"Stok Normal",STOK_DIPINJAM=>"Stok Dipinjam",STOK_LUAR=>"Stok Diluar");
	return $rs;
}
function getListJenisStok2($value=NULL){
	$tmp = "<select name='cmbJenisStok' id='cmbJenisStok'>";
	$tmp.= "<option value='-1' ".(($value=='-1')?'selected':''	)." >Pilih</option>";
	$tmp.= "<option value='".STOK_NORMAL."' ".(($value==STOK_NORMAL)?'selected':''	)." >Stok Normal</option>";
	$tmp.= "<option value='".STOK_DIPINJAM."' ".(($value==STOK_DIPINJAM)?'selected':''	).">Stok Dipinjam</option>";
	$tmp.= "<option value='".STOK_LUAR."' ".(($value==STOK_LUAR)?'selected':''	).">Stok Diluar</option>";	
	$tmp.= "</select>";
	return $tmp;
}


function getListStatusKomponen2($value){
	$tmp = "<select name='cmbStatusBarang' id='cmbStatusBarang'>";
	$tmp.= "<option value='-1' ".(($value=='-1')?'selected':''	)." >Pilih</option>";
	$tmp.= "<option value='1' ".(($value=='<')?'selected':''	).">Baik</option>";
	$tmp.= "<option value='2' ".(($value=='>')?'selected':''	).">Rusak</option>";
	$tmp.= "<option value='3' ".(($value=='<=')?'selected':''	).">Repairable</option>";
	$tmp.= "</select>";
	return $tmp;
}

function getListKondisiKelengkapan($value){
	$tmp = "<select name='cmbKondisiKelengkapan' id='cmbKondisiKelengkapan'>";
	$tmp.= "<option value='-1' ".(($value=='-1')?'selected':''	)." >Pilih</option>";
	$tmp.= "<option value='Bagus' ".(($value=='<')?'selected':''	).">Bagus</option>";
	$tmp.= "<option value='Cacat' ".(($value=='>')?'selected':''	).">Cacat</option>";
	$tmp.= "<option value='Baik' ".(($value=='>')?'selected':''	).">Baik</option>";
	$tmp.= "<option value='Bersih' ".(($value=='>')?'selected':''	).">Bersih</option>";
	$tmp.= "<option value='Kotor' ".(($value=='>')?'selected':''	).">Kotor</option>";
	$tmp.= "<option value='Ada' ".(($value=='<=')?'selected':''	).">Ada</option>";
	$tmp.= "<option value='Tidak Ada' ".(($value=='<=')?'selected':''	).">Tidak Ada</option>";
	$tmp.= "</select>";
	
	$tmp = array ("-1"=>"Pilih",'Bagus'=>"Bagus",'Cacat'=>'Cacat','Baik'=>'Baik','Bersih'=>'Bersih','Kotor'=>'Kotor','Ada'=>'Ada','Tidak Ada'=>'Tidak Ada');
	return $tmp;
}

//buat rakit mesin
function getListStatusKomponen(){
	$rs  = array ("-1"=>"Pilih",KOMPONEN_BAIK=>"Baik",KOMPONEN_RUSAK=>"Rusak",KOMPONEN_REPAIRABLE=>"Repairable");
	return $rs;
}

//parameter nama,id,value
function getListDari2($value=null,$name=null){
	if ($name == null)
		$tmp = "<select name='cmbDari' id='cmbDari'>";
	else
		$tmp = "<select name='$name' id='$name'>";
	$tmp.= "<option value='Dari' ".(($value=='Dari')?'selected':''	)." >Dari</option>";
	$tmp.= "<option value='=' ".(($value=='=')?'selected':''	).">=</option>";
	$tmp.= "<option value='<' ".(($value=='<')?'selected':''	)."><</option>";
	$tmp.= "<option value='>' ".(($value=='>')?'selected':''	).">></option>";
	$tmp.= "<option value='<=' ".(($value=='<=')?'selected':''	)."><=</option>";
	$tmp.= "<option value='>='> ".(($value=='>=')?'selected':''	).">=</option>";
	$tmp.= "<option value='<>' ".(($value=='<>')?'selected':''	)."><></option>";
	$tmp.= "</select>";
	return $tmp;
}

function getListDari(){
	$rs  = array ("-1"=>"Dari","<"=>"<",">"=>">","="=>"=");
	return $rs;
}


function getListStatusMesin(){
	$rs = array("-1"=>"Pilih","1"=>"Turun Mesin","2"=>"Naik Mesin");
	return $rs;
}

function getListSIM(){	
	// A, C, B1 umum, B2 umum, B1 preman, B2 preman
	$rs  = array ("-1"=>"Pilih","A"=>"A","A Umum"=>"A Umum","B1 Umum"=>"B1 Umum","B2 Umum"=>"B2 Umum","B1 Preman"=>"B1 Preman","B2 Preman"=>"B2 Preman","C"=>"C");
	return $rs;
}

function getListWargaNegara(){		
	$rs  = array ("-1"=>"Pilih","WNI"=>"WNI","WNA"=>"WNA");
	return $rs;
}

function getListGolDarah(){	
	$rs  = array ("-1"=>"Pilih","A"=>"A","AB"=>"AB","B"=>"B","O"=>"O");
	return $rs;
}

function getListRumah(){	
	$rs  = array ("-1"=>"Pilih","Orang Tua"=>"Orang Tua","Sendiri"=>"Sendiri","Kontrak"=>"Kontrak","Sewa"=>"Sewa","Kost"=>"Kost","Lain-lain"=>"Lain-lain");
	return $rs;
}

function getListStatusPegawai(){	
	$rs  = array ("-1"=>"Pilih","Harian"=>"Harian","Borongan"=>"Borongan","Staff"=>"Staff","Kontrak"=>"Kontrak");
	return $rs;
}

function getListIjazah(){	
	$rs  = array ("-1"=>"Pilih","Berijazah"=>"Berijazah","Tidak"=>"Tidak");
	return $rs;
}

//new
function getHari($value="",$Compname){
  if (empty($Compname))
	$name ="cmbHari";
  else 
    $name =$Compname;
   return '<select name="'.$name.'">
			  <option value=0 '.getSelected(0,$value).'>Senin</option>
			  <option value=1 '.getSelected(1,$value).'>Selasa</option>
			  <option value=2 '.getSelected(2,$value).'>Rabu</option>
			  <option value=3 '.getSelected(3,$value).'>Kamis</option>
			  <option value=4 '.getSelected(4,$value).'>Jumat</option>
			  <option value=5 '.getSelected(5,$value).'>Sabtu</option>
	       </select>';
}

function getMinggu($value="",$Compname=""){
  if (empty($Compname))
	$name ="cmbMinggu";
  else 
    $name =$Compname;
   $rs = '<select name="'.$name.'">';
         for($i=0; $i<52; $i++){
            $rs .= '<option value='.($i).' '.getSelected(($i),$value).'>Week_'.($i+1).'</option>';
		 }
   $rs .="</select>";   
   return $rs;
}

function getValueMinggu($value){
	return "Week_".($value+1);
}

function getBulan($value="",$Compname="",$withAll=false,$objectId=""){
  $tempBulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
  if (empty($Compname))
	$name ="cmbBulan";
  else 
    $name =$Compname;
   $rs = '<select name="'.$name.'" id="'.$name.$objectId.'">';
   if ($withAll){
		$rs .= '<option value="-1">Semua</option>';
   }
         for($i=0; $i<count($tempBulan); $i++){
            $rs .= '<option value='.($i+1).' '.$this->getSelected(($i),$value).'>'.$tempBulan[$i].'</option>';
		 }
   $rs .="</select>";   
   return $rs;
}

function getBulanValue($idx){
	$tempBulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	
	return $tempBulan[$idx];
}

function getListBulan($value,$name=null){
	if ($name == null)
		$tmp = "<select name='cmbBulan' id='cmbBulan'>";
	else
		$tmp = "<select name='$name' id='$name'>";
	$tmp.= "<option value='00' ".(($value=='00')?'selected':'').">-- Pilih Bulan --</option>";
	$tmp.= "<option value='01' ".(($value=='01')?'selected':'').">Januari</option>";
	$tmp.= "<option value='02' ".(($value=='02')?'selected':'').">Februari</option>";
	$tmp.= "<option value='03' ".(($value=='03')?'selected':'').">Maret</option>";
	$tmp.= "<option value='04' ".(($value=='04')?'selected':'').">April</option>";
	$tmp.= "<option value='05' ".(($value=='05')?'selected':'').">Mei</option>";
	$tmp.= "<option value='06' ".(($value=='06')?'selected':'').">Juni</option>";
	$tmp.= "<option value='07' ".(($value=='07')?'selected':'').">Juli</option>";
	$tmp.= "<option value='08' ".(($value=='08')?'selected':'').">Agustus</option>";
	$tmp.= "<option value='09' ".(($value=='09')?'selected':'').">September</option>";
	$tmp.= "<option value='10' ".(($value=='10')?'selected':'').">Oktober</option>";
	$tmp.= "<option value='11' ".(($value=='11')?'selected':'').">November</option>";
	$tmp.= "<option value='12' ".(($value=='12')?'selected':'').">Desember</option>";
	$tmp.= "</select>";
	return $tmp;
}


function chmod_R($path, $filemode) { 
    if (!is_dir($path))
       return chmod($path, $filemode);

    $dh = opendir($path);
    while ($file = readdir($dh)) {
        if($file != '.' && $file != '..') {
            $fullpath = $path.'/'.$file;
            if(!is_dir($fullpath)) {
              if (!chmod($fullpath, $filemode))
                 return FALSE;
            } else {
              if (!chmod_R($fullpath, $filemode))
                 return FALSE;
            }
        }
    }
 
    closedir($dh);
    
    if(chmod($path, $filemode))
      return TRUE;
    else 
      return FALSE;
} 


function getListCheckpoint($value,$name=null){
	if ($name == null)
		$tmp = "<select name='cmbPeriode' id='cmbPeriode'>";
	else
		$tmp = "<select name='$name' id='$name'>";
	//jadi 12 bulan per 2013.07.13
	$tmp.= "<option value='1' ".(($value=='1')?'selected':'').">B.01</option>";
	$tmp.= "<option value='2' ".(($value=='2')?'selected':'').">B.02</option>";
	$tmp.= "<option value='3' ".(($value=='3')?'selected':'').">B.03</option>";
	$tmp.= "<option value='4' ".(($value=='4')?'selected':'').">B.04</option>";
	$tmp.= "<option value='5' ".(($value=='5')?'selected':'').">B.05</option>";
	$tmp.= "<option value='6' ".(($value=='6')?'selected':'').">B.06</option>";
	$tmp.= "<option value='7' ".(($value=='7')?'selected':'').">B.07</option>";
	$tmp.= "<option value='8' ".(($value=='8')?'selected':'').">B.08</option>";
	$tmp.= "<option value='9' ".(($value=='9')?'selected':'').">B.09</option>";
	$tmp.= "<option value='10' ".(($value=='10')?'selected':'').">B.10</option>";
	$tmp.= "<option value='11' ".(($value=='11')?'selected':'').">B.11</option>";
	$tmp.= "<option value='12' ".(($value=='12')?'selected':'').">B.12</option>";
	
	$tmp.= "</select>";
	return $tmp;
}


function getTahun($value="",$Compname="",$forFilter=false){
  if (empty($Compname))
	$name ="cmbTahun";
  else 
    $name =$Compname;
   $rs = '<select name="'.$name.'">';
   	//	$rs .='<option value="empty">'.ifThen($forFilter,"All","Pilih Tahun").'</option>	';

         for($i=2008; $i<=2030; $i++){
			
            $rs .= '<option value='.($i).' '.getSelected(($i),$value).'>'.($i).'</option>';
		 }
   $rs .="</select>";   
   return $rs;
}

function getValueFromSQL($sql,$defValue=""){
	    global $dbi;
		//FORMAT SQL fieldname nya harus dilengkapi dengan alias 'rs'
		//var_dump( $sql);
		$que = $this->model->db->query($sql);
		$rs = $defValue;
		if($que->num_rows()>0){
		    $rs = ($que->row()->rs==null?$defValue:$que->row()->rs);
		}
		return $rs;
		/* $result = mssql_query($sql,$dbi);
	    $data=mssql_fetch_object($result);
		if($data)
		    return ($data->rs);
		else
			return ($defValue); */
	}
	


//SQL FORMAT UTILITY
	function formatSQLString($SQL) {return "'".$SQL."'";}
	function formatSQLLike($SQL) {return " like '%".$SQL."%'";}
	function formatSQLDate($Date) {return " cast('".$Date."' as datetime)";}
	
	function getSystemDate() {return date("Y-m-d");}
	function getFullSystemDate() {return date("Y-m-d H:i:s");}
	
	function ifThen($condition=false,$ifTrue,$ifFalse){
		if ($condition)
			return $ifTrue;
		else
			return $ifFalse;
	}
	
function   getSelected($value,$name){
	$rs = "";
	//echo "value = ".$value;
	//echo "name = ".$name;
	if ($this->setUpper(trim($value)) == $this->setUpper(trim($name)))
	  $rs = "selected";
	return ($rs);
	}
	
	function getAktif($value='1'){
	  $rs="";
	  if ($value==''){
		return 'Y';
	  }else {
		return 'N';
	  }
	}
	
	function getChecked($value, $value2){
   // echo $value." vs ".$value2;
	$rs="";
	if ($value == $value2){
  	$rs= "checked";
	}
	return $rs;
	}
	
	function getPostRadio($component){
		// echo $value." vs ".$value2;		
		$rs="";
		if (isset($_POST[$component]) && ($_POST[$component]=='D') ){
			$rs= "D";
		}else {
			$rs= "V";
		}
		return $rs;
	}		
	
	//mestinya dipindahin
	function getChecklist($aValue){
		if (empty($aValue) || ($aValue=='N')){
			return 'N';
		}else{
			return 'Y';
		}
	}
	
	function getPostChecked($component){
		// echo $value." vs ".$value2;		
		$rs="";
		if (isset($_POST[$component])){
			$rs= "Y";
		}else {
			$rs= "N";
		}
		return $rs;
	}		
	
   
   function setUpper($aValue){
		return strtoupper($aValue);	
   }
   
   //fungsi utk ngambil $_POST paramenter : nama componen, default falue
   function getPostParam($component,$default="",$uppercase=false)  {
     //var_dump($_POST["$component"]);	 	
	//TEU TULUS BIARIN AJA sEADANYA DIDATABASE
	if  (($uppercase) &&($_POST["$component"]!='empty')) {		
	 if (isset($_POST["$component"])){
	   $rs = $_POST["$component"];
	   if (($rs!=""))
		return (strtoupper($rs));
	   else
		return (strtoupper($default));
	 } 
	 else
	   return (strtoupper($default));	 
    }else{
	   if (isset($_POST["$component"])){
		$rs = $_POST["$component"];
	   if (($rs!=""))
		return ($rs);
	   else
		return ($default);
	 } 
	 else
	   return ($default);	 
	   	
	}
}
	
   
    //fungsi utk ngambil $_GET paramenter : nama componen, default falue
   function getParam($component,$default="")  {
     if (isset($_GET["$component"]))
	   return ($_GET["$component"]);
	 else
	   return ($default);
   } 
   
   //ambil bulan dari tanggal
   function getMonth($component,$default="") {
     if (isset($_POST["$component"])) {
	   return date('m',strtotime($_POST["$component"]));
	 }else {
	   return date('m',strtotime('now'));
	 }
   }
   
   //ambil tahun dari tanggal
   function getYear($component,$default="") {
     if (isset($_POST["$component"])) {
	   return date('Y',strtotime($_POST["$component"]));
	 }else {
	   return date('Y',strtotime('now'));
	 }
   }
   
    //ambil tanggal dari tanggal
   function getDay($component,$default="") {
     if (isset($_POST["$component"])) {
	   return date('d',strtotime($_POST["$component"]));
	 }else {
	   return date('d',strtotime('now'));
	 }
   }
   
  
  
   
   //format indonesian date dd MMMM yyyy
   function ourFormatDate($aValue){
	if (($aValue=="")||($aValue=="0000-00-00"))
		return "-";
	else
		return (strftime("%d %B %Y",strtotime($aValue)));
   }
   
   //format indonesian date dd MM yyyy
   public function ourFormatDate2($aValue,$aDefault=""){
	if ($aValue=="")
		return $aDefault;
	else
		return (strftime("%d-%m-%Y",strtotime($aValue)));
   }
   
   //fungsi ubah format tanggal untuk insert ke database
   public function ourFormatSQLDate($aValue){   
		if ($aValue!=""){
			$newYear = $this->ourEkstrakString($aValue,"-",0);
			$newMonth = $this->ourEkstrakString($aValue,"-",1);
			$newDate = $this->ourEkstrakString($aValue,"-",2);			
			return ($newDate."-".$newMonth."-".$newYear);
		}
		else
			return ("");
   }
   
    public function ourDeFormatSQLDate($aValue){
		if ($aValue!=""){
			$newYear = $this->ourEkstrakString($aValue,"-",2);
			$newMonth = $this->ourEkstrakString($aValue,"-",1);
			$newDate = $this->ourEkstrakString($aValue,"-",0);
			return ($newYear."-".$newMonth."-".$newDate);				
		}
		else
			return ("");
   }
   
   //format indonesian date  yyyy MM dd
   function ourFormatDate3($aValue,$aDefault=""){
	if (($aValue=="")||($aValue=="0000-00-00")){
		return $aDefault;
	}else		
		return (strftime("%d-%m-%Y",strtotime($aValue)));
   }
   
   function ourFormatNumber($aValue,$aPrecision=0){
		if ($aValue =="")
			return "0";
		else
			return (number_format($aValue,$aPrecision,",","."));
   }
   //nge reformat thousand sparator jadi normal kembali
   function ourDeFormatNumber($aValue){
	  $rs = str_replace(".","",$aValue);
	  //echo $rs;
	  return ($rs);
   }
   
   //nge reformat titik jadi hilang, koma jadi titik
   function ourDeFormatNumber2($aValue){
	  $rs = str_replace(".","",$aValue);
	  $rs = str_replace(",",".",$rs);
	  //echo $rs;
	  return ($rs);
   }
   
   //cek penulisan bilangan bukan decimal tanpa thousan saparator
   function isCorrectSQLNumeric($value){
	$rs = false;
	$pos =strpos($value,".");
	//if ((==true)||(strpos($value,",")==true))
	if ($pos==false)
		$rs=true;
	return ($rs);
   }
   
   //$minLength : panjang minimal karakter
   //$str          : string karakter
function ourIntToStrFixedLen($minLength,$str){
	$tmpStr = $str;
    for ($i = 1;$i <= ($minLength-strlen($str));$i++)
      $tmpStr= '0'.$tmpStr;
    return ($tmpStr);
 }
 
 function ourEkstrakString($input,$limiter,$count){
   /* I.S. : Input = string yang akan di-extract, Limiter = karakter yang
           dipakai sebagai tanda pemisah, Count = bagian ke berapa yang
           akan diambil, paling kiri adalah bagian ke-1
    F.S. : menghasilkan substring ke-Count dari Input dengan batas Limiter 
	*/
		$tmpString = "";
		$ctr = 0;
		$tmpInput = $input;
		
		do {
			$posisi = strpos($input,$limiter);
			//$posisi = strpos("32-45","-");
			if ($posisi==false)
				$posisi = strlen($input);
			$tmpString = substr($input,0,$posisi);
			$input = substr($input,$posisi+1,strlen($input)-1);
			$ctr++;
		}while ($ctr<=$count);
		
		
		return ($tmpString);
		//return (strpos($limiter,$input));
	
   }
 
//generate new number field
function ourGetNextIDNum($fieldName,$tblName,$condition,$prefix,$suffix,$minLength=5){
	global $dbi;
	
	$sql = "SELECT MAX($fieldName) as newNum FROM $tblName";
    $cond = '';
    if ($condition != "")
      $cond = $cond . " AND " . substr($condition,5,strlen($condition));
    if ($prefix != "")
      $cond = $cond . " AND " . $fieldName . " LIKE " . "'$prefix"."%"."$suffix'";
	if ($cond!= "")
		$sql .= " WHERE ".substr($cond,5,strlen($cond));
	
	$result =  $this->model->db->query($sql);
	
	if ($result->row()->newNum!=""){
		$code = $result->row()->newNum;
		$code = substr($code,strlen($prefix),strlen($code)-strlen($prefix));
		$codNum = $code;
		$codNum++;
		$rs = $prefix . $this->ourIntToStrFixedLen($minLength,$codNum);
	}
	else
		$rs = $prefix . $this->ourIntToStrFixedLen($minLength,1);
	return ($rs);
   
}

function ourAlert($msg){
	echo "<script language='javascript'>
		alert('$msg');
	</script>";
}


function ourConfirm($url){
	echo '<script type="text/javascript">
		//Boxy.confirm("Penyimpanan Berhasil. Input data lagi?", 
		var answer = confirm("Penyimpanan Berhasil. Input data lagi?")
			//function() { 
			if (answer)	location.href("'.$url.'");
			//}, 
		//{title: "Konfirmasi"});
	</script>';
}
function ourConfirm2($msg,$url){
	/*echo '<SCRIPT language="JavaScript">  
		var answer = confirm("'.$msg.'");
		if (answer)
		{';
			$rs =true;	
	echo '}else{';
	//$rs =false;*/
	//echo '<script type="text/javascript">
		//	function confirmdelete() { 
 //return confirm("'.$msg.'");   
//}';
	//echo '</SCRIPT>';
	echo '<script type="text/javascript">
			function performdelete(msg,DestURL) {
var ok = confirm(msg);
if (ok) {location.href = DestURL;}
return ok;
} </SCRIPT>';
	$rs = "onClick=\"javascript:return performdelete('$msg','$url');\"";
	
	return($rs);
}



function cekNumericFmt($val,$decimalDigit=null){
	if(is_numeric($val)){
		if(strpos($val, '.') || strpos($val, ',')){
			if($val<1){
			return  number_format($val, ($decimalDigit!=null?$decimalDigit:4), ',', '.');
			} else {
			return  number_format($val, ($decimalDigit!=null?$decimalDigit:2), ',', '.');
			}
		}else{
			return  number_format($val, ($decimalDigit!=null?$decimalDigit:0), ',', '.');
		}
	}else{
		return  $val;
	}
}

//==============================F U N G S I  - F U N G S I              D A T E        U T I L I T Y=========================================================

/*$tomorrow  = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
$lastmonth = mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"));
$nextyear  = mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1);
?>*/
function getYesterday(){
	$yesterday=date("d/m/Y", time()-86400);
	return ($yesterday);
}
//get range date
function createDateRangeArray($strDateFrom,$strDateTo) {
  // takes two dates formatted as YYYY-MM-DD and creates an
  // inclusive array of the dates between the from and to dates.

  // could test validity of dates here but I'm already doing
  // that in the main script

  $aryRange=array();

  $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2), substr($strDateFrom,8,2),substr($strDateFrom,0,4));
  $iDateTo=mktime(1,0,0,substr($strDateTo,5,2), substr($strDateTo,8,2),substr($strDateTo,0,4));

  if ($iDateTo>=$iDateFrom) {
    array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry

    while ($iDateFrom<$iDateTo) {
      $iDateFrom+=86400; // add 24 hours
      array_push($aryRange,date('Y-m-d',$iDateFrom));
    }
  }
  return $aryRange;
}

function createMonthRangeListArray($strDateFrom,$strDateTo) {
   $aryRange=array();
  //var_dump($strDateFrom);
  //var_dump($strDateTo);die;
  $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2), substr($strDateFrom,8,2),substr($strDateFrom,0,4));
  $iDateTo=mktime(1,0,0,substr($strDateTo,5,2), substr($strDateTo,8,2),substr($strDateTo,0,4));
  $counter  = 0;  
  if ($iDateTo>=$iDateFrom) {
	array_push($aryRange,date('Y-m',$iDateFrom)); // first entry
	
    while ($iDateFrom<$iDateTo) {
		$iDateFrom+=86400; // add 24 hours
	    //var_dump(array_search(date('Y-m',$iDateFrom),$aryRange));
		$tmp = array_search(date('Y-m',$iDateFrom),$aryRange);
		//if (array_search(date('Y-m',$iDateFrom),$aryRange)==0){		
			//var_dump(date('Y-m',$iDateFrom));
			//var_dump($tmp);die;
		if ($aryRange[$counter]!=date('Y-m',$iDateFrom)){		
			array_push($aryRange,date('Y-m',$iDateFrom));
			$counter++;
		}	
    }
  }
  return $aryRange;
}

//buat list month
function createMonthRangeArray($strDateFrom,$strDateTo) {
   $aryRange=array();

  $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2), substr($strDateFrom,8,2),substr($strDateFrom,0,4));
  $iDateTo=mktime(1,0,0,substr($strDateTo,5,2), substr($strDateTo,8,2),substr($strDateTo,0,4));
  $counter  = 1;  
  if ($iDateTo>=$iDateFrom) {
	$aryRange[date('Y-m',$iDateFrom)]=$counter; // first entry

    while ($iDateFrom<$iDateTo) {
      $iDateFrom+=86400; // add 24 hours
	   
	  if (!array_key_exists(date('Y-m',$iDateFrom),$aryRange)){
		$counter = 1;
		$aryRange[date('Y-m',$iDateFrom)]=$counter;
	}	
	  else {
		$counter++;
		$aryRange[date('Y-m',$iDateFrom)]=$counter;
	  }
    }
  }
  return $aryRange;
}

//check valid range date
function validRangeDate($strDateFrom,$strDateTo){
	//if ()
}

function getIntervalDate($tgl1,$tgl2){
	$tg1 = strtotime($tgl1);
	$tg2 = strtotime($tgl2);
	$result = ($tg1-$tg2)/86400;
	return ($result>7);
}

function date_in_range($periode_awal,$periode_akhir,$tanggal){
    //untuk mengecek apakah sebuah tanggal benar dalam range periode awa; dan periode akhir
	// format tanggal dan periode adala Y-m-d
//	var_dump('( $tanggal >= $periode_awal ) = '. $tanggal .'>=' . $periode_awal.' HASIL ='.( $tanggal >= $periode_awal ));
	//var_dump('( $tanggal <= $periode_akhir ) = '. $tanggal .'<=' . $periode_akhir.' HASIL ='.( $tanggal <= $periode_akhir ));
	$rs = ( ( $tanggal >= $periode_awal ) && ( $tanggal <= $periode_akhir ) );	
	return $rs;
}

function lastDaysOfMonth($periode){
	//untuk menghasilkan jumlah hari pada tahun dan bulan tertentu;
	// paramter Y-M-D
	$tahun =  $this->ourEkstrakString($periode,'-',0);
	$bulan=  $this->ourEkstrakString($periode,'-',1);
	//var_dump($bulan);
	//$dateAkhir =  date('Y-m-t',mktime(0,0,0,$bulan,1,$tahun));
//	$dateAkhir =  date('Y-m-d',mktime(0,0,0,$bulan,1,$tahun));
	$dateAkhir = date('Y-m-d',strtotime('-1 second',strtotime('+1 month',strtotime($bulan.'/01/'.$tahun.' 00:00:00'))));
	//var_dump($dateAkhir);
	 //$dateAkhir = date('Y-m-t');
	return $dateAkhir;
}

function day_between($datum1,$datum2)
{  //parameter terkirim harus 2007-12-01
    //var_dump($datum1);
	$datum1=strftime("%Y%m%d",strtotime($datum1));
	$datum2=strftime("%Y%m%d",strtotime($datum2));
  // var_dump($datum1);
  // /var_dump($datum2);
   //if $datum1 = 20071215 and $datum2 = 20081215
    //var_dump(is_numeric($datum1));
    if( is_numeric($datum1) && is_numeric($datum2) && strlen($datum1) == 8 && strlen($datum2) == 8 )
    {
        $dat  = ($datum1 < $datum2)? $datum1 : $datum2;
        $datv = ($datum1 < $datum2)? $datum2 : $datum1;
        $i    = 0;
        while( $dat < $datv)
        {
            $i++;
            switch(substr($dat,6,2))
            {
                case '28': $dat += (substr($dat,4,2) == 02 && substr($dat,0,4)%4 > 0 )? 73 : 1;
                    break;
                case '29': $dat += (substr($dat,4,2) == 02 && substr($dat,0,4)%4 == 0 )? 72 : 1;
                    break;
                case '30': $dat += (in_array( substr($dat,4,2), array(04,06,09,11)))? 71 : 1;
                    break;
                case '31': $dat += (substr($dat,4,2) == 12 )? 8870 : 70;
                    break;
                default:   $dat++;
                    break;
            }
        }
        return $i-1;
    }
    else
    {
        return false;
    }
}

/*$year = date("Y", $date);
$month = date("m", $date);
if( (isset($_GET['year'])) && (intval($_GET['year']) > 1582) )
{
    $year = intval($_GET['year']);
}
if( (isset($_GET['month'])) && (intval($_GET['month']) >= 1) && (intval($_GET['month']) <= 12) )
{
    $month = intval($_GET['month']);
}
$date = mktime(1, 1, 1, $month, date("d"), $year);

$first_day_of_month = strtotime("-" . (date("d", $date)-1) . " days", $date);
$last_day_of_month = strtotime("+" . (date("t", $first_day_of_month)-1) . " days", $first_day_of_month);

$first_week_no = date("W", $first_day_of_month);
$last_week_no = date("W", $last_day_of_month);

if($last_week_no < $first_week_no) $last_week_no=date("W", strtotime("-1 week",$last_week_no)) + 1;
$weeks_of_month = $last_week_no - $first_week_no + 1;*/

function firstDayOfMonth($dateTime){
	$dateTime = strftime("%Y-%m-%d",strtotime($dateTime));
	$year = strftime("%Y", strtotime($dateTime));
	$month = strftime("%m", strtotime($dateTime));
	//var_dump("<br>".$year);
	//var_dump($month);
	if( (isset($_GET['year'])) && (intval($_GET['year']) > 1582) ){
		$year = intval($_GET['year']);
	}
	if( (isset($_GET['month'])) && (intval($_GET['month']) >= 1) && (intval($_GET['month']) <= 12) ){
		$month = intval($_GET['month']);
	}
	$dateTime = mktime(1, 1, 1, $month, date("d"), $year);
	$first_day_of_month = strtotime("-" . (date("d", $dateTime)-1) . " days", $dateTime);
	return ($first_day_of_month);
//	$last_day_of_month = strtotime("+" . (date("t", $first_day_of_month)-1) . " days", $first_day_of_month);
}

function days_between($fyear, $fmonth, $fday, $tyear, $tmonth, $tday)
{
  return abs((mktime ( 0, 0, 0, $fmonth, $fday, $fyear) - mktime ( 0, 0, 0, $tmonth, $tday, $tyear))/(60*60*24));
}

function day_before($fyear, $fmonth, $fday)
{
  return date ("Y-m-d", mktime (0,0,0,$fmonth,$fday-1,$fyear));
}

function daybefore($j){
$day = date('d');
$month = date('m');
$year = date('Y');
for ($i=0; $i<$j; $i++) { 
if ($day==1) {
    if ($month == 1) {
        $day = 31;
        $month = 12;
        $year = $year - 1;
    } else {
        $month = $month - 1; 
        switch ($month) {
            case 01:
                $maxdays=31;
                break;
            case 02:
                $a = $year / 4;
                $b = ceil($a);
                if ($a==$b){                
                     $maxdays=29;
                } else {
                      $maxdays=28;
                }
                break;
            case 03:
                $maxdays=31;
                break;
            case 04:
                $maxdays=30;
                break;
            case 05:
                $maxdays=31;
                break;
            case 06:
                $maxdays=30;
                break;
            case 07:
                $maxdays=31;
                break;
            case 08:
                $maxdays=31;
                break;
            case 09:
                $maxdays=30;
                break;
            case 10:
                $maxdays=31;
                break;
            case 11:
                $maxdays=30;
                break;
            case 12:
                $maxdays=31;
                break;
        }
        $day = $maxdays;
        $year = $year;
    }
} else {
    $day = $day - 1;
    $month = $month;
    $year = $year;
}}
return "$year-$month-$day";
}

function dayAfter($j){
$day = date('d');
$month = date('m');
$year = date('Y');
for ($i=0; $i<$j; $i++) { 
if ($day==1) {
    if ($month == 1) {
        $day = 31;
        $month = 12;
        $year = $year + 1;
    } else {
        $month = $month + 1; 
        switch ($month) {
            case 01:
                $maxdays=31;
                break;
            case 02:
                $a = $year / 4;
                $b = ceil($a);
                if ($a==$b){                
                     $maxdays=29;
                } else {
                      $maxdays=28;
                }
                break;
            case 03:
                $maxdays=31;
                break;
            case 04:
                $maxdays=30;
                break;
            case 05:
                $maxdays=31;
                break;
            case 06:
                $maxdays=30;
                break;
            case 07:
                $maxdays=31;
                break;
            case 08:
                $maxdays=31;
                break;
            case 09:
                $maxdays=30;
                break;
            case 10:
                $maxdays=31;
                break;
            case 11:
                $maxdays=30;
                break;
            case 12:
                $maxdays=31;
                break;
        }
        $day = $maxdays;
        $year = $year;
    }
} else {
    $day = $day + 1;
    $month = $month;
    $year = $year;
}}
return "$year-$month-$day";
}


function day_before2($datetime){
	//parameter format  yyyy-mm-dd
	$fyear = $this->ourEkstrakString($datetime,"-",0);
	$fmonth = $this->ourEkstrakString($datetime,"-",1);
	$fday = $this->ourEkstrakString($datetime,"-",2);	
	return date ("Y-m-d", mktime (0,0,0,$fmonth,$fday-1,$fyear));
}

function next_day($fyear, $fmonth, $fday)
{
  return date ("Y-m-d", mktime (0,0,0,$fmonth,$fday+1,$fyear));
}

function weekday($fyear, $fmonth, $fday) //0 is monday
{
  return (((mktime ( 0, 0, 0, $fmonth, $fday, $fyear) - mktime ( 0, 0, 0, 7, 17, 2006))/(60*60*24))+700000) % 7;
}

function prior_monday($fyear, $fmonth, $fday)
{
  return date ("Y-m-d", mktime (0,0,0,$fmonth,$fday-weekday($fyear, $fmonth, $fday),$fyear)); 
}

  function getRangePeriode($filStartDate,$filEndDate,& $listDate, & $listMonth ){
		if (($filStartDate=="")&&($filEndDate=="")){
			$listDate = array();
			return 0;
		}
		else {
			//$filStartDate = $this->ourFormatSQLDate($filStartDate);
			//$filEndDate = $this->ourFormatSQLDate($filEndDate);	    
			$listDate = $this->createDateRangeArray($filStartDate,$filEndDate);
			$listMonth = $this->createMonthRangeArray($filStartDate,$filEndDate);		
			return count($listDate);		
		}
	}

//=============================E N D      F U N G S I  - F U N G S I              D A T E        U T I L I T Y=========================================================


 // BUAT convert URI
// convert an ascii string to its hex representation
   public static function AsciiToHex($ascii)
   {
      $hex = '';

      for($i = 0; $i < strlen($ascii); $i++)
         $hex .= str_pad(base_convert(ord($ascii[$i]), 10, 16), 2, '0', STR_PAD_LEFT);

      return $hex;
   }

   // convert a hex string to ascii, prepend with '0' if input is not an even number
   // of characters in length   
   public static function HexToAscii($hex)
   {
      $ascii = '';
   
      if (strlen($hex) % 2 == 1)
         $hex = '0'.$hex;
   
      for($i = 0; $i < strlen($hex); $i += 2)
         $ascii .= chr(base_convert(substr($hex, $i, 2), 16, 10));
   
      return $ascii;
   }
   
 
	
   
   
   
   
}
?>

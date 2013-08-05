<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Eye View Design CMS module Ajax Model
 *
 * PHP version 5
 *
 * @category  CodeIgniter
 * @package   Security
 * @author    In.Visi
 * @copyright 2009
 * @version   0.1
*/

class Sys_menu_model extends CI_Model 
{    var $shorcutList;
	 var $gotoMenuList;
	/**
	* constructor 
	*/
	public function __construct()
    {
        parent::__construct();
		//$this->CI =& get_instance();	
		$this->shortcutList = array();		
		
    }
	
	public function loadMenu($app_type,$imported=null,$cekPolicy=false){
		$sql = "select m.* from tbl_menu m where hide<>1 and menu_parent is null and app_types like '%$app_type%'"
		//.($menuparent==null?' where menu_parent is null ':' where menu_parent = '.$menuparent)
		.($imported==null?'  ':' and imported = '.$imported)
		.' order by menu_id ';
		$query = $this->db->query($sql);
		$result = array();
		foreach ($query->result() as $row){
			/* if ($cekPolicy){
				if (!$this->cekAkses("ADD;EDIT;VIEW;DELETE;PRINT;PROSES;EXCEl;",$row->menu_id,$this->session->userdata('group_id'),$this->session->userdata('level_id'))) {
					continue;
				}
			} */
			$policy ='';
			$node =array();
			$node['id'] = $row->menu_id;
			$node['text'] = $row->menu_name;
			$node['state'] = 'closed';//($row->menu_parent==null?'closed':'open');
			
			$node['children'] = $this->loadChild($row->menu_id,$app_type,$imported,$cekPolicy,$policy);
			if (($cekPolicy)&&($policy=="")) {
				$policy = $this->getAccessPolicy($row->menu_id,$this->session->userdata('group_id'),$this->session->userdata('level_id'));
				if ($policy=="")
					continue;
			}
			array_push($result,$node);
		}	
		//var_dump($result);die;
		return json_encode($result);
	}
	
	public function loadChild($menuparent,$app_type,$imported=null,$cekPolicy=false,& $policy){
		$sql = 'select m.* from tbl_menu m '
		.' where hide<>1 and menu_parent = '.$menuparent
		."  and app_types like '%$app_type%' "
		.($imported==null?'  ':' and imported = '.$imported)
		.' order by menu_id ';
		$query = $this->db->query($sql);
		$result = array();
		foreach ($query->result() as $row){
			$node =array();
			$node['id'] = $row->menu_id;
			$node['text'] = $row->menu_name;
			$attr = array();
			$attr['url'] = $row->url;
			//array_push($node,$attr);
			$node['attributes'] = $attr;
			//var_dump($policy."=".$row->menu_id.'='.$this->session->userdata('group_id'));
			
			$node['children'] = $this->loadChild($row->menu_id,$app_type,$imported,$cekPolicy,$policy);
			//$policy .= $this->getAccessPolicy($row->menu_id,$this->session->userdata('group_id'),$this->session->userdata('level_id'));
			if ($node['children']!=null) 
				$node['state'] = 'closed';
			else {
				if (($cekPolicy) ) {
					//if ($policy!="")
					$currentPolicy = $this->getAccessPolicy($row->menu_id,$this->session->userdata('group_id'),$this->session->userdata('level_id'));	
//				var_dump($currentPolicy."=".$row->menu_id.'='.$this->session->userdata('group_id'));
					$policy .= $currentPolicy;
					//else {
						if ($currentPolicy =='')
							continue;
					//}
				}
			}
			array_push($result,$node);
		}	
		return $result;
	}
	
	public function getAccessPolicy($menu_id,$group_id,$level_id){
		if ($level_id=="1") //superadmin
			return "ADD;VIEW;EDIT;DELETE;PRINT;EXCEL;IMPORT;PROSES;";
		else {
			$this->db->flush_cache();
			$this->db->select('policy');
			$this->db->where('menu_id',$menu_id);	
			$this->db->where('group_id',$group_id);				
			$this->db->where('level_id',$level_id);				
			
			$this->db->from('tbl_group_access');
			$result = $this->db->get();
		
			if(isset($result->row()->policy)){
				return $result->row()->policy;
			}else{
				return '';
			}
		}
	}
	
	public function cekAkses($policy,$menu_id,$group_id,$level_id){
		if ($level_id=="1") //superadmin
			return true;
		else {
			//var_dump($policy.'='.$menu_id.'='.$group_id.'='.$level_id);
			$this->db->where('menu_id',$menu_id);	
			$this->db->where('group_id',$group_id);				
			$this->db->where('level_id',$level_id);				
			$this->db->where("policy like '%$policy%'");				
			$this->db->from('tbl_group_access');
			//var_dump($this->db->where());
		//	var_dump($this->db->count_all_results());die;
			return ($this->db->count_all_results()>0);
		}
	}
	//buat data di grid
	public function getAll($parentId = null)
	{	$sql = "SELECT menu_id,menu_group,menu_name,ifnull(parent_menu_id,'') as parent_menu_id,url,has_child,url_help FROM sys_menu "; 
		$filter = "(hide=1 or hide is null)";
		//var_dump(!isset($parentId));
		if ($parentId!='')
			$filter .= " and parent_menu_id = ".$parentId;			
		else $filter .= " and parent_menu_id is null";				
		
		//}
		//var_dump($filter);die;	
		$sql .= " where ".$filter." order by  group_order,menu_order";
		//$this->db->select('menu_id,menu_group,menu_name,parent_menu_id,url');
		//$this->db->from('sys_menu');	
		//$this->db->where('hide',0);	
		//$this->db->orderby('menu_group,menu_id');	
		//$this->db->query($sql, array(3, 'live', 'Rick')); 

			$query = $this->db->query($sql);
		//	var_dump($sql);
			$rs = array();
			foreach ($query->result() as $row)
			{
			   //$rs[] = array(array("menu_id=>".$row->menu_id,"menu_group=>".$row->menu_group,"menu_name=>".$row->menu_name,"url=>".$row->url));
			   $rs[] = array($row->menu_id,$row->menu_group,$row->menu_name,$row->url,$row->parent_menu_id,$row->has_child,$row->url_help);
			}
			
		$query->free_result();
		return $rs;		
	}
	
	public function GetListDistinctGroupModule() {		
		$pdfdata = array();
		$query = $this->db->get('sys_menu');	
		$comma=DEFINE_COMMA;//",";//separate by commas
		$group_id = "-1".$comma;
		$group_name = "Semua".$comma;
		foreach ($query->result() as $row){	
			$group_id .= $row->menu_group.$comma;
			$group_name .= $row->menu_group.$comma;			
		}
		$group_id = substr($group_id,0,strlen($group_id)-2);
		$group_name = substr($group_name,0,strlen($group_name)-2);
		$arr_group_id=split($comma,$group_id);
		$arr_group=split($comma,$group_name);		
		$pdfdata=array_combine($arr_group_id,$arr_group);		
		$query->free_result();
		return $pdfdata;		
		
	}
	
	public function getAllAkses($group_id,$parentId = null)	{	
		$sql_old = "select * from (select m.*
				from sys_menu m inner join sys_group_access a on m.menu_id = a.menu_id
				where group_id = $group_id and (can_add = 1 or can_edit=1 or can_delete=1 or can_acc=1 or can_view=1)
				and (hide=0 or hide is null) and has_child= 0
				union all
				select * from sys_menu
				where menu_id in (select distinct m.parent_menu_id
				from sys_menu m inner join sys_group_access a on m.menu_id = a.menu_id
				where group_id = $group_id and (can_add = 1 or can_edit=1 or can_delete=1 or can_acc=1 or can_view=1)
				) and (hide=0 or hide is null) and has_child= 1
				union all
				select * from sys_menu
				where menu_id in (select parent_menu_id from sys_menu
				where menu_id in (select distinct m.parent_menu_id
				from sys_menu m inner join sys_group_access a on m.menu_id = a.menu_id
				where group_id = $group_id and (can_add = 1 or can_edit=1 or can_delete=1 or can_acc=1 or can_view=1)
				) and (hide=0 or hide is null) and has_child= 1) and parent_menu_id is null
				)t1 "; 
		//$filter = "(hide=1 or hide is null)";
		//var_dump(!isset($parentId));
		
		$sql = "select distinct * from (	
	select m.menu_id,menu_group,menu_name,parent_menu_id,case  when url_trans is null then url else url_trans end as url,hide,has_child,define_name,group_order,menu_order,shortcut,is_trans, 'ADD' as kategory,url_help
	from sys_menu m inner join sys_group_access a on m.menu_id = a.menu_id
	where group_id = $group_id and (can_add=1)
	and (hide=0 or hide is null) and has_child= 0 and is_trans = 1
	union 
	select m.menu_id,menu_group,menu_name,display_parent_id as parent_menu_id,url,hide,has_child,define_name,group_order,(menu_order+50) as menu_order,shortcut,is_trans, 'LIST' as kategory,url_help
	from sys_menu m inner join sys_group_access a on m.menu_id = a.menu_id
	where group_id = $group_id and (can_edit=1 or can_delete=1 or can_acc=1 or can_view=1)
	and (hide=0 or hide is null) and has_child= 0 and is_trans = 1
	union 
	select m.menu_id,menu_group,menu_name,parent_menu_id,url,hide,has_child,define_name,group_order,menu_order,shortcut,is_trans, 'LIST2' as kategory,url_help
	from sys_menu m inner join sys_group_access a on m.menu_id = a.menu_id
	where group_id = $group_id and (can_edit=1 or can_delete=1 or can_acc=1 or can_view=1)
	and (hide=0 or hide is null) and has_child= 0 and is_trans is null
	union 
	select menu_id,menu_group,menu_name,parent_menu_id,url,hide,has_child,define_name,group_order,menu_order,shortcut,is_trans,'SUBMENU' as kategory,url_help from sys_menu
	where menu_id in (select distinct m.parent_menu_id
	from sys_menu m inner join sys_group_access a on m.menu_id = a.menu_id
	where group_id = $group_id and (can_add = 1 or can_edit=1 or can_delete=1 or can_acc=1 or can_view=1)
	) and (hide=0 or hide is null) and has_child= 1
	union 
	select menu_id,menu_group,menu_name,parent_menu_id,url,hide,has_child,define_name,group_order,menu_order,shortcut,is_trans,'SUBMENU' as kategory,url_help from sys_menu
	where menu_id in (select distinct m.display_parent_id
	from sys_menu m inner join sys_group_access a on m.menu_id = a.menu_id
	where group_id = $group_id and (can_add = 1 or can_edit=1 or can_delete=1 or can_acc=1 or can_view=1)
	) and (hide=0 or hide is null) and has_child= 1
	union 
	select menu_id,menu_group,menu_name,parent_menu_id,url,hide,has_child,define_name,group_order,menu_order,shortcut,is_trans,'ROOT' as kategory,url_help from sys_menu
	where menu_id in (select parent_menu_id from sys_menu
	where menu_id in (select distinct m.parent_menu_id
	from sys_menu m inner join sys_group_access a on m.menu_id = a.menu_id
	where group_id = $group_id and (can_add = 1 or can_edit=1 or can_delete=1 or can_acc=1 or can_view=1)
	) and (hide=0 or hide is null) and has_child= 1) and parent_menu_id is null
)t1  ";
		$filter = "";
		if ($parentId!='')
			$filter .= " and parent_menu_id = ".$parentId;			
		else $filter .= " and parent_menu_id is null";				
		
		if ($filter !="")
		  $filter = " where ".substr($filter,5,strlen($filter));
		
	//	$sql .= $filter." order by  group_order,menu_order";
		$sql .= $filter."  order by group_order,menu_order, parent_menu_id,is_trans desc";
		
		//$sql =
			$query = $this->db->query($sql);
	
			$rs = array();
			foreach ($query->result() as $row)
			{
			   //$rs[] = array(array("menu_id=>".$row->menu_id,"menu_group=>".$row->menu_group,"menu_name=>".$row->menu_name,"url=>".$row->url));
			   $rs[] = array($row->menu_id,$row->menu_group,$row->menu_name,$row->url,$row->parent_menu_id,$row->has_child,$row->shortcut,$row->url_help);
			}
			
		$query->free_result();
		return $rs;		
	}
	
	
	function getShortCut(){
		$tmp = '';
		/*
		$tmp = '<script type="text/javascript">
		
				$(document).shortkeys({';
			$rs ="";	
             foreach ($this->shortcutList as $row){			
					if (($row["shortcut"]!= null)&&($row["shortcut"]!=""))
				
				   $rs .= "'".$row["shortcut"]."' :  function () { window.location =base_url+'".$row["url"]."'; },";
			}
			$rs = substr($rs,0,strlen($rs)-1);
				
			$tmp .= $rs.'});';
           
		$tmp .='</script>';
		
		// GAJADI 
		*/
		return $tmp;
	}
	
	
	function prepareMenuManual(){
		$rs = '';
		$rs .=  '<ul  style="width:100%;" id="udm" class="udm">';
		$menu_name = 'tes';
		$newmenu = $menu_name.'<img style="display: block; margin-top: 6px; clip: rect(0pt, 5px, 5px, 0px); visibility: visible;" src="'.base_url().'assets/images/arrowR.gif" title="" alt=".." class="udmA">';
			
			$rs .=  '<li><a href="'.base_url().$url.'" class="'.$class.'">'.$newmenu.'</a>';
			$rs .=  "</li>";
		$rs .=  '</ul>';
				
	}
	
	
	function prepareMenu($group_id,$parentId,$result="",$goto=""){	    
		$menu = $this->getAllAkses($group_id,$parentId);		
		$rs = $result;
		//if (!isset($goto)||($goto == '')) $this->gotoMenuList = '<ul id="categorymenu" class="mcdropdown_menu">';
		//else
			$this->gotoMenuList = $goto;
		if (count($menu)>0){
			if ($parentId ==""){
				//$rs .=  '<ul class="menu" id="menu">';
				//$rs .=  '<ul  id="nav">';
				$rs .=  '<ul  style="width:100%;" id="udm" class="udm">';
				
				$this->gotoMenuList .= '<ul id="categorymenu" class="mcdropdown_menu">';
			}
			else {
				$rs .=  '<ul>';
				$this->gotoMenuList .= '<ul>';
			}
		}
		
		foreach ($menu as $i=>$row){
			//echo "<ul>".$row->menu_name."<ul>";
			//var_dump($menu[$i]);
			//var_dump("<br>");
			list($menu_id,$menu_group,$menu_name,$url,$parent_menu_id,$has_child,$shortcut) = $menu[$i];
			$this->shortcutList[]= array("menu_id"=>$menu_id,"url"=>$url,'shortcut'=>$shortcut);
			//var_dump($menu_name);
			$class = "";
			
			
			if ($parent_menu_id == "") {
				$class = "";//"menulink";
			}	
			else{			
				if ($has_child ==1)
					$class = "";//"sub";
			}
			
			$newmenu = $menu_name;
			if (($parent_menu_id!="")&&($has_child==1))
				$newmenu = $menu_name.'<img style="display: block; margin-top: 6px; clip: rect(0pt, 5px, 5px, 0px); visibility: visible;" src="'.base_url().'assets/images/arrowR.gif" title="" alt=".." class="udmA">';
			
			$rs .=  '<li><a href="'.base_url().$url.'" class="'.$class.'">'.$newmenu.'</a>';
			//$this->gotoMenuList .=  '<li rel="'.$menu_id.'"><a href="'.basbase_url().$url.'" class="'.$class.'">'.$menu_name.'</a>';
			$this->gotoMenuList .=  '<li rel="'.$menu_id.'='.base_url().$url.'">'.$menu_name;
			
			
			//echo '<ul>';
			$rs = $this->prepareMenu($group_id,$menu_id,$rs,$this->gotoMenuList);
			
			if ($parent_menu_id == "") {
				$class = "menulink";
			}	
			else{
				//echo "<ul>";
				$class = "sub";
			}
			
			if ($parent_menu_id != "") {
				if ($has_child=1){
				//if ($has_child==0){
					$rs .=  "</li>";
					$this->gotoMenuList .=  "</li>";
				}
				else {
					$rs .=  "</li></ul>";				
					$this->gotoMenuList .=  "</li></ul>";				
				}
			}	
			else{
				$rs .=  '</li>';		
				$this->gotoMenuList .=  '</li>';		
			}
		
		}	
		
		if (count($menu)>0){
			$rs .=  '</ul>';
			$this->gotoMenuList .=  '</ul>';
		}
		
		
		return $rs;				
	}
	
	function prepareMenu2($parentId){
		$menu = $this->getAll($parentId);
		if (count($menu)>0){
			if ($parentId =="")
				echo '<ul class="menu" id="menu">';
			else echo '<ul>';
		}
		
		foreach ($menu as $i=>$row){
			//echo "<ul>".$row->menu_name."<ul>";
			//var_dump($menu[$i]);
			//var_dump("<br>");
			list($menu_id,$menu_group,$menu_name,$url,$parent_menu_id,$has_child) = $menu[$i];
			//var_dump($menu_name);
			$class = "";
			
			
			if ($parent_menu_id == "") {
				$class = "menulink";
			}	
			else{			
				if ($has_child ==1)
					$class = "sub";
			}
			
			echo '<li><a href="'.base_url().$url.'" class="'.$class.'">'.$menu_name.'</a>';
			
			//echo '<ul>';
			$this->prepareMenu2($menu_id);
			if ($parent_menu_id == "") {
				$class = "menulink";
			}	
			else{
				//echo "<ul>";
				$class = "sub";
			}
			
			if ($parent_menu_id != "") {
				if ($has_child=1)
					echo "</li>";
				else echo "</li></ul>";				
			}	
			else
				echo '</li>';		
		
		}	
		
		if (count($menu)>0){
			echo '</ul>';
		}
	}
	
	
	
	
	private function isCan($typeId,$menu_id,$group_id){
		switch ($typeId){
		default : $this->db->where('can_add',"1");	break;
		case "2" : $this->db->where('can_edit',"1");	break;
		case "3" : $this->db->where('can_delete',"1");	break;
		case "4" : $this->db->where('can_acc',"1");	break;
		case "5" : $this->db->where('can_view',"1");	break;
		case "6" : $this->db->where('can_print',"1");	break;
		}
		
		$this->db->where('menu_id',$menu_id);				
		$this->db->where('group_id',$group_id);						
		$this->db->from('sys_group_access');
		//var_dump($this->db->where());
	//	var_dump($this->db->count_all_results());die;
		return ($this->db->count_all_results()>0);
	}
	
	public function isCanAdd($menu_id,$group_id){
		return $this->isCan(1,$menu_id,$group_id);
	}
	public function isCanEdit($menu_id,$group_id){
		return $this->isCan(2,$menu_id,$group_id);
	}
	public function isCanDelete($menu_id,$group_id){
		return $this->isCan(3,$menu_id,$group_id);
	}
	public function isCanAcc($menu_id,$group_id){
		return $this->isCan(4,$menu_id,$group_id);
	}
	
	public function isCanView($menu_id,$group_id){
		return $this->isCan(5,$menu_id,$group_id);
	}
	
	public function isCanPrint($menu_id,$group_id){
		return $this->isCan(6,$menu_id,$group_id);
	}
	
	public function getAutoTab($group_id){
/*
		$this->db->select('*');
		$this->db->from('tbl_menu');
		$this->db->where_like('policy','%AUTOTAB;%',false);
*/
		$sql = "select tbl_menu.* from tbl_menu inner join tbl_group_access g on tbl_menu.menu_id = g.menu_id where g.policy like '%AUTOTAB;%'  and hide<>1 and group_id ='$group_id' ";//like '%$app_type%'  ";
		$query = $this->db->query($sql);
		$response = array();//stdClass();
/*
		$i=0;
		foreach ($query->result() as $row){
			$response[]=array($row->menu_name,$row->url);
			$i++;
		}
		$query->free_result();
*/
		return $query->result();
	}
	
}


?>

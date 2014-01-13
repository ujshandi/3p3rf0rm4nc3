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

class Group_access_model extends CI_Model 
{
	/**
	* constructor 
	*/
	public function __construct()
    {
        parent::__construct();
		//$this->CI =& get_instance();		
    }

	public function DeleteOnDb($id)	{	
		$this->db->where('group_id',$id);
		$result = $this->db->delete('sys_group_access');
		
		if($result) {
			return TRUE;
		}else {
			return FALSE;
		}
	}
	
	public function exist($menu_id,$group_id,$level_id){
		$this->db->where('menu_id',$menu_id);	
		$this->db->where('group_id',$group_id);				
		$this->db->where('level_id',$level_id);				
		$this->db->from('tbl_group_access');
		//var_dump($this->db->where());
	//	var_dump($this->db->count_all_results());die;
		return ($this->db->count_all_results()>0);
	}
	
	
		
	public function SaveToDb($data){
	   $this->db->trans_start(TRUE);
	   
	   $i=0;
	   $state = true;
	   //var_dump($data);die;
	   while($state && $i<$data['rowcount']){
	      //$tmp = $this->GetNoOrder()+1;
		  //$data['menu_id'] = $data['menu_id'][$i];
		  //$data['group_id'] = $data['group_id'][$i];
		  //var_dump($data['can_add']);die;
		  
		  //add here
		  $policy ="";
		  if($data['chkView'][$i] != null) $policy .= 'VIEW;';
		  if($data['chkAdd'][$i] != null) $policy .= 'ADD;';
		  if($data['chkEdit'][$i] != null) $policy .= 'EDIT;';
		  if($data['chkDelete'][$i] != null) $policy .= 'DELETE;';
		  if($data['chkPrint'][$i] != null) $policy .= 'PRINT;';
		  if($data['chkExcel'][$i] != null) $policy .= 'EXCEL;';
		  if($data['chkImport'][$i] != null) $policy .= 'IMPORT;';
		  if($data['chkProses'][$i] != null) $policy .= 'PROSES;';
		  if($data['chkCopy'][$i] != null) $policy .= 'COPY;';
		  if($data['chkAuto'][$i] != null) $policy .= 'AUTOTAB;';
		  
		  $this->db->set('policy',$policy);		  
		  		  
		  
		  if (!$this->exist($data['menu_id'][$i],$data['group_id'],$data['level_id'])) {
			$this->db->set('menu_id',$data['menu_id'][$i]);		  
		    $this->db->set('group_id',$data['group_id']);
		    $this->db->set('level_id',$data['level_id']);
			$this->db->insert('tbl_group_access');
			// var_dump("here inert");
		 }	
		  else{
			$this->db->where('menu_id',$data['menu_id'][$i]);	
			$this->db->where('group_id',$data['group_id']);				
			$this->db->where('level_id',$data['level_id']);				
			$this->db->update('tbl_group_access');
			//var_dump("update ");die;
		  }		  
		  $i++;
	   }
	   //die;	   
	   $this->db->trans_complete();
	   if ($this->db->trans_status() === FALSE){
			return false;
		}else {
			return true;
	   }
	}
	
	
	
	public function getData($level_id,$group_id,$objectId){
		
				
		/*is_can(1,$group_id,m.menu_id) as can_add, is_can(2,$group_id,m.menu_id) as can_edit,is_can(3,$group_id,m.menu_id) as can_delete,is_can(4,$group_id,m.menu_id) as can_acc , is_can(5,$group_id,m.menu_id) as can_view, is_can(6,$group_id,m.menu_id) as can_print, is_can(7,$group_id,m.menu_id) as can_not_acc
		and parent_menu_id is not null and has_child = 0 ".($menugroup!=-1?" and menu_group = '$menugroup'":"").
		*/		
		$sql = "select m.menu_group,m.menu_id,m.menu_name, m.policy, m.url, g.policy as group_policy, m.menu_parent from tbl_menu m left join tbl_group_access g on g.menu_id = m.menu_id and g.level_id = '$level_id' and g.group_id = '$group_id'   where (hide=0 or hide is null)  order by m.menu_id ";
		//
		//left join tbl_group_user gu on gu.group_id = g.group_id
				
		
		$query = $this->db->query($sql);		
		$rs = $query->result();		
	//<div class="fitem">				
				
		$tmp ='<table id="tbl'.$objectId.'" width="100%">
								
				<!-- <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CBC7B8">-->
				<tr align="center">
				  <td bgcolor="#F4F4F4" width="10px">&nbsp;No&nbsp;
					<input type="hidden" name="rowcount" value="'.$query->num_rows().'">
					<input type="hidden" name="level_id" value="'.$level_id.'">
					<input type="hidden" name="group_id" value="'.$group_id.'">
				  </td>			  
				  <td bgcolor="#F4F4F4" width="300px">&nbsp;Menu&nbsp;</td>
				  <td bgcolor="#F4F4F4" >&nbsp;View&nbsp;</td>
				  <td bgcolor="#F4F4F4" >&nbsp;Tambah&nbsp;</td>
				  <td bgcolor="#F4F4F4" >&nbsp;Edit&nbsp;</td>
				  <td bgcolor="#F4F4F4" >&nbsp;Hapus&nbsp;</td>
				  <td bgcolor="#F4F4F4" >&nbsp;Print&nbsp;</td>
				  <td bgcolor="#F4F4F4" >&nbsp;Excel&nbsp;</td>
				  <td bgcolor="#F4F4F4" >&nbsp;Import&nbsp;</td>
				  <td bgcolor="#F4F4F4" >&nbsp;Proses&nbsp;</td>	
				  <td bgcolor="#F4F4F4" >&nbsp;Copy&nbsp;</td>	
				  <td bgcolor="#F4F4F4" width="10px">&nbsp;Auto Tab&nbsp;</td>		
				</tr>';
		//chan
		$i=1; $no=1;
		if ($query->num_rows()==0){
				$tmp .= '<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>			
				  <td>&nbsp;</td>			
				  <td>&nbsp;</td>			
				</tr>';
		}else {
			foreach($query->result() as $r){
		//	var_dump(strpos(strtolower($r->policy),'add;'));
				if (($r->menu_parent != "") && ($r->url=="#")) continue;
				$tmp .= '<tr> ';
				if ($r->url=='#'){
					$no=1;
					$tmp .= '<td>&nbsp;<input type="hidden" name="menu_id'.$i.'" value="'.$r->menu_id.'"></td>';
				}
				else {
					$tmp .= '<td>'.$no++.'&nbsp;<input type="hidden" name="menu_id'.$i.'" value="'.$r->menu_id.'"></td>';
				}
				
				if (($r->url!='#')&&($r->url!=null))
					$tmp .= '<td>&nbsp;&nbsp;&nbsp;'.$r->menu_name.'&nbsp;</td>';
				else
					$tmp .= '<td><b>'.$r->menu_name.'</b>&nbsp;</td>';
				 
				if ($r->url=='#'){
					$tmpxx = '<td align="center"><input type="checkbox" id="chkView'.$r->menu_group.'" onclick="selectModul(\'View\',\''.$r->menu_group.'\')" name="chkView'.$i.'">&nbsp;</td>				  
					  <td align="center"><input type="checkbox" id="chkAdd'.$r->menu_group.'" name="chkAdd'.$i.'">&nbsp;</td>				  
					  <td align="center"><input type="checkbox" id="chkEdit'.$r->menu_group.'" name="chkEdit'.$i.'">&nbsp;</td>				  
					  <td align="center"><input type="checkbox" id="chkDelete'.$r->menu_group.'" name="chkDelete'.$i.'">&nbsp;</td>				  
					  <td align="center"><input type="checkbox" id="chkPrint'.$r->menu_group.'" name="chkPrint'.$i.'" >&nbsp;</td>				  
					  <td align="center"><input type="checkbox" id="chkExcel'.$r->menu_group.'" name="chkExcel'.$i.'" >&nbsp;</td>				  
					  <td align="center"><input type="checkbox" id="chkImport'.$r->menu_group.'" name="chkImport'.$i.'" >&nbsp;</td>				  
					  <td align="center"><input type="checkbox" id="chkProses'.$r->menu_group.'" name="chkProses'.$i.'">&nbsp;</td>				  
					  <td align="center"><input type="checkbox" id="chkCopy'.$r->menu_group.'" name="chkCopy'.$i.'">&nbsp;</td>';				  
				}
				else {
				  $tmp .= '<td align="center">'.(strpos($r->policy,'VIEW;')=== false?'':'<input type="checkbox" id="chkView'.$r->menu_group.$i.'" name="chkView'.$i.'" '.(strpos($r->group_policy,'VIEW;')=== false?'':'checked="checked"').'>').'&nbsp;</td>				  
				  <td align="center">'.((strpos($r->policy,'ADD;')===false)?'':'<input type="checkbox" id="chkAdd'.$r->menu_group.$i.'" name="chkAdd'.$i.'"  '.(strpos($r->group_policy,'ADD;')=== false?'':'checked="checked"').'>').'&nbsp;</td>				  
				  <td align="center">'.(strpos($r->policy,'EDIT;')===false?'':'<input type="checkbox" id="chkEdit'.$r->menu_group.$i.'" name="chkEdit'.$i.'" '.(strpos($r->group_policy,'EDIT;')=== false?'':'checked="checked"').'>').'&nbsp;</td>				  
				  <td align="center">'.(strpos($r->policy,'DELETE;')===false?'':'<input type="checkbox" id="chkDelete'.$r->menu_group.$i.'" name="chkDelete'.$i.'" '.(strpos($r->group_policy,'DELETE;')=== false?'':'checked="checked"').'>').'&nbsp;</td>				  
				  <td align="center">'.(strpos($r->policy,'PRINT;')===false?'':'<input type="checkbox" id="chkPrint'.$r->menu_group.$i.'" name="chkPrint'.$i.'" '.(strpos($r->group_policy,'PRINT;')=== false?'':'checked="checked"').'>').'&nbsp;</td>				  
				  <td align="center">'.(strpos($r->policy,'EXCEL;')===false?'':'<input type="checkbox" id="chkExcel'.$r->menu_group.$i.'" name="chkExcel'.$i.'" '.(strpos($r->group_policy,'EXCEL;')=== false?'':'checked="checked"').'>').'&nbsp;</td>				  
				  <td align="center">'.(strpos($r->policy,'IMPORT;')===false?'':'<input type="checkbox" id="chkImport'.$r->menu_group.$i.'" name="chkImport'.$i.'" '.(strpos($r->group_policy,'IMPORT;')=== false?'':'checked="checked"').'>').'&nbsp;</td>				  
				  <td align="center">'.(strpos($r->policy,'PROSES;')===false?'':'<input type="checkbox" id="chkProses'.$r->menu_group.$i.'" name="chkProses'.$i.'"'.(strpos($r->group_policy,'PROSES;')=== false?'':'checked="checked"').'>').'&nbsp;</td>				  
				  <td align="center">'.(strpos($r->policy,'COPY;')===false?'':'<input type="checkbox" id="chkCopy'.$r->menu_group.$i.'" name="chkCopy'.$i.'"'.(strpos($r->group_policy,'COPY;')=== false?'':'checked="checked"').'>').'&nbsp;</td>				  
				  <td align="center">'.(strpos($r->policy,'AUTOTAB;')===false?'':'<input type="checkbox" id="chkAuto'.$r->menu_group.$i.'" class="chkAutoTab" name="chkAuto'.$i.'"'.(strpos($r->group_policy,'AUTOTAB;')=== false?'':'checked="checked"').'>').'&nbsp;</td>';				  
				}
				$tmp .= '</tr>';
				$i++;
			}		
		}		
		$tmp .='</table>
			</div>  ';
				$query->free_result();
		return $tmp;
	}
	
	
	
}

?>

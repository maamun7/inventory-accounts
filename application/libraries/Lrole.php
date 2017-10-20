<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lrole {
	public function generate_role_list()
	{
		$CI =& get_instance();
		$CI->load->model('roles');
		$role_list = $CI->roles->get_role_list();		
		$i=0;
		if(!empty($role_list)){		
			foreach($role_list as $k=>$v){$i++;
			   $role_list[$k]['sl']=$i;
			}
		}
		$data = array(
				'title' => 'Role List',
				'role_lists' => $role_list
			);
		$list_view = $CI->parser->parse('roles/index',$data,true);
		return $list_view;
	}
		
	public function new_role()
	{
		$CI =& get_instance();
		$CI->load->model('roles');
		
		$data = array(
				'title' 		=> 'Add Role',
				'permissions'	=> $this->all_permission()
			);
		$roleForm = $CI->parser->parse('roles/add',$data,true);
		return $roleForm;
	}
		
	public function role_edit_form($role_id)
	{
		$CI =& get_instance();
		$CI->load->model('roles');
		$role = $CI->roles->get_role_edit_data($role_id);
		if(!empty($role)){
			$data['role_id'] = $role[0]['role_id'];
			$data['role'] = $role[0]['role'];
		}
		$data['title']='Edit Role';
		$roleEditForm = $CI->parser->parse('roles/edit',$data,true);
		return $roleEditForm;
	} 
	
	private function all_permission()
    {
        $CI =& get_instance();
        $CI->load->model('roles');
        $group = $CI->roles->get_all_group();
        $i = -1;
            $custom = array();
            foreach($group as $k => $v){
                $permision = $CI->roles->get_by_group_id($v['group_id']);
               // echo count($permision).',_';
                if(count($permision)> 0){$i++;
                    $custom[$k]['permisions']=$permision;
                    $custom[$k]['group']=$v['group'];
                    $custom[$k]['group_id']=$v['group_id'];
                }

            }
      $permissions = $CI->parser->parse('roles/all_permissions', array('groups'=>$custom), TRUE);
      return $permissions;
    } 
	
	public function permission_form($role_id)
	{
		$CI =& get_instance();
        $CI->load->model('roles');
        $data = $this->get_permissions($role_id); //print_r($data); exit;	
        $role = $CI->roles->get_by_role_id($role_id);
        $cdata = array('groups'=>$data,'role_name'=>$role[0]['role'],'role_id'=>$role_id);
        $content = $CI->parser->parse('roles/permission', $cdata, TRUE);
        return $content;
	}
	
	public function get_permissions($role_id)
	{
        $CI =& get_instance();
		$CI->load->model('roles');
        $res = $CI->roles->get_permission_by_role_id($role_id);
        $per = explode(',',trim($res[0]['permission'],','));
        $group = $CI->roles->get_all_group();
      
      //  $data = $this->get_all();
        $i = -1;
        $custom = array();
        foreach($group as $k => $v){ 
            $permision = $CI->roles->get_by_group_id($v['group_id']);
           // echo count($permision).',_';
            if(count($permision)> 0){$i++;
                foreach($permision as $j=>$perm){
                    if(in_array($perm['permission_alias'],$per)){ $permision[$j]['is_checked'] = 'checked="checked"';}else{$permision[$j]['is_checked'] = '';}
                }
                $custom[$k]['permisions']=$permision;
                $custom[$k]['group']=$v['group'];
                $custom[$k]['group_id']=$v['group_id'];
            }
        }
        return $custom;
	}
}
?>
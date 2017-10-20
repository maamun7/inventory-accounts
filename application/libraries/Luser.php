<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Luser {
	
	public function generate_list($limit,$page,$links)
	{
		$CI =& get_instance();
		$CI->load->model('users');
		$list = $CI->users->get_user_list($limit,$page);		
		$i=$page;
		if(!empty($list)){		
			foreach($list as $k=>$v){$i++;
			   $list[$k]['sl']=$i;
			   if($v['user_type']=='2'){
					$list[$k]['user_type']="System User";
			   }else if($v['user_type']=='1'){
					$list[$k]['user_type']="Register User";
			   }else if($v['user_type']=='0'){
					$list[$k]['user_type']="Admin";
			   }
			   
			   if($v['is_active']=='1'){
					$list[$k]['is_active']="Active";
			   }else{
					$list[$k]['is_active']="Inactive";
			   }
			   
			   if($v['can_login']=='1'){
					$list[$k]['can_login']="Yes";
			   }else{
					$list[$k]['can_login']="No";
			   }
			}
		}
		$data = array(
				'title' => 'User List',
				'lists' => $list,
				'links' => $links
			);
		$list_view = $CI->parser->parse('user/index',$data,true);
		return $list_view;
	}
	
	public function new_user()
	{
		$CI =& get_instance();
		$CI->load->model('users');
		$data = array(
				'title' => 'Add User',
				'roles' => $CI->users->get_role_list()
			);
		$productForm = $CI->parser->parse('user/add',$data,true);
		return $productForm;
	}
	
	public function get_edit_data($user_id)
	{
		$CI =& get_instance();
		$CI->load->model('users');
		$edit_data = $CI->users->retrieve_edit_data($user_id);
		$data = array();
		if(!empty($edit_data)){
		$role = $CI->users->get_role_list();
		if(!empty($role)){
			foreach($role as $k=>$v){
				if($v['role_id'] == $edit_data[0]['role_id']){
					$role[$k]['selected'] = "selected='selected'";
				}else{
					$role[$k]['selected'] = "";
				}
			}
		}
		
		$data = array(
				'user_id' 		=> $edit_data[0]['user_id'],
				'user_type' 	=> $edit_data[0]['user_type'],
				'first_name' 	=> $edit_data[0]['first_name'],
				'last_name' 	=> $edit_data[0]['last_name'],
				'designition' 	=> $edit_data[0]['designition'],
				'address'		=> $edit_data[0]['address'],
				'email' 		=> $edit_data[0]['username'],
				'is_active' 	=> $edit_data[0]['is_active'],
				'can_login' 	=> $edit_data[0]['can_login'],
				'roles' 		=> $role
			);	
		}
		$profile_data = $CI->parser->parse('user/edit',$data,true);
		return $profile_data;
	}
	
	public function edit_profile_form()
	{
		$CI =& get_instance();
		$CI->load->model('users');
		$edit_data = $CI->users->profile_edit_data();	
		$data = array(
				'first_name' => $edit_data[0]['first_name'],
				'last_name' => $edit_data[0]['last_name'],
				'user_name' => $edit_data[0]['username']
			);	
		$profile_data = $CI->parser->parse('user/edit_profile',$data,true);
		return $profile_data;
	}
}
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Crole extends CI_Controller {
	
	function __construct() {
      parent::__construct();
	  
	  $this->template->current_menu = 'role';
    }
	public function index()
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('manage_role');	
		$CI->load->library('lrole');	
        $content = $CI->lrole->generate_role_list();
        $sub_menu = array(
				array('label'=> 'Manage User ', 'url' => 'cuser'),
				array('label'=> 'Add User', 'url' => 'cuser/add'),
				array('label'=> 'Manage Role ', 'url' => 'crole','class' =>'active'),
				array('label'=> 'Add Role ', 'url' => 'crole/add_role')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	
	public function add_role()
	{	
		$CI =& get_instance();
		$CI->auth->check_auth();
		$this->auth->check_permission('add_role');
		$CI->load->library('lrole');
		$CI->load->model('roles');
		
			$ar = array('role_name','permission_slug');
            $flag=true;
            foreach($ar as $v){
                if(!isset($_POST[$v])){$flag=false;}
            }			
            if($flag){
                $data=array('role'=> $this->input->post('role_name'),'status'=>1);
                $permission_slug = implode(',',$_POST['permission_slug']);
                $permission_slug = ','.$permission_slug.',';
                $role_id = $this->roles->insert_role($data);
                if($role_id){
                    $datas = array('role_id'=>$role_id ,'permission'=>$permission_slug);
                    $this->roles->insert_role_permission_relation($datas);
                    $this->session->set_userdata(array('message'=>'Role added successfully.'));
                    $this->index();
                    return;
                }
            }
		
		
		$content = $CI->lrole->new_role();
		$sub_menu = array(
				array('label'=> 'Manage User ', 'url' => 'cuser'),
				array('label'=> 'Add User', 'url' => 'cuser/add'),
				array('label'=> 'Manage Role ', 'url' => 'crole'),
				array('label'=> 'Add Role ', 'url' => 'crole/add_role','class' =>'active')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	public function edit_role($role_id=null){
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('edit_role');
		$this->load->library('lrole');
		$CI->load->model('roles');
		if(!$role_id){
			$this->session->set_userdata(array('message'=>"You didn't select role."));
			redirect(base_url('crole'));
		}
		$ar = array('role_name');
		$flag=true;
		foreach($ar as $v){
			if(!isset($_POST[$v])){$flag=false;}
		}
		if($flag){
			$data=array('role'=> $this->input->post('role_name'));
			if($this->roles->do_update($data,$role_id)){
				$this->session->set_userdata(array('message'=>'Role updated successfully.'));
				 $this->index();
				return;
			}
		}
		$content = $this->lrole->role_edit_form($role_id);
		$sub_menu = array(
				array('label'=> 'Manage User ', 'url' => 'cuser'),
				array('label'=> 'Add User', 'url' => 'cuser/add'),
				array('label'=> 'Manage Role ', 'url' => 'crole'),
				array('label'=> 'Add Role ', 'url' => 'crole/add_role'),
				array('label'=> 'Edit Role ', 'url' => 'crole/edit_role'.$role_id,'class' =>'active')
			);
	   
		$this->template->full_admin_html_view($content,$sub_menu);

	}
	
	public function permission($role_id){ 
		$CI =& get_instance();
        $this->auth->check_auth();
		$this->auth->check_permission('manage_permission');
		if(!$role_id){
			$this->session->set_userdata(array('message'=>"You didn't select role."));
			redirect(base_url('crole'));
		}
        $CI->load->library('lrole');
		$CI->load->model('roles');
        $flag=true;
        if (isset($_POST['permission_alias'])){
            $data = implode(',',$_POST['permission_alias']);
            $data = ','.$data.',';
        } else {
            $flag=false;
        }
		
        if ($flag){
            $data=array('permission'=> $data);
            if($this->roles->update_by_role_id($data,$role_id)){
                $this->session->set_userdata(array('message'=>'Permission updated successfully.'));
            }
        }

        $content = $this->lrole->permission_form($role_id);
		$sub_menu = array(
				array('label'=> 'Manage User ', 'url' => 'cuser'),
				array('label'=> 'Add User', 'url' => 'cuser/add'),
				array('label'=> 'Manage Role ', 'url' => 'crole'),
				array('label'=> 'Manage Permissions', 'url' => 'crole/permission/'.$role_id, 'class' => 'active'),
				array('label'=> 'Add Role ', 'url' => 'crole/add_role')
			);

        $this->template->full_admin_html_view($content,$sub_menu);
    }
}
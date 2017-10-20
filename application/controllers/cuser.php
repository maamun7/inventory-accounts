<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cuser extends CI_Controller {
	
	function __construct() {
      parent::__construct();
	  
	  $this->template->current_menu = 'user';
    }
	public function index()
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('manage_user');
		$CI->load->library('luser');
		$CI->load->model('users');
		
		$config = array();
		$config["base_url"] = base_url()."cuser/index";
		$config["total_rows"] = $this->users->count_user();	  
		$config["per_page"] = 50;
		$config["uri_segment"] = 3;	
		$config['full_tag_open'] = '<div id="pagination">';
		$config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$limit = $config["per_page"];
	    $links = $this->pagination->create_links();
		
        $content = $CI->luser->generate_list($limit,$page,$links);
        $sub_menu = array(
				array('label'=> 'Manage User ', 'url' => 'cuser','class' =>'active'),
				array('label'=> 'Add User', 'url' => 'cuser/add'),
				array('label'=> 'Manage Role ', 'url' => 'crole'),
				array('label'=> 'Add Role ', 'url' => 'crole/add_role')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	//user Add Form
	public function add()
	{	
		$CI =& get_instance();
		$CI->auth->check_auth();
		$this->auth->check_permission('add_user');
		$CI->load->library('luser');
		$content = $CI->luser->new_user();
		$sub_menu = array(
				array('label'=> 'Manage User ', 'url' => 'cuser'),
				array('label'=> 'Add User', 'url' => 'cuser/add','class' =>'active'),
				array('label'=> 'Manage Role ', 'url' => 'crole'),
				array('label'=> 'Add Role ', 'url' => 'crole/add_role')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	//Insert user and uload
	public function insert_user()
	{
		$CI =& get_instance();
		$CI->auth->check_auth();
		$this->auth->check_permission('add_user');
		$CI->load->model('users');
		$basic_data = array(
			'user_id' 		=> Null,
			'first_name' 	=> $this->input->post('first_name'),
			'last_name' 	=> $this->input->post('last_name'),
			'designition' 	=> $this->input->post('designation'),
			'address' 		=> $this->input->post('address'),
			'status' 		=> 1
		);
		$user_id = $CI->users->insert_basic_info($basic_data);
		$login_data = array(
			'user_id' 		=> $user_id,
			'username' 		=> $this->input->post('email'),
			'password' 		=> md5("matroak".$this->input->post('password')),
			'user_type' 	=> 2,
			'is_active' 	=> $this->input->post('is_active'),
			'can_login' 	=> $this->input->post('can_login')
		);
		$CI->users->insert_login_info($login_data);
		
		$role_relation = array(
			'id' 		=> null,
			'user_id' 	=> $user_id,
			'role_id' 	=> $this->input->post('role_id')
		);
		$CI->users->insert_user_role_relation($role_relation);
		
		$this->session->set_userdata(array('message'=>"New User Added Successfully!"));
		redirect(base_url('cuser'));
		exit;
	}
	//user Update Form
	public function edit($user_id = Null)
	{	
		$CI =& get_instance();
		$CI->auth->check_auth();
		$this->auth->check_permission('edit_user');
		$CI->load->library('luser');
		if(!$user_id){
			$this->session->set_userdata(array('message'=>"You didn't Select User !"));
			redirect(base_url('cuser'));
		}
		$content = $CI->luser->get_edit_data($user_id);
		$sub_menu = array(
				array('label'=> 'Manage User ', 'url' => 'cuser'),
				array('label'=> 'Add User', 'url' => 'cuser/add'),
				array('label'=> 'Edit User', 'url' => 'cuser/edit/'.$user_id,'class' =>'active'),
				array('label'=> 'Manage Role ', 'url' => 'crole'),
				array('label'=> 'Add Role ', 'url' => 'crole/add_role')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	// user Update
	public function user_update()
	{
		$CI =& get_instance();
		$CI->auth->check_auth();
		$this->auth->check_permission('edit_user');
		$CI->load->model('users');
		$user_id  = $this->input->post('user_id');
		$basic_data = array(
			'first_name' 	=> $this->input->post('first_name'),
			'last_name' 	=> $this->input->post('last_name'),
			'designition' 	=> $this->input->post('designation'),
			'address' 		=> $this->input->post('address'),
			'status' 		=> 1
		);
		$CI->users->update_basic_info($basic_data,$user_id);
		$login_data = array(
			'username' 		=> $this->input->post('email'),
			'password' 		=> md5("matroak".$this->input->post('password')),
			'user_type' 	=> 2,
			'is_active' 	=> $this->input->post('is_active'),
			'can_login' 	=> $this->input->post('can_login')
		);
		$CI->users->update_login_info($login_data,$user_id);
		
		$role_relation=array(
			'user_id' 	=> $user_id,
			'role_id' 	=> $this->input->post('role_id')
		);
		$CI->users->update_user_role_relation($role_relation,$user_id);
		$this->session->set_userdata(array('message'=>"User Successfully Edited!"));
		redirect(base_url('cuser'));
		exit;
	}
	// user_delete
	public function user_delete()
	{	
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->model('users');
		$user_id =  $_POST['user_id'];
		$CI->users->delete_user($user_id);
		return true;
			
	}
}
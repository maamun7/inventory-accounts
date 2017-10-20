<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cpermission extends CI_Controller {
	
	function __construct() {
      parent::__construct();
	  
	  $this->template->current_menu = 'role';
    }
	public function index()
	{	
		$CI =& get_instance();
		$CI->load->model('permissions');
		$this->auth->check_auth();
		
		$permission = $CI->permissions->get_permission_list();	
		$i=0;
		if(!empty($permission)){		
			foreach($permission as $k=>$v){$i++;
			   $permission[$k]['sl']=$i;
			}
		}
		$data = array(
				'title' => 'Permission List',
				'permissions' => $permission
			);
		$content = $CI->parser->parse('roles/permission_list',$data,true);
        $sub_menu = array(
				array('label'=> 'Manage Permission ', 'url' => 'cpermission','class' =>'active'),
				array('label'=> 'Add Permission', 'url' => 'cpermission/add')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	
	public function add()
	{	
		$CI =& get_instance();
		$CI->auth->check_auth();
		$CI->load->model('permissions');
		
		$ar = array('group_id','permission','permission_alias');
		$flag=true;
		foreach($ar as $v){
			if(!isset($_POST[$v])){$flag=false;}
		}			
		if($flag){
			$data = array(
					'permission'		=>$this->input->post('permission'),
					'permission_alias'	=>$this->input->post('permission_alias'),
					'created_on'		=>date('Y-m-d',time()),
					'group_id'			=>$this->input->post('group_id')
				);
			$this->permissions->insert_permission($data);
			$this->session->set_userdata(array('message'=>'Role added successfully.'));
			$this->index();
			return;	
		}
		$datas = array('groups'=>$CI->permissions->get_permission_group_list());
		$content = $CI->parser->parse('roles/add_permission',$datas,true);
		$sub_menu = array(
			array('label'=> 'Manage Permission ', 'url' => 'cpermission'),
			array('label'=> 'Add Permission', 'url' => 'cpermission/add','class' =>'active')
		);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
}
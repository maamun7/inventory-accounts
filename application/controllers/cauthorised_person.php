<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cauthorised_person extends CI_Controller {
	
	function __construct() {
      parent::__construct();
	  
	  $this->template->current_menu = 'authorised_person';
    }
	public function index()
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('manage_auth_person');
		$CI->load->library('lauthorised_person');
		$CI->load->model('authorised_persons');
        $content = $CI->lauthorised_person->auth_person_list();
        $sub_menu = array(
			array('label'=> 'Manage', 'url' => 'cauthorised_person','class' =>'active'),
			array('label'=> 'Add New', 'url' => 'cauthorised_person/add')
		);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	//Product Add Form
	public function add()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('add_auth_person');
		$CI->load->model('authorised_persons');
		$CI->load->library('lauthorised_person');
		$ar = array('name', 'designation','mobile_no', 'phone_no');
        $flag=true;
		foreach($ar as $v){
			if(!isset($_POST[$v])){
				$flag=false;
			}else{
			    $data[$v] = $this->input->post($v);
			    ${$v} = $this->input->post($v);
			}
		}		
		if($flag){
			$datas['id'] = Null;
			$datas['name'] = $name;
			$datas['designation'] = $designation;
			$datas['mobile_no'] = $mobile_no;
			$datas['phone_no'] = $phone_no;
			$datas['status'] = 1;
			$purchase_id = $this->authorised_persons->entry($datas);
				
			if(isset($_POST['add-auth_person'])){
				redirect(base_url('cauthorised_person'));
				exit;
			}elseif(isset($_POST['add-auth_person-another'])){
				redirect(base_url('cauthorised_person/add'));
				exit;
			}
		}			
		$content = $CI->lauthorised_person->add_form();
		$sub_menu = array(
			array('label'=> 'Manage', 'url' => 'cauthorised_person'),
			array('label'=> 'Add New', 'url' => 'cauthorised_person/add','class' =>'active')
		);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	
	//purchase Update Form
	public function edit($id = Null)
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('edit_auth_person');
		/* 		if(!$purchase_id){
			$this->session->set_userdata(array('message'=>"You didn't select purchase!"));
			redirect(base_url('cauthorised_person'));
		} */
		$CI->load->model('authorised_persons');
		$CI->load->library('lauthorised_person');
		$ar = array('authp_id','name', 'designation','mobile_no','phone_no');
        $flag=true;
		foreach($ar as $v){
			if(!isset($_POST[$v])){
				$flag=false;
			}else{
			    $data[$v] = $this->input->post($v);
			    ${$v} = $this->input->post($v);
			}
		}		
		if($flag){
			$datas['name'] = $name;
			$datas['designation'] = $designation;
			$datas['mobile_no'] = $mobile_no;
			$datas['phone_no'] = $phone_no;
			$this->authorised_persons->update($datas,$authp_id);			
			redirect(base_url('cauthorised_person'));
			exit;
		}		
		$content = $CI->lauthorised_person->edit_data($id);
		$sub_menu = array(
			array('label'=> 'Manage', 'url' => 'cauthorised_person'),
			array('label'=> 'Add New', 'url' => 'cauthorised_person/add'),
			array('label'=> 'Edit', 'url' => 'cauthorised_person/edit/'.$id,'class' =>'active')
		);
		$this->template->full_admin_html_view($content,$sub_menu);
	}

	public function do_delete()
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('delete_auth_person');
		$CI->load->model('authorised_persons');
		$authp_id =  $_POST['id'];
		$CI->authorised_persons->delete($authp_id);
		return true;
			
	}
}
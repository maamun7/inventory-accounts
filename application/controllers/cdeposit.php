<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cdeposit extends CI_Controller {
	
	function __construct() {
      parent::__construct();
	  
	  $this->template->current_menu = 'deposit';
    }
	public function index()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('manage_deposit');
		$CI->load->library('ldeposit');
		$CI->load->model('deposits');
		
		$config = array();
		$config["base_url"] = base_url()."cdeposit/Add_deposit";
		$config["total_rows"] = $this->deposits->count_deposit();	  
		$config["per_page"] = 15;
		$config["uri_segment"] = 3;	
		$config['full_tag_open'] = '<div id="pagination">';
		$config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$limit = $config["per_page"];
	    $links = $this->pagination->create_links();
		
        $content = $CI->ldeposit->deposit_list($limit,$page,$links);
        $sub_menu = array(
				array('label'=> 'Manage Deposit', 'url' => 'cdeposit','class' =>'active'),
				array('label'=> 'Add Deposit', 'url' => 'cdeposit/add_deposit')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	//deposit Add Form
	public function add_deposit()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('add_deposit');
		$CI->load->library('ldeposit');
		$content = $CI->ldeposit->deposit_add_form();
		$sub_menu = array(
				array('label'=> 'Manage Deposit', 'url' => 'cdeposit'),
				array('label'=> 'Add Deposit', 'url' => 'cdeposit/add_deposit','class' =>'active')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	//Insert deposit and uload
	public function insert_deposit()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('add_deposit');
		$CI->load->library('ldeposit');

		$data=array(
			'deposit_id' 	=> Null,
			'description' 	=> $this->input->post('description'),
			'amount' 		=> $this->input->post('amount'),
			'date' 			=> $this->input->post('deposit_date'),
			'status' 		=> 1
			);
		$CI->ldeposit->insert_deposit($data);
		$this->session->set_userdata(array('message'=>"Successfully Added !"));
		if(isset($_POST['add-deposit'])){
			redirect(base_url('cdeposit'));
			exit;
		}elseif(isset($_POST['add-deposit-another'])){
			redirect(base_url('cdeposit/add_deposit'));
			exit;
		}
	}
	//deposit Update Form
	public function deposit_update_form($deposit_id=null)
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('edit_deposit');
		if(!$deposit_id){
			$this->session->set_userdata(array('error_message'=>"You didn't select Deposit!"));
			redirect(base_url('cdeposit'));
		}
		$CI->load->library('ldeposit');
		$content = $CI->ldeposit->deposit_edit_data($deposit_id);
		$sub_menu = array(
				array('label'=> 'Manage Deposit', 'url' => 'cdeposit'),
				array('label'=> 'Add Deposit', 'url' => 'cdeposit/add_deposit'),
				array('label'=> 'Edit Deposit', 'url' => 'cdeposit/deposit_update_form/'.$deposit_id,'class' =>'active')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	// deposit Update
	public function deposit_update()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('edit_deposit');
		$CI->load->model('deposits');
		$deposit_id  = $this->input->post('deposit_id');
		$data=array(
			'description' 	=> $this->input->post('description'),
			'amount' 		=> $this->input->post('amount'),
			'date' 			=> $this->input->post('deposit_date'),
			'status' 		=> 1
			);
		$CI->deposits->update_deposit($data,$deposit_id);
		$this->session->set_userdata(array('message'=>"Successfully Updated !"));
		redirect(base_url('cdeposit'));
		exit;
	}	
}
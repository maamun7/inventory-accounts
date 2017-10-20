<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cbank extends CI_Controller {
	
	function __construct() {
      parent::__construct();
	  
	  $this->template->current_menu = 'bank';
    }
	
	public function index()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('manage_bank');
		$CI->load->library('lbank');
		
        $content = $CI->lbank->bank_list( );
        $sub_menu = array(
				array('label'=> 'All Bank', 'url' => 'cbank','class' =>'active'),
				array('label'=> 'New Bank ', 'url' => 'cbank/new_bank')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	
	public function new_bank()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('add_bank');
		$CI->load->library('Lbank');
		$data=array('title'=>"Add New Bank");
        $content = $CI->parser->parse('bank/new_bank',$data,true);
        $sub_menu = array(
				array('label'=> 'All Bank', 'url' => 'cbank'),
				array('label'=> 'New Bank ', 'url' => 'cbank/new_bank','class' =>'active')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}	
	
	public function add_new_bank()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('add_bank');
		$CI->load->model('banks');
		$data = array(
			'bank_id'		=>	null,
			'bank_name'		=>	$this->input->post('bank_name'),
			'status'		=>1
		
		);
		$invoice_id = $CI->banks->bank_entry( $data );
		$this->session->set_userdata(array('message'=>"Successfully Added Bank!"));
		redirect(base_url('cbank'));exit;
	}
	//This function is used to Generate Key
	public function generator($lenth)
	{
		$number=array("A","B","C","D","E","F","G","H","I","J","K","L","N","M","O","P","Q","R","S","U","V","T","W","X","Y","Z","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","1","2","3","4","5","6","7","8","9","0");
	
		for($i=0; $i<$lenth; $i++)
		{
			$rand_value=rand(0,61);
			$rand_number=$number["$rand_value"];
		
			if(empty($con))
			{ 
			$con=$rand_number;
			}
			else
			{
			$con="$con"."$rand_number";}
		}
		return $con;
	}	
}
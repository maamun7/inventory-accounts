<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cpurchase extends CI_Controller {
	
	function __construct() {
      parent::__construct();
	  
	  $this->template->current_menu = 'purchase';
    }
	public function index()
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('manage_purchase');
		$CI->load->library('lpurchase');
		$CI->load->model('purchases');
		
		$config = array();
		$config["base_url"] = base_url()."cpurchase/index";
		$config["total_rows"] = $this->purchases->count_purchase();	  
		$config["per_page"] = 20;
		$config["uri_segment"] = 3;	
		$config['full_tag_open'] = '<div id="pagination">';
		$config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$limit = $config["per_page"];
	    $links = $this->pagination->create_links();
		
        $content = $CI->lpurchase->purchase_list($limit,$page,$links);
        $sub_menu = array(
			array('label'=> 'Manage Purchase', 'url' => 'cpurchase','class' =>'active'),
			array('label'=> 'New Purchase', 'url' => 'cpurchase/add_purchase')
		);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	
	public function get_product_data()
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('add_purchase');
		$CI->load->model('purchases');
		$product_id =  $_POST['product_id'];
		$product_info = $CI->purchases->retrieve_product_data($product_id);
		echo json_encode($product_info);	
	}
	
	public function add_purchase()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('add_purchase');
		$CI->load->model('purchases');
		$CI->load->library('lpurchase');
		$ar = array('supplier_id', 'discount', 'adjustment','purchase_date', 'ship_to', 'terms_and_condi', 'job_description', 'authorised_by_id', 'requested_by_id', 'purchase_rate', 'product_id', 'product_quantity', 'total_price');
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
			$datas['chalan_no'] = $this->purchases->create_purchase_no($supplier_id);
			$datas['supplier_id'] = $supplier_id;
			list($day,$month,$year) = explode("/",$purchase_date);
			$purchase_date = $year."-".$month."-".$day;
			$datas['purchase_date'] = $purchase_date;
			$datas['discount'] = $discount;
			$datas['adjustment'] = $adjustment;
			$datas['ship_to'] = $ship_to;
			$datas['terms_and_condi'] = $terms_and_condi;
			$datas['job_description'] = $job_description;
			$datas['authorised_by_id'] = $authorised_by_id;
			$datas['requested_by_id'] = $requested_by_id;
			$datas['created_by_id'] = $this->auth->get_user_email_id();
			$purchase_id = $this->purchases->purchase_entry($datas);
			
			if($purchase_id > 0){
				foreach($product_id as $k=>$s){
					$another_flag = false;
					if($product_id[$k] !='' && $product_quantity[$k] !='' && $purchase_rate[$k]!='' && $total_price[$k]!=''){
						$another_flag=true;
					}
					if($another_flag){
						$data_item['purchase_detail_id'] = Null;
						$data_item['purchase_id'] = $purchase_id;
						$data_item['product_id'] = $product_id[$k];
						$data_item['quantity'] = $product_quantity[$k];
						$data_item['rate'] = $purchase_rate[$k];
						$data_item['total_amount'] = $total_price[$k];
						$data_item['status'] = 1;
						$this->purchases->purchase_details_entry($data_item);
					}
				}
				$this->session->set_userdata(array('message'=>"Successfully Added !"));
				if(isset($_POST['add-purchase'])){
					redirect(base_url('cpurchase/purchase_details_data/'.$purchase_id));
					exit;
				}elseif(isset($_POST['add-purchase-another'])){
					redirect(base_url('cpurchase/add_purchase'));
					exit;
				}
			}
		}			
		$content = $CI->lpurchase->purchase_add_form();
		$sub_menu = array(
			array('label'=> 'Manage Purchase', 'url' => 'cpurchase'),
			array('label'=> 'New Purchase', 'url' => 'cpurchase/add_purchase','class' =>'active')
		);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	
	//purchase Update Form
	public function edit_purchase($purchase_id = Null)
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('edit_purchase');
		/* 		if(!$purchase_id){
			$this->session->set_userdata(array('message'=>"You didn't select purchase!"));
			redirect(base_url('cpurchase'));
		} */
		$CI->load->model('purchases');
		$CI->load->library('lpurchase');
		$msg = "Warnings!!! You can edit your purchase but If you change supplier,product or product quantity,your Software may gives 'DEVIOUS' results.";
		$this->session->set_userdata(array('error_message'=>$msg));
		$ar = array('purchase_id','supplier_id', 'purchase_date', 'discount','adjustment', 'ship_to', 'terms_and_condi', 'job_description', 'authorised_by_id','requested_by_id', 'purchase_rate', 'purchase_detail_id', 'product_id', 'product_quantity', 'total_price');
        $flag=true;
		foreach($ar as $v){
			if(!isset($_POST[$v])){
				$flag=false;
				$d = $this->input->post($v);				
			}else{
			    $data[$v] = $this->input->post($v);
			    ${$v} = $this->input->post($v);
			}
		}		
		if($flag){
			$datas['supplier_id'] = $supplier_id;
			list($day,$month,$year) = explode("/",$purchase_date);
			$purchase_date = $year."-".$month."-".$day;
			$datas['purchase_date'] = $purchase_date;
			$datas['discount'] = $discount;
			$datas['adjustment'] = $adjustment;
			$datas['ship_to'] = $ship_to;
			$datas['terms_and_condi'] = $terms_and_condi;
			$datas['job_description'] = $job_description;
			$datas['authorised_by_id'] = $authorised_by_id;
			$datas['requested_by_id'] = $requested_by_id;
			$datas['edited_by_id'] = $this->auth->get_user_email_id();
			$datas['edited_on'] = date('Y-m-d');
			$this->purchases->purchase_update($datas,$purchase_id);
			
			foreach($product_id as $k=>$s){
				$another_flag = false;
				if($product_id[$k] !='' && $product_quantity[$k] !='' && $purchase_rate[$k]!='' && $total_price[$k]!=''){
					$another_flag=true;
				}
				if($another_flag){
					if(isset($purchase_detail_id[$k])){
						$data_item['product_id'] = $product_id[$k];
						$data_item['quantity'] = $product_quantity[$k];
						$data_item['rate'] = $purchase_rate[$k];
						$data_item['total_amount'] = $total_price[$k];
						$data_item['status'] = 1;
						$this->purchases->purchase_details_update($data_item,$purchase_detail_id[$k]);
					}else{
						$data_item['purchase_detail_id'] = Null;
						$data_item['purchase_id'] = $purchase_id;
						$data_item['product_id'] = $product_id[$k];
						$data_item['quantity'] = $product_quantity[$k];
						$data_item['rate'] = $purchase_rate[$k];
						$data_item['total_amount'] = $total_price[$k];
						$data_item['status'] = 1;
						$this->purchases->purchase_details_entry($data_item);
					}
				}
			}
			$this->session->set_userdata(array('message'=>"Successfully Updated !"));
			redirect(base_url('cpurchase/purchase_details_data/'.$purchase_id));
			exit;
		}
		$CI->load->library('lpurchase');
		$content = $CI->lpurchase->purchase_edit_data($purchase_id);
		$sub_menu = array(
				array('label'=> 'Manage Purchase', 'url' => 'cpurchase'),
				array('label'=> 'New Purchase', 'url' => 'cpurchase/add_purchase'),
				array('label'=> 'Edit Purchase', 'url' => 'cpurchase/edit_purchase/'.$purchase_id,'class' =>'active')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	
	// delete details single row
	public function delete_details_single_row()
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('edit_purchase');
		$CI->load->model('purchases');
		$detail_id =  $_POST['detail_id'];
		$this->purchases->delete_details_row($detail_id);
		return true;	
	}
	// product_delete
	public function purchase_delete()
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('delete_purchase');
		$CI->load->model('purchases');
		$purchase_id =  $_POST['purchase_id'];
		$CI->purchases->delete_purchase($purchase_id);
		return true;
			
	}
	
	//Retrive right now inserted data to cretae html
	public function purchase_details_data($purchase_id)
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('purchase_details');
		$CI->load->library('lpurchase');
		$content = $CI->lpurchase->purchase_details_data($purchase_id);		
		$sub_menu = array(
				array('label'=> 'Manage Purchase', 'url' => 'cpurchase'),
				array('label'=> 'New Purchase', 'url' => 'cpurchase/add_purchase'),
				array('label'=> 'PDF View', 'url' => 'cpurchase','class' =>'active')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	//Purchase Details
	public function create_purchase_pdf($purchase_id=Null)
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('print_purchase');
		if(!$purchase_id){
			$this->session->set_userdata(array('message'=>"You didn't select purchase!"));
			redirect(base_url('cpurchase'));
		}
		$CI->load->library('lpurchase');
		$CI->load->model('purchases');
		$this->load->helper(array('dompdf', 'file'));
		$this->load->helper('pdfexport_helper.php');
		
		//$urlid  = $this->uri->segment('3');
		$filename = $purchase_id;
		$filename = $this->purchases->get_purchase_no($purchase_id);
		$data['title'] = "Create Purchase";
		$data['final_view'] = $CI->lpurchase->pdf_purchase_details($purchase_id);
		$html  = $CI->parser->parse('purchase/final_purchase',$data,TRUE);		
		create_pdf_cv($html,$filename);  
       
	}
	
	public function search_by_supplier()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('manage_purchase');
		$CI->load->library('lpurchase');
		$supplier_id = $this->input->post('supplier_id');	
		if($supplier_id==""){
			$this->session->set_userdata(array('error_message'=>"You didn't select supplier!"));
			redirect(base_url('cpurchase'));
		} 
		$content = $CI->lpurchase->search_by_supplier($supplier_id);
		$sub_menu = array(
			  array('label'=> 'Manage Purchase', 'url' => 'cpurchase'),
			  array('label'=> 'New Purchase', 'url' => 'cpurchase/add_purchase'),
			  array('label'=> 'Search Report', 'url' => 'cpurchase','class' =>'active')
		);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	
	public function search_by_date()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('date_wise_report');
		$CI->load->library('lpurchase');
		$start_date = $this->input->post('from_date');		
		$end_date = $this->input->post('to_date');	
		if($start_date=="" || $end_date=="" ){
			$this->session->set_userdata(array('error_message'=>"Select from and to date!"));
			redirect(base_url('cpurchase'));
		} 
        $content = $CI->lpurchase->retrieve_date_wise_search_list($start_date,$end_date);
		$sub_menu = array(
			  array('label'=> 'Manage Purchase', 'url' => 'cpurchase'),
			  array('label'=> 'New Purchase', 'url' => 'cpurchase/add_purchase'),
			  array('label'=> 'Search Report', 'url' => 'cpurchase','class' =>'active')
		);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
}
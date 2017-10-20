<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cinvoice extends CI_Controller {
	
	function __construct() {
      parent::__construct();
	  
	  $this->template->current_menu = 'invoice';
    }
	public function index()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('manage_invoice');
		$CI->load->library('linvoice');
		$CI->load->model('invoices');		
		$config = array();
		$config["base_url"] = base_url()."cinvoice/index";
		$config["total_rows"] = $this->invoices->count_invoice();	  
		$config["per_page"] = 15;
		$config["uri_segment"] = 3;	
		$config['full_tag_open'] = '<div id="pagination">';
		$config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$limit = $config["per_page"];
	    $links = $this->pagination->create_links();
		
        $content = $CI->linvoice->invoice_list($limit,$page,$links);
        $sub_menu = array(
				array('label'=> 'Manage Invoice', 'url' => 'cinvoice','class' =>'active'),
				array('label'=> 'New Invoice', 'url' => 'cinvoice/add_invoice')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}

	public function add_invoice()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('add_invoice');
		$CI->load->model('invoices');
		$CI->load->library('linvoice');
		$ar = array('created_on', 'authorised_by_id', 'customer_id', 'terms_and_condi', 'discount', 'adjustment', 'product_id', 'rate', 'quantity', 'total_price');
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
			$datas['invoice_no'] = $this->invoices->create_invoice_no($customer_id);
			$datas['customer_id'] = $customer_id;
			list($day,$month,$year) = explode("/",$created_on);
			$created_date = $year."-".$month."-".$day;
			$datas['created_on'] = $created_date;
			$datas['authorised_by_id'] = $authorised_by_id;
			$datas['terms_and_condi'] = $terms_and_condi;
			$datas['discount'] = $discount;
			$datas['adjustment'] = $adjustment;
			$datas['created_by_id'] = $this->auth->get_user_email_id();
			$datas['status'] = 1;
			$invoice_id = $this->invoices->invoice_entry($datas);

			if($invoice_id > 0){
				//Insert Cutomer ledger table
				$ledger_data = array(
					'transaction_id'	=>	null,
					'customer_id'		=>	$customer_id,
					'invoice_no'		=>	$invoice_id,
					'date'				=>	$created_date,
					'status'			=>	1
				);
				$this->invoices->customer_ledger_entry($ledger_data);
				
				foreach($product_id as $k=>$s){
					$another_flag = false;
					if($product_id[$k] !='' && $quantity[$k] !='' && $rate[$k]!='' && $total_price[$k]!=''){
						$another_flag=true;
					}
					if($another_flag){
						$data_item['invoice_details_id'] = Null;
						$data_item['invoice_id'] = $invoice_id;
						$data_item['product_id'] = $product_id[$k];
						$data_item['quantity'] = $quantity[$k];
						$data_item['rate'] = $rate[$k];
						$data_item['total_price'] = $total_price[$k];
						$data_item['status'] = 1;
						$this->invoices->invoice_details_entry($data_item);
					}
					
					$exist = $this->invoices->cheeck_price_assign($product_id[$k],$customer_id);
					if($exist){
						$this->invoices->insert_price_assign($product_id[$k],$customer_id,$rate[$k]);
					}else{
						$this->invoices->update_price_assign($product_id[$k],$customer_id,$rate[$k]);
					}
				}				
				$this->session->set_userdata(array('message'=>"Successfully Added !"));
				if(isset($_POST['add-invoice'])){
					redirect(base_url('cinvoice/invoice_details/'.$invoice_id));
					exit;
				}elseif(isset($_POST['add-invoice-another'])){
					redirect(base_url('cinvoice/add_invoice'));
					exit;
				}
			}
		}			
		$content = $CI->linvoice->invoice_add_form();
		$sub_menu = array(
				array('label'=> 'Manage Invoice', 'url' => 'cinvoice'),
				array('label'=> 'New Invoice', 'url' => 'cinvoice/add_invoice','class' =>'active')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}

	public function edit_invoice($invoice_id = Null)
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('edit_invoice');
		/* 		if(!$invoice_id){
			$this->session->set_userdata(array('message'=>"You didn't select purchase!"));
			redirect(base_url('cpurchase'));
		} */
		$CI->load->model('invoices');
		$CI->load->library('linvoice');
		$msg = "Warnings!!! You can edit your invoice but If you change customer,product or product quantity,your Software may gives 'DEVIOUS' results.";
		$this->session->set_userdata(array('error_message'=>$msg));
		$ar = array('invoice_id', 'created_on', 'authorised_by_id', 'customer_id', 'terms_and_condi', 'product_id', 'discount', 'adjustment', 'invoice_details_id', 'rate', 'quantity', 'total_price');
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
			$datas['customer_id'] = $customer_id;
			list($day,$month,$year) = explode("/",$created_on);
			$created_date = $year."-".$month."-".$day;
			$datas['authorised_by_id'] = $authorised_by_id;
			$datas['terms_and_condi'] = $terms_and_condi;
			$datas['discount'] = $discount;
			$datas['adjustment'] = $adjustment;
			$datas['edited_by_id'] = $this->auth->get_user_email_id();
			$datas['edited_on'] = date('Y-m-d');
			$this->invoices->invoice_update($datas,$invoice_id);
			
			//Insert Cutomer ledger table
			$ledger_update_data = array(
				'customer_id'		=>	$customer_id,
				'invoice_no'		=>	$invoice_id,
				'date'				=>	$created_date
			);
			$this->invoices->customer_ledger_update($ledger_update_data,$invoice_id);

			foreach($product_id as $k=>$s){
				$another_flag = false;
				if($product_id[$k] !='' && $quantity[$k] !='' && $rate[$k]!='' && $total_price[$k]!=''){
					$another_flag=true;
				}
				if($another_flag){
					if(isset($invoice_details_id[$k])){
						$data_item['invoice_id'] = $invoice_id;
						$data_item['product_id'] = $product_id[$k];
						$data_item['quantity'] = $quantity[$k];
						$data_item['rate'] = $rate[$k];
						$data_item['total_price'] = $total_price[$k];
						$data_item['status'] = 1;
						$this->invoices->invoice_details_update($data_item,$invoice_details_id[$k]);
					}else{
						$data_item['invoice_details_id'] = Null;
						$data_item['invoice_id'] = $invoice_id;
						$data_item['product_id'] = $product_id[$k];
						$data_item['quantity'] = $quantity[$k];
						$data_item['rate'] = $rate[$k];
						$data_item['total_price'] = $total_price[$k];
						$data_item['status'] = 1;
						$this->invoices->invoice_details_entry($data_item);
					}
					$exist = $this->invoices->cheeck_price_assign($product_id[$k],$customer_id);
					if($exist){
						$this->invoices->insert_price_assign($product_id[$k],$customer_id,$rate[$k]);
					}else{
						$this->invoices->update_price_assign($product_id[$k],$customer_id,$rate[$k]);
					}
				}
			}
			
			$this->session->set_userdata(array('message'=>"Successfully Updated !"));
			redirect(base_url('cinvoice/invoice_details/'.$invoice_id));
			exit;
		}
		$content = $this->linvoice->invoice_edit_data($invoice_id);
		$sub_menu = array(
				array('label'=> 'Manage Invoice', 'url' => 'cinvoice'),
				array('label'=> 'New Invoice', 'url' => 'cinvoice/add_invoice'),
				array('label'=> 'Edit Invoice', 'url' => 'cinvoice/edit_invoice/'.$invoice_id,'class' =>'active')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}

	public function invoice_details($invoice_id=Null)
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('manage_invoice');
		$CI->load->library('linvoice');
		if(!$invoice_id){
			$this->session->set_userdata(array('error_message'=>"You didn't select Invoice!"));
			redirect(base_url('cinvoice'));
		}
		$content = $CI->linvoice->get_details_data($invoice_id);		
		$sub_menu = array(
				array('label'=> 'Manage Invoice', 'url' => 'cinvoice'),
				array('label'=> 'New Invoice', 'url' => 'cinvoice/add_invoice'),
				array('label'=> 'PDF View', 'url' => 'cinvoice','class' =>'active')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	
	public function invoice_single_row_delete()
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('edit_purchase');
		$CI->load->model('invoices');
		$detail_id =  $_POST['detail_id'];
		$this->invoices->do_delete_single_row($detail_id);
		return true;	
	}
	
	public function retrieve_product_data()
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$CI->load->model('invoices');
		$all_ids =  $_POST['all_ids'];		
		$product_info = $CI->invoices->retrieve_product_data($all_ids);
		echo json_encode($product_info);	
	}

	public function invoice_delete()
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('delete_invoice');
		$CI->load->model('invoices');
		$invoice_id =  $_POST['invoice_id'];
		$CI->invoices->delete_invoice($invoice_id);
		return true;	
	}

	public function create_invoice_pdf($invoice_no,$invoice_id=Null)
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		if(!$invoice_id){
			$this->session->set_userdata(array('error_message'=>"You didn't select Invoice!"));
			redirect(base_url('cinvoice'));
		}
		$this->auth->check_permission('manage_invoice');
		$CI->load->library('linvoice');
		$this->load->helper(array('dompdf','file'));
		$this->load->helper('pdfexport_helper.php');
		
		$urlid  = $this->uri->segment('3');
		
		$data['title'] = "Create Invoice";
		$filename = $invoice_no;
		$data['final_view'] = $CI->linvoice->invoice_pdf_data($invoice_id);
		$html  = $CI->parser->parse('invoice/final_invoice',$data,TRUE);		
		create_pdf_cv($html,$filename);  	
	}
	
	public function product_stock_check()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$CI->load->model('invoices');
		$product_id =  $_POST['product_id'];
		$purchase_stocks = $CI->invoices->get_total_purchase_item($product_id);
		$total_purchase = 0;		
		if(!empty($purchase_stocks)){	
			$total_purchase = $purchase_stocks[0]['total_quantity'];
		}		
		$sales_stocks = $CI->invoices->get_total_sales_item($product_id);
		$total_sales = 0;	
		if(!empty($sales_stocks)){	
			$total_sales = $sales_stocks[0]['total_s_quantity'];
		}
		
		$final_total = ($total_purchase - $total_sales);
		echo $final_total ;
	}
	
	public function search_by_customer()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('manage_purchase');
		$CI->load->library('linvoice');
		$customer_id = $this->input->post('customer_id');	
		if($customer_id==""){
			$this->session->set_userdata(array('error_message'=>"You didn't select Customer!"));
			redirect(base_url('cinvoice'));
		} 
		$content = $CI->linvoice->search_by_customer($customer_id);
		$sub_menu = array(
				array('label'=> 'Manage Invoice', 'url' => 'cinvoice'),
				array('label'=> 'New Invoice', 'url' => 'cinvoice/add_invoice'),
			  array('label'=> 'Search Report', 'url' => 'cinvoice','class' =>'active')
			);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	
	public function search_by_date()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('date_wise_report');
		$CI->load->library('linvoice');
		$start_date = $this->input->post('from_date');		
		$end_date = $this->input->post('to_date');	
		if($start_date=="" || $end_date=="" ){
			$this->session->set_userdata(array('error_message'=>"Select from and to date!"));
			redirect(base_url('cinvoice'));
		} 
        $content = $CI->linvoice->retrieve_date_wise_search_list($start_date,$end_date);
		$sub_menu = array(
			array('label'=> 'Manage Invoice', 'url' => 'cinvoice'),
			array('label'=> 'New Invoice', 'url' => 'cinvoice/add_invoice'),
			array('label'=> 'Search Report', 'url' => 'cinvoice','class' =>'active')
		);
		$this->template->full_admin_html_view($content,$sub_menu);
	}
	
	
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lcustomer {
	//Retrieve  Customer List	
	public function customer_list($limit,$page,$links)
	{
		$CI =& get_instance();
		$CI->load->model('customers');
		$customers_list = $CI->customers->customer_list($limit,$page);
		$i=$page;
		if(!empty($customers_list)){	
			foreach($customers_list as $k=>$v){$i++;
			   $customers_list[$k]['sl']=$i;
			}
		}
		$data = array(
				'title' => 'customers List',
				'customers_list' => $customers_list,
				'links' => $links
			);
		$customerList = $CI->parser->parse('customer/customer',$data,true);
		return $customerList;
	}
	//Retrieve  Customer Search List	
	public function customer_search_item($customer_id)
	{
		$CI =& get_instance();
		$CI->load->model('customers');
		$customers_list = $CI->customers->customer_search_item($customer_id);
		$i=0;
		foreach($customers_list as $k=>$v){$i++;
           $customers_list[$k]['sl']=$i;
		}
		$data = array(
				'title' => 'Customers Search Item',
				'customers_list' => $customers_list
			);
		$customerList = $CI->parser->parse('customer/customer',$data,true);
		return $customerList;
	}
	//Sub Category Add
	public function customer_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('customers');
		$data = array(
				'title' => 'Add customer'
			);
		$customerForm = $CI->parser->parse('customer/add_customer_form',$data,true);
		return $customerForm;
	}
	public function insert_customer($data)
	{
		$CI =& get_instance();
		$CI->load->model('customers');
        $CI->customers->customer_entry($data);
		return true;
	}
	//customer Edit Data
	public function customer_edit_data($customer_id)
	{
		$CI =& get_instance();
		$CI->load->model('customers');
		$customer_detail = $CI->customers->retrieve_customer_editdata($customer_id);
		$data=array(
			'customer_id' 	=> $customer_detail[0]['customer_id'],
			'customer_name' => $customer_detail[0]['customer_name'],
			'customer_address' 		=> $customer_detail[0]['customer_address'],
			'customer_mobile' 		=> $customer_detail[0]['customer_mobile'],
			'customer_email' 		=> $customer_detail[0]['customer_email'],
			'status' 		=> $customer_detail[0]['status']
			);
		$chapterList = $CI->parser->parse('customer/edit_customer_form',$data,true);
		return $chapterList;
	}
	//Customer ledger Data
	public function customer_ledger_data($customer_id)
	{
		$CI =& get_instance();
		$CI->load->model('customers');
		$CI->load->library('occational');
		$customer_detail = $CI->customers->customer_personal_data($customer_id);
		$invoice_info 	= $CI->customers->customer_invoice_data($customer_id);

		$invoice_amount = 0;
		if(!empty($invoice_info)){
			foreach($invoice_info as $k=>$v){
				$invoice_amount = round($invoice_amount+$invoice_info[$k]['total_price'],2);				
			    $invoice_info[$k]['final_date'] = date_numeric_format($invoice_info[$k]['created_on']);
			}
		}

		$invoice_data = array(
			'invoice_info' 	=> $invoice_info,
			'invoice_amount' => $invoice_amount,
		);		
		$invoice_content = $CI->parser->parse('customer/invoice_details',$invoice_data,true);
		
		
		
		$receipt_info 	= $CI->customers->customer_receipt_data($customer_id);
		$receipt_amount = 0;
		if(!empty($receipt_info)){
			foreach($receipt_info as $k=>$v){
				$receipt_info[$k]['final_date'] = $CI->occational->dateConvert($receipt_info[$k]['date']);
				$receipt_amount = $receipt_amount+$receipt_info[$k]['amount'];
			}
		}
		$receipt_data = array(
			'receipt_amount' 		=> $receipt_amount,
			'receipt_info' 			=> $receipt_info,
		);		
		$receipt_content = $CI->parser->parse('customer/report_details',$receipt_data,true);
		
		$color = "";
		$payment_status = "";
		$status_amount = $invoice_amount - $receipt_amount;
		if($status_amount > 0){
			$payment_status = "Due";
			$color = "FF0000";
		}else if($status_amount < 0){
			$payment_status = "Balance";
			$status_amount = substr($status_amount,1); 
			$color = "006600";
		}else{
			$status_amount = "";
			$payment_status = "Equal";
		}
		
		$data=array(
			'customer_id' 		=> $customer_detail[0]['customer_id'],
			'customer_name' 	=> $customer_detail[0]['customer_name'],
			'customer_address' 		=> $customer_detail[0]['customer_address'],
			'customer_mobile' 		=> $customer_detail[0]['customer_mobile'],
			'customer_email' 		=> $customer_detail[0]['customer_email'],
			'receipt_amount' 		=> $receipt_amount,
			'invoice_amount' 		=> $invoice_amount,
			'invoice_info' 			=> $invoice_content,
			'receipt_info' 			=> $receipt_content,
			'payment_status' 		=> $payment_status,
			'status_amount' 		=> $status_amount,
			'color' 		=> $color
			
			);
		$chapterList = $CI->parser->parse('customer/customer_details',$data,true);
		return $chapterList;
	}
	//Search customer
	public function customer_search_list($cat_id,$company_id)
	{
		$CI =& get_instance();
		$CI->load->model('customers');
		$category_list = $CI->customers->retrieve_category_list();
		$customers_list = $CI->customers->customer_search_list($cat_id,$company_id);
		$data = array(
				'title' => 'customers List',
				'customers_list' => $customers_list,
				'category_list' => $category_list
			);
		$customerList = $CI->parser->parse('customer/customer',$data,true);
		return $customerList;
	}
}
?>
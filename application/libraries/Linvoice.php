<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Linvoice {
	
	//Retrieve  Invoice List
	public function invoice_list($limit,$page,$links)
	{
		$CI =& get_instance();
		$CI->load->model('invoices');		
		$invoices_list = $CI->invoices->invoice_list($limit,$page);
		$person_list = $CI->invoices->get_auth_person_list();	
		if(!empty($invoices_list)){
			$i=$page;
			foreach($invoices_list as $k=>$v){$i++;
			   $invoices_list[$k]['sl']=$i;
			   $invoices_list[$k]['authorised_p_name']  = "";
				
			    $invoices_list[$k]['sl']=$i;
			    $invoices_list[$k]['final_date'] = date_numeric_format($invoices_list[$k]['created_on']);			   
			    $invoices_list[$k]['final_total']  = round(($invoices_list[$k]['total_credit']-(($invoices_list[$k]['total_credit']*$invoices_list[$k]['discount'])/100))-$invoices_list[$k]['adjustment'],2);
			   				
				if(!empty($person_list)){	
					foreach($person_list as $indx=>$val){						
						if($invoices_list[$k]['authorised_by_id'] == $val['id']){
							$invoices_list[$k]['authorised_p_name']  = $val['name'];
						}
					}
				}
			}
		}
		$data = array(
				'title' => 'Invoices List',
				'invoices_list' => $invoices_list,
				'links' => $links
			);
		$invoiceList = $CI->parser->parse('invoice/invoice',$data,true);
		return $invoiceList;
	}

	public function invoice_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('invoices');
		$person_list = $CI->invoices->get_auth_person_list();
		$data = array(
			'title' => 'Add New Invoice',
			'auth_person_list' => $person_list
		);
		$invoiceForm = $CI->parser->parse('invoice/add_invoice_form',$data,true);
		return $invoiceForm;
	}
	
	public function invoice_edit_data($invoice_id)
	{
		$CI =& get_instance();
		$CI->load->model('invoices');
		$sales_edit_data = $CI->invoices->get_edit_data($invoice_id);
		$person_list = $CI->invoices->get_auth_person_list();		
		$data=array();
		$sales_amount = 0;
		$grand_total_amount = 0;
		if(!empty($sales_edit_data)){
			$i=0;
			foreach($sales_edit_data as $k=>$v){$i++;					
			   $sales_edit_data[$k]['sl']=$i;
			   $sales_edit_data[$k]['convert_date'] = date_numeric_format($sales_edit_data[$k]['created_on']);
			   $sales_amount = $sales_amount+$sales_edit_data[$k]['total_price'];
			   $grand_total_amount = $sales_amount-(($sales_amount*$sales_edit_data[$k]['discount'])/100);
			   $grand_total_amount  = $grand_total_amount-$sales_edit_data[$k]['adjustment'];
			   				
				if(!empty($person_list)){	
					foreach($person_list as $indx=>$val){						
						if($sales_edit_data[0]['authorised_by_id'] == $val['id']){
							$person_list[$indx]['selected']='selected="selected"';
						}
						else{
							$person_list[$indx]['selected']='';
						}
					}
				}
			}
			$data=array(
				'invoice_id'		=>	$sales_edit_data[0]['invoice_id'],
				'customer_name'		=>	$sales_edit_data[0]['customer_name'],
				'customer_id'		=>	$sales_edit_data[0]['customer_id'],
				'terms_and_condi'	=>	nl2br($sales_edit_data[0]['terms_and_condi']),
				'final_date'		=>	$sales_edit_data[0]['convert_date'],
				'price_total'		=>	$sales_amount,
				'discount'			=>	$sales_edit_data[0]['discount'],
				'adjustment'		=>	$sales_edit_data[0]['adjustment'],
				'grand_total'		=>	$grand_total_amount,
				'invoice_no'		=>	$sales_edit_data[0]['invoice_no'],
				'invoice_all_data'	=>	$sales_edit_data,
				'auth_person_list' => $person_list,
				);
			}
		$edit_view = $CI->parser->parse('invoice/invoice_edit',$data,true);
		return $edit_view;
	}
	
	
	public function get_details_data($invoice_id)
	{
		$CI =& get_instance();
		$CI->load->model('invoices');
		$sales_detail = $CI->invoices->retrieve_details_data($invoice_id);
		$person_list = $CI->invoices->get_auth_person_list();		
		$data=array();
		$sales_amount = 0;
		$grand_total_amount = 0;
		if(!empty($sales_detail)){
			$i=0;
			foreach($sales_detail as $k=>$v){$i++;	
				$sales_detail[$k]['authorised_p_name'] = "";
				$sales_detail[$k]['authorised_p_desg'] = "";
				$sales_detail[$k]['authorised_p_cell'] ="";
				
			   $sales_detail[$k]['sl']=$i;
			   $sales_detail[$k]['convert_date'] = date_numeric_format($sales_detail[$k]['created_on']);
			   $sales_amount = $sales_amount+$sales_detail[$k]['total_price'];
			   $grand_total_amount = $sales_amount-(($sales_amount*$sales_detail[$k]['discount'])/100);
			   $grand_total_amount  = $grand_total_amount-$sales_detail[$k]['adjustment'];
			   				
				if(!empty($person_list)){	
					foreach($person_list as $indx=>$val){						
						if($sales_detail[$k]['authorised_by_id']== $val['id']){
							$sales_detail[$k]['authorised_p_name']  = $val['name'];
							$sales_detail[$k]['authorised_p_desg'] =  $val['designation'];
							$sales_detail[$k]['authorised_p_cell'] =  $val['mobile_no'];
						}
					}
				}
			}
			$data=array(
				'invoice_id'		=>	$sales_detail[0]['invoice_id'],
				'customer_name'		=>	$sales_detail[0]['customer_name'],
				'customer_address'	=>	nl2br($sales_detail[0]['customer_address']),
				'customer_phone'	=>	$sales_detail[0]['customer_mobile'],
				'authorised_p_name'	=>	$sales_detail[0]['authorised_p_name'],
				'authorised_p_desg'	=>	$sales_detail[0]['authorised_p_desg'],
				'authorised_p_cell'	=>	$sales_detail[0]['authorised_p_cell'],
				'terms_and_condi'	=>	nl2br($sales_detail[0]['terms_and_condi']),
				'final_date'		=>	$sales_detail[0]['convert_date'],
				'price_total'		=>	$sales_amount,
				'discount'			=>	$sales_detail[0]['discount'],
				'adjustment'		=>	$sales_detail[0]['adjustment'],
				'grand_total'		=>	$grand_total_amount,
				'invoice_no'		=>	$sales_detail[0]['invoice_no'],
				'invoice_all_data'	=>	$sales_detail
				);
			}
		$invoice_html_view = $CI->parser->parse('invoice/invoice_details',$data,true);
		return $invoice_html_view;
	}
	//invoice PDF Data
	public function invoice_pdf_data($invoice_id)
	{
		$CI =& get_instance();
		$CI->load->model('invoices');
		$CI->load->library('occational');
		$sales_detail = $CI->invoices->retrieve_details_data($invoice_id);
		$person_list = $CI->invoices->get_auth_person_list();		
		$data=array();
		$sales_amount = 0;
		$grand_total_amount = 0;
		if(!empty($sales_detail)){
			$i=0;
			foreach($sales_detail as $k=>$v){$i++;	
				$sales_detail[$k]['authorised_p_name'] = "";
				$sales_detail[$k]['authorised_p_desg'] = "";
				$sales_detail[$k]['authorised_p_cell'] ="";
				
			   $sales_detail[$k]['sl']=$i;
			   $sales_detail[$k]['convert_date'] = date_numeric_format($sales_detail[$k]['created_on']);
			   $sales_amount = $sales_amount+$sales_detail[$k]['total_price'];
			   $grand_total_amount = $sales_amount-(($sales_amount*$sales_detail[$k]['discount'])/100);
			   $grand_total_amount  = $grand_total_amount-$sales_detail[$k]['adjustment'];
			   				
				if(!empty($person_list)){	
					foreach($person_list as $indx=>$val){						
						if($sales_detail[$k]['authorised_by_id']== $val['id']){
							$sales_detail[$k]['authorised_p_name']  = $val['name'];
							$sales_detail[$k]['authorised_p_desg'] =  $val['designation'];
							$sales_detail[$k]['authorised_p_cell'] =  $val['mobile_no'];
						}
					}
				}
			}
			$data=array(
				'invoice_id'		=>	$sales_detail[0]['invoice_id'],
				'customer_name'		=>	$sales_detail[0]['customer_name'],
				'customer_address'	=>	nl2br($sales_detail[0]['customer_address']),
				'customer_phone'	=>	$sales_detail[0]['customer_mobile'],
				'authorised_p_name'	=>	$sales_detail[0]['authorised_p_name'],
				'authorised_p_desg'	=>	$sales_detail[0]['authorised_p_desg'],
				'authorised_p_cell'	=>	$sales_detail[0]['authorised_p_cell'],
				'terms_and_condi'	=>	nl2br($sales_detail[0]['terms_and_condi']),
				'final_date'		=>	$sales_detail[0]['convert_date'],
				'price_total'		=>	$sales_amount,
				'discount'			=>	$sales_detail[0]['discount'],
				'adjustment'		=>	$sales_detail[0]['adjustment'],
				'grand_total'		=>	$grand_total_amount,
				'invoice_no'		=>	$sales_detail[0]['invoice_no'],
				'invoice_all_data'	=>	$sales_detail
				);
			}
		$invoice_view = $CI->parser->parse('invoice/invoice_pdf',$data,true);
		return $invoice_view;
	}
	public function search_by_customer($customer_id)
	{
		$CI =& get_instance();
		$CI->load->model('invoices');
		$invoices_list = $CI->invoices->get_by_customer_search_list($customer_id);
		$person_list = $CI->invoices->get_auth_person_list();	
		if(!empty($invoices_list)){
			$i=0;
			foreach($invoices_list as $k=>$v){$i++;
			   $invoices_list[$k]['sl']=$i;
			   $invoices_list[$k]['authorised_p_name']  = "";
				
			    $invoices_list[$k]['sl']=$i;
			    $invoices_list[$k]['final_date'] = date_numeric_format($invoices_list[$k]['created_on']);			   
			    $invoices_list[$k]['final_total']  = round(($invoices_list[$k]['total_credit']-(($invoices_list[$k]['total_credit']*$invoices_list[$k]['discount'])/100))-$invoices_list[$k]['adjustment'],2);
			   				
				if(!empty($person_list)){	
					foreach($person_list as $indx=>$val){						
						if($invoices_list[$k]['authorised_by_id'] == $val['id']){
							$invoices_list[$k]['authorised_p_name']  = $val['name'];
						}
					}
				}
			}
		}
		$data = array(
			'title' => 'Invoices Search List',
			'invoice_list' => $invoices_list
		);
		$invoiceList = $CI->parser->parse('invoice/search',$data,true);
		return $invoiceList;
	}
	
	public function retrieve_date_wise_search_list($start_date,$end_date)
	{
		$CI =& get_instance();
		$CI->load->model('invoices');
		$invoices_list = $CI->invoices->get_date_wise_search_list($start_date,$end_date);
		$person_list = $CI->invoices->get_auth_person_list();	
		if(!empty($invoices_list)){
			$i=0;
			foreach($invoices_list as $k=>$v){$i++;
			   $invoices_list[$k]['sl']=$i;
			   $invoices_list[$k]['authorised_p_name']  = "";
				
			    $invoices_list[$k]['sl']=$i;
			    $invoices_list[$k]['final_date'] = date_numeric_format($invoices_list[$k]['created_on']);			   
			    $invoices_list[$k]['final_total']  = round(($invoices_list[$k]['total_credit']-(($invoices_list[$k]['total_credit']*$invoices_list[$k]['discount'])/100))-$invoices_list[$k]['adjustment'],2);
			   				
				if(!empty($person_list)){	
					foreach($person_list as $indx=>$val){						
						if($invoices_list[$k]['authorised_by_id'] == $val['id']){
							$invoices_list[$k]['authorised_p_name']  = $val['name'];
						}
					}
				}
			}
		}
		$data = array(
			'title' => 'Invoices Search List',
			'invoice_list' => $invoices_list
		);
		$invoiceList = $CI->parser->parse('invoice/search',$data,true);
		return $invoiceList;
	}
	
	
}
?>
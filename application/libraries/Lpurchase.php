<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lpurchase {
	// Retrieve  Quize List From DB
	public function purchase_list($limit,$page,$links)
	{
		$CI =& get_instance();
		$CI->load->model('purchases');	
		$purchases_list = $CI->purchases->get_purchase_list($limit,$page);		
		$person_list = $CI->purchases->get_auth_person_list();	
		if(!empty($purchases_list)){	
			$i=$page;
			foreach($purchases_list as $k=>$v){$i++;
				$purchases_list[$k]['authorised_p_name']  = "";
				$purchases_list[$k]['requested_p_name']  = "";
				
			    $purchases_list[$k]['sl']=$i;
			    $purchases_list[$k]['final_date'] = date_numeric_format($purchases_list[$k]['purchase_date']);			   
			    $purchases_list[$k]['final_total']  = round(($purchases_list[$k]['total_credit']-(($purchases_list[$k]['total_credit']*$purchases_list[$k]['discount'])/100))-$purchases_list[$k]['adjustment'],2);
			   				
				if(!empty($person_list)){	
					foreach($person_list as $indx=>$val){						
						if($purchases_list[$k]['authorised_by_id'] == $val['id']){
							$purchases_list[$k]['authorised_p_name']  = $val['name'];
						}
						if($purchases_list[$k]['requested_by_id'] == $val['id']){
							$purchases_list[$k]['requested_p_name']  = $val['name'];
						}
					}
				}
			}
		}

		$data = array(
				'title' => 'Purchases List',
				'purchases_list' => $purchases_list,
				'links' => $links
			);
		$purchaseList = $CI->parser->parse('purchase/purchase',$data,true);
		return $purchaseList;
	}

	//Sub Category Add
	public function purchase_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('purchases');
		$person_list = $CI->purchases->get_auth_person_list();
		$data = array(
			'title' => 'Add Purchase',
			'auth_person_list' => $person_list
		);
		$purchaseForm = $CI->parser->parse('purchase/add_purchase_form',$data,true);
		return $purchaseForm;
	}

	public function insert_purchase($data)
	{
		$CI =& get_instance();
		$CI->load->model('purchases');
        $CI->purchases->purchase_entry($data);
		return true;
	}
	
	public function purchase_edit_data($purchase_id)
	{
		$CI =& get_instance();
		$CI->load->model('purchases');
		$purchase_detail = $CI->purchases->retrieve_purchase_editdata($purchase_id);
		$person_list = $CI->purchases->get_auth_person_list();
		$req_person_list = $person_list;
		$purchase_amount = 0;
		$grand_total_amount = 0;
		$data=array();
		if(!empty($purchase_detail)){
			$i=0;
			foreach($purchase_detail as $k=>$v){$i++;
			   $purchase_detail[$k]['sl']=$i;
			   $purchase_amount = $purchase_amount+$purchase_detail[$k]['total_amount'];
			   $grand_total_amount = ($purchase_amount-(($purchase_amount*$purchase_detail[$k]['discount'])/100)-$purchase_detail[$k]['adjustment']);
			}
			
			if(!empty($person_list)){	
				foreach($person_list as $indx=>$val){						
					if($purchase_detail[0]['authorised_by_id'] == $val['id']){
						$person_list[$indx]['selected']='selected="selected"';
					}
					else{
						$person_list[$indx]['selected']='';
					}
				}
				foreach($req_person_list as $index=>$value){
					if($purchase_detail[0]['requested_by_id'] == $value['id']){
						$req_person_list[$index]['selected']='selected="selected"';
					}
					else{
						$req_person_list[$index]['selected']='';
					}
				}
			}
			$data=array(
				'purchase_id'		=>	$purchase_id,
				'chalan_no'			=>	$purchase_detail[0]['chalan_no'],
				'supplier_name'		=>	$purchase_detail[0]['supplier_name'],
				'supplier_id'		=>	$purchase_detail[0]['supplier_id'],
				'total_price'		=>	$purchase_amount,
				'discount'			=>	$purchase_detail[0]['discount'],
				'adjustment'		=>	$purchase_detail[0]['adjustment'],
				'grand_total'		=>	ceil($grand_total_amount),
				'ship_to'			=>	$purchase_detail[0]['ship_to'],
				'terms_and_condi'	=>	$purchase_detail[0]['terms_and_condi'],
				'job_description'	=>	$purchase_detail[0]['job_description'],
				'purchase_date'		=>	$purchase_detail[0]['purchase_date'],
				'purchase_info'		=>	$purchase_detail,
				'auth_person_list' => $person_list,
				'req_person_list' => $req_person_list
				);
		}
		$chapterList = $CI->parser->parse('purchase/edit_purchase_form',$data,true);
		return $chapterList;
	}
	
	public function purchase_details_data($purchase_id)
	{
		$CI =& get_instance();
		$CI->load->model('purchases');
		$purchase_detail = $CI->purchases->purchase_details_data($purchase_id);
		$person_list = $CI->purchases->get_auth_person_list();
		$purchase_amount = 0;
		$grand_total_amount = 0;
		if(!empty($purchase_detail)){
			$i=0;
			foreach($purchase_detail as $k=>$v){$i++;	
				$purchase_detail[$k]['authorised_p_name'] = "";
				$purchase_detail[$k]['authorised_p_desg'] = "";
				$purchase_detail[$k]['authorised_p_cell'] ="";
				$purchase_detail[$k]['requested_p_name']  = "";
				
			   $purchase_detail[$k]['sl']=$i;
			   $purchase_detail[$k]['convert_date'] = date_numeric_format($purchase_detail[$k]['purchase_date']);
			   $purchase_amount = $purchase_amount+$purchase_detail[$k]['total_amount'];
			   $grand_total_amount = $purchase_amount-(($purchase_amount*$purchase_detail[$k]['discount'])/100);
			   $grand_total_amount  = round($grand_total_amount-$purchase_detail[$k]['adjustment'],2);
			   				
				if(!empty($person_list)){	
					foreach($person_list as $indx=>$val){						
						if($purchase_detail[$k]['authorised_by_id']== $val['id']){
							$purchase_detail[$k]['authorised_p_name']  = $val['name'];
							$purchase_detail[$k]['authorised_p_desg'] =  $val['designation'];
							$purchase_detail[$k]['authorised_p_cell'] =  $val['mobile_no'];
						}
						if($purchase_detail[$k]['requested_by_id']== $val['id']){
							$purchase_detail[$k]['requested_p_name']  = $val['name'];
						}
					}
				}
			}
		}
		$data=array(
			'purchase_id'		=>	$purchase_detail[0]['purchase_id'],
			'supplier_name'		=>	$purchase_detail[0]['supplier_name'],
			'supplier_address'	=>	nl2br($purchase_detail[0]['address']),
			'supplier_phone'	=>	$purchase_detail[0]['mobile'],
			'authorised_p_name'	=>	$purchase_detail[0]['authorised_p_name'],
			'authorised_p_desg'	=>	$purchase_detail[0]['authorised_p_desg'],
			'authorised_p_cell'	=>	$purchase_detail[0]['authorised_p_cell'],
			'requested_p_name'	=>	$purchase_detail[0]['requested_p_name'],
			'job_description'	=>	nl2br($purchase_detail[0]['job_description']),
			'ship_to'			=>	nl2br($purchase_detail[0]['ship_to']),
			'terms_and_condi'	=>	nl2br($purchase_detail[0]['terms_and_condi']),
			'final_date'		=>	$purchase_detail[0]['convert_date'],
			'total_price'		=>	$purchase_amount,
			'discount'			=>	$purchase_detail[0]['discount'],
			'adjustment'		=>	$purchase_detail[0]['adjustment'],
			'grand_total'		=>	$grand_total_amount,
			'chalan_no'			=>	$purchase_detail[0]['chalan_no'],
			'purchase_all_data'	=>	$purchase_detail
			);
		$detail_html = $CI->parser->parse('purchase/purchase_detail',$data,true);
		return $detail_html;
	}
	//Purchase html Data
	public function pdf_purchase_details($purchase_id)
	{
		$CI =& get_instance();
		$CI->load->model('purchases');
		$purchase_detail = $CI->purchases->purchase_details_data($purchase_id);
		$person_list = $CI->purchases->get_auth_person_list();
		$purchase_amount = 0;
		$grand_total_amount = 0;
		if(!empty($purchase_detail)){
			$i=0;
			foreach($purchase_detail as $k=>$v){$i++;			
				$purchase_detail[$k]['authorised_p_name'] = "";
				$purchase_detail[$k]['authorised_p_desg'] = "";
				$purchase_detail[$k]['authorised_p_cell'] ="";
				$purchase_detail[$k]['requested_p_name']  = "";
			
			   $purchase_detail[$k]['sl']=$i;
			   $purchase_detail[$k]['convert_date'] = date_numeric_format($purchase_detail[$k]['purchase_date']);
			   $purchase_amount = $purchase_amount+$purchase_detail[$k]['total_amount'];
			   $grand_total_amount = $purchase_amount-(($purchase_amount*$purchase_detail[$k]['discount'])/100);
			   $grand_total_amount  = round($grand_total_amount-$purchase_detail[$k]['adjustment'],2);
			   				
				if(!empty($person_list)){	
					foreach($person_list as $indx=>$val){						
						if($purchase_detail[$k]['authorised_by_id']== $val['id']){
							$purchase_detail[$k]['authorised_p_name']  = $val['name'];
							$purchase_detail[$k]['authorised_p_desg'] =  $val['designation'];
							$purchase_detail[$k]['authorised_p_cell'] =  $val['mobile_no'];
						}
						if($purchase_detail[$k]['requested_by_id']== $val['id']){
							$purchase_detail[$k]['requested_p_name']  = $val['name'];
						}
					}
				}
			}
		}
		$data=array(
			'purchase_id'		=>	$purchase_detail[0]['purchase_id'],
			'supplier_name'		=>	$purchase_detail[0]['supplier_name'],
			'supplier_address'	=>	nl2br($purchase_detail[0]['address']),
			'supplier_phone'	=>	$purchase_detail[0]['mobile'],
			'authorised_p_name'	=>	$purchase_detail[0]['authorised_p_name'],
			'authorised_p_desg'	=>	$purchase_detail[0]['authorised_p_desg'],
			'authorised_p_cell'	=>	$purchase_detail[0]['authorised_p_cell'],
			'requested_p_name'	=>	$purchase_detail[0]['requested_p_name'],
			'job_description'	=>	nl2br($purchase_detail[0]['job_description']),
			'ship_to'			=>	nl2br($purchase_detail[0]['ship_to']),
			'terms_and_condi'	=>	nl2br($purchase_detail[0]['terms_and_condi']),
			'final_date'		=>	$purchase_detail[0]['convert_date'],
			'total_price'		=>	$purchase_amount,
			'discount'			=>	$purchase_detail[0]['discount'],
			'adjustment'		=>	$purchase_detail[0]['adjustment'],
			'grand_total'		=>	$grand_total_amount,
			'chalan_no'			=>	$purchase_detail[0]['chalan_no'],
			'purchase_all_data'	=>	$purchase_detail
			);
		$detail_html = $CI->parser->parse('purchase/pdf_purchase',$data,true);
		return $detail_html;
	}
	
	public function search_by_supplier($supplier_id)
	{
		$CI =& get_instance();
		$CI->load->model('purchases');
		$purchases_list = $CI->purchases->get_by_supplier_search_list($supplier_id);
		$person_list = $CI->purchases->get_auth_person_list();	
		if(!empty($purchases_list)){	
			$i=0;
			foreach($purchases_list as $k=>$v){$i++;
				$purchases_list[$k]['authorised_p_name']  = "";
				$purchases_list[$k]['requested_p_name']  = "";
				
			    $purchases_list[$k]['sl']=$i;
			    $purchases_list[$k]['final_date'] = date_numeric_format($purchases_list[$k]['purchase_date']);			   
			    $purchases_list[$k]['final_total']  = round(($purchases_list[$k]['total_credit']-(($purchases_list[$k]['total_credit']*$purchases_list[$k]['discount'])/100))-$purchases_list[$k]['adjustment'],2);
			   				
				if(!empty($person_list)){	
					foreach($person_list as $indx=>$val){						
						if($purchases_list[$k]['authorised_by_id'] == $val['id']){
							$purchases_list[$k]['authorised_p_name']  = $val['name'];
						}
						if($purchases_list[$k]['requested_by_id'] == $val['id']){
							$purchases_list[$k]['requested_p_name']  = $val['name'];
						}
					}
				}
			}
		}
		$data = array(
				'title' => 'Supplier wise purchases search list',
				'purchases_list' => $purchases_list,
			);
		$purchaseList = $CI->parser->parse('purchase/supplier_search',$data,true);
		return $purchaseList;
	}
	
	public function retrieve_date_wise_search_list($start_date,$end_date)
	{
		$CI =& get_instance();
		$CI->load->model('purchases');
		$purchases_list = $CI->purchases->get_date_wise_search_list($start_date,$end_date);
		$person_list = $CI->purchases->get_auth_person_list();	
		if(!empty($purchases_list)){	
			$i=0;
			foreach($purchases_list as $k=>$v){$i++;
				$purchases_list[$k]['authorised_p_name']  = "";
				$purchases_list[$k]['requested_p_name']  = "";
				
			    $purchases_list[$k]['sl']=$i;
			    $purchases_list[$k]['final_date'] = date_numeric_format($purchases_list[$k]['purchase_date']);	
				$purchases_list[$k]['final_total']  = round(($purchases_list[$k]['total_credit']-(($purchases_list[$k]['total_credit']*$purchases_list[$k]['discount'])/100))-$purchases_list[$k]['adjustment'],2);
			   				
				if(!empty($person_list)){	
					foreach($person_list as $indx=>$val){						
						if($purchases_list[$k]['authorised_by_id'] == $val['id']){
							$purchases_list[$k]['authorised_p_name']  = $val['name'];
						}
						if($purchases_list[$k]['requested_by_id'] == $val['id']){
							$purchases_list[$k]['requested_p_name']  = $val['name'];
						}
					}
				}
			}
		}
		$data = array(
				'title' => 'Datewise purchases search list',
				'purchases_list' => $purchases_list,
			);
		$purchaseList = $CI->parser->parse('purchase/date_search',$data,true);
		return $purchaseList;
	}
}
?>
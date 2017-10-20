<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lpurchase {
	// Retrieve  Quize List From DB
	public function purchase_list($limit,$page,$links)
	{
		$CI =& get_instance();
		$CI->load->model('purchases');
		$CI->load->library('occational');
		$purchases_list = $CI->purchases->purchase_list($limit,$page);
		if(!empty($purchases_list)){	
			$j=0;
			foreach($purchases_list as $k=>$v){
				$purchases_list[$k]['final_date'] = $CI->occational->dateConvert($purchases_list[$j]['purchase_date']);
			  $j++;
			}
		
			$i=$page;
			foreach($purchases_list as $k=>$v){$i++;
			   $purchases_list[$k]['sl']=$i;
			}
		}
		$data = array(
				'title' => 'purchases List',
				'purchases_list' => $purchases_list,
				'links' => $links
			);
		$purchaseList = $CI->parser->parse('purchase/purchase',$data,true);
		return $purchaseList;
	}
	//Purchase Item By Search
	public function purchase_by_search($supplier_id)
	{
		$CI =& get_instance();
		$CI->load->model('purchases');
		$CI->load->library('occational');
		$purchases_list = $CI->purchases->purchase_by_search($supplier_id);
		$j=0;
		if(!empty($purchases_list)){
			foreach($purchases_list as $k=>$v){
				$purchases_list[$k]['final_date'] = $CI->occational->dateConvert($purchases_list[$j]['purchase_date']);
			  $j++;
			}
			$i=0;
			foreach($purchases_list as $k=>$v){$i++;
			   $purchases_list[$k]['sl']=$i;
			}
		}
		$data = array(
				'purchases_list' => $purchases_list
			);
		$purchaseList = $CI->parser->parse('purchase/purchase',$data,true);
		return $purchaseList;
	}
	//Sub Category Add
	public function purchase_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('purchases');
		$data = array(
				'title' => 'Add purchase',
				'chalan_number' => $CI->purchases->chalan_number_generator()
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
	//purchase Edit Data
	public function purchase_edit_data($purchase_id)
	{
		$CI =& get_instance();
		$CI->load->model('purchases');
		$purchase_detail = $CI->purchases->retrieve_purchase_editdata($purchase_id);
		if(!empty($purchase_detail)){
			$i=0;
			foreach($purchase_detail as $k=>$v){$i++;
			   $purchase_detail[$k]['sl']=$i;
			}
		}
		
		$data=array(
			'purchase_id'		=>	$purchase_detail[0]['purchase_id'],
			'chalan_no'			=>	$purchase_detail[0]['chalan_no'],
			'supplier_name'		=>	$purchase_detail[0]['supplier_name'],
			'supplier_id'		=>	$purchase_detail[0]['supplier_id'],
			'grand_total'		=>	$purchase_detail[0]['grand_total_amount'],
			'purchase_details'	=>	$purchase_detail[0]['purchase_details'],
			'purchase_date'		=>	$purchase_detail[0]['purchase_date'],
			'purchase_info'		=>	$purchase_detail
			);
		$chapterList = $CI->parser->parse('purchase/edit_purchase_form',$data,true);
		return $chapterList;
	}
	//Search purchase
	public function purchase_search_list($cat_id,$company_id)
	{
		$CI =& get_instance();
		$CI->load->model('purchases');
		$category_list = $CI->purchases->retrieve_category_list();
		$purchases_list = $CI->purchases->purchase_search_list($cat_id,$company_id);
		$data = array(
				'title' => 'purchases List',
				'purchases_list' => $purchases_list,
				'category_list' => $category_list
			);
		$purchaseList = $CI->parser->parse('purchase/purchase',$data,true);
		return $purchaseList;
	}
	//Purchase html Data
	public function purchase_details_data($purchase_id)
	{
		$CI =& get_instance();
		$CI->load->model('purchases');
		$CI->load->library('occational');
		$purchase_detail = $CI->purchases->purchase_details_data($purchase_id);
		if(!empty($purchase_detail)){
			$i = 0;
			foreach($purchase_detail as $k=>$v){$i++;
			   $purchase_detail[$k]['sl']=$i;
			}
			
			foreach($purchase_detail as $k=>$v){
			   $purchase_detail[$k]['convert_date'] = $CI->occational->dateConvert($purchase_detail[$k]['purchase_date']);
			}
		}
		$data=array(
			'purchase_id'		=>	$purchase_detail[0]['purchase_id'],
			'supplier_name'		=>	$purchase_detail[0]['supplier_name'],
			'final_date'		=>	$purchase_detail[0]['convert_date'],
			'sub_total_amount'	=>	$purchase_detail[0]['grand_total_amount'],
			'chalan_no'			=>	$purchase_detail[0]['chalan_no'],
			'purchase_all_data'	=>	$purchase_detail
			);
		$chapterList = $CI->parser->parse('purchase/purchase_detail',$data,true);
		return $chapterList;
	}
	//Purchase html Data
	public function pdf_purchase_details($purchase_id)
	{
		$CI =& get_instance();
		$CI->load->model('purchases');
		$CI->load->library('occational');
		$purchase_detail = $CI->purchases->purchase_details_data($purchase_id);
		if(!empty($purchase_detail)){
			$i = 0;
			foreach($purchase_detail as $k=>$v){$i++;
			   $purchase_detail[$k]['sl']=$i;
			}
			
			foreach($purchase_detail as $k=>$v){
			   $purchase_detail[$k]['convert_date'] = $CI->occational->dateConvert($purchase_detail[$k]['purchase_date']);
			}
		}
		$data=array(
			'purchase_id'		=>	$purchase_detail[0]['purchase_id'],
			'supplier_name'		=>	$purchase_detail[0]['supplier_name'],
			'final_date'		=>	$purchase_detail[0]['convert_date'],
			'sub_total_amount'	=>	$purchase_detail[0]['grand_total_amount'],
			'chalan_no'			=>	$purchase_detail[0]['chalan_no'],
			'purchase_all_data'	=>	$purchase_detail
			);
		$chapterList = $CI->parser->parse('purchase/pdf_purchase',$data,true);
		return $chapterList;
	}
}
?>
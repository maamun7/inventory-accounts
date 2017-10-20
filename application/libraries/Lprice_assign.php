<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lprice_assign {
	//Retrieve  Customer List	
	public function get_customer_price_list($limit,$page,$links)
	{
		$CI =& get_instance();
		$CI->load->model('price_assigns');
		$cust_mrp_list = $CI->price_assigns->retrieve_customer_price_list($limit,$page);
		$i=$page;
		if(!empty($cust_mrp_list)){	
			foreach($cust_mrp_list as $k=>$v){$i++;
			   $cust_mrp_list[$k]['sl']=$i;
			}
		}
		$data = array(
				'title' => 'Customer Price List',
				'customer_price_list' => $cust_mrp_list,
				'links' => $links
			);
		$price_list_view = $CI->parser->parse('price_assign/assign_list',$data,true);
		return $price_list_view;
	}
	//Retrieve  Customer Search List	
	public function price_search_item($customer_id)
	{
		$CI =& get_instance();
		$CI->load->model('price_assigns');
		$price_search_items = $CI->price_assigns->get_price_search_item($customer_id);
		$i=0;
		foreach($price_search_items as $k=>$v){$i++;
           $price_search_items[$k]['sl']=$i;
		}
		$data = array(
				'customer_price_list' => $price_search_items
			);
		$price_list_view = $CI->parser->parse('price_assign/assign_list',$data,true);
		return $price_list_view;
	}
}
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lreport {
	// Retrieve All Stock Report
	public function stock_report($limit,$page,$links)
	{
		$CI =& get_instance();
		$CI->load->model('reports');
		$CI->load->library('occational');
		$all_products_report = $CI->reports->get_all_products($limit,$page);
		$total_purchase = null;	
		$total_sales = null;	
		$i = $page;
		if(!empty($all_products_report)){$i++;
			foreach($all_products_report as $kye=>$value){
				$purchase_report = $CI->reports->retrieve_purchase_report($value['product_id']);
			 	if(!empty($purchase_report)){
					$total_purchase = $purchase_report[0]['totalPurchaseQnty'];
				}
				$sales_report = $CI->reports->retrieve_sales_report($value['product_id']);
				if(!empty($sales_report)){
					$total_sales = $sales_report[0]['totalSalesQnty'];
				}
				$in_stock = $total_purchase - $total_sales; 
				$all_products_report[$kye]['purchase_quantity'] = $total_purchase ;
				$all_products_report[$kye]['sales_quantity'] = $total_sales ;
				$all_products_report[$kye]['stok_quantity'] = $in_stock ;	
			    $all_products_report[$kye]['sl']= $i;
			}
		}
		$data = array(
				'title' => 'Stock List',
				'stok_report' => $all_products_report,
				'links' => $links
			);
		$reportList = $CI->parser->parse('report/stock_report',$data,true);
		return $reportList;
	}
	// Retrieve Single Item Stock Stock Report
	public function stock_report_single_item($product_id)
	{
		$CI =& get_instance();
		$CI->load->model('reports');
		$all_products_report = $CI->reports->product_details_info($product_id);
		$total_purchase = null;	
		$total_sales = null;	
		$i = 0;
		if(!empty($all_products_report)){$i++;
			foreach($all_products_report as $kye=>$value){
				$purchase_report = $CI->reports->retrieve_purchase_report($value['product_id']);
			 	if(!empty($purchase_report)){
					$total_purchase = $purchase_report[0]['totalPurchaseQnty'];
				}
				$sales_report = $CI->reports->retrieve_sales_report($value['product_id']);
				if(!empty($sales_report)){
					$total_sales = $sales_report[0]['totalSalesQnty'];
				}
				$in_stock = $total_purchase - $total_sales; 
				$all_products_report[$kye]['purchase_quantity'] = $total_purchase ;
				$all_products_report[$kye]['sales_quantity'] = $total_sales ;
				$all_products_report[$kye]['stok_quantity'] = $in_stock ;	
			    $all_products_report[$kye]['sl']= $i;
			}
		}
		$data = array(
				'title' => 'Stock List',
				'stok_report' => $all_products_report
			);
		$reportList = $CI->parser->parse('report/stock_report',$data,true);
		return $reportList;
	}
	// Retrieve daily Report
	public function retrieve_all_reports()
	{
		$CI =& get_instance();
		$CI->load->model('reports');
		$CI->load->library('occational');
		
		// Sales Report 
		$sales_report = $CI->reports->todays_sales_report();
		$sales_amount = 0;
		if(!empty($sales_report)){
			$i=0;
			foreach($sales_report as $k=>$v){$i++;
			   $sales_report[$k]['sl']=$i;
			   $sales_report[$k]['final_date'] = date_numeric_format($sales_report[$k]['created_on']);			   
			   $sales_report[$k]['final_total']  = round(($sales_report[$k]['total_credit']-(($sales_report[$k]['total_credit']*$sales_report[$k]['discount'])/100))-$sales_report[$k]['adjustment'],2);
			   $sales_amount = $sales_amount+$sales_report[$k]['final_total'];
			}
		}	
		$sales_data = array(
			'sales_report' => $sales_report,
			'sales_amount' => $sales_amount
		);			
		$sales_content = $CI->parser->parse('report/sales_report',$sales_data,true);
				
		//Purchase Report 
		$purchase_report = $CI->reports->todays_purchase_report();		
		$purchase_amount = 0;
		if(!empty($purchase_report)){
			$i=0;
			foreach($purchase_report as $k=>$v){$i++;
			    $purchase_report[$k]['sl']=$i;			   
			    $purchase_report[$k]['final_total']  = round(($purchase_report[$k]['total_credit']-(($purchase_report[$k]['total_credit']*$purchase_report[$k]['discount'])/100))-$purchase_report[$k]['adjustment'],2);
				$purchase_amount = round($purchase_amount+$purchase_report[$k]['final_total'],2);
			}
		}	
		
		$purchase_data = array(
			'purchase_report' => $purchase_report,
			'purchase_amount' => $purchase_amount
		);		
		$purchase_content = $CI->parser->parse('report/todays_purchase_view',$purchase_data,true);

		$data = array(
				'title' => 'Home',
				'todays_sales_report' => $sales_content,
				'todays_purchase_report' => $purchase_content
			);
		$reportList = $CI->parser->parse('report/all_report',$data,true);
		return $reportList;
	}
	// Retrieve todays_sales_report
	public function todays_sales_report()
	{
		$CI =& get_instance();
		$CI->load->model('reports');
		$sales_report = $CI->reports->todays_sales_report();
		$sales_amount = 0;
		if(!empty($sales_report)){
			$i=0;
			foreach($sales_report as $k=>$v){$i++;
			   $sales_report[$k]['sl']=$i;		   
			   $sales_report[$k]['final_total']  = round(($sales_report[$k]['total_credit']-(($sales_report[$k]['total_credit']*$sales_report[$k]['discount'])/100))-$sales_report[$k]['adjustment'],2);
			   $sales_amount = $sales_amount+$sales_report[$k]['final_total'];
			}
		}	
		$sales_data = array(
			'sales_report' => $sales_report,
			'sales_amount' => $sales_amount
		);			
		$sales_content = $CI->parser->parse('report/sales_report',$sales_data,true);
		return $sales_content;
	}
	public function retrieve_dateWise_SalesReports($start_date,$end_date)
	{
		$CI =& get_instance();
		$CI->load->model('reports');
		$CI->load->library('occational');
		$sales_report = $CI->reports->retrieve_dateWise_SalesReports($start_date,$end_date);
		$sales_amount = 0;
		if(!empty($sales_report)){
			$i=0;
			foreach($sales_report as $k=>$v){$i++;
			   $sales_report[$k]['sl']=$i;
			   $sales_report[$k]['final_total']  = round(($sales_report[$k]['total_credit']-(($sales_report[$k]['total_credit']*$sales_report[$k]['discount'])/100))-$sales_report[$k]['adjustment'],2);
				$sales_amount = round($sales_report+$sales_report[$k]['final_total'],2);
			}
		}
		$data = array(
				'title' 		=> 'Sales Report',
				'sales_amount' 	=>  $sales_amount,
				'sales_report' 	=> $sales_report
			);
		$reportList = $CI->parser->parse('report/sales_report',$data,true);
		return $reportList;
	}
	// Retrieve todays_purchase_report
	public function todays_purchase_report()
	{
		$CI =& get_instance();
		$CI->load->model('reports');
		//Purchase Report 
		$purchase_report = $CI->reports->todays_purchase_report();		
		$purchase_amount = 0;
		if(!empty($purchase_report)){
			$i=0;
			foreach($purchase_report as $k=>$v){$i++;
			    $purchase_report[$k]['sl']=$i;			   
			    $purchase_report[$k]['final_total']  = round(($purchase_report[$k]['total_credit']-(($purchase_report[$k]['total_credit']*$purchase_report[$k]['discount'])/100))-$purchase_report[$k]['adjustment'],2);
				$purchase_amount = round($purchase_amount+$purchase_report[$k]['final_total'],2);
			}
		}	
		
		$purchase_data = array(
			'purchase_report' => $purchase_report,
			'purchase_amount' => $purchase_amount
		);		
		$purchase_content = $CI->parser->parse('report/todays_purchase_view',$purchase_data,true);
		return $purchase_content;
	}
	public function retrieve_dateWise_PurchaseReports($start_date,$end_date)
	{
		$CI =& get_instance();
		$CI->load->model('reports');
		$purchase_report = $CI->reports->retrieve_dateWise_PurchaseReports($start_date,$end_date);
		$purchase_amount = 0;
		if(!empty($purchase_report)){
			$i=0;
			foreach($purchase_report as $k=>$v){$i++;
			    $purchase_report[$k]['sl']=$i;
			    $purchase_report[$k]['prchse_date'] = date_numeric_format($purchase_report[$k]['purchase_date']);
				$purchase_amount = $purchase_amount+$purchase_report[$k]['grand_total_amount'];
			}
		}
		$data = array(
				'title' => 'Purchase Report',
				'purchase_amount' 	=>  $purchase_amount,
				'purchase_report' => $purchase_report
			);
		$reportList = $CI->parser->parse('report/purchase_report',$data,true);
		return $reportList;
	}
	public function get_products_report_sales_view()
	{
		$CI =& get_instance();
		$CI->load->model('reports');
		$product_report = $CI->reports->retrieve_product_sales_report();
		
		if(!empty($product_report)){
			$i=0;
			foreach($product_report as $k=>$v){$i++;
			    $product_report[$k]['sl']=$i;
			}
		}
		$sub_total = 0;
		if(!empty($product_report)){
			foreach($product_report as $k=>$v){
			    $product_report[$k]['sales_date'] = date_numeric_format($product_report[$k]['created_on']);
				$sub_total = round($sub_total+$product_report[$k]['total_price'],2);
			}
		}
		$data = array(
				'title' => 'Product Wise Sales Report',
				'sub_total' =>  $sub_total,
				'product_report' => $product_report
			);
		$reportList = $CI->parser->parse('report/product_report',$data,true);
		return $reportList;
	}
	public function get_products_search_report( $from_date,$to_date )
	{
		$CI =& get_instance();
		$CI->load->model('reports');
		$CI->load->library('occational');
		$product_report = $CI->reports->retrieve_product_search_sales_report( $from_date,$to_date );
		
		if(!empty($product_report)){
			$i=0;
			foreach($product_report as $k=>$v){$i++;
			    $product_report[$k]['sl']=$i;
			}
		}
		$sub_total = 0;
		if(!empty($product_report)){
			foreach($product_report as $k=>$v){
			    $product_report[$k]['sales_date'] = date_numeric_format($product_report[$k]['created_on']);
				$sub_total = round($sub_total+$product_report[$k]['total_price'],2);
			}
		}
		$data = array(
				'title' => 'Product Wise Sales Report',
				'sub_total' =>  $sub_total,
				'product_report' => $product_report
			);
		$reportList = $CI->parser->parse('report/product_report',$data,true);
		return $reportList;
	}
}
?>
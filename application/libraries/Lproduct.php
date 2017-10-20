<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lproduct {
	public function product_list($limit,$page,$links)
	{
		$CI =& get_instance();
		$CI->load->model('products');
		$products_list = $CI->products->product_list($limit,$page);
		$i=$page;
		if(!empty($products_list)){		
			foreach($products_list as $k=>$v){$i++;
			   $products_list[$k]['sl']=$i;
			}
		}
		$data = array(
				'title' => 'Products List',
				'products_list' => $products_list,
				'links' => $links
			);
		$productList = $CI->parser->parse('product/product',$data,true);
		return $productList;
	}
	//Sub Category Add
	public function product_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('products');
		$data = array(
				'title' => 'Add Product'
			);
		$productForm = $CI->parser->parse('product/add_product_form',$data,true);
		return $productForm;
	}
	public function insert_product($data)
	{
		$CI =& get_instance();
		$CI->load->model('products');
        $CI->products->product_entry($data);
		return true;
	}
	//Product Edit Data
	public function product_edit_data($product_id)
	{
		$CI =& get_instance();
		$CI->load->model('products');
		$product_detail = $CI->products->retrieve_product_editdata($product_id);
		$data=array(
			'product_id' 			=> $product_detail[0]['product_id'],
			'product_name' 			=> $product_detail[0]['product_name'],
			'purchase_price' 		=> $product_detail[0]['purchase_price'],
			'quantity_type' 		=> $product_detail[0]['quantity_type'],
			'product_model' 		=> $product_detail[0]['product_model'],
			'product_details' 		=> $product_detail[0]['product_details']
			);
		$chapterList = $CI->parser->parse('product/edit_product_form',$data,true);
		return $chapterList;
	}
	//Search Product
	public function product_search_list($product_id)
	{
		$CI =& get_instance();
		$CI->load->model('products');
		$products_list = $CI->products->product_search_item($product_id);
		$i=0;
		foreach($products_list as $k=>$v){$i++;
           $products_list[$k]['sl']=$i;
		}
		$data = array(
				'title' => 'Products List',
				'products_list' => $products_list,
			);
		$productList = $CI->parser->parse('product/product',$data,true);
		return $productList;
	}
	//Product Details
	public function product_details($product_id)
	{
		$CI =& get_instance();
		$CI->load->model('products');
		$details_info = $CI->products->product_details_info($product_id);
		//
		$purchase_report = $CI->products->product_purchase_info($product_id);
		$totalPurchase = 0;		
		$purchase_amount = 0;
		$j=0;		
		if(!empty($purchase_report)){	
			foreach($purchase_report as $k=>$v){$j++;
				$purchase_report[$k]['sl'] = $j;
				$purchase_report[$k]['final_date'] = date_numeric_format($purchase_report[$k]['purchase_date']);
				$purchase_amount = ($purchase_amount + $purchase_report[$k]['total_amount']);
				$totalPurchase = ($totalPurchase + $purchase_report[$k]['quantity']);
			}
		}	
		$purchase_data = array(
			'purchase_report' => $purchase_report,
			'purchase_amount' => $purchase_amount
		);		
		$purchase_content = $CI->parser->parse('product/purchs_report_view',$purchase_data,true);
		
		
		$salesData = $CI->products->invoice_data($product_id);		
		$totalSales = 0;		
		$sales_amount = 0;		
		if(!empty($salesData)){	
			$i=0;
			foreach($salesData as $k=>$v){$i++;
				$salesData[$k]['sl'] = $i;
				$salesData[$k]['final_date'] = date_numeric_format($salesData[$k]['created_on']);
				$totalSales = ($totalSales + $salesData[$k]['quantity']);
				$sales_amount = ($sales_amount + $salesData[$k]['total_price']);
			}
		}
		$sales_data = array(
			'sales_report' => $salesData,
			'sales_amount' => $sales_amount
		);			
		$sales_content = $CI->parser->parse('product/sells_report_view',$sales_data,true);
		
		$stock = ($totalPurchase - $totalSales);
		
		$data = array(
				'title'					=> 'Product Detail',
				'product_name' 			=> $details_info[0]['product_name'],
				'product_model' 		=> $details_info[0]['product_model'],
				'quantity_type' 		=> $details_info[0]['quantity_type'],
				'purchase_price'		=> $details_info[0]['purchase_price'],
				'purchaseTotalAmount'	=> $purchase_amount,
				'sales_amount'			=> $sales_amount,
				'total_purchase'		=> $totalPurchase,
				'total_sales'			=> $totalSales,
				'purchase_content'		=> $purchase_content,
				'sales_content'			=> $sales_content,
				'stock'					=> $stock 
			);
		$productList = $CI->parser->parse('product/product_details',$data,true);
		return $productList;
	}
}
?>
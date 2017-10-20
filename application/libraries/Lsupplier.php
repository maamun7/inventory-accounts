<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lsupplier {
	//Supplier List
	public function supplier_list($limit,$page,$links)
	{
		$CI =& get_instance();
		$CI->load->model('suppliers');
		$suppliers_list = $CI->suppliers->supplier_list($limit,$page);
		$i=$page;
		if(!empty($suppliers_list)){	
			foreach($suppliers_list as $k=>$v){$i++;
			   $suppliers_list[$k]['sl']=$i;
			}
		}
		$data = array(
				'title' => 'suppliers List',
				'suppliers_list' => $suppliers_list,
				'links' => $links
			);
		$supplierList = $CI->parser->parse('supplier/supplier',$data,true);
		return $supplierList;
	}
	//Supplier Search Item
	public function supplier_search_item($supplier_id)
	{
		$CI =& get_instance();
		$CI->load->model('suppliers');
		$suppliers_list = $CI->suppliers->supplier_search_item($supplier_id);
		$i=0;
		foreach($suppliers_list as $k=>$v){$i++;
           $suppliers_list[$k]['sl']=$i;
		}
		$data = array(
				'title' => 'Suppliers Search Items',
				'suppliers_list' => $suppliers_list
			);
		$supplierList = $CI->parser->parse('supplier/supplier',$data,true);
		return $supplierList;
	}
	//Sub Category Add
	public function supplier_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('suppliers');
		$data = array(
				'title' => 'Add supplier'
			);
		$supplierForm = $CI->parser->parse('supplier/add_supplier_form',$data,true);
		return $supplierForm;
	}
	public function insert_supplier($data)
	{
		$CI =& get_instance();
		$CI->load->model('suppliers');
        $CI->suppliers->supplier_entry($data);
		return true;
	}
	//supplier Edit Data
	public function supplier_edit_data($supplier_id)
	{
		$CI =& get_instance();
		$CI->load->model('suppliers');
		$supplier_detail = $CI->suppliers->retrieve_supplier_editdata($supplier_id);
		$data=array(
			'supplier_id' 	=> $supplier_detail[0]['supplier_id'],
			'supplier_name' => $supplier_detail[0]['supplier_name'],
			'address' 		=> $supplier_detail[0]['address'],
			'mobile' 		=> $supplier_detail[0]['mobile'],
			'details' 		=> $supplier_detail[0]['details'],
			'status' 		=> $supplier_detail[0]['status']
			);
		$chapterList = $CI->parser->parse('supplier/edit_supplier_form',$data,true);
		return $chapterList;
	}
	//Supplier Details Data
	public function supplier_detail_data($supplier_id)
	{
		$CI =& get_instance();
		$CI->load->model('suppliers');
		$CI->load->model('purchases');
		$supplier_detail = $CI->suppliers->supplier_personal_data($supplier_id);
		$purchases_list = $CI->suppliers->supplier_purchase_data($supplier_id);
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
			'title' => 'Supplier Details',
			'supplier_id' 		=> $supplier_detail[0]['supplier_id'],
			'supplier_name' 	=> $supplier_detail[0]['supplier_name'],
			'supplier_address' 	=> $supplier_detail[0]['address'],
			'supplier_mobile' 	=> $supplier_detail[0]['mobile'],
			'purchase_info' => $purchases_list,
		);
		$chapterList = $CI->parser->parse('supplier/supplier_details',$data,true);
		return $chapterList;
	}
	//Search supplier
	public function supplier_search_list($cat_id,$company_id)
	{
		$CI =& get_instance();
		$CI->load->model('suppliers');
		$category_list = $CI->suppliers->retrieve_category_list();
		$suppliers_list = $CI->suppliers->supplier_search_list($cat_id,$company_id);
		$data = array(
				'title' => 'suppliers List',
				'suppliers_list' => $suppliers_list,
				'category_list' => $category_list
			);
		$supplierList = $CI->parser->parse('supplier/supplier',$data,true);
		return $supplierList;
	}
}
?>
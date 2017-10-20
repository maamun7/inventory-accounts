<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lauthorised_person {
	// Retrieve  Quize List From DB
	public function auth_person_list()
	{
		$CI =& get_instance();
		$CI->load->model('authorised_persons');
		$CI->load->library('occational');
		$authorised_persons_list = $CI->authorised_persons->get_list();
		if(!empty($authorised_persons_list)){	
			$i=0;
			foreach($authorised_persons_list as $k=>$v){$i++;
			   $authorised_persons_list[$k]['sl']=$i;
			}
		}
		$data = array(
				'title' => 'Authorised Persons List',
				'authorised_persons_list' => $authorised_persons_list,
			);
		$personList = $CI->parser->parse('authorised_person/index',$data,true);
		return $personList;
	}
	
	public function add_form()
	{
		$CI =& get_instance();
		$data = array(
			'title' => 'Add authorised person',
		);
		$purchaseForm = $CI->parser->parse('authorised_person/add',$data,true);
		return $purchaseForm;
	}

	public function insert_purchase($data)
	{
		$CI =& get_instance();
		$CI->load->model('authorised_persons');
        $CI->authorised_persons->purchase_entry($data);
		return true;
	}
	 
	public function edit_data($id)
	{
		$CI =& get_instance();
		$CI->load->model('authorised_persons');
		$detail_data = $CI->authorised_persons->get_edit_data($id);
		if(empty($detail_data)){
			$CI->session->set_userdata(array('error_message'=>"There in no data found!"));
			redirect(base_url('cauthorised_person'));
		}

		$data=array(
			'authp_id'			=>	$detail_data[0]['id'],
			'name'				=>	$detail_data[0]['name'],
			'designation'		=>	$detail_data[0]['designation'],
			'mobile_no'			=>	$detail_data[0]['mobile_no'],
			'phone_no'			=>	$detail_data[0]['phone_no']
		);
		$dataList = $CI->parser->parse('authorised_person/edit',$data,true);
		return $dataList;
	}
}
?>
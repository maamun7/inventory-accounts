<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lbank {
	
	public function bank_list()
	{
		$CI =& get_instance();
		$CI->load->model('banks');
		$bank_list = $CI->banks->get_bank_list( );
		$i=0;
		if(!empty($bank_list)){		
			foreach($bank_list as $k=>$v){$i++;
			   $bank_list[$k]['sl']=$i;
			}
		}
		$data = array(
				'title' => 'Bank List',
				'bank_list' => $bank_list
			);
		$bankList = $CI->parser->parse('bank/bank',$data,true);
		return $bankList;
	}
}
?>
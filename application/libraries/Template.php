<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Template {
	var $current_menu = 'home';
	// View Message
	function message_html()
	{
		$CI =& get_instance();
		$CI->load->library('parser');
		
		$message = '';
		$message_class = '';
		$html = '';
		
		if ( $CI->session->userdata('message') != '' )
		{
			$message = $CI->session->userdata('message');
			$message_class = 'alert-success';
		}
		
		if ( $CI->session->userdata('error_message') != '' )
		{
			$message = $CI->session->userdata('error_message');
			$message_class = 'alert-error';
		}else if ( $CI->session->userdata('warning_message') != '' )
		{
			$message = $CI->session->userdata('warning_message');
		}

		$data = array(
					'message' => $message,
					'message_class' => $message_class
				);

		if ( $message != '' )
			$html = $CI->parser->parse('include/message',$data,true);

		$CI->session->unset_userdata('message');
		$CI->session->unset_userdata('error_message');

		return $html;
	}
	//Admin Html View....
	public function full_admin_html_view($content,$sub_menu=''){
	
		$CI =& get_instance();
		$message = $this->message_html();
		$logged_info='';
		$top_menu='';
		
		if ($CI->auth->is_logged())
		{
			$menu_template = 'include/top_menu';
			$logged_data = 'include/admin_loggedin_info';
			//$full_name = $CI->auth->get_full_name();
		
			// parse menu
			$menu_data = array(
					'active' => $this->current_menu
				);
			$log_info = array(
					'email' => $CI->session->userdata('user_name'),
					'logout' => base_url().'admin_dashboard/logout'
				); 
			$top_menu = $CI->parser->parse($menu_template,$menu_data,true);
			$logged_info = $CI->parser->parse($logged_data,$log_info,true);
		}
		//Sub Menu
		if ( $sub_menu != '' )
		{
			// insert empty text to non assigned elments
			foreach($sub_menu as $k=>$sub){
				if(!isset($sub['title']))$sub_menu[$k]['title']='';
				if(!isset($sub['class']))$sub_menu[$k]['class']='';
			}
			$sub_menu = $CI->parser->parse('include/sub_menu', array('sub_menu'=>$sub_menu), true);
		}
		$data = array (
				'logindata' => $logged_info,
				'mainmenu' 	=> $top_menu,
				'sub_menu' 	=> $sub_menu,
				'content' 	=> $content,
				'msg_content' => $message
			);
		$content = $CI->parser->parse('admin_html_template',$data);
	}
	
	
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth {
	//Login....
	public function login($username,$password)
	{
		$CI =& get_instance();
		$CI->load->model('users'); 
		$result = $CI->users->check_valid_user($username,$password);		
        if ($result)
		{
			$key = md5(time());
			$key = str_replace("1", "z", $key);
			$key = str_replace("2", "J", $key);
			$key = str_replace("3", "y", $key);
			$key = str_replace("4", "R", $key);
			$key = str_replace("5", "Kd", $key);
			$key = str_replace("6", "jX", $key);
			$key = str_replace("7", "dH", $key);
			$key = str_replace("8", "p", $key);
			$key = str_replace("9", "Uf", $key);
			$key = str_replace("0", "eXnyiKFj", $key);
			$sid_web = substr($key, rand(0, 3), rand(28, 32));
			
			// codeigniter session stored data			
			$user_data = array(
				'sid_web' 		=> $sid_web,
				'user_id' 		=> $result[0]['user_id'],
				'user_type' 	=> $result[0]['user_type'],
				'user_name' 	=> $result[0]['username']
			);
           $CI->session->set_userdata($user_data);
            return TRUE;
		}else{
			return FALSE;
        }
	}
	
	function check_auth($url='')
	{   
        if($url==''){$url = base_url().'admin_dashboard/login';}
		$CI =& get_instance();
        if (!$CI->auth->is_logged() )
		{   
            redirect($url,'refresh'); exit;
        }
	}
	
	function check_admin_auth($url='')
	{   
        if($url==''){$url = base_url().'admin_dashboard/login';}
		$CI =& get_instance();
        if($this->is_logged())
		{
			if(!$this->is_admin())
			{
				$this->logout();
				$error = "You are not authorized for this part";
				$CI->session->set_userdata(array('error_message'=>$error));
				redirect($url,'refresh'); exit;
			}
        }else{
			$error = "Please Log in to Access !";
			$CI->session->set_userdata(array('error_message'=>$error));
			redirect($url,'refresh'); exit;
		}
	}
	//Check if is logged....
	public function is_logged()
	{
		$CI =& get_instance();
        if($CI->session->userdata('sid_web'))
		{
			return true;
		}		
		return false;
	}
	
	//Check for logged in user is Admin or not.
	public function is_admin()
	{
		$CI =& get_instance();
        $CI->load->model('users');
		$type = $CI->users->check_by_user_id($this->get_user_id());
		
        if ($type[0]['status']==2)
		{
			return true;
		}
		return false;
	}
	
	//Logout....
	public function logout()
	{
		$CI =& get_instance();
		$user_data = array(
				'sid_web' 		=> '',
				'user_id' 		=> '',
				'user_type' 	=> '',
				'user_name' 	=> ''
			);
        $CI->session->unset_userdata($user_data);
		return true;
	}
	
	public function get_user_id()
	{
		$CI =& get_instance();
		return $CI->session->userdata('user_id');
	}	
	public function get_user_email_id()
	{
		$CI =& get_instance();
		return $CI->session->userdata('user_name');
	}
	
	// checking user has role and return role id
    private function has_role($user_id){
        $CI =& get_instance();
        $CI->load->model('users');
        $role = $CI->users->get_by_user_id($user_id);
        $role_id = $role[0]['role_id'];
        return $role_id;
    }

    // if user has desired task permission
    function check_permission($slug, $redirect=true, $user_id = 0)
    {
        $CI =& get_instance();
		$CI->load->model('users');
        if ( $user_id == 0 )
        {
            $user_id = $this->get_user_id();
        }

        // if user has the role and permission
        // then return true
        // else
        // return to dashbord or the referrer and show 'You dont have permission to access this page'

        $role_id = $this->has_role($user_id);
        
        // if Administrator role
        if ( $role_id === '1')
            return true;
        $res = $CI->users->get_by_role_id_and_slug($role_id,$slug);
        if( count($res) > 0){
            return true;
        }else{
            if( $redirect )
            {
                $CI->session->set_userdata(array('error_message'=>"You don't have permission to access this page!"));
                redirect(base_url().'admin_dashboard','refresh');
            }
            else
                return false;
            //$CI->output->set_header("Location: ".base_url().'admin/dashboard', TRUE, 302);
        }
    }

}
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function count_user()
	{
		$this->db->select(
						'x.user_id,x.first_name,x.last_name,'
						.'y.username,y.user_type,y.is_active,y.can_login,'
						.'z.role_id,z.role'
						);
		$this->db->from('users x');
		$this->db->join('user_login y','y.user_id=x.user_id','left');
		$this->db->join('user_role_relation p','p.user_id=x.user_id','left');
		$this->db->join('roles z','p.role_id=z.role_id','left');
		$query = $this->db->get();
		return $query->num_rows();		
	}
	
	public function get_user_list($limit,$page)
	{
		$this->db->select(
						'x.user_id,x.first_name,x.last_name,'
						.'y.username,y.user_type,y.is_active,y.can_login,'
						.'z.role_id,z.role'
						);
		$this->db->from('users x');
		$this->db->join('user_login y','y.user_id=x.user_id','left');
		$this->db->join('user_role_relation p','p.user_id=x.user_id','left');
		$this->db->join('roles z','p.role_id=z.role_id','left');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	public function insert_basic_info($basic_data)
	{
		$this->db->insert('users',$basic_data);
        return $this->db->insert_id();
	}
	
	public function insert_login_info($login_data)
	{
		$this->db->insert('user_login',$login_data);
        return true;
	}
	
	public function insert_user_role_relation($role_relation)
	{
		$this->db->insert('user_role_relation',$role_relation);
        return true;
	}
	public function retrieve_edit_data($user_id)
	{
		$this->db->select('x.*,y.*,z.*');
		$this->db->from('users x');
		$this->db->join('user_login y','y.user_id=x.user_id','left');
		$this->db->join('user_role_relation p','p.user_id=x.user_id','left');
		$this->db->join('roles z','p.role_id=z.role_id','left');
		$this->db->where('x.user_id',$user_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	function check_valid_user($username,$password)
	{ 	
		$password = md5("matroak".$password);
        $this->db->where(array('username'=>$username,'password'=>$password,'is_active'=>'1','can_login'=>'1','user_type !='=>'1'));
		$query = $this->db->get('user_login');
		$result =  $query->result_array();		
		if (count($result) == '1')
		{
			$user_id = $result[0]['user_id'];
			$this->db->select('a.*,b.*');
			$this->db->from('user_login a');
			$this->db->join('users b','b.user_id = a.user_id');
			$this->db->where('a.user_id',$user_id);
			$query = $this->db->get();
			return $query->result_array();
		}
		return false;
	}
	
	public function update_basic_info($basic_data,$user_id)
	{
		$this->db->where('user_id',$user_id);
		$this->db->update('users',$basic_data);
        return true;
	}
	
	public function update_login_info($login_data,$user_id)
	{
		$this->db->where('user_id',$user_id);
		$this->db->update('user_login',$login_data);
        return true;
	}
	
	public function update_user_role_relation($role_relation,$user_id)
	{
		$this->db->where('user_id',$user_id);
		$this->db->update('user_role_relation',$role_relation);
        return true;
	}
		
	public function get_role_list()
	{
		$this->db->select('role_id,role');
		$this->db->from('roles');
		$this->db->where('status','1');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	public function profile_edit_data()
	{
		$user_id = $this->session->userdata('user_id');
		$this->db->select('a.*,b.username');
		$this->db->from('users a');
		$this->db->join('user_login b','b.user_id = a.user_id');
		$this->db->where('a.user_id',$user_id);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Update Profile
	public function profile_update()
	{
		$user_id = $this->session->userdata('user_id');
		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		//$user_name = $this->input->post('user_name');
		
		$this->db->set('first_name',$first_name);
		$this->db->set('last_name',$last_name);
		$this->db->where('user_id', $user_id);
		$this->db->update('users');
	}
	//Change Password
	public function change_password($email,$old_password,$new_password)
	{
		$user_name = md5("matroak".$new_password);
		$password = md5("matroak".$old_password);
        $this->db->where(array('username'=>$email,'password'=>$password,'status'=>1));
		$query = $this->db->get('user_login');
		$result =  $query->result_array();
		
		if (count($result) == 1)
		{	
			$this->db->set('password',$user_name);
			$this->db->where('password',$password);
			$this->db->where('username',$email);
			$this->db->update('user_login');
			return true;
		}
		return false;
	}

	function get_by_user_id($user_id)
	{
		$this->db->where('user_id',$user_id);
        $q = $this->db->get('user_role_relation');
        return $q->result_array();
	}

	function check_by_user_id($user_id)
	{
		$this->db->where('user_id',$user_id);
        $q = $this->db->get('users');
        return $q->result_array();
	}
	
	function get_by_role_id_and_slug($role_id,$slug)
	{ // slug/$role_id/$slug
        $this->table = 'role_permission_relation';
        $this->db->from($this->table.' as r');
        $this->db->where("r.role_id",$role_id);
        $this->db->like("r.permission",$slug);
        $query = $this->db->get();
        return $query->result_array();
	}

}
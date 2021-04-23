<?php
class Logins extends CI_Model 
{
	public $table = 'logins';
	public $primary_key = 'id';
	
	public function __construct()
	{
	}
	
	function read_data_specific($id, $field)
	{
		$db = $this->db;
		$db->select($field);
		$db->where($this->primary_key,$id);
		$db->limit(1);
		$q = $db->get($this->table)->row()->$field;
		return $q;
	}

	function read_data_by_column_value($field, $value)
	{
		$db = $this->db;
		$db->select('*');
		$db->where($field,$value);
		$db->where('active','1');
		$db->limit(1);
		$q = $db->get($this->table)->row();
		return $q;
	}

	function read_data_join($id)
	{
	}

	function read_data($id)
	{
		$db = $this->db;
		$db->select('*');
		$db->where($this->primary_key,$id);
		$db->limit(1);
		$q = $db->get($this->table)->row();
		return $q;
	}

	function list_data()
	{
		$db = $this->db;
		$db->select('*');
		$db->where('active','1');
		$q = $db->get($this->table)->result();
		return $q;
	}

	function check_data($id, $find_opt=array())
	{
		$db = $this->db;
		$db->select('id');
		$db->where('active','1');

        if( !empty($id) || $id > 0 )
        {
            $db->where('user_id != ', $id);
        }

        foreach ( $find_opt as $key => $val )
    	{
    		$db->where($key, $val);
    	}

        $db->limit(1);
        $q = $db->get($this->table)->row();
		return $q;
	}

	function create_data($data)
	{
		$db = $this->db;
		$q = $db->insert($this->table, $data);
		$q = $db->insert_id();

		return $q;
	}

	function create_role($data)
	{
		$db = $this->db;
		$q = $db->insert('users_role', $data);
		$q = $db->insert_id();

		return $q;
	}

	function create_data_multiple($data)
	{
		$db = $this->db;
		$q = $db->insert_batch($this->table, $data);
		$q = $db->insert_id();

		return $q;
	}

	function update_data($id, $data)
	{
		$db = $this->db;
		$db->where($this->primary_key, $id);
		$db->update($this->table, $data);
		$q = $db->affected_rows();

		return $q;
	}

	function update_role($id, $data)
	{
		$db = $this->db;
		$db->where($this->primary_key, $id);
		$db->update('users_role', $data);
		$q = $db->affected_rows();

		return $q;
	}

	function delete_data($id)
	{
		$data = array(
						"updated"=>getDateTime(),
						"active"=>'0',
					);

		$db = $this->db;
		$q = $db->where_in($this->primary_key, $id);
		$q = $db->update($this->table, $data);

		return $q;
	}

	function delete_data_by_column_value($field, $value)
	{
		$data = array(
						"updated"=>getDateTime(),
						"active"=>'0',
					);
		
		$db = $this->db;
		$q = $db->where_in($field, $value);
		$q = $db->update($this->table, $data);

		return $q;
	}
	
	function is_login()
	{
		if ( !empty($this->session->curr_login_id) && $this->session->curr_login_id != '' )
		{
			// nothing to do
		}
		else 
		{
			$text = '<div class="alert alert-warning">
                        <button class="close" data-close="alert"></button>
                        <span> Please login! </span>
                     </div>';
            $this->session->set_flashdata('login_result', $text);
            redirect('login');
            die();
		}
	}
	
	function login($login_type, $user_name, $user_password, $user_type, $user_type_id=array())
	{
		$db = $this->db;
		$db->select('a.id, a.login_type_id, a.user_name, a.login_now, a.first_login, a.last_login, b.id AS user_id, b.user_type_id, b.full_name, b.user_type');
		$db->from($this->table.' a');
		$db->join('users b', 'b.id = a.user_id', 'LEFT');
		$db->where('a.login_type_id',$login_type);
		$db->where('a.user_name',$user_name);
		$db->where('a.user_password',encryptor('encrypt',$user_password));

		if ( is_array($user_type_id) && count($user_type_id) > 0 )
		{
			$db->where_in('b.user_type_id',$user_type_id);
		}

		$db->where('a.active','1');
		$db->where('b.active','1');
		$db->limit(1);
		$q = $db->get()->row();
		// echo $this->db->last_query();
		return $q;
	}
}
?>
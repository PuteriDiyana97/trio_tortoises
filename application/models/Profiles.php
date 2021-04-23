<?php
class Profiles extends CI_Model 
{
	public $table = 'users';
	public $primary_key = 'id';

	public function __construct()
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

	function read_data_login($id)
	{
		$db = $this->db;
		$db->select('*');
		$db->where($this->primary_key,$id);
		$db->limit(1);
		$q = $db->get('logins')->row();
		return $q;
	}

	public function insert($data)
    {
        $q = $this->db->insert($this->table, $data);
        $insert_id = $this->db->insert_id();

        return $insert_id;
    }

	function update_data($id, $data)
	{
		$db = $this->db;
		$db->where($this->primary_key, $id);
		$db->update($this->table, $data);
		$q = $db->affected_rows();

		return $q;
	}

    function update_logins($id, $data)
    {
        $db = $this->db;
		$db->select('user_password,user_name');
		$db->from('logins');
		$db->where('user_id',$id);
		$db->limit(1);
		$q = $db->get()->row();

        return $q;
    }


	public function detail($id)
    {

        $db = $this->db;
        $db->select('*');
        $db->from($this->table);
        $db->where('id', $id);
        $q = $db->get()->row();

        return $q;

    }

}
?>
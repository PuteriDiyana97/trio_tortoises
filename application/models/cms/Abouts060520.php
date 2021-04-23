<?php
class Abouts extends CI_Model 
{
	public $table = 'abouts';
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
		$db = $this->db;
		$db->select('a.*');
		$db->from($this->table.' a');
		$db->where('a.'.$this->primary_key,$id);
		$db->limit(1);
		$q = $db->get()->row();
		return $q;
	}

	function read_data()
	{
		$db = $this->db;
		$db->select('*');
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

	function create_data($data)
	{
		$db = $this->db;
		$q = $db->insert($this->table, $data);
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

	function update_data($data)
	{
		// $db = $this->db;
		// $db->where($this->primary_key, $id);
		// $db->update($this->table, $data);
		// $q = $db->affected_rows();

		// return $q;
		$q = $this->db->update($this->table, $data);

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

	// ======================= DATATABLE SERVER SIDE PROCESSING =========================

    var $column_order = array(null, null, null); // field yang ada di table
    var $column_search = array(); // field yang diizinkan untuk pencarian 
    var $order = array('UPPER(a.id)' => 'ASC'); // default order 

    private function _get_datatables_query()
    {
    	$db = $this->db;
    	$db->select('a.*');
    	$db->from($this->table.' a');
    	$db->where('a.active', '1');
    }

    function get_datatables()
    {
    	$db = $this->db;
        $this->_get_datatables_query();
        if ( $_POST['length'] != -1 )
        $db->limit($_POST['length'], $_POST['start']);
        $query = $db->get();
        // echo $db->last_query();
        return $query->result();
    }
 
    function count_filtered()
    {
    	$db = $this->db;
        $this->_get_datatables_query();
        $query = $db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
    	$db = $this->db;
        $db->from($this->table.' a');
        $db->where('a.active', '1');
        $c = $db->count_all_results();
        // echo $db->last_query();
        return $c;
    }
}
?>
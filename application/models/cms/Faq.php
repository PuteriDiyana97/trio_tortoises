<?php
class Faq extends CI_Model 
{
	public $table = 'faq';
	public $primary_key = 'id';

	public function __construct()
	{
	}

	function read_data($id)
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
        //echo json_encode($data);
		$db = $this->db;
		$db->update($this->table, $data);
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

	// ======================= DATATABLE SERVER SIDE PROCESSING =========================

    var $column_order = array(null, 'description', 'created', 'updated', null); // field yang ada di table
    var $column_search = array('description'); // field yang diizinkan untuk pencarian 
    var $order = array('UPPER(description)' => 'ASC'); // default order

    private function _get_datatables_query()
    {
    	$filter_description = $this->input->post('filter_description');

    	$db = $this->db;
    	$db->select('*');
    	$db->from($this->table);
    	$db->where('active', '1');

		if ( !empty($filter_description) ) 
		{
    		$db->like('description', $filter_description, 'both');
		}

		$i = 0;
     
        foreach ($this->column_search as $item) // looping awal
        {
            if ($_POST['search']['value'] ) // jika datatable mengirimkan pencarian dengan method POST
            {
                 
                if ( $i===0 ) // looping awal
                {
                    $db->group_start(); 
                    $db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $db->or_like($item, $_POST['search']['value']);
                }
 
                if ( count($this->column_search) - 1 == $i ) 
                    $db->group_end(); 
            }
            $i++;
        }
         
        if ( isset($_POST['order']) ) 
        {
            $db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if ( isset($this->order) )
        {
            $order = $this->order;
            $db->order_by(key($order), $order[key($order)]);
        }
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
<?php
class Store_Locations extends CI_Model 
{
	public $table = 'store_locations';
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

	function list_data()
	{
		$db = $this->db;
		$db->select('*');
		$db->where('active','1');
		$q = $db->get($this->table)->result();
		return $q;
	}

	public function insert($data)
    {
        $q = $this->db->insert($this->table, $data);
        $insert_id = $this->db->insert_id();

        return $insert_id;
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

	public function detail($id)
    {

        $db = $this->db;
        $db->select('*');
        $db->from($this->table);
        $db->where('id', $id);
        $q = $db->get()->row();

        return $q;

    }

	// ======================= DATATABLE SERVER SIDE PROCESSING =========================

    var $column_order = array(null, 'store_name', 'store_address', 'open_time', 'close_time', null); // field yang ada di table
    var $column_search = array('store_name', 'store_address'); // field yang diizinkan untuk pencarian 
    var $order = array('UPPER(store_name)' => 'ASC'); // default order

    private function _get_datatables_query()
    {
    	$filter_name = $this->input->post('filter_name');

    	$db = $this->db;
    	$db->select('*');
    	$db->from($this->table);
    	$db->where('active', '1');

		if ( !empty($filter_name) ) 
		{
    		$db->like('store_name', $filter_name);
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
    	$curr_user_id = $this->session->userdata('curr_user_id');

    	$db = $this->db;
        $db->from($this->table.' a');
        $db->where('a.active', '1');
        $c = $db->count_all_results();
        // echo $db->last_query();
        return $c;
    }
}
?>
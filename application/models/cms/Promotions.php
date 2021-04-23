<?php
class Promotions extends CI_Model 
{
	public $table = 'promotions';
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
    //for promotion category
	function list_data()
	{
		$db = $this->db;
		$db->select('*');
        $db->from('promotion_categories');
        $db->order_by('priority_no', 'ASC');
		$db->where('active','1');
		$query = $this->db->get();
        return $query->result();
	}

	function insert($data)
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

    var $column_order = array(null, 'a.title', 'b.category', 'a.start_date', 'a.expiry_date', null); // field yang ada di table
    var $column_search = array('a.title'); // field yang diizinkan untuk pencarian 
    var $order = array('UPPER(a.title)' => 'ASC'); // default order

    private function _get_datatables_query()
    {
        $filter_title = $this->input->post('filter_title');
        $start_date   = $this->input->post('filter_date_start');
        $end_date     = $this->input->post('filter_date_end');
    	
    	$db = $this->db;
    	$db->select('a.*, b.category');
    	$db->from($this->table. ' a');
        $db->join('promotion_categories b', '(b.id = a.promotion_category_id)', 'LEFT');
    	$db->where('a.active', '1');

		if ( !empty($filter_title) ) 
		{
    		$db->like('title', $filter_title, 'both');
		}

        if(!empty($start_date))
        {
            $filter_date_start_temp = str_replace('/', '-', $start_date);

            $db->where('DATE(a.start_date) >=',date("Y-m-d", strtotime($filter_date_start_temp)));
        }
         
        if(!empty($end_date))
        {
            $filter_date_end_temp = str_replace('/', '-', $end_date);

            $db->where('DATE(a.expiry_date) <=',date("Y-m-d", strtotime($filter_date_end_temp)));
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
        $db->from($this->table);
        $db->where('active', '1');
        $c = $db->count_all_results();
        // echo $db->last_query();
        return $c;
    }
}
?>
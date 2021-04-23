<?php
class Birthday_vouchers extends CI_Model 
{
	public $table = 'data_voucher';
	public $primary_key = 'id';

	public function __construct()
	{
	}

	function read_data($id)
	{
		$db = $this->db;
		$db->select('*,MONTH(end_date) as month');
		$db->where($this->primary_key,$id);
		$db->limit(1);
		$q = $db->get($this->table)->row();
		return $q;
	}

	function insert($data)
	{
		$q = $this->db->insert($this->table, $data);
        $insert_id = $this->db->insert_id();

        return $insert_id;
	}

    function list_data()
    {
        $db = $this->db;
        $db->select('*');
        $db->where('active','1');
        $q = $db->get($this->table)->row();
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

	// ======================= DATATABLE SERVER SIDE PROCESSING =========================

    var $column_order = array(null, 'voucher_name', 'voucher_value', 'month', null); // field yang ada di table
    var $column_search = array('voucher_name','start_date', 'end_date'); // field yang diizinkan untuk pencarian 
    var $order = array('UPPER(voucher_name)' => 'ASC'); // default order

    private function _get_datatables_query()
    {
    	$filter_name = $this->input->post('filter_name');
        $filter_month  = $this->input->post('filter_month');

    	$db = $this->db;
    	$db->select('id,voucher_name, voucher_value, MONTHNAME(end_date) as month');
    	$db->from($this->table);
    	$db->where('active', '1');
        $db->where('voucher_type', '1');

        if(!empty($filter_month))
        {

            $db->where('MONTH(end_date) =',$filter_month);
        }

		if ( !empty($filter_name) ) 
		{
    		$db->like('voucher_name', $filter_name, 'both');
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
        $db->select('*');
        $db->from($this->table);
        $db->where('active', '1');
        $db->where('voucher_type', '1');
        $c = $db->count_all_results();
        // echo $db->last_query();
        return $c;
    }
}
?>
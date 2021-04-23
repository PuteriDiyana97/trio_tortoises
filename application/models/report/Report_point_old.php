<?php
class Report_point extends CI_Model 
{
	public $table = 'data_customer';
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

	public function detail($id)
    {

        $db = $this->db;
        $db->select('a.*');
        $db->from($this->table . ' a');
        $db->where('id', $id);
        $db->where('active','1');
        $q = $db->get()->row();

        return $q;

    }

	// ======================= DATATABLE SERVER SIDE PROCESSING =========================

     var $column_order = array(null, 'a.contact_no', 'a.name', '', '', 'c.trxtotal', 'c.trxvalue', ''); // field yang ada di table
    var $column_search = array('a.contact_no'); // field yang diizinkan untuk pencarian 
    var $order = array('UPPER(name)' => 'ASC'); // default order

    private function _get_datatables_query()
    {
        $filter_id = $this->input->post('filter_id');
        
        $db = $this->db;
        $db->select_sum('c.trxtotal');
        $db->select_sum('b.trxvalue');
        $db->group_by('c.sbclient_id');
        $db->select('a.*');
        $db->from($this->table. ' a');
        $db->join('data_voucher_cust b', '(a.contact_no = b.contact_no)', 'left');
        $db->join('data_sales_transaction c', '(a.contact_no = c.sbclient_id)', 'left');
        $db->where('a.active', '1');

        if ( !empty($filter_id) ) 
        {
            $db->like('a.contact_no', $filter_id);
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

    public function get_data_export() //$filter_date=array()
    {
        // $filter_date_start = '';
        // $filter_date_end = '';
       
        // if (count($filter_date) > 0) {
        //     $filter_date_start = $filter_date['filter_date_start'];
        //     $filter_date_end   = $filter_date['filter_date_end'];

        //     if ( !empty($filter_date_start) && !empty($filter_date_end) )
        //     {
        //         $filter_date_start_temp = str_replace('/', '-', $filter_date_start);
        //         $filter_date_start = date('Y-m-d', strtotime($filter_date_start_temp));

        //         $filter_date_end_temp = str_replace('/', '-', $filter_date_end);
        //         $filter_date_end = date('Y-m-d', strtotime($filter_date_end_temp));

        //         $date = "AND (a.created >='" . $filter_date_start . "' AND a.created<='" . $filter_date_end . "')";
        //     }
        //     else
        //     {
        //         $date = '';
        //     }
        // } else {
        //     $date = '';
        // }

        // $filter = '';

        $db = $this->db;
        $db->select_sum('c.trxtotal');
        $db->select_sum('b.trxvalue');
        $db->group_by('c.sbclient_id');
        $db->select('a.*');
        $db->from($this->table. ' a');
        $db->join('data_voucher_cust b', '(a.contact_no = b.contact_no)', 'left');
        $db->join('data_sales_transaction c', '(a.contact_no = c.sbclient_id)', 'left');
        $db->where('a.active', '1');
        $q = $db->get($this->table)->result();
        return $q;
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
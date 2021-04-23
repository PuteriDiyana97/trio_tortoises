<?php
class Report_vouchers extends CI_Model 
{
 	public $table = 'data_customer';
    public $primary_key = 'id';

    public function __construct()
    {
       
    }

    // ======================= DATATABLE SERVER SIDE PROCESSING =========================

     var $column_order = array(null, 'a.contact_no', 'a.name', '', 'c.claim_date', 'b.voucher_name', 'b.voucher_value', 'c.redeem_date', 'd.outlet,b.exchange_point'); // field yang ada di table
    var $column_search = array('a.contact_no, a.name'); // field yang diizinkan untuk pencarian 
    var $order = array('UPPER(a.name)' => 'ASC'); // default order

    private function _get_datatables_query()
    { 
        $filter_id = $this->input->post('filter_id');
        $filter_name = $this->input->post('filter_name');
        $filter_outlet_code = $this->input->post('filter_outlet_code');

        $db = $this->db;
        $db->select('a.*, c.claim_date,c.redeem_date,d.outlet,b.voucher_name,b.voucher_value,b.exchange_point');
        $db->from($this->table. ' a');
        $db->join('data_voucher_cust c', '(a.contact_no = c.contact_no)', 'left');
        $db->join('data_sales_transaction_detail d', '(a.contact_no = d.sbclient_id)', 'left');
        $db->join('data_voucher b', '(c.voucher_id = b.id)', 'left');
        $db->where('a.active', '1');

        if ( !empty($filter_id) ) 
        {
            $db->like('a.contact_no', $filter_id);
        }

        if ( !empty($filter_name) ) 
        {
            $db->like('a.name', $filter_name);
        }
        if ( !empty($filter_outlet_code) ) 
        {
            $db->like('a.outlet', $filter_outlet_code);
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
        $db = $this->db;
        $db->select('a.*, c.claim_date,c.redeem_date,d.outlet,b.voucher_name,b.voucher_value,b.exchange_point');
        $db->from($this->table. ' a');
        $db->join('data_voucher_cust c', '(a.contact_no = c.contact_no)', 'left');
        $db->join('data_sales_transaction_detail d', '(a.contact_no = d.sbclient_id)', 'left');
        $db->join('data_voucher b', '(c.voucher_id = b.id)', 'left');
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
<?php
class Report_vouchers extends CI_Model 
{
 	public $table = 'data_customer';
    public $primary_key = 'id';

    public function __construct()
    {
       
    }

    // ======================= DATATABLE SERVER SIDE PROCESSING =========================

    var $column_order = array(null, 'a.contact_no', 'c.country', 'b.voucher_name', 'b.voucher_type'); // field yang ada di table
    var $column_search = array('a.contact_no', 'c.country', 'b.voucher_name', 'b.voucher_type'); // field yang diizinkan untuk pencarian 
    var $order = array('UPPER(b.voucher_name)' => 'ASC'); // default order

    private function _get_datatables_query()
    {  
        $filter_id = $this->input->post('filter_id');
        $filter_vname = $this->input->post('filter_vname');
        $filter_nationality = $this->input->post('filter_nationality');
        $start_date   = $this->input->post('filter_date_start');
        $end_date     = $this->input->post('filter_date_end');

        $db = $this->db;
        $db->select('a.voucher_id, b.id, a.contact_no, c.name,b.voucher_name, b.voucher_type, c.country, a.redeem_date, MAX(a.redeem_date) as redeem_date');
        $db->from('data_voucher_cust a');
        $db->join('data_voucher b', 'b.id = a.voucher_id', 'LEFT');
        $db->join('data_customer c', 'c.contact_no = a.contact_no', 'LEFT');
        $db->where('a.redeem_date = a.redeem_date');
        $db->where('c.active',1);
        $db->group_by('a.redeem_date');

        if ( !empty($filter_id) ) 
        {
            $db->like('a.contact_no', $filter_id);
        }

         if ( !empty($filter_vname) ) 
        {
            $db->like('b.voucher_name', $filter_vname);
        }

        if ( $filter_nationality == 'Malaysia') 
        {
             $db->like('c.country', 'Malaysia');
        } 
        else if ($filter_nationality == 'Singapore') 
        {
            $db->like('c.country', 'Singapore');     
        }
        else if ($filter_nationality == 'Indonesia') 
        {
            $db->like('c.country', 'Indonesia');     
        }

        if(!empty($start_date))
        {
            $filter_date_start_temp = str_replace('/', '-', $start_date);

            $db->where('DATE(a.redeem_date) >=',date("Y-m-d", strtotime($filter_date_start_temp)));
        }
         
        if(!empty($end_date))
        {
            $filter_date_end_temp = str_replace('/', '-', $end_date);

            $db->where('DATE(a.redeem_date) <=',date("Y-m-d", strtotime($filter_date_end_temp)));
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

    public function get_data_export($filter_date=array())
    {
        $filter_date_start = '';
        $filter_date_end = '';
       
        if (count($filter_date) > 0) {
            $filter_date_start = $filter_date['filter_date_start'];
            $filter_date_end   = $filter_date['filter_date_end'];

            if ( !empty($filter_date_start) && !empty($filter_date_end) )
            {
                $filter_date_start_temp = str_replace('/', '-', $filter_date_start);
                $filter_date_start = date('Y-m-d', strtotime($filter_date_start_temp));

                $filter_date_end_temp = str_replace('/', '-', $filter_date_end);
                $filter_date_end = date('Y-m-d', strtotime($filter_date_end_temp));

                $date = "AND (DATE(a.redeem_date) >='" . $filter_date_start . "' AND DATE(a.redeem_date) <='" . $filter_date_end . "')";
            }
            else
            {
                $date = '';
            }
        } else {
            $date = '';
        }

        $db = "
        SELECT a.voucher_id, b.id, a.contact_no, c.name,b.voucher_name, b.voucher_type, c.name, c.country, a.redeem_date
        FROM data_voucher_cust a
        LEFT JOIN data_voucher b ON b.id = a.voucher_id
        LEFT JOIN data_customer c ON c.contact_no = a.contact_no
        WHERE c.active = 1
        AND a.redeem_date = a.redeem_date ".$date;

        $q = $this->db->query($db)->result();
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
        $db->select('a.voucher_id, b.id, a.contact_no, c.name,b.voucher_name, b.voucher_type, c.country, a.redeem_date, MAX(a.redeem_date)');
        $db->from('data_voucher_cust a');
        $db->join('data_voucher b', 'b.id = a.voucher_id', 'LEFT');
        $db->join('data_customer c', 'c.contact_no = a.contact_no', 'LEFT');
        $db->where('a.redeem_date = a.redeem_date');
        $db->where('c.active',1);
        $db->group_by('a.redeem_date');
        $c = $db->count_all_results();
        // echo $db->last_query();
        return $c;
    }
  
}
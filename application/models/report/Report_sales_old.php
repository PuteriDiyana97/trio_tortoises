<?php
class Report_sales extends CI_Model 
{
 	public $table = 'data_customer';
    public $primary_key = 'id';

    public function __construct()
    {
       
    }

    // ======================= DATATABLE SERVER SIDE PROCESSING =========================

     var $column_order = array(null, 'a.contact_no', 'a.name', 'b.trxtotal', '', '','', '', '',''); // field yang ada di table
    var $column_search = array('a.contact_no'); // field untuk pencarian 
    var $order = array('UPPER(a.name)' => 'ASC'); // default order

    private function _get_datatables_query()
    { 
        $filter_id = $this->input->post('filter_id');
        //0:redeem(used) 1:claim

        $db = $this->db;
        
        $db->select(' a.id, a.contact_no, b.sbclient_id, a.name, ,e.total_voucher_value_redeem, s.total_value_redeem');
        $db->select_sum('b.trxtotal');
        $db->select('count(b.sbclient_id) AS visit_count');
        $db->select_min('b.trxtotal', 'min_sales');
        $db->select_max('b.trxtotal', 'max_sales');
        $db->select_avg('b.trxtotal', 'avg_sales');
        $db->from($this->table. ' a');
        $db->join('data_sales_transaction b', '(b.sbclient_id = a.contact_no)', 'LEFT');
        $db->join('(SELECT contact_no, SUM(trxvalue) AS total_voucher_value_redeem, 
                    COUNT(contact_no) AS total_voucher_redeem 
                     FROM data_voucher_cust 
                     WHERE voucher_status = 1
                     GROUP BY contact_no 
                   ) AS e',' (e.contact_no = a.contact_no)','LEFT');
        $db->join('(SELECT contact_no, SUM(trxvalue) AS total_value_redeem, 
                COUNT(contact_no) AS total_voucher_redeem 
                 FROM data_voucher_cust 
                 WHERE voucher_status = 0
                 GROUP BY contact_no 
               ) AS s',' (s.contact_no = a.contact_no)','LEFT');
        
        $db->where('a.active', '1');
        $db->group_by('a.contact_no');

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

  //       $db = "
		// SELECT s.staff_code, b.staff_name, b.department,b.division, b.occupation_desc AS position, a.created,
		// CASE
		//     WHEN s.approval_1 != '' THEN CONCAT(app1.staff_name, ' (', s.approval_1, ')')
		//     ELSE ''
		// END AS manager_level_1,
		// CASE
		//     WHEN s.approval_2 != '' THEN CONCAT(app2.staff_name, ' (', s.approval_2, ')')
		//     ELSE ''
		// END AS manager_level_2,
		// CASE
		//     WHEN a.status_id IS NULL THEN 'PENDING'
		//     ELSE 'SUBMITTED'
		// END AS status_submission,
		// CASE
		//     WHEN a.status_id = 0 THEN 'PENDING'
		//     WHEN a.status_id = 1 THEN 'APPROVED'
		//     WHEN a.status_id = 2 THEN 'REJECTED'
  //           WHEN a.status_id = 3 THEN 'AMENDMENT'
  //           WHEN a.status_id = 4 THEN 'AMENDMENT REQUEST'
		//     ELSE 'PENDING'
		// END AS status_approval
		// FROM senhengcom_management.staff_approval_level s
		// LEFT JOIN senhengcom_management.hr_employee_details app1 ON app1.staff_code = s.approval_1
		// LEFT JOIN senhengcom_management.hr_employee_details app2 ON app2.staff_code = s.approval_2
		// LEFT JOIN pms.submission a ON a.staff_code = s.staff_code
		// LEFT JOIN senhengcom_management.hr_employee_details b ON b.staff_code = s.staff_code
		// WHERE s.active = 1
		// AND s.staff_code NOT LIKE '%cloone%'". $date;

        $db = $this->db;
        
        $db->select(' a.id, a.contact_no, b.sbclient_id, a.name, ,e.total_voucher_value_redeem, s.total_value_redeem');
        $db->select_sum('b.trxtotal');
        $db->select('count(b.sbclient_id) AS visit_count');
        $db->select_min('b.trxtotal', 'min_sales');
        $db->select_max('b.trxtotal', 'max_sales');
        $db->select_avg('b.trxtotal', 'avg_sales');
        $db->from($this->table. ' a');
        $db->join('data_sales_transaction b', '(b.sbclient_id = a.contact_no)', 'LEFT');
        $db->join('(SELECT contact_no, SUM(trxvalue) AS total_voucher_value_redeem, 
                    COUNT(contact_no) AS total_voucher_redeem 
                 FROM data_voucher_cust 
                 WHERE voucher_status = 1
                 GROUP BY contact_no ) AS e',' (e.contact_no = a.contact_no)','LEFT');
        $db->join('(SELECT contact_no, SUM(trxvalue) AS total_value_redeem, 
                    COUNT(contact_no) AS total_voucher_redeem 
                    FROM data_voucher_cust 
                    WHERE voucher_status = 0
                    GROUP BY contact_no) AS s',' (s.contact_no = a.contact_no)','LEFT');
        
        $db->where('a.active', '1');
        $db->group_by('a.contact_no');


  //       $db = $this->db;
		// $db->select('*');
		// $db->where('active','1');
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
        $db->select_sum('b.trxtotal');
        $db->group_by('b.sbclient_id');
        $db->select('a.*');
        $db->from($this->table. ' a');
        $db->join('data_sales_transaction b', '(b.sbclient_id = a.contact_no)', 'left');
        $db->join('data_sales_transaction_detail c', '(b.id = c.sales_transaction_id)', 'left');
        $db->where('a.active', '1');
        $c = $db->count_all_results();
        // echo $db->last_query();
        return $c;
    }
  
}
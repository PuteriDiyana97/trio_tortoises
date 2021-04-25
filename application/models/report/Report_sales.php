<?php
class Report_sales extends CI_Model 
{
 	public $table = 'data_customer';
    public $primary_key = 'id';

    public function __construct()
    {
       
    }

    // ======================= DATATABLE SERVER SIDE PROCESSING =========================

     var $column_order = array(null, 'a.contact_no', 'a.name', 'a.country', 'd.deduct_points'); // field yang ada di table
    var $column_search = array('a.contact_no', 'a.name', 'a.country', 'd.deduct_points'); // field untuk pencarian 
    var $order = array('UPPER(a.name)' => 'ASC'); // default order

    private function _get_datatables_query()
    { 
        $filter_id = $this->input->post('filter_id');
        $start_date   = $this->input->post('filter_date_start');
        $end_date     = $this->input->post('filter_date_end');
        //0:redeem(used) 1:claim

        $db = $this->db;
        $db->select('a.id, a.name, a.contact_no, a.created, a.country, a.active, a.customer_type, d.deduct_points');
        $db->from($this->table. ' a');
        //total deduct point
         $db->join('(SELECT contact_no, SUM(points) AS deduct_points, 
                COUNT(contact_no) AS minus_points
                     FROM data_customer_points 
                     WHERE point_type = 0
                     GROUP BY contact_no 
                   ) AS d',' (d.contact_no = a.contact_no)','LEFT');
         $db->where('a.active',1);

        if ( !empty($filter_id) ) 
        {
            $db->like('a.contact_no', $filter_id);
        }

        if(!empty($start_date))
        {
            $filter_date_start_temp = str_replace('/', '-', $start_date);
            $start_date = date('Y-m-d', strtotime($filter_date_start_temp));

            $db->where('DATE(a.created) >=',date("Y-m-d", strtotime($start_date)));
        }
         
        if(!empty($end_date))
        {
            $filter_date_end_temp = str_replace('/', '-', $end_date);
            $end_date = date('Y-m-d', strtotime($filter_date_end_temp));

            $db->where('DATE(a.created) <=',date("Y-m-d", strtotime($end_date)));
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

                $date = "AND (DATE(a.created) >='" . $filter_date_start . "' AND DATE(a.created) <='" . $filter_date_end . "')";
            }
            else
            {
                $date = '';
            }
        } else {
            $date = '';
        }

        $db = "
        SELECT a.id, a.contact_no, a.country, a.name, d.deduct_points, a.created,
        CASE
            WHEN a.country = 'Indonesia' THEN 'INDONESIAN'
            WHEN a.country = 'Malaysia'  THEN 'MALAYSIAN'
            WHEN a.country = 'Singapore' THEN 'SINGAPOREAN'
            WHEN a.country = 'Thailand'  THEN 'THAI'
            WHEN a.country = 'Vietnam'   THEN 'VIETNAMESE'
            ELSE ''
        END AS nationality
        FROM data_customer a
        LEFT JOIN ( 
             SELECT contact_no, SUM(points) AS deduct_points, 
             COUNT(contact_no) AS minus_points 
             FROM data_customer_points 
             WHERE point_type = 0
             GROUP BY contact_no) AS d ON (d.contact_no = a.contact_no)
        WHERE a.active = 1 ".$date;

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
        $db->select('a.id, a.name, a.contact_no, a.created, a.country, a.active, a.customer_type, d.deduct_points');
        $db->from($this->table. ' a');
        //total deduct point
         $db->join('(SELECT contact_no, SUM(points) AS deduct_points, 
                COUNT(contact_no) AS minus_points
                     FROM data_customer_points 
                     WHERE point_type = 0
                     GROUP BY contact_no 
                   ) AS d',' (d.contact_no = a.contact_no)','LEFT');
         $db->where('a.active',1);
        $c = $db->count_all_results();
        // echo $db->last_query();
        return $c;
    }
  
}
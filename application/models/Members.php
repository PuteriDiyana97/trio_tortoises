<?php
class Members extends CI_Model 
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

    function member_detail($selected_id)
    {
        $db = $this->db;
        
        $db->select('a.*, c.description');
        $db->from('data_customer a');
        $db->join('data_customer_points c', '(a.contact_no = c.contact_no)', 'left');
        $db->where('a.id', $selected_id);
        $db->where('a.active',1);

        $query = $this->db->get();
        return $query->row();
    }

    function country_detail($selected_id)
    {
        $db = $this->db;
        
        $db->select('a.*, c.country');
        $db->from('data_customer a');
        $db->join('data_country c', '(a.country = c.country)', 'left');
        $db->where('a.id', $selected_id);
        $db->where('a.active',1);

        $query = $this->db->get();
        return $query->row();
    }

    function transaction_details($transaction_no,$type)
    {

        $db = $this->db;

        $db->select('a.trxdate,a.trxpoint_desc,a.terminal,a.trxnum,a.active,a.trxtotal');
        $db->from('data_sales_transaction a');
        $db->where('a.trxnum',$transaction_no);
        $db->where('a.active',$type);

        $query = $this->db->get();
        return $query->row();
    }

    function member_points($selected_id)
    {
        $q_find_group_id = $this->db->select('*')->from('data_customer')->where('id',$selected_id)->get()->row();

        $db = $this->db;
        
        $db->select('c.description,c.transaction_date, c.transaction_date as c_transaction_date, c.points, c.point_type, e.current_points, a.contact_no, a.name, a.group_id as data_cust_group_id');
        // $db->select_sum('c.points');
        $db->from('data_customer_points c');
        $db->join('data_customer a', '(a.contact_no = c.contact_no)', 'left');
        $db->join('(SELECT contact_no, SUM(points) AS current_points, 
                COUNT(contact_no) AS curr_points
                     FROM data_customer_points 
                     WHERE point_type = 1
                     GROUP BY contact_no 
                   ) AS e',' (e.contact_no = a.contact_no)','LEFT');
        // $db->where('a.id', $selected_id); 
        $db->where('a.active',1);

        if(isset($q_find_group_id->group_id) && !empty($q_find_group_id->group_id) && $q_find_group_id->group_id > 0)
        {
            $db->where('a.group_id',$q_find_group_id->group_id);
        }
        else
        {
            $db->where('a.contact_no',$q_find_group_id->contact_no);   
        }
       
        $db->order_by('c.transaction_date','ASC');

        $query = $this->db->get();
        return $query->result();
    }

    function list_data()
    {
        $db = $this->db;
        $db->select('*');
        $db->where('active','1');
        $q = $db->get($this->table)->result();
        return $q;
    }

    function list_country()
    {
        $db = $this->db;
        $db->select('*');
        $q = $db->get('data_country')->result();
        return $q;
    }

    public function insert($data)
    {
        $q = $this->db->insert($this->table, $data);
        $insert_id = $this->db->insert_id();

        return $insert_id;
    }

    public function insert1($data)
    {
        $q = $this->db->insert('data_customer_points', $data);
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

    function delete_dcp($contact_no)
    {
        $data = array(
                        "update"=>getDateTime(),
                        "active"=>'0',
                    );

        $db = $this->db;
        $q = $db->where_in('contact_no', $contact_no);
        $q = $db->update('data_customer_points', $data);

        return $q;
    }

    public function detail($selected_id)
    {
        $db = $this->db;
        $db->select('a.*');
        $db->from($this->table . ' a');
        $db->where('id', $selected_id);
        $db->where('active', 1);
        $q = $db->get()->row();

        return $q;
    }

    public function check_data($phone)
    {

        $db = $this->db;
        $db->select('a.*');
        $db->from($this->table . ' a');
        $db->where('contact_no  ', $phone);
        $db->where_in('active',['1','2','3']);
        $q = $db->get()->row();

        return $q;

    }
    public function check_data_member($phone,$selected_id)
    {

        $db = $this->db;
        $db->select('a.*');
        $db->from($this->table . ' a');
        $db->where('contact_no', $phone);
        $db->where_not_in('id', $selected_id);
        $db->where_in('active',['1','2','3']);
        $q = $db->get()->row();

        return $q;

    }

    // ======================= DATATABLE SERVER SIDE PROCESSING =========================

     var $column_order = array(null, 'a.name', 'a.email', 'a.contact_no', 'a.state', 'a.country', 'current_point', 'b.total_points', 'a.customer_type','a.created', null); // field yang ada di table
    var $column_search = array('a.name', 'a.email', 'a.contact_no', 'a.state', 'a.country', 'a.active','a.created'); // field yang diizinkan untuk pencarian 
    var $order = array('UPPER(a.firsttime)' => 'DESC'); // default order

    private function _get_datatables_query()
    {
        $filter_name = $this->input->post('filter_name');
        $filter_membership_type = $this->input->post('filter_membership_type');
        $filter_country = $this->input->post('filter_country');
        $filter_contact = $this->input->post('filter_contact');
        $start_date   = $this->input->post('filter_date_start');
        $end_date     = $this->input->post('filter_date_end');

        $db = $this->db;
        $db->select('a.id, a.name, a.email, a.contact_no, a.state, a.country, a.active, a.customer_type,a.created, e.sum_points, d.deduct_points, b.total_points,
                    CASE WHEN d.deduct_points != "" THEN (b.total_points - d.deduct_points) 
                    ELSE b.total_points END as current_point');
        $db->group_by('a.contact_no');
        $db->from($this->table. ' a');
        $db->join('data_customer_points c', '(a.contact_no = c.contact_no)', 'left');
        //total sum
        $db->join('(SELECT contact_no, SUM(points) AS sum_points, 
                COUNT(contact_no) AS total_points
                     FROM data_customer_points 
                     WHERE point_type = 1
                     GROUP BY contact_no 
                   ) AS e',' (e.contact_no = a.contact_no)','LEFT');
        //total deduct point
         $db->join('(SELECT contact_no, SUM(points) AS deduct_points, 
                COUNT(contact_no) AS minus_points
                     FROM data_customer_points 
                     WHERE point_type = 0
                     GROUP BY contact_no 
                   ) AS d',' (d.contact_no = a.contact_no)','LEFT');
         //total points as member
        $db->join('(SELECT contact_no, SUM(points) AS total_points, 
                    COUNT(contact_no) AS tot_points
                     FROM data_customer_points
                    WHERE point_type = 1
                     GROUP BY contact_no 
                   ) AS b',' (b.contact_no = a.contact_no)','LEFT');
         $db->where('a.active',1);
       

        if ( !empty($filter_name) ) 
        {
            $db->like('a.name', $filter_name, 'both');
        }
        if ( !empty($filter_contact) ) 
        {
            $db->like('a.contact_no', $filter_contact);
        }

        //  1: Lite 2:Silver 3:Gold 4:VIP
        if ( $filter_membership_type == '4') 
        {
             $db->where('a.customer_type', 4);
        } 
        else if ($filter_membership_type == '2') 
        {
            $db->where('a.customer_type', 2);     
        }
        else if ($filter_membership_type == '3') {
            $db->where('a.customer_type', 3);     
        }
        else if ($filter_membership_type == '1') {
            $db->where('a.customer_type', 1);     
        }

        if ( !empty($filter_country) ) 
        {
            $db->like('a.country', $filter_country);
        }

        // if(!empty($start_date))
        // {
        //     $date        = DateTime::createFromFormat('d/m/Y H:i:s', "$start_date 00:00:00");
        //     $startDates = $date->format('Y-m-d H:i:s');

        //     $db->where('DATE(a.created) >=', $startDates);
        // }
         
        // if(!empty($end_date))
        // {
        //     $date        = DateTime::createFromFormat('d/m/Y H:i:s', "$end_date 00:00:00");
        //     $endDates = $date->format('Y-m-d H:i:s');

        //     $db->where('DATE(a.created) <=', $endDates);
        // } 

        if(!empty($start_date))
        {
            $filter_date_start_temp = str_replace('/', '-', $start_date);

            $db->where('DATE(a.created) >=',date("Y-m-d", strtotime($filter_date_start_temp)));
        }
         
        if(!empty($end_date))
        {
            $filter_date_end_temp = str_replace('/', '-', $end_date);

            $db->where('DATE(a.created) <=',date("Y-m-d", strtotime($filter_date_end_temp)));
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
        $db->select('a.contact_no');
        $db->group_by('a.contact_no');
        $db->from($this->table. ' a');
         $db->where('a.active',1);
        $c = $db->count_all_results();
        // echo $db->last_query();
        return $c;
    }

}
?>
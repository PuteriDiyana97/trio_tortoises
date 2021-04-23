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

    var $column_order = array(null, 'a.gender', 'b.point_used'); // field yang ada di table
    var $column_search = array('a.gender', 'b.point_used'); // field yang diizinkan untuk pencarian 
    var $order = array('UPPER(name)' => 'ASC'); // default order

    private function _get_datatables_query()
    {
        $start_date   = $this->input->post('filter_date_start');
        $end_date     = $this->input->post('filter_date_end');
        
        $db = $this->db->select('a.id, a.gender, SUM(b.points) AS point_used, b.transaction_date')
                ->from('data_customer_points b')
                ->join('data_customer a','b.contact_no = a.contact_no','left')
                ->where('point_type','0')
                ->where('a.active','1')
                ->where('b.active','1')
                ->group_by('a.gender');

        if(!empty($start_date) && !empty($end_date))
        {
            $filter_date_start_temp = str_replace('/', '-', $start_date);
            $filter_date_start_db_format = date("Y-m-d", strtotime($filter_date_start_temp));
            $filter_date_end_temp = str_replace('/', '-', $end_date);
            $filter_date_end_db_format = date("Y-m-d", strtotime($filter_date_end_temp));

            $db->where("(DATE(b.transaction_date) BETWEEN '".$filter_date_start_db_format."' AND '".$filter_date_end_db_format."')");
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
        //echo $db->last_query();
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
                $date_start = date('Y-m-d', strtotime($filter_date_start_temp));

                $filter_date_end_temp = str_replace('/', '-', $filter_date_end);
                $date_end = date('Y-m-d', strtotime($filter_date_end_temp));

                $date = "AND (DATE(b.transaction_date) BETWEEN '" . $date_start . "' AND '" . $date_end . "')";
            }
            else
            {
                $date = '';
            }
        } else {
            $date = '';
        }

         $db = "
            SELECT a.gender as Gender,SUM(b.points) as point_used, b.transaction_date
            FROM data_customer_points b
            LEFT JOIN data_customer a ON a.contact_no = b.contact_no
            WHERE b.point_type = 0
            AND  a.active= 1
            ".$date."
            GROUP BY a.gender ";
        
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

    	$db = $this->db->select('a.id, a.gender, SUM(b.points) AS point_used')
                ->from('data_customer_points b    ')
                ->join('data_customer a','b.contact_no = a.contact_no','left')
                ->where('point_type','0')
                ->where('a.active','1')
                ->group_by('a.gender');
        $c = $db->count_all_results();
        // echo $db->last_query();
        return $c;
    }

    function count_gender($gender = 'male')
    {
        $gender = strtolower($gender);

        $q = $this->db->select('SUM(b.points) AS deduct_points')
                ->from('data_customer_points b    ')
                ->join('data_customer a','b.contact_no = a.contact_no','left')
                ->where('point_type','0')
                ->where('a.gender',strtolower($gender))
                ->where('a.gender',ucwords($gender))
                ->where('a.gender',strtoupper($gender))
                ->get()->row();
                

        return isset($q->deduct_points) || $q->deduct_points > 0 ? $q->deduct_points : 0 ;
    }
}
?>
<?php
class Dashboard extends CI_Model 
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

    function member_day()
    {
        
        $db = "SELECT id, contact_no, name,
            COUNT(id) AS 'Count'
            FROM data_customer
            WHERE DATE(created) = DATE(NOW()) ORDER BY `id` DESC";

        $q = $this->db->query($db)->row();
        return $q;
    }

    function member_week()
    {  
        $db = "SELECT name, created as create_date,
            COUNT(id) as 'Count'
            FROM data_customer
            WHERE YEARWEEK(created) = YEARWEEK(NOW()) ORDER BY `id` DESC";

        $q = $this->db->query($db)->row();
        return $q;
    }

    function member_month()
    {
        $db = "SELECT name, created as create_date,
         COUNT(id) as 'Count'
        FROM data_customer
        WHERE MONTH(created) = MONTH(NOW()) ORDER BY `id` DESC";

        $q = $this->db->query($db)->row();
        return $q;
    }

    function earn_day()
    {
        
        $db = "SELECT created as create_date,
            SUM(points) as 'Count' 
            FROM data_customer_points
            WHERE DATE(created) = DATE(NOW()) ORDER BY `id` DESC";

        $q = $this->db->query($db)->row();
        return $q;
    }

    function earn_week()
    {  
        $db = "SELECT created as create_date,
            SUM(points) as 'Count'
            FROM data_customer_points
            WHERE YEARWEEK(created) = YEARWEEK(NOW()) ORDER BY `created` DESC;";

        $q = $this->db->query($db)->row();
        return $q;
    }

    function earn_month()
    {
        $db = "SELECT created as create_date,
            SUM(POINTS) as 'Count'
            FROM data_customer_points
            WHERE MONTH(created) = MONTH(NOW()) ORDER BY `id` DESC;";

        $q = $this->db->query($db)->row();
        return $q;
    }

    function claim_day()
    {
        
        $db = "SELECT voucher_id, contact_no, trxvalue, voucher_status,  claim_date,
            SUM(trxvalue) AS 'Count'
            FROM data_voucher_cust
            WHERE DATE(created) = DATE(NOW()) ORDER BY `id` DESC;";

        $q = $this->db->query($db)->row();
        return $q;
    }

    function claim_week()
    {  
        $db = "SELECT voucher_id, contact_no, trxvalue, voucher_status,  claim_date,
            SUM(trxvalue) as 'Count'
            FROM data_voucher_cust
            WHERE YEARWEEK(created) = YEARWEEK(NOW()) ORDER BY `created` DESC;";

        $q = $this->db->query($db)->row();
        return $q;
    }

    function claim_month()
    {
        $db = "SELECT voucher_id, contact_no, trxvalue, voucher_status,  claim_date,
            SUM(trxvalue) as 'Count'
            FROM data_voucher_cust
            WHERE MONTH(created) = MONTH(NOW()) ORDER BY `id` DESC;";

        $q = $this->db->query($db)->row();
        return $q;
    }

    function redeem_day()
    {
        
        $db = "SELECT voucher_id, contact_no, trxvalue, voucher_status,  redeem_date,
                SUM(trxvalue) as 'Count'
                FROM data_voucher_cust 
                WHERE voucher_status = 0
                AND DATE(created) = DATE(NOW()) ORDER BY `id` DESC; ";

        $q = $this->db->query($db)->row();
        return $q;
    }

    function redeem_week()
    {  
        $db = "SELECT voucher_id, contact_no, trxvalue, voucher_status,  redeem_date,
                SUM(trxvalue) as 'Count'
                FROM data_voucher_cust 
                WHERE voucher_status = 0
                AND YEARWEEK(created) = YEARWEEK(NOW()) ORDER BY `created` DESC;";

        $q = $this->db->query($db)->row();
        return $q;
    }

    function redeem_month()
    {
        $db = "SELECT voucher_id, contact_no, trxvalue, voucher_status,  redeem_date,
                SUM(trxvalue) as 'Count'
                FROM data_voucher_cust 
                WHERE voucher_status = 0
                AND MONTH(created) = MONTH(NOW()) ORDER BY `id` DESC;";

        $q = $this->db->query($db)->row();
        return $q;
    }

    function member_points($selected_id)
    {
        //$db->select('(column2 - column1) AS `remains_value`')->get_where('tablename1', array('pk' => $pk_val))->row_array();
        //$db->select_sum('total_points');

        $q_find_group_id = $this->db->select('*')->from('data_customer')->where('id',$selected_id)->get()->row();


        $db = $this->db;
        
        $db->select('c.description,c.transaction_date, c.created as c_created, c.points, c.point_type, e.current_points, a.contact_no, a.name, a.group_id as data_cust_group_id');
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
        $db->where('a.group_id',$q_find_group_id->group_id);
        $db->order_by('c.created','ASC');

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

	public function insert($data)
    {
        $q = $this->db->insert($this->table, $data);
        $insert_id = $this->db->insert_id();

        return $insert_id;
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

}
?>
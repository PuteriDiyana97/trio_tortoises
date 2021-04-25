<?php
class Users extends CI_Model 
{
	public $table = 'users';
	public $primary_key = 'id';

	public function __construct()
	{
	}
	
	function read_data_specific($id, $field)
	{
		$db = $this->db;
		$db->select($field);
		$db->where($this->primary_key,$id);
		$db->limit(1);
		$q = $db->get($this->table)->row()->$field;
		return $q;
	}

	function read_data_by_column_value($field, $value)
	{
		$db = $this->db;
		$db->select('*');
		$db->where($field,$value);
		$db->where('active','1');
		$db->limit(1);
		$q = $db->get($this->table)->row();
		return $q;
	}

	function read_data_join($id)
	{
		$db = $this->db;
		$db->select('a.*, b.user_name');
		$db->from($this->table.' a');
    	$db->join('logins b', '(b.user_id = a.id AND b.login_type_id = 1)', 'LEFT');
		$db->where('a.'.$this->primary_key,$id);
		$db->limit(1);
		$q = $db->get()->row();
		return $q;
	}

	function read_data($id)
	{
		$db = $this->db;
		$db->select('a.*,b.user_name');
		$db->from($this->table.' a');
		$db->join('logins b', '(b.user_id = a.id)', 'LEFT');
		$db->where('a.'.$this->primary_key,$id);
		$db->limit(1);
		$q = $db->get($this->table)->row();
		return $q;
	}

	function read_role($id)
	{
		$db = $this->db;
		$db->select('a.*, b.role_id');
		$db->from($this->table.' a');
		$db->join('users_role b', '(b.user_id = a.id)', 'LEFT');
		$db->where('a.'.$this->primary_key,$id);
		$q = $db->get($this->table)->row();
		return $q;
	}

	function read_data_role($id)
	{
		$db = $this->db;
		$db->select('*');
		$db->where('user_id',$id);
		$db->where('active','1');
		$q = $db->get('users_role')->result();
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

	function create_data($data)
	{
		$db = $this->db;
		$q = $db->insert($this->table, $data);
		$q = $db->insert_id();

		return $q;
	}

	function create_data_multiple($data)
	{
		$db = $this->db;
		$q = $db->insert_batch($this->table, $data);
		$q = $db->insert_id();

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

	function remove_role($id_user, $role,$data)
	{
		$db = $this->db;
		$db->where('user_id', $id_user);
		$db->where_not_in('role_id', $role);
		$db->update('users_role', $data);
		$q = $db->affected_rows();

		return $q;
	}

	function update_role($id_user,$id_role, $data)
	{
		$db = $this->db;
		$db->where('user_id', $id_user);
		$db->where('role_id', $id_role);
		$db->update('users_role', $data);
		$q = $db->affected_rows();

		return $q;
	}


	function check_role($id_user,$id_role)
	{
		$db = $this->db;
		$db->select('*');
		$db->from('users_role');
		$db->where('user_id',$id_user);
		$db->where('role_id',$id_role);
		$db->where('active', '1');
		$q = $db->get()->row();

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

    var $column_order = array(null, 'a.full_name', 'a.email', 'a.mobile_no', 'b.last_login', null); // field yang ada di table
    var $column_search = array('a.full_name', 'a.email', 'b.last_login'); // field yang diizinkan untuk pencarian 
    var $order = array('UPPER(a.full_name)' => 'ASC'); // default order

    private function _get_datatables_query()
    {
    	$curr_user_id = $this->session->userdata('curr_user_id');
    	$filter_name = $this->input->post('filter_name');
    	$filter_user_type = $this->input->post('filter_user_type');

    	$get_login =   '(SELECT `user_id`, MAX(`last_login`) AS last_login
						FROM `logins`
						GROUP BY `user_id`)';

    	$db = $this->db;
    	$db->select('a.id, a.full_name, a.email, b.last_login, a.user_type, a.mobile_no, l.user_name');
    	$db->from($this->table.' a');
    	$db->join($get_login.' b', 'b.user_id = a.id', 'INNER');
    	$db->join('logins l', 'l.user_id = a.id', 'LEFT');
    	$db->where('a.active', '1');
    	$db->where('a.user_type != ', '1'); // not output super admin
    	//$db->where('a.user_type != ', '2'); // not output admin
    	$db->where('a.id != ', $curr_user_id); // not output current login user

		if ( !empty($filter_name) ) 
		{
    		$db->like('a.full_name', $filter_name, 'both');
		}

		if ( $filter_user_type == '3') 
        {
            //2:admin 3:operator
             $db->where('a.user_type', 3);
        } 
        else if ($filter_user_type == '2') 
        {
        	$db->where('a.user_type', 2);   
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

    public function module()
    {
        $users_id = $this->session->curr_user_id;

        $db = $this->db;
        $db->select('*');
        $db->where('user_id', $users_id);
        $db->where('active', '1');
        $q = $db->get('users_role')->result();

        $output['roles'] = array();
        foreach ($q as $r) {
           $output['roles'][$r->role_id] = $r->user_id;
       }
       return $output;
       
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
    	$get_login =   '(SELECT `user_id`, MAX(`last_login`) AS last_login
						FROM `logins`
						GROUP BY `user_id`)';

    	$db = $this->db;
        $db->from($this->table.' a');
    	$db->join($get_login.' b', 'b.user_id = a.id', 'INNER');
        $db->where('a.active', '1');
    	$db->where('a.user_type != ', '1'); // not output super admin
    	//$db->where('a.user_type != ', '2'); // not output admin
    	$db->where('a.id != ', $curr_user_id); // not output current login user
        $c = $db->count_all_results();
        // echo $db->last_query();
        return $c;
    }
}
?>
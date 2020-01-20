<?php

class AdminModel extends CI_Model
{

    var $title = '';
    var $content = '';
    var $date = '';
    var $table = 'tbl_admins';

    function __construct()
    {
        parent::__construct();
    }

    function get_last_ten_entries()
    {
        $query = $this->db->get('entries', 10);
        return $query->result();
    }

    function insert_entry()
    {
        $this->title = $_POST['title']; // please read the below note
        $this->content = $_POST['content'];
        $this->date = time();

        $this->db->insert('entries', $this);
    }

    function update_entry()
    {
        $this->title = $_POST['title'];
        $this->content = $_POST['content'];
        $this->date = time();

        $this->db->update('entries', $this, array('id' => $_POST['id']));
    }

    public function checkLogin($post)
    {
        $arrayResult = array();
        $result = $this->db->select('*')->from('tbl_admins')->where('email', $post['email'])->get()->row_array();
        if (!empty($result)) {
            if (matchHash($result['password'], $post['password'])) {
                $arrayResult = $result;
            }
        }
        return $arrayResult;
    }

    public function getAdmin($limit = null, $start = 0)
    {

        $this->db->select('*')
            ->from('tbl_admins')
            ->where('is_deleted', 0)->order_by('admin_id', 'desc');

        if (!empty($limit)) {
            $this->db->limit($limit, $start);
        }
        $result = $this->db->get()->result();
        if (!empty($result)) {
            return $result;
        }
        return array();
    }

    public function getCount()
    {
        return $this->db->where('is_deleted', 0)->count_all_results('tbl_admins');
    }

    public function saveData($post, $image = "")
    {

        $data = array(
            'name' => $post['name'],
            'phone' => $post['phone'],
            'email' => $post['email'],
            'password' => setHash($post['password']),
            'create_date' => date('Y-m-d H:i:s'),
        );

        if (!empty($image)) {
            $image = array('image' => $image);
            $data = array_merge($data, $image);
        }

        $this->db->insert('tbl_admins', $data);
    }

    public function updateData($post, $image = "", $id="")
    {

        $data = array(
            'name' => $post['name'],
            'phone' => $post['phone'],
            'email' => $post['email'],
            'update_date' => date('Y-m-d H:i:s'),
        );

        if (!empty($post['password'])) {
            $password = array('password' => setHash($post['password']));
            $data = array_merge($data, $password);
        }

        if (!empty($image)) {
            $image = array('image' => $image);
            $data = array_merge($data, $image);
        }

        $this->db->where('admin_id', $id);
        $this->db->update($this->table, $data);

       /************* Permission Module *********/
        $this->db->where('admin_id', $id);
        $this->db->delete('tbl_auth_assignment');
        if (!empty($post['item_list'])) {
            foreach ($post['item_list'] as $item) {
                $dataAuth = array(
                    'auth_item_id' => $item,
                    'admin_id' => $id,
                    'type' => 'A'
                );
                $this->db->insert('tbl_auth_assignment', $dataAuth);
            }
        }
        /************* Permission Module End*********/

    }

    public function getAdminDetails($admin_id)
    {
        $this->db->select('*')
            ->from('tbl_admins')
            ->where('admin_id', $admin_id);
        $result = $this->db->get()->row();
        return $result;
    }


}

<?php
class AdminModel extends CI_Model {

    var $title   = '';
    var $content = '';
    var $date    = '';

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
        $this->title   = $_POST['title']; // please read the below note
        $this->content = $_POST['content'];
        $this->date    = time();

        $this->db->insert('entries', $this);
    }

    function update_entry()
    {
        $this->title   = $_POST['title'];
        $this->content = $_POST['content'];
        $this->date    = time();

        $this->db->update('entries', $this, array('id' => $_POST['id']));
    }

    public function checkLogin($post){
        $arrayResult = array();
       $result = $this->db->select('*')->from('tbl_admins')->where('email', $post['email'])->get()->row_array();
       if(!empty($result)){
           if(matchHash($result['password'], $post['password'])){
               $arrayResult = $result;
           }
       }
       return $arrayResult;
    }


}

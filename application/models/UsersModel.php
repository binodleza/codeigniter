<?php
class UsersModel extends CI_Model {
    protected $table = 'tbl_users';
    function __construct()
    {
        parent::__construct();
    }
    
   public function getUsers($limit = null, $start = 0){

        $this->db->select('*')
           ->from('tbl_users')
           ->where('is_deleted', 0);

        if(!empty($limit)){
            $this->db->limit($limit, $start);
        }
       $result = $this->db->get()->result();
       if(!empty($result)){
           return $result;
       }
       return array();
   }





    public function deleteUsers(){

    }


    public function getCount() {
        return  $this->db->where('is_deleted', 0)->count_all_results($this->table);
    }


}

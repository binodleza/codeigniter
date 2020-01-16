<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Users extends Admin_Parent {

    function __construct()
    {
        parent::__construct();
        $this->load->model('UsersModel');

        $this->load->helper('url');
        $this->load->library("pagination");
    }

	public function index()
	{
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('msg', "You need to be logged in to access the this page.");
            redirect('site/login');
        }

        $config = array();
        $config["base_url"] = base_url() . "users";
        $config["total_rows"] = $this->UsersModel->getCount();
        $config["per_page"] = 2;
        $config["uri_segment"] = 2;

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';
        $config['next_tag_open'] = '<li class="pg-next">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="pg-prev">';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

        $this->data["links"] = $this->pagination->create_links();

        $this->data['list'] = $this->UsersModel->getUsers($config["per_page"], $page);
        //$this->load->view('authors/index', $data);
        //$this->data['list'] = $this->UsersModel->getUsers();
        $this->render('backend/users/index');


	}

	public function changeStatus(){
        $id = $_GET['id'];
        $result = $this->db->select('user_id,is_active')->from('tbl_users')->where('user_id', $id)->get()->row();
        if(!empty($result)){
            if($result->is_active == 1){
               $isActive = 0;
            }else{
                $isActive = 1;
            }
            $this->db->update('tbl_users', array('is_active' => $isActive), array('user_id' => $id));
        }

    }

    public function test(){
       $total = $this->db->where('user_id',5)->count_all_results('tbl_users');

       echo $total;
    }


}

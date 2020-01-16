<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Site extends CI_Controller {


    protected $data = array();
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->data['pagetitle'] = 'My CodeIgniter App';
        $this->load->model('AdminModel');
    }

    protected function render($content)
    {
        $this->data['content'] = (is_null($content)) ? '' : $this->load->view($content,$this->data, TRUE);
        $this->load->view('backend/main', $this->data);
    }

    protected function renderPartial($content)
    {
        $this->load->view($content, $this->data);
    }

	public function index()
	{
		$this->load->view('welcome_message');
	}

    public function login()
    {
        // if already set logged_id then go direct on dashboard//
        if ($this->session->userdata('logged_in')) {
            redirect(base_url('dashboard'));
        }

       $post =  $this->input->post();
       if(!empty($post)){
           $this->form_validation->set_rules('password', 'Password', 'required');
           $this->form_validation->set_rules(
               'email', 'Email Id',
               'required|min_length[5]|max_length[50]|valid_email',
               array(
                   'required'      => 'You have not provided %s.',
               )
           );
           if ($this->form_validation->run() != FALSE) {
               $result = $this->AdminModel->checkLogin($post);
               if(!empty($result)){
                   $this->session->set_userdata('userInfo', $result);
                   $this->session->set_userdata('logged_in', TRUE);
                   redirect(base_url('dashboard'));
               }else{
                   $this->session->set_flashdata('errorMsg', "You have entered wrong credentials.");
               }
           }
       }

        $this->renderPartial('backend/login');
    }

    public function test()
    {
        $password = '111111';
        $hash = password_hash($password,PASSWORD_DEFAULT);
        echo $hash; exit;
       // return $hash;

       // $hash = '$2y$07$BCryptRequires22Chrcte/VlQH0piJtjXl.0t1XkA8pw9dMXTpOq';

        if (password_verify('111111', $hash)) {
            echo 'Password is valid!';
        } else {
            echo 'Invalid password.';
        }
        exit;
        echo 'Hello1234';
       $password = 'Hello1234';
       echo  password_hash($password, PASSWORD_BCRYPT);
    }

    public function md5()
    {
        echo md5(123456);
    }

    public function logout() {
        $this->session->unset_userdata('userInfo');
        $this->session->unset_userdata('logged_in');
        redirect(base_url('site/login'));
    }
	

            



}

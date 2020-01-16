<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Dashboard extends CI_Controller {

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
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('msg', "You need to be logged in to access the this page.");
            redirect('site/login');
        }else{
            $this->render('backend/dashboard');
        }


	}


}

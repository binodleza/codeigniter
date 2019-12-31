<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lawyer extends CI_Controller {


    protected $data = array();
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->data['pagetitle'] = 'My CodeIgniter App';
    }

    protected function render($content)
    {
        $this->data['content'] = (is_null($content)) ? '' : $this->load->view($content,$this->data, TRUE);
        $this->load->view('backend/main', $this->data);
    }

	public function index()
	{
		$this->load->view('welcome_message');
	}

    public function createLawyer()
    {

         $this->data = array(
            'name' => 'Binod',
            'Branch' => 'CS',
            'pagetitle' => 'Title'
        );
        $this->render('backend/general');
    }

    public function getLawyer()
    {

        $query = $this->db->query("select * from crud");
        $result = $query->result();
        debugger_print($result);
    }


}

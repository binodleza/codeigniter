<?php
class Admin_Parent extends CI_Controller {

    protected $data = array();
    public function __construct()
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

    protected function renderPartial($content)
    {
        $this->load->view($content, $this->data);
    }


}
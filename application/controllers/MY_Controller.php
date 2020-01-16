<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
class MY_Controller extends CI_Controller {

    protected $data = array();
    function __construct()
    {
        parent::__construct();

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

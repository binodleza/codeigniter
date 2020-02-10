<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mailer extends Admin_Parent
{

    function __construct()
    {
        parent::__construct();
    }



    public function index()
    {
       // $this->load->library('email');

        /*$config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'neverreply61@gmail.com', // change it to yours
            'smtp_pass' => 'nvccixigpfowdxbz', // change it to yours
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );*/

        $config = Array(
            'protocol' => 'localhost',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'neverreply61@gmail.com', // change it to yours
            'smtp_pass' => 'nvccixigpfowdxbz', // change it to yours
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );

        $message = 'Test email here';
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('binod.leza@gmail.com'); // change it to yours
        $this->email->to('binod.leza@gmail.com');// change it to yours
        $this->email->subject('Resume from JobsBuddy for your Job posting');
        $this->email->message($message);
        if($this->email->send())
        {
            echo 'Email sent.';
        }
        else
        {
            show_error($this->email->print_debugger());
        }


     // echo 'Send Mail';


    }



}

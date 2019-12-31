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

       // $query = $this->db->query("select * from tbl_admin");
        //$result = $query->result();

         /*$query = $this->db->get('tbl_admin');
         $result = $query->result();
         foreach ($result as $row){
            echo $row['admin_id'];
         }*/

         $this->db->select('*')->from('tbl_order');
         $this->db->join('(
                                        SELECT t1.*
                                        FROM tbl_payments AS t1
                                        LEFT OUTER JOIN tbl_payments AS t2 ON t1.order_id = t2.order_id 
                                                AND (t1.payment_date < t2.payment_date 
                                                 OR (t1.payment_date = t2.payment_date AND t1.payment_id < t2.payment_id))
                                        WHERE t2.order_id IS NULL
                                        ) as temp', 'temp.order_id = tbl_order.order_id', 'left');
         $this->db->where('tbl_order.order_id', 444);
         $result =  $this->db->get()->result_array();


        show($result);
    }


}

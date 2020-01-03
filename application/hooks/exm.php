<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Exm extends CI_Controller {
    public function tut()
    {
        //echo "Welcome to JavaTpoint. This is ";
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
?>
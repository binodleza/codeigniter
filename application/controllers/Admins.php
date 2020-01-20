<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admins extends Admin_Parent
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('AdminModel');

        $this->load->helper('url');
        $this->load->library("pagination");

         $only = array(
             "index","create","update","delete","test","check"
         );
         isAllowAccess($only);
    }
    public function check(){

         echo 'hi';
    }

    public function index()
    {
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('msg', "You need to be logged in to access the this page.");
            redirect('site/login');
        }

        $config = array();
        $config["base_url"] = base_url() . "admins";
        $config["total_rows"] = $this->AdminModel->getCount();
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

        $this->data['list'] = $this->AdminModel->getAdmin($config["per_page"], $page);
        //$this->load->view('authors/index', $data);
        //$this->data['list'] = $this->UsersModel->getUsers();
        $this->render('backend/admins/index');


    }

    public function changeStatus()
    {
        $id = $_GET['id'];
        $result = $this->db->select('admin_id,is_active')->from('tbl_admins')->where('admin_id', $id)->get()->row();
        if (!empty($result)) {
            if ($result->is_active == 1) {
                $isActive = 0;
            } else {
                $isActive = 1;
            }
            $this->db->update('tbl_admins', array('is_active' => $isActive), array('admin_id' => $id));
        }

    }

    public function create()
    {
        $post = $this->input->post();
        if (!empty($post)) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('phone', 'Phone', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');
            $this->form_validation->set_rules(
                'email', 'Email Id',
                'required|min_length[5]|max_length[50]|is_unique[tbl_admins.email]',
                array(
                    'required' => 'You have not provided %s.',
                    'is_unique' => 'This %s already exists.'
                )
            );
            if ($this->form_validation->run() == FALSE) {

                /* $validation = $this->form_validation->error_array();
                 $error = array();
                 foreach($validation as $key => $row)
                     $error[] = array('field' => $key, 'error' => $row);
                 if(!empty($error)) {
                     $this->json['status'] = 'error';
                     $this->json['errorfields'] = $error;
                 } else {
                     $this->json['status'] = 'success';
                 }
                 echo json_encode($this->json);
                 exit;
                */
            } else {

                $image_data = array();
                if (!empty($_FILES) && !empty($_FILES["image"]['name'])) {

                    $this->load->library('image_lib');
                    $config['file_name'] = time() . '-' . $_FILES["image"]['name'];
                    $config['upload_path'] = UPLOADS;
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('image')) {
                        show($this->upload->display_errors());
                    } else {
                        $image_data = $this->upload->data();

                        $configer = array(
                            'image_library' => 'gd2',
                            'source_image' => $image_data['full_path'],
                            //'maintain_ratio'  =>  TRUE,
                            'maintain_ratio' => FALSE,
                            'width' => 250,
                            'height' => 250,
                        );
                        $this->image_lib->clear();
                        $this->image_lib->initialize($configer);
                        $this->image_lib->resize();
                    }

                }
                $fileName = '';
                if (!empty($image_data)) {
                    $fileName = $image_data['file_name'];
                }

                $this->AdminModel->saveData($this->input->post(), $fileName);
                redirect(base_url('admins/index'));
            }
        }

        $this->render('backend/admins/form');
    }


    public function update($id)
    {
        //$admin_id  =  $_GET['id'];
        $admin_id = $id;
        $model = $this->AdminModel->getAdminDetails($admin_id);


        $this->db->select('*')
            ->from('tbl_auth_module')
            ->where('is_active', 1)->order_by('auth_module_name', 'asc');
        $modules = $this->db->get()->result_array();
        $result = array();
        foreach ($modules as $row) {
            $row['items'] = $this->getModuleItem($row['auth_module_id']);
            array_push($result, $row);
        }
      // show($result); exit;

        $post = $this->input->post();
        if (!empty($post)) {
            //show($post); exit;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('phone', 'Phone', 'required');
            $this->form_validation->set_rules(
                'email', 'Email Id',
                'required|min_length[5]|max_length[50]',
                array(
                    'required' => 'You have not provided %s.',
                )
            );
            if ($this->form_validation->run() == FALSE) {

                /* $validation = $this->form_validation->error_array();
                 $error = array();
                 foreach($validation as $key => $row)
                     $error[] = array('field' => $key, 'error' => $row);
                 if(!empty($error)) {
                     $this->json['status'] = 'error';
                     $this->json['errorfields'] = $error;
                 } else {
                     $this->json['status'] = 'success';
                 }
                 echo json_encode($this->json);
                 exit;
                */
            } else {

                $image_data = array();
                if (!empty($_FILES) && !empty($_FILES["image"]['name'])) {

                    $this->load->library('image_lib');
                    $config['file_name'] = time() . '-' . $_FILES["image"]['name'];
                    $config['upload_path'] = UPLOADS;
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('image')) {
                        show($this->upload->display_errors());
                    } else {
                        $image_data = $this->upload->data();

                        $configer = array(
                            'image_library' => 'gd2',
                            'source_image' => $image_data['full_path'],
                            //'maintain_ratio'  =>  TRUE,
                            'maintain_ratio' => FALSE,
                            'width' => 250,
                            'height' => 250,
                        );
                        $this->image_lib->clear();
                        $this->image_lib->initialize($configer);
                        $this->image_lib->resize();
                    }

                }
                $fileName = '';
                if (!empty($image_data)) {
                    $fileName = $image_data['file_name'];
                }

                $this->AdminModel->updateData($this->input->post(), $fileName, $admin_id);

                $message = '<div class="alert alert-success hideSomeTime">
                        <strong>Success!</strong> Admin Details has been updated.
                    </div>';

                $this->session->set_flashdata('success', $message);
                redirect(base_url('admins/index'));
            }
        }

        $this->data['model'] = $model;
        $this->data['result'] = $result;
        $this->render('backend/admins/form');
    }

    public function getModuleItem($id) {
        $model =  $this->db->select('*')
            ->from('tbl_auth_item')
            ->where('is_active', 1)->where('auth_module_id', $id)->order_by('auth_item_name', 'asc')->get()->result_array();
        return $model;
    }

    public function countTest(){
       echo checkAccess('/admins/index');
           //  show(getUserPermission(1,'A'));
         // show(getModuleAssignItem());
    }

    public function permission(){
        $sessionData = $this->session->userdata('userPermissibleItem');
        show($sessionData);
    }

    public function test(){
        $sessionData = getPermissibleArray();
        show($sessionData);
    }


}

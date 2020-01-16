<?php
//namespace \yidas\queue\worker; 
//use Exception;
//use CI_Controller;
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Lawyer extends CI_Controller {


    protected $data = array();
    function __construct()
    {
        parent::__construct();
        $this->load->database();
		//  $this->load->library('QuLibrary');
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
	
	public function test(){
		$query = $this->db->query("select * from employee");
         $result = $query->result();
		 show($result);
		echo "Hello";
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

    public function getConfig(){
       // $this->config->set_item('mainURL','itsolutionstuff.com');
        //$mainURL = $this->config->item('mainURL');

        $this->config->load('breadcrumbs');
        //$this->config->set_item('hide_number', '32333');

        $mainURL =  $this->config->item('hide_number');
        echo $mainURL;

    }


    public function getForm(){

        $this->render('backend/form');
    }

    public function save_user(){

        $this->load->library('form_validation');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');
        $this->form_validation->set_rules(
            'email', 'Email Id',
            'required|min_length[5]|max_length[50]|is_unique[user.email]',
            array(
                'required'      => 'You have not provided %s.',
                'is_unique'     => 'This %s already exists.'
            )
        );
        if ($this->form_validation->run() == FALSE) {
            $validation = $this->form_validation->error_array();
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

        } else {

            $image_data = array();
            if(!empty($_FILES)){
                $this->load->library('image_lib');
                $config['file_name']        = time().'-'.$_FILES["photo"]['name'];
                $config['upload_path'] = UPLOADS;
                $config['allowed_types'] = 'gif|jpg|png';
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('photo'))
                {
                    echo "error";
                }
                else
                {
                    $image_data =   $this->upload->data();

                    $configer =  array(
                        'image_library'   => 'gd2',
                        'source_image'    =>  $image_data['full_path'],
                        //'maintain_ratio'  =>  TRUE,
                        'maintain_ratio'  =>  FALSE,
                        'width'           =>  250,
                        'height'          =>  250,
                    );
                    $this->image_lib->clear();
                    $this->image_lib->initialize($configer);
                    $this->image_lib->resize();
                }
            }
            $fileName = '';
            if(!empty($image_data)){
              $fileName =  $image_data['file_name'];
            }

            $this->model->saveUser($this->input->post(), $fileName);
            redirect(base_url('getForm'));
        }

    }


    public function imageUpload(){ 
          $this->render('backend/image-upload');

    }

    public function uploadImage() {  
    if(!empty($_FILES)){ 
      $this->load->library('image_lib');
      $config['file_name']        = time().'-'.$_FILES["image"]['name'];
      $config['upload_path'] = UPLOADS;
      $config['allowed_types'] = 'gif|jpg|png';
      $this->load->library('upload', $config);
      if ( ! $this->upload->do_upload('image'))
      {
         echo "error";    
      }
      else
      {
            $image_data =   $this->upload->data();

            $configer =  array(
              'image_library'   => 'gd2',
              'source_image'    =>  $image_data['full_path'],
              //'maintain_ratio'  =>  TRUE,
              'maintain_ratio'  =>  FALSE,
              'width'           =>  250,
              'height'          =>  250,
            );
            $this->image_lib->clear();
            $this->image_lib->initialize($configer);
            $this->image_lib->resize();

            show($image_data);
           // $this->model->saveImage($image_data['file_name']);
      } 
   }
   // $this->render('backend/image-upload'); 
   }

    function multipleUpload(){
        $data = array();
        // If file upload form submitted
       // show($_FILES); exit;
        if(!empty($_FILES['image']['name'])){
            $this->load->library('image_lib');
            $filesCount = count($_FILES['image']['name']);
            for($i = 0; $i < $filesCount; $i++){
                $_FILES['file']['name']     = $_FILES['image']['name'][$i];
                $_FILES['file']['type']     = $_FILES['image']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['image']['tmp_name'][$i];
                $_FILES['file']['error']     = $_FILES['image']['error'][$i];
                $_FILES['file']['size']     = $_FILES['image']['size'][$i];

                // File upload configuration
                $uploadPath = UPLOADS;
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'jpg|jpeg|png|gif';

                // Load and initialize upload library
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                // Upload file to server
                if($this->upload->do_upload('file')){
                    // Uploaded file data
                    $image_data =   $this->upload->data();
                    $configer =  array(
                        'image_library'   => 'gd2',
                        'source_image'    =>  $image_data['full_path'],
                        //'maintain_ratio'  =>  TRUE,
                        'maintain_ratio'  =>  FALSE,
                        'width'           =>  250,
                        'height'          =>  250,
                    );
                    $this->image_lib->clear();
                    $this->image_lib->initialize($configer);
                    $this->image_lib->resize();

                    $uploadData[$i]['file_name'] = $image_data['file_name'];
                    $uploadData[$i]['uploaded_on'] = date("Y-m-d H:i:s");


                   /* $fileData = $this->upload->data();
                    $uploadData[$i]['file_name'] = $fileData['file_name'];
                    $uploadData[$i]['uploaded_on'] = date("Y-m-d H:i:s"); */
                }
            }

            if(!empty($uploadData)){

                show($uploadData);
                exit;
               /*
                // Insert files data into the database
                $insert = $this->file->insert($uploadData);
                // Upload status message
                $statusMsg = $insert?'Files uploaded successfully.':'Some problem occurred, please try again.';
                $this->session->set_flashdata('statusMsg',$statusMsg);
               */
            }
        }

    }


 public function uploadImageRunning() {  
    if(!empty($_FILES)){ 
      $config['file_name']        = time().'-'.$_FILES["image"]['name'];
      $config['upload_path']   = UPLOADS; // define in constants //

      $config['allowed_types'] = 'gif|jpg|png'; 
      $config['max_size']      = 1024;
      $config['file_ext_tolower'] = TRUE;

      $this->load->library('upload', $config);


      if ( ! $this->upload->do_upload('image')) {
         $error = array('error' => $this->upload->display_errors()); 
         show($error);
         //$this->load->view('imageUploadForm', $error); 
      }else {  
        $uploadedImage = $this->upload->data(); 
        // thumbnail image name made from image raw name + _thumb + extension //
        $thumbnailName = $uploadedImage['raw_name'].'_thumb'.$uploadedImage['file_ext']; 
        $isResizeDone = $this->resizeImage($uploadedImage['file_name']);
        // isResizeDone retrun 1 for success //
        if($isResizeDone){

         $imageDetails['name'] =  $uploadedImage['file_name'];
         $imageDetails['thumbnailImageName'] =  $thumbnailName ;
          show($imageDetails); exit;
          $this->model->saveImage($imageDetails);
        }  
         
      }  
   }
   // $this->render('backend/image-upload');

   }


  public function resizeImage($filename)
   { 
      $source_path = UPLOADS . $filename; 
      $target_path = UPLOADS;
      $config_manip = array(
          'image_library' => 'gd2',
          'source_image' => $source_path,
          'new_image' => $target_path,
          //'maintain_ratio' => TRUE,
          'maintain_ratio' => FALSE,
          'create_thumb' => TRUE,
          'thumb_marker' => '_thumb',
          'width' => 1024,
          'height' => 768
      );

       $result = true;
      $this->load->library('image_lib', $config_manip);
      if (!$this->image_lib->resize()) { 
            echo $this->image_lib->display_errors();
            $result = false;
      } 

      $this->image_lib->clear(); 
      return $result;
   }

    public function imageUploadtEST(){
           if($this->input->post()){
                $config = array(
                'upload_path' => "./uploads/",
                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                'overwrite' => TRUE,
                'max_size' => "2048", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                'max_height' => "1768",
                'max_width' => "3024"
                );
                $this->load->library('upload', $config);
                if($this->upload->do_upload())
                {
                $data = array('upload_data' => $this->upload->data());
                $this->load->view('image-upload',$data);
                }
                else
                {
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('image-upload', $error);
                }
                }

                $this->render('backend/image-upload');
           }

    public function saveUser()
    {

        $data = array(
            'name'=> 'Binod Kr Yadav',
            'phone'=> '90908978798',
            'email'=> 'binodyadav2011@gmail.com'
        );
        $this->db->insert('user',$data);
    }

    public function getUnion()
    {
       // $this->db->select('*');
       // $result = $this->db->from('view_listing')->get()->result_array();
       /// show($result);
      /*  $this->db->select('listing.listing_id as listing_id, listing.name as listing_name, "L" as list_type');
        $this->db->from('listing');
        $result =  $this->db->get()->result_array();
      */
       /* $this->db->select('listing.listing_id as listing_id, listing.name as listing_name, "L" as list_type');
        $this->db->from('listing');
        $query1 = $this->db->get_compiled_select();

        $this->db->select('trainer.trainer_id as listing_id, trainer.name as listing_name, "T" as list_type');
        $this->db->from('trainer');
        $query2 = $this->db->get_compiled_select();

        $query = $this->db->query($query1 . ' UNION ' . $query2);
        $result =  $query->result_array();
        show($result);*/

       // $query = "SELECT fname, lname, no_of_years(start_date) as 'years' FROM employee";
        //$query = $this->db->query($query);

       /* $this->db->select('fname, lname, no_of_years(start_date) as "years"');
        $query = $this->db->from('employee')->get();
        $result =  $query->result_array();*/

        $query = $this->db->query("CALL get_user(1, @user_name)");
        $result = $query->result();
        show($result);


    }
            



}

<?php
/*https://github.com/yidas/codeigniter-queue-worker */
use yidas\queue\worker\Controller as WorkerController;

class My_worker extends WorkerController
{
    // Initializer
    protected function init() {
       // $this->load->database();
        $this->load->library('myjobs');
    }

    // Worker
    protected function handleWork() {
        $this->load->database();
        $data = array(
            'name'=> 'Binod Kr Yadav',
            'phone'=> '90908978798',
            'email'=> 'binodyadav2011@gmail.com'
        );
        $this->db->insert('user',$data);
        return true;


       /* $job = $this->myjobs->popJob();
        // return `false` for job not found, which would close the worker itself.
        if (!$job)
            return false;

        // Your own method to process a job
        $this->myjobs->processJob($job);

        // return `true` for job existing, which would keep handling.
        return true;
       */
    }

    // Listener
    protected function handleListen() {
          return array(
              'id' => 1,
              'name' => 'Binod'
          );
       // return $this->myjobs->exists();
    }
}
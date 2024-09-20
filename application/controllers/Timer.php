<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timer extends CI_Controller {

    public function index()
    {
        $this->load->view('timer_view');
    }
}

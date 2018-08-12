<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    protected $admin;
    public function __construct()
    {
        parent::__construct();
        $this->checkLogin();
    }
    private function checkLogin()
    {
        include_once APPPATH . '/libraries/Admin.php';
        $this->load->library('session');
        $admin = $this->session->userdata(\Admin::SESSION_SAVE_KEY);
        if (empty($admin)) {
            redirect(base_url('admin/login'));
        }
        $this->admin = unserialize($admin);
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function index()
    {
        return $this->load->view('admin/login/index');
    }
    public function captcha()
    {
        $this->load->library('session');
        $this->load->library('ImageProcess');
        $code = $this->imageprocess->createVerificationCode(4, 95, 40, 5, 10);
        $this->session->unset_userdata('loginCaptcha');
        $this->session->set_userdata('loginCaptcha', $code);
        $this->imageprocess->showCreateImage();
        $this->imageprocess->destroy();
    }
    public function sub()
    {
        $username = $this->input->post('username');
        $pwd = $this->input->post('password');
        $captcha = $this->input->post('captcha');
        $this->load->library('session');
        $oldCaptcha = $this->session->userdata('loginCaptcha');
        if (!preg_match('/^[\w]{4}/', $captcha)) {
            return err('验证码错误');
        }
        if (!preg_match('/^[\w|_]{4,16}/', $username)) {
            return err('登录名错误');
        }
        if (!preg_match('/^[\w|_]{5,16}/', $pwd)) {
            return err('用户名错误');
        }
        if (strtolower($captcha) !== strtolower($oldCaptcha)) {
            return err('验证码错误');
        }
        $this->session->unset_userdata('loginCaptcha');
        $this->load->model('StaffModel', 'staff');
        $res = $this->staff->checkLogin($username, $pwd);
        if (empty($res)) {
            return err('用户名密码错误');
        }
        include_once APPPATH . '/libraries/Admin.php';
        $hasJob = $this->staff->staffJob($res['id']);
        if (empty($hasJob)) {
            return json(['result' => 'ERROR', 'msg' => '该用户无后台管理权限']);
        }
        $jobId = [];
        foreach ($hasJob as $v) {
            $jobId[] = $v['job_id'];
        }
        $res['key'] = $this->staff->getKey($jobId);
        unset($res['pwd']);
        $admin = new Admin(true);
        $admin->setInfo($res);
        $admin->setAuth($res['key']);
        $admin->save();
        $url = base_url('/admin/home');
        return json(['result' => 'SUCCESS', 'msg' => '登陆成功', 'url' => $url]);
    }
}

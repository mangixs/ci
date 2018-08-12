<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Staff extends MY_Controller
{
    private $key = 'staff';
    public function index()
    {
        $ret['title'] = '管理员管理';
        $ret['key'] = $this->admin->getFunc($this->key);
        $this->load->model('StaffModel', 'staff');
        $this->load->library('pagination');
        $every = 10;
        $config['base_url'] = site_url('admin/staff/index');
        $config['total_rows'] = $this->staff->getCount();
        $config['per_page'] = $every;
        $config['uri_segment'] = 4;
        $config['first_link'] = '第一页';
        $config['prev_link'] = '上一页';
        $config['next_link'] = '下一页';
        $config['last_link'] = '最后一页';
        $this->pagination->initialize($config);
        $ret['page'] = $this->pagination->create_links();
        $page = $this->uri->segment(4);
        $ret['data'] = $this->staff->getData($every, $page);
        $this->load->view('admin/public/list');
        $this->load->view('admin/staff/index', $ret);
    }
    public function add()
    {
        $data['action'] = 'add';
        $this->load->view('admin/public/edit');
        $this->load->view('admin/staff/add', $data);
    }
    public function uploadImage()
    {
        $config['upload_path'] = './resources/upload/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 2 * 1024;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('file')) {
            $error = $this->upload->display_errors();
            return err($error);
        } else {
            $data = $this->upload->data();
            $url = '/resources/upload/' . $data['file_name'];
            return json(['result' => 'SUCCESS', 'msg' => '上传成功', 'url' => $url]);
        }
    }
    public function uploadQiNiu()
    {
        $this->load->library('Qiniu');
        $accessKey = 'dz-8nHn9Ptp3CgWXqjOSJG8_ZiLal0pndbfn2Jru';
        $secretKey = 'jBfmOqwQKskDzFgiJE3YbDjJGSQuHKlPPdMTb8E9';
        $auth = new Qiniu\Auth($accessKey, $secretKey);
        $bucket = 'movie';
        $url = 'http://p8srgnrod.bkt.clouddn.com';
        $token = $auth->uploadToken($bucket);
        $uploadMgr = new \Qiniu\Storage\UploadManager();
        $saveFile = time() . '.jpg';
        $uploadFile = $_FILES['file']['tmp_name'];
        $res = $uploadMgr->putFile($token, $saveFile, $uploadFile);
        if (!empty($res[0]['key'])) {
            return json(['result' => 'SUCCESS', 'msg' => '上传成功', 'url' => $url . '/' . $res[0]['key']]);
        } else {
            return json(['result' => 'ERROR', 'msg' => '上传失败', 'data' => $res]);
        }
    }
    public function save()
    {
        $this->load->library('form_validation');
        $data['login_name'] = $this->input->post('login_name');
        $data['true_name'] = $this->input->post('true_name');
        $data['staff_num'] = $this->input->post('staff_num');
        $data['header_img'] = $this->input->post('header_img');
        if ($this->form_validation->run('staff') == false) {
            $err = $this->form_validation->error_array();
            return json(['result' => 'ERROR', 'msg' => '表单填写错误', 'data' => $err]);
        }
        $action = $this->input->post('action');
        $data['update_at'] = time();
        $this->load->model('StaffModel', 'staff');
        switch ($action) {
            case 'add':
                $data['insert_at'] = $data['update_at'];
                $data['pwd'] = md5(123456);
                $id = $this->staff->insert($data);
                break;
            case 'edit':
                $id = $this->input->post('id');
                $this->staff->update($id, $data);
                break;
            default:
                # code...
                break;
        }
        return json(['result' => 'SUCCESS', 'msg' => '操作成功', 'id' => $id]);
    }
    public function edit($id, $act)
    {
        $this->load->model('StaffModel', 'staff');
        $data['action'] = $act;
        $data['data'] = $this->staff->single($id);
        $this->load->view('admin/public/edit');
        $this->load->view('admin/staff/add', $data);
    }
    public function deleteData($id)
    {
        if (!is_numeric($id)) {
            return err('参数错误');
        }
        $this->load->model('StaffModel', 'staff');
        $this->staff->deleteData($id);
        return json(['result' => 'SUCCESS', 'msg' => '删除成功']);
    }
    public function setJob($id)
    {
        if (empty($id) and !is_numeric($id)) {
            return json(['result' => 'ERROR', 'msg' => '参数错误']);
        }
        $this->load->model('StaffModel', 'staff');
        $data['data'] = $this->staff->allJob();
        $data['has'] = $this->staff->hasJob($id);
        $data['staff_id'] = $id;
        $this->load->view('admin/staff/set', $data);
    }
    public function jobSave()
    {
        $staff_id = $this->input->post('staff_id');
        $job_id = $this->input->post('job_id');
        $set = $this->input->post('set') === 'true' ? true : false;
        if (empty($staff_id) and empty($job_id) and !is_numeric($staff_id) and !is_numeric($job_id) and !is_bool($set)) {
            return json(['result' => 'ERROR', 'msg' => '参数错误']);
        }
        $this->load->model('StaffModel', 'staff');
        $this->staff->jobSave($staff_id, $job_id, $set);
        return json(['result' => 'SUCCESS', 'msg' => '设置成功']);
    }
}

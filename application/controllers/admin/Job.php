<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Job extends MY_Controller
{
    private $rule = [
        'job' => [
            'job_name' => ['name' => 'job_name', 'preg' => ':notnull', 'notice' => '请填写职位名称！'],
            'explain' => ['name' => 'explain', 'preg' => ':notnull', 'notice' => '请填写职位备注', 'not_null' => false],
        ],
    ];
    private $key = 'job';
    public function index()
    {
        $data['title'] = '职位管理';
        $data['key'] = $this->admin->getFunc($this->key);
        $this->load->view('admin/public/list');
        return $this->load->view('admin/job/index', $data);
    }
    public function pageData()
    {
        $this->load->model('JobModel', 'job');
        $res = $this->job->pageData();
        return json($res);
    }
    public function add()
    {
        $data['action'] = 'add';
        $this->load->view('admin/public/edit');
        $this->load->view('admin/job/add', $data);
    }
    public function save()
    {
        $data['job_name'] = $this->input->post('job_name');
        $data['explain'] = $this->input->post('explain');
        $this->load->library('CheckFrom', $this->rule);
        $res = $this->checkfrom->checkFrom($data, 'job');
        if ($res['result'] != 'CHECK_PASS') {
            return json($res);
        }
        $this->load->model('JobModel', 'job');
        $action = $this->input->post('action');
        $data['update_at'] = time();
        switch ($action) {
            case 'add':
                $data['insert_at'] = $data['update_at'];
                $id = $this->job->insert($data);
                break;
            case 'edit':
                $id = $this->input->post('id');
                $this->job->update($id, $data);
                break;
            default:
                # code...
                break;
        }
        return json(['result' => 'SUCCESS', 'msg' => '操作成功', 'id' => $id]);
    }
    public function edit($id, $act)
    {
        $this->load->model('JobModel', 'job');
        $data['action'] = $act;
        $data['data'] = $this->job->single($id);
        $this->load->view('admin/public/edit');
        $this->load->view('admin/job/add', $data);
    }
    public function deleteData($id)
    {
        if (!is_numeric($id)) {
            return err('参数错误');
        }
        $this->load->model('jobModel', 'job');
        $this->job->deleteData($id);
        return json(['result' => 'SUCCESS', 'msg' => '删除成功']);
    }
    public function set($id)
    {
        $this->load->model('JobModel', 'job');
        $data['func'] = $this->job->funcAuth();
        $data['has'] = $this->job->hasAuth($id);
        $data['admin_job_id'] = $id;
        $this->load->view('admin/public/edit');
        $this->load->view('admin/job/set', $data);
    }
    public function setAuth()
    {
        $data['admin_job_id'] = $this->input->post_get('admin_job_id');
        $data['auth_key'] = $this->input->post_get('auth_key');
        $data['func_key'] = $this->input->post_get('func_key');
        $this->load->model('JobModel', 'job');
        $ret = $this->job->auth($data);
        if ($ret) {
            return json(['result' => 'SUCCESS', 'msg' => '删除成功']);
        } else {
            return json(['result' => 'SUCCESS', 'msg' => '添加成功']);
        }
    }
}

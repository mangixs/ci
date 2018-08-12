<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Func extends MY_Controller
{
    private $key = 'func';
    public function index()
    {
        $data['title'] = '功能管理';
        $data['key'] = $this->admin->getFunc($this->key);
        $this->load->view('admin/public/list');
        $this->load->view('admin/func/index', $data);
    }
    public function pageData()
    {
        $this->load->model('FuncModel', 'func');
        $data = $this->func->pageData();
        return json($data);
    }
    public function add()
    {
        $data['action'] = 'add';
        $this->load->view('admin/public/edit');
        $this->load->view('admin/func/add', $data);
    }
    public function save()
    {
        $data['key'] = $this->input->post('key');
        $data['func_name'] = $this->input->post('func_name');
        if (!preg_match("/[a-zA-Z|_]/", $data['key']) || empty($data['func_name'])) {
            return err("参数错误");
        }
        $action = $this->input->post('action');
        $this->load->model('FuncModel', 'func');
        switch ($action) {
            case 'add':
                $res = $this->func->insert($data);
                if (!$res) {
                    return err('键值已存在');
                }
                break;
            case 'edit':
                $this->func->update($data);
                break;
        }
        return json(['result' => 'SUCCESS', 'msg' => '操作成功', 'id' => $data['key']]);
    }
    public function edit($key, $act)
    {
        $this->load->model('FuncModel', 'func');
        $data['action'] = $act;
        $data['data'] = $this->func->single($key);
        $this->load->view('admin/public/edit');
        $this->load->view('admin/func/add', $data);
    }
    public function deleteData($key)
    {
        $this->load->model('FuncModel', 'func');
        $this->func->deleteData($key);
        return json(['result' => 'SUCCESS', 'msg' => '删除成功']);
    }
    public function setFunc($key)
    {
        $this->load->model('FuncModel', 'func');
        $data['data'] = $this->func->single($key);
        $data['set'] = $this->func->getFuncSet($key);
        $this->load->view('admin/public/edit');
        $this->load->view('admin/func/set', $data);
    }
    public function setSave()
    {
        $keys = $this->input->post('key');
        $auth = $this->input->post('extendkey');
        $name = $this->input->post('extendname');
        $this->load->model('FuncModel', 'func');
        $this->func->deleteAuth($keys);
        if (empty($auth)) {
            return json(['result' => 'SUCCESS', 'msg' => '保存成功']);
        }
        foreach ($auth as $i => $key) {
            $data[] = ['key' => $key, 'func_key' => $keys, 'auth_name' => $name[$i]];
        }
        if (!empty($data)) {
            $this->func->insertAuth($data);
        }
        return json(['result' => 'SUCCESS', 'msg' => '保存成功']);
    }
}

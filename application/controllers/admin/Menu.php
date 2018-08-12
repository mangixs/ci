<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Menu extends MY_Controller
{
    private $rule=[
		'menu'=>[
			'named'=>['name'=>'named','preg'=>':notnull','notice'=>'请输入名称'],
            'url'=>['name'=>'url','preg'=>'/[a-z|A-Z|\/]+/','notice'=>'请输入功能名称','not_null'=>false],
            'screen_auth'=>['name'=>'screen_auth','preg'=>':notnull','notice'=>'请设置权限'],
            'sort'=>['name'=>'sort','preg'=>':number','notice'=>'请输入排序','not_null'=>false],
            'parent'=>['name'=>'parent','preg'=>':number','notice'=>'请输入选择菜单父级'],				
            'icon'=>['name'=>'icon','preg'=>':notnull','notice'=>'请上传图标','not_null'=>false],
		],
    ];
    private $key = 'menu';
    public function index()
    {
        $data['title'] = '菜单管理';
        $data['key'] = $this->admin->getFunc($this->key);
        $this->load->view('admin/menu/index', $data);
    }
    public function pageData()
    {
        $this->load->model('MenuModel', 'menu');
        $res = $this->menu->pageData();
        return json($res);
    }
    public function childMenu()
    {
        $pid = $this->input->post('pid');
        $this->load->model('MenuModel', 'menu');
        $ret = $this->menu->childData($pid);
        if (empty($ret)) {
            return json(['result' => 'EMPTY', 'msg' => '无子菜单数据', 'pid' => $pid]);
        }
        return json(['result' => 'SUCCESS', 'msg' => '获取成功', 'data' => $ret, 'pid' => $pid]);
    }
    public function add()
    {
        $pid = $this->input->get('pid');
        $this->load->model('MenuModel', 'menu');
        $this->load->model('JobModel', 'job');
        $data['all'] = $this->menu->allMenu();
        $data['pid'] = $pid;
        $data['action'] = 'add';
        $data['func'] = $this->job->funcAuth();
        $this->load->view('admin/public/edit');
        $this->load->view('admin/menu/add', $data);
    }
    public function edit($id, $act)
    {
        $this->load->model('MenuModel', 'menu');
        $this->load->model('JobModel', 'job');
        $data['all'] = $this->menu->allMenu();
        $data['action'] = $act;
        $data['func'] = $this->job->funcAuth();
        $data['pid'] = $id;
        $data['data'] = $this->menu->single($id);
        $this->load->view('admin/public/edit');
        $this->load->view('admin/menu/add', $data);
    }
    public function save()
    {
        $data['named'] = $this->input->post('named');
        $data['url'] = $this->input->post('url');
        $data['screen_auth'] = $this->input->post('screen_auth');
        $data['sort'] = $this->input->post('sort');
        $data['parent'] = $this->input->post('parent');
        $data['icon'] = $this->input->post('icon');
        $this->load->library('CheckFrom', $this->rule);
        $checkResult = $this->checkfrom->checkFrom($data, 'menu');
        if ($checkResult['result'] !== 'CHECK_PASS') {
            return json($checkResult);
        }
        $action = $this->input->post('action');
        $this->load->model('MenuModel','menu');
        switch ($action) {
            case 'add':
                $id = $this->menu->addMenu($data);
                break;
            case 'edit':
                $id = $this->input->post('id');
                $this->menu->editMenu($id, $data);
                break;
            default:
                # code...
                break;
        }
        return json(['result' => 'SUCCESS', 'msg' => '操作成功', 'id' => $id]);
    }
    
    public function deleteMenu($id)
    {
        if (empty($id) and !is_numeric($id)) {
            return json(['result' => 'ERROR', 'msg' => '参数错误']);
        }
        $this->load->model('MenuModel', 'menu');
        $res = $this->menu->deleteMenu($id);
        return json($res);
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Home extends MY_Controller
{
    public function index()
    {
        $data['true_name'] = $this->admin->true_name;
        $data['header_img'] = $this->admin->header_img;
        $data['menu'] = $this->createMenu($this->admin->key);
        return $this->load->view('admin/home/index', $data);
    }
    public function welcome()
    {
        return $this->load->view('admin/home/welcome');
    }
    public function pwd()
    {
        $this->load->view('admin/public/edit');
        $this->load->view('admin/home/pwd');
    }
    public function changePwd()
    {
        $old = $this->input->post('old');
        $newpwd = $this->input->post('pwd');
        $pwd = $this->input->post('newpwd');
        if ($newpwd !== $pwd) {
            return json(['result' => 'ERROR', 'msg' => '请输入一致的密码']);
        }
        if (!preg_match("/^[\w]{5,16}$/", $pwd)) {
            return json(['result' => 'ERROR', 'msg' => '请输入正确的密码格式']);
        }
        $this->load->model('StaffModel', 'staff');
        $res = $this->staff->checkAdminPwd($this->admin->id, $old);
        if ($res) {
            return json(['result' => 'ERROR', 'msg' => '旧密码不正确']);
        }
        $this->staff->checkPwd($this->admin->id, $pwd);
        return json(['result' => 'SUCCESS', 'msg' => '修改成功']);
    }
    public function loginout()
    {
        $this->admin->logout();
        redirect(base_url('admin/login'));
    }
    private function createMenu($func_data)
    {
        $menu_data = $this->menuData();
        foreach ($func_data as $k => $v) {
            if (empty($res_func[$v['func_key']])) {
                $res_func[$v['func_key']] = [
                    'func_key' => $v['func_key'],
                    'auth_key' => [],
                ];
            }
            if (!in_array($v['auth_key'], $res_func[$v['func_key']]['auth_key'])) {
                $res_func[$v['func_key']]['auth_key'][] = $v['auth_key'];
            }
        }
        $key_name = array_keys($res_func);
        foreach ($menu_data as $w => $d) {
            if (in_array($w, $key_name)) {
                $res[] = [
                    'menu_id' => $d['menu_id'],
                    'key_val' => $d['key_val'],
                    'func_val' => $w,
                ];
            }
        }
        $ret = [];
        foreach ($res as $e => $t) {
            foreach ($t['menu_id'] as $c => $r) {
                if (!in_array($r, $ret)) {
                    $ret[] = $r;
                }
            }
        }
        ksort($ret);
        $this->load->model('MenuModel', 'menu');
        $rets = $this->menu->getStaffMenu($ret);
        $parentList = [];
        foreach ($rets as $menu) {
            $parentList[$menu['parent']][] = $menu;
        }
        $tree = $this->createTree($parentList, 0);
        $menuList = $this->createList($tree);
        return $menuList;
    }
    private function createList($tree)
    {
        ob_start();
        echo '<ul class="menu-ul">';
        foreach ($tree as $k => $v) {
            echo '<li class="parent-li">';
            echo '<a href="javascript:;" class="parent-a">';
            if (!empty($v['icon'])) {
                echo '<img src="' . $v['icon'] . '" class="parent-img">';
                echo $v['named'];
            } else {
                echo '<span class="parent-span">' . $v['named'] . '</span>';
            }
            echo '<span class="arrow"></span>';
            echo '</a>';
            if (!empty($v['children'])) {
                echo '<ul class="child-ul">';
                foreach ($v['children'] as $c => $d) {
                    echo '<li class="child-li">';
                    echo '<a href="' . base_url($d['url']) . '" target="list" class="child-a" >';
                    if (!empty($d['icon'])) {
                        echo '<img src="' . $d['icon'] . '" class="child-img">';
                        echo '<span class="child-span" >' . $d['named'] . '</span>';
                    } else {
                        echo '<span class="child-span span-text">' . $d['named'] . '</span>';
                    }
                    echo '</a>';
                    echo '</li>';
                }
                echo '</ul>';
            }
            echo '</li>';
        }
        echo '</ul>';
        $ret = ob_get_contents();
        ob_clean();
        return $ret;
    }
    private function createTree(&$parentList, $pos)
    {
        $ret = [];
        foreach ($parentList[$pos] as $k => $v) {
            $ret[$v['id']] = $v;
            if (isset($parentList[$v['id']])) {
                $ret[$v['id']]['children'] = $this->createTree($parentList, $v['id']);
            }
        }
        return $ret;
    }
    private function menuData()
    {
        $this->load->model('MenuModel', 'menu');
        $data = $this->menu->allMenu();
        foreach ($data as $k => $v) {
            $tmp = json_decode($v['screen_auth'], true);
            foreach ($tmp as $e => $c) {
                if (empty($res[$e])) {
                    $res[$e] = [
                        'menu_id' => [],
                        'key_val' => [],
                    ];
                }
                if (!in_array($v['id'], $res[$e]['menu_id'])) {
                    $res[$e]['menu_id'][] = $v['id'];
                }
                if (!in_array($c[0], $res[$e]['key_val'])) {
                    $res[$e]['key_val'][] = $c[0];
                }
            }
        }
        return $res;
    }
}

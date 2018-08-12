<?php
class MenuModel extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function pageData()
    {
        $this->db->from('menu');
        $this->db->where('parent', 0);
        $this->setSearch($this->db);
        $ret['page'] = $this->setPage($this->db);
        $ret['data'] = $this->db->select('id,named,url,level,parent,sort')->order_by('id', 'DESC')->get()->result_array();
        return $ret;
    }
    public function childData($pid)
    {
        $tmp = $this->db->where('parent', $pid)->select('id,named,url,level,parent,sort')->get('menu')->result_array();
        return $tmp;
    }
    public function allMenu()
    {
        $res = $this->db->select('id,named,level,parent,screen_auth')->get('menu')->result_array();
        $data = [];
        foreach ($res as $k => $v) {
            $data[$v['parent']][$v['id']] = $v;
        }
        $tree = [];
        $this->treeMenu($data, 0, $tree);
        return $tree;
    }
    private function treeMenu(&$data, $pid, &$tree)
    {
        if (isset($data[$pid])) {
            foreach ($data[$pid] as $k => $v) {
                $tree[$k] = $v;
                $this->treeMenu($data, $k, $tree);
            }
        }
    }
    public function single($id)
    {
        $res = $this->db->where('id', $id)->get('menu')->row_array();
        return $res;
    }
    public function addMenu($data)
    {
        if ($data['parent'] == 0) {
            $data['level'] = 0;
            $this->db->insert('menu', $data);
        } else {
            $parent = $this->single($data['parent']);
            $data['level'] = (int) $parent['level'] + 1;
            $this->db->insert('menu', $data);
        }
        return $this->db->insert_id();
    }
    public function editMenu($id, $data)
    {
        if ($data['parent'] == 0) {
            $data['level'] = 0;
            $this->db->where(['id' => $id])->update('menu', $data);
        } else {
            $parent = $this->single($data['parent']);
            $data['level'] = (int) $parent['level'] + 1;
            $this->db->where(['id' => $id])->update('menu', $data);
        }
    }
    public function deleteMenu($id)
    {
        $hasChild = $this->db->where(['parent' => $id])->select('id,named')->get('menu')->row_array();
        if (!empty($hasChild)) {
            return ['result' => 'ERROR', 'msg' => '存在子菜单,不可删除'];
        }
        $this->db->where(['id' => $id])->delete('menu');
        return ['result' => 'SUCCESS', 'msg' => '删除成功'];
    }
    public function getStaffMenu($res)
    {
        $data = $this->db->select('id,url,named,icon,level,parent')->where_in('id',$res)->order_by('sort', 'DESC')->get('menu')->result_array();
        return $data;
    }
}

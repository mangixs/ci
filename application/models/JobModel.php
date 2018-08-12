<?php
class JobModel extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function pageData()
    {
        $this->db->from('admin_job');
        $this->db->where('valid', 1);
        $this->setSearch($this->db);
        $res['page'] = $this->setPage($this->db);
        $res['data'] = $this->db->select('id,job_name,update_at')->order_by('id', 'DESC')->get()->result_array();
        foreach ($res['data'] as $k => &$v) {
            $v['update_at'] = date('Y-m-d H:i:s', $v['update_at']);
        }
        return $res;
    }
    public function insert($data)
    {
        $this->db->insert('admin_job', $data);
        return $this->db->insert_id();
    }
    public function update($id, $data)
    {
        $this->db->where(['id' => $id])->update('admin_job', $data);
    }
    public function single($id)
    {
        $res = $this->db->where('id', $id)->get('admin_job')->row_array();
        return $res;
    }
    public function deleteData($id)
    {
        $this->db->where('id', $id)->update('admin_job', ['valid' => 0]);
    }
    public function funcAuth()
    {
        $func = $this->allKey();
        $auth = $this->authAll();
        $tmp = [];
        foreach ($auth as $v) {
            $tmp[$v['func_key']][] = $v;
        }
        $ret = [];
        foreach ($func as $k => $v) {
            $ret[$v['key']] = $v;
            if (array_key_exists($v['key'], $tmp)) {
                $ret[$v['key']]['auth'] = $tmp[$v['key']];
            } else {
                $ret[$v['key']]['auth'] = [];
            }
        }
        return $ret;
    }
    public function allKey()
    {
        $res = $this->db->get('background_func')->result_array();
        return $res;
    }
    public function authAll()
    {
        $res = $this->db->get('func_auth')->result_array();
        return $res;
    }
    public function hasAuth($id)
    {
        $res = $this->db->where(['admin_job_id' => $id])->get('admin_job_auth')->result_array();
        $ret = [];
        foreach ($res as $v) {
            $ret[$v['func_key']][] = $v['auth_key'];
        }
        return $ret;
    }
    public function auth($data)
    {
        $count = $this->db->where($data)->count_all_results('admin_job_auth');
        if ($count > 0) {
            $this->db->where($data)->delete('admin_job_auth');
            return true;
        } else {
            $this->db->insert('admin_job_auth', $data);
            return false;
        }
    }
}

<?php
class staffModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function checkLogin($username, $pwd)
    {
        $ret = $this->db->where(['login_name' => $username, 'pwd' => md5($pwd), 'valid' => 1])
            ->get('staff')
            ->row_array();
        return $ret;
    }
    public function getCount()
    {
        $count = $this->db->where(['valid' => 1])->count_all_results('staff');
        return $count;
    }
    public function getData($page, $offset)
    {
        $ret = $this->db->where(['valid' => 1])->select('id,login_name,true_name,header_img,staff_num,insert_at')
            ->limit($page, $offset)
            ->order_by('id', 'DESC')
            ->get('staff')
            ->result_array();
        foreach ($ret as $k => &$v) {
            $v['insert_at'] = date('Y-m-d H:i:s', $v['insert_at']);
        }
        return $ret;
    }
    public function insert($data)
    {
        $this->db->insert('staff', $data);
        return $this->db->insert_id();
    }
    public function update($id, $data)
    {
        $this->db->where(['id' => $id])->update('staff', $data);
    }
    public function single($id)
    {
        $res = $this->db->where(['id' => $id])->get('staff')->row_array();
        return $res;
    }
    public function deleteData($id)
    {
        $this->db->where(['id' => $id])->delete('staff');
    }
    public function allJob()
    {
        $res = $this->db->where('valid', 1)->get('admin_job')->result_array();
        return $res;
    }
    public function hasJob($id)
    {
        $ret = $this->db->select('job_id')->where(['staff_id' => $id])->get('staff_job')->result_array();
        $res = [];
        foreach ($ret as $v) {
            $res[] = $v['job_id'];
        }
        return $res;
    }
    public function jobSave($staff_id, $job_id, $set)
    {
        $this->db->where(['staff_id' => $staff_id])->where(['job_id' => $job_id])->delete('staff_job');
        if ($set) {
            $this->db->insert('staff_job', ['staff_id' => $staff_id, 'job_id' => $job_id]);
        }
        $res = $this->hasJob($staff_id);
        $this->db->where(['id' => $staff_id])->update('staff', ['job' => json_encode($res)]);
    }
    public function staffJob($id)
    {
        $res = $this->db->where('staff_id', $id)->get('staff_job')->result_array();
        return $res;
    }
    public function getKey($jobId)
    {
        $data = $this->db->distinct(true)->where_in('admin_job_id', $jobId)->select('func_key,auth_key')->get('admin_job_auth')->result_array();
        foreach ($data as $k => $v) {
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
        return $res_func;
    }
    public function checkAdminPwd($id, $pwd)
    {
        $res = $this->db->select('id')->where(['id' => $id, 'pwd' => md5($pwd)])->where(['valid' => 1])->get('staff')->row_array();
        if (empty($res)) {
            return true;
        } else {
            return false;
        }
    }
    public function checkPwd($id, $pwd)
    {
        $data['pwd'] = md5($pwd);
        $this->db->where(['id' => $id])->update('staff',$data);
    }
}

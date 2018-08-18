<?php
class FuncModel extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function pageData()
    {
        $this->db->from('background_func');
        $this->setSearch($this->db);
        $ret['page'] = $this->setPage($this->db);
        $ret['data'] = $this->db->get()->result_array();
        return $ret;
    }
    public function insert($data)
    {
        $res = $this->db->where(['key' => $data['key']])->get('background_func')->row_array();
        if ($res) {
            return false;
        }
        $this->db->insert('background_func', $data);
        return true;
    }
    public function update($data)
    {
        $this->db->where(['key' => $data['key']])->update('background_func', $data);
    }
    public function deleteData($key)
    {
        $this->db->where(['key' => $key])->delete('background_func');
        $this->deleteAuth($key);
    }
    public function single($key)
    {
        $res = $this->db->where(['key' => $key])->get('background_func')->row_array();
        return $res;
    }
    public function getFuncSet($key)
    {
        $res = $this->db->where(['func_key' => $key])->get('func_auth')->result();
        return $res;
    }
    public function deleteAuth($key)
    {
        $this->db->where(['func_key' => $key])->delete('func_auth');
    }
    public function insertAuth($data)
    {
        $this->db->insert_batch('func_auth', $data);
    }
    public function getExcelData(){
        $this->door = $this->load->database('door',true);
        $res = $this->door->from('device_event_log')->limit(20)->get()->result_array();
        return $res;
    }
}

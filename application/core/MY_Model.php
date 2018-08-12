<?php
class MY_Model extends CI_Model
{
    protected $__page_string = 'page';
    protected $__page_every_string = 'every';
    public function __construct()
    {
        parent::__construct();
    }
    public function setSearch(&$db)
    {
        $str = $this->input->get_post('search');
        if (empty($str)) {
            return;
        }
        $json = json_decode($str, true);
        if (!is_array($json)) {
            return;
        }
        foreach ($json as $k => $v) {
            $set = explode(':', $k);
            if (empty($v) or $v == -1) {
                continue;
            }
            $arr = explode(',', $set[1]);
            switch ($set[0]) {
                case 'like':
                    if (count($arr) == 1) {
                        $db->like($arr[0], $v);
                    } else {
                        $db->group_start();
                        foreach ($arr as $row) {
                            $db->or_like($row, $v);
                        }
                        $db->group_end();
                    }
                    break;
                case 'equal':
                case '=':
                    if (count($arr) == 1) {
                        $db->where($arr[0], $v);
                    } else {
                        $db->group_start();
                        foreach ($arr as $row) {
                            $db->or_where($row, $v);
                        }
                        $db->group_end();
                    }
                    break;
                default:
                    if (in_array($set[0], ['>', '>=', '<', '<='])) {
                        if (count($arr) == 1) {
                            $db->where($arr[0] . ' ' . $set[0], $v);
                        } else {
                            $db->group_start();
                            foreach ($arr as $row) {
                                $db->or_where($row . ' ' . $set[0], $v);
                            }
                            $db->group_end();
                        }
                    }
                    break;
            }
        }
    }
    public function setPage(&$db, $set_limit = true, $from = null, $def_eve = 10)
    {
        $page = $this->input->get_post('page') ? $this->input->get_post($this->__page_string) : 1;
        $every = $this->input->get_post('every') ? $this->input->get_post($this->__page_every_string) : $def_eve;
        if (is_string($from)) {
            $db->from($form);
        }
        $ret['every'] = $every;
        $ret['count_all'] = $db->count_all_results('', false);
        $ret['page_count'] = ceil($ret['count_all'] / $every);
        if ($page > $ret['page_count'] + 1) {
            $page = $ret['page_count'] + 1;
        }
        $ret['page'] = $page;
        $set_limit && $db->limit($every, ($page - 1) * $every);
        return $ret;

    }
}

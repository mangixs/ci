<?php
class Admin
{
    const SESSION_SAVE_KEY = 'admin_object';
    public function __construct($is_login = false)
    {
        $this->is_login = $is_login;
    }
    public function __set($key, $val)
    {
        $this->$key = $val;
    }
    public function __get($val)
    {
        if (isset($this->$val)) {
            return $this->$val;
        }
        return null;
    }
    public function setInfo($info)
    {
        foreach ($info as $k => $v) {
            $this->$k = $v;
        }
    }
    public function isLogin()
    {
        return $this->is_login;
    }
    public function setAuth($auth)
    {
        $this->auth = $auth;
        $this->setFunc(array_keys($this->auth));
    }
    public function setFunc($func)
    {
        $this->func = $func;
    }
    public function getFunc($key)
    {
        return $this->auth[$key];
    }
    public function save()
    {
        $ci = &get_instance();
        $ci->load->library('session');
        $ci->session->set_userdata(self::SESSION_SAVE_KEY, serialize($this));
    }
    public function logout()
    {
        $ci = &get_instance();
        $ci->load->library('session');
        $ci->session->unset_userdata(self::SESSION_SAVE_KEY);
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{

    public function index()
    {
        $this->load->view('test/index');
    }
    public function save()
    {
        $url = $this->input->post('url');
        if (empty($url)) {
            return json(['result' => 'ERROR', 'msg' => 'URL不能为空']);
        }
        $type = $this->input->post('type');
        $data = $this->input->post('data');
        $tmp = json_decode($data, true);
        switch ($type) {
            case 'get':
                if (!empty($tmp)) {
                    $url = $url . '?';
                    foreach ($tmp as $k => $v) {
                        $url = $url . $v['key'] . '=' . $v['value'] . '&';
                    }
                    $url = rtrim($url, '&');
                }
                $res = $this->httpGet($url);
                $tmp = json_decode($res, true);
                if (!is_array($tmp)) {
                    p($res);
                } else {
                    p($tmp);
                }
                break;
            case 'post':
                $ret = [];
                if (!empty($tmp)) {
                    foreach ($tmp as $key => $v) {
                        $ret[$v['key']] = $v['value'];
                    }
                }
                $res = $this->httpPost($url, $ret);
                $tmp = json_decode($res, true);
                if (!is_array($tmp)) {
                    p($res);
                } else {
                    p($tmp);
                }
                break;
            default:

                break;
        }
    }
    private function httpGet($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_NOBODY, false);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }
    private function httpPost($url, $ret)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($ret));
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
    public function cli($a)
    {
        echo $a;
    }
    public function linux()
    {
        $this->load->library('WriteFile');
        $res = date('Y-m-d H:i:s', time());
        $this->writefile->phpData('time', 'time', $res);
    }
}

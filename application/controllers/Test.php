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
    public function exports()
    {
        ini_set('memory_limit','512M');
        set_time_limit(0);
        $this->load->model('funcModel','func');
        $data = $this->func->getExcelData();
        $title = '门禁机开门日志';
        $xlsCell  = array(
            array('event_type','开门类型',30),
            array('event_time','开门时间',30),
            array('cardno','卡号',30),
            array('dev_name','设备名称',30),
            array('dev_sn','设备sn',30),
            array('app_account','app账号',30),
            array('img_path','图片路径',100),
        );
        $res=$this->saveExcel($title,$xlsCell,$data,false,'./');
    }
    public function saveExcel($title,$expCellName,$expTableData,$isDownLoad=true,$path=''){
        $this->load->library('PHPExcel/PHPExcel');
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        $objPHPExcel = new \PHPExcel();
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
        for($i=0;$i<$cellNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'1', $expCellName[$i][1]);
            $objPHPExcel->getActiveSheet()->getColumnDimension($cellName[$i])->setWidth($expCellName[$i][2]);
            $objPHPExcel->getActiveSheet()->getStyle($cellName[$i].'1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        for($i=0;$i<$dataNum;$i++){
            for($j=0;$j<$cellNum;$j++){
                $cell =$cellName[$j].($i+2);
                $val =$expTableData[$i][$expCellName[$j][0]];
                $objPHPExcel->getActiveSheet(0)->setCellValue($cell,$val);
                $objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
        }
        $writer = new \PHPExcel_Writer_Excel2007($objPHPExcel);
        if($isDownLoad){
            header('Pragma:public');
            header('Expires:0');
            header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
            header('Content-Type:application/force-download');
            header('Content-Type:application/vnd.ms-excel');
            header('Content-Type:application/octect-stream');
            header('Content-Type:application/download');
            header('Content-Disposition:attachment;filename="' . $title . '.xlsx"');
            header('Content-Transfer-Encoding:binary"');
            $writer->save('php://output');
        }else{
            $savePath = $path.$title.'.xlsx';
            $writer->save($savePath);
            return $savePath;
        }
    }
    public function uploadFile()
    {
        $config['upload_path']=INDEXPATH.'/resources/upload';
        $config['allowed_types']='xls|xlsx';
        $config['encrypt_name']=true;
        $this->load->library('upload',$config);		
        $res=$this->upload->do_upload('file');
        if($res){
            $result=$this->upload->data();
            $data=$this->readExcel($result['full_path']);
        }else{
            echo '上传文件错误'.$this->upload->display_errors();
        }
    }
    public function readExcel($path){
        $this->load->library('PHPExcel/PHPExcel');
        $this->load->library('PHPExcel/PHPExcel/PHPExcel_IOFactory');
        $fileType = \PHPExcel_IOFactory::identify($path);
        $objReader = \PHPExcel_IOFactory::createReader($fileType);
        $objPHPExcel = $objReader->load($path);
        $sheetCount = $objPHPExcel->getSheetCount();
        $data = $objPHPExcel->getSheet()->toArray();
        return $data;
        // $sheet = $objPHPExcel->getSheet(0);
        // $highestRow = $sheet->getHighestRow();
        // $highestColumn = $sheet->getHighestColumn();
    }
}

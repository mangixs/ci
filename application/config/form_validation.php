<?php
$config = array(
    'staff' => array(
        array(
            'field' => 'login_name',
            'label' => '登陆名',
            'rules' => 'required|regex_match[/^[\w]{5,16}/]',
        ),
        array(
            'field' => 'true_name',
            'label' => '用户名',
            'rules' => 'required|max_length[12]',
        ),
        array(
            'field' => 'staff_num',
            'label' => '用户编号',
            'rules' => 'required|max_length[6]|numeric',
        ),
        array(
            'field' => 'header_img',
            'label' => '用户头像',
            'rules' => 'required|regex_match[/^.+\.(jpg|png|jpeg|gif){1}$/i]',
        ),
    ),
);
